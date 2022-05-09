<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Http\Requests;
use App\Coupon;
use App\Color;
use App\Size;
use App\Customer;
use App\Product;
use App\Shipping;
use App\Order;
use App\OrderDetails;
use Carbon\Carbon;
use App\Payment;
use Cart;
use Mail;
use App\Feeship;
use Illuminate\Support\Facades\Redirect;
session_start();
class CartController extends Controller
{
    public function check_coupon(Request $request){
        $today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
        $data = $request->all();
        $coupon_expired = Coupon::where('coupon_code',$data['coupon'])->where('coupon_status',1)->where('coupon_date_end','>=',$today)->where('coupon_time','>',0)->where('coupon_used','LIKE','%'.Session::get('customer_id').'%')->first();
        if($coupon_expired){
          return redirect()->back()->with('error','You have already used this discount code, please enter another code');
        }
        else{
          $coupon = Coupon::where('coupon_code',$data['coupon'])->where('coupon_status',1)->where('coupon_date_end','>=',$today)->where('coupon_time','>',0)->first();
          if($coupon){
              $count_coupon = $coupon->count();
              if($count_coupon>0){
                  $coupon_session = Session::get('coupon');
                  if($coupon_session==true){
                      $is_avaiable = 0;
                      if($is_avaiable==0){
                          $cou[] = array(
                              'coupon_code' => $coupon->coupon_code,
                              'coupon_condition' => $coupon->coupon_condition,
                              'coupon_number' => $coupon->coupon_number,

                          );
                          Session::put('coupon',$cou);
                      }
                  }else{
                      $cou[] = array(
                              'coupon_code' => $coupon->coupon_code,
                              'coupon_condition' => $coupon->coupon_condition,
                              'coupon_number' => $coupon->coupon_number,

                          );
                      Session::put('coupon',$cou);
                  }
                  Session::save();
                  return redirect()->back()->with('message','Add coupon code successfully');
              }

          }else{
              return redirect()->back()->with('error','The discount code is incorrect or has expired');
          }
        }

    }  

    public function cart(Request $request){
         //seo 
        $meta_desc = "Your cart"; 
        $meta_keywords = "Cart Ajax";
        $meta_title = "Your Cart";
        $meta_canonical = $request->url();
        //--seo
        $cate_product = DB::table('tbl_category_product')->where('category_status','1')->where('category_parent','0')->orderby('category_id','desc')->get(); 
        $brand_product = DB::table('tbl_brand')->where('brand_status','1')->orderby('brand_id','desc')->get(); 

        return view('pages.cart.cart_ajax')->with('category',$cate_product)->with('brand',$brand_product)->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('meta_canonical',$meta_canonical);
    }

    public function add_cart_ajax(Request $request){
        $data = $request->all();
        $session_id = substr(md5(microtime()),rand(0,26),5);
        $cart = Session::get('cart');
        if($cart==true){
            $is_avaiable = 0;
            foreach($cart as $key => $val){
                if($val['product_id']==$data['cart_product_id']){
                    $is_avaiable++;

                }
            }
            if($is_avaiable == 0){
                $cart[] = array(
                    'session_id' => $session_id,
                    'product_name' => $data['cart_product_name'],
                    'product_id' => $data['cart_product_id'],
                    'product_image' => $data['cart_product_image'],
                    'product_qty' => $data['cart_product_qty'],
                    'product_price' => $data['cart_product_price'],
                );
                Session::put('cart',$cart);
            }
        }else{
            $cart[] = array(
                'session_id' => $session_id,
                'product_name' => $data['cart_product_name'],
                'product_id' => $data['cart_product_id'],
                'product_image' => $data['cart_product_image'],
                'product_qty' => $data['cart_product_qty'],
                'product_price' => $data['cart_product_price'],

            );
            Session::put('cart',$cart);
        }
       
        Session::save();

    }
    public function delete_product($session_id){
        $cart = Session::get('cart');
        // echo '<pre>';
        // print_r($cart);
        // echo '</pre>';
        if($cart==true){
            foreach($cart as $key => $val){
                if($val['session_id']==$session_id){
                    unset($cart[$key]);
                }
            }
            Session::put('cart',$cart);
            return redirect()->back()->with('message','Delete product successfully');

        }else{
            return redirect()->back()->with('message','Delete product not successfully');
        }

    }

