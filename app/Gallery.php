<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    public $timestamps = false; //set time to false
    protected $fillable = [
    	'product_id','gallery_image'
    ];
    protected $primaryKey = 'gallery_id';
 	protected $table = 'tbl_gallery';
}
