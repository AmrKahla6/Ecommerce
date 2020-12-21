<?php

use Illuminate\Database\Seeder;
use App\About;

class AboutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $about                        = new About;
        $about->{'title:en'}          = 'About our website';
        $about->{'title:ar'}          = 'نبذة عن موقعنا';
        $about->{'description:en'}    = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore gna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat';
        $about->{'description:ar'}    = ' موقعنا عباره عن مجموعة من العمليّات التجاريّة التي تشمل على شراء وبيع الخدمات والسلع،';
        $about->image                 = 'about_image.jpg';
        $about->cover                 = 'cover_page_1.jpg';

        $about->{'why_choose:en'}                        = 'Why Choose Us?';
        $about->{'why_choose:ar'}                        = 'ليه تختارنا ؟';

        $about->{'why_choose_title_1:en'}                = 'Free Gift Box';
        $about->{'why_choose_title_1:ar'}                = 'Free Gift Box';
        $about->{'why_choose_desc_1:en'}                 = 'Lorem ipsum dolor sit amet consect adipisic elit sed do';
        $about->{'why_choose_desc_1:ar'}                 = 'Lorem ipsum dolor sit amet consect adipisic elit sed do';
        $about->why_choose_image_1                       = 'ti-heart';

        $about->{'why_choose_title_2:en'}                = 'Money Back';
        $about->{'why_choose_title_2:ar'}                = 'Money Back';
        $about->{'why_choose_desc_2:en'}                 = 'Lorem ipsum dolor sit amet consect adipisic elit sed do';
        $about->{'why_choose_desc_2:ar'}                 = 'Lorem ipsum dolor sit amet consect adipisic elit sed do';
        $about->why_choose_image_2                       = 'ti-reload';

        $about->{'why_choose_title_3:en'}                = 'Support 24/7';
        $about->{'why_choose_title_3:ar'}                = 'Support 24/7';
        $about->{'why_choose_desc_3:en'}                 = 'Lorem ipsum dolor sit amet consect adipisic elit sed do';
        $about->{'why_choose_desc_3:ar'}                 = 'Lorem ipsum dolor sit amet consect adipisic elit sed do';
        $about->why_choose_image_3                       = 'ti-time';

        $about->{'why_choose_title_4:en'}                = 'Free Delivery';
        $about->{'why_choose_title_4:ar'}                = 'Free Delivery';
        $about->{'why_choose_desc_4:en'}                 = 'Lorem ipsum dolor sit amet consect adipisic elit sed do';
        $about->{'why_choose_desc_4:ar'}                 = 'Lorem ipsum dolor sit amet consect adipisic elit sed do';
        $about->why_choose_image_4                       = 'ti-truck';

        $about->save();
    }
}
