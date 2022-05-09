<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Session;
use App\Size;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
session_start();

class SizeController extends Controller
{
    public function AuthLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }
    public function add_size($product_id){
       	$pro_id = $product_id;
    	return view('admin.size.add_size')->with(compact('pro_id'));
    }

    public function insert_size(Request $request, $pro_id){
        $this->AuthLogin();
        $data = $request->all();
        $size = new size();
        $size->size_name = Str::upper($data['size_name']);
       	$size->product_id = $pro_id;
        $size->save();
    	return redirect()->back();
    }

    public function update_size_name(Request $request){
        $this->AuthLogin();
    	$siz_id = $request->siz_id;
    	$siz_text = $request->siz_text;
    	$size = size::find($siz_id);
	    $size->size_name = Str::upper($data['size_name']);
		$size->save();
    }


    public function delete_size(Request $request){
                $this->AuthLogin();

    	$siz_id = $request->siz_id;
    	$size = size::find($siz_id);
	    $size->delete();
    }

    public function select_size(Request $request){
                $this->AuthLogin();

    	$product_id = $request->pro_id;
    	$size = size::where('product_id',$product_id)->get();
    	$size_count = $size->count();
    	$output =''.csrf_field().'';
    	?>
			<form>
				<?php echo $output ?>
			      <table class="table table-hover">
			         <thead>
			            <tr>
			               <th>No</th>
			               <th>size</th>
			               <th>Manager</th>
			            </tr>
			         </thead>
			         <tbody>
			         	<?php
					    	if($size_count>0){
					    		$i = 0;
					    		foreach($size as $key => $siz){
					    			 $i++;
					    			?>
							            <tr>
							               <td><?php echo $i ?></td>
							               <td contenteditable="" class="edit_siz_name" data-siz_id="<?php echo $siz->size_id ?>"><?php echo $siz->size_name ?></td>
							               <td>
							                  <button type="button" data-siz_id="<?php echo $siz->size_id ?>" class="btn btn-xs btn-danger delete-size">Delete</button>
							               </td>
							            </tr>
					    			<?php
					    		}
					    	}else{
					    		?>
    				 				<tr>
                                       <td sizspan="4">There are no sizes for this product yet</td>
                                    </tr>
					    		<?php
					    	}	
			         	?>

			         </tbody>
			      </table>
			</form>
    	<?php
    }
}

?>