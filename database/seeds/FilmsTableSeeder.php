<?php

use Illuminate\Database\Seeder;
use App\User;
class FilmsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (User::all() as $user) {
            $user->films()->saveMany(factory(App\Film::class, mt_rand(2,3))->make());
        }
    }
}
