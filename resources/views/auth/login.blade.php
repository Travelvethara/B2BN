
<!DOCTYPE html>
<html lang="en" >
<!-- begin::Head -->
<head>
	<meta charset="utf-8" />
	<title>
		B2B Project
	</title>
	<meta name="description" content="Latest updates and statistic charts">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!--begin::Web font -->
	<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
	<script>
		WebFont.load({
			google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	</script>
	<!--end::Web font -->
	<!--begin::Base Styles -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">
	<link href="css/fullcalendar.bundle.css" rel="stylesheet" type="text/css" />
	<!--end::Page Vendors -->
	<link href="css/vendors.bundle.css" rel="stylesheet" type="text/css" />
	<link href="css/style.bundle.css" rel="stylesheet" type="text/css" />
	<link href=" css/custom.css" rel="stylesheet" type="text/css" />
	<link href=" css/custom-responsive.css" rel="stylesheet" type="text/css" />
	<!--end::Base Styles -->
	<link rel="shortcut icon" href="assets/demo/default/media/img/logo/favicon.ico" />
</head>
<!-- end::Head -->
<!-- end::Body -->
<body  class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default"  >
	<!-- begin:: Page -->
	<div class="m-grid m-grid--hor m-grid--root m-page">
		<div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-grid--tablet-and-mobile m-grid--hor-tablet-and-mobile m-login m-login--1 m-login--signin" id="m_login">
			<div class="m-grid__item m-grid__item--order-tablet-and-mobile-2 m-login__aside" style="margin:auto;">
				<div class="m-stack m-stack--hor m-stack--desktop">
					<div class="m-stack__item m-stack__item--fluid">
						<div class="m-login__wrapper">
							<div class="m-login__logo">
								<a href="{{route('login')}}">
									<img src="./img/logo_default_dark.png">
								</a>
							</div>
							<div class="m-login__signin">
								<div class="m-login__head">
									<h3 class="m-login__title">
										Login
									</h3>
								</div>
								<form method="POST" action="{{ route('login') }}" class="m-login__form m-form loginsubmit">
									<input type="hidden" name="_token" value="<?php echo @csrf_token(); ?>">
									@if ($errors->has('email'))
									<?php if($errors->first('email') == 'These credentials do not match our records.') {?>
										<div class="m-alert m-alert--outline alert alert-danger alert-dismissible animated fadeIn" role="alert">			<button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>			<span>Incorrect username or password. Please try again.</span>		</div>
									<?php } ?>
									@endif
									<div class="form-group m-form__group">
										<input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="Email" >
										<span class="invalid-feedback email-check" style="display:none">
											<strong>The field is required.</strong>
										</span>
										<span class="invalid-feedback email-involid-check" style="display:none">
											<strong>The email is involid.</strong>
										</span>
										@if ($errors->has('email'))
										<span class="invalid-feedback">
											<?php  if($errors->first('email') == 'The email field is required.') {?>
												<strong>The field is required.</strong>
											<?php } ?>
										</span>
										@endif
									</div>
									<div class="form-group m-form__group">
										<input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Password">
										
										<span class="invalid-feedback password-check" style="display:none">
											<strong>The field is required.</strong>
										</span>
										@if ($errors->has('password'))
										<span class="invalid-feedback">
											<strong>The field is required.</strong>
										</span>
										@endif
									</div>
									<div class="row m-login__form-sub">
										<div class="col m--align-left m-login__form-left">
											<label class="m-checkbox  m-checkbox--focus">
												<input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
												Remember me
												<span></span>
											</label>
										</div>
										<div class="col m--align-right m-login__form-right">
											<a href="javascript:;" id="m_login_forget_password" class="m-link">
												Forget Password ?
											</a>
										</div>
									</div>
									<div class="m-login__form-action">
										<button id="" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn m-login__btn--primary loginhome">
											Sign In
										</button>
									</div>
								</form>
							</div>
							<div class="m-login__signup">
								<div class="m-login__head">
									<h3 class="m-login__title">
										Sign Up
									</h3>
									<div class="m-login__desc">
										Enter your details to create your account:
									</div>
								</div>
								<form class="m-login__form m-form" action="">
									<div class="form-group m-form__group">
										<input class="form-control m-input" type="text" placeholder="Fullname" name="fullname">
									</div>
									<div class="form-group m-form__group">
										<input class="form-control m-input" type="text" placeholder="Email" name="email" autocomplete="off">
									</div>
									<div class="form-group m-form__group">
										<input class="form-control m-input" type="password" placeholder="Password" name="password">
									</div>
									<div class="form-group m-form__group">
										<input class="form-control m-input m-login__form-input--last" type="password" placeholder="Confirm Password" name="rpassword">
									</div>
									<div class="row form-group m-form__group m-login__form-sub">
										<div class="col m--align-left">
											<label class="m-checkbox m-checkbox--focus">
												<input type="checkbox" name="agree">
												I Agree the
												<a href="#" class="m-link m-link--focus">
													terms and conditions
												</a>
												.
												<span></span>
											</label>
											<span class="m-form__help"></span>
										</div>
									</div>
									<div class="m-login__form-action">
										<button id="m_login_signup_submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air">
											Sign Up
										</button>
										<button id="m_login_signup_cancel" class="btn btn-outline-focus  m-btn m-btn--pill m-btn--custom">
											Cancel
										</button>
									</div>
								</form>
							</div>
							<div class="m-login__forget-password">
								<div class="m-login__head">
									<h3 class="m-login__title">
										Forgotten Password ?
									</h3>
									<div class="m-login__desc">
										Enter your email to reset your password:
									</div>
								</div>
								<form class="m-login__form m-form" method="POST" action="{{route('registersignup')}}">
									<div class="form-group m-form__group">
										<input class="form-control m-input" type="text" placeholder="Email" name="email" id="m_email" autocomplete="off">
										<span class="invalid-feedback email-check" style="display:none;">
											<strong>The field is required.</strong>
										</span>
										<span class="invalid-feedback email-invalid" style="display:none;">
											<strong>your email is not valid..</strong>
										</span>
										<span class="invalid-feedback email-active-check" style="display:none;">
											<strong>Your email id is not active.</strong>
										</span>
                                        <span class="email-active-check-send-mail" style="display:none;width: 100%;margin-top: .25rem;font-size: 80%;color: #4CAF50;">
											<strong>The email send sucessfully.</strong>
										</span>
									</div>
									<div class="m-login__form-action">
										<button type="button" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air forwardpass_check">
											Request
										</button>
										<button id="m_login_forget_password_cancel" class="btn btn-outline-focus m-btn m-btn--pill m-btn--custom">
											Cancel
										</button>
									</div>
								</form>
							</div>
						</div>
					</div>
					<div class="m-stack__item m-stack__item--center">
						<div class="m-login__account">
							<span class="m-login__account-msg">
								Don't have an Agency yet ?
							</span>
							&nbsp;&nbsp;
							<a href="{{route('registersignup')}}" id="m_login_signup1" class="m-link m-link--focus m-login__account-link signup-front">
								Create Agency
							</a>
						</div>
					</div>
				</div>
			</div>
			<div class="m-grid__item m-grid__item--fluid m-grid m-grid--center m-grid--hor m-grid__item--order-tablet-and-mobile-1	m-login__content" style="background-image: url(./img/bg-4.jpg); display:none">
				<div class="m-grid__item m-grid__item--middle">
					<h3 class="m-login__welcome">
						Join Our Community
					</h3>
					<p class="m-login__msg">
						Lorem ipsum dolor sit amet, coectetuer adipiscing
						<br>
						elit sed diam nonummy et nibh euismod
					</p>
				</div>
			</div>
		</div>
	</div>
	<!-- end:: Page -->
	<!--begin::Base Scripts -->
	<script src="js/vendors.bundle.js" type="text/javascript"></script>
	<script src="js/scripts.bundle.js" type="text/javascript"></script>
	<!--end::Base Scripts -->   
	<!--begin::Page Snippets -->
	<script src="js/login.js" type="text/javascript"></script>
	<!--end::Page Snippets -->
	<script type="text/javascript" >
		var forgetpassowrdlogin = "{{ URL::to('/forgetpassowrdlogin')}}";
		
		//login validation
		
		
		$(document).on('click', '.loginhome', function(){
			
			var error = 0;
			//website validation
			//start
			if($('#password').val() == ''){
			//alert(name);
			$('#password').focus();
			$('.password-check').show();
			error=1;
		}else{
			$('.password-check').hide();
		}
		
		
		
		
		var sEmail = $('#email').val();
		if($.trim(sEmail).length == 0){
			$('#email').focus();
			$('.email-check').show();
			error=1;
		}
		if($('#email').val() != ''){
			if(validateEmail(sEmail)){
				
				$('.email-check').hide();
				$('.email-involid-check').hide();
			}else{
				$('.email-check').hide();
				$('.email-involid-check').show();
				$('#email').focus();
				error=1;
			}
		}
		
		if(error == 1){
			return false;
		}else{
			$('.loginsubmit').submit();
		}
		
	});
		
		
		
		
		
		
		
		$(document).on('click', '.forwardpass_check', function(){
			
			var error =0;
			var sEmail = $("#m_email").val();
							  //email
						//var sEmail = $('.input-email').val();
						if($.trim(sEmail).length == 0){
							$('.email-check').show();
							$('#m_email').focus();
							$('.email-invalid').hide();
							$('.email-active-check').hide();
							error=1;
						}
						if($('#m_email').val() != ''){
							//alert(sEmail);
							if(validateEmail(sEmail)){
								
								
							}else{
								$('.email-invalid').show();
								('.email-active-check').hide();
								error=1;
							}
						}
				  //console.log(useremail);
				  
				  if(error == 0){
				 $.ajax
						({
						  type: "GET",
						  url: forgetpassowrdlogin,
						  data: {'useremail': sEmail},
						  success: function(response)
						  {
							 console.log(response);
							 if(response == 'faild'){
							 $('.email-active-check').show();
							 }else{
							 $('.email-active-check-send-mail').show();
							 }
						  }
						});
				  }

					});
		function validateEmail(sEmail) {
			var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
			if (filter.test(sEmail)) {
				return true;
			}
			else {
				
				return false;
			}
		}
	</script>
    
      <script language="javascript">
document.onmousedown=disableclick;
status="Right Click Disabled";
function disableclick(event)
{
  if(event.button==2)
   {
     alert(status);
     return false;    
   }
}
document.onkeydown = function(e) {
  if(event.keyCode == 123) {
     return false;
  }
  if(e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)) {
     return false;
  }
  if(e.ctrlKey && e.shiftKey && e.keyCode == 'C'.charCodeAt(0)) {
     return false;
  }
  if(e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)) {
     return false;
  }
  if(e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)) {
     return false;
  }
}


</script>
</body>
<!-- end::Body -->
</html>
