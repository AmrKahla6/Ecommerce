<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GeneralsettingTranslation extends Model
{
    public $timestamps = false;
    protected $fillable  = ['terms_condition','desc_of_politic_register_user','title_politic_register_user','desc_of_politic_register_company','title_politic_register_company','title_of_div_6_of_home_section_2','desc_of_div_6_of_home_section_2','button_of_div_6_of_home_section_2','desc_in_above_navbar','get_touch','desc_get_touch','copy_right','title_of_shipping','title_of_track_order','title_of_fqa','title_of_returns'];

}
