<div class="cl-filter_sidebar_colection-wrapper  col-lg-3" id="sidebar">
    <button class="cl-click-hide_sidebar">Hide Sidebar</button>
    <form class="cl-content-filter">
        @csrf
        <ul class="cl-include-filter">
            <li class="cl-header-filter cl-son_fl-item">
                <div class="cl-header">
                    <span class="title">Filter By:</span>
                    <div class="cl-close-filter_mobile">
                        <a href="" class="cl-close-filter_table cl-toggle-filter" title="Close"></a>
                    </div>
                </div>
            </li>
            <li class="cl-son_fl-item cl-widget-arcoding">
                <div class="cl-click-acording">
                    <span class="cl-title-item">CATEGORY</span>
                </div>
                <ul class="cl-style-colection">
                    @foreach($categories as $value)
                        <li class="cl-item">
                                {{--@if($value->categoryChildren->count())
                                    <i>></i>
                                @endif --}}
                            @if(Request::is('category-product/'.$value->category_id))
                              <a class="cl-title-link active">{{$value->category_name}}</a>
                            @else
                              <a href="{{URL::to('/category-product/'.$value->category_id)}}" 
                                class="cl-title-link">{{$value->category_name}}</a>
                            @endif
                        </li>
                        @include('pages.include.child_category',['value' => $value])
                    @endforeach 
                </ul>

            </li>
            <li class="cl-son_fl-item cl-widget-arcoding">
                <div class="cl-click-acording">
                    <span class="cl-title-item">BRAND</span>
                </div>
                <ul class="cl-choose-type cl-style-colection">
                    @foreach($brand as $value)
                        @if(request()->get('brand') ==  $value->brand_id)
                            <li class="cl-item">
                                <a class="cl-title-link active" href="{{ request()->fullUrlWithQuery(['brand' => null]) }}">
                                    {{$value->brand_name}} 
                                </a>
                            </li>
                        @else
                            <li class="cl-item">
                                <a class="cl-title-link" href="{{ request()->fullUrlWithQuery(['brand' => $value->brand_id]) }}">
                                    {{$value->brand_name}} 
                                </a>
                            </li>
                        @endif
                    @endforeach 
                </ul>
            </li>
            <li>
            <li class="cl-son_fl-item cl-widget-arcoding">
                <div class="cl-click-acording">
                    <span class="cl-title-item">COLOR</span>
                </div>
                <ul class="cl-choose-type cl-style-colection cl-color_and_size">
                    @foreach($color as $value)
                        @if(request()->get('color') == $value->color_name)
                            <li class="cl-item">
                                <a class="cl-title-link active" href="{{ request()->fullUrlWithQuery(['color' => null]) }}">
                                    {{$value->color_name}} 
                                </a>
                            </li>
                        @else
                            <li class="cl-item">
                                <a class="cl-title-link" href="{{ request()->fullUrlWithQuery(['color' => $value->color_name]) }}">
                                    {{$value->color_name}} 
                                </a>
                            </li>
                        @endif
                    @endforeach 
                </ul>
            </li>
            <li class="cl-son_fl-item cl-widget-arcoding">
                <div class="cl-click-acording">
                    <span class="cl-title-item">SIZE</span>
                </div>
                <ul class="cl-choose-type cl-style-colection cl-color_and_size">
                    @foreach($size as $value)
                        @if(request()->get('size') == $value->size_name)
                            <li class="cl-item">
                                <a class="cl-title-link active" href="{{ request()->fullUrlWithQuery(['size' =>null]) }}">
                                    {{$value->size_name}} 
                                </a>
                            </li>
                        @else
                            <li class="cl-item">
                                <a class="cl-title-link" href="{{ request()->fullUrlWithQuery(['size' => $value->size_name]) }}">
                                    {{$value->size_name}} 
                                </a>
                            </li>
                        @endif
                    @endforeach 
                </ul>
            </li>
            <li class="cl-son_fl-item cl-widget-arcoding">
                <div class="cl-click-acording">
                    <span class="cl-title-item">PRICE</span>
                </div>
                <ul class="cl-choose-type cl-style-colection">

                    @for($i=1; $i<=5; $i++)
                        @if(request()->get('price') == $i)
                            <li class="cl-item">
                                <a class="cl-title-link active" href="{{ request()->fullUrlWithQuery(['price' =>null]) }}">
                                    less than equal to {{number_format($i*200000,0,',','.').' '."VNĐ"}}
                                </a>
                            </li>
                        @else
                            <li class="cl-item">
                                <a class="cl-title-link" href="{{ request()->fullUrlWithQuery(['price'=> $i ]) }}">
                                    less than equal to {{number_format($i*200000,0,',','.').' '."VNĐ"}} 
                                </a>
                            </li>
                        @endif

                    @endfor
                        @if(request()->get('price') == 6)
                            <li class="cl-item">
                                <a class="cl-title-link active" href="{{ request()->fullUrlWithQuery(['price' =>null]) }}">
                                    more than equal to {{number_format(1000000,0,',','.').' '."VNĐ"}} 
                                </a>
                            </li>
                        @else
                            <li class="cl-item">
                                <a class="cl-title-link" href="{{ request()->fullUrlWithQuery(['price'=> 6 ]) }}">
                                    more than equal to {{number_format(1000000,0,',','.').' '."VNĐ"}} 
                                </a>
                            </li>
                        @endif

                </ul>
            </li>
        </ul>
        
    </form>
</div>