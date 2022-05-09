<ul class="cl-menu-dashboard">
   <li>
      @if(Request::is('your-dashboard'))
         <a class="active">DASHBOARD</a>
      @else
         <a href="{{URL::to('/your-dashboard')}}">DASHBOARD</a>
      @endif
   </li>
   <li>
      @if(Request::is('history-order'))
         <a class="active">ORDERED</a>
      @else
         <a href="{{URL::to('/history-order')}}">ORDERED</a>
      @endif
   </li>
   <li>
      @if(Request::is('show-wishlist'))
         <a class="active">WISHLIST</a>
      @else
         <a href="{{URL::to('/show-wishlist')}}">WISHLIST</a>
      @endif
   </li>
   <li>
      <a href="{{URL::to('/logout-checkout')}}">LOGOUT</a>
   </li>
</ul>