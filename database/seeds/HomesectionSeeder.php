<?php

use Illuminate\Database\Seeder;
use App\Homesection1;
use App\Homesection2;
use App\Homesection3;
class HomesectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $homesection1                    = new Homesection1;
        $homesection1->{'title:en'}      = 'HP Labs';
        $homesection1->{'title:ar'}      ='لابات اتش بي';
        $homesection1->{'description:en'}= 'HP laptops are irreplaceable in terms of quality, efficiency and price, as they bear pressure, videos and all games';
        $homesection1->{'description:ar'}= 'لابات اتش بي لا يمكن الاستغناء عنها من حيث الجوده والكفاءه والسعر فهي تتحمل الضغط والفيديوهات وجميع الالعاب';
        $homesection1->{'button:en'}     = 'ِHP Products';
        $homesection1->{'button:ar'}     = 'تسوق منتجات اتش بي';
        $homesection1->image             = "h_1_5.jpg";
        $homesection1->category_id       = \App\Category::whereTranslationLike('name' , 'Computers')->first()->id;
        $homesection1->subcategory_id    = \App\Subcategory::whereTranslationLike('name' , 'hp')->first()->id;
        $homesection1->save();

        $homesection1                    = new Homesection1;
        $homesection1->{'title:en'}      = 'Lenovo Labs';
        $homesection1->{'title:ar'}      ='لابات لينوفو ';
        $homesection1->{'description:en'}= 'Lenovo laptops are irreplaceable in terms of quality, efficiency and price, as they bear pressure, videos and all games';
        $homesection1->{'description:ar'}= 'لابات لينوفو لا يمكن الاستغناء عنها من حيث الجوده والكفاءه والسعر فهي تتحمل الضغط والفيديوهات وجميع الالعاب';
        $homesection1->{'button:en'}     = 'ِLenovo Products';
        $homesection1->{'button:ar'}     = 'تسوق منتجات لينوفو';
        $homesection1->image             = "h_1_1.jpg";
        $homesection1->category_id       = \App\Category::whereTranslationLike('name' , 'Computers')->first()->id;
        $homesection1->subcategory_id    = \App\Subcategory::whereTranslationLike('name' , 'Lenovo')->first()->id;
        $homesection1->save();

        $homesection1                    = new Homesection1;
        $homesection1->{'title:en'}      = 'TOSHIBA Labs';
        $homesection1->{'title:ar'}      ='لابات توشيبا';
        $homesection1->{'description:en'}= 'TOSHIBA laptops are irreplaceable in terms of quality, efficiency and price, as they bear pressure, videos and all games';
        $homesection1->{'description:ar'}= 'لابات توشيبا لا يمكن الاستغناء عنها من حيث الجوده والكفاءه والسعر فهي تتحمل الضغط والفيديوهات وجميع الالعاب';
        $homesection1->{'button:en'}     = 'ِTOSHIBA Products';
        $homesection1->{'button:ar'}     = 'تسوق منتجات توشيبا';
        $homesection1->image             = "h_1_3.jpg";
        $homesection1->category_id       = \App\Category::whereTranslationLike('name' , 'Computers')->first()->id;
        $homesection1->subcategory_id    = \App\Subcategory::whereTranslationLike('name' , 'Toshiba')->first()->id;
        $homesection1->save();

        $homesection1                    = new Homesection1;
        $homesection1->{'title:en'}      = 'HP Labs';
        $homesection1->{'title:ar'}      ='لابات اتش بي';
        $homesection1->{'description:en'}= 'HP laptops are irreplaceable in terms of quality, efficiency and price, as they bear pressure, videos and all games';
        $homesection1->{'description:ar'}= 'لابات اتش بي لا يمكن الاستغناء عنها من حيث الجوده والكفاءه والسعر فهي تتحمل الضغط والفيديوهات وجميع الالعاب';
        $homesection1->{'button:en'}     = 'ِHP Products';
        $homesection1->{'button:ar'}     = 'تسوق منتجات اتش بي';
        $homesection1->image             = "h_1_6.jpg";
        $homesection1->category_id       = \App\Category::whereTranslationLike('name' , 'Computers')->first()->id;
        $homesection1->subcategory_id    = \App\Subcategory::whereTranslationLike('name' , 'hp')->first()->id;
        $homesection1->save();

        $homesection1                    = new Homesection1;
        $homesection1->{'title:en'}      = 'Lenovo Labs';
        $homesection1->{'title:ar'}      ='لابات لينوفو ';
        $homesection1->{'description:en'}= 'Lenovo laptops are irreplaceable in terms of quality, efficiency and price, as they bear pressure, videos and all games';
        $homesection1->{'description:ar'}= 'لابات لينوفو لا يمكن الاستغناء عنها من حيث الجوده والكفاءه والسعر فهي تتحمل الضغط والفيديوهات وجميع الالعاب';
        $homesection1->{'button:en'}     = 'ِLenovo Products';
        $homesection1->{'button:ar'}     = 'تسوق منتجات لينوفو';
        $homesection1->image             = "h_1_4.jpg";
        $homesection1->category_id       = \App\Category::whereTranslationLike('name' , 'Computers')->first()->id;
        $homesection1->subcategory_id    = \App\Subcategory::whereTranslationLike('name' , 'Lenovo')->first()->id;
        $homesection1->save();

        $homesection2                    = new Homesection2;
        $homesection2->{'title:en'}      = 'TOSHIBA Labs';
        $homesection2->{'title:ar'}      ='لابات اتش بي';
        $homesection2->{'description:en'}= 'TOSHIBA laptops are irreplaceable in terms of quality, efficiency and price';
        $homesection2->{'description:ar'}= 'لابات توشيبا لا يمكن الاستغناء عنها من حيث الجوده والكفاءه والسعر فهي تتحمل الضغط ';
        $homesection2->image             = "h_2_1.jpg";
        $homesection2->category_id       = \App\Category::whereTranslationLike('name' , 'Computers')->first()->id;
        $homesection2->subcategory_id    = \App\Subcategory::whereTranslationLike('name' , 'Toshiba')->first()->id;
        $homesection2->save();

        $homesection2                    = new Homesection2;
        $homesection2->{'title:en'}      = 'DELL Labs';
        $homesection2->{'title:ar'}      ='لابات ديل';
        $homesection2->{'description:en'}= 'DELL laptops are irreplaceable in terms of quality, efficiency and price';
        $homesection2->{'description:ar'}= 'لابات ديل لا يمكن الاستغناء عنها من حيث الجوده والكفاءه والسعر فهي تتحمل الضغط ';
        $homesection2->image             = "h_2_2.jpg";
        $homesection2->category_id       = \App\Category::whereTranslationLike('name' , 'Computers')->first()->id;
        $homesection2->subcategory_id    = \App\Subcategory::whereTranslationLike('name' , 'Dell')->first()->id;
        $homesection2->save();

        $homesection2                    = new Homesection2;
        $homesection2->{'title:en'}      = 'Lenovo Labs';
        $homesection2->{'title:ar'}      ='لابات لينوفو ';
        $homesection2->{'description:en'}= 'Lenovo laptops are irreplaceable in terms of quality, efficiency and price';
        $homesection2->{'description:ar'}= 'لابات لينوفو لا يمكن الاستغناء عنها من حيث الجوده والكفاءه والسعر فهي تتحمل الضغط ';
        $homesection2->image             = "h_2_3.jpg";
        $homesection2->category_id       = \App\Category::whereTranslationLike('name' , 'Computers')->first()->id;
        $homesection2->subcategory_id    = \App\Subcategory::whereTranslationLike('name' , 'Lenovo')->first()->id;
        $homesection2->save();

        $homesection2                    = new Homesection2;
        $homesection2->{'title:en'}      = 'APPLE Labs';
        $homesection2->{'title:ar'}      ='لابات ابل';
        $homesection2->{'description:en'}= 'APPLE laptops are irreplaceable in terms of quality, efficiency and price';
        $homesection2->{'description:ar'}= 'لابات ابل لا يمكن الاستغناء عنها من حيث الجوده والكفاءه والسعر فهي تتحمل الضغط ';
        $homesection2->image             = "h_2_4.jpg";
        $homesection2->category_id       = \App\Category::whereTranslationLike('name' , 'Computers')->first()->id;
        $homesection2->subcategory_id    = \App\Subcategory::whereTranslationLike('name' , 'Apple')->first()->id;
        $homesection2->save();

        $homesection2                    = new Homesection2;
        $homesection2->{'title:en'}      = 'Acer Labs';
        $homesection2->{'title:ar'}      ='لابات اسر';
        $homesection2->{'description:en'}= 'Acer laptops are irreplaceable in terms of quality, efficiency and price';
        $homesection2->{'description:ar'}= 'لابات اسر لا يمكن الاستغناء عنها من حيث الجوده والكفاءه والسعر فهي تتحمل الضغط ';
        $homesection2->image             = "h_2_5.jpg";
        $homesection2->category_id       = \App\Category::whereTranslationLike('name' , 'Computers')->first()->id;
        $homesection2->subcategory_id    = \App\Subcategory::whereTranslationLike('name' , 'Acer')->first()->id;
        $homesection2->save();

        $homesection2                    = new Homesection2;
        $homesection2->{'title:en'}      = 'HP Labs';
        $homesection2->{'title:ar'}      ='لابات اتش بي';
        $homesection2->{'description:en'}= 'HP laptops are irreplaceable in terms of quality, efficiency and price';
        $homesection2->{'description:ar'}= 'لابات اتش بي لا يمكن الاستغناء عنها من حيث الجوده والكفاءه والسعر فهي تتحمل الضغط ';
        $homesection2->image             = "h_2_6.jpg";
        $homesection2->category_id       = \App\Category::whereTranslationLike('name' , 'Computers')->first()->id;
        $homesection2->subcategory_id    = \App\Subcategory::whereTranslationLike('name' , 'Acer')->first()->id;
        $homesection2->save();
    }
}
