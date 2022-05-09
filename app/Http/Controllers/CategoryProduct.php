<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Http\Requests;
use App\Category;
use App\Brand;
use App\Product;
use App\Color;
use App\Size;
use App\Gallery;
use App\Components\Recusive;
use Illuminate\Support\Facades\Redirect;
session_start();

class CategoryProduct extends Controller
{
    private $category;
    public function __construct(Category $category){
        $this->category = $category;
    }

    public function AuthLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }
    // public function add_category_product(){
    //     $this->AuthLogin();
    //     $category = Category::where('category_parent',0)->orderBy('category_id','DESC')->get();
    // 	return view('admin.add_category_product',compact('category'));
    // }

    public function add_category_product(){
        $this->AuthLogin();
        $data       = $this->category->all();
        $recusive   = new Recusive($data);
        $htmlOption = $recusive->categoryRecusive($parentId='');
        return view('admin.add_category_product', compact('htmlOption'));
    }


    public function all_category_product(){
        $this->AuthLogin();
    	$all_category_product = DB::table('tbl_category_product')->get();
    	$manager_category_product  = view('admin.all_category_product')->with('all_category_product',$all_category_product);
    	return view('admin_layout')->with('admin.all_category_product', $manager_category_product);
    }

    public function save_category_product(Request $request){
        $this->AuthLogin();
    	$data = array();
        $data['category_parent'] = $request->category_parent;
    	$data['category_name'] = $request->category_product_name;
    	$data['category_desc'] = $request->category_product_desc;
        $data['meta_keywords'] = $request->meta_keywords;
    	$data['category_status'] = $request->category_product_status;

    	DB::table('tbl_category_product')->insert($data);
    	Session::put('messageaddcategory','Add category successfully');
    	return Redirect::to('add-category-product');
    }

    public function unactive_category_product($category_product_id){
        $this->AuthLogin();
        DB::table('tbl_category_product')->where('category_id',$category_product_id)->update(['category_status'=>1]);
        Session::put('messageCategory','Active successfully');
        return Redirect::to('all-category-product');

    }

    public function active_category_product($category_product_id){
        $this->AuthLogin();
        DB::table('tbl_category_product')->where('category_id',$category_product_id)->update(['category_status'=>0]);
        Session::put('messageCategory','Unactive successfully');
        return Redirect::to('all-category-product');
    }

    public function getCategory($category_product_id,$parentId){

        $data       =  $this->category->whereNotIn('category_id',[$category_product_id])->get();
        $recusive   = new Recusive($data);
        $htmlOption = $recusive->categoryRecusive($parentId);
        return $htmlOption;
    }

    public function edit_category_product($category_product_id){
        $this->AuthLogin();
        $category = $this->category->find($category_product_id);
        $htmlOption = $this->getCategory($category_product_id,$category->category_parent);
        return view('admin.edit_category_product', compact('category','htmlOption'));
    }

    public function update_category_product(Request $request,$category_product_id){
        $this->AuthLogin();
        $data = array();
        $data['meta_keywords'] = $request->meta_keywords;
        $data['category_name'] = $request->category_product_name;
        $data['category_parent'] = $request->category_parent;
        $data['category_desc'] = $request->category_product_desc;
        DB::table('tbl_category_product')->where('category_id',$category_product_id)->update($data);
        Session::put('messageupdatecategory','Update category successfully');
        return Redirect::to('edit-category-product/'.$category_product_id);
    }

    public function delete_category_product($category_product_id){
        $this->AuthLogin();
        DB::table('tbl_category_product')->where('category_id',$category_product_id)->delete();
        Session::put('messageCategory','Delete category successfully');
        return Redirect::to('all-category-product');
    }

    //End Function Admin Page
    public function show_category_home(Request $request, $category_product_id){
        $paramtAtbSearch = $request->except('price','page');
        $paramtAtbSearch = array_values($paramtAtbSearch);
        $cate_product = DB::table('tbl_category_product')->where('category_status','1')->where('category_parent','0')->orderby('category_id','desc')->get(); 
        $brand_product = DB::table('tbl_brand')->where('brand_status','1')->orderby('brand_id','desc')->get(); 
        $cate_side_bar = DB::table('tbl_category_product')->where('category_status','1')->orderby('category_id','asc')->get(); 

        $products = Product::join('tbl_category_product','tbl_product.category_id','tbl_category_product.category_id')->where('tbl_category_product.category_id',$category_product_id)->where('product_status','1');

        $product_id = Product::join('tbl_category_product','tbl_product.category_id','tbl_category_product.category_id')->where('tbl_category_product.category_parent',$category_product_id)->where('product_status','1');
        if ($request->brand) {
            $brand = $request->brand;
            $products->where('brand_id', $brand);
            $product_id->where('brand_id', $brand);
        }

        if($request->price){
            $price = $request->price;
            if($price == 6){
                $products->where('product_price_promotion','>=',1000000);
                $product_id->where('product_price_promotion','>=',1000000);
            }else{
               $products->where('product_price_promotion','<=',200000*$price);
               $product_id->where('product_price_promotion','<=',200000*$price);
            }
        }

        if($request->color){
            $color = $request->color;
            $products->join('tbl_color','tbl_product.product_id','tbl_color.product_id')->where('tbl_color.color_name',$color);
            $product_id->join('tbl_color','tbl_product.product_id','tbl_color.product_id')->where('tbl_color.color_name',$color);
        }

        if($request->size){
            $size = $request->size;
            $products->join('tbl_size','tbl_product.product_id','tbl_size.product_id')->where('tbl_size.size_name',$size);
            $product_id->join('tbl_size','tbl_product.product_id','tbl_size.product_id')->where('tbl_size.size_name',$size);

        }

        if($request->orderby){
            $orderby = $request->orderby;
            switch ($orderby) {
                case 'desc':
                    $products->orderBy('tbl_product.product_id','DESC');

                    break;

                case 'asc':
                    $products->orderBy('tbl_product.product_id','ASC');
                    break;

                case 'price_max':
                    $products->orderBy('tbl_product.product_price_promotion','DESC');
                    break;

                case 'price_min':
                    $products->orderBy('tbl_product.product_price_promotion','ASC');
                    break;
                case 'A_Z':
                    $products->orderBy('tbl_product.product_name','ASC');
                    break;
                case 'Z_A':
                    $products->orderBy('tbl_product.product_name','DESC');
                    break; 
            }
        }

        if($request->orderby){
            $orderby = $request->orderby;
            switch ($orderby) {
                case 'desc':
                    $product_id->orderBy('tbl_product.product_id','DESC');
                    break;

                case 'asc':
                    $product_id->orderBy('tbl_product.product_id','ASC');
                    break;

                case 'price_max':
                    $product_id->orderBy('tbl_product.product_price_promotion','DESC');
                    break;

                case 'price_min':
                    $product_id->orderBy('tbl_product.product_price_promotion','ASC');
                    break;
                case 'A_Z':
                    $product_id->orderBy('tbl_product.product_name','ASC');
                    break;
                case 'Z_A':
                    $product_id->orderBy('tbl_product.product_name','DESC');
                    break;  
            }
        }

        $count_products   = $products->count();
        $products         = $products->paginate(12)->appends(request()->query());
        $begin_products   = $products->firstItem();
        $end_products     = $products->lastItem();

        $count_product_id = $product_id->count();
        $product_id       = $product_id->paginate(12)->appends(request()->query());
        $begin            = $product_id->firstItem();
        $end              = $product_id->lastItem();


        $categories = Category::where('category_parent',0)->get();


        $category_by_dd = DB::table('tbl_category_product')->where('tbl_category_product.category_id',$category_product_id)->get();
        foreach ($category_by_dd as $key => $val) {
            $meta_desc = $val->category_desc;
            $meta_keywords= $val->meta_keywords;
            $meta_title= $val->category_name;
            $meta_canonical= $request->url();
        }

        $color = Color::select('color_name')->groupBy('color_name')->orderBy('color_name','ASC')->get();
        $size = Size::select('size_name')->groupBy('size_name')->orderBy('size_name','ASC')->get();


        $category_name = DB::table('tbl_category_product')->where('tbl_category_product.category_id',$category_product_id)->limit(1)->get();
        
        $galleryone = Gallery::join('tbl_product','tbl_gallery.product_id','=','tbl_product.product_id')->get();

        return view('pages.category.show_category')->with('categories',$categories)->with('cate_side_bar',$cate_side_bar)->with('category',$cate_product)->with('brand',$brand_product)->with('products',$products)->with('category_name',$category_name)->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('meta_canonical',$meta_canonical)->with('color',$color)->with('size',$size)->with('product_id',$product_id)->with('gallery',$galleryone)->with('begin',$begin)->with('end',$end)->with('count_product_id',$count_product_id)->with('begin_products',$begin_products)->with('end_products',$end_products)->with('count_products',$count_products);
    }

}
