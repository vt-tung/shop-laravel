@extends('layout')
@section('content')

<div class="container th-banner">
	<div class="cl-breacrumb-product">
		<div class="cl-list-breacrumb">
			<ul class="cl-content-breacrumb">
				<li><a href="index.php" class="cl-link" title="">Home</a></li>
				<li><span class="cl-link disabled">Login</span></li>
			</ul>
		</div>
	</div>
      <?php
          $message = Session::get('message_check_login');
          if($message){
              echo '<span class="error">'.$message.'</span>';
              Session::put('message_check_login',null);
          }
      ?>
	<div class="th-form-login row">
		<div class="th-form col-md-6">
			<h1 class="th-title">Login</h1>
			<form method="POST" action="{{URL::to('/login-customer')}}" class="login-form">
				@csrf
				<table>
					<tbody>
						<tr>
							<td>
								<div class="form-group">
									<label class="cl-label-form" for="">Email :</label>
									<input type="email" class="th-form-control" name="email_account" placeholder="Email..." required="">
								</div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="form-group">
									<label class="cl-label-form" for="">Password :</label>
									<input type="password" class="th-form-control" name="password_account" placeholder="Password..." required="">
								</div>
							</td>
						</tr>
					</tbody>
				</table>
				<div class="th-form-check">
					<button name="login" type="submit" class="th-btn">SUBMIT</button>
				</div>
			</form>
			<ul class="cl-list-login">
				<li>
					<a href="{{url('login-customer-google')}}">
						<img width="10%" alt="Đăng nhập bằng tài khoản google"  src="{{asset('public/frontend/images/gg.png')}}">
					</a>
				</li>
				
				<li>
					<a href="{{url('login-facebook-customer')}}">
						<img width="10%" alt="Đăng nhập bằng tài khoản facebook"  src="{{asset('public/frontend/images/fb.png')}}">
					</a>
				</li>
			</ul>
			<p class="text-center" style="text-align: center; margin-top: 20px;">Not a member? <a href="{{URL::to('register')}}" class="cl-signup_now"><strong>Sign up now!</strong></a></p>
		</div>
	</div>
</div>
@endsection