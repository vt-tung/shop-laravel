     <div class="cl-product-thumb">
        <a href="{{URL::to('/detail-product/'.$product->product_id)}}" title="{{$product->product_name}}" >
           <div>
            <img  class="cl-pic-1" src="{{URL::to('public/uploads/product/'.$product->product_image)}}" alt="">
          </div>
          @foreach(\App\Gallery::where(['product_id' => $product->product_id])->take(1)->get() as $key => $gal )
             <div>
              <img  class="cl-pic-2" src="{{URL::to('public/uploads/gallery/'.$gal->gallery_image)}}" alt="">
            </div>
          @endforeach
        </a>

        @if($product->product_qty <= 0)
           <span class="cl-text_note cl-sold_out">Sold Out</span>
        @else
           @if($product->product_promotion<=0 || $product->product_promotion=='')
              {{''}}
           @else
              <span class="cl-text_note cl-sale">Sale {{$product->product_promotion}} %</span>
           @endif
        @endif
        {{--                                  
            <div class="cl-social">
                <button type="button" class="cl-tooltip_left" data-cl-tooltip="Login to use Wishlist"><i class="fa fa-heart-o"></i></button>
                <button type="button" class="cl-add_to_cart cl-tooltip_left" data-cl-tooltip="Add to cart" data-id_product="13" name="add-to-cart"><i class="fa fa-shopping-bag"></i></button>
            </div> 
        --}}
     </div>
     <div class="cl-product-info">
        <h2 class="cl-product-name">
           <a href="{{URL::to('/detail-product/'.$product->product_id)}}" title="{{$product->product_name}}">{{$product->product_name}}</a>
        </h2>
        @php($rating_item= round(\App\Comment::where('comment_product_id',$product->product_id)->avg('rating'), 1, PHP_ROUND_HALF_DOWN))
        <div class="cl-info-rating_item">
           <span>({{$rating_item}})</span>
              <div class="cl-star-ratings">
                <div class="fill-ratings" style="width: {{$rating_item/5*100}}%;">
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
           <span>
             | {{$product->product_number_rating}} review
           </span>
        </div>
        <div class="cl-clearfix"></div>
       @if($product->product_qty <= 0)
           <div class="cl-out_stock_pr">
             <span>Out of Stock</span>
           </div>
       @else
         <span class="cl-price">
           @if($product->product_promotion<=0 || $product->product_promotion=='')
             {{''}}
           @else
              <ins class="cl-product-price" style="color: #cf0f0f">
                   <span class="cl-money">
                     <?php
                       $compare_price = ($product->product_price)-($product->product_price*$product->product_promotion/100);
                       echo number_format($compare_price,0,',','.').' '."VNĐ";
                     ?>
                   </span>
               </ins>
           @endif

           @if($product->product_promotion<=0 || $product->product_promotion=='')
               <ins class="cl-product-price" >
                   <span class="cl-money">{{ number_format($product->product_price,0,',','.').' '."VNĐ"}}</span>
               </ins>
           @else
               <del class="cl-compare-price">
                   <span class="cl-money">{{ number_format($product->product_price,0,',','.').' '."VNĐ"}}</span>
               </del>
           @endif
         </span>
       @endif
     </div>