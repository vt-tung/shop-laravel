<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Feeship;
use App\Shipping;
use App\Order;
use App\OrderDetails;
use App\Customer;
use App\Coupon;
use App\Product;
use App\Payment;
use App\Statistic;
use Carbon\Carbon;
use PDF;
use Mail;
use Session;
use DB;
session_start();

class OrderController extends Controller
{

	public function print_order($checkout_code){
		$pdf = \App::make('dompdf.wrapper');
		$pdf->loadHTML($this->print_order_convert($checkout_code));
		return $pdf->stream();
	}


	public function print_order_convert($checkout_code){
		$order_details = OrderDetails::where('order_code',$checkout_code)->get();
		$order = Order::where('order_code',$checkout_code)->get();
		foreach($order as $key => $ord){
			$customer_id = $ord->customer_id;
			$shipping_id = $ord->shipping_id;
		}
		$customer = Customer::where('customer_id',$customer_id)->first();
		$shipping = Shipping::where('shipping_id',$shipping_id)->first();

		$order_details_product = OrderDetails::with('product')->where('order_code', $checkout_code)->get();

		foreach($order_details_product as $key => $order_d){

			$product_coupon = $order_d->product_coupon;
		}
		if($product_coupon != 'no'){
			$coupon = Coupon::where('coupon_code',$product_coupon)->first();

			$coupon_condition = $coupon->coupon_condition;
			$coupon_number = $coupon->coupon_number;

			if($coupon_condition==1){
				$coupon_echo = $coupon_number.'%';
			}elseif($coupon_condition==2){
				$coupon_echo = number_format($coupon_number,0,',','.')." ".'VNĐ';
			}
		}else{
			$coupon_condition = 2;
			$coupon_number = 0;

			$coupon_echo = '0';
		
		}

		$output = '';

		$output.='
		<style>
			body{
				font-family: DejaVu Sans;
			}
			.table-styling{
				border:1px solid #000;
				border-collapse: collapse;
				width:100%;
			}
			.table-styling tbody tr td, .table-styling thead tr th{
				border:1px solid #000;
				padding:10px;
				with:100%;
				font-size:12px;

			}

			.table-styling thead tr th{
				font-weight:normal;
				text-align: left;
            	font-weight: bold;
			}

			.cl-title-pdf{
				font-size:14px;
				margin-bottom: 15px;
			}
			.cl-title-pdf2{
				font-size:12px;
				margin-bottom: 3px;
				 line-height: normal
			}
		</style>
		<h1><center>WILD SHOP</center></h1>
		<h6 class="cl-title-pdf">Orderer: </h6>
		<table class="table-styling">
				<thead>
					<tr>
						<th>Customer name</th>
						<th>Phone number</th>
						<th>Email</th>
					</tr>
				</thead>
				<tbody>';
				
				$output.='		
					<tr>
						<td>'.$customer->customer_name.'</td>
						<td>'.$customer->customer_phone.'</td>
						<td>'.$customer->customer_email.'</td>
						
					</tr>
				';
				

		$output.='				
				</tbody>
			
		</table>

		';

		// Ship đến


		if($shipping->shipping_method==0){
			$shipping_method = 'Transfer';
		}else{
			$shipping_method = 'Pay by COD';
		}
		if($shipping->shipping_note!=null) {
			$output.='
				<h6 class="cl-title-pdf">Delivery to: </h6>
				<table class="table-styling">
					<thead>
						<tr>
							<th>Recipient name</th>
							<th>Address</th>
							<th>Phone number</th>
							<th>Email</th>
							<th>Note</th>
							<th>Payments</th>
						</tr>
					</thead>
					<tbody>
			';

			$output.='		
				<tr>
					<td>'.$shipping->shipping_name.'</td>
					<td>'.$shipping->shipping_address.'</td>
					<td>'.$shipping->shipping_phone.'</td>
					<td>'.$shipping->shipping_email.'</td>
					<td>'.$shipping->shipping_note.'</td>
					<td>'.$shipping_method.'</td>

				</tr>
			';
		}else {
			$output.='
				<h6 class="cl-title-pdf">Delivery to: </h6>
				<table class="table-styling">
					<thead>
						<tr>
							<th>Recipient name</th>
							<th>Address</th>
							<th>Phone number</th>
							<th>Email</th>
							<th>Payments</th>
						</tr>
					</thead>
					<tbody>
			';
	
			$output.='		
				<tr>
					<td>'.$shipping->shipping_name.'</td>
					<td>'.$shipping->shipping_address.'</td>
					<td>'.$shipping->shipping_phone.'</td>
					<td>'.$shipping->shipping_email.'</td>
					<td>'.$shipping_method.'</td>
				</tr>
			';
		}

		$output.='				
				</tbody>
			
		</table>';

		$output.='
			<h6 class="cl-title-pdf">Order : </h6>
			<table class="table-styling">
				<thead>
					<tr>
						<th>No</th>
						<th>Product Name</th>
						<th>Color</th>
						<th>Size</th>

						<th>Quantity</th>
						<th>Price</th>
						<th>Total</th>
					</tr>
				</thead>
				<tbody>
		';

		$total = 0;
		$count= 0;
		foreach($order_details_product as $key => $product){
			$count++;
			$subtotal = $product->product_price*$product->product_sales_quantity;
			$total+=$subtotal;

			if($product->product_coupon!='no'){
				$product_coupon = $product->product_coupon;
			}else{
				$product_coupon = 'No discount code';
			}		

			$output.='		
				<tr>
					<td>'.$count.'</td>
					<td>'.$product->product_name.'</td>
					<td>'.$product->product_color.'</td>
					<td>'.$product->product_size.'</td>
					<td>'.$product->product_sales_quantity.'</td>
					<td>'.number_format($product->product_price,0,',','.')." ".'VNĐ'.'</td>
					<td>'.number_format($subtotal,0,',','.')." ".'VNĐ'.'</td>
					
				</tr>
			';
		}

		if($coupon_condition==1){
            $total_coupon = $total + ($total*0.1) + $product->product_feeship;
            $total_coupon_final = $total_coupon - ($total_coupon*$coupon_number/100);
		}else{
          	$total_coupon_final = $total + ($total*0.1) - $coupon_number + $product->product_feeship;
		}

		if($shipping->shipping_method==0){
			$shipping_method = 'Transfer';
			$output.= '<tr>
					<td colspan="7" style="text-align:right">
						<p class="cl-title-pdf2">Tax: '.number_format($total*0.1,0,',','.')." "."VNĐ".'</p>
						<p class="cl-title-pdf2">Shipping fee: '.number_format($product->product_feeship,0,',','.')." ".'VNĐ'.'</p>
						<p class="cl-title-pdf2">Discount code: '.$product_coupon.'</p>
						<p class="cl-title-pdf2">Total decreased: '.$coupon_echo.'</p>
						<p class="cl-title-pdf2">Paid: '.number_format($total_coupon_final,0,',','.')." ".'VNĐ'.'</p>
						<p class="cl-title-pdf2">Payments mothod: Transfer</p>
						<p class="cl-title-pdf2">Collect money from recipients: 0 VNĐ</p>

					</td>
			</tr>';
		}else{
			$output.= '<tr>
					<td colspan="7" style="text-align:right">
						<p class="cl-title-pdf2">Tax: '.number_format($total*0.1,0,',','.')." "."VNĐ".'</p>
						<p class="cl-title-pdf2">Shipping fee: '.number_format($product->product_feeship,0,',','.')." ".'VNĐ'.'</p>
						<p class="cl-title-pdf2">Discount code: '.$product_coupon.'</p>
						<p class="cl-title-pdf2">Total decreased: '.$coupon_echo.'</p>
						<p class="cl-title-pdf2">Payments method: Pay by COD</p>
						<p class="cl-title-pdf2">Collect money from recipients : '.number_format($total_coupon_final,0,',','.')." ".'VNĐ'.'</p>

					</td>
			</tr>';
		}

		$output.='				
				</tbody>
			
		</table>

			<table>
				<thead>
					<tr>
						<th width="200px">Vote makers</th>
						<th width="800px">Receiver</th>
						
					</tr>
				</thead>
				<tbody>';
						
		$output.='				
				</tbody>
			
		</table>

		';
		return $output;

	}


