<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    public $timestamps = false; //set time to false
    protected $fillable = [
    	'coupon_name', 'coupon_code', 'coupon_time','coupon_number', 'coupon_condition','coupon_date_start','coupon_date_end','coupon_status','coupon_used'
    ];
    protected $primaryKey = 'id_coupon';
 	protected $table = 'tbl_coupon';
}
