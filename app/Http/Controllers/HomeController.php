<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Http\Requests;
use App\Gallery;
use App\Product;
use Illuminate\Support\Facades\Redirect;
use App\Slider;
session_start();

class HomeController extends Controller
{
    
    public function index(Request $request){
        $meta_desc = "Chuyên bán quần áo đẹp và chất lượng";
        $meta_keywords="Quần áo nam";
        $meta_title="Wild";
        $meta_canonical= $request->url();
        //--seo
    	$cate_product = DB::table('tbl_category_product')->where('category_status','1')->where('category_parent','0')->orderby('category_id','DESC')->get(); 
        $brand_product = DB::table('tbl_brand')->where('brand_status','1')->orderby('brand_id','DESC')->get(); 


        
      $sale_product = DB::table('tbl_product')->where('product_status','1')->where('product_promotion','>','0')->orderby('product_id','DESC')->get(); 

      $best_sellers = DB::table('tbl_product')->where('product_status','1')->where('product_sold','>','0')->orderby('product_sold','DESC')->get(); 

      $new_items = DB::table('tbl_product')->where('product_status','1')->orderby('product_id','DESC')->take(8)->get(); 

      $slider = Slider::where('slider_status','1')->orderBy('slider_id','ASC')->get();


    	return view('pages.home')->with('category',$cate_product)->with('brand',$brand_product)->with('sale_product',$sale_product)->with('best_sellers',$best_sellers)->with('new_items',$new_items)->with('slider',$slider)->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('meta_canonical',$meta_canonical);
    }

    public function search_ajax(Request $request){
        $keywords             = $request->name;
        $search_product       = product::where('product_name','like','%'.$keywords.'%')
                                ->orWhere('product_price_promotion','like','%'.$keywords.'%')
                                ->take(12)->get();
        $count_search_product = product::where('product_name','like','%'.$keywords.'%')
                                ->orWhere('product_price_promotion','like','%'.$keywords.'%')
                                ->count();
        $count_product        = count($search_product);

        if ($count_product>0) {
            foreach ($search_product as $result) {
                ?>
                    <a class="item-search" href="<?php echo url('/detail-product/'.$result->product_id) ?>">
                       <div class="item-thumb">
                          <img src="<?php echo url('public/uploads/product/'.$result->product_image) ?>" alt="" class="item-pic">
                       </div>
                       <div class="item-infor">
                          <div>
                            <?php
                              if ($result['product_qty']<=0) {
                                ?>
                                  <span class="item-sticker sticker-soldout">Sold Out</span>
                                <?php
                              }else {
                                if ($result['product_promotion']<=0 || $result['product_promotion']=='') {
                                  echo '';
                                }else {
                                  ?>
                                    <span class="item-sticker sticker-sale">Sale <?php echo $result['product_promotion']; ?> %</span>
                                  <?php
                                }
                              }
                            ?>
                          </div>
                          <div class="cl-product-name"><?php echo $result->product_name ?></div>
                            <div>
                               <?php
                                  if ($result['product_qty'] <= 0) {
                                    ?>
                                       <div class="cl-out_stock_pr">
                                          <span>Out of Stock</span>
                                       </div>
                                    <?php
                                  }else {
                                    ?>
                                       <span class="cl-price">
                                           <?php
                                              if ($result['product_promotion']=="" || $result['product_promotion']==0){
                                                echo '';
                                              }else {
                                                ?>
                                                <ins class="cl-ProductPrice" style="color: #cf0f0f">
                                                   <span class="cl-money">
                                                        <?php
                                                            $compare_price = ($result['product_price'])-($result['product_price']*$result['product_promotion']/100);
                                                          echo number_format($compare_price,0,',','.').' '."VNĐ";
                                                        ?>
                                                   </span>
                                                </ins>
                                                <?php
                                              }
                                            ?>
                                           <?php
                                              if ($result['product_promotion']=="" || $result['product_promotion']==0) {
                                                ?>
                                                    <ins class="cl-ProductPrice" >
                                                        <span class="cl-money"><?php echo number_format($result['product_price'],0,',','.')." "."VNĐ"; ?></span>
                                                    </ins>
                                                <?php
                                              }else {
                                                ?>
                                                   <del class="cl-ProductPrice">
                                                        <span class="cl-money"><?php echo number_format($result['product_price'],0,',','.')." "."VNĐ"; ?></span>
                                                   </del>
                                               <?php
                                              }
                                              ?>
                                       </span>
                                   <?php
                                  }
                                ?>
                            </div>
                       </div>
                    </a>
                <?php
            }
        }else{
            ?>
                <div class="cl-no-result">
                    <span>Your search did not yield any results.</span>
                </div>
            <?php
        }

      if ($count_search_product >= 12) {
        ?>

          <div class="cl-button-see-all">
            <button type="submit" class="cl-see_all_pd-search"><u>See all results <?php echo $count_search_product; ?></u></button>
          </div>
        <?php
      }else {
        echo '';
      }
    }

    public function search(Request $request){

        $meta_desc      = "Search product"; 
        $meta_keywords  = "Search product";
        $meta_title     = "Search product";
        $meta_canonical  = $request->url();
        //--seo
        $keywords       = $request->keywords;

        $cate_product   = DB::table('tbl_category_product')->where('category_status','1')->where('category_parent','0')->orderby('category_id','desc')->get(); 
        $brand_product  = DB::table('tbl_brand')->where('brand_status','1')->orderby('brand_id','desc')->get(); 

        $search_product = product::where('product_name','like','%'.$keywords.'%')->orWhere('product_price_promotion','like','%'.$keywords.'%')->paginate(12)->appends(request()->query()); 
        $count_search_product = product::where('product_name','like','%'.$keywords.'%')->orWhere('product_price_promotion','like','%'.$keywords.'%')->count();


        return view('pages.search.search')->with('category',$cate_product)->with('brand',$brand_product)->with('search_product',$search_product)->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('meta_canonical',$meta_canonical)->with('keywords',$keywords)->with('count_search_product',$count_search_product);

    }
}
