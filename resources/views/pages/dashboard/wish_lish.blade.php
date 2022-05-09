@extends('layout')
@section('content')
<div class="cl-list-wishlist-product">
   <div class="cl-dashboard container">
      <div class="row">
         <div class="cl-section-related-title col-lg-12">
            <h3>WISHLIST PRODUCT</h3>
            <span class="cl-line"></span>
         </div>
      </div>
      <form class="row">
        @csrf
         <div class="col-lg-12 cl-list-wishlist_item">
            
         </div>
      </form>
   </div>
</div>
@endsection