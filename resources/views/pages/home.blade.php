@extends('layout')
@section('content')
<!-- /START MAIN -->
<div class="cl-main-home_page">
   <div class="cl-big-carousel">
      @foreach($slider as $slide)
        <div class="cl-bg-head" style="background-image: url({{URL::to('public/uploads/slider/'.$slide->slider_image)}});">

        </div>
      @endforeach

   </div>
   <div class="cl-grid_shop-gender">
      <div class="container">
         <div class="row">
            <div class="cl-grid-content-gender cl-grid_img-left col-md-6">
               <div class="cl-grid-image-gender cl-male" style="background-image: url({{URL::to('public/frontend/images/men-grid.png')}})">
                  <a href="{{URL::to('/category-product/6')}}" class="cl-link-shop_gender" title="">men</a>
               </div>
            </div>
            <div class="cl-grid-content-gender cl-grid_img-right col-md-6" >
               <div class="cl-grid-image-gender cl-female" style="background-image: url({{URL::to('public/frontend/images/women-grid.png')}})">
                  <a href="{{URL::to('/category-product/7')}}" class="cl-link-shop_gender" title="">women</a>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="cl-related-product cl-featured-product">
      <div class="container">
         <div class="row">
            <div class="cl-section-related-title col-lg-12">
               <h3>SALE ITEMS</h3>
               <span class="cl-line"></span>
            </div>
            <div class="cl-product-wrapper col-sm-12">
               <div class="cl-product-listing cl-arrow-style_1 cl-slide-related-product">
                @foreach($sale_product as $key => $product )
                  <div class="cl-card-product cl-show-card">
                     @include('pages.include.product_item')
                  </div>
                @endforeach
               </div>
            </div>

         </div>
      </div>
   </div>

    <div class="cl-related-product cl-featured-product">
      <div class="container">
         <div class="row">
            <div class="cl-section-related-title col-lg-12">
               <h3>BEST SELLERS</h3>
               <span class="cl-line"></span>
            </div>
            <div class="cl-product-wrapper col-sm-12">
               <div class="cl-product-listing cl-arrow-style_1 cl-slide-related-product">
                @foreach($best_sellers as $key => $product )
                  <div class="cl-card-product cl-show-card">
                     @include('pages.include.product_item')
                  </div>
                @endforeach
               </div>
            </div>

         </div>
      </div>
   </div>

    <div class="cl-related-product cl-featured-product">
      <div class="container">
         <div class="row">
            <div class="cl-section-related-title col-lg-12">
               <h3>NEW ITEMS</h3>
               <span class="cl-line"></span>
            </div>
            <div class="cl-product-wrapper col-sm-12">
               <div class="cl-product-listing cl-arrow-style_1 cl-slide-related-product">
                @foreach($new_items as $key => $product )
                  <div class="cl-card-product cl-show-card">
                     @include('pages.include.product_item')
                  </div>
                @endforeach
               </div>
            </div>

         </div>
      </div>
   </div>
   <div class="cl-bg-shop_now" style="background-image: url({{URL::to('public/frontend/images/bg-2.png')}})">
      <div class="container">
         <div class="row">
            <div class="cl-meta-function offset-lg-2 col-md-12">
               <div class="cl-meta-shop_now-title">
                  <span class="extra-text">EXTRA</span>
                  <div >
                     <span class="percent-text">25%</span>
                     <span class="extra-text">OFF</span>
                  </div>
               </div>
               <a href="" class="cl-bt-shop_now" title="">SHOP NOW</a>
            </div>
         </div>
      </div>
   </div>
   <div class="cl-related-product cl-lastest-blog">
      <div class="container">
         <div class="row">
            <div class="cl-section-related-title col-lg-12">
               <h3>LASTEST BLOG</h3>
               <span class="cl-line"></span>
            </div>
            <div class="col-sm-12">
               <div class="cl-product-listing row">
                  <div class="cl-blog-image-grid col-md-4 col-sm-6">
                     <a href="" class="cl-blog-image" title="">
                        <img src="{{URL::to('public/frontend/images/blog_1.png')}}" alt="">
                        <p class="cl-infomation-blog">
                           <span class="cl-text-info">5 Tips Make You More and More Beautiful</span>
                           <span class="cl-meta-time">
                           <span class="entry-text">Tip & Trick</span>
                           <span class="cl-date_time">24/05/2019</span>
                           </span>
                        </p>
                     </a>
                  </div>
                  <div class="cl-blog-image-grid col-md-4 col-sm-6">
                     <a href="" class="cl-blog-image" title="">
                        <img src="{{URL::to('public/frontend/images/blog_2.png')}}" alt="">
                        <p class="cl-infomation-blog">
                           <span class="cl-text-info">What is The Trend Of Fashion Today?</span>
                           <span class="cl-meta-time">
                           <span class="entry-text">Tip & Trick</span>
                           <span class="cl-date_time">24/05/2019</span>
                           </span>
                        </p>
                     </a>
                  </div>
                  <div class="cl-blog-image-grid col-md-4 col-sm-6">
                     <a href="" class="cl-blog-image" title="">
                        <img src="{{URL::to('public/frontend/images/blog_3.png')}}" alt="">
                        <p class="cl-infomation-blog">
                           <span class="cl-text-info">How to Compound Sneaker With a Jean?</span>
                           <span class="cl-meta-time">
                           <span class="entry-text">Tip & Trick</span>
                           <span class="cl-date_time">24/05/2019</span>
                           </span>
                        </p>
                     </a>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="cl-newlester">
      <div class="container">
         <div class="row">
            <div class="col-lg-12">
               <span class="cl-sale_off">Get 20% Off</span>
               <form class="cl-input-group">
                  <input type="text" class="cl-form-control cl-input-search" placeholder="Your Email Here">
                  <div class="cl-input-group-append">
                     <button class="cl-btn cl-btn-outline" type="submit">
                     <span class="arrow arrow-bar is-right"></span>
                     </button>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
   <div class="cl-wild_instagram">
      <div class="cl-wild_instagram-wrapper">
         <a href="" class="cl-link_instagram">wild.store</a>
         <div class="cl-insta-carousel">
            <div><a href="" class="cl-effect-ani1" title=""><img src="{{URL::to('public/frontend/images/insta_1.png')}}" alt=""></a></div>
            <div><a href="" class="cl-effect-ani1" title=""><img src="{{URL::to('public/frontend/images/insta_2.png')}}" alt=""></a></div>
            <div><a href="" class="cl-effect-ani1" title=""><img src="{{URL::to('public/frontend/images/insta_3.png')}}" alt=""></a></div>
            <div><a href="" class="cl-effect-ani1" title=""><img src="{{URL::to('public/frontend/images/insta_1.png')}}" alt=""></a></div>
            <div><a href="" class="cl-effect-ani1" title=""><img src="{{URL::to('public/frontend/images/insta_2.png')}}" alt=""></a></div>
            <div><a href="" class="cl-effect-ani1" title=""><img src="{{URL::to('public/frontend/images/insta_3.png')}}" alt=""></a></div>
            <div><a href="" class="cl-effect-ani1" title=""><img src="{{URL::to('public/frontend/images/insta_1.png')}}" alt=""></a></div>
            <div><a href="" class="cl-effect-ani1" title=""><img src="{{URL::to('public/frontend/images/insta_2.png')}}" alt=""></a></div>
            <div><a href="" class="cl-effect-ani1" title=""><img src="{{URL::to('public/frontend/images/insta_3.png')}}" alt=""></a></div>
            <div><a href="" class="cl-effect-ani1" title=""><img src="{{URL::to('public/frontend/images/insta_1.png')}}" alt=""></a></div>
            <div><a href="" class="cl-effect-ani1" title=""><img src="{{URL::to('public/frontend/images/insta_2.png')}}" alt=""></a></div>
            <div><a href="" class="cl-effect-ani1" title=""><img src="{{URL::to('public/frontend/images/insta_3.png')}}" alt=""></a></div>
         </div>
      </div>
   </div>
</div>
<!-- /END MAIN -->
@endsection