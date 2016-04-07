<?php

use Illuminate\Database\Seeder;
use App\FilmCategory;
use App\Ticket;
use App\User;
use App\Film;
class FilmCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $categories = config('film.categoryNames');

        $rows = ['A', 'B', 'C', 'D', 'E'];

        $faker = Faker\Factory::create();

        $numFullMovies = 2;
        $fullMovieCategories = $faker->randomElements($categories, $numFullMovies);
        $films = Film::all();
        // create the category and then attach to some movies and then fifty tickets for it
        for($i = 0; $i < count($categories); $i++){

            $category = FilmCategory::create([
                'name' => $categories[$i],
            ]);

            if(in_array($categories[$i], $fullMovieCategories)){
                $applyMovies = $films->random(75);
            }
            else{
                $applyMovies = $films->random(mt_rand(15, 30));
            }

            $applyMovies->each(function ($m) use ($category) {
                $m->categories()->attach($category->id);
            });

            $tickets = [];
            for($j = 0; $j < count($rows); $j++){
                for($k = 1; $k <= 10; $k++){
                    $t = new Ticket([
                        'row' => $rows[$j],
                        'seat' => $k,
                    ]);
                    $tickets[] = $t;
                }
            }

            $category->tickets()->saveMany($tickets);
            $this->command->info('Tickets saved for '.$category->name);
        }

        // go through users and fill up three random categories of tickets
        $numFullCategories = 3;
        $otherTicketCategories = FilmCategory::all()->shuffle();
        $fullTicketCategories = $otherTicketCategories->splice($numFullCategories);
        $hotTicketsSoldOut = false;
        foreach (User::all() as $user) {
            $purchaseAmt = mt_rand(1, 4);
            // populate available categories up to three if
            // full ticket categories are available then no others can join
            // if not grab from other ticket categories

            if($hotTicketsSoldOut){
                $buyTickets = Ticket::whereNull('user_id')->where(function ($query) use ($otherTicketCategories) {
                    $otherTicketCategories->each(function ($cat) use ($query) {
                        $query->orWhere('category_id', $cat->id);
                    });
                })
                    ->get();
            }
            else {
                $buyTickets = Ticket::whereNull('user_id')->where(function ($query) use ($fullTicketCategories) {
                    $fullTicketCategories->each(function ($cat) use ($query) {
                        $query->orWhere('category_id', $cat->id);
                    });
                })
                    ->get();
                if($buyTickets->count() === 0){
                    $hotTicketsSoldOut = true;
                    $buyTickets = Ticket::whereNull('user_id')->where(function ($query) use ($otherTicketCategories) {
                        $otherTicketCategories->each(function ($cat) use ($query) {
                            $query->orWhere('category_id', $cat->id);
                        });
                    })
                        ->get();
                }
            }
            if($purchaseAmt >= $buyTickets->count()){
                $purchaseTickets = $buyTickets;
                if($buyTickets->count() === 1) $purchaseAmt = 1;
            }
            else{
                $purchaseTickets = $buyTickets->random($purchaseAmt);
            }

            if($purchaseAmt > 1){
                $purchaseTickets->each(function ($pt, $key) use ($faker, $user) {
                    $pt->purchased_at = $faker->dateTimeBetween('-3 months', 'now');
                    $pt->name = $key === 0 ? $user->name : $faker->name;
                    $pt->receipt = str_random(32);
                });

                $user->tickets()->saveMany($purchaseTickets);
            }
            else{
                $purchaseTickets->purchased_at = $faker->dateTimeBetween('-3 months', 'now');
                $purchaseTickets->name = $user->name;
                $purchaseTickets->receipt = str_random(32);

                $user->tickets()->save($purchaseTickets);
            }

        }
    }
}
