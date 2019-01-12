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
        <!--begin::Page Vendors -->
		
	<link rel="dns-prefetch" href="https://fonts.gstatic.com">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" /> 
        <link href="css/vendors.bundle.css" rel="stylesheet" type="text/css" />
		<link href="css/style.bundle.css" rel="stylesheet"  />
       
		<link href="{{asset('/css/custom.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('/css/custom-responsive.css')}}" rel="stylesheet" type="text/css" />
        
		<!--end::Base Styles -->
		<link rel="shortcut icon" href="/img/logo/favicon.ico" />
	</head>
    
    <?php 
	
	  $agecnyresultsnotification = DB::select( DB::raw("SELECT * FROM agency WHERE notification_staus_new = '1' AND notification_staus_read = '0'"));
	   
	  $agecnyresultsnotificationread = DB::select( DB::raw("SELECT * FROM agency WHERE notification_staus_new = '0'"));
	
	?>
    
    

    
	<!-- end::Head -->
    <!-- end::Body -->
	<body  class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default"  >
		<!-- begin:: Page -->
		<div class="m-grid m-grid--hor m-grid--root m-page">
        <div class="loader-fixed" style="display:none;">
	      <img src="img/ldr.gif" />
         </div>



