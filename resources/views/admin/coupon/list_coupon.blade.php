@extends('admin_layout')
@section('admin_content')
    <div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      LIST DISCOUNT CODE
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
          $message = Session::get('message_mail_coupon');
          if($message){
              ?>
                <div class="alert alert-success alert-dismissible" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  {{$message}}
                </div>
              <?php
              Session::put('message_mail_coupon',null);
          }
      ?>
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
            <th>No</th>
            <th>Discount Code Name</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Code</th>
            <th>Quantity</th>
            <th>Conditions</th>
            <th>Decreases</th>
            <th>Send Code</th>
            <th>Status</th>
            <th>Expires</th>
          </tr>
        </thead>
        <tbody>
            @php($count=0)
          @foreach($coupon as $key => $cou)
            @php($count++)
          <tr>
            <td>{{ $count }}</td>
            <td>

              {{ $cou->coupon_name }}

            </td>
            <td>
                {{\Carbon\Carbon::createFromFormat('Y-m-d',$cou->coupon_date_start)->format('d/m/Y')}}
            </td>
            <td>
                {{\Carbon\Carbon::createFromFormat('Y-m-d',$cou->coupon_date_end)->format('d/m/Y')}}
            </td>
            <td>{{ $cou->coupon_code }}</td>
            <td>{{ $cou->coupon_time }}</td>
            <td><span class="text-ellipsis">
              <?php
               if($cou->coupon_condition==1){
                ?>
                Discount by %
                <?php
                 }else{
                ?>  
                Discount by money
                <?php
               }
              ?>
            </span>
          </td>
             <td><span class="text-ellipsis">
              <?php
               if($cou->coupon_condition==1){
                ?>
                Reduction {{$cou->coupon_number}} %
                <?php
                 }else{
                ?>  
                Reduction {{number_format($cou->coupon_number,0,',','.')}} VNĐ
                <?php
               }
              ?>
            </span></td>
          <td><span class="text-ellipsis">
            <?php
            if($cou->coupon_status==1){
              ?>
              <span style="color:green">Activating</span>
              <?php
            }else{
              ?>  
              <span style="color:red">Locked</span>
              <?php
            }
            ?>
          </span>
          </td>
        <td>

          @if($cou->coupon_date_end >= $today)
            <span style="color:green">Not expired</span>
          @else 
            <span style="color:red">Expired</span>
          @endif
          

        </td>
            <td>
             
              <a onclick="return confirm('Bạn có chắc là muốn xóa mã này ko?')" href="{{URL::to('/delete-coupon/'.$cou->id_coupon)}}" class="active styling-edit" ui-toggle-class="">
                <i class="fa fa-times text-danger text"></i>
              </a>
            </td>
            <td>
        <td>
      
          <p><a href="{{url('/send-coupon-vip', [ 

            'coupon_time'=> $cou->coupon_time,
            'coupon_condition'=> $cou->coupon_condition,
            'coupon_number'=> $cou->coupon_number,
            'coupon_code'=> $cou->coupon_code


          ])}}" class="btn btn-primary" style="margin:5px 0;">Send VIP customer discount</a></p>    
          <p><a href="{{url('/send-coupon',[ 

           
            'coupon_time'=> $cou->coupon_time,
            'coupon_condition'=> $cou->coupon_condition,
            'coupon_number'=> $cou->coupon_number,
            'coupon_code'=> $cou->coupon_code


          ])}}" class="btn btn-default">Send normal customer discount</a></p>  
       

       </td>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <footer class="panel-footer">
      <div class="row">
        
        <div class="col-sm-5 text-center">
        </div>
        <div class="col-sm-7 text-right text-center-xs">                
          {!! $coupon->links() !!}
        </div>
      </div>
    </footer>
  </div>
</div>
@endsection