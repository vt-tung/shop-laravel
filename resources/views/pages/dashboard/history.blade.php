@extends('layout')
@section('content')
<div class="cl-dashboard">
   <div class="container">
      <div class="cl-breacrumb-product" style="margin-top: 0">
          <div class="cl-list-breacrumb">
             <ul class="cl-content-breacrumb">
                <li><a href="{{URL::to('/')}}" class="cl-link" title="">Home</a></li>
                <li><span class="cl-link disabled">Ordered</span></li>
             </ul>
          </div>
      </div>
      <div class="row">
         <div class="col-md-3">
            @include('pages.include.inc_sidebar_dashboard')
         </div>
         <div class="col-md-9 cl-main-dashboard">
            <div class="cl-info-customer">
              <div class="cl-ordered-customer">
                 <div class="cl-hello-dashboard" style="margin: 0">
                    <p><strong>My Ordered :</strong></p>
                 </div>
                 <div class="cl-products-ordered">
                  @if(count($getorder))
                    <table class="shop_table cart table table-bordered table-customize">
                       <tbody>
                          <tr>
                             <th width="2%">No</th>
                             <th width="10%">Code orders</th>
                             <th width="10%">Date Ordered</th>
                             <th width="10%">Status</th>
                             <th width="10%">Action</th>
                          </tr>
                          @php 
                            $i = 0;
                          @endphp

                          @foreach($getorder as $key => $ord)
                            @php 
                              $i++;
                            @endphp
                          <tr>
                            <td>
                              {{$key+ $getorder->firstItem()}}
                            </td>
                            <td>{{ $ord->order_code }}</td>
                            <td>
                              {{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$ord->order_date)->format('H:i:s d/m/Y')}}
                            </td>
                            
                            <td>
                                @if($ord->order_status==1)
                                  New orders
                                @elseif($ord->order_status==2) 
                                  Order confirmed
                                @elseif($ord->order_status==3)
                                  Take orders
                                @elseif($ord->order_status==4)
                                  Delivering
                                @elseif($ord->order_status==5)
                                  Delivered  
                                @elseif($ord->order_status==6)
                                  Cancelled 
                                @endif                               
                            </td>
                            <td>
                              <a href="{{URL::to('/view-history-order/'.$ord->order_code)}}" class="active styling-edit cl-view_order" >
                                View Order</a>
                                @if($ord->order_status!=6 && $ord->order_status!=5 && $ord->order_status!=4 && $ord->order_status!=3 && $ord->order_status!=2 )
                                  <a href="{{URL::to('/destroy-order/'.$ord->order_code)}}" class="active styling-edit cl-destroy_order" >
                                  Destroy Order</a>
                                @endif                              

                            </td>
                          </tr>
                          @endforeach
                       </tbody>
                    </table>
                    <div class="panel-footer">
                      <div class="row">
                        <div class="col-sm-5 text-left">
                          <small>Showing item {{$getorder->firstItem()}} to {{$getorder->lastItem()}} of {{$getorder->total()}} results</small>
                        </div>
                        <div class="col-sm-7" style="text-align: right;">                
                            {!! $getorder->links() !!}
                        </div>
                      </div>
                    </div>
                  @else
                    <div class="dashboard-error">
                        No order has been made yet.   
                    </div>
                  @endif
                 </div>
              </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection