<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    public $timestamps = false; //set time to false
    protected $fillable = [
    	'slider_name', 'slider_image','slider_status'
    ];
    protected $primaryKey = 'slider_id';
 	protected $table = 'tbl_slider';
}
