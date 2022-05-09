@extends('admin_layout')
@section('admin_content')
    <div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      List of orders
    </div>
    <div class="row w3-res-tb">
      <div class="col-sm-5 m-b-xs">
        <select class="input-sm form-control w-sm inline v-middle">
          <option value="0">Bulk action</option>
          <option value="1">Delete selected</option>
          <option value="2">Bulk edit</option>
          <option value="3">Export</option>
        </select>
        <button class="btn btn-sm btn-default">Apply</button>                
      </div>
      <div class="col-sm-4">
      </div>
      <div class="col-sm-3">
        <div class="input-group">
          <input type="text" class="input-sm form-control" placeholder="Search">
          <span class="input-group-btn">
            <button class="btn btn-sm btn-default" type="button">Go!</button>
          </span>
        </div>
      </div>
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
           
            <th>No</th>
            <th>Information</th>
            <th>Order method</th>
            <th>Date of order</th>
            <th>Order Status</th>

            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
          @php 
          $i = 0;
          @endphp
          @foreach($order as $key => $ord)
            @php 
            $i++;
            @endphp
          <tr>
            <td>{{$key+ $order->firstItem()}}</label></td>
            <td>
              <ul style="margin-left: 15px;" class="cl-content-product">
                <li><strong>Order Id: </strong>{{$ord->order_code }}</li>
                <li><strong>Email: </strong>{{$ord->shipping_email }}</li>
                <li><strong>Name: </strong>{{$ord->shipping_name}}</li>
                <li><strong>Address: </strong>{{$ord->shipping_address}}</li>
              </ul>
            </td>
            <td>
              @if($ord->shipping_method==0)
                <span class="badge badge-primary">Transfer</span>
              @else
                <span class="badge badge-dark">Pay by COD</span>
              @endif
            </td>
            <td>{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$ord->order_date)->format('H:i:s d/m/Y')}}</td>
            <td>
                @if($ord->order_status==1)
                  New orders
                @elseif($ord->order_status==2) 
                  Order confirmed
                @elseif($ord->order_status==3)
                  Waiting for the goods
                @elseif($ord->order_status==4)
                  Delivering
                @elseif($ord->order_status==5)
                  Delivered  
                @elseif($ord->order_status==6)
                  Cancelled 
                @endif
            </td>
            <td>
              <a href="{{URL::to('/view-order/'.$ord->order_code)}}" class="active styling-edit" ui-toggle-class="">
                <i class="fa fa-eye text-success text-active"></i></a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <footer class="panel-footer">
      <div class="row">
        
        <div class="col-sm-5 text-left">
          <small>Showing item {{$order->firstItem()}} to {{$order->lastItem()}} of {{$order->total()}} results</small>
        </div>
        <div class="col-sm-7 text-right text-center-xs">                
          <ul class="pagination pagination-sm m-t-none m-b-none">
              {!!$order->links()!!}
          </ul>
        </div>
      </div>
    </footer>
  </div>
</div>
@endsection