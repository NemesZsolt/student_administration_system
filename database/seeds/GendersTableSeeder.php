<?php

use App\Gender as GenderAlias;
use Illuminate\Database\Seeder;

class GendersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        GenderAlias::insert([
            'name' => 'female'
        ]);

        GenderAlias::insert([
            'name' => 'male'
        ]);
    }
}
