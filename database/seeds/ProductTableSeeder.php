<?php

use Illuminate\Database\Seeder;
use App\Product;
use App\Productsize;
use App\Productcolors;
use App\Productimages;


class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $product                          =new Product();
        $product ->{'name:en'}            ="The best laptops from HP";
        $product ->{'name:ar'}            ="افضل اجهزه اللاب توب من اتش بي";
        $product ->{'description:en'}     ="HP OMEN 15-6CM24AV-4 , Intel Core i7-9750H Processor 2.6GHz, NVIDIA GeForce GTX 1660 Ti 6GB GDDR5, 16GB DDR4-2666 RAM, 1TB HDD+256GB SSD, Microsoft";
        $product ->{'description:ar'}     ="HP OMEN 15-6CM24AV-4 , Intel Core i7-9750H Processor 2.6GHz, NVIDIA GeForce GTX 1660 Ti 6GB GDDR5, 16GB DDR4-2666 RAM, 1TB HDD+256GB SSD, Microsoft ";
        $product ->image                  ="hp.jpg";
        $product ->price                  =7800;
        $product ->number                 =15;
        $product ->sale                   =10;
        $product->category_id             = \App\Category::whereTranslationLike('name' , 'Computers')->first()->id;
        $product->subcategory_id          = \App\Subcategory::whereTranslationLike('name' , 'hp')->first()->id;
        $product ->user_id                =\App\User::where('email','abdelhamid@gmail.com')->firstOrFail()->id;
        $product ->save();

        $product                          =new Product();
        $product ->{'name:en'}            ="The best laptops from Lenovo";
        $product ->{'name:ar'}            ="  افضل اجهزه اللاب توب من لينوفو";
        $product ->{'description:en'}     ="Lenovo OMEN 15-6CM24AV-4 , Intel Core i7-9750H Processor 2.6GHz, NVIDIA GeForce GTX 1660 Ti 6GB GDDR5, 16GB DDR4-2666 RAM, 1TB HDD+256GB SSD, Microsoft";
        $product ->{'description:ar'}     ="Lenovo OMEN 15-6CM24AV-4 , Intel Core i7-9750H Processor 2.6GHz, NVIDIA GeForce GTX 1660 Ti 6GB GDDR5, 16GB DDR4-2666 RAM, 1TB HDD+256GB SSD, Microsoft ";
        $product ->image                  ="lenovo.jpg";
        $product ->price                  =6800;
        $product ->number                 =15;
        $product ->sale                   =10;
        $product->category_id             = \App\Category::whereTranslationLike('name' , 'Computers')->first()->id;
        $product->subcategory_id          = \App\Subcategory::whereTranslationLike('name' , 'Lenovo')->first()->id;
        $product ->user_id                =\App\User::where('email','abdelhamid@gmail.com')->firstOrFail()->id;
        $product ->save();

        $product                          =new Product();
        $product ->{'name:en'}            ="The best laptops from sony";
        $product ->{'name:ar'}            ="  افضل اجهزه اللاب توب من سوني";
        $product ->{'description:en'}     ="sony OMEN 15-6CM24AV-4 , Intel Core i7-9750H Processor 2.6GHz, NVIDIA GeForce GTX 1660 Ti 6GB GDDR5, 16GB DDR4-2666 RAM, 1TB HDD+256GB SSD, Microsoft";
        $product ->{'description:ar'}     ="sony OMEN 15-6CM24AV-4 , Intel Core i7-9750H Processor 2.6GHz, NVIDIA GeForce GTX 1660 Ti 6GB GDDR5, 16GB DDR4-2666 RAM, 1TB HDD+256GB SSD, Microsoft ";
        $product ->image                  ="sony.jpg";
        $product ->price                  =6800;
        $product ->number                 =15;
        $product ->sale                   =15;
        $product->category_id             = \App\Category::whereTranslationLike('name' , 'Computers')->first()->id;
        $product->subcategory_id          = \App\Subcategory::whereTranslationLike('name' , 'Sony')->first()->id;
        $product ->user_id                =\App\User::where('email','abdelhamid@gmail.com')->firstOrFail()->id;
        $product ->save();

        $product                          =new Product();
        $product ->{'name:en'}            ="The best laptops from Toshiba";
        $product ->{'name:ar'}            ="  افضل اجهزه اللاب توب من توشيبا";
        $product ->{'description:en'}     ="Toshiba OMEN 15-6CM24AV-4 , Intel Core i7-9750H Processor 2.6GHz, NVIDIA GeForce GTX 1660 Ti 6GB GDDR5, 16GB DDR4-2666 RAM, 1TB HDD+256GB SSD, Microsoft";
        $product ->{'description:ar'}     ="Toshiba OMEN 15-6CM24AV-4 , Intel Core i7-9750H Processor 2.6GHz, NVIDIA GeForce GTX 1660 Ti 6GB GDDR5, 16GB DDR4-2666 RAM, 1TB HDD+256GB SSD, Microsoft ";
        $product ->image                  ="toshiba.jpg";
        $product ->price                  =6800;
        $product ->number                 =15;
        $product->category_id             = \App\Category::whereTranslationLike('name' , 'Computers')->first()->id;
        $product->subcategory_id          = \App\Subcategory::whereTranslationLike('name' , 'Toshiba')->first()->id;
        $product ->user_id                =\App\User::where('email','abdelhamid@gmail.com')->firstOrFail()->id;
        $product ->save();

        $product                          =new Product();
        $product ->{'name:en'}            ="The best laptops from acer";
        $product ->{'name:ar'}            ="  افضل اجهزه اللاب توب من اسر";
        $product ->{'description:en'}     ="acer OMEN 15-6CM24AV-4 , Intel Core i7-9750H Processor 2.6GHz, NVIDIA GeForce GTX 1660 Ti 6GB GDDR5, 16GB DDR4-2666 RAM, 1TB HDD+256GB SSD, Microsoft";
        $product ->{'description:ar'}     ="acer OMEN 15-6CM24AV-4 , Intel Core i7-9750H Processor 2.6GHz, NVIDIA GeForce GTX 1660 Ti 6GB GDDR5, 16GB DDR4-2666 RAM, 1TB HDD+256GB SSD, Microsoft ";
        $product ->image                  ="acer.jpg";
        $product ->price                  =6800;
        $product ->number                 =15;
        $product->category_id             = \App\Category::whereTranslationLike('name' , 'Computers')->first()->id;
        $product->subcategory_id          = \App\Subcategory::whereTranslationLike('name' , 'Acer')->first()->id;
        $product ->user_id                =\App\User::where('email','abdelhamid@gmail.com')->firstOrFail()->id;
        $product ->save();

        $product                          =new Product();
        $product ->{'name:en'}            ="The best laptops from Apple";
        $product ->{'name:ar'}            ="  افضل اجهزه اللاب توب من ابل";
        $product ->{'description:en'}     ="Apple OMEN 15-6CM24AV-4 , Intel Core i7-9750H Processor 2.6GHz, NVIDIA GeForce GTX 1660 Ti 6GB GDDR5, 16GB DDR4-2666 RAM, 1TB HDD+256GB SSD, Microsoft";
        $product ->{'description:ar'}     ="Apple OMEN 15-6CM24AV-4 , Intel Core i7-9750H Processor 2.6GHz, NVIDIA GeForce GTX 1660 Ti 6GB GDDR5, 16GB DDR4-2666 RAM, 1TB HDD+256GB SSD, Microsoft ";
        $product ->image                  ="apple.jpg";
        $product ->price                  =6800;
        $product ->number                 =15;
        $product->category_id             = \App\Category::whereTranslationLike('name' , 'Computers')->first()->id;
        $product->subcategory_id          = \App\Subcategory::whereTranslationLike('name' , 'Apple')->first()->id;
        $product ->user_id                =\App\User::where('email','abdelhamid@gmail.com')->firstOrFail()->id;
        $product ->save();

        foreach (Product::all() as  $product) {
            $productimage               = new Productimages;
            $productimage->image        ="images_1.jpg";
            $productimage->product_id   =$product->id;
            $productimage->save();

            $productsize = new Productsize;
            $productsize->size = "xl";
            $productsize->product_id =$product->id;
            $productsize->save();

            $productcolor = new Productcolors;
            $productcolor->color = "#00aa11";
            $productcolor->product_id =$product->id;
            $productcolor->save();
        }
        foreach (Product::all() as  $product) {
            $productimage               = new Productimages;
            $productimage->image        ="images_2.jpg";
            $productimage->product_id   =$product->id;
            $productimage->save();

            $productsize = new Productsize;
            $productsize->size = "sm";
            $productsize->product_id =$product->id;
            $productsize->save();

            $productcolor = new Productcolors;
            $productcolor->color = "#002255";
            $productcolor->product_id =$product->id;
            $productcolor->save();
        }


        foreach (Product::all() as  $product) {
            $productimage               = new Productimages;
            $productimage->image        ="images_3.jpg";
            $productimage->product_id   =$product->id;
            $productimage->save();

            $productsize = new Productsize;
            $productsize->size = "xxl";
            $productsize->product_id =$product->id;
            $productsize->save();

            $productcolor = new Productcolors;
            $productcolor->color = "#aa88ee";
            $productcolor->product_id =$product->id;
            $productcolor->save();
        }


        foreach (Product::all() as  $product) {
            $productimage               = new Productimages;
            $productimage->image        ="images_4.jpg";
            $productimage->product_id   =$product->id;
            $productimage->save();

            $productsize = new Productsize;
            $productsize->size = "md";
            $productsize->product_id =$product->id;
            $productsize->save();

            $productcolor = new Productcolors;
            $productcolor->color = "#0001ff";
            $productcolor->product_id =$product->id;
            $productcolor->save();
        }
        foreach (Product::all() as  $product) {
            $productimage               = new Productimages;
            $productimage->image        ="images_5.jpg";
            $productimage->product_id   =$product->id;
            $productimage->save();
        }

        
    }
}
