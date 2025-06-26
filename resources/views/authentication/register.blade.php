<!DOCTYPE html>
<html>
<head>
<title>SignUp Form</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- Custom Theme files -->
<link href="{{asset('admin/register/style.css')}}" rel="stylesheet" type="text/css" media="all" />
<!-- //Custom Theme files -->
<!-- web font -->
<link href="//fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,700,700i" rel="stylesheet">
<!-- //web font -->
</head>
<body>
	<!-- main -->
	<div class="main-w3layouts wrapper">
		<h1>SignUp Form</h1>
		<div class="main-agileinfo">
			<div class="agileits-top">
				<form action="{{ url('register') }}" method="POST">
                    @csrf

					<input class="text" type="text" name="name" placeholder="Username" required="" value="{{ old('name') }}">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror

					<input class="text email" type="email" name="email" placeholder="Email" required="" value="{{ old('email') }}">
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror

                    <input class="text" type="text" name="phone" placeholder="Phone" required="" value="{{ old('phone') }}">
                    @error('phone')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror

					<input class="text" type="password" name="password" placeholder="Password" required="">
					<input class="text w3lpass" type="password" name="password_confirmation" placeholder="Confirm Password" required="">
					<div class="wthree-text">
						<label class="anim">
							<input type="checkbox" class="checkbox" required="">
							<span>I Agree To The Terms & Conditions</span>
						</label>
						<div class="clear"> </div>
					</div>
					<input type="submit" value="Sign Up">
				</form>
				<p>Do you already have an Account? <a href="{{route('login')}}"> Login Now!</a></p>
			</div>
		</div>
		<!-- copyright -->
		<div class="colorlibcopy-agile">
			<p>© 2018 Colorlib Signup Form. All rights reserved | Design by <a href="https://colorlib.com/" target="_blank">Colorlib</a></p>
		</div>
		<!-- //copyright -->
		<ul class="colorlib-bubbles">
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
		</ul>
	</div>
	<!-- //main -->
</body>
</html>
