<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    public $timestamps = false; //set time to false
    protected $fillable = [
        'product_id', 'customer_id'
    ];
    protected $primaryKey = 'wishlist_id';
    protected $table = 'tbl_wishlist';
}
