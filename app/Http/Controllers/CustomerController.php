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

class CustomerController extends Controller
{

    public function AuthLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('admin')->send();
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

    public function login_customer(Request $request){
        $email = $request->email_account;
        $password = md5($request->password_account);
        $result = DB::table('tbl_customer')->where('customer_email',$email)->where('customer_password',$password)->first();

        if($result){
            Session::put('customer_id',$result->customer_id);
            return Redirect::to('/checkout');
        }else{
            Session::flash('message_check_login','Email or password is incorrect!');
            return redirect()->back();
        }
    }


    public function logout_checkout(Request $request){
        Session::forget('customer_id');
        if(Session::get('customer_name')==true){
            Session::forget('customer_name');  
        }
        if(Session::get('customer_picture')==true){
            Session::forget('customer_picture');  
        }
        
        if(Session::get('coupon')==true){
            Session::forget('coupon');  
        }

        if(Session::get('fee')==true){
            Session::forget('fee');  
        }

        return Redirect::to('/login-checkout');
    }

    public function list_customer(Request $request){
        $admin_id   = Session::get('admin_id');
        $admin_role = Session::get('admin_role');
        if($admin_id && $admin_role==1){
            $all_customer = Customer::orderBy('customer_id','DESC')->paginate(6);
            $manager_all_customer  = view('admin.customer.list_customer')->with('all_customer',$all_customer);
            return view('admin_layout')->with('admin.customer.list_customer', $manager_all_customer);
        }else{
            return view('errors.404');
        }
    }

    public function unactive_customer($customer_id){
        $admin_id   = Session::get('admin_id');
        $admin_role = Session::get('admin_role');
        if($admin_id && $admin_role==1){
            Customer::where('customer_id',$customer_id)->update(['customer_vip'=>0]);
            Session::put('messagecustomer','Downgrade to normal successfully');
            return Redirect::to('list-customer');
        }else{
            return view('errors.404');
        }
    }
    public function active_customer($customer_id){
        $admin_id   = Session::get('admin_id');
        $admin_role = Session::get('admin_role');
        if($admin_id && $admin_role==1){
            Customer::where('customer_id',$customer_id)->update(['customer_vip'=>1]);
            Session::put('messagecustomer','Upgrade to vip successfully');
            return Redirect::to('list-customer');
        }else{
            return view('errors.404');
        }
    }
}