    public function delete_all_product(){
        $cart = Session::get('cart');
        if($cart==true){
            // Session::destroy();
            Session::forget('cart');
            return redirect()->back()->with('message','Delete cart successfully');
        }
    }

    public function update_cart(Request $request){
        $data = $request->all();
        $cart = Session::get('cart');
        if($cart==true){
            foreach($data['cart_qty'] as $key => $qty){
                foreach($cart as $session => $val){
                    if($val['session_id']==$key){
                        $cart[$session]['product_qty'] = $qty;
                    }
                }
            }
            Session::put('cart',$cart);
            return redirect()->back()->with('messagecartajax','Updated number successfully');
        }else{
            return redirect()->back()->with('messagecartajax','Updated number not successfully');
        }
    }


    public function save_cart(Request $request){
        $data = array();
        $productId = $request->cart_product_id;
        $quantity = $request->cart_product_qty;
        $Size_id = $request->cart_product_size;
        $Color_id = $request->cart_product_color;
        
        $check = Product::find($productId);
        $product_qty = $check->product_qty;
        $asd = Cart::content()->where('id', $productId);
        $quantitytol   = 0;
        $totalquantity = 0;
        if($Size_id =='no' && $Color_id =='no'){

            if (count($asd)>0) {
                foreach($asd as $content){
                    if($quantity <= $product_qty-$content->qty){
                      $product_info                  = DB::table('tbl_product')->where('product_id',$productId)->first();
                      $data['id']                    = $product_info->product_id;
                      $data['qty']                   = $quantity;
                      $data['name']                  = $product_info->product_name;
                      $data['price']                 = ($product_info->product_price-($product_info->product_price*$product_info->product_promotion/100));
                      $data['weight']                = $product_info->product_promotion;
                      $data['options']['image']      = $product_info->product_image;
                      $data['options']['size_id']    = $Size_id;
                      $data['options']['color_id']   = $Color_id;
                      $data['options']['size_name']  = $Size_id;
                      $data['options']['color_name'] = $Color_id;
                      Cart::add($data);
                    }else{
                        return response(['message'=>'Do not add more than the quantity of the product.']);
                    }
                }
            }else{
              $product_info                  = DB::table('tbl_product')->where('product_id',$productId)->first();
              $data['id']                    = $product_info->product_id;
              $data['qty']                   = $quantity;
              $data['name']                  = $product_info->product_name;
              $data['price']                 = ($product_info->product_price-($product_info->product_price*$product_info->product_promotion/100));
              $data['weight']                = $product_info->product_promotion;
              $data['options']['image']      = $product_info->product_image;
              $data['options']['size_id']    = $Size_id;
              $data['options']['color_id']   = $Color_id;
              $data['options']['size_name']  = $Size_id;
              $data['options']['color_name'] = $Color_id;
              Cart::add($data);
            }
        }elseif($Size_id =='no'){
            if (count($asd)>0) {

                foreach($asd as $content){
                    $quantitytol+=$content->qty;
                }
                $totalquantity = $quantitytol;
                if($quantity <= $product_qty-$totalquantity){
                  $product_info                  = DB::table('tbl_product')->where('product_id',$productId)->first();
                  $product_color                 = Color::where('color_id',$Color_id)->first(); 
                  $data['id']                    = $product_info->product_id;
                  $data['qty']                   = $quantity;
                  $data['name']                  = $product_info->product_name;
                  $data['price']                 = ($product_info->product_price-($product_info->product_price*$product_info->product_promotion/100));
                  $data['weight']                = $product_info->product_promotion;
                  $data['options']['image']      = $product_info->product_image;
                  $data['options']['size_id']    = $Size_id;
                  $data['options']['color_id']   = $product_color->color_id;
                  $data['options']['size_name']  = $Size_id;
                  $data['options']['color_name'] = $product_color->color_name;
                  Cart::add($data);
                }else{
                    return response(['message'=>'Do not add more than the quantity of the product.']);
                }
            }else{
              $product_info                  = DB::table('tbl_product')->where('product_id',$productId)->first();
              $product_color                 = Color::where('color_id',$Color_id)->first(); 
              $data['id']                    = $product_info->product_id;
              $data['qty']                   = $quantity;
              $data['name']                  = $product_info->product_name;
              $data['price']                 = ($product_info->product_price-($product_info->product_price*$product_info->product_promotion/100));
              $data['weight']                = $product_info->product_promotion;
              $data['options']['image']      = $product_info->product_image;
              $data['options']['size_id']    = $Size_id;
              $data['options']['color_id']   = $product_color->color_id;
              $data['options']['size_name']  = $Size_id;
              $data['options']['color_name'] = $product_color->color_name;
              Cart::add($data);
            }
        }elseif($Color_id == 'no'){
            if (count($asd)>0) {
                foreach($asd as $content){
                    $quantitytol+=$content->qty;
                }
                $totalquantity = $quantitytol;
                if($quantity <= $product_qty-$totalquantity){
                      $product_info                  = DB::table('tbl_product')->where('product_id',$productId)->first();
                      $product_size                  = Size::where('size_id',$Size_id)->first(); 
                      $data['id']                    = $product_info->product_id;
                      $data['qty']                   = $quantity;
                      $data['name']                  = $product_info->product_name;
                      $data['price']                 = ($product_info->product_price-($product_info->product_price*$product_info->product_promotion/100));
                      $data['weight']                = $product_info->product_promotion;
                      $data['options']['image']      = $product_info->product_image;
                      $data['options']['size_id']    = $product_size->size_id;
                      $data['options']['color_id']   = $Color_id;
                      $data['options']['size_name']  = $product_size->size_name;
                      $data['options']['color_name'] = $Color_id;
                      Cart::add($data);
                    }else{
                        return response(['message'=>'Do not add more than the quantity of the product.']);
                    }
            }else{
              $product_info                  = DB::table('tbl_product')->where('product_id',$productId)->first();
              $product_size                  = Size::where('size_id',$Size_id)->first(); 
              $data['id']                    = $product_info->product_id;
              $data['qty']                   = $quantity;
              $data['name']                  = $product_info->product_name;
              $data['price']                 = ($product_info->product_price-($product_info->product_price*$product_info->product_promotion/100));
              $data['weight']                = $product_info->product_promotion;
              $data['options']['image']      = $product_info->product_image;
              $data['options']['size_id']    = $product_size->size_id;
              $data['options']['color_id']   = $Color_id;
              $data['options']['size_name']  = $product_size->size_name;
              $data['options']['color_name'] = $Color_id;
              Cart::add($data);
            }
        }else{
            if (count($asd)>0) {
                foreach($asd as $content){
                    $quantitytol+=$content->qty;
                }
                $totalquantity = $quantitytol;
                if($quantity <= $product_qty-$totalquantity){
                  $product_info                  = DB::table('tbl_product')->where('product_id',$productId)->first();
                  $product_size                  = Size::where('size_id',$Size_id)->first(); 
                  $product_color                 = Color::where('color_id',$Color_id)->first(); 
                  $data['id']                    = $product_info->product_id;
                  $data['qty']                   = $quantity;
                  $data['name']                  = $product_info->product_name;
                  $data['price']                 = ($product_info->product_price-($product_info->product_price*$product_info->product_promotion/100));
                  $data['weight']                = $product_info->product_promotion;
                  $data['options']['image']      = $product_info->product_image;
                  $data['options']['size_id']    = $product_size->size_id;
                  $data['options']['color_id']   = $product_color->color_id;
                  $data['options']['size_name']  = $product_size->size_name;
                  $data['options']['color_name'] = $product_color->color_name;
                  Cart::add($data);
                }else{
                    return response(['message'=>'Do not add more than the quantity of the product.']);
                }
            }else{
              $product_info                  = DB::table('tbl_product')->where('product_id',$productId)->first();
              $product_size                  = Size::where('size_id',$Size_id)->first(); 
              $product_color                 = Color::where('color_id',$Color_id)->first(); 
              $data['id']                    = $product_info->product_id;
              $data['qty']                   = $quantity;
              $data['name']                  = $product_info->product_name;
              $data['price']                 = ($product_info->product_price-($product_info->product_price*$product_info->product_promotion/100));
              $data['weight']                = $product_info->product_promotion;
              $data['options']['image']      = $product_info->product_image;
              $data['options']['size_id']    = $product_size->size_id;
              $data['options']['color_id']   = $product_color->color_id;
              $data['options']['size_name']  = $product_size->size_name;
              $data['options']['color_name'] = $product_color->color_name;
              Cart::add($data); 
            }
        }
    }

    public function hover_cart(Request $request){
        $cart = count(Cart::content());
        if($cart>0){
              $total = 0;
              $qty = 0;
            ?>
                <?php
                    if (url('/show-cart')==$request->url) {
                        ?>
                            <a class="icon-link active">
                              <i class="fa fa-shopping-bag" aria-hidden="true"></i>
                              <span class="cl-number cl-beamer_bounce "><?php echo Cart::count() ?></span>
                            </a>
                        <?php
                    }else{
                        ?>
                            <a href="<?php echo url('/show-cart') ?>" class="icon-link" >
                              <i class="fa fa-shopping-bag" aria-hidden="true"></i>
                              <span class="cl-number cl-beamer_bounce "><?php echo Cart::count() ?></span>
                            </a>
                        <?php
                    }
                ?>

                <div class="cart-hover">
                    <div class="change-item-cart">
                      <div class="select-items">
                          <table>
                              <tbody>
                                    <?php
                                        foreach (Cart::content() as $item) {
                                            $subtotal = $item->price * $item->qty;
                                            $total+=$subtotal;
                                            $qty+=$item->qty;
                                            ?>
                                              <tr>
                                                <td class="si-pic" style="width: 20%;"><img src="<?php echo url('public/uploads/product/'.$item->options->image) ?>" alt=""></td>
                                                  <td class="si-text" style="width: 80%; vertical-align: top;">
                                                      <div class="product-selected">
                                                          <h6><?php echo $item->name ?></h6>
                                                          <p class="cl-atrribute-cart">
                                                            <?php
                                                              if($item->options->color_id == 'no' && $item->options->size_id != 'no'){
                                                                ?>
                                                                  <strong>Size: </strong><?php echo $item->options->size_name ?>
                                                                <?php
                                                              }elseif($item->options->size_id == 'no' && $item->options->color_id != 'no'){
                                                                ?>
                                                                  <strong>Color: </strong> <?php echo $item->options->color_name ?>
                                                                <?php
                                                              }elseif($item->options->size_id == 'no' && $item->options->color_id == 'no'){
                                                                echo '';
                                                              }else{
                                                                ?>
                                                                  <strong>Color: </strong> <?php echo $item->options->color_name ?> / <strong>Size: </strong> <?php echo $item->options->size_name ?>
                                                                <?php
                                                              }    
                                                            ?>                                                              
                                                          </p>
                                                          <p class="cl-name_product-cart"><?php echo number_format($item->price,0,',','.').' '.'VNĐ' ?> x <?php echo $item->qty ?></p>
                                                      </div>
                                                  </td>
                                              </tr>
                                            <?php
                                        }
                                    ?>
                              </tbody>
                          </table>
                      </div>
                      <div class="select-total">
                          <span>total:</span>
                          <h5><?php echo number_format($total+($total*0.1),0,',','.')." "."VNĐ" ?></h5>
                      </div>

                    </div>
                    <div class="select-button">
                        <a href="<?php echo url('/show-cart') ?>" class="primary-btn view-card">VIEW CART</a>
                       <?php
                          $customer_id = Session::get('customer_id');
                           if($customer_id!=NULL){ 
                              ?>
                                <a href="<?php echo url('/checkout') ?>" class="primary-btn checkout-btn">CHECK OUT</a>

                              <?php
                           }else{
                               ?>
                                    <a href="<?php echo url('/login-checkout') ?>" class="primary-btn checkout-btn">CHECK OUT</a>

                               <?php 
                           }
                       ?> 
                    </div>  
                </div>
            <?php
        }else{
           ?>
                <?php
                    if (url('/show-cart')==$request->url) {
                        ?>
                            <a class="icon-link active">
                              <i class="fa fa-shopping-bag" aria-hidden="true"></i>
                              <span class="cl-number">0</span>
                            </a>
                        <?php
                    }else{
                        ?>
                            <a href="<?php echo url('/show-cart') ?>" class="icon-link">
                              <i class="fa fa-shopping-bag" aria-hidden="true"></i>
                              <span class="cl-number">0</span>
                            </a>
                        <?php
                    }
                ?>

              <div class="cart-hover" style="text-align: center; line-height: normal;">
                 <img src="<?php echo url('public/frontend/images/cartempty.png') ?>" alt="<?php echo url('public/frontend/images/cartempty.png') ?>" style="width: 100px">

                  <div class="change-item-cart" style="text-align: center; font-size: 16px; line-height: normal;">
                      <span>Your cart is empty.</span>
                  </div>
              </div>
           <?php 
        }
    }



