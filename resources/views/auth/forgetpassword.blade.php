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
										Forget Password
									</h3>
								</div>
                               
                                <form class="m-login__form m-form" method="POST" action="{{route('forgetpage')}}">
                                <input type="hidden" name="_token" value="<?php echo @csrf_token(); ?>">
                                <input type="hidden" name="userID" value="<?php echo $_GET['id']; ?>"/>
								<div class="form-group m-form__group">
										<input class="form-control m-input" type="password" placeholder="Password" id="password" name="password">
                                          <span class="error-message password-check" style="display:none">
																			  The field is required.
																			    </span>
									</div>
                                  
									<div class="form-group m-form__group">
										<input class="form-control m-input m-login__form-input--last" type="password" placeholder="Confirm Password" id="rpassword" name="rpassword">
                                        <span class="error-message password-check" style="display:none">
																			  The field is required.
																			    </span>
                                                                                 <span class="error-message confirm-password-check-match" style="display:none">
																			  Password do not match.
																			    </span>
									</div>
                                    
								<div class="m-login__form-action text-center">
									<button id="submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn m-login__btn--primary loginhome">
										Submit
									</button>
								</div>
                                </form>
								
							</div>
							
							
							
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
	
</body>
<!-- end::Body -->
</html>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
	<!--var loginurl = "{{ URL::to('/login')}}";
	<!--setTimeout(function(){  window.location.href= loginurl; }, 3000);
	
	$("#submit").on("click", function(){
		var error = 0;
		
		
		if($('#rpassword').val() == ''){
		//alert(name);
		  $('#rpassword').focus();
		  $('.confirm-password-check').show();
		  error=1;
		  
	}else{
		
	     $('.confirm-password-check').hide();
		 
	}
	//end
	//password number validation
	//start
	if($('#password').val() == ''){
		
		//alert(name);
		  $('#password').focus();
		  $('.password-check').show();
		  error=1;
		  
	}else{
		
	  $('.password-check').hide();
	  
	} 
		var password = $('#password').val();
		var rpassword = $('#rpassword').val();
		//alert('tesrt');
		
		
		 var password = $("#password").val();
            var confirmPassword = $("#rpassword").val();
            if (password != confirmPassword) {
                $('.confirm-password-check-match').show();
				$('.password-check').hide();
				$('.confirm-password-check').hide();
                return false;
            }
			
			if(error == 1){
		return false;
	}else{
		//alert('hi');
		$('#submit').submit();
	
	}
	
	 
		
		});
</script>
<style>
#errmsg
{
 color:red;
}

.error-message {
    color: #ff3c41;
    padding: 5px 10px;
    margin-left: 0;
    width: 100%;
}
</style>