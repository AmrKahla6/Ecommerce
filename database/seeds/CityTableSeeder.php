<?php

use Illuminate\Database\Seeder;
use App\City;

class CityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $city                        = new City;
        $city->{'name:en'}           = 'cairo';
        $city->{'name:ar'}           = 'القاهره';
        $city->save();
    }
}
