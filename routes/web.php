<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//Frontend 
Route::get('/','HomeController@index' );
Route::get('/home-pages','HomeController@index');
Route::post('/tim-kiem','HomeController@search');

//Danh muc san pham trang chu
Route::get('/category-product/{category_product_id}','CategoryProduct@show_category_home');
Route::get('/thuong-hieu-san-pham/{brand_slug}','BrandProduct@show_brand_home');
Route::get('/detail-product/{product_id}','ProductController@details_product');

//Backend
Route::get('/admin','AdminController@index');
Route::get('/dashboard','AdminController@show_dashboard');
Route::get('/logout','AdminController@logout');
Route::post('/admin-dashboard','AdminController@dashboard');
Route::post('/filter-by-date','AdminController@filter_by_date');

Route::get('/order-date','AdminController@order_date');

Route::post('/days-order','AdminController@days_order');
Route::post('/dashboard-filter','AdminController@dashboard_filter');

//Category Product
Route::get('/add-category-product','CategoryProduct@add_category_product');
Route::get('/edit-category-product/{category_product_id}','CategoryProduct@edit_category_product');
Route::get('/delete-category-product/{category_product_id}','CategoryProduct@delete_category_product');
Route::get('/all-category-product','CategoryProduct@all_category_product');

Route::get('/unactive-category-product/{category_product_id}','CategoryProduct@unactive_category_product');
Route::get('/active-category-product/{category_product_id}','CategoryProduct@active_category_product');


Route::post('/save-category-product','CategoryProduct@save_category_product');
Route::post('/update-category-product/{category_product_id}','CategoryProduct@update_category_product');

//Brand Product
Route::get('/add-brand-product','BrandProduct@add_brand_product');
Route::get('/edit-brand-product/{brand_product_id}','BrandProduct@edit_brand_product');
Route::get('/delete-brand-product/{brand_product_id}','BrandProduct@delete_brand_product');
Route::get('/all-brand-product','BrandProduct@all_brand_product');

Route::get('/unactive-brand-product/{brand_product_id}','BrandProduct@unactive_brand_product');
Route::get('/active-brand-product/{brand_product_id}','BrandProduct@active_brand_product');

Route::post('/save-brand-product','BrandProduct@save_brand_product');
Route::post('/update-brand-product/{brand_product_id}','BrandProduct@update_brand_product');

//Product
Route::get('/add-product','ProductController@add_product');
Route::get('/edit-product/{product_id}','ProductController@edit_product');
Route::get('/delete-product/{product_id}','ProductController@delete_product');
Route::get('/all-product','ProductController@all_product');

Route::get('/unactive-product/{product_id}','ProductController@unactive_product');
Route::get('/active-product/{product_id}','ProductController@active_product');

Route::post('/save-product','ProductController@save_product');
Route::post('/update-product/{product_id}','ProductController@update_product');

Route::get('/view-rating/{product_id}','ProductController@view_rating');

//Staff
Route::get('/add-staff','AdminController@add_staff');
Route::get('/list-staff','AdminController@list_staff');
Route::get('/delete-staff/{admin_id}','AdminController@delete_staff');
Route::get('/edit-staff/{admin_id}','AdminController@edit_staff');
Route::post('/update-staff/{admin_id}','AdminController@update_staff');
Route::post('/save-staff','AdminController@save_staff');

//Cart
Route::post('/update-cart-quantity','CartController@update_cart_quantity');
// Route::post('/update-cart-minus','CartController@update_cart_minus');
Route::post('/save-cart','CartController@save_cart');
Route::get('/show-cart','CartController@show_cart');
Route::get('/show-cart-now','CartController@show_cart_now');
// Route::get('/delete-to-cart/{rowId}','CartController@delete_to_cart');
Route::post('/delete-to-cart/','CartController@delete_to_cart');

Route::post('/add-cart-ajax','CartController@add_cart_ajax');
Route::get('/cart','CartController@cart');
Route::post('/update-cart','CartController@update_cart');
Route::get('/del-product/{session_id}','CartController@delete_product');
Route::get('/del-all-product','CartController@delete_all_product');
Route::post('/hover-cart','CartController@hover_cart');

//Customer
Route::get('/list-customer','CustomerController@list_customer');
Route::get('/login-checkout','CustomerController@login_checkout');
Route::get('/logout-checkout','CustomerController@logout_checkout');
Route::get('/register','CustomerController@register_checkout');
Route::get('/unactive-customer/{customer_id}','CustomerController@unactive_customer');
Route::get('/active-customer/{customer_id}','CustomerController@active_customer');
Route::post('/add-customer','CustomerController@add_customer');
Route::post('/login-customer','CustomerController@login_customer');

//Checkout
Route::post('/order-place','CheckoutController@order_place');
Route::get('/checkout','CheckoutController@show_checkout');
Route::get('/payment','CheckoutController@payment');
Route::post('/save-checkout-customer','CheckoutController@save_checkout_customer');
Route::post('/select-delivery-home','CheckoutController@select_delivery_home');
Route::post('/calculate-fee','CheckoutController@calculate_fee');
Route::get('/del-fee','CheckoutController@del_fee');
Route::post('/confirm-order','CheckoutController@confirm_order');

