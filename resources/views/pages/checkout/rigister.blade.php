@extends('layout')
@section('content')
	<div class="container th-banner">
		<div class="cl-breacrumb-product">
			<div class="cl-list-breacrumb">
				<ul class="cl-content-breacrumb">
					<li><a href="index.php" class="cl-link" title="">Home</a></li>
					<li><span class="cl-link disabled">Register</span></li>
				</ul>
			</div>
		</div>
      <?php
          $message = Session::get('message_check_account');
          if($message){
              echo '<span class="error">'.$message.'</span>';
              Session::put('message_check_account',null);
          }
      ?>
		<div class="th-form-login row">
			<div class="th-form col-md-7">
				<h1 class="th-title">Register</h1>
				<form action="{{URL::to('/add-customer')}}" method="POST">
					@csrf
					<table >
						<tbody class="cl-row_50_percent">
							<tr>
								<td>
									<div class="form-group">
										<label class="cl-label-form" for="">Name :</label>
										<input type="text" class="th-form-control" name="customer_name" placeholder="Name..." required="">
									</div>
								</td>
							</tr>
							<tr>
								<td>
									<div class="form-group">
										<label class="cl-label-form" for="">Email :</label>
										<input type="email" class="th-form-control" name="customer_email" placeholder="Email..." required="">
									</div>
								</td>
							</tr>
							<tr>
								<td>
									<div class="form-group">
										<label class="cl-label-form" for="">Phone :</label>
										<input type="text" class="th-form-control" name="customer_phone" pattern="0[0-9\s.-]{9,11}" placeholder="Phone..." required="">
									</div>
								</td>
							</tr>
							<tr>
								<td>
									<div class="form-group">
										<label class="cl-label-form" for="">Password :</label>
										<input type="password" class="th-form-control" name="customer_password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" placeholder="Password..." required="">
									</div>
								</td>
							</tr>
							<tr>
								<td>
									<div class="form-group">
										<label class="cl-label-form" for="">Address :</label>
										<textarea type="text" rows="5" class="th-form-control" name="customer_address" placeholder="Ex: Apartment number - Hamlet or Street - Commune or Town - District - City" required=""></textarea>
									</div>
								</td>
							</tr>
						</tbody>
					</table>
					<div class="th-form-check">
						<button name="submit" type="submit" class="th-btn">CREATE</button>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection