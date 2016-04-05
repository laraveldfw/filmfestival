<?php

use Illuminate\Database\Seeder;
use App\FilmCategory;
use App\Ticket;
use App\User;

class FilmCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $categories = [
            'Lots of silence and staring',
            'Drunk aunt can be heard in the background',
            'Pancakes',
            'Camera shake is edgy, not nauseating',
            'You were wrong about me Mom!',
            'Telepathic Animals (and how we should be more like them)',
            'Someone pulls a gun for no reason',
            'Only shot at night (bc of equipment rental policy)'
        ];

        $rows = ['A', 'B', 'C', 'D', 'E'];

        $faker = Faker\Factory::create();

        // create the category and then fifty tickets for it
        for($i = 0; $i < count($categories); $i++){

            $category = FilmCategory::create([
                'name' => $categories[$i],
            ]);

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
        $numFilled = 3;
        $randCategories = $faker->randomElements($categories, $numFilled);
        $randCategoryModels = FilmCategory::where(function ($q) use ($randCategories) {
            foreach ($randCategories as $randCategory) {
                $q->orWhere('name', $randCategory);
            }
        })->get();

        $otherCategories = array_values(array_diff($categories, $randCategories));
        $otherCategoryModels = FilmCategory::where(function ($q) use ($otherCategories) {
            foreach ($otherCategories as $cat) {
                $q->orWhere('name', $cat);
            }
        })->get();
        foreach (User::all() as $user) {
            $purchaseAmt = mt_rand(1, 3);
            $fillTickets = Ticket::whereNull('user_id')
                ->where(function ($query) use ($randCategoryModels) {
                $randCategoryModels->each(function ($r) use ($query) {
                    $query->orWhere('category_id', $r->id);
                });
            })->get();

            if($fillTickets->count() > 0){
                //grab the next category to get filled up
                if($purchaseAmt > $fillTickets->count()){
                    $purchaseAmt = $fillTickets->count();
                }
                $buyTickets = $fillTickets->take($purchaseAmt);
            }
            else{
                //purchase tickets at random for other categories
                $otherTickets = Ticket::whereNull('user_id')
                    ->where(function ($query) use ($otherCategoryModels) {
                    $otherCategoryModels->each(function ($oc) use ($query){
                        $query->orWhere('category_id', $oc->id);
                    });
                })
                    ->get()->shuffle();

                $buyTickets = $otherTickets->take($purchaseAmt);
            }

            $buyTickets->each(function ($bt, $key) use ($faker, $user) {
                $bt->purchased_at = $faker->dateTimeBetween('-3 months', 'now');
                $bt->name = $key === 0 ? $user->name : $faker->name;
                $bt->receipt = str_random(32);
            });
            $user->tickets()->saveMany($buyTickets);
        }
    }
}
