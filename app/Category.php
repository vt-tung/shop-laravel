<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $timestamps = false; //set time to false
    protected $fillable = [
    	'meta_keywords', 'category_name', 'category_parent','category_desc','category_status'
    ];
    protected $primaryKey = 'category_id';
 	protected $table = 'tbl_category_product';



    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function categoryChildren()
    {
        return $this->hasMany(Category::class, 'category_parent');
    }

    public function children(){
        return $this->hasMany(Category::class, 'category_parent', 'category_id');
    }



    public function parent(){
    return $this->belongsTo(Category::class, 'category_parent');
    }

    public function products(){
        return $this->hasMany(Product::class, 'category_id');
    }
    public function recursiveChildren()
    {
       return $this->children()->with('recursiveChildren');
    }
}
