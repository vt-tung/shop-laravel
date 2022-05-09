<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Slider;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use DB;

class SliderController extends Controller
{
    public function AuthLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }

    public function add_slider(){
        $admin_id   = Session::get('admin_id');
        $admin_role = Session::get('admin_role');
        if($admin_id && $admin_role==1){
            return view('admin.slider.add_slider');
        }else{
            return view('errors.404');
        }
    }

    public function insert_slider(Request $request){
    	
    	$this->AuthLogin();

   		$data = $request->all();
       	$get_image = request('slider_image');
      
        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image =  $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move('public/uploads/slider', $new_image);

            $slider = new Slider();
            $slider->slider_name = $data['slider_name'];
            $slider->slider_image = $new_image;
            $slider->slider_status = $data['slider_status'];
           	$slider->save();
            Session::put('messageslider','Add slider successfully');
            return Redirect::to('add-slider');
        }else{
        	Session::put('messageslider','Please add slider');
    		return Redirect::to('add-slider');
        }
       	
    }

    public function manage_slider(){
        $admin_id   = Session::get('admin_id');
        $admin_role = Session::get('admin_role');
        if($admin_id && $admin_role==1){
            $all_slide = Slider::orderBy('slider_id','DESC')->paginate(6);
            return view('admin.slider.list_slider')->with(compact('all_slide'));
        }else{
            return view('errors.404');
        }
    }


    public function unactive_slide($slide_id){
        $admin_id   = Session::get('admin_id');
        $admin_role = Session::get('admin_role');
        if($admin_id && $admin_role==1){
            DB::table('tbl_slider')->where('slider_id',$slide_id)->update(['slider_status'=>1]);
            Session::put('messageslider','Active successfully');
            return redirect()->back();
        }else{
            return view('errors.404');
        }
    }

    public function active_slide($slide_id){
        $admin_id   = Session::get('admin_id');
        $admin_role = Session::get('admin_role');
        if($admin_id && $admin_role==1){
            DB::table('tbl_slider')->where('slider_id',$slide_id)->update(['slider_status'=>0]);
            Session::put('messageslider','Unactive successfully');
            return redirect()->back();
        }else{
            return view('errors.404');
        }
    }

    public function delete_slide(Request $request, $slide_id){
        $admin_id   = Session::get('admin_id');
        $admin_role = Session::get('admin_role');
        if($admin_id && $admin_role==1){
            $slider = Slider::find($slide_id);
            unlink('public/uploads/slider/'.$slider->slider_image);
            $slider->delete();
            Session::put('messageslider','Delete slider successfully');
            return redirect()->back();
        }else{
            return view('errors.404');
        }
    }
}
