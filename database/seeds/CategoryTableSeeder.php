<?php

use Illuminate\Database\Seeder;
use App\Category;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category                        = new Category;
        $category->{'name:en'}           = 'Computers';
        $category->{'name:ar'}           = 'كمبيوترات';
        $category->save();

    }
}
