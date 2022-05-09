@extends('layout')
@section('content')

<section id="cart_items">
    <div class="container th-banner r">
      <div class="cl-breacrumb-product register-req">
        <div class="cl-list-breacrumb">
          <ul class="cl-content-breacrumb">
            <li><a href="{{URL::to('/')}}" class="cl-link" title="">Home</a></li>
            <li><span class="cl-link disabled">Check out</span></li>
          </ul>
        </div>
      </div>
        @if(session()->has('message'))
            <div class="success">
                {!! session()->get('message') !!}
            </div>
        @elseif(session()->has('error'))
             <div class="alert alert-danger">
                {!! session()->get('error') !!}
            </div>
        @endif
      <div class="review-payment" style="margin-top: 40px">

              <div class="main-content">
                {{ csrf_field() }}

                  @if (count(Cart::content()))
                     @php
                        $total = 0;
                        $qty = 0;
                        $count=0;
                     @endphp
                     <div class="th-form-login row">
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
                                    </tr>
                                 </thead>
                                 <tbody>
                                    @foreach(Cart::content() as $v_content)
                                       @php
                                          $count++;
                                          $subtotal = $v_content->price * $v_content->qty;
                                          $total+=$subtotal;
                                          $qty+=$v_content->qty;
                                       @endphp
                                    <tr>
                                       <td colspan="" rowspan="" headers="">{{$count}}</td>
                                       <td class="product-thumbnail">

                                         <div class="cl-cart_thumbnail-content">
                                            <a href="{{URL::to('/detail-product/'.$v_content->id)}}" class="cl-cart_thumbnail-left">
                                             <img src="{{URL::to('public/uploads/product/'.$v_content->options->image)}}" alt="{{URL::to('public/uploads/product/'.$v_content->options->image)}}">
                                            </a>
                                            <div class="cl-cart_thumbnail-right">
                                               <p class="cl-title" style="white-space: nowrap;"><span>Name:</span> {{$v_content->name}}</p>
                                                  @if($v_content->options->color_id=='no' && $v_content->options->size_id!='no')
                                                   <p class="cl-title"><span>Size:</span> {{$v_content->options->size_name}}</p>
                                                  @elseif($v_content->options->color_id!='no' && $v_content->options->size_id=='no')
                                                   <p class="cl-title"><span>Color:</span> {{$v_content->options->color_name}}</p>
                                                  @elseif($v_content->options->color_id=='no' && $v_content->options->size_id=='no')
                                                    {{''}}
                                                  @else
                                                   <p class="cl-title"><span>Color:</span> {{$v_content->options->color_name}}</p>
                                                   <p class="cl-title"><span>Size:</span> {{$v_content->options->size_name}}</p>
                                                  @endif

                                            </div>
                                         </div>
                                       </td>
                                       <td>
                                          {{number_format($v_content->price).' '.'VNĐ'}}                                   
                                       </td>
                                       <td>
											                     {{$v_content->qty}}
                                       </td>
                                       <td>                  
                                          {{number_format($subtotal,0,',','.')." "."VNĐ"}}

                                       </td>

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
                                                echo number_format($vat,0,',','.').' '."VNĐ";
                                             ?>
                                          )
                                       </span>
                                    </td>
                                 </tr>
                                  @if(Session::get('fee'))
                                    <tr>
                                      <td>Shipping fee:</td>
                                      <td>
                                        <a class="cart_quantity_delete" href="{{url('/del-fee')}}"><i class="fa fa-times"></i></a>
                                        {{number_format(Session::get('fee'),0,',','.')}}đ

                                      </td>
                                    </tr>
                  
                                  @endif 
                                  <tr class="order-total">
                                      <td>Total</td>
                                      <td>
                                        <span class="price "> 
                                              <?php
                                                $totalvat = ($total + $total*0.1) + Session::get('fee');
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
                                                            {{number_format($cou['coupon_number'],0,',','.')." "."VNĐ"}} 
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
                              <td>
                                 @if(Session::get('coupon'))
                                          <a class="button medium checkout-button" href="{{url('/unset-coupon')}}">Delete coupon</a>
                                 @endif
                              </td>
  
                           </div>
                        </div>
	                   <div class="col-12 box-coupon" style="margin-bottom: 40px;">
	                       <form method="POST" action="{{url('/check-coupon')}}" class="coupon">
	                           @csrf
	                           <h3 class="coupon-box-title">Coupon</h3>
	                           <div class="inner-box">
	                               <input type="text" name="coupon" class="input-text" id="coupon_code" value="" placeholder="Coupon code">
	                               <input type="submit" name="check_coupon" class="button Apply_Coupon" name="apply_coupon" value="Apply Coupon">
	                           </div>
	                       </form>
	                   </div>
      						<div class="th-form col-md-12 @if(Session::get('fee')) col-lg-6 @else col-lg-12 @endif">
                      <h1 class="th-title" style="font-size: 22px">Charge Shipping </h1>
      						   <form  class="login-form">
      						      @csrf
      				                <table>
      				                  <tbody>
      				                    <tr>
      				                      <td>
      				                        <div class="form-group">
              									         <label class="cl-label-form" for="exampleInputPassword1">Select city or province :</label>
              									         <select name="city" id="city" class="th-form-control input-sm m-bot15 choose city">
              									            <option value="">--Select city or province--</option>
              									            @foreach($city as $key => $ci)
              									             <option value="{{$ci->matp}}">{{$ci->name_city}}</option>
              									            @endforeach
              									         </select>
      				                        </div>
      				                      </td>
      				                    </tr>
      				                    <tr>
      				                      <td>
      									      <div class="form-group">
      									         <label class="cl-label-form" for="exampleInputPassword1">Select District :</label>
      									         <select name="province" id="province" class="th-form-control input-sm m-bot15 province choose">
      									            <option value="">--Select District--</option>
      									         </select>
      									      </div>
      				                      </td>
      				                    </tr>
      				                    <tr>
      				                      <td>
      									      <div class="form-group">
      									         <label class="cl-label-form" for="exampleInputPassword1">Select Commune :</label>
      									         <select name="wards" id="wards" class="th-form-control input-sm m-bot15 wards">
      									            <option value="">--Select Commune--</option>
      									         </select>
      									      </div>

      				                      </td>
      				                    </tr>
      				                  </tbody>
      				                </table>
      				                <div class="th-form-check">
      				                  <button type="button" name="calculate_order" class="th-btn calculate_delivery">Charge shipping</button>
      				                </div>
      						   </form>
      						</div>
					 	       @if(Session::get('fee'))
				          	<div class="th-form col-md-6 col-lg-6" style="border-left: 1.5px">
				            	<h1 class="th-title" style="font-size: 22px">Shipping information</h1>

				              <form action="{{url('/confirm-order')}}" method="POST" class="login-form">
				                {{csrf_field()}}

				                  @if(Session::get('fee'))
				                    <input type="hidden" name="order_fee" class="order_fee" value="{{Session::get('fee')}}">
				                  @else 
				                    <input type="hidden" name="order_fee" class="order_fee" value="10000">
				                  @endif

        									@if(Session::get('coupon'))
        										@foreach(Session::get('coupon') as $key => $cou)
        											<input type="hidden" name="order_coupon" class="order_coupon" value="{{$cou['coupon_code']}}">
                                       @if($cou['coupon_condition']==1)
                                          <input type="hidden" name="total_pay" class="cl-total_pay" value="{{$totalvat-$total_coupon}}">
                                       @elseif($cou['coupon_condition']==2)
                                          <input type="hidden" name="total_pay" class="cl-total_pay" value="{{$total_coupon}}">
                                       @endif   
        										@endforeach

        									@else 
        										<input type="hidden" name="order_coupon" class="order_coupon" value="no">
                                    <input type="hidden" name="total_pay" class="cl-total_pay" value="{{$totalvat}}">
        									@endif

				                <table>
				                  <tbody>
				                    <tr>
				                      <td>
				                        <div class="form-group">
                                  <label class="cl-label-form" for="exampleInputPassword1">Email :</label>

				                          <input type="text" class="th-form-control shipping_email" name="shipping_email" placeholder="Email..." value="{{$customer_infor->customer_email}}" required="">
				                        </div>
				                      </td>
				                    </tr>
				                    <tr>
				                      <td>
				                        <div class="form-group">
                                  <label class="cl-label-form" for="exampleInputPassword1">Name :</label>
				                          <input type="text" class="th-form-control shipping_name" name="shipping_name" placeholder="Name..." value="{{$customer_infor->customer_name}}" required="">
				                        </div>
				                      </td>
				                    </tr>
				                    <tr>
				                      <td>
				                        <div class="form-group">
                                  <label class="cl-label-form" for="exampleInputPassword1">Phone number :</label>
				                          <input type="text" class="th-form-control shipping_phone" name="shipping_phone" placeholder="Phone..." value="{{$customer_infor->customer_phone}}" required="">
				                        </div>
				                      </td>
				                    </tr>
				                    <tr>
				                      <td>
				                        <div class="form-group">
                                   <label class="cl-label-form" for="exampleInputPassword1">Address :</label>
				                          <input type="text" class="th-form-control shipping_address" name="shipping_address" placeholder="Address..." value="{{$customer_infor->customer_address}}" required="">
				                        </div>
				                      </td>
				                    </tr>
				                    <tr>
				                      <td>
				                        <div class="form-group">
                                  <label class="cl-label-form" for="exampleInputPassword1">Note :</label>
				                          <textarea type="password"  rows="5" class="th-form-control shipping_note" name="shipping_note" placeholder="Note..."></textarea>
				                        </div>
				                      </td>
				                    </tr>
				                    <tr>
				                      <td>
				                        <div class="form-group">
                                    <label class="cl-label-form" for="">Choose a form of payment :</label>
                                    <select name="shipping_method"  class="th-form-control payment_select">
                                      <option value="1">Pay by COD</option>
                                      <option value="0">Transfer by VNPAY</option>   
                                    </select>
				                        </div>
				                      </td>
				                    </tr>
				                  </tbody>
				                </table>
				                <div class="th-form-check">
				                  <button name="send_order" type="button" class="th-btn send_order">Order confirmation</button>
                              <button name="send_ordered" type="submit" class="th-btn order-online" style="display:none;">Order confirmation</button>

				                </div>			                  

				              </form>
				          	</div>
			          	@endif
                  @else
                    <div style="text-align: center;">
                         <img src="<?php echo url('public/frontend/images/cartempty.png') ?>" alt="<?php echo url('public/frontend/images/cartempty.png') ?>" style="width: 250px">
                          <p style="
                              color: #000;
                              font-size: 20px;
                              font-weight: 600;
                          ">
                              Your Cart is empty.
                          </p>
                    </div>
                  @endif
              </div>
      </div>
      

    </div>
  </section> <!--/#cart_items-->

@endsection
