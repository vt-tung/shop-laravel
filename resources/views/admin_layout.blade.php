<!DOCTYPE html>
<head>
<title>Dashboard</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Visitors Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- bootstrap-css -->
<link rel="stylesheet" href="{{asset('public/backend/css/bootstrap.min.css')}}" >

<meta name="csrf-token" content="{{csrf_token()}}">
<!-- //bootstrap-css -->
<!-- Custom CSS -->
<link href="{{asset('public/backend/css/style.css')}}" rel='stylesheet' type='text/css' />
<link href="{{asset('public/backend/css/style-responsive.css')}}" rel="stylesheet"/>
<link href="{{asset('public/backend/css/jquery.dataTables.min.css')}}" rel="stylesheet"/>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<!-- font CSS -->
<link href='//fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
<!-- font-awesome icons -->
<link rel="stylesheet" href="{{asset('public/backend/css/font.css')}}" type="text/css"/>
<link href="{{asset('public/backend/css/font-awesome.css')}}" rel="stylesheet"> 


<link rel="stylesheet" href="{{asset('public/backend/css/bootstrap-tagsinput.css')}}" type="text/css"/>

<link rel="stylesheet" href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" type="text/css"/>

<link rel="stylesheet" href="{{asset('public/backend/css/morris.css')}}" type="text/css"/>
<!-- calendar -->
<link rel="stylesheet" href="{{asset('public/backend/css/monthly.css')}}" type="text/css"/>
<!-- calendar -->

<!-- //calendar -->
<!-- //font-awesome icons -->
<script src="{{asset('public/frontend/js/jquery-2.1.4.min.js')}}"></script>
{{-- <script src="{{asset('public/backend/js/jquery2.0.3.min.js')}}"></script>
 --}}
<script src="{{asset('public/backend/js/raphael-min.js')}}"></script>
<script src="{{asset('public/backend/js/morris.js')}}"></script>
<script src="{{asset('public/backend/js/ckeditor/ckeditor.js')}}"></script>

</head>
<body>
<section id="container">
<!--header start-->
<header class="header fixed-top clearfix">
<!--logo start-->
<div class="brand">
    <a href="{{URL::to('/dashboard')}}" class="logo">
        WILD
    </a>
    <div class="sidebar-toggle-box">
        <div class="fa fa-bars"></div>
    </div>
</div>
<!--logo end-->

<div class="top-nav clearfix">
    <!--search & user info start-->
    <ul class="nav pull-right top-menu">
{{--         <li>
            <input type="text" class="form-control search" placeholder=" Search">
        </li> --}}
        <!-- user login dropdown start-->
        <li class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                <img alt="" src="{{URL::to('public/backend/images/2.png')}}">
                <span class="username">
                	<?php
					$name = Session::get('admin_name');
					if($name){
						echo $name;
					}
					?>

                </span>
                <b class="caret"></b>
            </a>
            <ul class="dropdown-menu extended logout">
                <li><a href="#"><i class=" fa fa-suitcase"></i>Profile</a></li>
                <li><a href="{{URL::to('/logout')}}"><i class="fa fa-key"></i>Đăng xuất</a></li>
            </ul>
        </li>
        <!-- user login dropdown end -->
       
    </ul>
    <!--search & user info end-->
