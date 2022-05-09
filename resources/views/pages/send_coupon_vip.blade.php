<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<style>
	body {
		font-family: Arial;
	}

	.coupon {
		border: 5px dotted #bbb;
		width: 80%;
		border-radius: 15px;
		margin: 0 auto;
		max-width: 600px;
	}

	.container {
		padding: 2px 16px;
		background-color: #e9635d;
		color: #fff;
	}

	.promo {
		background: #ccc;
		padding: 3px;
	}

	.expire {
		color: #fff;
	}
	p.code {
	    text-align: center;
	    font-size: 20px;
	}
	p.expire {
    text-align: center;
	}
	h2.note {
	    text-align: center;
	    font-size: large;
	    text-decoration: underline;
	}
</style>
</head>
<body>

	<div class="coupon">

		<div class="container">
			<h3 style="text-align: center;">Promo code for VIP customers from WILD SHOP</a>
			</h3>
		</div>
		<div class="container" style="background-color:white; color: #000;">

			<h2 class="note"><b><i>
				@if($coupon['coupon_condition']==1)
					Reduction {{$coupon['coupon_number']}}%
				@else
					Reduction {{number_format($coupon['coupon_number'],0,',','.').' '.'VNĐ'}}
				@endif
			    for total purchase order</i></b></h2> 

			<p>If you already have an account at WILD SHOP, please <a target="_blank" style="color:red" href="{{URL::to('/login-checkout' )}}">login</a> to your account to purchase and enter the code below to receive a discount on purchases, thank you. Wish you a lot of health and peace in life. </p>

		</div>
		<div class="container">
			<p class="code">Use the following Code: <span class="promo">{{$coupon['coupon_code']}}</span> with only {{$coupon['coupon_time']}} discount code, hurry before it runs out.</p>
			<p class="expire">Start day : {{\Carbon\Carbon::createFromFormat('Y-m-d',$coupon['start_coupon'])->format('d/m/Y')}} / Code expiration date: {{\Carbon\Carbon::createFromFormat('Y-m-d',$coupon['end_coupon'])->format('d/m/Y')}}</p>
		</div>

	</div>

</body>
</html> 
