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
class dashboardController extends Controller
{


    public function dashboard(Request $request){
        $customer_id = Session::get('customer_id');
        if($customer_id){
            $meta_desc = "Dashboard";
            $meta_keywords="Dashboard";
            $meta_title="Dashboard";
            $meta_canonical= $request->url();
            //--seo
            $cate_product = DB::table('tbl_category_product')->where('category_status','1')->where('category_parent','0')->orderby('category_id','desc')->get(); 
            $brand_product = DB::table('tbl_brand')->where('brand_status','1')->orderby('brand_id','desc')->get();

            $customer_infor = Customer::find($customer_id);

    		return view('pages.dashboard.dashboard')->with('category',$cate_product)->with('brand',$brand_product)->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('meta_canonical',$meta_canonical)->with('customer_infor', $customer_infor);
        }else{
            return Redirect::to('/login-checkout')->send();
        }
    }

    public function update_profile_pages(Request $request){
        $customer_id = Session::get('customer_id');
        if($customer_id){
            $meta_desc = "Dashboard";
            $meta_keywords="Dashboard";
            $meta_title="Dashboard";
            $meta_canonical= $request->url();
            //--seo
            $cate_product = DB::table('tbl_category_product')->where('category_status','1')->where('category_parent','0')->orderby('category_id','desc')->get(); 
            $brand_product = DB::table('tbl_brand')->where('brand_status','1')->orderby('brand_id','desc')->get();

            $customer_infor = Customer::find($customer_id);

            return view('pages.dashboard.update_profile')->with('category',$cate_product)->with('brand',$brand_product)->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('meta_canonical',$meta_canonical)->with('customer_infor', $customer_infor);
        }else{
            return Redirect::to('/login-checkout')->send();
        }
    }

    public function update_profile(Request $request){
        $data = $request->all();
        $customer_id = Session::get('customer_id');
        $customer_edit = Customer::find($customer_id);
        $customer_edit->customer_name  = $data['name'];
        $customer_edit->customer_phone = $data['phone'];
        $customer_edit->customer_address  = $data['address'];
        $get_image = $request->file('product_image');

        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image =  $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move('public/uploads/avatar_customer',$new_image);
            $customer_edit->customer_picture  = url('/public/uploads/avatar_customer/'.$new_image.'');
            $customer_edit->save();
            return redirect()->back();
        }
        $customer_edit->save();
        return redirect()->back();
    }


}
