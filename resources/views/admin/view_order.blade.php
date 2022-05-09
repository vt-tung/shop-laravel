@extends('admin_layout')
@section('admin_content')
<div class="table-agile-info">
  
  <div class="panel panel-default">
    <div class="panel-heading">
     Information of customer 
    </div>
    
    <div class="table-responsive">
      <?php
        $message = Session::get('message');
        if($message){
            echo '<span class="text-alert">'.$message.'</span>';
            Session::put('message',null);
        }
      ?>
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
           
            <th>Name customer</th>
            <th>Phone number</th>
            <th>Email</th>
            
          </tr>
        </thead>
        <tbody>
        
          <tr>
            <td>{{$customer->customer_name}}</td>
            <td>
              @if($customer->customer_phone)
                {{$customer->customer_phone}}
              @else
                N/A
              @endif
            </td>
            <td>{{$customer->customer_email}}</td>
          </tr>
     
        </tbody>
      </table>

    </div>
   
  </div>
</div>
<br>
<div class="table-agile-info">
  
  <div class="panel panel-default">
    <div class="panel-heading">
     SHIPPING INFORMATION

    </div>
    
    
    <div class="table-responsive">
      <?php
            $message = Session::get('message');
            if($message){
                echo '<span class="text-alert">'.$message.'</span>';
                Session::put('message',null);
            }
      ?>
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
           
            <th>Name</th>
            <th>Address</th>
            <th>Phone number</th>
            <th>Email</th>
            <th>Note</th>
            <th>Payments</th>
          
            
          </tr>
        </thead>
        <tbody>
        
          <tr>
            <td>{{$shipping->shipping_name}}</td>
            <td>{{$shipping->shipping_address}}</td>
            <td>{{$shipping->shipping_phone}}</td>
            <td>{{$shipping->shipping_email}}</td>
            <td>
              @if($shipping->shipping_note)
                {{$shipping->shipping_note}}
              @else
                N/A
              @endif
            </td>
            <td>@if($shipping->shipping_method==0) Transfer @else Pay by COD @endif</td>
            
          </tr>
     
        </tbody>
      </table>

    </div>
   
  </div>
</div>
<br><br>

<div class="table-agile-info">
  
  <div class="panel panel-default">
    <div class="panel-heading">
