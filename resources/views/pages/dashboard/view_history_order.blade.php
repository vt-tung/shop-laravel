@extends('layout')
@section('content')
<div class="cl-dashboard">
    <div class="container">
      <div class="cl-breacrumb-product" style="margin-top: 0">
          <div class="cl-list-breacrumb">
             <ul class="cl-content-breacrumb">
                <li><a href="{{URL::to('/')}}" class="cl-link" title="">Home</a></li>
                <li><a href="{{URL::to('/history-order')}}" class="cl-link" title="">Ordered</a></li>
                <li><span class="cl-link disabled">Order {{$order_code}}</span></li>
             </ul>
          </div>
      </div>
      <div class="row">
        <div class="col-md-12 cl-main-dashboard">
           <div class="cl-info-customer">
              <div class="cl-ordered-customer">
                 <div class="cl-hello-dashboard" style="margin: 0">
                    <p><strong>Your Information :</strong></p>
                 </div>
                 <div class="cl-products-ordered" style="max-height: 400px; overflow: auto">
                    <table class="shop_table cart table table-bordered table-customize">
                       <tbody>
                          <tr>
                             <th width="2%">No</th>
                             <th width="10%">Name</th>
                             <th width="10%">Phone number</th>
                             <th width="10%">Email</th>
                          </tr>
                          <tr>
                            <td>1</td>
                            <td>{{$customer->customer_name}}</td>
                            <td>
                              
                              @if($customer->customer_phone == true)
                                {{$customer->customer_phone}}
                              @else
                                N/A
                              @endif
                            </td>
                            <td><span style="text-transform: lowercase;">{{$shipping->shipping_email}}</span></td>
                          </tr>
                       </tbody>
                    </table>
                 </div>
              </div>

              <div class="cl-ordered-customer" style="margin-top: 40px!important;">
                 <div class="cl-hello-dashboard" style=" margin: 0">
                    <p><strong>Consignee information :</strong></p>
                 </div>
                 <div class="cl-products-ordered" style="max-height: 400px; overflow: auto">
                    <table class="shop_table cart table table-bordered table-customize">
                       <tbody>
                            <tr>
                              <th width="2%">No</th>
                              <th>Name of carrier</th>
                              <th>Address</th>
                              <th>Phone number</th>
                              <th>Email</th>
                              <th>Notes</th>
                              <th>Form of payment</th>
                            </tr>
                            <tr>
                              <td>1</td>
                              <td>{{$shipping->shipping_name}}</td>
                              <td>{{$shipping->shipping_address}}</td>
                              <td>{{$shipping->shipping_phone}}</td>
                              <td>
                                <span style="text-transform: lowercase;">{{$shipping->shipping_email}}</span>
                              </td>
                              <td>
                                @if($shipping->shipping_note==true)
                                  {{$shipping->shipping_note}}
                                @else
                                  N/A
                                @endif
                              </td>
                              <td>@if($shipping->shipping_method==0) Transfer @else Pay by cash @endif</td>
                              
                              
                            </tr>
                       </tbody>
                    </table>
                 </div>
              </div>

              <div class="cl-ordered-customer" style="margin-top: 40px!important;">
                 <div class="cl-hello-dashboard" style=" margin: 0">
                    <p><strong>List order details :</strong></p>
                 </div>
                 <div class="cl-products-ordered" style="overflow: auto">
                    <table class="shop_table cart table table-bordered table-customize">
                       <tbody>
                          <tr>
                            <th>No.</th>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Total amount</th>
                          </tr>
                          @php 
                            $i = 0;
                            $total = 0;
                          @endphp

                          @foreach($order_details as $key => $details)
                            @php 
                              $i++;
                              $subtotal = $details->product_price*$details->product_sales_quantity;
                              $total+=$subtotal;
                            @endphp
                          <tr class="color_qty_{{$details->product_id}}">
                           
                            <td>{{$i}}</td>

                            <td class="product-thumbnail">
                              <div class="cl-cart_thumbnail-content">
                                 <a href="{{URL::to('/detail-product/'.$details->product->product_id)}}" class="cl-cart_thumbnail-left">
                                    <img src="{{URL::to('public/uploads/product/'.$details->product->product_image)}}" alt="Southern wind bomber AG-0876">
                                 </a>
                                 <div class="cl-cart_thumbnail-right">
                                    <p class="cl-title" style="white-space: nowrap;"><span>Name:</span> {{$details->product_name}}</p>
                                    @if($details->product_color=='no' && $details->product_size!='no')
                                      <p class="cl-title"><span>Size:</span> {{$details->product_size}}</p>
                                    @elseif($details->product_color!='no' && $details->product_size=='no')
                                      <p class="cl-title"><span>Color:</span> {{$details->product_color}}</p>
                                    @elseif($details->product_color=='no' && $details->product_size=='no')
                                      {{''}}
                                    @else
                                      <p class="cl-title"><span>Color:</span> {{$details->product_color}}</p>
                                      <p class="cl-title"><span>Size:</span> {{$details->product_size}}</p>
                                    @endif

                                 </div>
                              </div>
                            </td>

                            <td>
                              {{$details->product_sales_quantity}}
                              <input type="hidden" min="1" readonly disabled class="order_qty_{{$details->product_id}}" value="{{$details->product_sales_quantity}}" name="product_sales_quantity">

                              <input type="hidden" name="order_qty_storage" class="order_qty_storage_{{$details->product_id}}" value="{{$details->product->product_qty}}">

                              <input type="hidden" name="order_code" class="order_code" value="{{$details->order_code}}">

                              <input type="hidden" name="order_product_id" class="order_product_id" value="{{$details->product_id}}">

                            

                            </td>
                            <td>{{number_format($details->product_price ,0,',','.')}}đ</td>
                            <td>{{number_format($subtotal ,0,',','.')}}đ</td>
                          </tr>
                          @endforeach
                          <tr>
                            <td colspan="5" align="right">  
                              @php 
                                $total_coupon = 0;
                              @endphp
                              <div><strong>Tax: </strong>{{number_format($total*0.1,0,',','.')." "."VNĐ"}}.</div>
                              <div>
                                <strong>Shipping fee: </strong> {{number_format($details->product_feeship,0,',','.').' '.'VNĐ'}}.
                              </div>
                              @if($details->product_coupon!='no')
                                <div>
                                  <strong>Discount code: </strong>{{$details->product_coupon}}.
                                </div>
                              @else
                                <div>
                                  <strong>Discount code: </strong>No discount code.
                                </div>
                              @endif
                              @if($coupon_condition==1)
                                @php
                                  $total_after_coupon = $total + ($total*0.1) + $details->product_feeship;
                                  echo '<div><strong>Total decreased: </strong>'.number_format($total_after_coupon*$coupon_number/100,0,',','.').' ' .'VNĐ'.'.</div>';
                                  $total_coupon = $total_after_coupon - ($total_after_coupon*$coupon_number/100);
                                @endphp
                              @else 
                                @php
                                  echo '<div><strong>Total decreased:  </strong>'.number_format($coupon_number,0,',','.').' ' .'VNĐ'.'.</div>';
                                  $total_coupon = $total + ($total*0.1) + $details->product_feeship - $coupon_number ;
                                @endphp
                              @endif

                              @if($shipping->shipping_method==0) 
                                <div><strong>Paid: </strong> {{number_format($total_coupon,0,',','.').' '.'VNĐ'}}.</div>
                                <div><strong>Payments method:</strong> Transfer.</div>
                                <div><strong>Pay:</strong> 0 VNĐ.</div>
                              @else 
                                <div><strong>Payments method:</strong> Payment in cash.</div>
                                <div><strong>Pay:</strong> {{number_format($total_coupon,0,',','.').' '.'VNĐ'}}.</div>
                              @endif
                            </td>
                          </tr>
                       </tbody>
                    </table>
                 </div>
              </div>
           </div>
        </div>

      </div>



  </div>
  
</div>

@endsection