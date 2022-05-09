<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Session;
use App\Gallery;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();
class GalleryController extends Controller
{
    public function AuthLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }

    public function add_gallery($product_id){
       	$pro_id = $product_id;
    	return view('admin.gallery.add_gallery')->with(compact('pro_id'));

    }

    public function update_gallery(Request $request){
    	$get_image = $request->file('file');
    	$gal_id = $request->gal_id;
    	if($get_image){
			$gallery = Gallery::find($gal_id);
           	unlink('public/uploads/gallery/'.$gallery->gallery_image);
			$get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image =  $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move('public/uploads/gallery',$new_image);
            $gallery->gallery_image = $new_image;
           	$gallery->save(); 
    	}
    }

    public function insert_gallery(Request $request, $pro_id){
    	$get_image = $request->file('file');
    	if($get_image){
    		foreach($get_image as $image){
    			$get_name_image = $image->getClientOriginalName();
	            $name_image = current(explode('.',$get_name_image));
	            $new_image =  $name_image.rand(0,99).'.'.$image->getClientOriginalExtension();
	            $image->move('public/uploads/gallery',$new_image);
	           	$gallery = new Gallery();
                $gallery->gallery_image = $new_image;
	           	$gallery->product_id = $pro_id;
	           	$gallery->save();
    		}
    	}
    	Session::put('message','Add image library to public');
	    return redirect()->back();

    }

    public function delete_gallery(Request $request){
    	$gal_id = $request->gal_id;
    	$gallery = Gallery::find($gal_id);
	    unlink('public/uploads/gallery/'.$gallery->gallery_image);
	    $gallery->delete();
    }

    public function select_gallery(Request $request){
    	$product_id = $request->pro_id;
    	$gallery = Gallery::where('product_id',$product_id)->get();
    	$gallery_count = $gallery->count();
    	$output = ' <form>
    					'.csrf_field().'

    					<table class="table table-hover">
                                    <thead>
                                      <tr>
                                      	<th>No.</th>
                                        <th>Image</th>
                                        <th>Manager</th>
                                      </tr>
                                    </thead>
                                    <tbody>

    	';
    	if($gallery_count>0){
    		$i = 0;
    		foreach($gallery as $key => $gal){
    			$i++;
    			$output.='

    				 <tr>
    				 					<td>'.$i.'</td>

                                        <td>

                                        <img src="'.url('public/uploads/gallery/'.$gal->gallery_image).'" class="img-thumbnail" width="120" height="120">

                                        <input type="file" class="file_image" style="width:40%" data-gal_id="'.$gal->gallery_id.'" id="file-'.$gal->gallery_id.'" name="file" accept="image/*" />

                                        </td>
                                        <td>
                                        	<button type="button" data-gal_id="'.$gal->gallery_id.'" class="btn btn-xs btn-danger delete-gallery">Delete</button>
                                        </td>
                                      </tr>
                                    



    			';
    		}
    	}else{ 
    		$output.='
    				 <tr>
                                        <td colspan="4">There are no gallerys for this product yet</td>
                                       
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
