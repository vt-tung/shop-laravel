<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Coupon;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();

class CouponController extends Controller
{
	public function unset_coupon(){
		$coupon = Session::get('coupon');
        if($coupon==true){
            Session::forget('coupon');
            return redirect()->back()->with('messagecoupon','Delete coupon code successfully');
        }
	}
    public function insert_coupon(){
        $admin_id   = Session::get('admin_id');
        $admin_role = Session::get('admin_role');
        if($admin_id && $admin_role==1){
            return view('admin.coupon.insert_coupon');
        }else{
            return view('errors.404');
        }
    }
    public function delete_coupon($id_coupon){
    	$coupon = Coupon::find($id_coupon);
    	$coupon->delete();
    	Session::put('message_mail_coupon','Delete coupon code successfully');
        return Redirect::to('list-coupon');
    }
    public function list_coupon(){
        $admin_id   = Session::get('admin_id');
        $admin_role = Session::get('admin_role');
        if($admin_id && $admin_role==1){
            $today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
            $coupon = Coupon::orderby('id_coupon','DESC')->paginate(5);
            return view('admin.coupon.list_coupon')->with(compact('coupon', 'today'));
        }else{
            return view('errors.404');
        }
    }
    public function insert_coupon_code(Request $request){

        $data = $request->all();
        $checkcoupon = Coupon::where('coupon_code', Input::get('coupon_code'))->first();
        $start_time = Carbon::createFromFormat('d/m/Y',$data['coupon_date_start'])->format('Y-m-d');
        $end_time = Carbon::createFromFormat('d/m/Y',$data['coupon_date_end'])->format('Y-m-d');

        if($start_time >= $end_time){
            Session::put('messageadd','Start date must be less than end date');
            return redirect()->back();
        }else{
            if($checkcoupon==true){
                Session::put('messageadd','Discount code already exists');
                return redirect()->back();
            }elseif($checkcoupon==false) {
                $coupon = new Coupon;
                $coupon->coupon_name = $data['coupon_name'];
                $coupon->coupon_date_start = $start_time;
                $coupon->coupon_date_end = $end_time;
                $coupon->coupon_number = $data['coupon_number'];
                $coupon->coupon_code = $data['coupon_code'];
                $coupon->coupon_time = $data['coupon_time'];
                $coupon->coupon_condition = $data['coupon_condition'];
                $coupon->save();
                Session::put('messageadd_coupon_success','Add coupon code successfully');
                return redirect()->back();
            }
        }


    }
}