</div>
</header>
<!--header end-->
<!--sidebar start-->
<aside>
    <div id="sidebar" class="nav-collapse">
        <!-- sidebar menu start-->
        <div class="leftside-navigation">
            <ul class="sidebar-menu" id="nav-accordion">
                <li>
                    <a class="active" href="{{URL::to('/dashboard')}}">
                        <i class="fa fa-dashboard"></i>
                        <span>Dash board</span>
                    </a>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Manage category</span>
                    </a>
                    <ul class="sub">
                        <li><a href="{{URL::to('/add-category-product')}}">Add product category</a></li>
                        <li><a href="{{URL::to('/all-category-product')}}">List of categorys product</a></li>
                    </ul>
                </li>
                 <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Manage brand</span>
                    </a>
                    <ul class="sub">
                        <li><a href="{{URL::to('/add-brand-product')}}">Add product brand</a></li>
                        <li><a href="{{URL::to('/all-brand-product')}}">List of brands product</a></li>
                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Manage product</span>
                    </a>
                    <ul class="sub">
                        <li><a href="{{URL::to('/add-product')}}">Add product</a></li>
                        <li><a href="{{URL::to('/all-product')}}">List of product</a></li>
                    </ul>
                </li>
                @if(Session::get('admin_role')==1)
                    <li class="sub-menu">
                        <a href="javascript:;">
                            <i class="fa fa-book"></i>
                            <span>Manage staff</span>
                        </a>
                        <ul class="sub">
                            <li><a href="{{URL::to('/add-staff')}}">Add staff</a></li>
                            <li><a href="{{URL::to('/list-staff')}}">List staff</a></li>                   
                        </ul>
                    </li>
                     <li class="sub-menu">
                        <a href="javascript:;">
                            <i class="fa fa-book"></i>
                            <span>Manager customer</span>
                        </a>
                        <ul class="sub">
                            <li><a href="{{URL::to('/list-customer')}}">List customer</a></li>                        
                        </ul>
                    </li>
                     <li class="sub-menu">
                        <a href="javascript:;">
                            <i class="fa fa-book"></i>
                            <span>Manager coupon</span>
                        </a>
                        <ul class="sub">
                            <li><a href="{{URL::to('/insert-coupon')}}">Add discount code</a></li>
                            <li><a href="{{URL::to('/list-coupon')}}">List discount code</a></li>                      
                        </ul>
                    </li>
                     <li class="sub-menu">
                        <a href="javascript:;">
                            <i class="fa fa-book"></i>
                            <span>Manage delivery</span>
                        </a>
                        <ul class="sub">
                            <li><a href="{{URL::to('/delivery')}}">Delivery management</a></li>
                        </ul>
                    </li>
                     <li class="sub-menu">
                        <a href="javascript:;">
                            <i class="fa fa-book"></i>
                            <span>Manage rating</span>
                        </a>
                        <ul class="sub">
                            <li><a href="{{URL::to('/comment')}}">Lish rating</a></li>                      
                        </ul>
                    </li>
                     <li class="sub-menu">
                        <a href="javascript:;">
                            <i class="fa fa-book"></i>
                            <span>Manage order</span>
                        </a>
                        <ul class="sub">
    						<li><a href="{{URL::to('/manage-order')}}">Order management</a></li>						
                        </ul>
                    </li>
                    <li class="sub-menu">
                        <a href="javascript:;">
                            <i class="fa fa-book"></i>
                            <span>Manage slider</span>
                        </a>
                        <ul class="sub">
                            <li><a href="{{URL::to('/add-slider')}}">Add slider</a></li>
                            <li><a href="{{URL::to('/manage-slider')}}">List of slider</a></li>
                        </ul>
                    </li>
                @endif             
            </ul>            
        </div>
        <!-- sidebar menu end-->
    </div>
</aside>
<!--sidebar end-->
<!--main content start-->
<section id="main-content">
	<section class="wrapper">
        @yield('admin_content')
    </section>
 <!-- footer -->
		  <div class="footer">
			<div class="wthree-copyright">
			  <p>© 2021 WILD </p>
			</div>
		  </div>
  <!-- / footer -->
</section>
<!--main content end-->
</section>
<script src="{{asset('public/backend/js/bootstrap.js')}}"></script>
<script src="{{asset('public/backend/js/jquery.dcjqaccordion.2.7.js')}}"></script>
<script src="{{asset('public/backend/js/scripts.js')}}"></script>
<script src="{{asset('public/backend/js/jquery.slimscroll.js')}}"></script>
<script src="{{asset('public/backend/js/jquery.nicescroll.js')}}"></script>
<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="js/flot-chart/excanvas.min.js"></script><![endif]-->

 <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{{asset('public/backend/js/jquery.scrollTo.js')}}"></script>

<script type="text/javascript">
    $('.comment_duyet_btn').click(function(){
        var comment_status = $(this).data('comment_status');

        var comment_id = $(this).data('comment_id');
        var _token = $('input[name="_token"]').val();
        if(comment_status==0){
            var alert = 'Successful change';
        }else{
            var alert = 'Change failed';
        }
        $.ajax({
            url:"{{url('/allow-comment')}}",
            method:"POST",
            data:{comment_status:comment_status,comment_id:comment_id, _token: _token},
            success:function(data){
                location.reload();
               $('#notify_comment').html('<span class="text text-alert">'+alert+'</span>');

            }
        });


    });
    $('.btn-reply-comment').click(function(){
        var comment_id = $(this).data('comment_id');

        var comment = $('.reply_comment_'+comment_id).val();

        

        var comment_product_id = $(this).data('product_id');
        var _token = $('input[name="_token"]').val();
        
      $.ajax({
            url:"{{url('/reply-comment')}}",
            method:"POST",

            data:{comment:comment,comment_id:comment_id,comment_product_id:comment_product_id, _token:_token},
            success:function(data){
                $('.reply_comment_'+comment_id).val('');
               $('#notify_comment').html('<span class="text text-alert">Reply to comment successfully</span>');

            }
        });


    });
