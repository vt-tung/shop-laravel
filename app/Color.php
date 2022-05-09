<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    public $timestamps = false;
    protected $fillable = [
    	'product_id','color_name'
    ];
    protected $primaryKey = 'color_id';
 	protected $table = 'tbl_color';
}
