<?php

use Illuminate\Database\Seeder;
use App\Generalsetting;

class GeneralsettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $general_setting                                = new Generalsetting;

        $general_setting->{'title_of_div_6_of_home_section_2:en'}   = 'SIGN UP & GET 20% OFF';
        $general_setting->{'desc_of_div_6_of_home_section_2:en'}    = 'Be the frist to know about the latest fashion news and get exclu-sive offers';
        $general_setting->{'button_of_div_6_of_home_section_2:en'}  = 'sign up';

        $general_setting->{'terms_condition:en'}  = 'terms_condition';
        $general_setting->{'desc_of_politic_register_user:en'}  = 'register_user';
        $general_setting->{'title_politic_register_user:en'}  = 'register_user';
        $general_setting->{'desc_of_politic_register_company:en'}  = 'register_company';
        $general_setting->{'title_politic_register_company:en'}  = 'register_company';

        $general_setting->{'desc_in_above_navbar:en'}   = 'Free shipping for standard order over $100';
        $general_setting->{'get_touch:en'}              = 'GET IN TOUCH';
        $general_setting->{'desc_get_touch:en'}         = 'Any questions? Let us know in store at 8th floor, 379 Hudson St, New York, NY 10018 or call us on (+1) 96 716 6879';
        $general_setting->{'copy_right:en'}             = 'copy_right';
        $general_setting->{'title_of_shipping:en'}      = 'title_of_shipping';
        $general_setting->{'title_of_track_order:en'}   = 'title_of_track_order';
        $general_setting->{'title_of_fqa:en'}           = 'title_of_fqa';
        $general_setting->{'title_of_returns:en'}       = 'title_of_returns';
        $general_setting->link_of_track_order           = 'https://www.facebook.com/';
        $general_setting->email_above_navbar            = 'admin@gmail.com';
        $general_setting->logo                          = 'logo.jpg';
        $general_setting->save();
    }
}
