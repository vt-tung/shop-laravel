@extends('layout')
@section('content')

<div class="main-container no-sidebar">
  	<div class="main-container no-sidebar">
      <div class="container">
		<div class="cl-breacrumb-product" style="margin-top: 0">
			<div class="cl-list-breacrumb">
				<ul class="cl-content-breacrumb">
					<li><a href="index.php" class="cl-link" title="">Home</a></li>
					<li><span class="cl-link disabled">Payment</span></li>
				</ul>
			</div>
		</div>
          <div class="main-content">
				<?php
					$content = Cart::content();
				?>
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
                                </tr>
                            </thead>
                            <tbody>
                            	@foreach($content as $v_content)
                                <tr>
                                  <td colspan="" rowspan="" headers="">1</td>
                                    <td class="product-thumbnail"><img src="{{URL::to('public/uploads/product/'.$v_content->options->image)}}" alt=""><a href="#">{{$v_content->name}}</a></td>
                                    <td>
                                    	{{number_format($v_content->price).' '.'VNĐ'}}                                   
                                    </td>
                                    <td>
										{{$v_content->qty}}
                                    </td>
                                    <td>									
	                                    <?php
											$total = $v_content->price * $v_content->qty;
											echo number_format($total).' '.'VNĐ';


										?>
									</td>

                                </tr>

								@endforeach

                            </tbody>
                        </table>
                      </div>


                  </div>
                  <div class="col-md-12 col-lg-4">
                      <div class="box-cart-total">
                          	<h2 class="title">Choose a form of payment</h2>
							<form method="POST" action="{{URL::to('/order-place')}}">
								{{ csrf_field() }}
								<div class="cl-payment-options">
										<div class="cl-payment_option">
											<label><input name="payment_option" value="2" type="radio" checked> Cash payment</label>
										</div>
										<div class="cl-payment_option">
											<label><input name="payment_option" value="1" type="radio"> Pay by ATM</label>
										</div>

										<div class="cl-payment_option">
											<label><input name="payment_option" value="3" type="radio"> Debit card payment</label>
										</div>
										<input type="submit" value="Order now" name="send_order_place" class="button medium checkout-button">

								</div>
							</form>                        
                      </div>
                  </div>
              </div>
          </div>
      </div>
    </div>
</div>


@endsection
