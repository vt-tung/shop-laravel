@extends('admin_layout')
@section('admin_content')
    <div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      List of customer
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
            $message = Session::get('messagecustomer');
            if($message){
                echo '<span class="text-success">'.$message.'</span>';
                Session::put('messagecustomer',null);
            }
      ?>
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
            <th style="width:20px;">
              No.
            </th>
            <th>Customer name </th>
            <th>Customer email </th>
            <th>Customer phone </th>
            <th>Customer address</th>
            <th>Status</th>
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
          @foreach($all_customer as $key => $customer)
          <tr>
            <td>{{$key+ $all_customer->firstItem()}}</td>
            <td>{{ $customer->customer_name }}</td>
            <td>{{ $customer->customer_email }}</td>
            <td>
              @if($customer->customer_phone)
                {{ $customer->customer_phone }}
              @else
                N/A
              @endif
            </td>
            <td>
              @if($customer->customer_address)
                {{ $customer->customer_address }}
              @else
                N/A
              @endif
            </td>
            <td>
              <span class="text-ellipsis">
                <?php
                 if($customer->customer_vip==0){
                  ?>
                    <a href="{{URL::to('/active-customer/'.$customer->customer_id )}}" class="btn btn-primary btn-xs">Upgrade to vip</a>
                  <?php
                   }else{
                  ?>  
                   <a href="{{URL::to('/unactive-customer/'.$customer->customer_id )}}" class="btn btn-success btn-xs">Downgrade to normal</a>
                  <?php
                 }
                ?>
              </span>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <footer class="panel-footer">
      <div class="row">
        <div class="col-sm-5 text-left">
          <small>Showing item {{$all_customer->firstItem()}} to {{$all_customer->lastItem()}} of {{$all_customer->total()}} results</small>
        </div>
        <div class="col-sm-7 text-right text-center-xs">                
            {!! $all_customer->links() !!}
        </div>
      </div>
    </footer>
  </div>
</div>
@endsection