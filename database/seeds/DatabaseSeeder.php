<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class)
        factory(App\Group::class, 1)->create();
        // factory(App\User::class, 20)->create();
        // factory(App\Activity::class, 50)->create();
    }
}