</script>
<script type="text/javascript">
   
  $( function() {
    $( "#datepicker" ).datepicker({
        prevText:"Last month",
        nextText:"Next month",
        dateFormat:"yy-mm-dd",
        dayNamesMin: [ "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday" ]

    });
    $( "#datepicker2" ).datepicker({
        prevText:"Last month",
        nextText:"Next month",
        dateFormat:"yy-mm-dd",
        dayNamesMin: [ "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday" ]

    });
  } );
 
</script>


<script type="text/javascript">
    $('.order_details').change(function(){
        var order_status = $(this).val();
        var order_id = $(this).children(":selected").attr("id");
        var _token = $('input[name="_token"]').val();

        //lay ra so luong
        quantity = [];
        $("input[name='product_sales_quantity']").each(function(){
            quantity.push($(this).val());
        });
        //lay ra product id
        order_product_id = [];
        $("input[name='order_product_id']").each(function(){
            order_product_id.push($(this).val());
        });

        //lay ra order details id
        order_details_id = [];
        $("input[name='order_details_id']").each(function(){
            order_details_id.push($(this).val());
        });

        if (confirm('Are you sure?')) {
            $.ajax({
                url : '{{url('/update-order-qty')}}',
                method: 'POST',
                data:{_token:_token, order_status:order_status ,order_id:order_id ,quantity:quantity, order_product_id:order_product_id, order_details_id:order_details_id},
                success:function(data){
                    alert('Change order status successfully');
                    location.reload();
                }
            });
        }else{
            location.reload();
        }


    });
</script>
<script type="text/javascript">
    $(document).ready(function(){
        load_gallery();

        function load_gallery(){
            var pro_id = $('.pro_id').val();
            var _token = $('input[name="_token"]').val();
            $.ajax({
                method:"POST",
                url:"{{url('/select-gallery')}}",
                data:{pro_id:pro_id,_token:_token},
                success:function(data){
                    $('#gallery_load').html(data);
                }
            });
        }

        $('#file').change(function(){
            var error = '';
            var files = $('#file')[0].files;

            if(files.length>5){
                error+='<p>You can choose up to 5 photos</p>';
            }else if(files.length==''){
                error+="<p>You can't leave the photo blank</p>";
            }else if(files.size > 2000000){
                error+='<p>Image files cannot be larger than 2MB</p>';
            }

            if(error==''){

            }else{
                $('#file').val('');
                $('#error_gallery').html('<span class="text-danger">'+error+'</span>');
                return false;
            }

        });

        $(document).on('click','.delete-gallery',function(){
            var gal_id = $(this).data('gal_id');
          
            var _token = $('input[name="_token"]').val();
            if(confirm('Are you sure?')){
                $.ajax({
                    url:"{{URL::to('/delete-gallery')}}",
                    method:"POST",

                    data:{gal_id:gal_id,_token:_token},

                    success:function(data){
                        load_gallery();
                        $('#error_gallery').html('<span class="text-danger">Delete image successfully</span>');
                    }
                });
            }
        });

        $(document).on('change','.file_image',function(){

            var gal_id = $(this).data('gal_id');
            var image = document.getElementById("file-"+gal_id).files[0];

            var form_data = new FormData();

            form_data.append("file", document.getElementById("file-"+gal_id).files[0]);
            form_data.append("gal_id",gal_id);

                $.ajax({
                    method:"POST",
                     url:"{{url('/update-gallery')}}",

                    headers:{
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data:form_data,

                    contentType:false,
                    cache:false,
                    processData:false,
                    success:function(data){
                        load_gallery();
                        $('#error_gallery').html('<span class="text-danger">Image update successful</span>');
                    }
                });
            
        });

    });
</script>
<script type="text/javascript">
    $(document).ready(function(){
        load_size();

        function load_size(){
            var pro_id = $('.pro_id').val();
            var _token = $('input[name="_token"]').val();
            // alert(pro_id);
            $.ajax({
                url:"{{url('/select-size')}}",
                method:"POST",
                data:{pro_id:pro_id,_token:_token},
                success:function(data){
                    $('#size_load').html(data);
                }
            });
        }

        $(document).on('blur','.edit_siz_name',function(){
            var siz_id = $(this).data('siz_id');
            var siz_text = $(this).text();
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url:"{{url('/update-size-name')}}",
                method:"POST",
                data:{siz_id:siz_id,siz_text:siz_text,_token:_token},
                success:function(data){
                    load_size();
                    $('#error_size').html('<span class="text-danger">Update size successfully</span>');
                }
            });
        });

        $(document).on('click','.delete-size',function(){
            var siz_id = $(this).data('siz_id');
          
            var _token = $('input[name="_token"]').val();
            if(confirm('Are you sure?')){
                $.ajax({
                    url:"{{url('/delete-size')}}",
                    method:"POST",
                    data:{siz_id:siz_id,_token:_token},
                    success:function(data){
                        load_size();
                        $('#error_size').html('<span class="text-danger">Delete size successfully</span>');
                    }
                });
            }
        });

    });
