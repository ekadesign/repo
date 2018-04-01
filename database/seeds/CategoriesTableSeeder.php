<?php

use Illuminate\Database\Seeder;
use \App\Models\Forum\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::firstOrCreate(['name' => 'General']);
        Category::firstOrCreate(['name' => 'Cryptos']);
    }
}