	public function view_order($order_code){
        $admin_id   = Session::get('admin_id');
        $admin_role = Session::get('admin_role');
        if($admin_id && $admin_role==1){
			$order_details = OrderDetails::with('product')->where('order_code',$order_code)->get();
			$order = Order::where('order_code',$order_code)->get();
			foreach($order as $key => $ord){
				$customer_id = $ord->customer_id;
				$shipping_id = $ord->shipping_id;
				$order_status = $ord->order_status;
			}
			$customer = Customer::where('customer_id',$customer_id)->first();
			$shipping = Shipping::where('shipping_id',$shipping_id)->first();

			$order_details_product = OrderDetails::with('product')->where('order_code', $order_code)->get();

			foreach($order_details_product as $key => $order_d){

				$product_coupon = $order_d->product_coupon;
			}
			if($product_coupon != 'no'){
				$coupon = Coupon::where('coupon_code',$product_coupon)->first();
				$coupon_condition = $coupon->coupon_condition;
				$coupon_number = $coupon->coupon_number;
			}else{
				$coupon_condition = 2;
				$coupon_number = 0;
			}
			
			return view('admin.view_order')->with(compact('order_details','customer','shipping','coupon_condition','coupon_number','order','order_status'));
        }else{
            return view('errors.404');
        }
	}
	public function destroy_order_code(Request $request){
		$data = $request->all();
		$order = Order::where('order_code',$data['order_code'])->first();
		$order->order_status = $data['order_status'];
		$order->order_destroy = $data['text_reason'];
		$order->save();

	  	if($order->order_status == 6){
			foreach($data['order_product_id'] as $key => $product){
				$product = Product::find($product);
				$product_quantity = $product->product_qty;
				$product_sold = $product->product_sold;

				foreach($data['quantity'] as $key2 => $qty){
					 if($key==$key2){
						$pro_remain = $product_quantity + $qty;
						$product->product_qty = $pro_remain;
						$product->product_sold = $product_sold - $qty;
						$product->save();
					}
				}
			}
        }
	}

