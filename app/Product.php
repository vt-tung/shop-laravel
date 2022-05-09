<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Customer;
class Product extends Model
{
    public $timestamps = false; //set time to false
    protected $fillable = [
    	'product_name','category_id','brand_id','product_desc','product_content','product_import_price','product_price','product_qty','product_sold','product_promotion','product_price_promotion','product_image','product_status', 'product_number_rating', 'product_total_rating','product_views'
    ];
    protected $primaryKey = 'product_id';
 	protected $table = 'tbl_product';

 	public function comment(){
 		return $this->hasMany('App\Comment');
 	}
 	
	public function category(){
	    return $this->belongsTo(Category::class, 'category_id');
	}

    public function wishlistuser(){
        return $this->belongsToMany(Customer::class,'tbl_wishlist','product_id','customer_id');
    }
}
