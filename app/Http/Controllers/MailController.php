<?php

namespace App\Http\Controllers;


use Illuminate\Support\Str;

use Illuminate\Http\Request;
use Mail;
use Session;
use DB;
use Carbon\Carbon;
use App\Coupon;
use App\Customer;
use App\Category;
use App\Product;

class MailController extends Controller
{
    public function send_mail(Request $request){
        $meta_desc = "Contact us";
        $meta_keywords="Contact us";
        $meta_title="Contact us";
        $meta_canonical= $request->url();
        //--seo
    	$cate_product = DB::table('tbl_category_product')->where('category_status','1')->where('category_parent','0')->orderby('category_id','desc')->get(); 
        $brand_product = DB::table('tbl_brand')->where('brand_status','1')->orderby('brand_id','desc')->get(); 
        

    	return view('pages.send_mail')->with('category',$cate_product)->with('brand',$brand_product)->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('meta_canonical',$meta_canonical);
    }


    public function post_mail(Request $request){
        Mail::send('pages.mail.email',[
            'name'    => $request->name,
            'content' => $request->content,
        ], function($message) use ($request){
            $message->to('tritung1998@gmail.com', $request->name);
            $message->from($request->email);
            $message->subject($request->subject);
        });
        return back()->with('success', 'Thanks for contacting me, I will get back to you soon!');   
    }

    public function send_coupon_vip($coupon_time,$coupon_condition,$coupon_number,$coupon_code){
        //get customer
        $customer = Customer::where('customer_vip','=',1)->get();

        $coupon = Coupon::where('coupon_code',$coupon_code)->first();
        $start_coupon = $coupon->coupon_date_start;
        $end_coupon = $coupon->coupon_date_end;

        $now = Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y H:i:s');

        $title_mail = "Promo code for the day".' '.$now;
        
        $data = [];
        foreach($customer as $normal){
            $data['email'][] = $normal->customer_email;
        }
        
        $coupon = array(
            
            'start_coupon' =>$start_coupon,
            'end_coupon' =>$end_coupon,
            'coupon_time' => $coupon_time,
            'coupon_condition' => $coupon_condition,
            'coupon_number' => $coupon_number,
            'coupon_code' => $coupon_code
        );
        Mail::send('pages.send_coupon_vip',  ['coupon'=>$coupon] , function($message) use ($title_mail,$data){
                $message->to($data['email'])->subject($title_mail);//send this mail with subject
                $message->from($data['email'],$title_mail);//send from this mail
        });
  
  
         return redirect()->back()->with('message_mail_coupon','Sending promo code vip customers successfully');
    }

    public function send_coupon($coupon_time,$coupon_condition,$coupon_number,$coupon_code){
        //get customer
        $customer = Customer::where('customer_vip','=',0)->get();

        $coupon = Coupon::where('coupon_code',$coupon_code)->first();
        $start_coupon = $coupon->coupon_date_start;
        $end_coupon = $coupon->coupon_date_end;

        $now = Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y H:i:s');

        $title_mail = "Promo code for the day".' '.$now;
        
        $data = [];
        foreach($customer as $normal){
            $data['email'][] = $normal->customer_email;
        }
        
        $coupon = array(
            
            'start_coupon' =>$start_coupon,
            'end_coupon' =>$end_coupon,
            'coupon_time' => $coupon_time,
            'coupon_condition' => $coupon_condition,
            'coupon_number' => $coupon_number,
            'coupon_code' => $coupon_code
        );
        Mail::send('pages.send_coupon',  ['coupon'=>$coupon] , function($message) use ($title_mail,$data){
                $message->to($data['email'])->subject($title_mail);//send this mail with subject
                $message->from($data['email'],$title_mail);//send from this mail
        });
  
  
         return redirect()->back()->with('message_mail_coupon','Sending promo code vip customers successfully');
    }  
}
