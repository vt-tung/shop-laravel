@if($value->categoryChildren->count())
    <ul class="cl-style-colection cl-style-colection_child">
        @foreach($value->categoryChildren as $categoryChild)
            @if($value->categoryChildren->count())
	            <li class="cl-item cl-item-2">
					{{--@if($categoryChild->categoryChildren->count())
                		<i>></i>
                	@endif --}}
	                @if(Request::is('category-product/'.$categoryChild->category_id))
	                  <a class="cl-title-link active">{{$categoryChild->category_name}} </a>
	                @else
	                  <a href="{{URL::to('/category-product/'.$categoryChild->category_id)}}" 
	                    class="cl-title-link">{{$categoryChild->category_name}} </a>
	                @endif
	            </li>
                @include('pages.include.child_category',['value' => $categoryChild])
            @endif
        @endforeach 
    </ul>
@endif