//Coupon
Route::post('/check-coupon','CartController@check_coupon');

Route::get('/unset-coupon','CouponController@unset_coupon');
Route::get('/insert-coupon','CouponController@insert_coupon');
Route::get('/delete-coupon/{id_coupon}','CouponController@delete_coupon');
Route::get('/list-coupon','CouponController@list_coupon');
Route::post('/insert-coupon-code','CouponController@insert_coupon_code');

//Delivery
Route::get('/delivery','DeliveryController@delivery');
Route::post('/select-delivery','DeliveryController@select_delivery');
Route::post('/insert-delivery','DeliveryController@insert_delivery');
Route::post('/select-feeship','DeliveryController@select_feeship');
Route::post('/update-delivery','DeliveryController@update_delivery');
Route::post('delete-feeshipping','DeliveryController@delete_feeshipping');

//Carttest
Route::get('/Add-Cart/{id}','CartController@AddCart');

// Gallery Image
Route::get('add-gallery/{product_id}','GalleryController@add_gallery');
Route::post('select-gallery','GalleryController@select_gallery');
Route::post('insert-gallery/{pro_id}','GalleryController@insert_gallery');
Route::post('update-gallery-name','GalleryController@update_gallery_name');
Route::post('delete-gallery','GalleryController@delete_gallery');
Route::post('update-gallery','GalleryController@update_gallery');

// Color
Route::get('add-color/{product_id}','ColorController@add_color');
Route::post('select-color','ColorController@select_color');
Route::post('insert-color/{pro_id}','ColorController@insert_color');
Route::post('update-color-name','ColorController@update_color_name');
Route::post('delete-color','ColorController@delete_color');

// size
Route::get('add-size/{product_id}','SizeController@add_size');
Route::post('select-size','SizeController@select_size');
Route::post('insert-size/{pro_id}','SizeController@insert_size');
Route::post('update-size-name','SizeController@update_size_name');
Route::post('delete-size','SizeController@delete_size');


//Order

Route::get('/print-order/{checkout_code}','OrderController@print_order');
Route::get('/manage-order','OrderController@manage_order');
Route::get('/view-order/{order_code}','OrderController@view_order');
Route::post('/update-order-qty','OrderController@update_order_qty');
Route::get('/history-order','OrderController@history');
Route::get('/view-history-order/{order_code}','OrderController@view_history_order');
Route::get('/destroy-order/{order_code}','OrderController@destroy_order');
Route::get('/destroy-order/{order_code}','OrderController@destroy_order');
Route::post('/destroy-order-code','OrderController@destroy_order_code');

//Dashboard of customer
Route::get('/your-dashboard','dashboardController@dashboard');
Route::get('/update-profile-pages','dashboardController@update_profile_pages');
Route::post('/update-profile','dashboardController@update_profile');

//Login facebook
Route::get('/login-facebook-customer','AdminController@login_facebook_customer');
Route::get('/customer/facebook/callback','AdminController@callback_facebook_customer');

//Login google
Route::get('/login-customer-google','AdminController@login_customer_google');
Route::get('/customer/google/callback','AdminController@callback_customer_google');

//Send Mail 
Route::get('/send-coupon-vip/{coupon_time}/{coupon_condition}/{coupon_number}/{coupon_code}','MailController@send_coupon_vip');
Route::get('/send-coupon/{coupon_time}/{coupon_condition}/{coupon_number}/{coupon_code}','MailController@send_coupon');

Route::get('/send-mail','MailController@send_mail');

Route::post('/send-mail','MailController@post_mail');

//SEARCH
Route::get('/search','HomeController@search');
Route::post('/search-ajax','HomeController@search_ajax');

//Banner
Route::get('/manage-slider','SliderController@manage_slider');
Route::get('/add-slider','SliderController@add_slider');
Route::get('/delete-slide/{slide_id}','SliderController@delete_slide');
Route::post('/insert-slider','SliderController@insert_slider');
Route::get('/unactive-slide/{slide_id}','SliderController@unactive_slide');
Route::get('/active-slide/{slide_id}','SliderController@active_slide');

//payonline
Route::post('/payment/online','CartController@createPayment');
Route::get('/vnpay/return','CartController@vnpayReturn')->name('vnpay.return');
// Route::get('/pay','CartController@confirm_order');
// Route::post('/confirm-order','CheckoutController@confirm_order');


//comment
Route::post('/load-comment','ProductController@load_comment');
Route::post('/send-comment','ProductController@send_comment');
Route::get('/comment','ProductController@list_comment');
Route::post('/allow-comment','ProductController@allow_comment');
Route::post('/reply-comment','ProductController@reply_comment');

//wishlist
Route::post('/insert-wishlist','WishlistController@insert_wishlist');
Route::post('/count-wishlist','WishlistController@count_wishlist');
Route::get('/show-wishlist','WishlistController@show_wishlist');
Route::get('/show-wishlist-now','WishlistController@show_wishlist_now');
Route::post('/delete-to-wishlist','WishlistController@delete_to_wishlist');
