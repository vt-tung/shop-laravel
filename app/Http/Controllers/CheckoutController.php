<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use Cart;
use Carbon\Carbon;
use Mail;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();
use App\City;
use App\Province;
use App\Wards;
use App\Feeship;
use App\Product;
use App\Coupon;
use App\Customer;
use App\Shipping;
use App\Order;
use App\OrderDetails;
class CheckoutController extends Controller
{
    public function AuthLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }

    public function confirm_order(Request $request){
        $meta_desc = "VNPAY";
        $meta_keywords="VNPAY";
        $meta_title="VNPAY";
        $meta_canonical= $request->url();
        $data = $request->all();
        if ($data['shipping_method']==0) {
            $totalMoney = $data['total_pay'];
            $info_customer = Session::get('info_customer');
            if($info_customer==true){
                $is_avaiable = 0;
                if($is_avaiable==0){
                    $info[] = array(
                        'order_fee' => $data['order_fee'],
                        'order_coupon' => $data['order_coupon'],
                        'total_pay' => $data['total_pay'],
                        'shipping_email' => $data['shipping_email'],
                        'shipping_name' => $data['shipping_name'],
                        'shipping_phone' => $data['shipping_phone'],
                        'shipping_address' => $data['shipping_address'],
                        'shipping_note' => $data['shipping_note'],
                        'shipping_method' => $data['shipping_method'],
                    );
                    Session::put('info_customer',$info);
                }
            }else{
                $info[] = array(
                    'order_fee' => $data['order_fee'],
                    'order_coupon' => $data['order_coupon'],
                    'total_pay' => $data['total_pay'],
                    'shipping_email' => $data['shipping_email'],
                    'shipping_name' => $data['shipping_name'],
                    'shipping_phone' => $data['shipping_phone'],
                    'shipping_address' => $data['shipping_address'],
                    'shipping_note' => $data['shipping_note'],
                    'shipping_method' => $data['shipping_method'],
                );
                Session::put('info_customer',$info);
            }
            Session::save();

            $cate_product = DB::table('tbl_category_product')->where('category_status','1')->where('category_parent','0')->orderby('category_id','desc')->get(); 
            $brand_product = DB::table('tbl_brand')->where('brand_status','1')->orderby('brand_id','desc')->get(); 


            return view('pages.vnpay.index')->with('totalMoney',$totalMoney)->with('category',$cate_product)->with('brand',$brand_product)->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('meta_canonical',$meta_canonical);
        }else{
            if($data['order_coupon']!='no'){
                $coupon = Coupon::where('coupon_code',$data['order_coupon'])->first();
                $coupon->coupon_used = $coupon->coupon_used.','.Session::get('customer_id');
                $coupon->coupon_time = $coupon->coupon_time - 1;
                $coupon_mail = $coupon->coupon_code;
                $coupon->save();
            }else {
                $coupon_mail = 'No discount code';
            }

            $shipping = new Shipping();
            $shipping->shipping_name    = $data['shipping_name'];
            $shipping->shipping_email   = $data['shipping_email'];
            $shipping->shipping_phone   = $data['shipping_phone'];
            $shipping->shipping_address = $data['shipping_address'];
            $shipping->shipping_note    = $data['shipping_note'];
            $shipping->shipping_method  = $data['shipping_method'];
            $shipping->save();
            $shipping_id = $shipping->shipping_id;

            $checkout_code = substr(md5(microtime()),rand(0,26),10);

            $order = new Order;
            $order->customer_id = Session::get('customer_id');
            $order->shipping_id = $shipping_id;
            $order->order_status = 1;
            $order->order_code = $checkout_code;

            $today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d h:i:s');
            $order->created_at = $today;
            $order->order_date = $today;
            $order->save();

            $content = Cart::content();
            foreach($content as $v_content){
                $order_details = new OrderDetails;
                $order_details->order_code             = $checkout_code;
                $order_details->product_id             = $v_content->id;
                $order_details->product_name           = $v_content->name;
                $order_details->product_color          = $v_content->options->color_name;
                $order_details->product_size           = $v_content->options->size_name;
                $order_details->product_price          = $v_content->price;
                $order_details->product_sales_quantity = $v_content->qty;
                $order_details->product_coupon         =  $data['order_coupon'];
                $order_details->product_feeship        = $data['order_fee'];
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



            $now = Carbon::now('Asia/Ho_Chi_Minh')->format('h:i:s d/m/Y');

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
                'shipping_name' => $data['shipping_name'],
                'shipping_email' => $data['shipping_email'],
                'shipping_phone' => $data['shipping_phone'],
                'shipping_address' => $data['shipping_address'],
                'shipping_note' => $data['shipping_note'],
                'shipping_method' => $data['shipping_method']
            );

            //lay ma giam gia, lay coupon code
            $ordercode_mail = array(
                'coupon_code' => $coupon_mail,
                'order_code' => $checkout_code,
            );

            Mail::send('pages.mail.mail_order',  ['cart_array'=>$cart_array, 'shipping_array'=>$shipping_array ,'code'=>$ordercode_mail] , function($message) use ($title_mail,$data){
                $message->to($data['email'])->subject($title_mail);//send this mail with subject
                $message->from($data['email'],$title_mail);//send from this mail
            });

            Session::forget('coupon');
            Session::forget('fee');
            Cart::destroy();
        }
    }

    public function view_order($orderId){
        $this->AuthLogin();
        $order_by_id = DB::table('tbl_order')
        ->join('tbl_customer','tbl_order.customer_id','=','tbl_customer.customer_id')
        ->join('tbl_shipping','tbl_order.shipping_id','=','tbl_shipping.shipping_id')
        ->join('tbl_order_details','tbl_order.order_id','=','tbl_order_details.order_id')
        ->select('tbl_order.*','tbl_customer.*','tbl_shipping.*','tbl_order_details.*')->first();

        $manager_order_by_id  = view('admin.view_order')->with('order_by_id',$order_by_id);
        return view('admin_layout')->with('admin.view_order', $manager_order_by_id);
        
    }
    
    public function del_fee(){
        Session::forget('fee');
        return redirect()->back();
    }

    public function calculate_fee(Request $request){
        $data = $request->all();
        if($data['matp']){
            $feeship = Feeship::where('fee_matp',$data['matp'])->where('fee_maqh',$data['maqh'])->where('fee_xaid',$data['xaid'])->get();
            if($feeship){
                $count_feeship = $feeship->count();
                if($count_feeship>0){
                     foreach($feeship as $key => $fee){
                        Session::put('fee',$fee->fee_feeship);
                        Session::save();
                    }
                }else{ 
                    Session::put('fee',25000);
                    Session::save();
                }
            }
           
        }
    }

    public function select_delivery_home(Request $request){
        $data = $request->all();
        if($data['action']){
            $output = '';
            if($data['action']=="city"){
                $select_province = Province::where('matp',$data['ma_id'])->orderby('maqh','ASC')->get();
                    $output.='<option value="">---Select District---</option>';
                foreach($select_province as $key => $province){
                    $output.='<option value="'.$province->maqh.'">'.$province->name_district.'</option>';
                }

            }else{
                $select_wards = Wards::where('maqh',$data['ma_id'])->orderby('xaid','ASC')->get();
                $output.='<option value="">---Select Commune---</option>';
                foreach($select_wards as $key => $ward){
                    $output.='<option value="'.$ward->xaid.'">'.$ward->name_commune.'</option>';
                }
            }
            echo $output;
        }
    }
    public function login_checkout(Request $request){
        $meta_desc = "Please login here!";
        $meta_keywords="login";
        $meta_title="Login";
        $meta_canonical= $request->url();
        $cate_product = DB::table('tbl_category_product')->where('category_status','1')->where('category_parent','0')->orderby('category_id','desc')->get(); 
        $brand_product = DB::table('tbl_brand')->where('brand_status','1')->orderby('brand_id','desc')->get(); 

    	return view('pages.checkout.login_checkout')->with('category',$cate_product)->with('brand',$brand_product)->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('meta_canonical',$meta_canonical);
    }

    public function register_checkout(Request $request){
        $meta_desc = "Register if you are not a member yet";
        $meta_keywords="register";
        $meta_title="Register";
        $meta_canonical= $request->url();
         $cate_product = DB::table('tbl_category_product')->where('category_status','1')->where('category_parent','0')->orderby('category_id','desc')->get(); 
        $brand_product = DB::table('tbl_brand')->where('brand_status','1')->orderby('brand_id','desc')->get(); 

        return view('pages.checkout.rigister')->with('category',$cate_product)->with('brand',$brand_product)->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('meta_canonical',$meta_canonical);
    }

    public function add_customer(Request $request){
        $dataname = $request->all();
    	
        $check_customer_email = $dataname['customer_email'];
        $checkaccount = Customer::where('customer_email', $check_customer_email)->first();
        if($checkaccount){
            Session::put('message_check_account','Email already exists');
            return redirect()->back();
        }else{
            $data = array();
            $data['customer_name']     = $request->customer_name;
            $data['customer_phone']    = $request->customer_phone;
            $data['customer_email']    = $request->customer_email;
            $data['customer_password'] = md5($request->customer_password);
            $data['customer_address']  = $request->customer_address;

            $customer_id = DB::table('tbl_customer')->insertGetId($data);

            Session::put('customer_id',$customer_id);
            Session::put('customer_name',$request->customer_name);
            return Redirect::to('/checkout');
        }

    }

    public function show_checkout(Request $request){

        $customer_id = Session::get('customer_id');
        if($customer_id){
            $meta_desc = "Chuyên bán quần áo đẹp và chất lượng";
            $meta_keywords="Quần áo nam";
            $meta_title="Check Out";
            $meta_canonical= $request->url();
            $city = City::orderby('matp','ASC')->get();
             $cate_product = DB::table('tbl_category_product')->where('category_status','1')->where('category_parent','0')->orderby('category_id','desc')->get(); 
            $brand_product = DB::table('tbl_brand')->where('brand_status','1')->orderby('brand_id','desc')->get();

            $customer_infor = Customer::find($customer_id); 
            return view('pages.checkout.show_checkout')->with('category',$cate_product)->with('brand',$brand_product)->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('meta_canonical',$meta_canonical)->with('city',$city)->with('customer_infor',$customer_infor);
        }else{
            return Redirect::to('/login-checkout')->send();
        }
    }

    public function save_checkout_customer(Request $request){
    	$data = array();
    	$data['shipping_name'] = $request->shipping_name;
    	$data['shipping_phone'] = $request->shipping_phone;
    	$data['shipping_email'] = $request->shipping_email;
    	$data['shipping_note'] = $request->shipping_note;
    	$data['shipping_address'] = $request->shipping_address;

    	$shipping_id = DB::table('tbl_shipping')->insertGetId($data);

    	Session::put('shipping_id',$shipping_id);
    	
    	return Redirect::to('/payment');
    }
    public function payment(Request $request){
        $meta_desc = "Payment";
        $meta_keywords="payment";
        $meta_title="Payment";
        $meta_canonical= $request->url();
         $cate_product = DB::table('tbl_category_product')->where('category_status','1')->where('category_parent','0')->orderby('category_id','desc')->get(); 
        $brand_product = DB::table('tbl_brand')->where('brand_status','1')->orderby('brand_id','desc')->get(); 
        return view('pages.checkout.payment')->with('category',$cate_product)->with('brand',$brand_product)->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('meta_canonical',$meta_canonical);

    }
    public function order_place(Request $request){
        //insert payment_method
     
        $data = array();
        $data['payment_method'] = $request->payment_option;
        $data['payment_status'] = 'Đang chờ xử lý';
        $payment_id = DB::table('tbl_payment')->insertGetId($data);

        //insert order
        $order_data = array();
        $order_data['customer_id'] = Session::get('customer_id');
        $order_data['shipping_id'] = Session::get('shipping_id');
        $order_data['payment_id'] = $payment_id;
        $order_data['order_total'] = Cart::total();
        $order_data['order_status'] = 'Waiting for processing';
        $order_id = DB::table('tbl_order')->insertGetId($order_data);

        //insert order_details
        $content = Cart::content();
        foreach($content as $v_content){
            $order_d_data['order_id'] = $order_id;
            $order_d_data['product_id'] = $v_content->id;
            $order_d_data['product_name'] = $v_content->name;
            $order_d_data['product_price'] = $v_content->price;
            $order_d_data['product_sales_quantity'] = $v_content->qty;
            DB::table('tbl_order_details')->insert($order_d_data);
        }
        if($data['payment_method']==1){

            echo 'Pay by ATM';
            Cart::destroy();
        }elseif($data['payment_method']==2){
            Cart::destroy();

             $cate_product = DB::table('tbl_category_product')->where('category_status','1')->where('category_parent','0')->orderby('category_id','desc')->get(); 
            $brand_product = DB::table('tbl_brand')->where('brand_status','1')->orderby('brand_id','desc')->get(); 
            return view('pages.checkout.handcash')->with('category',$cate_product)->with('brand',$brand_product);

        }else{
            Cart::destroy();
            echo 'Debit card payment';

        }
        
        //return Redirect::to('/payment');
    }
    // public function logout_checkout($customer_id){
    // 	Session::flush();
    // 	return Redirect::to('/login-checkout');
    // }

    public function manage_order(){
        
        $this->AuthLogin();
        $all_order = DB::table('tbl_order')
        ->join('tbl_customer','tbl_order.customer_id','=','tbl_customer.customer_id')
        ->select('tbl_order.*','tbl_customer.customer_name')
        ->orderby('tbl_order.order_id','desc')->get();
        $manager_order  = view('admin.manage_order')->with('all_order',$all_order);
        return view('admin_layout')->with('admin.manage_order', $manager_order);
    }
}