    public function show_cart(Request $request){
        $meta_desc = "Cart";
        $meta_keywords="Cart";
        $meta_title="Cart";
        $meta_canonical= $request->url();
        $cate_product = DB::table('tbl_category_product')->where('category_status','1')->where('category_parent','0')->orderby('category_id','desc')->get(); 
        $brand_product = DB::table('tbl_brand')->where('brand_status','1')->orderby('brand_id','desc')->get();
   
        return view('pages.cart.show_cart')->with('category',$cate_product)->with('brand',$brand_product)->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('meta_canonical',$meta_canonical);
    }

    public function show_cart_now(Request $request){
        $cart = count(Cart::content());
        $output =''.csrf_field().'';

        if($cart>0){
            $total = 0;
            $qty = 0;
            $count=0;
            ?>
                   <div class="row">
                      <div class="col-md-12 col-lg-8">
                         <div class="table-responsive">
                            <table class="shop_table cart table table-bordered table-customize">
                               <thead>
                                  <tr>
                                     <th class="product-price">NO</th>
                                     <th colspan="" class="product-name">Product</th>
                                     <th class="product-price">Price</th>
                                     <th class="product-quantity">Qty</th>
                                     <th class="product-subtotal">Total</th>
                                     <th class="product-remove">Delete</th>
                                  </tr>
                               </thead>
                               <tbody>
                                    <?php
                                        foreach (Cart::content() as $v_content) {
                                              $count++;
                                              $subtotal = $v_content->price * $v_content->qty;
                                              $total+=$subtotal;
                                              $qty+=$v_content->qty;
                                            ?>
                                              <tr>
                                                 <td colspan="" rowspan="" headers=""><?php echo $count; ?></td>
                                                 <td class="product-thumbnail">
                                                    <div class="cl-cart_thumbnail-content">
                                                       <a href="<?php echo url('/detail-product/'.$v_content->id) ?>" class="cl-cart_thumbnail-left">
                                                       <img src="<?php echo url('public/uploads/product/'.$v_content->options->image) ?>" alt="<?php echo $v_content->name ?>">
                                                       </a>
                                                       <div class="cl-cart_thumbnail-right">
                                                          <p class="cl-title" style="white-space: nowrap;"><span>Name:</span> <?php echo $v_content->name ?></p>
                                                          <?php
                                                            if($v_content->options->color_id == 'no' && $v_content->options->size_id != 'no'){
                                                              ?>
                                                                <p class="cl-title"><span>Size:</span> <?php echo $v_content->options->size_name ?></p>
                                                              <?php
                                                            }elseif($v_content->options->size_id == 'no' && $v_content->options->color_id != 'no'){
                                                              ?>
                                                                <p class="cl-title"><span>Color:</span> <?php echo $v_content->options->color_name ?></p>
                                                              <?php
                                                            }elseif($v_content->options->size_id == 'no' && $v_content->options->color_id == 'no'){
                                                              echo '';
                                                            }else{
                                                              ?>
                                                                <p class="cl-title"><span>Color:</span> <?php echo $v_content->options->color_name ?></p>
                                                                <p class="cl-title"><span>Size:</span> <?php echo $v_content->options->size_name ?></p>
                                                              <?php
                                                            }  
                                                          ?>

                                                       </div>
                                                    </div>
                                                 </td>
                                                 <td>
                                                    <?php echo number_format($v_content->price,0,',','.').' '.'VNĐ' ?>                                   
                                                 </td>
                                                 <td>
                                                      <form >
                                                            <?php echo $output ?>
                                                         <input type="hidden" value="<?php echo $v_content->rowId ?>" name="rowId_cart" class="form-control upRowId_<?php echo $v_content->rowId ?>">
                                                         <input type="hidden" value="<?php echo $v_content->id ?>" class="form-control upRowidproduct_<?php echo $v_content->id ?>">

                                                         <div class="cl-box-quantity-cart">
                                                            <button type="button" class="cl-bt-qty minus bt_minus_<?php echo $v_content->rowId ?>">-</button>
                                                            <input class="qty-box cart_quantity_item_<?php echo $v_content->rowId ?>" type="text" name="cart_quantity" value="<?php echo $v_content->qty ?>" min="">
                                                            <button type="button" class="cl-bt-qty plus bt_plus_<?php echo $v_content->rowId ?>">+</button>
                                                         </div>
                                                      </form>
                                                 </td>
                                                 <td>                  
                                                    <?php echo number_format($subtotal,0,',','.')." "."VNĐ" ?>
                                                 </td>
                                                 <td class="product-remove">
                                                    <a data-row_id="<?php echo $v_content->rowId ?>" class="btn btn-xs btn-danger delete-cart"><i class="xoa far fa fa-trash-o "></i></a>
                                                 </td>
                                              </tr>
                                            <?php
                                        }
                                    ?>

                               </tbody>
                            </table>
                         </div>
                      </div>
                      <div class="col-md-12 col-lg-4">
                         <div class="box-cart-total">
                            <h2 class="title">Cart Totals</h2>
                            <table>
                               <tbody>
                                  <tr>
                                     <td>Subtotal</td>
                                     <td>
                                        <span class="price">
                                            <?php echo number_format($total,0,',','.')." "."VNĐ" ?>
                                        </span>
                                     </td>
                                  </tr>
                                  <tr>
                                     <td>Total quantity</td>
                                     <td>
                                        <span class="price">
                                            <?php echo number_format($qty) ?>
                                        </span>
                                     </td>
                                  </tr>
                                  <tr>
                                     <td>Tax</td>
                                     <td>
                                        <span class="price">
                                        10%(
                                             <?php
                                                $vat = $total*0.1;
                                                echo number_format($vat,0,',','.').' '."VNĐ";
                                             ?>
                                        )
                                        </span>
                                     </td>
                                  </tr>
                                  <tr class="order-total">
                                     <td>Total</td>
                                     <td>
                                        <span class="price"> 
                                         <?php
                                           $totalvat = $total + $total*0.1;
                                           echo number_format($totalvat,0,',','.').' '."VNĐ";
                                         ?>                               
                                        </span>
                                     </td>
                                  </tr>
                               </tbody>
                            </table>
                         <?php
                            $customer_id = Session::get('customer_id');
                             if($customer_id!=NULL){ 
                                ?>
                                    <a href="<?php echo url('/checkout') ?>" class="button medium update-cartbutton">Check out</a>
                                <?php
                             }else{
                                 ?>
                                    <a href="<?php echo url('/login-checkout') ?>" class="button medium update-cartbutton">Check out</a>
                                 <?php 
                             }
                         ?>                                 
                         <a href="<?php echo url('/') ?>" class="button medium checkout-button">Continue Shopping</a>
                         </div>
                      </div>
                   </div>
            <?php
        }else{
            Session::forget('fee');
            Session::forget('coupon'); 
            ?>
              <div style="text-align: center;">
                   <img src="<?php echo url('public/frontend/images/cartempty.png') ?>" alt="<?php echo url('public/frontend/images/cartempty.png') ?>" style="width: 250px">
                    <p style="
                        color: #000;
                        font-size: 20px;
                        font-weight: 600;
                    ">
                        Your Cart is empty.
                    </p>
              </div>
            <?php
        }     
    }

