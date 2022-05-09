<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Gallery;
use App\Product;
use App\Color;
use App\Size;
use App\Rating;
use App\Category;
use App\Customer;
use App\Comment;
use Carbon\Carbon;
use App\Wishlist;
use App\Components\Recusive;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use App\Services\ProcessViewService;

session_start();
class ProductController extends Controller
{
    public function AuthLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }
    public function add_product(){
        $this->AuthLogin();
        $brand_product = DB::table('tbl_brand')->orderby('brand_id','desc')->get(); 
        $data       = Category::all();
        $recusive   = new Recusive($data);
        $htmlOption = $recusive->categoryRecusive($parentId='');
        return view('admin.add_product')->with('cate_product', $htmlOption)->with('brand_product',$brand_product);
    }
    
    public function all_product(){
        $this->AuthLogin();
    	$all_product = Product::join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
        ->join('tbl_brand','tbl_brand.brand_id','=','tbl_product.brand_id')
        ->orderby('tbl_product.product_id','desc')->paginate(6);

        $count_all_product = Product::join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
        ->join('tbl_brand','tbl_brand.brand_id','=','tbl_product.brand_id')
        ->orderby('tbl_product.product_id','desc')->count();
        $begin =  $all_product->firstItem();
        $end   = $all_product->lastItem();

    	$manager_product  = view('admin.all_product')->with('all_product',$all_product)->with('begin',$begin)->with('end',$end)->with('count_all_product',$count_all_product);
    	return view('admin_layout')->with('admin.all_product', $manager_product);

    }
    public function save_product(Request $request){
        $this->AuthLogin();
    	$data = array();
    	$data['product_name'] = $request->product_name;
        $data['product_desc'] = $request->product_desc;
        $data['product_content'] = $request->product_content;
        $data['product_import_price'] = $request->product_import_price;
        $data['product_price'] = $request->product_price;
        $data['product_qty'] = $request->product_qty;
        $data['product_promotion'] = $request->product_promotion;
        $data['product_price_promotion'] = $request->product_price-($request->product_price*$request->product_promotion/100);
        $data['category_id'] = $request->product_cate;
        $data['brand_id'] = $request->product_brand;
        $data['product_status'] = $request->product_status;
        $get_image = $request->file('product_image');
      
        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image =  $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move('public/uploads/product',$new_image);
            $data['product_image'] = $new_image;
            $pro_id=DB::table('tbl_product')->insertGetId($data);
            $get_image_gallery = $request->file('file');
            if($get_image_gallery){
                foreach($get_image_gallery as $image){
                    $get_name_image = $image->getClientOriginalName();
                    $name_image = current(explode('.',$get_name_image));
                    $new_image =  $name_image.rand(0,99).'.'.$image->getClientOriginalExtension();
                    $image->move('public/uploads/gallery',$new_image);
                    $gallery = new Gallery();
                    $gallery->product_id = $pro_id;
                    $gallery->gallery_image = $new_image;
                    $gallery->save();
                }
            }
            Session::put('messageaddproduct','Add product successfully');
            return Redirect::to('add-product');
        }
        $data['product_image'] = '';
        DB::table('tbl_product')->insertGetId($data);
    	Session::put('messageaddproduct','Add product successfully');
    	return Redirect::to('all-product');
    }

    public function unactive_product($product_id){
        $this->AuthLogin();
        DB::table('tbl_product')->where('product_id',$product_id)->update(['product_status'=>1]);
        Session::put('messageProuduct','Active product');
        return Redirect::to('all-product');
    }

    public function active_product($product_id){
         $this->AuthLogin();
        DB::table('tbl_product')->where('product_id',$product_id)->update(['product_status'=>0]);
        Session::put('messageProuduct','Unactive product');
        return Redirect::to('all-product');
    }

    public function getCategory($parentId){
        $data       =  Category::all();
        $recusive   = new Recusive($data);
        $htmlOption = $recusive->categoryRecusive($parentId);
        return $htmlOption;
    }

    public function edit_product($product_id){
         $this->AuthLogin();
        $brand_product = DB::table('tbl_brand')->orderby('brand_id','desc')->get(); 

        $product = Product::find($product_id);

        $cate_product = $this->getCategory($product->category_id);

        return view('admin.edit_product')->with('edit_product',$product)->with('cate_product',$cate_product)->with('brand_product',$brand_product);
    }

    public function update_product(Request $request,$product_id){
         $this->AuthLogin();
        $data = array();
        $data['product_name'] = $request->product_name;
        $data['product_desc'] = $request->product_desc;
        $data['product_content'] = $request->product_content;
        $data['product_price'] = $request->product_price;
        $data['product_qty'] = $request->product_qty;
        $data['product_promotion'] = $request->product_promotion;
        $data['product_price_promotion'] = $request->product_price-($request->product_price*$request->product_promotion/100);
        $data['category_id'] = $request->product_cate;
        $data['brand_id'] = $request->product_brand;
        $data['product_status'] = $request->product_status;
        $get_image = $request->file('product_image');
        
        if($get_image){
                    $get_name_image = $get_image->getClientOriginalName();
                    $name_image = current(explode('.',$get_name_image));
                    $new_image =  $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
                    $get_image->move('public/uploads/product',$new_image);
                    $data['product_image'] = $new_image;
                    DB::table('tbl_product')->where('product_id',$product_id)->update($data);
                    Session::put('messageupdateproduct','Update product successfully');
                    return Redirect::to('all-product');
        }
            
        DB::table('tbl_product')->where('product_id',$product_id)->update($data);
        Session::put('messageupdateproduct','Update product successfully');
        return Redirect::to('edit-product/'.$product_id);
    }
    public function delete_product($product_id){
        $this->AuthLogin();
        DB::table('tbl_product')->where('product_id',$product_id)->delete();
        Session::put('messageProuduct','Delete product successfully');
        return Redirect::to('all-product');
    }
    //End Admin Page
    public function details_product(Request $request, $product_id){

        $cate_product = DB::table('tbl_category_product')->where('category_status','1')->where('category_parent','0')->orderby('category_id','desc')->get(); 
        $brand_product = DB::table('tbl_brand')->where('brand_status','1')->orderby('brand_id','desc')->get(); 

        $details_product = DB::table('tbl_product')
        ->join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
        ->join('tbl_brand','tbl_brand.brand_id','=','tbl_product.brand_id')
        ->where('tbl_product.product_id',$product_id)->get();

        foreach($details_product as $key => $value){
            $category_id = $value->category_id;
            $product_id = $value->product_id;
            $meta_desc = $value->product_desc;
            $meta_keywords= $value->product_name;
            $meta_title= $value->product_name;
            $meta_canonical= $request->url();        
        }
       
        $gallery = Gallery::where('product_id',$product_id)->get();
        $color = Color::where('product_id',$product_id)->get();
        $size = Size::where('product_id',$product_id)->get();

        // $product = Product::where('product_id',$product_id)->first();
        // $product->product_views += 1;
        // $product->save();
        ProcessViewService::view('tbl_product','product_views','product',$product_id);
        $related_product = DB::table('tbl_product')->join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
        ->where('tbl_category_product.category_id',$category_id)->whereNotIn('tbl_product.product_id',[$product_id])->orWhere('tbl_category_product.category_parent',$category_id)->whereNotIn('tbl_product.product_id',[$product_id])->get();

        $rating         = round(Comment::where('comment_product_id',$product_id)->avg('rating'), 1, PHP_ROUND_HALF_DOWN);


        $customer_id    = Session::get('customer_id');
        $customer_infor = Customer::find($customer_id);
        return view('pages.product.show_details')->with('category',$cate_product)->with('brand',$brand_product)->with('product_details',$details_product)->with('relate',$related_product)->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('meta_canonical',$meta_canonical)->with('gallery',$gallery)->with('color',$color)->with('size',$size)->with('customer_infor',$customer_infor)->with('rating',$rating);
    }

    public function send_comment(Request $request){
        $product_id                      = $request->product_id;
        $comment_name                    = $request->comment_name;
        $comment_content                 = $request->comment_content;
        $number_rating                   = $request->number_rating;
        $customer_id                     = Session::get('customer_id');
        $customer_infor                  = Customer::find($customer_id);
        $comment                         = new Comment();
        $comment->comment                = $comment_content;
        $comment->comment_name           = $comment_name;
        $comment->comment_picture        = $customer_infor->customer_picture;
        $comment->comment_product_id     = $product_id;
        $comment->customer_id            = $customer_id;
        $comment->rating                 = $number_rating;
        $comment->comment_status         = 0;
        $comment->comment_parent_comment = 0;
        $comment->save();
        $product = Product::find($product_id);
        $product->product_number_rating += 1;
        $product->product_total_rating  += $number_rating;
        $product->save();
    }

    public function insert_rating(Request $request){
        $data = $request->all();
        $rating = new Rating();
        $rating->product_id = $data['product_id'];
        $rating->rating = $data['index'];
        $rating->save();
        echo 'done';
    }

    public function load_comment(Request $request){
        $product_id = $request->product_id;
        $id_comment = $request->id;
        if($id_comment>0){
            $comment = Comment::where('comment_product_id',$product_id)->where('comment_parent_comment','=',0)->where('comment_status',0)->where('id_comment','<',$id_comment)->orderby('id_comment','desc')->take(5)->get();
        }else{
            $comment = Comment::where('comment_product_id',$product_id)->where('comment_parent_comment','=',0)->where('comment_status',0)->orderby('id_comment','desc')->take(5)->get();
        }
        $comment_rep = Comment::with('product')->where('comment_parent_comment','>',0)->orderby('id_comment','desc')->get();
        if (!$comment->isEmpty()) {
            ?>
                <div>
                    <?php 
                        foreach($comment as $key => $comm){
                            $last_id=$comm->id_comment;
                            ?>
                                <div class="row style_comment">
                                    <div class="col-1">
                                        <?php 
                                            if($comm->comment_picture!=""){
                                                ?>
                                                    <img width="100%" src="<?php echo url(''.$comm->comment_picture.'') ?>" class="img img-responsive img-thumbnail" style="border-radius:50%">
                                                <?php
                                            }else{
                                                ?>
                                                    <img width="100%" src="<?php echo url('public/frontend/images/pngtree-user-vector-avatar-png-image_1541962.jpg') ?>" class="img img-responsive img-thumbnail" style="border-radius:50%">
                                                <?php
                                            }
                                        ?>

                                    </div>
                                    <div class="col-11">
                                        <div>
                                            <p style="color:green;">@<?php echo $comm->comment_name; ?> - <?php echo Carbon::createFromFormat('Y-m-d H:i:s',$comm->comment_date)->format('H:i:s d/m/Y') ?></p>
                                            <?php
                                                for($i=1; $i<=5; $i++){
                                                    ?>
                                                        <a class="cl-rating-product cl-commented" title="">
                                                          <i class="fa fa-star <?php if($i <= $comm->rating){ echo 'active';} ?>"></i>
                                                        </a>
                                                    <?php
                                                }
                   
                                            ?>
                                        </div>
                                        
                                        <p><?php echo $comm->comment; ?></p>
                                    </div>
                                </div>
                            <?php

                            foreach($comment_rep as $key => $rep_comment)  {
                                if($rep_comment->comment_parent_comment==$comm->id_comment)  {
                                    ?>
                                        <div class="row style_comment" style="margin: 0px 0px 35px 40px!important; background: #f5f6f7;">
                                            <div class="col-1">
                                                <img width="100%" src="<?php echo url('/public/frontend/images/pngtree-user-vector-avatar-png-image_1541962.jpg') ?>" class="img img-responsive img-thumbnail" style="border-radius: 50%">
                                            </div>
                                            <div class="col-11">
                                                <p style="color:#9c0000;">@Admin - <?php echo Carbon::createFromFormat('Y-m-d H:i:s',$rep_comment->comment_date)->format('H:i:s d/m/Y') ?></p>
                                                <p style="color:#000;"><?php echo $rep_comment->comment; ?></p>
                                            </div>
                                        </div>
                                    <?php
                                }
                            }
                        }
                    ?>
                </div>
                 <button style="
                    padding: 12px 15px;
                    text-transform: capitalize;
                    color: #fff;
                    font-size: 14px;
                    background-color: #000;
                    border-color: #000;
                    cursor: pointer;
                    border-style: unset;
                    transition: .3s;
                    font-weight: 600;
                    width: 100%;
                    text-transform: uppercase;"
                 type="button" id="cl-load_more_comment" data-id='<?php echo $last_id ?>'>Load More</button>
            <?php
        }
    }

    public function list_comment(){
        $admin_id   = Session::get('admin_id');
        $admin_role = Session::get('admin_role');
        if($admin_id && $admin_role==1){
            $comment = Comment::with('product')->where('comment_parent_comment','=',0)->orderBy('id_comment','DESC')->paginate(6);
            $comment_rep = Comment::with('product')->where('comment_parent_comment','>',0)->get();
            return view('admin.comment.list_comment')->with(compact('comment','comment_rep'));
        }else{
            return view('errors.404');
        }
    }

    public function view_rating($product_id){
        $admin_id   = Session::get('admin_id');
        $admin_role = Session::get('admin_role');
        if($admin_id && $admin_role==1){
            $comment = Comment::with('product')->where('comment_parent_comment','=',0)->where('comment_product_id',$product_id)->orderBy('id_comment','DESC')->paginate(6);
            $comment_rep = Comment::with('product')->where('comment_parent_comment','>',0)->get();
            return view('admin.view_rating')->with(compact('comment','comment_rep'));;
        }else{
            return view('errors.404');
        }
    }

    public function allow_comment(Request $request){
        $data = $request->all();
        $comment = Comment::find($data['comment_id']);
        $comment->comment_status = $data['comment_status'];
        $comment->save();
    }

    public function reply_comment(Request $request){
        $data = $request->all();
        $comment = new Comment();
        $comment->comment = $data['comment'];
        $comment->comment_product_id = $data['comment_product_id'];
        $comment->comment_parent_comment = $data['comment_id'];
        $comment->comment_status = 0;
        $comment->comment_name = 'WILDSTORE';
        $comment->save();
    }
}