	public function update_order_qty(Request $request){
		$data = $request->all();
		$order = Order::find($data['order_id']);
		$order->order_status = $data['order_status'];
		$order->save();
	
	  	if($order->order_status == 6){
			foreach($data['order_product_id'] as $key => $product){
				$product = Product::find($product);
				$product_quantity = $product->product_qty;
				$product_sold = $product->product_sold;

				foreach($data['quantity'] as $key2 => $qty){
					 if($key==$key2){
						$pro_remain = $product_quantity + $qty;
						$product->product_qty = $pro_remain;
						$product->product_sold = $product_sold - $qty;
						$product->save();
					}
				}
			}
        }

        $order_code_title = $order->order_code;

		//send mail confirm
		$now = Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y H:i:s');
		if($order->order_status == 1){

			$title_mail = "Your order ".$order_code_title." has not been confirmed at".' '.$now;

		}elseif($order->order_status == 2){

			$title_mail = "Your order ".$order_code_title." has been confirmed at".' '.$now;

		}elseif($order->order_status == 3){

			$title_mail = "Your order ".$order_code_title." are being taken at".' '.$now;
		}elseif($order->order_status == 4){

			$title_mail = "Your order ".$order_code_title." are delivering at".' '.$now;

		}elseif($order->order_status == 5){

			$title_mail = "Your order ".$order_code_title." has been delivered at".' '.$now;

		}elseif($order->order_status == 6){

			$title_mail = "Your order ".$order_code_title." has been cancelled at".' '.$now;

		}
		
		$customer = Customer::where('customer_id',$order->customer_id)->first();
		$data['email'][] = $customer->customer_email;

		
	  	//lay san pham
	  	
		foreach($data['order_details_id'] as $key => $product){
				$product_mail = OrderDetails::find($product);
				foreach($data['quantity'] as $key2 => $qty){

				 	if($key==$key2){

						$cart_array[] = array(
							'product_name' => $product_mail['product_name'],
							'product_price' => $product_mail['product_price'],
							'product_color' => $product_mail['product_color'],
							'product_size' => $product_mail['product_size'],
							'product_qty' => $qty
						);

				}
			}
		}

		
	  	//lay shipping
	  	$details = OrderDetails::where('order_code',$order->order_code)->first();

		$fee_ship = $details->product_feeship;
		$coupon_mail = $details->product_coupon;

	  	$shipping = Shipping::where('shipping_id',$order->shipping_id)->first();
	  	
		$shipping_array = array(
			'fee_ship' =>  $fee_ship,
			'status_order' => $title_mail,
			'customer_name' => $customer->customer_name,
			'shipping_name' => $shipping->shipping_name,
			'shipping_email' => $shipping->shipping_email,
			'shipping_phone' => $shipping->shipping_phone,
			'shipping_address' => $shipping->shipping_address,
			'shipping_note' => $shipping->shipping_note,
			'shipping_method' => $shipping->shipping_method

		);

		if($coupon_mail != 'no'){
			$coupon = Coupon::where('coupon_code',$coupon_mail)->first();
			$coupon_condition = $coupon->coupon_condition;
			$coupon_number = $coupon->coupon_number;
		}else{
			$coupon_condition = 2;
			$coupon_number = 0;
		}

	  	//lay ma giam gia, lay coupon code
		$ordercode_mail = array(
			'coupon_code' => $coupon_mail,
			'order_code' => $details->order_code,
			'coupon_condition' => $coupon_condition,
			'coupon_number' => $coupon_number
		);

		Mail::send('admin.confirm_order',  ['cart_array'=>$cart_array, 'shipping_array'=>$shipping_array ,'code'=>$ordercode_mail] , function($message) use ($title_mail,$data){
			      $message->to($data['email'])->subject($title_mail);//send this mail with subject
			      $message->from($data['email'],$title_mail);//send from this mail
		});

		$order_date = Carbon::createFromFormat('Y-m-d H:i:s',$order->order_date)->format('Y-m-d');
		
		$statistic = Statistic::where('order_date',$order_date)->get();
		if($statistic){
			$statistic_count = $statistic->count();	
		}else{
			$statistic_count = 0;
		}

		if($order->order_status==5){
			//them
			$total_order = 0;
			$sales = 0;
			$profit = 0;
			$quantity = 0;
			$totalsales = 0;
			$totalquantity = 0;
			$totalorder = 0;
			$totalprofit = 0;
			foreach($data['order_product_id'] as $key => $product_id){

				$product = Product::find($product_id);
				$product_price 		  = $product->product_price_promotion;
				$product_import_price = $product->product_import_price;
				$now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();

				foreach($data['quantity'] as $key2 => $qty){

					if($key==$key2){
						//update doanh thu
						$quantity+=$qty;
						$total_order+=1;
						$sales +=$product_price*$qty;
 						$profit += $product_import_price*$qty;
					}
				}
			}

			if($coupon_condition==1){
				$totalquantity	   = $quantity;
				$totalorder	       +=1;
				$totalsales        = $sales + ($sales*0.1) + $fee_ship;
				$total_sales_final = $totalsales - ($totalsales*$coupon_number/100) - ($sales*0.1) - $fee_ship;
				$totalprofit       = $total_sales_final - $profit;
			}else{
				$totalquantity	   = $quantity;
				$totalorder	       +=1;
				$total_sales_final = $sales - $coupon_number;
				$totalprofit       = $total_sales_final - $profit;
			}

			//update doanh so db
			if($statistic_count>0){
				$statistic_update = Statistic::where('order_date',$order_date)->first();
				$statistic_update->sales = $statistic_update->sales + $total_sales_final;
				$statistic_update->profit =  $statistic_update->profit + $totalprofit;
				$statistic_update->quantity =  $statistic_update->quantity + $totalquantity;
				$statistic_update->total_order = $statistic_update->total_order + $totalorder;
				$statistic_update->save();

			}else{

				$statistic_new = new Statistic();
				$statistic_new->order_date = $order_date;
				$statistic_new->sales = $total_sales_final;
				$statistic_new->profit =  $totalprofit;
				$statistic_new->quantity =  $totalquantity;
				$statistic_new->total_order = $totalorder;
				$statistic_new->save();
			}
		}
	}

    public function manage_order(){
        $admin_id   = Session::get('admin_id');
        $admin_role = Session::get('admin_role');
        if($admin_id && $admin_role==1){
	    	$order = Order::join('tbl_shipping','tbl_order.shipping_id','tbl_shipping.shipping_id')->orderby('tbl_order.order_id','DESC')->paginate(5);
	    	return view('admin.manage_order')->with('order',$order);
        }else{
            return view('errors.404');
        }
    }



 	public function history(Request $request){
		if(!Session::get('customer_id')){
			return redirect('/login-checkout')->with('alert','Please login to view purchase history');
		}else{

	        //seo 
	        $meta_desc = "Orderer"; 
	        $meta_keywords = "Orderer";
	        $meta_title = "Orderer";
	        $meta_canonical = $request->url();
	        
    		$cate_product = DB::table('tbl_category_product')->where('category_status','1')->where('category_parent','0')->orderby('category_id','desc')->get(); 
	        
	        $brand_product = DB::table('tbl_brand')->where('brand_status','1')->orderby('brand_id','desc')->get(); 

	        $getorder = Order::where('customer_id',Session::get('customer_id'))->orderby('order_id','DESC')->paginate(8);

	    	return view('pages.dashboard.history')->with('category',$cate_product)->with('brand',$brand_product)->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('meta_canonical',$meta_canonical)->with('getorder',$getorder); //1
		}
	}
	public function view_history_order(Request $request,$order_code){
		if(!Session::get('customer_id')){
			return redirect('/login-checkout')->with('alert','Please login to view purchase history');
		}else{
	        //seo 
	        $meta_desc = "Orderer"; 
	        $meta_keywords = "Orderer";
	        $meta_title = "Orderer";
	        $meta_canonical = $request->url();
	        //--seo
	        
    		$cate_product = DB::table('tbl_category_product')->where('category_status','1')->where('category_parent','0')->orderby('category_id','desc')->get(); 
	        
	        $brand_product = DB::table('tbl_brand')->where('brand_status','1')->orderby('brand_id','desc')->get(); 

	        
	        //xem lich sử
	        $order_details = OrderDetails::with('product')->where('order_code',$order_code)->get();
			$getorder = Order::where('order_code',$order_code)->first();
			
			$customer_id = $getorder->customer_id;
			$shipping_id = $getorder->shipping_id;
			$order_status = $getorder->order_status;
			
			$customer = Customer::where('customer_id',$customer_id)->first();
			$shipping = Shipping::where('shipping_id',$shipping_id)->first();

			$order_details_product = OrderDetails::with('product')->where('order_code', $order_code)->get();

			foreach($order_details_product as $key => $order_d){

				$product_coupon = $order_d->product_coupon;
			}
			if($product_coupon != 'no'){
				$coupon = Coupon::where('coupon_code',$product_coupon)->first();
				$coupon_condition = $coupon->coupon_condition;
				$coupon_number = $coupon->coupon_number;
			}else{
				$coupon_condition = 2;
				$coupon_number = 0;
			}

	    	return view('pages.dashboard.view_history_order')->with('category',$cate_product)->with('brand',$brand_product)->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('meta_canonical',$meta_canonical)->with('order_details',$order_details)->with('customer',$customer)->with('shipping',$shipping)->with('coupon_condition',$coupon_condition)->with('coupon_number',$coupon_number)->with('order_status',$order_status)->with('order_code',$order_code); //1
		}


	}

	public function destroy_order(Request $request, $order_code){
		if(!Session::get('customer_id')){
			return redirect('/login-checkout')->with('alert','Please login to view purchase history');
		}else{
	        $meta_desc = "Destroy Orderer"; 
	        $meta_keywords = "Destroy Orderer";
	        $meta_title = "Destroy Orderer";
	        $meta_canonical = $request->url();

			$cate_product = DB::table('tbl_category_product')->where('category_status','1')->where('category_parent','0')->orderby('category_id','desc')->get(); 
	        
	        $brand_product = DB::table('tbl_brand')->where('brand_status','1')->orderby('brand_id','desc')->get();

	        //xem lich sử
	        $order_details = OrderDetails::with('product')->where('order_code',$order_code)->get();
			return view('pages.dashboard.destroy_order')->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('meta_canonical',$meta_canonical)->with('category',$cate_product)->with('brand',$brand_product)->with('order_code',$order_code)->with('order_details',$order_details);
		}
	}


}
