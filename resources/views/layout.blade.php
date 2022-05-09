<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{$meta_desc}}">
    <meta name="keywords" content="{{$meta_keywords}}"/>
    <meta name="robots" content="INDEX,FOLLOW"/>
    <link  rel="canonical" href="{{$meta_canonical}}" />
    <meta name="author" content="">
    <link  rel="icon" type="image/x-icon" href="" />
    <title>{{$meta_title}}</title>
    <meta name="csrf-token" content="{{csrf_token()}}">

{{--     <meta property="og:image" content="{{$image_og}}" />
 --}}    
    <meta property="og:site_name" content="Wild.com" />
    <meta property="og:description" content="{{$meta_desc}}" />
    <meta property="og:title" content="{{$meta_title}}" />
    <meta property="og:url" content="{{$meta_canonical}}" />
    <meta property="og:type" content="website" />
    <meta property="fb:app_id" content="1148320635619289" />

    <link rel="stylesheet" type="text/css" href="{{asset('public/frontend/css/style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('public/frontend/css/cart.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('public/frontend/fonts/FontAwesome/icon/dist/font-awesome.min.css')}}">
      <link href="{{asset('public/frontend/css/sweetalert.css')}}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('public/frontend/css/photoswipe.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('public/frontend/css/default-skin/default-skin.css')}}">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">
    <script src="{{asset('public/frontend/js/sweetalert.min.js')}}"></script>
    <script src="{{asset('public/frontend/js/jquery-2.1.4.min.js')}} "></script>
    <script src="{{asset('public/frontend/js/function.js')}} "></script>
    <script src="{{asset('public/frontend/js/jquery.zoom.js')}}" ></script>
    <script src="{{asset('public/frontend/js/slick.js')}} "></script>
    <script src="{{asset('public/frontend/js/slick.min.js')}} "></script>
    <script src="{{asset('public/frontend/js/photoswipe.min.js')}} "></script>
    <script src="{{asset('public/frontend/js/photoswipe-ui-default.js')}} "></script>
  </head>

  <body class="hidden-scroll-y">

    <div class="cl-main-page-wrapper">

      <div class="cl-wrapper cl-wrapper-container th-wrapper">
        <!-- /START HEADER -->
        <header id="cl-wild_header-section">
          <div class="cl-wild_header">
            <div class="cl-wild-menu cl-min-height clone">
              <div class="container">
                <div class="cl-willdropdesktop">
                  <div class="row cl-content-menu">
                    <div class="cl-header-logo cl-jt-center col-12 col-sm-auto">
                      <h1 class="cl-logo-name"><a href="{{URL::to('home-pages')}}" title="">Wild</a></h1>
                    </div>
                    <div class="cl-header-menu cl-horizon-menu col-sm-12 col-lg-8">
                      <div class="cl-box-header-menu cl-header-logo">
                        <div class="cl-control-box_mobile">
                          <h1 class="cl-logo-name"><a href="" title="">Wild</a></h1>
                          <h4 class="entry-title"><span>MAIN</span> <span>MENU</span></h4>
                          <a href="" class="cl-close cl-show-menu menu-toggle"></a>
                        </div>
                      </div>
                      <nav class="cl-main-navigation">
                        <ul class="cl-nav cl-main-menu">
                          <li class="item-menu">
                            @if(Request::is('/'))
                              <a class="name-item active">HOME</a>
                            @else
                              <a href="{{URL::to('/')}}" class="name-item">HOME</a>
                            @endif
                          </li>
                          @foreach($category as $key => $cate)
                          <li class="item-menu">
                            @if(Request::is('category-product/'.$cate->category_id))
                              <a class="name-item active">{{$cate->category_name}}</a>
                            @else
                              <a href="{{URL::to('/category-product/'.$cate->category_id)}}" 
                                class="name-item">{{$cate->category_name}}</a>
                            @endif
                          </li>

                          @endforeach
                          <li class="item-menu">
                            @if(Request::is('send-mail'))
                              <a 
                                class="name-item active">Contact us</a>
                            @else
                              <a href="{{URL::to('/send-mail')}}" class="name-item">Contact us</a>
                            @endif
                          </li>
                        </ul>
                      </nav>
                    </div>
                    <div class="cl-header-control cl-jt-center col-12 col-sm-auto">
                      <nav class="cl-main_menu-control">
                        <ul class="cl-menu-control">
                          <li class="cl-menu-toggle">
                            <a href="" class="cl-show-menu menu-toggle">
                              <span class="mr-b spinner"></span>
                              <span class="spinner"></span>
                              <span class="mr-t spinner"></span>
                            </a>
                          </li>

                          <li class="cl-search-product">
                            <a href="javascript:void(0)" class="icon-link" ><i class="fa fa-search" aria-hidden="true"></i></a>
                            <form class="cl-dropdown-content" action="{{URL::to('/search')}}" autocomplete="off" method="GET">
                              @csrf
                              <div class="header">
                                <input type="text" class="cl-input-search" name="keywords" placeholder="Search everything..." required="">
                                <button type="submit" class="cl-btn-search"><i class="fa fa-search" aria-hidden="true"></i></button>
                                <div class="cl-btn-search cl-loading" style="">
                                  <i class="fa fa-circle-o-notch" style="vertical-align: text-top;"></i>
                                </div>
                              </div>
                              <div id="back_result" class="cl-list-search">
                              </div>
                            </form>
                          </li>
                          <li class="cl-wilget_user block-user">
                            @php
                              $customer_id      = Session::get('customer_id');
                              $customer_picture = Session::get('customer_picture');
                            @endphp
                            @if($customer_id!=NULL && $customer_picture!=NULL)
                              <a href="javascript:void(0)" class="icon-link cl-avatar_user">
                                <img src="{{Session::get('customer_picture')}}"> 
                              </a>
                            @else

                              <a href="javascript:void(0)" class="icon-link"><i class="fa fa-user" aria-hidden="true"></i></a>
                            @endif
                            <div class="settings-wrapper kiti--DropInner shadow">
                               <div class="setting-content text-left">
                                  <div class="setting-option">
                                    <?php
                                       $customer_id = Session::get('customer_id');
                                        if($customer_id!=NULL){ 
                                            ?>
                                              <ul>

                                                 <li>
                                                    @if(Request::is('your-dashboard'))
                                                      <a class="cl-item active">
                                                        <span class="lock-icon"><i class="fa fa-th-list" aria-hidden="true"></i></span><span>Dashboard</span>
                                                      </a>
                                                    @else
                                                      <a href="{{URL::to('/your-dashboard')}}" class="cl-item">
                                                        <span class="lock-icon"><i class="fa fa-th-list" aria-hidden="true"></i></span><span>Dashboard</span>
                                                      </a>
                                                    @endif
                                                 </li>
                                                <li class="cl-count-item_wishlist">

                                                </li>
                                                 <li>
                                                    <span class="lock-icon"><i class="fa fa-sign-out" aria-hidden="true"></i></span>
                                                    <a href="{{URL::to('/logout-checkout')}}" class="cl-item">Logout</a>                                   
                                                 </li>
                                              </ul>
                                            <?php
                                        }else{
                                            ?>
                                             <ul>
                                                <li>
                                                   <span class="lock-icon"><i class="fa fa-lock" aria-hidden="true"></i></span>
                                                   <a href="{{URL::to('login-checkout/')}}" class="cl-item"><span>Login</span></a>
                                                   <a href="{{URL::to('register')}}" class="cl-item"><span>Register</span></a>
                                                </li>
                                             </ul>
                                            <?php 
                                        }
                                    ?>
                                  </div>
                               </div>
                            </div>
                          </li>
                          <li class="cart-icon cl-hover-cart">
                            
                          </li>
                        </ul>
                      </nav>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          </header><!-- /END HEADER -->
            <div class="cl-discount_for_order">
              <span class="cl-entry-title">WE HAVE BEST PRODUCTS FOR YOU</span>
            </div>

              @yield('content')
              <!-- /START FOOTER -->
              <div class="cl-wild-footer">
                <div class="container">
                  <div class="row cl-content_top-footer">
                    <div class="col-lg-2 cl-logo-footer">
                      <h1 class="cl-logo-product">
                      <a href="" class="entry-title" title="">Wild</a>
                      </h1>
                    </div>
                    <div class="col-lg-8 cl-contet-nav-footer">
                      <div class="cl-navigation-footer">
                        <ul class="cl-content-navigation-footer">
                          <li><a href="" title="" class="name-item">Contact & FAQ</a></li>
                          <li><a href="" title="" class="name-item">Shipping & Return</a></li>
                          <li><a href="" title="" class="name-item">Terms</a></li>
                          <li><a href="" title="" class="name-item">Privacy Policy</a></li>
                        </ul>
                      </div>
                    </div>
                    <div class="col-lg-2 cl-share_on-footer">
                      <div class="cl-share_on-network">
                        <ul class="cl-social-network">
                          <li class="cl-tooltip_top_right" data-cl-tooltip="Facebook"><a href="" class="cl-icon-network" ><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                          <li class="cl-tooltip_top" data-cl-tooltip="Twitter"><a href="" class="cl-icon-network"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                          <li class="cl-tooltip_top_left" data-cl-tooltip="Linkedin"><a href="" class="cl-icon-network" ><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                        </ul>
                      </div>
                    </div>
                  </div>
                  <div class="row cl-content_bottom-footer">
                    <div class="col-lg-12 cl-meta_bottom-footer">
                      <div class="cl-copy-right">
                        <span>© 2021 logo</span>
                      </div>
                      <div class="cl-trust-badge">
                        <img src="images/trust_badge.png" alt="">
                      </div>
                    </div>
                  </div>
                </div>
                </div><!-- /END FOOTER -->
                <div class="cl-overlay-mobile_menu">
                  <div class="cl-overlay">
                  </div>
                </div>
              </div>
            </div>
            <div id="cl-scroll-top-wrapper" title="Scroll to top">
                <span class="scroll-top-inner">
                     <i class="fa fa-angle-up" aria-hidden="true"></i>
                </span>
            </div>
            <div id="fb-root"></div>
            <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v10.0&appId=976181729445713&autoLogAppEvents=1" nonce="tb6cuwQN"></script>

            <script type="text/javascript">
              $(function(){
                let listStar = $('.lish_star .fa');
                lishRatingText={
                  1 : 'Very bad',
                  2 : 'Bad',
                  3 : 'Normal',
                  4 : 'Good',
                  5 : 'Very good',
                }

                listStar.mouseover(function(){
                  let $this = $(this);
                  let number = $this.attr('data-key');
                  listStar.removeClass('rating_active');
                  $('.number_rating').val(number);
                  $.each(listStar, function(key, value){
                    if(key+1 <= number){
                      $(this).addClass('rating_active')
                    }
                  });

                  $(".lish_text").text('').text(lishRatingText[number]).show();
                });
              });
            </script>

            <script type="text/javascript">
                $(document).ready(function(){
                    hover_wishlist();
                    show_wishlist();
                    function hover_wishlist(){
                        var url = "{{url()->current()}}";

                        $.ajax({
                            url:"{{url('/count-wishlist')}}",
                            method:"POST",
                            headers:{
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data:{url:url},
                            success:function(data){
                              $('.cl-count-item_wishlist').html(data);
                            }
                        });
                    }

                    function show_wishlist(){
                        $.ajax({
                            url:"{{url('/show-wishlist-now')}}",
                            method:"GET",
                            success:function(data){
                              $('.cl-list-wishlist-product .cl-list-wishlist_item').html(data);
                            }
                        });
                    }

                  $(document).on('click','.cl-remove_wl .cl-delete-wl',function(){

                      var row_id = $(this).data('row_id');
                    
                      var _token = $('input[name="_token"]').val();
                      swal({
                        title: "Are you sure?",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "Yes",
                        cancelButtonText: "Cancel",
                        closeOnConfirm: false,
                        closeOnCancel: false
                      },
                      function(isDelete){
                           if (isDelete) {
                              $.ajax({
                                  url:"{{url('/delete-to-wishlist')}}",
                                  method:'POST',
                                  data:{row_id:row_id,_token:_token},
                                  success:function(data){
                                      swal({
                                          title: 'Success',
                                          type: 'success',
                                          text: 'Removed from wishlist successfully',
                                          timer: 800,
                                          showCancelButton: false,
                                          showConfirmButton: false,
                                      });                                
                                      hover_wishlist();
                                      show_wishlist();
                                  }
                              });
                            } 
                            else {
                              swal({
   
                                timer: 0,
                                title: "Are you sure?",
                                type: "warning",
                                showCancelButton: true,
                                confirmButtonClass: "btn-danger",
                                confirmButtonText: "Yes",
                                cancelButtonText: "Cancel",
                                closeOnConfirm: false,
                                closeOnCancel: false
                              });
                            }
                      });

                  });

                    $(document).on('click', '.js-add-favorite', function() {
                      var customer_id = $(this).data("customer_id");
                      var product_id = $(this).data("product_id");
                      var _token = $('input[name="_token"]').val();
                      $.ajax({
                        url:"{{url('/insert-wishlist')}}",
                        method:"POST",
                        data:{customer_id:customer_id, product_id:product_id, _token:_token},
                        success:function(data){
                          swal({
                              title: 'Success',
                              type: 'success',
                              text: 'The product has been added to wishlist',
                              timer: 1200,
                              showCancelButton: false,
                              showConfirmButton: false,
                          });
                          $('div.cl-wish-add-icon').html('');
                          $('div.cl-wish-add-icon').html(data);
                          hover_wishlist();
                          show_wishlist();
                        }
                      });
                    });

                    $('.cl-summary-rating').click(function(event) {
                      event.preventDefault();
                      $('html, body').animate({
                        scrollTop: $(".cl-comment-customer").offset().top
                      }, 500)
                    }); 

                    load_comment();

                    function load_comment(id=''){
                        var product_id = $('.comment_product_id').val();
                        var _token = $('input[name="_token"]').val();
                        $.ajax({
                          url:"{{url('/load-comment')}}",
                          method:"POST",
                          data:{id:id, product_id:product_id, _token:_token},
                          success:function(data){
                            $('#cl-load_more_comment').remove();
                            $('#comment_show').append(data);
                          }
                        });
                    }

                  $(document).on('click', '#cl-load_more_comment', function() {
                    var id = $(this).data("id");
                    load_comment(id);
                  });

                    $('.send-comment').click(function(){
                        var product_id = $('.comment_product_id').val();
                        var comment_name = $('.comment_name').val();
                        var comment_content = $('.comment_content').val();
                        var number_rating = $('.number_rating').val();
                        var _token = $('input[name="_token"]').val();
                        let listStar = $('.lish_star .fa');
                        if(number_rating == ""){
                          swal({
                            title: "Alert",
                            text: "Please choose stars",
                            type:'error',
                          });
                        }else if(comment_content==""){
                          swal({
                            title: "Alert",
                            text: "Do not leave the form blank",
                            type:'error',
                          });
                        }else{
                          $.ajax({
                            url:"{{url('/send-comment')}}",
                            method:"POST",
                            data:{product_id:product_id,comment_name:comment_name,comment_content:comment_content, number_rating:number_rating, _token:_token},
                            success:function(data){
                              
                              $('#notify_comment').html('<span class="success">Comment successfully</span>');
                              $('#comment_show').html('');
                              load_comment();
                              $('#notify_comment').fadeOut(9000);
                              $('.comment_content').val('');
                              $('.number_rating').val('');
                              listStar.removeClass('rating_active');
                              $(".lish_text").hide();
                              $('html, body').animate({
                                scrollTop: $(".cl-commnent-showed").offset().top
                              }, 500);
                            }
                          });
                        }
                    });
                });
            </script>

            <script type="text/javascript">
              $(document).ready(function(){
                  function search_ajax() {
                      $('.cl-input-search').on('keyup', function() {
                          var name = $(this).val().trim();
                          var _token = $('input[name="_token"]').val();
                          if (name != '') {
                              $('.cl-loading').show();
                              $.ajax({
                                  url: '{{url('/search-ajax')}}',
                                  method: "post",
                                  data: {
                                      name : name, _token:_token
                                  },
                                  dataType: "html",
                                  success: function(data) {
                                      $('.cl-loading').hide();
                                      $('div.cl-list-search').addClass('active');
                                      $('div.cl-list-search').html(data);
                                  },
                                  error: function() {
                                      $('.cl-loading').hide();
                                      $('div.cl-list-search').html();
                                  }
                              });
                          } else if (name === '') {
                              $('div.cl-list-search').removeClass('active');
                              $('div.cl-list-search').html('');
                          }
                      });
                  }
                  search_ajax();

                  $(document).on('click','.cl-cancel_order_button',function(){
                      var order_code = $('.order_code').val();
                      var text_reason = $('.cl-txt_reason_destroy_order').val();
                      var order_status = 6;
                      //lay ra so luong
                      var quantity = [];
                      $("input[name='product_sales_quantity']").each(function(){
                          quantity.push($(this).val());
                      });
                      //lay ra product id
                      var order_product_id = [];
                      $("input[name='order_product_id']").each(function(){
                          order_product_id.push($(this).val());
                      });

                      var _token = $('input[name="_token"]').val();
                        if(text_reason==""){
                          swal({
                            title: "Alert",
                            text: "Do not leave the form blank",
                            type:'error',

                          });
                        }else{
                        swal({
                          title: "Are you sure",
                          type: "warning",
                          showCancelButton: true,
                          confirmButtonClass: "btn-danger",
                          confirmButtonText: "Yes",
                          cancelButtonText: "Cancel",
                          closeOnConfirm: false,
                          closeOnCancel: false
                        },
                        function(d){
                             if (d) {
                                $.ajax({
                                    url: '{{url('/destroy-order-code')}}',
                                    method: 'POST',
                                    data:{order_code:order_code,text_reason:text_reason,order_status:order_status,quantity:quantity,order_product_id:order_product_id,_token:_token},
                                    success:function(){
                                      swal({
                                        title: "Order success",
                                        text: "Your order has been successfully sent",
                                        type:'success',
                                        timer: 500,
                                        showCancelButton: false,
                                        showConfirmButton: false,
                                      },
                                      function() {
                                        window.location.href = "{{url('/history-order')}}";
                                      });
                                    }
                                });
                              } 
                              else {
                                $('.cl-txt_reason_destroy_order').val('');
                                swal({
                                  title: "Cancel",
                                  text: "Your order has not been sent yet, please complete the order",
                                  type:'error',
                                  timer: 0,
                                  showCancelButton: false,
                                  showConfirmButton: false,
                                });
                              }
                        });

                      }

                  });
              });
            </script>
            <script type="text/javascript">
              $(document).ready(function(){

                var container = [];

                // Loop over gallery items and push it to the array
                $('.cl-content-bigslide').find('figure.featured-slide-2').each(function(){
                  var $link = $(this).find('a'),
                      item = {
                        src: $link.attr('href'),
                        w: $link.data('width'),
                        h: $link.data('height'),
                      };
                  container.push(item);
                });

                $('.cl-content-bigslide a').click(function(event){

                  // Prevent location change
                  event.preventDefault();

                  // Define object and gallery options
                  var $pswp = $('.pswp')[0],
                      options = {
                        index: $(this).parent('figure.featured-slide-2').index(),
                        bgOpacity: 0.95,
                        allowPanToNext:true,
                        closeOnVerticalDrag:true,
                        loop:true,

                      };

                  // Initialize PhotoSwipe
                  var gallery = new PhotoSwipe($pswp, PhotoSwipeUI_Default, container, options);
                  gallery.init();
                });

              });

            </script>
            <script type="text/javascript">
              $(document).ready(function(){
                hover_cart();
                show_cart();

                function show_cart(){
                    $.ajax({
                        url:"{{url('/show-cart-now')}}",
                        method:"GET",
                        success:function(data){
                            $('.cl-show_cart').html(data);
                        }
                    });
                }

                function hover_cart(){
                    var url = "{{url()->current()}}";
                    $.ajax({
                        url:"{{url('/hover-cart')}}",
                        method:"POST",
                        headers:{
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data:{url:url},
                        success:function(data){
                            $('.cart-icon.cl-hover-cart').html(data);
                        }
                    });
                }
                function set_qty(){
                   $('.cl-qty.cl-number').val(1);
                }

                $('.cl-add_to_cart.cl-addcarrt-ajax').click(function(){
                  var id = $(this).data('id_product');
                  var cart_product_id = $('.cart_product_id_' + id).val();
                  var cart_product_qty = $('.cart_product_qty_' + id).val();
                  var cart_product_color = $('input[name="color_id"]:checked').val();
                  var cart_product_size = $('input[name="size_id"]:checked').val();
                  var _token = $('input[name="_token"]').val();
                  $.ajax({
                      url: '{{url('/save-cart')}}',
                      method: 'POST',
                      data:{cart_product_id:cart_product_id,cart_product_qty:cart_product_qty,cart_product_color:cart_product_color,cart_product_size:cart_product_size,_token:_token},
                      beforeSend: function () {
                        $('.button-loading').removeClass('display-none');
                        $('.cl-add_to_cart.cl-addcarrt-ajax').addClass('display-none');
                      },
                      success:function(response){
 
                        hover_cart();
                        show_cart();
                        set_qty();
                        if (response.message) {
                          swal({
                              title: 'Alert',
                              type: 'error',
                              text: ''+response.message+'',
                          });
                        }else{
                          swal({
                              title: 'Success',
                              type: 'success',
                              text: 'The product has been added to cart',
                              timer: 1200,
                              showCancelButton: false,
                              showConfirmButton: false,
                          });
                        } 
                      },
                      complete: function () {
                          $('.button-loading').addClass('display-none');
                          $('.cl-add_to_cart.cl-addcarrt-ajax').removeClass('display-none');
                      }
                  });
                });
                $('.cl-buy-now.cl-bt').click(function(){
                  var id = $(this).data('id_product');
                  var id_user = $(this).data('id_user');
                  var cart_product_id = $('.cart_product_id_' + id).val();
                  var cart_product_qty = $('.cart_product_qty_' + id).val();
                  var cart_product_color = $('input[name="color_id"]:checked').val();
                  var cart_product_size = $('input[name="size_id"]:checked').val();
                  var _token = $('input[name="_token"]').val();
                  $.ajax({
                      url: '{{url('/save-cart')}}',
                      method: 'POST',
                      data:{cart_product_id:cart_product_id,cart_product_qty:cart_product_qty,cart_product_color:cart_product_color,cart_product_size:cart_product_size,_token:_token},
                      success:function(response){
                        hover_cart();
                        show_cart();
                        set_qty();
                        if (response.message) {
                          swal({
                              title: 'Alert',
                              type: 'error',
                              text: ''+response.message+'',
                          });
                        }else{
                          if(id_user){
                            window.location.href = "{{url('checkout')}}";
                          }else{
                            window.location.href = "{{url('login-checkout')}}";
                          }
                        } 
                      }
                  });
                });


                @foreach(Cart::content() as $key)
                  $(document).on('click', '.cl-bt-qty.plus.bt_plus_{{ $key->rowId}}', function(event) {
                      event.preventDefault();
                      if ($(this).prev().val()) {
                          $(this).prev().val(+$(this).prev().val() + 1);
                      }
                      var newQty = $('.qty-box.cart_quantity_item_{{ $key->rowId}}').val();
                      var upRowId = $('.form-control.upRowId_{{ $key->rowId}}').val();
                      var upRowIdproduct = $('.form-control.upRowidproduct_{{ $key->id}}').val();

                      var _token = $('input[name="_token"]').val();
                      $.ajax({
                          url:"{{url('/update-cart-quantity')}}",
                          method:'POST',
                          data:{newQty:newQty,upRowId:upRowId,upRowIdproduct:upRowIdproduct,_token:_token},
                          success:function(data){
                              hover_cart();
                              show_cart();
                              if (data.message) {
                                  alert(data.message);
                              } 
                          }
                      });
                  });

                  $(document).on('click', '.cl-bt-qty.minus.bt_minus_{{ $key->rowId}}', function(event) {
                      event.preventDefault();
                      if ($(this).next().val() > 1) {
                          if ($(this).next().val() > 0) $(this).next().val(+$(this).next().val() - 1);
                      }else if($(this).next().val() == 1){
                        alert('Do not reduce less than 1 product');
                      }
                      var newQty = $('.qty-box.cart_quantity_item_{{ $key->rowId}}').val();
                      var upRowId = $('.form-control.upRowId_{{ $key->rowId}}').val();
                      var _token = $('input[name="_token"]').val();
                      var upRowIdproduct = $('.form-control.upRowidproduct_{{ $key->id}}').val();

                      $.ajax({
                          url:"{{url('/update-cart-quantity')}}",
                          method:'POST',
                          data:{newQty:newQty,upRowId:upRowId,upRowIdproduct:upRowIdproduct,_token:_token},
                          success:function(data){
                            hover_cart();
                            show_cart();
                          }
                      });
                  });

                  $(document).on('keyup', '.qty-box.cart_quantity_item_{{ $key->rowId}}', function() {
                      var newQty = $('.qty-box.cart_quantity_item_{{ $key->rowId}}').val();
                      var upRowId = $('.upRowId_{{ $key->rowId}}').val();
                      var upRowIdproduct = $('.form-control.upRowidproduct_{{ $key->id}}').val();

                      var _token = $('input[name="_token"]').val();
                      if(newQty > 0){
                        $.ajax({
                            url:"{{url('/update-cart-quantity')}}",
                            method:'POST',
                            data:{newQty:newQty,upRowId:upRowId,upRowIdproduct:upRowIdproduct,_token:_token},
                            success:function(data){
                                hover_cart();
                                show_cart();
                                if (data.message) { 
                                  alert(data.message);
                                } 
                            }
                        });
                      }else if(newQty < 1){
                        alert("Do not reduce less than 1 product");
                        $('.qty-box.cart_quantity_item_{{$key->rowId}}').val({{$key->qty}});
                      }

                  });
                @endforeach

                $(document).on('click','.delete-cart',function(){

                    var row_id = $(this).data('row_id');
                  
                    var _token = $('input[name="_token"]').val();
                    swal({
                      title: "Are you sure?",
                      type: "warning",
                      showCancelButton: true,
                      confirmButtonClass: "btn-danger",
                      confirmButtonText: "Yes",
                      cancelButtonText: "Cancel",
                      closeOnConfirm: false,
                      closeOnCancel: false
                    },
                    function(isDelete){
                         if (isDelete) {
                            $.ajax({
                                url:"{{url('/delete-to-cart')}}",
                                method:'POST',
                                data:{row_id:row_id,_token:_token},
                                success:function(data){
                                    swal({
                                        title: 'Success',
                                        type: 'success',
                                        text: 'Product delete successfully',
                                        timer: 800,
                                        showCancelButton: false,
                                        showConfirmButton: false,
                                    });                                
                                    hover_cart();
                                    show_cart();
                                }
                            });
                          } 
                          else {
                            swal({
 
                              timer: 0,
                              title: "Are you sure?",
                              type: "warning",
                              showCancelButton: true,
                              confirmButtonClass: "btn-danger",
                              confirmButtonText: "Yes",
                              cancelButtonText: "Cancel",
                              closeOnConfirm: false,
                              closeOnCancel: false
                            });
                          }
                    });

                });

                $('.send_order').click(function(){
                    var shipping_email = $('.shipping_email').val();
                    var shipping_name = $('.shipping_name').val();
                    var shipping_address = $('.shipping_address').val();
                    var shipping_phone = $('.shipping_phone').val();
                    var shipping_note = $('.shipping_note').val();
                    var shipping_method = $('.payment_select').val();
                    var order_fee = $('.order_fee').val();
                    var order_coupon = $('.order_coupon').val();
                    var _token = $('input[name="_token"]').val();
                    var total_pay = $('.cl-total_pay').val();
                    var payment_select = $('.payment_select').val();
                    if($('.shipping_email').val()=="" || $('.shipping_name').val()=="" || $('.shipping_address').val()=="" || $('.shipping_phone').val()=="" || $('.payment_select').val()==""){
                            swal({
                              title: "Alert",
                              text: "Do not leave it blank",
                              type:'error',
                              timer: 1200,
                              showCancelButton: false,
                              showConfirmButton: false,
                            });                          
                    }else{
                        swal({
                          title: "Order confirmation",
                          text: "Orders will not be refunded when placed, do you want to place?",
                          type: "warning",
                          showCancelButton: true,
                          confirmButtonClass: "btn-danger",
                          confirmButtonText: "Order Now",
                          cancelButtonText: "Cancel",
                          closeOnConfirm: false,
                          closeOnCancel: false
                        },
                        function(isConfirm){
                             if (isConfirm) {
                                $.ajax({
                                    url: '{{url('/confirm-order')}}',
                                    method: 'POST',
                                    data:{shipping_email:shipping_email,shipping_name:shipping_name,shipping_address:shipping_address,shipping_phone:shipping_phone,shipping_note:shipping_note,_token:_token,order_fee:order_fee,order_coupon:order_coupon,shipping_method:shipping_method,total_pay:total_pay},
                                    beforeSend: function () {
                                      swal({
                                          title: "Processing...",
                                          type:'info',
                                          showCancelButton: false,
                                          showConfirmButton: false,
                                        });
                                    },
                                    success:function(){
                                       $('.shipping_email').val("");
                                       $('.shipping_name').val("");
                                       $('.shipping_address').val("");
                                       $('.shipping_phone').val("");
                                       $('.payment_select').val("");
                                        hover_cart();
                                        show_cart();
                                        swal({
                                          title: "Order success",
                                          text: "Your order has been successfully sent",
                                          type:'success',
                                          timer: 1500,
                                          showCancelButton: false,
                                          showConfirmButton: false,
                                        },
                                        function() {
                                          window.location.href = "{{url('/history-order')}}";
                                        });

                                    }
                                });

                              } 
                              else {
                                swal({
                                  title: "Cancel",
                                  text: "Your order has not been sent yet, please complete the order",
                                  type:'error',
                                  timer: 1200,
                                  showCancelButton: false,
                                  showConfirmButton: false,
                                });
                              }
                        });

                    } 

                });
            });
            </script>
            <script type="text/javascript">
                $(document).ready(function(){
                  $('.choose').on('change',function(){
                    var action = $(this).attr('id');
                    var ma_id = $(this).val();
                    var _token = $('input[name="_token"]').val();
                    var result = '';
                   
                    if(action=='city'){
                        result = 'province';
                    }else{
                        result = 'wards';
                    }
                    $.ajax({
                        url : '{{url('/select-delivery-home')}}',
                        method: 'POST',
                        data:{action:action,ma_id:ma_id,_token:_token},
                        success:function(data){
                           $('#'+result).html(data);     
                        }
                    });
                  });

                  $('.payment_select').on('change',function(){
                    var val = $(this).val();

                    if (val == 0) {
                      $('.th-btn.order-online').css("display", "block");
                      $('.th-btn.send_order').css("display", "none");
                    }else if(val == 1){
                      $('.th-btn.order-online').css("display", "none");
                      $('.th-btn.send_order').css("display", "block");
                    }
                  });
                });
                  
            </script>
            <script type="text/javascript">
                $(document).ready(function(){
                    $('.calculate_delivery').click(function(){
                        var matp = $('.city').val();
                        var maqh = $('.province').val();
                        var xaid = $('.wards').val();
                        var _token = $('input[name="_token"]').val();
                        if(matp == ''){
                            swal({
                              title: "Alert",
                              text: "Please choose city or province",
                              type:'error'
                            });       
                        }else if(maqh == ''){
                            swal({
                              title: "Alert",
                              text: "Please choose district",
                              type:'error'
                            });    
                        }else if(xaid == ''){
                            swal({
                              title: "Alert",
                              text: "Please choose commune",
                              type:'error'
                            });    
                        }
                        else{
                            $.ajax({
                            url : '{{url('/calculate-fee')}}',
                            method: 'POST',
                            data:{matp:matp,maqh:maqh,xaid:xaid,_token:_token},
                              success:function(){
                                 location.reload(); 
                              }
                            });
                        } 
                });
            });
            </script>
            <script >

                  function AddCart(id){
                    $.ajax({
                      url:'http://localhost/shopbanhanglaravel/Add-Cart/'+id,
                      method:'GET',
                      success:function(response){
                        console.log(response);
                        $(".cart-hover .change-item-cart").empty();
                        $(".cart-hover .change-item-cart").html(response);
                        swal({
                                title: "Product added to cart",
                                text: "You can purchase or go to the cart to proceed with the payment",
                                showCancelButton: true,
                                cancelButtonText: "See more",
                                confirmButtonClass: "btn-success",
                                confirmButtonText: "Go to cart",
                                closeOnConfirm: false
                            },
                        function() {
                            window.location.href = "{{url('/cart')}}";
                        });
                      }
                    });
                  }
            </script>

          </body>
        </html>

