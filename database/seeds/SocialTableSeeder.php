<?php

use Illuminate\Database\Seeder;
use App\SocialSetting;

class SocialTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $social             = new SocialSetting;
        $social->url        = "https://www.facebook.com/";
        $social->icon       = "facebook";
        $social->save();

        $social             = new SocialSetting;
        $social->url        = "https://www.google.com/";
        $social->icon       = "google-plus";
        $social->save();

        $social             = new SocialSetting;
        $social->url        = "https://www.youtube.com/";
        $social->icon       = "youtube-play";
        $social->save();

        $social             = new SocialSetting;
        $social->url        = "https://twitter.com/";
        $social->icon       = "twitter";
        $social->save();
    }
}
