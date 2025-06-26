<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login Or SignUp</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="{{asset('admin/login/images/icons/favicon.ico')}}"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('admin/login/vendor/bootstrap/css/bootstrap.min.css')}}">
<!--===============================================================================================-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="stylesheet" type="text/css" href="{{asset('admin/login/fonts/font-awesome-4.7.0/css/font-awesome.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('admin/login/vendor/animate/animate.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('admin/login/vendor/css-hamburgers/hamburgers.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('admin/login/vendor/animsition/css/animsition.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('admin/login/vendor/select2/select2.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('admin/login/vendor/daterangepicker/daterangepicker.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('admin/login/css/util.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('admin/login/css/main.css')}}">
<!--===============================================================================================-->
</head>
<body>

	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<form class="login100-form validate-form p-l-55 p-r-55 p-t-178" action="{{ url('login') }}" method="POST">
                    @csrf

					<span class="login100-form-title">
						Sign In
					</span>

					<div class="wrap-input100 validate-input m-b-16" data-validate="Please enter email">
						<input class="input100" type="text" name="email" placeholder="Email" value="{{ old('email') }}">
						<span class="focus-input100">
                        </span>
					</div>

                    @error('email')
                            <span class="text-danger">{{ $message }}</span>
                    @enderror

					<div class="wrap-input100 validate-input" data-validate = "Please enter password">
						<input class="input100" type="password" name="password" placeholder="Password">
						<span class="focus-input100"></span>
					</div>
                    @error('password')
                            <span class="text-danger">{{ $message }}</span>
                    @enderror

					<div class="text-right p-t-13 p-b-23">
						<span class="txt1">
							Forgot
						</span>

						<a href="#" class="txt2">
							Username / Password?
						</a>
					</div>

					<div class="container-login100-form-btn mb-3">
						<button type="submit" class="login100-form-btn">
							Sign in
						</button>
					</div>

                    <hr>

					<div class="container-login100-form-btn mb-3 d-flex flex-column gap-2">
                        <a href="{{ route('socialLogin', 'google') }}" class="btn btn-danger btn-block rounded-pill">
                            <i class="fab fa-google me-2"></i> Sign in with Google
                        </a>
                        <a href="{{ route('socialLogin', 'github') }}" class="btn btn-dark btn-block rounded-pill">
                            <i class="fab fa-github me-2"></i> Sign in with GitHub
                        </a>
                    </div>

					<div class="flex-col-c p-t-170 p-b-20">
						<span class="txt1 p-b-9">
							Don’t have an account?
						</span>

						<a href="{{route('register')}}" class="txt3">
							Sign up now
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>


<!--===============================================================================================-->
	<script src="{{asset('admin/login/vendor/jquery/jquery-3.2.1.min.js')}}"></script>
<!--===============================================================================================-->
	<script src="{{asset('admin/login/vendor/animsition/js/animsition.min.js')}}"></script>
<!--===============================================================================================-->
	<script src="{{asset('admin/login/vendor/bootstrap/js/popper.js')}}"></script>
	<script src="{{asset('admin/login/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
<!--===============================================================================================-->
	<script src="{{asset('admin/login/vendor/select2/select2.min.js')}}"></script>
<!--===============================================================================================-->
	<script src="{{asset('admin/login/vendor/daterangepicker/moment.min.js')}}"></script>
	<script src="{{asset('admin/login/vendor/daterangepicker/daterangepicker.js')}}"></script>
<!--===============================================================================================-->
	<script src="{{asset('admin/login/vendor/countdowntime/countdowntime.js')}}"></script>
<!--===============================================================================================-->
	<script src="{{asset('admin/login/js/main.js')}}"></script>

</body>
</html>



