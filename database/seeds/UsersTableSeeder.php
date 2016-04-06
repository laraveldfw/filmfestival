<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // create one known user for demonstration purposes
        factory(App\User::class)->create([
            'email' => 'nate@nate.com',
        ]);

        factory(App\User::class, 99)->create();
    }
}
