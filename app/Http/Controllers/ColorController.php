<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Session;
use App\Color;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

session_start();

class ColorController extends Controller
{
    public function AuthLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }
    public function add_color($product_id){
       	$pro_id = $product_id;
    	return view('admin.color.add_color')->with(compact('pro_id'));
    }

    public function insert_color(Request $request, $pro_id){
        $this->AuthLogin();
        $data = $request->all();
        $color = new Color();
        $color->color_name = Str::title($data['color_name']);
       	$color->product_id = $pro_id;
        $color->save();
    	return redirect()->back();
    }

    public function update_color_name(Request $request){
    	$col_id = $request->col_id;
    	$col_text = $request->col_text;
    	$color = color::find($col_id);
	    $color->color_name = Str::title($col_text);
		$color->save();
    }


    public function delete_color(Request $request){
    	$col_id = $request->col_id;
    	$color = color::find($col_id);
	    $color->delete();
    }

    public function select_color(Request $request){
    	$product_id = $request->pro_id;
    	$color = Color::where('product_id',$product_id)->get();
    	$color_count = $color->count();
    	$output = ' <form>
    					'.csrf_field().'

    					<table class="table table-hover">
                                    <thead>
                                      <tr>
                                      	<th>No</th>
                                        <th>Color</th>
                                        <th>Manager</th>
                                      </tr>
                                    </thead>
                                    <tbody>

    	';
    	if($color_count>0){
    		$i = 0;
    		foreach($color as $key => $col){
    			$i++;
    			$output.='

    				 <tr>
    				 					<td>'.$i.'</td>
                                        <td contenteditable class="edit_col_name" data-col_id="'.$col->color_id.'">'.$col->color_name.'</td>
                                        <td>
                                        	<button type="button" data-col_id="'.$col->color_id.'" class="btn btn-xs btn-danger delete-color">Delete</button>
                                        </td>
                                      </tr>
                                    



    			';
    		}
    	}else{ 
    		$output.='
    				 <tr>
                                        <td colspan="4">There are no colors for this product yet</td>
                                       
                                      </tr>


    			';

    	}
    	$output.='
    				 </tbody>
    				 </table>
    				 </form>


    			';
    	echo $output;
    }
}
