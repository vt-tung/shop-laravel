<?php

namespace App\Services;

use App\Components\Recusive;

class ProcessViewService
{
    public static function view($table, $column, $key, $id){
        $ipAddress = Recusive::get_client_ip();
        $timeNow = time(); 

        $throttleTime = 60*60;
        $key = $key .'_'. md5($ipAddress) . '_' . $id;
        if (\Session::exists($key)) {
            $timeBefore = \Session::get($key);
            if($timeBefore + $throttleTime > $timeNow){
                return false;
            }
        }
        \Session::put($key, $timeNow);
        \DB::table($table)->where('product_id', $id)->increment($column);
    }
}
