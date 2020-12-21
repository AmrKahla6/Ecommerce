<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use LaravelLocalization;
use Illuminate\Http\Request;
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function validate_trans(Request $request, $params){
        foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
            foreach($params as $param) {
                $request->validate([
                    "$param[0].$localeCode"     => "$param[1]"
                ]);
            }
        }                       
    }
}
