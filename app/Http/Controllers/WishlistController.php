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
use App\Wishlist;
use Carbon\Carbon;
use App\Components\Recusive;
use App\Http\Requests;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
session_start();

class WishlistController extends Controller
{
    public function insert_wishlist(Request $request)
    {
        $data = $request->all();
        $wishlist_check=Wishlist::where('product_id','=',$data['product_id'])->where('product_id','=',$data['customer_id'])->first();

        if ($wishlist_check==NULL) {
            $wishlist = new Wishlist();
            $wishlist->product_id    = $data['product_id'];
            $wishlist->customer_id   = $data['customer_id'];
            $wishlist->save();
        }

        ?>
            <a href="<?php echo url('/show-wishlist') ?>" name="wishlist" class="cl-icon-wl_cp cl-tooltip_left" data-cl-tooltip="Browse wishlist">
                <i class="fa fa-heart" style="color:#e9635d"></i>
            </a>
        <?php
    }

    public function count_wishlist(Request $request){
        $data = $request->all();
        $customer_id = Session::get('customer_id');
        $wishlist_count=Wishlist::where('customer_id','=',$customer_id)->count();
        if ($wishlist_count>0) {
            if (url('/show-wishlist')==$data['url']) {
                ?>
                    <a class="cl-item active">
                        <span class="lock-icon"><i class="fa fa-heart-o" aria-hidden="true"></i></span><span>Wishlist</span> (<span class="cl-number"><?php echo $wishlist_count ?></span>)
                    </a>
                <?php
            }else{
                ?>
                    <a href="<?php echo url('/show-wishlist') ?>" class="cl-item">
                        <span class="lock-icon"><i class="fa fa-heart-o" aria-hidden="true"></i></span><span>Wishlist</span> (<span class="cl-number"><?php echo $wishlist_count ?></span>)
                    </a>
                <?php
            }

        }else{
            ?>
               <a href="<?php echo url('/show-wishlist') ?>" class="cl-item">
                  <span class="lock-icon"><i class="fa fa-heart-o" aria-hidden="true"></i></span><span>Wishlist</span> (<span class="cl-number">0</span>)
               </a>
            <?php
        }


    }

    public function show_wishlist(Request $request){
        $meta_desc = "Your Wishlist";
        $meta_keywords="Your Wishlist";
        $meta_title="Your Wishlist";
        $meta_canonical= $request->url();
        $cate_product = DB::table('tbl_category_product')->where('category_status','1')->where('category_parent','0')->orderby('category_id','desc')->get(); 
        $brand_product = DB::table('tbl_brand')->where('brand_status','1')->orderby('brand_id','desc')->get();
   
        return view('pages.dashboard.wish_lish')->with('category',$cate_product)->with('brand',$brand_product)->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('meta_canonical',$meta_canonical);
    }

    public function show_wishlist_now(Request $request){
        $data = $request->all();
        $customer_id = Session::get('customer_id');
        // $wishlist_show=Wishlist::where('customer_id','=',$customer_id)->get();
        $wishlist_show = Product::whereHas('wishlistuser', function ($query) use ($customer_id) {
                        $query->where('tbl_wishlist.customer_id',$customer_id);
                    })->get();
        if (count($wishlist_show)>0) {
            ?>
                <table class="cl-tbl_wishlist shop_table_wl_responsive">
                   <thead>
                      <tr>
                         <th>Delete</th>
                         <th>Image</th>
                         <th>Product Name</th>
                         <th>Price</th>
                         <th></th>
                      </tr>
                   </thead>
                   <tbody>
                        <?php 
                            foreach($wishlist_show as $key => $wishlist){
                                ?>
                                  <tr>
                                     <td class="cl-remove_wl"> 
                                        <a data-row_id="<?php echo $wishlist->product_id ?>" class="cl-tooltip_top_right cl-delete-wl" data-cl-tooltip="Remove this item" style="cursor: pointer;"><i class="washabi-multiply"></i></a>
                                     </td>
                                     <td class="cl-img_pd_wl">
                                        <a href="<?php echo url('/detail-product/'.$wishlist->product_id) ?>" title="<?php echo $wishlist->product_name ?>">
                                            <img src="<?php echo url('public/uploads/product/'.$wishlist->product_image) ?>" alt="">
                                        </a>
                                     </td>
                                     <td class="cl-product_name_wl" data-title="Product Name: ">
                                        <a href="<?php echo url('/detail-product/'.$wishlist->product_id) ?>" title="<?php echo $wishlist->product_name ?>">
                                            <?php echo $wishlist->product_name ?>                  
                                        </a>
                                     </td>
                                     <td class="cl-product_price_wl" data-title="Price: ">
                                        <span class="cl-price">
                                          <ins class="cl-product-price">
                                            <span class="cl-money">
                                                <?php echo number_format($wishlist->product_price_promotion,0,',','.').' '.'VNĐ' ?>                   
                                            </span>
                                          </ins>
                                        </span>
                                     </td>
                                     <td>
                                        <a class="cl-btn_up_profile" href="<?php echo url('/detail-product/'.$wishlist->product_id) ?>">VIEW NOW</a>
                                     </td>
                                  </tr>
                               <?php  
                            }
                        ?>
                   </tbody>
                </table>
            <?php
        }else{
            ?>
                <div class="dashboard-error" style="margin-bottom: 150px">
                    There are currently no products to wishlist.
                </div>
            <?php
        }
    }

    public function delete_to_wishlist(Request $request){
        $customer_id = Session::get('customer_id');
        Wishlist::where('product_id',$request->row_id)->where('customer_id',$customer_id)->delete();
    }
}
