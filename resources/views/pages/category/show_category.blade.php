@extends('layout')
@section('content')

<div class="cl-main-home_page">
    <div class="cl-colection_product-wrapper cl-related-product cl-featured-product">
        <div class="container">
            <div class="row">
                <div class="cl-section-related-title col-lg-12">

                    @foreach($category_name as $key => $name)
                   
                        <h3>{{$name->category_name}}</h3>

                    @endforeach
                    <span class="cl-line"></span>
                    <p class="cl-des_text-colection">Lorem ipsum dolor sit amet, consectetur adipiscing elit, <br>sed do eiusmod tempor.</p>
                </div>
                <div class="col-md-12">
                    <div class="cl-top-collection">
                        <div class="result-count-order">
                            <div class="cl-results-title">
                              @if(count($product_id))
                                showing item {{$begin}} to {{$end}} of {{$count_product_id}} results
                              @else
                                {{''}}
                              @endif

                              @if(count($products))
                                showing item {{$begin_products}} to {{$end_products}} of {{$count_products}} results
                              @else
                                {{''}}
                              @endif
                            </div>
                        </div>
                        <div class="cl-show-filter_mobile">
                            <a href="" class="cl-show-fil_table cl-filter-click cl-toggle-filter" title=""><i style="" class="fa fa-sliders"></i><span class="title">Filter Here</span></a>
                        </div>
                        <div class="cl-sp-col-switch ">
                            <a onclick="setNumberCol(1,this)" rel="nofollow" href="javascript:void(0);" class="one" data-col="6"><i class="washabi-column"></i></a>
                            <a onclick="setNumberCol(2,this)" rel="nofollow" href="javascript:void(0);" class="two" data-col="6"><i class="washabi-column1"></i></a>
                            <a onclick="setNumberCol(3,this)" rel="nofollow" href="javascript:void(0);" class="hidden-xs three active" data-col="4"><i class="washabi-column2"></i></a>
                            <a onclick="setNumberCol(4,this)" rel="nofollow" href="javascript:void(0);" class="hidden-sm four" data-col="3"><i class="washabi-column3"></i></a></div>
                            <div class="shop-tools flex alin_center">
                                <div class="shopify-ordering">
                                    <div onclick="showFeature(this)" class="cl-receiver_box">
                                        <div>
                                          @if(request()->get('orderby') == 'desc')
                                            Date, new to old
                                          @elseif(request()->get('orderby') == 'asc')
                                            Date, old to new
                                          @elseif(request()->get('orderby') == 'price_max')
                                            Price, high to low
                                          @elseif(request()->get('orderby') == 'price_min')
                                            Price, low to high
                                          @elseif(request()->get('orderby') == 'A_Z')
                                            Alphabetically, A-Z
                                          @elseif(request()->get('orderby') == 'Z_A')
                                            Alphabetically, Z-A
                                          @else
                                            Sort By:
                                          @endif
                                        </div>
                                        <div class="a1a">
                                            <span class="washabi-down-arrow"></span>
                                        </div>
                                    </div>
                                    <ul class="cl-select_orderby">
                                        @if(request()->get('orderby') == 'A_Z')
                                          <li class="selected">
                                            <a href="{{ request()->fullUrlWithQuery(['orderby' => null]) }}">
                                              Alphabetically, A-Z
                                            </a>
                                          </li>
                                        @else
                                          <li>
                                            <a href="{{ request()->fullUrlWithQuery(['orderby' => 'A_Z']) }}">
                                              Alphabetically, A-Z
                                            </a>
                                          </li>
                                        @endif

                                        @if(request()->get('orderby') == 'Z_A')
                                          <li class="selected">
                                            <a href="{{ request()->fullUrlWithQuery(['orderby' => null]) }}">
                                              Alphabetically, Z-A
                                            </a>
                                          </li>
                                        @else
                                          <li>
                                            <a href="{{ request()->fullUrlWithQuery(['orderby' => 'Z_A']) }}">
                                              Alphabetically, Z-A
                                            </a>
                                          </li>
                                        @endif

                                        @if(request()->get('orderby') == 'desc')
                                          <li class="selected"><a href="{{ request()->fullUrlWithQuery(['orderby' => null]) }}">Date new to old</a></li>
                                        @else
                                          <li><a href="{{ request()->fullUrlWithQuery(['orderby' => 'desc']) }}">Date new to old</a></li>
                                        @endif

                                        @if(request()->get('orderby') == 'asc')
                                          <li class="selected">
                                            <a href="{{ request()->fullUrlWithQuery(['orderby' => null]) }}">
                                              Date, old to new
                                            </a>
                                          </li>
                                        @else
                                          <li>
                                            <a href="{{ request()->fullUrlWithQuery(['orderby' => 'asc']) }}">
                                              Date, old to new
                                            </a>
                                          </li>
                                        @endif

                                        @if(request()->get('orderby') == 'price_max')
                                          <li class="selected">
                                            <a href="{{ request()->fullUrlWithQuery(['orderby' => null]) }}">
                                              Price, high to low
                                            </a>
                                          </li>
                                        @else
                                          <li>
                                            <a href="{{ request()->fullUrlWithQuery(['orderby' => 'price_max']) }}">
                                              Price, high to low
                                            </a>
                                          </li>
                                        @endif

                                        @if(request()->get('orderby') == 'price_min')
                                          <li class="selected">
                                            <a href="{{ request()->fullUrlWithQuery(['orderby' => null]) }}">
                                              Price, low to high
                                            </a>
                                          </li>
                                        @else
                                          <li>
                                            <a href="{{ request()->fullUrlWithQuery(['orderby' => 'price_min']) }}">
                                              Price, low to high
                                            </a>
                                          </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" id="row-main">
                    <div class="cl-product-wrapper cl-hidden-md-up cl-main-collection cl-colection-content_item col-12 col-lg-9 order-1" id="content">
                    <div class="cl-show-side_bar_desktop">
                        <button class="cl-click-hide_sidebar cl-filter-block">Filter Here</button>
                    </div>
                    @if(count($products) || count($product_id))

                      <div class="cl-product-listing row" style="justify-content: flex-start;">

                            @foreach($products as $product)
                                <div class="cl-product-item cl-list-colection col-6 col-md-4 cl-card-product">
                                  @include('pages.include.product_item')
                                </div>
                            @endforeach

                            @foreach($product_id as $product)
                                <div class="cl-product-item cl-list-colection col-6 col-md-4 cl-card-product">
                                  @include('pages.include.product_item')
                                </div>
                            @endforeach
                      </div>
                    @else
                      <div class="cl-product-listing row">
                        <div class="cl-dashboard col-12">
                            <div class="dashboard-error">
                              No products were found
                            </div>
                        </div>
                      </div>
                    @endif 
                    <div class="cl-pagination cl-mrt-20 col-lg-12">
                      @if(count($products))
                        {!!$products->links()!!}
                      @endif
                      @if(count($product_id))
                        {!!$product_id->links()!!}
                      @endif
                    </div>
                </div>
                @include('pages.include.inc_sidebar')
            </div>
        </div>
    </div>
</div>
@endsection