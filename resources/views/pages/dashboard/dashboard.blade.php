@extends('layout')
@section('content')
<div class="cl-dashboard">
    <div class="container">
		<div class="cl-breacrumb-product" style="margin-top: 0">
		    <div class="cl-list-breacrumb">
		       <ul class="cl-content-breacrumb">
              	  <li><a href="{{URL::to('/')}}" class="cl-link" title="">Home</a></li>
		          <li><span class="cl-link disabled">Dashboard</span></li>
		       </ul>
		    </div>
		</div>
      <div class="row">
         <div class="col-md-3">
            @include('pages.include.inc_sidebar_dashboard')
         </div>
         <div class="col-md-9 cl-main-dashboard">
            <div class="cl-info-customer">
               <div class="cl-hello-dashboard cl-welcome-dashboard">
                  <p>Welcome <strong>{{$customer_infor->customer_name}}</strong></p>
               </div>

               <div class="cl-hello-dashboard">
                  <p><strong>Account details :</strong></p>
               </div>
               <div class="dashboard-responsive-table">
                  <table class="nt-dashboard-table responsive-table">
                     <tbody>
                     </tbody>
                     <tbody>

                        <tr>
                           <td class="text-left">Avatar :</td>
                           <td>
                              @if($customer_infor->customer_picture)
                                 <img src="{{$customer_infor->customer_picture}}" style="width: 100px; height: 100px; border-radius:50%"> 
                              @else
                                 Please update
                              @endif

                           </td>
                        </tr>
                        <tr>
                           <td class="text-left">Name :</td>
                           <td>{{$customer_infor->customer_name}}</td>
                        </tr>
                        <tr>
                           <td class="text-left">Phone :</td>
                           <td>
                              @if($customer_infor->customer_phone)
                                 {{$customer_infor->customer_phone}}
                              @else
                                 Please update
                              @endif
                           </td>
                        </tr>
                        <tr>
                           <td class="text-left">Email :</td>
                           <td>
                              {{$customer_infor->customer_email}}
                           </td>
                        </tr>
                        <tr>
                           <td class="text-left">Address :</td>
                           <td>
                              @if($customer_infor->customer_phone)
                                 {{$customer_infor->customer_address}}
                              @else
                                 Please update
                              @endif
                           </td>
                        </tr>
                        <tr>
                           <td colspan="3" style="text-align: center;"><a href="{{URL::to('/update-profile-pages')}}" title="" class="cl-btn_up_profile">Update Profile</a></td>
                        </tr>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection