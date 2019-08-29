<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        $this->call(GendersTableSeeder::class);

        factory(App\Student::class,50)->create();
        factory(App\StudyGroup::class,5)->create();
    }
}