</script>
<script type="text/javascript">
    $(document).ready(function(){
        load_color();

        function load_color(){
            var pro_id = $('.pro_id').val();
            var _token = $('input[name="_token"]').val();
            // alert(pro_id);
            $.ajax({
                url:"{{url('/select-color')}}",
                method:"POST",
                data:{pro_id:pro_id,_token:_token},
                success:function(data){
                    $('#color_load').html(data);
                }
            });
        }

        $(document).on('blur','.edit_col_name',function(){
            var col_id = $(this).data('col_id');
            var col_text = $(this).text();
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url:"{{url('/update-color-name')}}",
                method:"POST",
                data:{col_id:col_id,col_text:col_text,_token:_token},
                success:function(data){
                    load_color();
                    $('#error_color').html('<span class="text-danger">Update color successfully</span>');
                }
            });
        });

        $(document).on('click','.delete-color',function(){
            var col_id = $(this).data('col_id');
          
            var _token = $('input[name="_token"]').val();
            if(confirm('Are you sure?')){
                $.ajax({
                    url:"{{url('/delete-color')}}",
                    method:"POST",
                    data:{col_id:col_id,_token:_token},
                    success:function(data){
                        load_color();
                        $('#error_color').html('<span class="text-danger">Delete color successfully</span>');
                    }
                });
            }
        });

    });
