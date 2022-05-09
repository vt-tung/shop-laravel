@extends('layout')
@section('content')
<div class="cl-main-home_page">
   <div class="content">
      <div class="cl-related-product cl-featured-product">
         <div class="container">
            <div class="row">
               <div class="cl-section-related-title col-lg-12" style="margin-bottom: 30px;">
                  <h3>Showing item {{$search_product->firstItem()}} to {{$search_product->lastItem()}} of {{$search_product->total()}} results for "{{$keywords}}"</h3>
                  <span class="cl-line"></span>
               </div>
               <div class="cl-product-wrapper col-sm-12">
                  <div class="cl-product-listing row">
                  	@foreach($search_product as $product)
	                     <div class="col-md-3 col-sm-6 cl-col-xs-6 cl-card-product cl-show-card">
									@include('pages.include.product_item')
	                     </div>
                     @endforeach
                     <div class="cl-pagination cl-mrt-20 col-lg-12">
	                      @if(count($search_product))
	                        {!!$search_product->links()!!}
	                      @endif
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection