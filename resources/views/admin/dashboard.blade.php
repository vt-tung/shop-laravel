@extends('admin_layout')
@section('admin_content')
	@php
        $admin_id   = Session::get('admin_id');
        $admin_role = Session::get('admin_role');
	@endphp
	@if($admin_id && $admin_role==1)
	<div class="market-updates">
		<div class="col-md-3 market-update-gd">
			<a href="{{URL::to('/comment')}}" class="market-update-block clr-block-2">
				<div class="col-md-4 market-update-right">
					<i class="fa fa-star"> </i>
				</div>
				 <div class="col-md-8 market-update-left">
				 <h4>Rating</h4>
				<h3>{{$comment}}</h3>
				<p>Other hand, we denounce</p>
			  </div>
			  <div class="clearfix"> </div>
			</a>
		</div>
		<div class="col-md-3 market-update-gd">
			<a href="{{URL::to('list-customer')}}" class="market-update-block clr-block-1">
				<div class="col-md-4 market-update-right">
					<i class="fa fa-users" ></i>
				</div>
				<div class="col-md-8 market-update-left">
				<h4>Users</h4>
					<h3>{{$customer}}</h3>
					<p>Other hand, we denounce</p>
				</div>
			  <div class="clearfix"> </div>
			</a>
		</div>
		<div class="col-md-3 market-update-gd">
			<a href="{{URL::to('/list-coupon')}}" class="market-update-block clr-block-3">
				<div class="col-md-4 market-update-right">
					<i class="fa fa-usd"></i>
				</div>
				<div class="col-md-8 market-update-left">
					<h4>Coupon</h4>
					<h3>{{$coupon}}</h3>
					<p>Other hand, we denounce</p>
				</div>
			  <div class="clearfix"> </div>
			</a>
		</div>
		<div class="col-md-3 market-update-gd">
			<a href="{{URL::to('/manage-order')}}" class="market-update-block clr-block-4">
				<div class="col-md-4 market-update-right">
					<i class="fa fa-shopping-cart" aria-hidden="true"></i>
				</div>
				<div class="col-md-8 market-update-left">
					<h4>Orders</h4>
					<h3>{{$order}}</h3>
					<p>Other hand, we denounce</p>
				</div>
			  <div class="clearfix"> </div>
			</a>
		</div>
	   <div class="clearfix"> </div>
	</div>
	<div class="container-fluid">
		<style type="text/css">
			h2.title_thongke {
			    text-align: center;
			    font-size: 20px;
			    font-weight: bold;
			    margin-bottom: 30px;
			}

			.cl-select-filter{
				text-align: right;
			}

			.filter-from-day{
				margin-right: 10px;
			}
			.filter-from-day, .filter-to-day{
				display: inline-flex;
			}

			.filter-from-day label, .filter-to-day label, .cl-select-filter label{
				margin-right: 5px;
			}
		</style>
		<div class="row" style="padding: 0 15px;">
			<div class="col-md-12 agileinfo-grap" style="padding: 2em 0!important;">
				<h2 class="title_thongke">Statistics of sales and profits</h2>

				<form autocomplete="off" class="col-md-12">
					@csrf

					<div class="col-md-8">
						<div class="filter-from-day">
							<label>From:</label>
							<input type="text" id="datepicker" class="form-control">
						</div>
						<div class="filter-to-day">
							<label>to:</label>
							<input type="text" id="datepicker2" class="form-control">
							<input type="button" id="btn-dashboard-filter" class="btn btn-primary btn-sm" value="Filter" style="margin-left:15px">
						</div>
					</div>

					<div class="col-md-4 cl-select-filter">
						<div style="display: inline-flex;">
							<label>Filter:</label>
							<div >
								<select class="dashboard-filter form-control" >
									<option>--Not select--</option>
									<option value="7ngay">The past 7 days</option>
									<option value="thangtruoc">Last month</option>
									<option value="thangnay">This month</option>
									<option value="365ngayqua">365 days</option>
								</select>

							</div> 

						</div>

					</div>


				</form>
				<div class="col-sm-12">
					<div id="chart" style="height: auto;"></div>
				</div>
			</div>
		</div>
	</div>

	<div class="agileits-w3layouts-stats">
		<div class="col-md-12 stats-info stats-last widget-shadow">

			<div class="stats-last-agile">

				<table class="table stats-table ">
					<thead>
						<tr>
							<th>Total sales</th>
							<th>Total profits</th>
							<th>Total quantity sold</th>
							<th>Total orders completed</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>{{number_format($sumsales,0,',','.').' '."VNĐ"}}</td>
							<td>{{number_format($sumprofits,0,',','.').' '."VNĐ"}}</td>
							<td>{{$sumquantity}}</td>
							<td>{{$sumorder}}</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<div class="clearfix"> </div>
	</div>
	<div class="agileits-w3layouts-stats">
		<div class="col-md-6 stats-info stats-last widget-shadow">

			<div class="stats-last-agile">
				<div class="stats-title">
					<h4 class="title">Products best seller</h4>
				</div>
				<table class="table stats-table ">
					<thead>
						<tr>
							<th>NO.</th>
							<th>Product</th>
							<th>Sold</th>
						</tr>
					</thead>
					<tbody>
						@foreach($best_sellers as $key => $seller)
						<tr>
							<th scope="row">{{++$key}}</th>
							<td><a href="{{URL::to('/detail-product/'.$seller->product_id)}}">{{$seller->product_name}}</a></td>
							<td>{{$seller->product_sold}}</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
		<div class="col-md-6 stats-info stats-last widget-shadow">

			<div class="stats-last-agile">
				<div class="stats-title">
					<h4 class="title">Products with high views</h4>
				</div>
				<table class="table stats-table ">
					<thead>
						<tr>
							<th>NO.</th>
							<th>Product</th>
							<th>Views</th>
						</tr>
					</thead>
					<tbody>
						@foreach($productview as $key => $proview)
						<tr>
							<th scope="row">{{++$key}}</th>
							<td><a href="{{URL::to('/detail-product/'.$proview->product_id)}}">{{$proview->product_name}}</a></td>
							<td>{{$proview->product_views}}</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>

		<div class="clearfix"> </div>
	</div>
	@else
		<div class="row">
			<div class="panel-body">
				<div class="col-md-12 w3ls-graph">
					<div class="agileinfo-grap">
						<div class="agileits-box">
							<header class="agileits-box-header clearfix">
								<h3 style="margin-bottom: 0!important;">Welcome</h3>
							</header>
						</div>
					</div>

				</div>
			</div>
		</div>
	@endif
