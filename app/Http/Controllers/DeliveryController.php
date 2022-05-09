<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\City;
use App\Province;
use App\Wards;
use App\Feeship;
class DeliveryController extends Controller
{
	public function update_delivery(Request $request){
		$data = $request->all();
		$fee_ship = Feeship::find($data['feeship_id']);
		$fee_value = rtrim($data['fee_value'],'.');
		$fee_ship->fee_feeship = $fee_value;
		$fee_ship->save();
	}

    public function delete_feeshipping(Request $request){
    	$feeship_id = $request->fee_id;
    	$feeship = Feeship::find($feeship_id);
	    $feeship->delete();
    }

	public function select_feeship(){
		$feeship = Feeship::orderby('fee_id','DESC')->get();
		$output = '';
		$output .= '<div class="table-responsive">  
			<table class="table table-bordered">
				<thread> 
					<tr>
						<th>No.</th>
						<th>City</th>
						<th>District</th> 
						<th>Commune</th>
						<th>Fee shipping</th>
						<th>Action</th>
					</tr>  
				</thread>
				<tbody>
				';

				$count = 0;
				foreach($feeship as $key => $fee){
				$count++;	
				$output.='
					<tr>
						<td>'.$count.'</td>
						<td>'.$fee->city->name_city.'</td>
						<td>'.$fee->province->name_district.'</td>
						<td>'.$fee->wards->name_commune.'</td>
						<td contenteditable data-feeship_id="'.$fee->fee_id.'" class="fee_feeship_edit">'.number_format($fee->fee_feeship,0,',','.').'</td>
						<td><button type="button" data-fee_id="'.$fee->fee_id.'" class="btn btn-xs btn-danger delete-feeshipping">Delete</button></td>

					</tr>
					';
				}

				$output.='		
				</tbody>
				</table></div>
				';

				echo $output;

		
	}
	
	public function insert_delivery(Request $request){

		$data = $request->all();
		$checkfee = Feeship::where('fee_matp',$data['city'])->where('fee_maqh',$data['province'])->where('fee_xaid',$data['wards'])->first();
		if($checkfee){
			return response(['message'=>"This location's shipping charges already exist"]);
		}else{
			$fee_ship = new Feeship();
			$fee_ship->fee_matp = $data['city'];
			$fee_ship->fee_maqh = $data['province'];
			$fee_ship->fee_xaid = $data['wards'];
			$fee_ship->fee_feeship = $data['fee_ship'];
			$fee_ship->save();
		}
	}
    public function delivery(Request $request){

    	$city = City::orderby('matp','ASC')->get();

    	return view('admin.delivery.add_delivery')->with(compact('city'));
    }
    public function select_delivery(Request $request){
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
}
