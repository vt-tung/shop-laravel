<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public $timestamps = false; //set time to false
    protected $fillable = [
    	'id_comment','comment', 'comment_name', 'comment_picture', 'comment_date','comment_product_id','comment_parent_comment','comment_status', 'rating', 'customer_id'
    ];
    protected $primaryKey = 'id_comment';
 	protected $table = 'tbl_comment';

 	public function product(){
 		return $this->belongsTo('App\Product','comment_product_id');
 	}
}
