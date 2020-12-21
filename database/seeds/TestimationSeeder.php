<?php

use Illuminate\Database\Seeder;
use App\Testimation;

class TestimationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $testimation                        = new Testimation;
        $testimation->description           = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit sed do eiusmod teincidi dunt ut labore et dolore gna aliqua. Ut enim ad minim veniam,';
        $testimation->user_id               = \App\User::where('email','abdelhamid@gmail.com')->first()->id;
        $testimation->save();

        $testimation                        = new Testimation;
        $testimation->description           = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit sed do eiusmod teincidi dunt ut labore et dolore gna aliqua. Ut enim ad minim veniam,';
        $testimation->user_id               = \App\User::where('email','abdelhamid@gmail.com')->first()->id;
        $testimation->save();
    }
}
