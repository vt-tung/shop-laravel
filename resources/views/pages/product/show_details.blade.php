@extends('layout')
@section('content')
  @foreach($product_details as $key => $pro_details)
    <div class="cl-product-single-background">
      <div class="container">
        <div class="row">
          <div class="col-lg-12 cl-breacrumb-product">
            <div class="cl-list-breacrumb">
              <ul class="cl-content-breacrumb">
                <li><a href="{{URL::to('/')}}"  class="cl-link" title="">Home</a></li>
                <li><a href="{{URL::to('/category-product/'.$pro_details->category_id)}}"  class="cl-link" title="">{{$pro_details->category_name}}</a></li>
                <li><span class="cl-link disabled" >{{$pro_details->product_name}}</span></li>
              </ul>
            </div>
          </div>
          <div class="cl-product-detail-image col-12 col-lg-7">
            <div class="cl-content-bigslide col-12 col-md-10 col-lg-10 order-md-1">
              @if($pro_details->product_qty <= 0)
                <span class="cl-text_note cl-sold_out">Sold Out</span>
              @else
                @if($pro_details->product_promotion<=0 || $pro_details->product_promotion=='')

                @else
                  <span class="cl-text_note cl-sale">Sale {{$pro_details->product_promotion}} %</span>
                @endif
              @endif
              <form class="cl-wishlist_compare" accept-charset="utf-8">
                @csrf
                <button type="button" onclick="$('.cl-content-bigslide .slick-current a').trigger('click')" class="cl-icon-wl_cp cl-tooltip_left" data-cl-tooltip="Click to Enlarge">
                  <i class="fa fa-arrows-alt" aria-hidden="true"></i>
                </button>
                @php($wishlist=\App\Wishlist::where(['product_id' => $pro_details->product_id])->where(['customer_id' => Session::get('customer_id')])->first())
                @if(Session::get('customer_id')!=NULL)
                  @if($wishlist==NULL)
                  <div class="cl-wish-add-icon">
                   <button type="button" name="wishlist" data-customer_id="{{Session::get('customer_id')}}" data-product_id="{{$pro_details->product_id}}" class="cl-icon-wl_cp cl-tooltip_left js-add-favorite" data-cl-tooltip="Add to Wishlist">
                    <i class="fa fa-heart-o"></i></button>
                  </div>
                  @else
                   <div>
                    <button type="button" onclick="location.href ='{{URL::to('/show-wishlist')}}'" name="wishlist" class="cl-icon-wl_cp cl-tooltip_left" data-cl-tooltip="Browse wishlist">
                    <i class="fa fa-heart" style="color:#e9635d"></i></button>
                  </div>
                  @endif
                @else
                    <button type="button" onclick="location.href ='{{URL::to('/login-checkout')}}'" class="cl-icon-wl_cp cl-tooltip_left" data-cl-tooltip="Login to use Wishlist"> <i class="fa fa-heart-o"></i></button>
                @endif

              </form>
              <div class="cl-slider-for cl-slider-for_2">
                <figure class="zoom__image featured-slide-2">
                  <a href="{{URL::to('public/uploads/product/'.$pro_details->product_image)}}" data-width="1600" data-height="2074">
                    <img src="{{URL::to('public/uploads/product/'.$pro_details->product_image)}}" data-bigimg="{{URL::to('public/uploads/product/'.$pro_details->product_image)}}" alt="{{URL::to('public/uploads/product/'.$pro_details->product_image)}}" class="img-responsive">
                  </a>
                </figure>
                @foreach($gallery as $key => $gal)
                  <figure class="zoom__image featured-slide-2">
                    <a href="{{asset('public/uploads/gallery/'.$gal->gallery_image)}}" data-width="1600" data-height="2074"><img src="{{asset('public/uploads/gallery/'.$gal->gallery_image)}}"  data-bigimg="{{URL::to('public/uploads/gallery/'.$gal->gallery_image)}}" alt="{{asset('public/uploads/gallery/'.$gal->gallery_image)}}" class="img-responsive"></a>
                  </figure>
                @endforeach
              </div>
            </div>
            <div class="cl-content-smallslide col-12 col-md-2 col-lg-2">
              <div class="cl-slider-nav cl-slider-nav_2">
                <div class="slide-link slide-link-2">
                  <img src="{{asset('public/uploads/product/'.$pro_details->product_image)}}" alt="{{asset('public/uploads/product/'.$pro_details->product_image)}}">
                </div>
                @foreach($gallery as $key => $gal)
                  <div class="slide-link slide-link-2">
                    <img src="{{asset('public/uploads/gallery/'.$gal->gallery_image)}}" alt="{{asset('public/uploads/gallery/'.$gal->gallery_image)}}">
                  </div>
                @endforeach
              </div>
            </div>
          </div>
          <div class="cl-right-sidebar_product col-12 col-lg-5">
            <div class="cl-summary">
              <div class="cl-sold-text">
                <img src="{{URL::to('public/frontend/images/thunder.svg')}}" alt="">
                <span class="entry-text">{{$pro_details->product_sold}} products sold</span>
              </div>
              <h1 class="cl-product_name">{{$pro_details->product_name}}</h1>
              <div class="cl-summary-rating">
                  <span class="cl-count-star">
                    ({{$rating}})
                  </span>
                  <div class="cl-star-ratings">
                    <div class="fill-ratings" style="width: {{$rating/5*100}}%;">
                      @for($i=1; $i<=5; $i++)
                        <span>&#9733;</span>
                      @endfor    
                    </div>
                    <div class="empty-ratings">
                      @for($i=1; $i<=5; $i++)
                        <span>&#9733;</span>
                      @endfor  
                    </div>
                  </div>
                  <span class="cl-reviews">
                     | {{$pro_details->product_number_rating}} review | {{$pro_details->product_views}} views
                  </span>
              </div>

              @if($pro_details->product_qty <= 0)
                <div class="cl-out_stock">
                  <span>Out of Stock</span>
                </div>
              @else
                <span class="cl-price">
                  @if($pro_details->product_promotion<=0 || $pro_details->product_promotion=='')
                    {{''}}
                  @else
                     <ins class="cl-product-price" style="color: #cf0f0f">
                          <span class="cl-money">
                            <?php
                              $compare_price = ($pro_details->product_price)-($pro_details->product_price*$pro_details->product_promotion/100);
                              echo number_format($compare_price,0,',','.').' '."VNĐ";
                            ?>
                          </span>
                      </ins>
                  @endif

                  @if($pro_details->product_promotion<=0 || $pro_details->product_promotion=='')
                      <ins class="cl-product-price" >
                          <span class="cl-money">{{ number_format($pro_details->product_price,0,',','.').' '."VNĐ"}}</span>
                      </ins>
                  @else
                      <del class="cl-compare-price">
                          <span class="cl-money">{{ number_format($pro_details->product_price,0,',','.').' '."VNĐ"}}</span>
                      </del>
                  @endif
                </span>
              @endif
              @if($pro_details->product_content!=NULL)
                <div>
                  {!!$pro_details->product_content!!}
                </div>
              @endif
              <div class="cl-clearfix"></div>
              <div class="cl-poduct-addtocart">
                <form action="{{URL::to('/save-cart-new')}}" class="cl-cart" method="POST">
                  @csrf
                  @if(count($color))
                    <div class="cl-color_and_size-content">
                      <label class="cl-title">Color : <span class="cl-result-color"></span></label>
                      <div class="cl-choose_color">
                        @php($count=0)
                      @foreach($color as $key => $col)
                        @php($count++)
                        <div class="cl-radio" data-slide="6">
                          <input id="radio-{{$count}}" data-color="{{$col->color_name}}" class="cart_product_color_{{$pro_details->product_id}}" name="color_id" value="{{$col->color_id}}" type="radio">
                          <label for="radio-{{$count}}" class="radio-label"><span>{{$col->color_name}}</span></label>
                        </div>
                      @endforeach
                     </div>
                    </div>
                  @else
                    <div class="cl-color_and_size-content" style="display: none!important">
                      <label class="cl-title">Color : <span class="cl-result-color"></span></label>
                      <div class="cl-choose_color">

                        <div class="cl-radio">
                          <input id="radio-1" data-color="no" class="cart_product_color_{{$pro_details->product_id}}" name="color_id" value="no" type="radio">
                          <label for="radio-1" class="radio-label"><span>no</span></label>
                        </div>
                     </div>
                    </div>
                  @endif

                  @if(count($size))
                    <div class="cl-color_and_size-content">
                        <label class="cl-title">Size : <span class="cl-result-size"></span></label>
                        <div class="cl-choose_size">
                          <div class="cl-lish-size">
                              @php($count=0)
                            @foreach($size as $key => $siz)
                              @php($count++)
                              <div class="cl-radio">
                                <input id="radiosize-{{$count}}" data-size="{{$siz->size_name}}" class="cart_product_size_{{$pro_details->product_id}}" name="size_id" value="{{$siz->size_id}}" type="radio">
                                <label for="radiosize-{{$count}}" class="radio-label"><span>{{$siz->size_name}}</span></label>
                              </div>
                            @endforeach
                          </div>
                            <a href="" class="cl-click-size_guide" data-modal="modal-size-guild">Size guide</a>
                        </div>
                    </div>
                  @else
                    <div class="cl-color_and_size-content" style="display: none!important">
                        <label class="cl-title">Size : <span class="cl-result-size"></span></label>
                        <div class="cl-choose_size">
                          <div class="cl-lish-size">

                              <div class="cl-radio">
                                <input id="radiosize-1" data-size="no" class="cart_product_size_{{$pro_details->product_id}}" name="size_id" value="no" type="radio">
                                <label for="radiosize-1" class="radio-label"><span>no</span></label>
                              </div>
                          </div>
                            <a href="" class="cl-click-size_guide" data-modal="modal-size-guild">Size guide</a>
                        </div>
                    </div>
                  @endif
                  <div class="cl-clearfix"></div>
                
                  @if($pro_details->product_qty>0)
                    <div class="cl-quantity_instock">
                      <span class="cl-title_instock">Instock: </span>{{$pro_details->product_qty}}
                    </div>
                  @endif
                  
                  <div class="cl-button-group">
                    <div class="cl-cart-form margin-bottom-15 cl-d-flex cl-flex-wrap">
                      <div class="cl-quantity">
                        <div class="cl-control">
                          <input type="hidden" name="productid_hidden" value="{{$pro_details->product_id}}">
                          <button type="button" class="cl-btn-number cl-qtyminus cl-quantity-minus"></button>
                          <input type="number" name="qty" class="cl-input-qty cl-input-number cl-exist cl-qty cl-number cart_product_qty_{{$pro_details->product_id}}" value="1" data-min="1" data-max="{{$pro_details->product_qty}}">
                          <button type="button" class="cl-btn-number cl-qtyplus cl-quantity-plus"></button>
                        </div>
                        <input type="hidden" value="{{$pro_details->product_id}}" class="cart_product_id_{{$pro_details->product_id}}">
                      </div>
                      @if($pro_details->product_qty>0)
                        <button type="button" id="button-add" class="cl-add_to_cart cl-addcarrt-ajax cl-bt cl-bt-primary col" data-id_product="{{$pro_details->product_id}}">
                          <span >Add to cart</span>
                        </button>
                         <button type="button" id="loader" class="cl-add_to_cart button-loading cl-bt-primary col display-none" data-id_product="{{$pro_details->product_id}}">
                          <span >Loading...</span>
                        </button>
                      @else
                        <button type="button" style="display: flex;line-height: normal; justify-content: center; align-items: center; background-color: #313131; border-color:#313131; cursor: inherit; margin-top: 5px" class="cl-add_to_cart cl-bt cl-bt-primary col" title="">SOLD OUT</button>
                      @endif
                    </div>
                      <?php $idcus= Session::get('customer_id')?>
                    <p class="cl-or"><span>-- or --</span></p>
                    @if($pro_details->product_qty>0)

                      <button type="button" class="cl-buy-now cl-bt cl-bt-primary col" data-id_product="{{$pro_details->product_id}}" data-id_user="{{$idcus}}">
                        <span >Buy Now</span>
                      </button>
                    @else
                        <button type="button" style="display: flex;line-height: normal; justify-content: center; align-items: center; background-color: #313131; border-color:#313131; cursor: inherit; margin-top: 5px" class="cl-add_to_cart cl-bt cl-bt-primary col" title="">SOLD OUT</button>
                    @endif
                  </div>

                </form>
              </div>
              <div class="cl-share_on-network cl-network-product cl-jc-center">
                <div>
                  <span class="cl-title">Share on:</span>
                </div>
                <ul class="cl-social-network">
                  <li class="cl-tooltip_top" data-cl-tooltip="Facebook"><a href="" class="cl-icon-network"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                  <li class="cl-tooltip_top" data-cl-tooltip="Twitter"><a href="" class="cl-icon-network"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                  <li class="cl-tooltip_top" data-cl-tooltip="Linkedin"><a href="" class="cl-icon-network"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                  <li class="cl-tooltip_top" data-cl-tooltip="Pinterest"><a href="" class="cl-icon-network"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a></li>
                </ul>
              </div>
              <div class="cl-full-service">
                <ul class="cl-content-service">
                  <li class="cl-service">
                    <div class="cl-icon-service">
                      <img src="{{URL::to('public/frontend/images/money.svg')}}" alt="">
                    </div>
                    <div class="cl-text-servive">
                      <span class="cl-text cl-fast_and_percent">100%</span>
                      <span class="cl-text cl-service-name">Money Back</span>
                    </div>
                  </li>
                  <li class="cl-service">
                    <div class="cl-icon-service">
                      <img src="{{URL::to('public/frontend/images/shield.svg')}}" alt="">
                    </div>
                    <div class="cl-text-servive">
                      <span class="cl-text cl-fast_and_percent">100%</span>
                      <span class="cl-text cl-service-name">Guaranteed</span>
                    </div>
                  </li>
                  <li class="cl-service">
                    <div class="cl-icon-service">
                      <img src="{{URL::to('public/frontend/images/shiping.svg')}}" alt="">

                    </div>
                    <div class="cl-text-servive">
                      <span class="cl-text cl-fast_and_percent">Fast</span>
                      <span class="cl-text cl-service-name">Shipping</span>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <div class="row cl-flex_end-tabpanel">
          <div class="col-lg-12 cl-tabpanel-wrapper-product">
            <div class="cl-description-product">
              <div class="cl-tabs-wrapper">
                <ul class="tabs flex-tabs cl-uppercase-tabs">
                  <li class="cl-bt-tab-1 active" data-toggle-tab="tab-size-1">
                    <a href="" title="" class="active"><span>DESCRIPTION</span></a>
                  </li>
                  <li class="cl-bt-tab-1" data-toggle-tab="tab-size-2">
                    <a href="" title=""><span>SIZING</span></a>
                  </li>
                  <li class="cl-bt-tab-1" data-toggle-tab="tab-size-3">
                    <a href="" title=""><span>SHIPPING</span></a>
                  </li>
                </ul>
                <div class="cl-tab-panels">
                  <div id="tab-size-1" class="info_product_deitails_tabs tab-content active">
                    {!!$pro_details->product_desc!!}
                  </div>
                  <div id="tab-size-2" class="info_sizing tab-content">
                    <table class="cl-shop_table cart">
                      <tbody>
                        <tr>
                          <td >Color:</td>
                          <td >Gray, Brown, Blue</td>
                        </tr>
                        <tr>
                          <td>Size:</td>
                          <td>Xs, S, L</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div id="tab-size-3" class="info_shipping tab-content">
                    <table class="cl-shop_table cart">
                      <tbody>
                        <tr>
                          <td >Shipping:</td>
                          <td >This item ship to <span class="strong">VietNam</span></td>
                        </tr>
                        <tr>
                          <td>Delivery:</td>
                          <td>Estimated between Apr 29 and May 03. <span class="strong">Will usually ship within 1 bussiness day</span></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>

            </div>
          </div>
          <div class="col-lg-12 cl-comment-customer" id="reviews ">
            <div>
              <div class="cl-comment-title">
                Product reviews:
              </div>
              <div class="cl-comment-content" style="padding: 15px;
    border: 3px solid #f1f1f1;">

                  <form action="#" class="cl-comment-product">
                    @if(Session::get('customer_id'))
                      <div id="notify_comment"></div>
                      <div class="cl-rating-star">
                        <span class="cl-title-star">Choose stars: </span>
                        <ul class="list-inline rating"  title="Average Rating">
                          @for($i=1; $i<=5; $i++)
                            <li title="star_rating" class="rating lish_star" style="cursor:pointer; color:#ccc; font-size:30px;"><span class="fa" data-key="{{$i}}">&#9733;</span></li>
                          @endfor
                        </ul>
                        <span class="cl-status-rating lish_text"></span>
                        <input type="hidden" value="" class="number_rating">
                      </div>

                      <input  type="hidden" class="comment_name cl-comment-input" value="{{$customer_infor->customer_name}}" placeholder="Your name(*)"/>

                      <div style="display: flex; background-color: #f5f6f7; padding: 15px">
                        @if($customer_infor->customer_picture!="")
                           <img src="{{$customer_infor->customer_picture}}" style="width: 70px; height: 70px;margin-right: 10px; border-radius:50%"> 
                        @else
                            <img src="{{URL::to('public/frontend/images/usercomment.jpg')}}" style="width: 70px; height: 70px; margin-right: 10px;border-radius:50%"> 
                        @endif
                        <textarea name="comment" class="comment_content cl-comment-input" placeholder="Comment here(*)" rows="7"></textarea>
                      </div>

                      <button type="button" class="btn-default-comment send-comment">
                        Send review
                      </button>
                    @else
                      <div class="cl-rating-star">
                        <span class="cl-title-star">Choose stars:</span>
                        <ul class="list-inline rating"  title="Average Rating">
                          @for($i=1; $i<=5; $i++)
                                <li title="star_rating" class="rating lish_star" style="cursor:pointer; color:#ccc; font-size:30px;">
                                  <span class="fa" data-key="{{$i}}">&#9733;</span>
                                </li>
                          @endfor
                        </ul>
                        <span class="cl-status-rating lish_text"></span>
                      </div>
                      <div style="display: flex; background-color: #f5f6f7; padding: 15px">
                        <img src="{{URL::to('public/frontend/images/pngtree-user-vector-avatar-png-image_1541962.jpg')}}" style="width: 70px; height: 70px; margin-right: 10px;border-radius:50%"> 
                        <textarea name="comment" class="comment_content cl-comment-input" placeholder="Comment here(*)" rows="7"></textarea>
                      </div>
                      <a href="{{URL::to('login-checkout')}}" class="btn-default-comment">
                        Send review
                      </a>
                    @endif
                  </form>

                  <form>
                     @csrf
                    <input type="hidden" name="comment_product_id" class="comment_product_id" value="{{$pro_details->product_id}}">
                     <div id="comment_show" class="cl-commnent-showed" style="margin-top: 30px">

                     </div>
                  </form>
              </div>
            </div>
          </div>
          <div class="col-lg-12 cl-comment-facebook">
            <div class="cl-comment-title">
              Comment with facebook:
            </div>
            <div class="fb-comments" data-href="{{$meta_canonical}}" data-width="100%" data-numposts="5"></div>
          </div>
        </div>
      </div>
    </div>
    <div class="cl-main-home_page">

      <div class="cl-related-product cl-featured-product">
        <div class="container">
          <div>
            <div class="cl-section-related-title col-lg-12">
              <h3>RELATED ITEMS</h3>
              <span class="cl-line"></span>
            </div>
            <div class="cl-product-wrapper">
              @if(count($relate))
                <div class="cl-product-listing cl-arrow-style_1 cl-slide-related-product">
                  @foreach($relate as $key => $product)
                  <div class="cl-card-product cl-show-card">
                    @include('pages.include.product_item')
                  </div>
                  @endforeach
                </div>
              @else
                <div class="alert alert-info text-center m-0" role="alert">
                    No related product.
                </div>
              @endif
            </div>
          </div>
        </div>
      </div>

    </div>
    <div class="cl-modal-size-guild modal" id="modal-size-guild">
    <div class="modal-box">
      <div class="modal-header">
        <span class="close-modal"><span class="close" title="Close(Esc)">&#10006;</span></span>
      </div>
      <figure class="modal-body">
        <img src="{{URL::to('public/frontend/images/custom_size_chart_content.jpg')}}" alt="">
      </figure>
    </div>
  </div>
    <div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
      <!-- Background of PhotoSwipe. 
           It's a separate element as animating opacity is faster than rgba(). -->
      <div class="pswp__bg"></div>
      <!-- Slides wrapper with overflow:hidden. -->
      <div class="pswp__scroll-wrap">
          <!-- Container that holds slides. 
              PhotoSwipe keeps only 3 of them in the DOM to save memory.
              Don't modify these 3 pswp__item elements, data is added later on. -->
          <div class="pswp__container">
              <div class="pswp__item"></div>
              <div class="pswp__item"></div>
              <div class="pswp__item"></div>
          </div>
          <!-- Default (PhotoSwipeUI_Default) interface on top of sliding area. Can be changed. -->
          <div class="pswp__ui pswp__ui--hidden">
              <div class="pswp__top-bar">
                  <!--  Controls are self-explanatory. Order can be changed. -->
                  <div class="pswp__counter"></div>
                  <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>
                  <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>
                  <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>
                  <!-- Preloader demo http://codepen.io/dimsemenov/pen/yyBWoR -->
                  <!-- element will get class pswp__preloader--active when preloader is running -->
                  <div class="pswp__preloader">
                      <div class="pswp__preloader__icn">
                        <div class="pswp__preloader__cut">
                          <div class="pswp__preloader__donut"></div>
                        </div>
                      </div>
                  </div>
              </div>
              <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                  <div class="pswp__share-tooltip"></div> 
              </div>
              <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)">
              </button>
              <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)">
              </button>
              <div class="pswp__caption">
                  <div class="pswp__caption__center"></div>
              </div>
          </div>
      </div>
  </div>
  @endforeach
@endsection