List order details
    </div>
   
    <div class="table-responsive">
      <?php
        $message = Session::get('message');
        if($message){
            echo '<span class="text-alert">'.$message.'</span>';
            Session::put('message',null);
        }
      ?>
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
            <th style="width:20px;">
              No
            </th>
            <th>Product name</th>
            <th>Product image</th>
            <th>In stock</th>
            <th>Color</th>
            <th>Size</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Total</th>
            
          </tr>
        </thead>
        <tbody>
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
          <tr>
           
            <td>{{$i}}</td>
            <td>{{$details->product_name}}</td>
            <td><img src="{{URL::to('public/uploads/product/'.$details->product->product_image)}}" style="width: 50px" /></td>
            <td>{{$details->product->product_qty}}</td>

            <td>{{$details->product_color}}</td>
            <td>{{$details->product_size}}</td>
            <td>
              <input type="number" min="1" {{$order_status==2 ? 'disabled' : ''}} class="order_qty_{{$details->product_id}}" value="{{$details->product_sales_quantity}}" name="product_sales_quantity" disabled="">

              <input type="hidden" name="order_qty_storage" class="order_qty_storage_{{$details->product_id}}" value="{{$details->product->product_quantity}}">

              <input type="hidden" name="order_code" class="order_code" value="{{$details->order_code}}">

              <input type="hidden" name="order_product_id" class="order_product_id" value="{{$details->product_id}}">
              <input type="hidden" name="order_details_id" class="order_details_id" value="{{$details->order_details_id}}">

            </td>
            <td>{{number_format($details->product_price ,0,',','.')}} VNĐ</td>
            <td>{{number_format($subtotal ,0,',','.')}} VNĐ</td>
          </tr>
        @endforeach
          <tr>
            <td colspan="9" style="text-align: right;">
              <strong>Tax:</strong> {{number_format($total*0.1,0,',','.')." "."VNĐ"}}.</br> 
              <strong>Shipping fee:</strong> {{number_format($details->product_feeship,0,',','.')}} VNĐ.</br>
              
              @if($details->product_coupon!='no')
                <strong>Discount code:</strong> {{$details->product_coupon}}.</br>
              @else
                <strong>Discount code:</strong> No discount code.</br>
              @endif

              @php 
                $total_coupon = 0;
              @endphp
              @if($coupon_condition==1)
                  @php
                    $total_coupon = $total + ($total*0.1) + $details->product_feeship ;
                    echo '<strong>Total decreased: </strong>'.number_format(($total_coupon*$coupon_number/100),0,',','.')." ".'VNĐ'.'.</br>';
                    $total_coupon_final = $total_coupon - ($total_coupon*$coupon_number/100);
                  @endphp
              @else 
                  @php
                    echo '<strong>Total decreased: </strong>'.number_format($coupon_number,0,',','.')." ".'VNĐ'.'.</br>';
                    $total_coupon_final = $total+ ($total*0.1) - $coupon_number + $details->product_feeship;
                  @endphp
              @endif
              @if($shipping->shipping_method==0) 
                <strong>Paid:</strong> {{number_format($total_coupon_final,0,',','.')}} VNĐ.</br>
                <strong>Payments method:</strong> Transfer.</br>
                <strong>Collect money from recipients:</strong> 0 VNĐ.

              @else 
                <strong>Payments method:</strong> Pay by COD.</br>
                <strong>Collect money from recipients:</strong> {{number_format($total_coupon_final,0,',','.')}} VNĐ.
              @endif
            </td>
          </tr>

          <tr>

            <td colspan="9">
            @foreach($order as $key => $or)
              @if($or->order_status==1)
                <form>
                   @csrf
                   <select class="form-control order_details">
                    
                    <option id="{{$or->order_id}}" selected value="1">Not processed yet</option>
                    <option id="{{$or->order_id}}" value="2">Order confirmation</option>
                    <option id="{{$or->order_id}}" value="3">Waiting for the goods</option>
                    <option id="{{$or->order_id}}" value="4">Delivering</option>
                    <option id="{{$or->order_id}}" value="5">Delivered</option>
                    <option id="{{$or->order_id}}" value="6">Cancel order</option>

                  </select>
                </form>
              @elseif($or->order_status==2)

                <form>
                  @csrf
                  <select class="form-control order_details">
                   
                    <option id="{{$or->order_id}}" value="1">Not processed yet</option>
                    <option id="{{$or->order_id}}" selected value="2">Order confirmation</option>
                    <option id="{{$or->order_id}}" value="3">Waiting for the goods</option>
                    <option id="{{$or->order_id}}" value="4">Delivering</option>
                    <option id="{{$or->order_id}}" value="5">Delivered</option>
                    <option id="{{$or->order_id}}" value="6">Cancel order</option>
                    
                  </select>
                </form>
              @elseif($or->order_status==3)
                <form>
                  @csrf
                  <select class="form-control order_details">
                   
                    <option id="{{$or->order_id}}" value="1">Not processed yet</option>
                    <option id="{{$or->order_id}}" value="2">Order confirmation</option>
                    <option id="{{$or->order_id}}" selected value="3">Waiting for the goods</option>
                    <option id="{{$or->order_id}}" value="4">Delivering</option>
                    <option id="{{$or->order_id}}" value="5">Delivered</option>
                    <option id="{{$or->order_id}}" value="6">Cancel order</option>
                    
                  </select>
                </form>
              @elseif($or->order_status==4)
                <form>
                  @csrf
                  <select class="form-control order_details">
                   
                    <option id="{{$or->order_id}}" value="1">Not processed yet</option>
                    <option id="{{$or->order_id}}" value="2">Order confirmation</option>
                    <option id="{{$or->order_id}}" value="3">Waiting for the goods</option>
                    <option id="{{$or->order_id}}" selected value="4">Delivering</option>
                    <option id="{{$or->order_id}}" value="5">Delivered</option>
                    <option id="{{$or->order_id}}" value="6">Cancel order</option>
                    
                  </select>
                </form>
              @elseif($or->order_status==5)
                <form>
                  @csrf
                  <select class="form-control order_details" disabled="">
                    <option id="{{$or->order_id}}" selected value="5">Delivered</option>                    
                  </select>
                </form>
              @else
                <form>
                  @csrf
                  <select class="form-control order_details" disabled="">
                    <option id="{{$or->order_id}}" selected value="6">Cancel order</option>
                  </select>
                </form>
              @endif
            @endforeach

            </td>
          </tr>
          <tr>
            @foreach($order as $key => $or)
              @if($or->order_destroy=="")
                {{''}}
              @else
                <td colspan="9">
                  <strong>Reason for order cancellation: </strong>{{$or->order_destroy}}
                </td>
             @endif
            @endforeach
          </tr>
        </tbody>
      </table>

    </div>
    @if($or->order_status!=1 && $or->order_status!=6)
      <div style="
        padding: 10px 17px;
        /* background-color: #000; */
        display: flex;
        justify-content: center;
      ">
          <a target="_blank" href="{{url('/print-order/'.$details->order_code)}}" style="    padding: 10px 20px;
            background-color: #000;
            text-decoration: none;
            color: #fff;
            font-size: 14px;
            text-transform: uppercase;">
            Print order
          </a>
      </div>
    @endif
  </div>
</div>
@endsection