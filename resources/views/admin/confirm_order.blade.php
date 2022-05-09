<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Order confirmation</title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<style type="text/css">
		table {
		    width: 100%;
		    border-collapse: collapse;
		    background-color: #fff;
		}

		.mail_table.order th {
		    vertical-align: middle;
		    padding-left: 10px;
		    padding-right: 10px;
		    text-transform: uppercase;
		}

		.mail_table.order td, .mail_table.order th {
		    vertical-align: middle;
		    padding-left: 10px;
		    padding-right: 10px;
		    font-size: 14px;
		    text-transform: capitalize;
		    border-bottom: 1px solid #ddd;
		}

		.mail_table th {
		    padding: 15px 0;
		    text-align: left;
		}

		.mail_table td {
		    padding: 15px 0;
		}
	</style>
</head>
<body>
	<div class="container" style="background: #222;border-radius: 12px;padding:15px;">
		<div class="col-md-12" >

			<p style="text-align: center;color: #fff">This is an automated email. Please do not reply to this email.</p>
			<div class="row" style="background: #d0b559; padding: 15px">

				
				<div class="col-md-6" style="text-align: center;color: #fff;font-weight: bold;font-size: 30px">
					<h4 style="margin:0">WILD SHOP</h4>
				</div>

				<div class="col-md-6 logo"  style="color: #fff">
					<p>Hi <strong style="color: #000;">{{$shipping_array['customer_name']}}</strong>, {{$shipping_array['status_order']}}</p>				
				</div>
				<div class="col-md-12">
					<p style="color:#fff;font-size: 17px;">You have placed an order at Wild Shop:</p>
					<h4 style="color: #000;text-transform: uppercase;font-size: 20px">Information Ordered:</h4>
					<table class="mail_table order info-customer">
						<thead>
							<tr>
								<th>No.</th>
								<th>Code orders</th>
								<th>Shipping fee</th>
								<th>Tax</th>
								<th>Promo code applies</th>
								<th>Service</th>
							</tr>
						</thead>

						<tbody>

							<tr>
								<td>1</td>
								<td>
									{{$code['order_code']}}
								</td>

								<td>
									{{number_format($shipping_array['fee_ship'],0,',','.').' '.'VNĐ'}}
								</td>

								<td>
									10%
								</td>

								<td>
									{{$code['coupon_code']}}
								</td>

								<td>
									Order online
								</td>

							</tr>

						</tbody>
					</table>

					<h4 style="color: #000;text-transform: uppercase; font-size: 20px">Receiver's information:</h4>

					<table class="mail_table order shipping">
						<thead>
							<tr>
								<th>No.</th>
								<th>Email</th>
								<th>Recipient's name</th>
								<th>Delivery address</th>
								<th>Phone number</th>
								<th>Note</th>
								<th>Payments</th>

							</tr>
						</thead>

						<tbody>


							<tr>
								<td>1</td>
								<td>
									@if($shipping_array['shipping_email']=='')
										<span>N/A</span>
									@else
										<span style="text-transform: lowercase;">{{$shipping_array['shipping_email']}}</span>
									@endif
								</td>

								<td>
									@if($shipping_array['shipping_name']=='')
										<span style="color:#000">N/A</span>
									@else
										<span style="color:#000">{{$shipping_array['shipping_name']}}</span>
									@endif
								</td>

								<td>
									@if($shipping_array['shipping_address']=='')
										<span style="color:#000">N/A</span>
									@else
										<span style="color:#000">{{$shipping_array['shipping_address']}}</span>
									@endif
								</td>

								<td>
									@if($shipping_array['shipping_phone']=='')
										<span style="color:#000">N/A</span>
									@else
										<span style="color:#000">{{$shipping_array['shipping_phone']}}</span>
									@endif
								</td>

								<td>
									@if($shipping_array['shipping_note']==NULL)
										<span style="color:#000">N/A</span>
									@else
										<span style="color:#000">{{$shipping_array['shipping_note']}}</span>
									@endif
								</td>

								<td>
									@if($shipping_array['shipping_method']==0)
										Transfer 
									@else
										Payment in cash
									@endif
								</td>
							</tr>

						</tbody>
					</table>
					<p style="color:#fff">If the consignee information is not available, we will contact the orderer to exchange information about the order placed..</p>

					<h4 style="color: #000;text-transform: uppercase; font-size: 20px;">Products ordered:</h4>

					<table class="mail_table order">
						<thead>
							<tr>
								<th>No.</th>
								<th>Product name</th>
								<th>Color</th>
								<th>Size</th>
								<th>Price</th>
								<th>Quantity</th>
								<th>Total</th>

							</tr>
						</thead>

						<tbody>
							@php
								$count = 0; 
								$subtotal = 0;
								$total = 0;
							@endphp	

							@foreach($cart_array as $cart)
								@php
									$count++; 
									$subtotal = $cart['product_qty']*$cart['product_price'];
									$total+=$subtotal;
								@endphp	

								<tr>
									<td>{{$count}}</td>
									<td>{{$cart['product_name']}}</td>
									<td>{{$cart['product_color']}}</td>
									<td>{{$cart['product_size']}}</td>
									<td>{{number_format($cart['product_price'],0,',','.')}} VNĐ</td>
									<td>{{$cart['product_qty']}}</td>
									<td>{{number_format($subtotal,0,',','.')}} VNĐ</td>
								</tr>
							@endforeach

							<tr>
								<td colspan="7" align="right">
									<div><strong>Tax: </strong>{{number_format($total*0.1,0,',','.')." "."VNĐ"}}</div>

									<div><strong>Shipping fee: </strong>{{number_format($shipping_array['fee_ship'],0,',','.').' '.'VNĐ'}}</div>

									@if($code['coupon_code']!='no')
										<div>Discount code: {{$code['coupon_code']}}</div>
									@endif

									@php 
										$total_coupon = 0;
									@endphp
									@if($code['coupon_condition']==1)
									  @php
									    $total_coupon = $total + ($total*0.1) + $shipping_array['fee_ship'] ;
									    echo '<div><strong>Total decreased : </strong>'.number_format(($total_coupon*$code['coupon_number']/100),0,',','.').'</div>';
									    $total_coupon_final = $total_coupon - ($total_coupon*$code['coupon_number']/100);
									  @endphp
									@else 
									  @php
									    echo '<div><strong>Total decreased : </strong>'.number_format($code['coupon_number'],0,',','.')." ".'VNĐ'.'</div>';
									    $total_coupon_final = $total + ($total*0.1) - $code['coupon_number'] + $shipping_array['fee_ship'];
									  @endphp
									@endif

									@if($shipping_array['shipping_method']==0)
										<div><strong>Paid: </strong>{{number_format($total_coupon_final,0,',','.').' '.'VNĐ'}}</div>
						                <div><strong>Payments method:</strong> Transfer.</div>
						                <div><strong>Collect money from recipients:</strong> 0 VNĐ.</div>
									@else
						                <div><strong>Payments method:</strong> Payment in cash.</div>
						                <div><strong>Collect money from recipients:</strong> {{number_format($total_coupon_final,0,',','.').' '.'VNĐ'}}.</div>
									@endif
								</td>
							</tr>

						</tbody>
					</table>

				</div>

				<p style="color:#fff">For more information, please contact the website at: <a target="_blank" href="{{URL::to('/')}}">WILD SHOP</a>, or contact via Hotline: 19005689. Thank you for ordering from our shop.</p>

			</div>
		</div>
	</div>
</body>

</html>