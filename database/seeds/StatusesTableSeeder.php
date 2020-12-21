<?php

use Illuminate\Database\Seeder;
use App\Status;

class StatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $status                 = new Status;
        $status->{'name:en'}    = 'active';
        $status->{'name:ar'}    = 'نشط';
        $status->{'name:ur'}    = 'فعال';
        $status->slug           = 'active';
        $status->save();

        $status                 = new Status;
        $status->{'name:en'}    = 'inactive';
        $status->{'name:ur'}    = 'غیر فعال';
        $status->{'name:ar'}    = 'غير نشط';
        $status->slug           = 'inactive';
        $status->save();
        
        $status                 = new Status;
        $status->{'name:en'}    = 'pending';
        $status->{'name:ar'}    = 'معلق';
        $status->{'name:ur'}    = 'زیر التواء';
        $status->slug           = 'pending';
        $status->save();  

        $status                 = new Status;
        $status->{'name:en'}    = 'block';
        $status->{'name:ur'}    = 'بلاک';
        $status->{'name:ar'}    = 'رفض';
        $status->slug           = 'block';
        $status->save();
    }
}
