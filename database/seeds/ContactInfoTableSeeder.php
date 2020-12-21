<?php

use Illuminate\Database\Seeder;
use App\Contactinfo;

class ContactInfoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $contact_info                    = new Contactinfo;
        $contact_info->{"location:ar"}   = " المنصوره - الدقليه - مصر";
        $contact_info->{"location:en"}   = " Mansoura - Dakahlia - Egypt";
        $contact_info->lat               = '31.040720';
        $contact_info->lng               = '31.382469';
        $contact_info->email             = 'amrkahla6@gmail.com';
        $contact_info->mobile            = '+201154400681';
        $contact_info->save();
    }
}