</script>
<script type="text/javascript">
    $(document).ready(function(){

        fetch_delivery();

        function fetch_delivery(){
            var _token = $('input[name="_token"]').val();
             $.ajax({
                url : '{{url('/select-feeship')}}',
                method: 'POST',
                data:{_token:_token},
                success:function(data){
                   $('#load_delivery').html(data);
                }
            });
        }
        $(document).on('blur','.fee_feeship_edit',function(){

            var feeship_id = $(this).data('feeship_id');
            var fee_value = $(this).text();
             var _token = $('input[name="_token"]').val();
            // alert(feeship_id);
            // alert(fee_value);
            $.ajax({
                url : '{{url('/update-delivery')}}',
                method: 'POST',
                data:{feeship_id:feeship_id, fee_value:fee_value, _token:_token},
                success:function(data){
                   fetch_delivery();
                }
            });

        });
        $('.add_delivery').click(function(){

            var city = $('.city').val();
            var province = $('.province').val();
            var wards = $('.wards').val();
            var fee_ship = $('.fee_ship').val();
            var _token = $('input[name="_token"]').val();
            if(city == '' || province == '' || fee_ship == '' || fee_ship==''){
                alert('Please choose to add shipping fee');
            }else{
                $.ajax({
                    url : '{{url('/insert-delivery')}}',
                    method: 'POST',
                    data:{city:city, province:province, _token:_token, wards:wards, fee_ship:fee_ship},
                    success:function(data){
                        fetch_delivery();
                        if (data.message) {
                            alert(data.message);
                        }
                        $('.city').val('');
                        $('.province').val('');
                        $('.wards').val('');
                        $('.fee_ship').val('');
                    }
                });
            }   

        });

        $(document).on('click','.delete-feeshipping',function(){
            var fee_id = $(this).data('fee_id');
          
            if(confirm('Are you sure?')){
                $.ajax({
                    url:"{{url('/delete-feeshipping')}}",
                    method:"POST",
                    headers:{
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data:{fee_id:fee_id},
                    success:function(data){
                        fetch_delivery();
                    }
                });
            }
        });

        $('.choose').on('change',function(){
            var action = $(this).attr('id');
            var ma_id = $(this).val();
            var _token = $('input[name="_token"]').val();
            var result = '';
            // alert(action);
            //  alert(matp);
            //   alert(_token);

            if(action=='city'){
                result = 'province';
            }else{
                result = 'wards';
            }
            $.ajax({
                url : '{{url('/select-delivery')}}',
                method: 'POST',
                data:{action:action,ma_id:ma_id,_token:_token},
                success:function(data){
                   $('#'+result).html(data);     
                }
            });
        }); 
    })


</script>
<script type="text/javascript">
	CKEDITOR.replace('ckeditor');
	CKEDITOR.replace('ckeditor1');
	CKEDITOR.replace('ckeditor2');
	CKEDITOR.replace('ckeditor3');
	CKEDITOR.replace('ckeditor4');
	CKEDITOR.replace('ckeditor5');
	CKEDITOR.replace('ckeditor6');
	CKEDITOR.replace('ckeditor7');
	CKEDITOR.replace('ckeditor8');
	CKEDITOR.replace('ckeditor9');
</script>
<!-- morris JavaScript -->	
<script>
	$(document).ready(function() {
		//BOX BUTTON SHOW AND CLOSE
	   jQuery('.small-graph-box').hover(function() {
		  jQuery(this).find('.box-button').fadeIn('fast');
	   }, function() {
		  jQuery(this).find('.box-button').fadeOut('fast');
	   });
	   jQuery('.small-graph-box .box-close').click(function() {
		  jQuery(this).closest('.small-graph-box').fadeOut(200);
		  return false;
	   });
	   
	    //CHARTS
	    function gd(year, day, month) {
			return new Date(year, month - 1, day).getTime();
		}
		
		graphArea2 = Morris.Area({
			element: 'hero-area',
			padding: 10,
        behaveLikeLine: true,
        gridEnabled: false,
        gridLineColor: '#dddddd',
        axes: true,
        resize: true,
        smooth:true,
        pointSize: 0,
        lineWidth: 0,
        fillOpacity:0.85,
			data: [
				{period: '2015 Q1', iphone: 2668, ipad: null, itouch: 2649},
				{period: '2015 Q2', iphone: 15780, ipad: 13799, itouch: 12051},
				{period: '2015 Q3', iphone: 12920, ipad: 10975, itouch: 9910},
				{period: '2015 Q4', iphone: 8770, ipad: 6600, itouch: 6695},
				{period: '2016 Q1', iphone: 10820, ipad: 10924, itouch: 12300},
				{period: '2016 Q2', iphone: 9680, ipad: 9010, itouch: 7891},
				{period: '2016 Q3', iphone: 4830, ipad: 3805, itouch: 1598},
				{period: '2016 Q4', iphone: 15083, ipad: 8977, itouch: 5185},
				{period: '2017 Q1', iphone: 10697, ipad: 4470, itouch: 2038},
			
			],
			lineColors:['#eb6f6f','#926383','#eb6f6f'],
			xkey: 'period',
            redraw: true,
            ykeys: ['iphone', 'ipad', 'itouch'],
            labels: ['All Visitors', 'Returning Visitors', 'Unique Visitors'],
			pointSize: 2,
			hideHover: 'auto',
			resize: true
		});
		
	   
	});
	</script>
<!-- calendar -->
	<script type="text/javascript" src="{{asset('public/backend/js/monthly.js')}}"></script>
	<script type="text/javascript">
		$(window).load( function() {

			$('#mycalendar').monthly({
				mode: 'event',
				
			});

			$('#mycalendar2').monthly({
				mode: 'picker',
				target: '#mytarget',
				setWidth: '250px',
				startHidden: true,
				showTrigger: '#mytarget',
				stylePast: true,
				disablePast: true
			});

		switch(window.location.protocol) {
		case 'http:':
		case 'https:':
		// running on a server, should be good.
		break;
		case 'file:':
		alert('Just a heads-up, events will not work when run locally.');
		}

		});
	</script>
	<!-- //calendar -->
</body>
</html>