    // public function delete_to_cart($rowId){
    //     Cart::update($rowId,0);
    //     return Redirect::to('/show-cart');
    // }

    public function delete_to_cart(Request $request){
        Cart::update($request->row_id,0);
    }

    public function update_cart_quantity(Request $request){
        $check = Product::find($request->upRowIdproduct);
        $product_qty = $check->product_qty;
        // $asd = Cart::content()->where('id', $request->upRowIdproduct);
        // $quantitytol   = 0;
        // $totalquantity = 0;
        // foreach($asd as $content){
        //     $quantitytol+=$content->qty;
        // }
        // $totalquantity = $quantitytol;
        if($request->newQty <= $product_qty){
            $rowId = $request->upRowId;
            $qty = $request->newQty;
            Cart::update($rowId,$qty);
            return redirect()->back();
        }else{
            return response(['message'=>'Do not add more than the quantity of the product.']);
        }
    }

    public function createPayment(Request $request){
      $vnp_TxnRef = substr(md5(microtime()),rand(0,26),10); 
      $vnp_OrderInfo = $request->order_desc;
      $vnp_OrderType = $request->order_type;
      $vnp_Amount = str_replace(",","", $request->amount) * 100;
      $vnp_Locale = $request->language;
      $vnp_BankCode = $request->bank_code;
      $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
      $inputData = array(
          "vnp_Version" => "2.0.0",
          "vnp_TmnCode" => env('VNP_TMN_CODE'),
          "vnp_Amount" => $vnp_Amount,
          "vnp_Command" => "pay",
          "vnp_CreateDate" => date('YmdHis'),
          "vnp_CurrCode" => "VND",
          "vnp_IpAddr" => $vnp_IpAddr,
          "vnp_Locale" => $vnp_Locale,
          "vnp_OrderInfo" => $vnp_OrderInfo,
          "vnp_OrderType" => $vnp_OrderType,
          "vnp_ReturnUrl" => route('vnpay.return'),
          "vnp_TxnRef" => $vnp_TxnRef,
      );

      if (isset($vnp_BankCode) && $vnp_BankCode != "") {
          $inputData['vnp_BankCode'] = $vnp_BankCode;
      }
      ksort($inputData);
      $query = "";
      $i = 0;
      $hashdata = "";
      foreach ($inputData as $key => $value) {
          if ($i == 1) {
              $hashdata .= '&' . $key . "=" . $value;
          } else {
              $hashdata .= $key . "=" . $value;
              $i = 1;
          }
          $query .= urlencode($key) . "=" . urlencode($value) . '&';
      }

      $vnp_Url = env('VNP_URL') . "?" . $query;
      if (env('VNP_HASH_SECRET')) {
         // $vnpSecureHash = md5($vnp_HashSecret . $hashdata);
          $vnpSecureHash = hash('sha256', env('VNP_HASH_SECRET') . $hashdata);
          $vnp_Url .= 'vnp_SecureHashType=SHA256&vnp_SecureHash=' . $vnpSecureHash;
      }

      return redirect($vnp_Url);

    }