<script type="text/javascript">
$(document).ready(function(){

        chart60daysorder();
        var chart = new Morris.Bar({
             
              element: 'chart',
              //option chart
                parseTime: false,
                hideHover: 'auto',
                xkey: 'period',
                ykeys: ['order','sales','profit','quantity'],
                labels: ['Order','Sales','Profit','Quantity'],
                barColors: ['#000000', '#32a84a','#337ab7', '#fa2f51'],

            });


       
        function chart60daysorder(){
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url:"{{url('/days-order')}}",
                method:"POST",
                dataType:"JSON",
                data:{_token:_token},
                
                success:function(data)
                    {
                        chart.setData(data);
                    }   
            });
        }

    $('.dashboard-filter').change(function(){
        var dashboard_value = $(this).val();
        var _token = $('input[name="_token"]').val();
        // alert(dashboard_value);
        $.ajax({
            url:"{{url('/dashboard-filter')}}",
            method:"POST",
            dataType:"JSON",
            data:{dashboard_value:dashboard_value,_token:_token},
            
            success:function(data)
                {
                    chart.setData(data);
                }   
            });

    });

    $('#btn-dashboard-filter').click(function(){
       
        var _token = $('input[name="_token"]').val();

        var from_date = $('#datepicker').val();
        var to_date = $('#datepicker2').val();

         $.ajax({
            url:"{{url('/filter-by-date')}}",
            method:"POST",
            dataType:"JSON",
            data:{from_date:from_date,to_date:to_date,_token:_token},
            
            success:function(data)
                {
                    chart.setData(data);
                }   
        });

    });

});
    
</script>
@endsection

