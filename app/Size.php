<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    public $timestamps = false;
    protected $fillable = [
    	'product_id','size_name'
    ];
    protected $primaryKey = 'size_id';
 	protected $table = 'tbl_size';
}