    public function vnpayReturn(Request $request){
        $info_customer = Session::get('info_customer');
        $customer_id   = Session::get('customer_id');
        if ($info_customer && $request->vnp_ResponseCode == '00') {
            $vnpayData = $request->all();
            foreach($info_customer as $key => $info){
                $order_coupon     = $info['order_coupon'];
                $product_feeship  = $info['order_fee'];
                $shipping_name    = $info['shipping_name'];
                $shipping_email   = $info['shipping_email'];
                $shipping_phone   = $info['shipping_phone'];
                $shipping_address = $info['shipping_address'];
                $shipping_note    = $info['shipping_note'];
                $shipping_method  = $info['shipping_method'];
            }
            $today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d h:i:s');

            $shipping = new Shipping();
            $shipping->shipping_name    = $shipping_name;
            $shipping->shipping_email   = $shipping_email;
            $shipping->shipping_phone   = $shipping_phone;
            $shipping->shipping_address = $shipping_address;
            $shipping->shipping_note    = $shipping_note;
            $shipping->shipping_method  = $shipping_method;
            $shipping->save();
            $shipping_id = $shipping->shipping_id;

            $payment = new Payment();
            $payment->p_transaction_id    = $shipping_id;
            $payment->customer_id         = $customer_id;
            $payment->p_transection_code  = $vnpayData['vnp_TxnRef'];
            $payment->p_money             = $vnpayData['vnp_Amount']/100;
            $payment->p_note              = $vnpayData['vnp_OrderInfo'];
            $payment->p_vnp_response_code = $vnpayData['vnp_ResponseCode'];
            $payment->p_code_vnpay        = $vnpayData['vnp_TransactionNo'];
            $payment->p_code_bank         = $vnpayData['vnp_BankCode'];
            $payment->time = $today;

            $payment->save();

            if($order_coupon!='no'){
                $coupon = Coupon::where('coupon_code',$order_coupon)->first();
                $coupon->coupon_used = $coupon->coupon_used.','.Session::get('customer_id');
                $coupon->coupon_time = $coupon->coupon_time - 1;
                $coupon_mail = $coupon->coupon_code;
                $coupon->save();
            }else {
                $coupon_mail = 'No discount code';
            }

            $order = new Order;
            $order->customer_id = $customer_id;
            $order->shipping_id = $shipping_id;
            $order->order_status = 1;
            $order->order_code = $vnpayData['vnp_TxnRef'];
            $order->created_at = $today;
            $order->order_date = $today;
            $order->save();

            $content = Cart::content();
            foreach($content as $v_content){
                $order_details = new OrderDetails;
                $order_details->order_code             = $vnpayData['vnp_TxnRef'];
                $order_details->product_id             = $v_content->id;
                $order_details->product_name           = $v_content->name;
                $order_details->product_color          = $v_content->options->color_name;
                $order_details->product_size           = $v_content->options->size_name;
                $order_details->product_price          = $v_content->price;
                $order_details->product_sales_quantity = $v_content->qty;
                $order_details->product_coupon         = $order_coupon;
                $order_details->product_feeship        = $product_feeship;
                $order_details->save();
            }

            foreach($content as $v_content){
                $cart_id = $v_content->id;
                $product = Product::find($cart_id);
                $product_quantity = $product->product_qty;
                $product_sold = $product->product_sold;
                if($cart_id == $product->product_id){
                    $pro_remain            = $product_quantity - $v_content->qty;
                    $product->product_qty  = $pro_remain;
                    $product->product_sold = $product_sold + $v_content->qty;
                    $product->save();
                }
            }

            $now = Carbon::now('Asia/Ho_Chi_Minh')->format('H:i:s d/m/Y');

            $title_mail = "You placed an order at".' '.$now;

            $customer = Customer::find(Session::get('customer_id'));
                  
            $data['email'][] = $customer->customer_email;

            if(count($content)>0){

                foreach($content as $v_content){

                  $cart_array[] = array(
                    'product_name'  => $v_content->name,
                    'product_color' => $v_content->options->color_name,
                    'product_size'  => $v_content->options->size_name,
                    'product_price' => $v_content->price,
                    'product_qty'   => $v_content->qty
                  );

                }

            }

            //lay shipping
            if(Session::get('fee')==true){
                $fee = Session::get('fee');
            }else{
                $fee = '25';
            }

            $shipping_array = array(
                'fee' =>  $fee,
                'customer_name' => $customer->customer_name,
                'shipping_name' => $shipping_name,
                'shipping_email' => $shipping_email,
                'shipping_phone' => $shipping_phone,
                'shipping_address' => $shipping_address,
                'shipping_note' => $shipping_note,
                'shipping_method' => $shipping_method
            );

            //lay ma giam gia, lay coupon code
            $ordercode_mail = array(
                'coupon_code' => $coupon_mail,
                'order_code' => $vnpayData['vnp_TxnRef'],
            );

            Mail::send('pages.mail.mail_order',  ['cart_array'=>$cart_array, 'shipping_array'=>$shipping_array ,'code'=>$ordercode_mail] , function($message) use ($title_mail,$data){
                $message->to($data['email'])->subject($title_mail);//send this mail with subject
                $message->from($data['email'],$title_mail);//send from this mail
            });

            Session::forget('coupon');
            Session::forget('fee');
            Cart::destroy();
            return Redirect::to('/history-order');
        }elseif($info_customer && $request->vnp_ResponseCode != '00'){
            return Redirect::to('/checkout');
        }
    }
}
