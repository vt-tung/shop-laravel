@extends('layout')
@section('content')
<div class="cl-dashboard">
   <div class="container">
    <div class="cl-breacrumb-product" style="margin-top: 0">
        <div class="cl-list-breacrumb">
           <ul class="cl-content-breacrumb">
                <li><a href="{{URL::to('/')}}" class="cl-link" title="">Home</a></li>
                <li><a href="{{URL::to('/history-order')}}" class="cl-link" title="">Ordered</a></li>
                <li><span class="cl-link disabled">Destroy Order {{$order_code}}</span></li>
           </ul>
        </div>
    </div>
      <div class="row">

         <div class="col-md-12 cl-main-dashboard">
            <div class="cl-info-customer">
              <div class="cl-ordered-customer">
                 <div class="cl-hello-dashboard" style=" margin: 0">
                    <p><strong>List order details :</strong></p>
                 </div>
                 <div class="cl-products-ordered" style="overflow: auto">
                    <table class="shop_table cart table table-bordered table-customize">
                       <tbody>
                          <tr>
                            <th>No.</th>
                            <th>Product Name</th>
                            <th>Amount</th>
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
                                    <p class="cl-title"><span>Color:</span> {{$details->product_color}}</p>
                                    <p class="cl-title"><span>Size:</span> {{$details->product_size}}</p>
                                 </div>
                              </div>
                            </td>

                            <td>

                              <input type="number" min="1" readonly disabled class="order_qty_{{$details->product_id}}" value="{{$details->product_sales_quantity}}" name="product_sales_quantity">

                              <input type="hidden" name="order_qty_storage" class="order_qty_storage_{{$details->product_id}}" value="{{$details->product->product_qty}}">

                              <input type="hidden" name="order_code" class="order_code" value="{{$details->order_code}}">

                              <input type="hidden" name="order_product_id" class="order_product_id" value="{{$details->product_id}}">

                            

                            </td>
                            <td>{{number_format($details->product_price ,0,',','.')}}đ</td>
                            <td>{{number_format($subtotal ,0,',','.')}}đ</td>
                          </tr>
                          @endforeach

                       </tbody>
                    </table>
                 </div>
              </div>
              <div class="cl-ordered-customer"  style="margin-top: 40px!important;">
                 <div class="cl-hello-dashboard" style=" margin-bottom: 20px">
                    <p><strong>Reason for order cancellation: </strong></p>
                 </div>
                <form method="POST">
                  @csrf
                  <div class="cl-reason_destroy_order">
                    <textarea name="note" rows="8" class="form-control cl-txt_reason_destroy_order" placeholder="Reason for order cancellation(*)" ></textarea>
                  </div>
                  <div class="send-button">
                    <button type="button" name="send" class="button cl-cancel_order_button">Cancel order</button>
                  </div>
                </form>
              </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection