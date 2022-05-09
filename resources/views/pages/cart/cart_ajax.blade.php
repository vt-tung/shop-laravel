@extends('layout')
@section('content')

<div class="main-container no-sidebar">
  	<div class="main-container no-sidebar">
      <div class="container">
		<div class="cl-breacrumb-product" style="margin-top: 0">
			<div class="cl-list-breacrumb">
				<ul class="cl-content-breacrumb">
					<li><a href="{{URL::to('/')}}" class="cl-link" title="">Home</a></li>
					<li><span class="cl-link disabled">Your Cart</span></li>
				</ul>
			</div>
		</div>
	  	@if(session()->has('message'))
            <div class="alert true">
                {{ session()->get('message') }}
            </div>
        @elseif(session()->has('error'))
             <div class="alert">
                {{ session()->get('error') }}
            </div>
        @endif
          <form action="{{url('/update-cart')}}" method="POST" class="main-content">
          	{{ csrf_field() }}

			@if(Session::get('cart')==true)
				@php
						$total = 0;
						$qty = 0;
				@endphp
              <div class="row">
                  <div class="col-md-12 col-lg-8">
                      <div class="table-responsive">
                        <table class="shop_table cart table table-bordered table-customize">
                            <thead>
                                <tr>
                                  <th class="product-price">NO</th>
                                    <th colspan="" class="product-name">Product</th>
                                    <th class="product-price">Price</th>
                                    <th class="product-quantity">Qty</th>
                                    <th class="product-subtotal">Total</th>
                                    <th class="product-remove">Delete</th>
                                </tr>
                            </thead>
                            <tbody>

								@foreach(Session::get('cart') as $key => $cart)
									@php
										$subtotal = $cart['product_price']*$cart['product_qty'];
										$total+=$subtotal;
										$qty+=$cart['product_qty'];
									@endphp
                                <tr>
                                  <td colspan="" rowspan="" headers="">1</td>
                                    <td class="product-thumbnail"><img src="{{asset('public/uploads/product/'.$cart['product_image'])}}" alt="{{$cart['product_name']}}"><a href="#">{{$cart['product_name']}}</a></td>
                                    <td>
                                    	{{number_format($cart['product_price'],0,',','.')." "."VNĐ"}}
                                    </td>
                                    <td>
										<div >
											<input type="hidden" value="" name="rowId_cart" class="form-control">
                                            <div class="cl-box-quantity-cart">
                                              <button type="button" class="cl-bt-qty minus">-</button>
                                              <input class="qty-box cart_quantity" type="number" name="cart_qty[{{$cart['session_id']}}]" value="{{$cart['product_qty']}}" min="1">
                                              <button type="button" class="cl-bt-qty plus">+</button>
                                            </div>
                                         </div>
                                    </td>
                                    <td>									
										{{number_format($subtotal,0,',','.')." "."VNĐ"}}
									</td>
                                    <td class="product-remove"><a href="{{url('/del-product/'.$cart['session_id'])}}"><i class="xoa far fa fa-trash-o "></i></a></td>
                                </tr>

								@endforeach
                            </tbody>
                        </table>
                      </div>


                  </div>
                  <div class="col-md-12 col-lg-4">
                      <div class="box-cart-total">
                          <h2 class="title">Cart Totals</h2>
                          <table>
                              <tr>
                                  <td>Subtotal</td>
                                  <td>
                                  	<span class="price">
                                  		{{number_format($total,0,',','.')." "."VNĐ"}}
                              		</span>
                              	  </td>
                              </tr>
                              <tr>
                                  <td>Total quantity</td>
                                  <td>
                                  	<span class="price">
                                  		{{$qty}}
                                    </span>
                                  </td>
                              </tr>
                              <tr>
                                  <td>Tax</td>
                                  <td>
                                  	<span class="price">
                                  		10%(
	                                  		<?php
	                                  			$vat = $total*0.1;
	                                  			echo $vat.' '."VNĐ";
	                                  		?>
                                  		)
                                    </span>
                                  </td>
                              </tr>

                              <tr class="order-total">
                                  <td>Total</td>
                                  <td>
                                  	<span class="price"> 
                                          <?php
                                            $totalvat = $total + $total*0.1;
                                            echo number_format($totalvat).' '."VNĐ";
                                          ?>
                                  	</span>

                                  </td>
                              </tr>

							@if(Session::get('coupon'))
									@foreach(Session::get('coupon') as $key => $cou)
										@if($cou['coupon_condition']==1)
				                             <tr>
				                                <td>Reduced code:</td>
				                                <td>
				                                 <span class="price">
													{{$cou['coupon_number']}} %
				                                  </span>
				                                </td>
				                             </tr>
											@php 
												$total_coupon = ($totalvat*$cou['coupon_number'])/100;
												echo '
						                             <tr>
						                                <td>Total reduction:</td>
						                                <td>
						                                 <span class="price">
						                                 	'.number_format($total_coupon,0,',','.').' VNĐ
						                                  </span>
						                                </td>
						                             </tr>
												';
											@endphp
				                              <tr class="order-total">
				                                  <td>Total has decreased:</td>
				                                  <td>
				                                  	<span class="price"> 
														{{number_format($totalvat-$total_coupon,0,',','.')." "."VNĐ"}}
				                                  	</span>

				                                  </td>
				                              </tr>
										@elseif($cou['coupon_condition']==2)
				                             <tr>
				                                <td>Reduced code:</td>
				                                <td>
				                                 <span class="price">
												{{$cou['coupon_number']." "."VNĐ"}} 
				                                  </span>
				                                </td>
				                             </tr>
												@php 
													$total_coupon = $totalvat - $cou['coupon_number'];
												@endphp
				                              <tr class="order-total">
				                                  <td>Total has decreased:</td>
				                                  <td>
				                                  	<span class="price"> 
														{{number_format($total_coupon,0,',','.')." "."VNĐ"}}
				                                  	</span>

				                                  </td>
				                              </tr>

										@endif
									@endforeach
							@endif 
                          </table>
							<td><input type="submit" value="Update cart" name="update_qty" class="button medium checkout-button"></td>
							<td>
								@if(Session::get('coupon'))
	                          		<a class="button medium checkout-button" href="{{url('/unset-coupon')}}">Delete coupon</a>
								@endif
							</td>

                          <?php
                             $customer_id = Session::get('customer_id');
                              if($customer_id!=NULL){ 
	                              ?>
	                      			<a href="{{URL::to('/checkout')}}" class="button medium update-cartbutton">pay now</a>
	                              <?php
                              }else{
                                  ?>
                          			<a href="{{URL::to('login-checkout')}}" class="button medium update-cartbutton">pay now</a>
                                  <?php 
                              }
                          ?>                            



                      </div>
                  </div>

              </div>
			@else 
			<tr>
				<td colspan="5"><center>
				@php 
					echo 'Please add product to cart';
				@endphp
				</center></td>
			</tr>
			@endif
          </form>
          @if(Session::get('cart'))
	          <div class="col-12 box-coupon">
	              <form method="POST" action="{{url('/check-coupon')}}" class="coupon">
	              		@csrf
	                  <h3 class="coupon-box-title">Coupon</h3>
	                  <div class="inner-box">
	                      <input type="text" name="coupon" class="input-text" id="coupon_code" value="" placeholder="Coupon code">
	                      <input type="submit" name="check_coupon" class="button Apply_Coupon" name="apply_coupon" value="Apply Coupon">
	                  </div>
	              </form>
	          </div>
          @endif
      </div>
    </div>
</div>


@endsection
