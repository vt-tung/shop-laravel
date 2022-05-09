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
         <form class="main-content">
          @csrf
            @if (count(Cart::content()))
               @php
                  $total = 0;
                  $qty = 0;
                  $count=0;
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
                                         <p class="cl-title"><span>Color:</span> {{$v_content->options->size_name}}</p>
                                         <p class="cl-title"><span>Size:</span> {{$v_content->options->color_name}}</p>
                                      </div>
                                   </div>
                                 </td>
                                 <td>
                                    {{number_format($v_content->price).' '.'VNĐ'}}                                   
                                 </td>
                                 <td>
                                    <form action="{{URL::to('/update-cart-quantity')}}" method="POST">
                                       {{ csrf_field() }}
                                       <input type="hidden" value="{{$v_content->rowId}}" name="rowId_cart" class="form-control">
                                       <div class="cl-box-quantity-cart">
                                          <button type="button" class="cl-bt-qty minus">-</button>
                                          <input class="qty-box" type="number" name="cart_quantity" value="{{$v_content->qty}}" min="0">
                                          <button type="button" class="cl-bt-qty plus">+</button>
                                       </div>
                                       <input type="submit" name="update_qty" value="Update">
                                    </form>
                                 </td>
                                 <td>                  
                                    {{number_format($subtotal,0,',','.')." "."VNĐ"}}

                                 </td>
                                 <td class="product-remove">
                                  <a href="{{URL::to('/delete-to-cart/'.$v_content->rowId)}}"><i class="xoa far fa fa-trash-o "></i></a>
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

                           <tr class="order-total">
                               <td>Total</td>
                               <td>
                                 <span class="price"> 
                                       <?php
                                         $totalvat = $total + $total*0.1;
                                         echo number_format($totalvat,0,',','.').' '."VNĐ";
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
                       <?php
                          $customer_id = Session::get('customer_id');
                           if($customer_id!=NULL){ 
                              ?>
                              <a href="{{URL::to('/checkout')}}" class="button medium update-cartbutton">Check out</a>
                              <?php
                           }else{
                               ?>
                              <a href="{{URL::to('login-checkout')}}" class="button medium update-cartbutton">Check out</a>
                               <?php 
                           }
                       ?>                         
                        <a href="{{URL::to('home-pages')}}" class="button medium checkout-button">Continue Shopping</a>
                     </div>
                  </div>
               </div>
            @else
            <div class="alert alert-info text-center m-0" role="alert">
                Your Cart is <b>empty</b>.
            </div>
            @endif
         </form>
      </div>
   </div>
</div>
@endsection