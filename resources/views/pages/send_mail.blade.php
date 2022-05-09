@extends('layout')
@section('content')
 <div>
   <div class="contact">
      <div class="container">
        @if(session('success'))
           <div class="success">
             {{ session('success') }}
           </div>
        @endif
         <div class="row">
            <div class="col-md-6 order-md-1">
               <p class="font-family-Poppins cl-black fontsize-30px font-weight-bold mt-5"><strong>Contact Us</strong></p>
               <p>We love to hear from you on our customer service, merchandise, website or any topics you want to share with us. Your comments and suggestions will be appreciated. Please complete the form below.</p>
               <p>
                  <i class="fa fa-map-marker margin-right-10px" aria-hidden="true"></i>
                  <span class="font-family-Poppins font-weight-normal">  238 Z115, Tân Thịnh, Thành phố Thái Nguyên, Thái Nguyên, Việt Nam.</span>
               </p>
               <p>
                  <i class="fa fa-phone margin-right-10px"></i>
                  <span class="font-family-Poppins font-weight-normal">(+84) 327748844.</span>
               </p>
               <div class="form" >
                  <form action="{{URL::to('/send-mail')}}" method="POST">
                     @csrf
                     <div class="row">
                        <div class="col-md-6 margin-top-28px">
                           <input type="text" name="name" class="form-control" placeholder="Your name(*)" required="">
                        </div>
                        <div class="col-md-6 margin-top-28px">
                           <input type="email" name="email" class="form-control" placeholder="Your email(*)" required="">
                        </div>
                        <div class="col-md-12 margin-top-28px">
                           <input type="text" name="subject" class="form-control" placeholder="Subject(*)" required="">
                        </div>
                        <div class="col-md-12 margin-top-28px">
                           <textarea name="content" rows="8" class="form-control" placeholder="Message(*)" required=""></textarea>
                        </div>
                     </div>
                     <div class="send-button">
                        <button type="submit" name="send" class="button">SEND MESSAGE</button>
                     </div>
                  </form>
               </div>
            </div>
            <div class="col-md-6 map">
               <div id="map" style="width: 100%;"><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3710.0888394485187!2d105.80665576577802!3d21.582455061641625!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31352738545565f9%3A0xa1c9eff2baedd11e!2zTmfDtSAxOTUsIFTDom4gVGjhu4tuaCwgVHAuIFRow6FpIE5ndXnDqm4sIFRow6FpIE5ndXnDqm4sIFZp4buHdCBOYW0!5e0!3m2!1svi!2s!4v1590054995279!5m2!1svi!2s" width="100%" height="670" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe></div>
            </div>
         </div>
      </div>
   </div>
</div> 


@endsection