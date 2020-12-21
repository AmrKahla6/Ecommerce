<?php

use Illuminate\Database\Seeder;
use App\Subcategory;

class SubcategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subcategory                        = new Subcategory;
        $subcategory->{'name:en'}           = 'hp';
        $subcategory->{'name:ar'}           = 'اتش بي';
        $subcategory->{'description:en'}    = 'Computers';
        $subcategory->{'description:ar'}    = 'Computers';
        $subcategory->order                    = 1;
        $subcategory->category_id              = \App\Category::whereTranslationLike('name' , 'Computers')->first()->id;
        $subcategory->save();

        $subcategory                        = new Subcategory;
        $subcategory->{'name:en'}           = 'Apple';
        $subcategory->{'name:ar'}           = ' ابل';
        $subcategory->{'description:en'}    = 'Computers';
        $subcategory->{'description:ar'}    = 'Computers';
        $subcategory->order                    = 1;
        $subcategory->category_id              = \App\Category::whereTranslationLike('name' , 'Computers')->first()->id;
        $subcategory->save();

        $subcategory                        = new Subcategory;
        $subcategory->{'name:en'}           = 'Dell';
        $subcategory->{'name:ar'}           = ' ديل';
        $subcategory->{'description:en'}    = 'Computers';
        $subcategory->{'description:ar'}    = 'Computers';
        $subcategory->order                    = 1;
        $subcategory->category_id              = \App\Category::whereTranslationLike('name' , 'Computers')->first()->id;
        $subcategory->save();

        $subcategory                        = new Subcategory;
        $subcategory->{'name:en'}           = 'Lenovo';
        $subcategory->{'name:ar'}           = ' لينوفو';
        $subcategory->{'description:en'}    = 'Computers';
        $subcategory->{'description:ar'}    = 'Computers';
        $subcategory->order                    = 1;
        $subcategory->category_id              = \App\Category::whereTranslationLike('name' , 'Computers')->first()->id;
        $subcategory->save();

        $subcategory                        = new Subcategory;
        $subcategory->{'name:en'}           = 'Acer';
        $subcategory->{'name:ar'}           = ' اسر';
        $subcategory->{'description:en'}    = 'Computers';
        $subcategory->{'description:ar'}    = 'Computers';
        $subcategory->order                    = 1;
        $subcategory->category_id              = \App\Category::whereTranslationLike('name' , 'Computers')->first()->id;
        $subcategory->save();

        $subcategory                        = new Subcategory;
        $subcategory->{'name:en'}           = 'Sony';
        $subcategory->{'name:ar'}           = ' سوني';
        $subcategory->{'description:en'}    = 'Computers';
        $subcategory->{'description:ar'}    = 'Computers';
        $subcategory->order                    = 1;
        $subcategory->category_id              = \App\Category::whereTranslationLike('name' , 'Computers')->first()->id;
        $subcategory->save();

        $subcategory                        = new Subcategory;
        $subcategory->{'name:en'}           = 'Toshiba';
        $subcategory->{'name:ar'}           = ' توشيبا';
        $subcategory->{'description:en'}    = 'Computers';
        $subcategory->{'description:ar'}    = 'Computers';
        $subcategory->order                    = 1;
        $subcategory->category_id              = \App\Category::whereTranslationLike('name' , 'Computers')->first()->id;
        $subcategory->save();

    }
}
