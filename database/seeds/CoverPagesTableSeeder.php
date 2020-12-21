<?php

use Illuminate\Database\Seeder;
use App\Coverpages;

class CoverPagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $coverpages                          = new Coverpages;
        $coverpages->cover_blog              = 'cover_page_1.jpg';
        $coverpages->cover_blog_deatails     = 'cover_page_1.jpg';
        $coverpages->cover_contact           = 'cover_page_1.jpg';
        $coverpages->cover_cart              = 'cover_page_1.jpg';
        $coverpages->cover_favourite         = 'cover_page_1.jpg';
        $coverpages->cover_checkout          = 'cover_page_1.jpg';
        $coverpages->cover_shop              = 'cover_page_1.jpg';
        $coverpages->cover_product_details   = 'cover_page_1.jpg';
        $coverpages->cover_login             = 'cover_page_login.jpg';
        $coverpages->cover_testimations      = 'cover_testimations.jpg';
        $coverpages->save();
    }
}
