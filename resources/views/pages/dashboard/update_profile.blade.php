@extends('layout')
@section('content')
<div class="cl-dashboard">
    <div class="container th-banner">
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
            <div class="th-form-login row">
               <div class="th-form col-md-8">
                  <h1 class="th-title">Update your profile here</h1>
                  <form method="POST" action="{{URL::to('/update-profile')}}" enctype="multipart/form-data">
                     @csrf
                     <table>
                        <tbody>
                           <tr>
                              <td>
                                 <div class="form-group">
                                    <label class="cl-label-form" for="">Email : {{$customer_infor->customer_email}}</label>
                                 </div>
                              </td>
                           </tr>
                           <tr>
                              <td>
                                 <div class="form-group">
                                    <label class="cl-label-form" for="">Name :</label>
                                    <input type="text" class="th-form-control" name="name" value="{{$customer_infor->customer_name}}" required="">
                                 </div>
                              </td>
                           </tr>

                           <tr>
                              <td>
                                 <div class="form-group">
                                    <label class="cl-label-form" for="">Phone :</label>
                                    <input type="text" class="th-form-control" name="phone" pattern="0[0-9\s.-]{9,10}" value="{{$customer_infor->customer_phone}}" required="">
                                 </div>
                              </td>
                           </tr>
                           <tr>
                              <td>
                                 <div class="form-group">
                                    <label class="cl-label-form" for="">Address :</label>
                                    <textarea type="text" rows="5" class="th-form-control" name="address" required="">{{$customer_infor->customer_address}}</textarea>
                                 </div>
                              </td>
                           </tr>
                           <tr>
                              <td>
                                 <div class="form-group">
                                    <label class="cl-label-form" for="">Avatar :</label>
                                    <input type="file" class="th-form-control" id="file" name="product_image" style="cursor: pointer;">
                                    <img src="{{$customer_infor->customer_picture}}" style="width: 100px; height: 100px; border-radius:50%"> 
                                 </div>
                              </td>
                           </tr>
                        </tbody>
                     </table>
                     <div class="th-form-check">
                        <button name="save" type="submit" class="th-btn">UPDATE</button>
                     </div>
                  </form>
               </div>
               </div>
         </div>
      </div>
   </div>
</div>
@endsection