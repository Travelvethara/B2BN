<?php 

//active tab
$activetab = 'active show';

$activecon = 'active';

$activecon2 = '';

$activetab2 = '';

$secTab = 'style="cursor:  not-allowed;"';
$route = 'signupagencyregister';

$route1 = 'signupagencymanager';

if(isset($_GET['id']) && !empty($_GET['id'])){
	$route = 'signupagencyupdate';
	$route1 = 'signupagencyregister';
	$secTab = ''; 
	if(isset($_GET['tab']) && !empty($_GET['tab'])){
		
		if($_GET['tab'] == 1){
			$activecon2 = '';
			$activetab2 = '';
			$activetab = 'active show';
			$activecon = 'active';
		}
		if($_GET['tab'] == 2){
			$activetab= '';
			$activecon = '';
			$activecon2 = 'active';
			$activetab2 = 'active show';
			
			
		}
	}

}

//echo $activetab;



/*echo '<pre>';
print_r($PakCities);
echo '</pre>';*/


?>

<!DOCTYPE html>
<!-- 
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 4
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
Renew Support: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
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
	<div class="register-main-page">
		<div class="m-grid__item m-grid__item--fluid m-wrapper sign-up-main-container">
			
			
			<div class="m-login__logo m-login__logo-alter">
				<a href="{{route('login')}}">
					<img src="./img/logo_default_dark.png">
				</a>
			</div>
			<div class="d-flex align-items-center register-create-agency">
				<div class="mr-auto">
					<h3 class="m-subheader__title ">
						Create Agency
					</h3>
				</div>
			</div>
			<!-- BEGIN: Subheader -->
			<div class="agency-signup"> 
				<div class="m-subheader ">
					
					<div class="row">
						<div class="col-md-12 ">
							<ul class="nav nav-tabs  m-tabs-line m-tabs-line--primary registerblockcenter" role="tablist" >
                            
                            
                            <li class="nav-item m-tabs__item" >
									<a class="nav-link m-tabs__link managerdetails{{$activetab}}" data-toggle="tab" href="#m_tabs_6_1" role="tab" aria-selected="false"   >
										Agency Information
									</a>
								</li>
								<li class="nav-item m-tabs__item">
									<a class="nav-link m-tabs__link agencyinfo {{$activetab2}}" title="Please fill your Agency Information details first"  <?php if(isset($_GET['id']) && !empty($_GET['id'])){ ?> data-toggle="tab" href="#m_tabs_6_3" role="tab" aria-selected="true" <?php } echo $secTab;?>>
										Manager Details
									</a>
								</li>
								
								
								
							</ul>
						</div>
						
						
						
						
					</div>
				</div>
				<!-- END: Subheader -->
				<div class="m-content">
					<!--Begin::Section-->
					
					
					<div class="tab-content">
						
						<div class="tab-pane agencyinformation <?php echo $activecon2; ?>" <?php if(isset($_GET['id']) && !empty($_GET['id'])){?> id="m_tabs_6_3" <?php }?> role="tabpanel">
							
							<div class="m-portlet-alterr m-portlet m-portlet-padding agency-info-tab">
								<form action="{{route($route)}}" class="m-form m-form--fit" method="post" id="signformsubmit">
									<input type="hidden" name="_token" value="<?php echo @csrf_token(); ?>">
									<div class="form-group m-form__group row">
										<label class="col-lg-3 col-form-label">Full Name<span class="requiredcls" aria-required="true"> * </span></label>
										<div class="col-lg-6">
											<input type="text" name="name" id="name" class="form-control "  <?php if (isset($agency->name) && !empty($agency->name)){?> value="{{ $agency->name }}" <?php }else{ ?>value="{{old('name')}}"<?php } ?> maxlength="30">
											<span class="error-message fullname-check" style="display:none">
												The field is required.
											</span>
											
											
											@if ($errors->has('name'))
											<span class="error-message">
												The field is required.
											</span>
											@endif
											<!--<span class="m-form__help">Please enter your full name</span>-->
										</div>
									</div>
									<div class="form-group m-form__group row">
										<label class="col-lg-3 col-form-label">Email<span class="requiredcls" aria-required="true"> * </span></label>
										<div class="col-lg-6">
											<input type="email" name="email" id="email" class="form-control " maxlength="30"  aria-describedby="emailHelp" <?php if (isset($agency->email) && !empty($agency->email)){?> value="{{ $agency->email }}" <?php }else{ ?>value="{{old('email')}}"<?php } ?>>
											<!--<span class="m-form__help">Please enter your Email name</span>-->
                                            
                                            <span class="error-message confirm-email-check-match" style="display:none">
													Email do not match.
												</span>
											<span class="error-message email-check" style="display:none">
												The field is required.
											</span>
											<span class="error-message email-involid-check" style="display:none">
												The Email is a not vaild.
											</span>
											@if ($errors->has('email'))
											<span class="error-message">  
												{{ $errors->first('email') }}
											</span>
											@endif	
										</div>
									</div>
                                    
                                    
                                    <div class="form-group m-form__group row">
										<label class="col-lg-3 col-form-label">Confirm Email<span class="requiredcls" aria-required="true"> * </span></label>
										<div class="col-lg-6">
											<input type="email" name="conformemail" id="conformemail" class="form-control " maxlength="30"  aria-describedby="emailHelp" <?php if (isset($agency->email) && !empty($agency->email)){?> value="{{ $agency->email }}" <?php }else{ ?>value="{{old('email')}}"<?php } ?>>
											<!--<span class="m-form__help">Please enter your Email name</span>-->
											<span class="error-message conformemail-check" style="display:none">
												The field is required.
											</span>
											<span class="error-message conformemail-involid-check" style="display:none">
												The Email is a not vaild.
											</span>
											@if ($errors->has('conformemail'))
											<span class="error-message">  
												{{ $errors->first('conformemail') }}
											</span>
											@endif	
										</div>
									</div>
									
									<div class="form-group m-form__group row">
										<label class="col-lg-3 col-form-label">User ID</label>
										<div class="col-lg-6">
											<input type="text" name="userid" class="form-control m-input" readonly  placeholder="AUTO" <?php if (isset($agency->userid) && !empty($agency->userid)){?> value="{{ $agency->userid }}" <?php }else{ ?>value="{{old('userid')}}"<?php } ?>>
											<!--<span class="m-form__help">Please enter your full name</span>-->
										</div>
									</div>
									<?php if (empty($agency->loginid)){ ?>
										<div class="form-group m-form__group row">
											<label class="col-lg-3 col-form-label">Password<span class="requiredcls" aria-required="true"> * </span></label>
											<div class="col-lg-6">
												<input type="password" name="password" id="password" class="form-control  required" >
												<span class="error-message password-check" style="display:none">
													The field is required.
												</span>
												@if ($errors->has('password')) 
												<span class="error-message">
													{{ $errors->first('password') }}
												</span>
												@endif
												<!--<span class="m-form__help">Please enter your Email name</span>-->
											</div>
										</div>
										<div class="form-group m-form__group row">
											<label class="col-lg-3 col-form-label">Confirm Password<span class="requiredcls" aria-required="true"> * </span></label>
											<div class="col-lg-6">
												<input type="password" name="password_confirmation"  id="password_confirmation" class="form-control  required" >
												<span class="error-message confirm-password-check" style="display:none">
													The field is required.
												</span>
												<span class="error-message confirm-password-check-match" style="display:none">
													Password do not match.
												</span>
												
												
												<!--<span class="m-form__help">Please enter your full name</span>-->
												
											</div>
										</div>
									<?php } ?>
									<?php if (!empty($agency->id)){  ?> 
										<input type="hidden" name="agency_id" value="{{Crypt::encrypt(base64_encode($agency->id))}}"/>
									<?php }  ?>
									<div class="m-portlet__foot m-portlet__foot--fit">
										<div class="m-form__actions m-form__actions">
											<div class="row">
												<div class="col-lg-3"></div>
												<div class="col-lg-6 m-login__form-action text-center">
													<button type="submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn m-login__btn--primary create-agency">Create agency</button>
													<!--<button type="button" class="btn btn-outline-focus m-btn m-btn--pill m-btn--custom">Back to Login</button>-->
												</div>
											</div>
										</div>
									</div>
									
									
									
								</div>
							</form>
						</div>
						
						
						<div class="tab-pane  createagency"  role="tabpanel" id="m_tabs_6_1">
							<div class="m-portlet m-portlet-padding agency-info-tab agency-info-tab-two m-form m-portlet-alterr">
								<form action="{{ route($route1) }}" method="POST" id="agency_info">
									<input type="hidden" name="_token" value="<?php echo @csrf_token(); ?>">
									<div class="form-group m-form__group row">
										<label class="col-lg-3 col-form-label">Agency Name<span class="requiredcls" aria-required="true"> * </span></label>
										<div class="col-lg-6">
											<input type="text" class="form-control " maxlength="30"  name="aname" id="aname"  <?php if (isset($agency->aname) && !empty($agency->aname)){?> value="{{ $agency->aname }}" <?php }else{ ?>value="{{old('aname')}}"<?php } ?> maxlength="30"/>
											<!--<span class="m-form__help">Please enter your full name</span>-->
											<span class="error-message agencya-check" style="display:none"> 
												The field is required.
											</span>
											@if ($errors->has('aname'))
											<span class="error-message"> 
												The field is required.
											</span>
											@endif
										</div>
									</div>
									<div class="form-group m-form__group row">
										<label class="col-lg-3 col-form-label">Email<span class="requiredcls" aria-required="true"> * </span></label>
										<div class="col-lg-6">
											<input type="email" class="form-control " maxlength="30" name="aemail" id="aemail" aria-describedby="emailHelp"  <?php if (isset($agency->aemail) && !empty($agency->aemail)){?> value="{{ $agency->aemail }}" <?php }else{ ?>value="{{old('aemail')}}"<?php } ?>>
											<!--<span class="m-form__help">Please enter your Email name</span>-->
                                            <span class="error-message aconfirm-email-check-match" style="display:none">
													Email do not match.
												</span>
											<span class="error-message emaila-check" style="display:none"> 
												The field is required.
											</span>
											<span class="error-message emaila-involid-check" style="display:none"> 
												The Email is a not vaild.
											</span>
											@if ($errors->has('aemail'))
											<span class="error-message">  
												The field is required.
											</span>
											@endif
										</div>
									</div>
                                    
                                    <div class="form-group m-form__group row">
										<label class="col-lg-3 col-form-label">Confirm Email<span class="requiredcls" aria-required="true"> * </span></label>
										<div class="col-lg-6">
											<input type="email" name="conformemail1" id="conformemail1" class="form-control " maxlength="30"  aria-describedby="emailHelp" <?php if (isset($agency->email) && !empty($agency->email)){?> value="{{ $agency->email }}" <?php }else{ ?>value="{{old('email')}}"<?php } ?>>
											<!--<span class="m-form__help">Please enter your Email name</span>-->
											<span class="error-message conformemail1-check" style="display:none">
												The field is required.
											</span>
											<span class="error-message conformemail1-involid-check" style="display:none">
												The Email is a not vaild.
											</span>
											@if ($errors->has('conformemail1'))
											<span class="error-message">  
												{{ $errors->first('conformemail1') }}
											</span>
											@endif	
										</div>
									</div>
									<div class="form-group m-form__group row">
										<label class="col-lg-3 col-form-label">Address line 1<span class="requiredcls" aria-required="true"> * </span></label>
										<div class="col-lg-6">
											<input type="text" class="form-control " maxlength="30"  name="address1" id="address1" <?php if (isset($agency->address1) && !empty($agency->address1)){?> value="{{ $agency->address1 }}" <?php }else{ ?>value="{{old('address1')}}"<?php } ?>>
											<!--<span class="m-form__help">Please enter your full name</span>-->
											<span class="error-message addressa-check" style="display:none"> 
												The field is required.
											</span>
											@if($errors->has('address1'))
											<span class="error-message">  
												The field is required.
											</span>
											@endif
										</div>
									</div>
									<div class="form-group m-form__group row">
										<label class="col-lg-3 col-form-label">Address line 2</label>
										<div class="col-lg-6">
											<input type="text" class="form-control " maxlength="30" name="address2" id="address2" <?php if (isset($agency->address2) && !empty($agency->address2)){?> value="{{ $agency->address2 }}" <?php }else{ ?>value="{{old('address2')}}"<?php } ?>>
											<!--<span class="m-form__help">Please enter your Email name</span>-->
											
										</div>
									</div>
									<div class="form-group m-form__group row">
										<label class="col-lg-3 col-form-label">Country<span class="requiredcls" aria-required="true"> * </span></label>
										<div class="col-lg-6">
											<select name="country" class="form-control" id="country">
												<option value=""> -- Select Contry Name -- </option>
												@foreach($CountryName as  $level)
												<option value="{{ $level}}" <?php if(isset($agency) && !empty($agency)) { if (isset($agency->country) && !empty($agency->country)){ ?> {{'selected'}}<?php } }else if(old('country') == $level){ ?>{{'selected'}}<?php } ?>>{{ $level }}</option>
												@endforeach
											</select>
											<!--<span class="m-form__help">Please enter your full name</span>-->
											<span class="error-message countrya-check" style="display:none"> 
												The field is required.
											</span>
											@if ($errors->has('country'))
											<span class="error-message">  
												The field is required.
											</span>
											@endif 
										</div>
									</div>
							 <div class="form-group m-form__group row cityallo" <?php if(isset($agency) && !empty($agency)) { if($agency->country == 'Pakistan') { ?> style="display:none"; <?php } } ?>>
						                      <label class="col-lg-3 col-form-label">City<span class="requiredcls" aria-required="true"> * </span></label>
						                       <div class="col-lg-6">
							                 <input type="text" class="form-control m-input cityall"   placeholder="" maxlength="30" <?php if(isset($agency) && !empty($agency)) { if($agency->country != 'Pakistan') { ?> name="city" id="city" <?php } }else{  ?> name="city" id="city" <?php } ?>   <?php if (isset($agency->city) && !empty($agency->city)){?> value="{{ $agency->city }}" <?php }else{ ?>value="{{old('city')}}"<?php } ?>>
                                             <span class="error-message citya-check" style="display:none"> 
                       						                         The field is required.
                       							                     </span>
                                 @if ($errors->has('city'))
                                 <span class="error-message"> 
                       						  {{ $errors->first('city') }}
                       							 </span>@endif 
							                                  <!--<span class="m-form__help">Please enter your full name</span>-->
						                         </div>
					                     </div> 
                                         
                                         
                                         <div class="form-group m-form__group row citypo"  <?php if(isset($agency) && !empty($agency)) { if($agency->country == 'Pakistan') { ?>  <?php }else{ ?> style="display:none" <?php } }else{ ?> style="display:none" <?php } ?>>
						                      <label class="col-lg-3 col-form-label">City<span class="requiredcls" aria-required="true"> * </span></label>
						                       <div class="col-lg-6">
							                <select class="form-control cityp" <?php if(isset($agency) && !empty($agency)) { if($agency->country == 'Pakistan') { ?>  name="city" id="city" <?php } } ?>  >
												<option value=""> -- Select City Name -- </option>
												@foreach($PakCities as  $level)
												<option value="{{ $level->CityName}}" <?php if(isset($agency) && !empty($agency)) { if ($agency->city == $level->CityName){ ?> {{'selected'}}<?php } }else if(old('country') == $level->CityName){ ?>{{'selected'}}<?php } ?>>{{ $level->CityName }}</option>
												@endforeach
											</select>
                                             <span class="error-message citya-check" style="display:none"> 
                       						                         The field is required.
                       							                     </span>
                                 @if ($errors->has('city'))
                                 <span class="error-message"> 
                       						  {{ $errors->first('city') }}
                       							 </span>@endif 
							                                  <!--<span class="m-form__help">Please enter your full name</span>-->
						                         </div>
					                     </div> 
                                    
                                    
                                    
									<div class="form-group m-form__group row">
										<label class="col-lg-3 col-form-label">Zip / postal Code<span class="requiredcls" aria-required="true"> * </span></label>
										<div class="col-lg-6">
											<input type="text" class="form-control m-input" maxlength="30"  name="zip" id="zip" placeholder=""  <?php if (isset($agency->pcode) && !empty($agency->pcode)){?> value="{{ $agency->pcode }}" <?php }else{ ?>value="{{old('zip')}}"<?php } ?>>
											<span class="error-message zip-check" style="display:none"> 
												The field is required.
											</span>
											@if ($errors->has('zip'))
											<span class="error-message">  
												The field is required.
											</span>
											@endif
											<!--<span class="m-form__help">Please enter your full name</span>-->
										</div>
									</div>
									<div class="form-group m-form__group row">
										<label class="col-lg-3 col-form-label">Mobile<span class="requiredcls" aria-required="true"> * </span></label>
										<div class="col-lg-6">
											<input type="text" class="form-control " maxlength="30" name="amobile" id="mobile1"   <?php if (isset($agency->amobile) && !empty($agency->amobile)){?> value="{{ $agency->amobile }}" <?php }else{ ?>value="{{old('amobile')}}"<?php } ?>>
											<span class="error-message mobilea-check" style="display:none"> 
												The field is required.
											</span>
											@if ($errors->has('amobile'))
											
											<span class="error-message">  
												The field is required.
											</span>
											@endif
											<!--<span class="m-form__help">Please enter your Email name</span>-->
										</div>
									</div>
									<div class="form-group m-form__group row" style="display:none">
										<label class="col-lg-3 col-form-label">Phone<span class="requiredcls" aria-required="true"> * </span></label>
										<div class="col-lg-6">
											<input type="text" class="form-control "  maxlength="30" name="aphone" id="phone1"    value="675765757657" >
											<span class="error-message phonea-check" style="display:none"> 
												The field is required.
											</span>
											@if ($errors->has('aphone'))
											<span class="error-message">  
												The field is required.
											</span>
											@endif
											
											<!--<span class="m-form__help">Please enter your full name</span>-->
										</div>
									</div>
									<div class="form-group m-form__group row" style="display:none">
										<label class="col-lg-3 col-form-label">Whatsapp<span class="requiredcls" aria-required="true"> * </span></label>
										<div class="col-lg-6">
											<input type="text" class="form-control " maxlength="30"   name="awhatsapp" id="whatsapp1"  value="7567676767" >
											<span class="error-message whatupa-check" style="display:none"> 
												The field is required.
											</span>
											@if ($errors->has('awhatsapp'))
											<span class="error-message">  
												The field is required.
											</span>
											@endif
											<!--<span class="m-form__help">Please enter your Email name</span>-->
										</div>
									</div>
									<div class="form-group m-form__group row">
										<label class="col-lg-3 col-form-label">Skype<span class="requiredcls" aria-required="true"> * </span></label>
										<div class="col-lg-6">
											<input type="text" class="form-control " maxlength="30"  name="skype" id="skype" <?php if (isset($agency->skype) && !empty($agency->skype)){?> value="{{ $agency->skype }}" <?php }else{ ?>value="{{old('skype')}}"<?php } ?>>
											<span class="error-message skypea-check" style="display:none"> 
												The field is required.
											</span>
											@if ($errors->has('skype'))<span class="error-message">  
												The field is required.
											</span> @endif
											<!--<span class="m-form__help">Please enter your full name</span>-->
										</div>
									</div>
									<div class="form-group m-form__group row">
										<label class="col-lg-3 col-form-label">Website<span class="requiredcls" aria-required="true"> * </span></label>
										<div class="col-lg-6">
											<input type="text" class="form-control " maxlength="30"  name="website" id="website" <?php if (isset($agency->website) && !empty($agency->website)){?> value="{{ $agency->website }}" <?php }else{ ?>value="{{old('website')}}"<?php } ?>>
											<span class="error-message website-check" style="display:none"> 
												The field is required.
											</span>
											@if ($errors->has('website'))<span class="error-message"> 
												The field is required.
											</span>@endif
											<!--<span class="m-form__help">Please enter your Email name</span>-->
										</div>
									</div>
									<div class="form-group m-form__group row">
										<label class="col-lg-3 col-form-label" maxlength="30">Register Number<span class="requiredcls" aria-required="true"> * </span></label>
										<div class="col-lg-6">
											<input type="text" class="form-control m-input required" name="register_number"  id="register_number"  placeholder="" <?php if (isset($agency->rnumber) && !empty($agency->rnumber)){?> value="{{ $agency->rnumber }}" <?php }else{ ?> value="{{old('register_number')}}"<?php } ?> />
											<span class="error-message registarction-check" style="display:none"> 
												The field is required.
											</span>
											@if ($errors->has('website'))<span class="error-message"> 
												The field is required.
											</span>@endif
											<!--<span class="m-form__help">Please enter your full name</span>-->
										</div>
									</div>
									<div class="m-portlet__foot m-portlet__foot--fit">
										<div class="m-form__actions m-login__form-action">
											<div class="row">
												<div class="col-lg-3"></div>
												<div class="col-lg-6 m-login__form-action text-center">
													<?php if (!empty($agency->id)){  ?> 
										     <input type="hidden" name="agency_id" value="{{Crypt::encrypt(base64_encode($agency->id))}}"/>
									             <?php }  ?>
													<button type="submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn m-login__btn--primary update-agency">Submit</button>
													<!--<button type="button" class="btn btn-outline-focus m-btn m-btn--pill m-btn--custom">Back to Login</button>-->
												</div>
											</div>
										</div>
									</div>
									
								</div>
							</form>
							
						</div>
						
						<div class="m-stack__item m-stack__item--center text-center">
							<div class="m-login__account">
								<span class="m-login__account-msg m-login__account-msg-alter">
									Do you have Agency ?
								</span>
								&nbsp;&nbsp;
								<a href="{{ route('login') }}" id="m_login_signup1" class="m-link m-link--focus m-login__account-link m-login__account-msg-alter-color signin-front">
									Sign In
								</a>
								
							</div>
						</div>  
						
						
						
					</div>
					<!--End::Section-->
				</form>
				
				<!--End::Section-->
			</div>
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
</body>
<!-- end::Body -->
</html>

<script>
	$(document).ready(function (){
		$(document).on('change', '#country', function(){
			
               var country = $(this).val();			
			  
			   if(country == 'Pakistan'){
				   
				   $('.citypo').show();
				   $('.cityallo').hide();
				   $('.cityall').removeAttr('id');
				   $(".cityp").attr("id", "city");
				   $(".cityp").attr("name", "city");
				   
			   }else{
				   $('.citypo').hide();
				   $('.cityallo').show();
				   $('.cityp').removeAttr('id');
				   $(".cityall").attr("id", "city");
				   $(".cityp").removeAttr("name", "city");
			   }
			
		});
		
		var con =  $("#password_confirmation").keyup(validate);	

		$(document).on('click', '.create-agency', function(){
			
			var error = 0;
			
			
	//password number validation
	//start
	if($('#password_confirmation').val() == ''){
	//alert(name);
	$('#password_confirmation').focus();
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
	//end
	
	//mobile number validation
	//start
	
	//end
	var emailinvoild =0;
	var conformemailinvoild =0;
	
	//conform email
	
	var sEmail = $('#conformemail').val();
	if($.trim(sEmail).length == 0){
		$('.conformemail-check').show();
		$('.conformemail-involid-check').hide();
		$('#conformemail').focus();
		error=1;
	}
	if($('#conformemail').val() != ''){
		if(validateEmail(sEmail)){
			
			$('.conformemail-check').hide();
			$('.conformemail-involid-check').hide();
			conformemailinvoild =1;
		}else{
			$('.conformemail-check').hide();
			$('.conformemail-involid-check').show();
			$('#conformemail').focus();
			error=1;
		}
	}
	
	//end
	
	
	//email validation
	//start
	var sEmail = $('#email').val();
	if($.trim(sEmail).length == 0){
		$('.email-check').show();
		$('.email-involid-check').hide();
		$('#email').focus();
		error=1;
	}
	if($('#email').val() != ''){
		if(validateEmail(sEmail)){
			
			$('.email-check').hide();
			$('.email-involid-check').hide();
			emailinvoild= 1;
		}else{
			$('.email-check').hide();
			$('.email-involid-check').show();
			$('#email').focus();
			error=1;
		}
	}
	//end
	
	
	if(emailinvoild && conformemailinvoild){ 
	
	
	//alert('hi')
	var sEmail = $('#email').val();
	var conformemail = $('#conformemail').val();
	
	  if (sEmail != conformemail)
           {
           //alert('hi');
		   $('#email').focus();
		   $('.confirm-email-check-match').show();
		   error=1;
           }else{
		    $('.confirm-email-check-match').hide();
		   
		   }
	
	
	}
	
	//name validation
	
	
	if($('#name').val() == ''){
	//alert(name);
	$('#name').focus();
	$('.fullname-check').show();
	error=1;
}else{
	$('.fullname-check').hide();
}

var password = $("#password").val();
var confirmPassword = $("#password_confirmation").val();
if (password != confirmPassword) {
	$('.confirm-password-check-match').show();
	$('.password-check').hide();
	$('.confirm-password-check').hide();
	return false;
}


	//return false;
	if(error == 1){
		return false;
	}else{
		
		$('#signformsubmit').submit();
		
	}
	
});





//manger detail validation


$(document).on('click', '.update-agency', function(){
	
	var error = 0;
	
	
	
	//website validation
	//start
	if($('#register_number').val() == ''){
	//alert(name);
	$('#register_number').focus();
	$('.registarction-check').show();
	error=1;
}else{
	$('.registarction-check').hide();
}


	//website validation
	//start
	if($('#website').val() == ''){
	//alert(name);
	$('#website').focus();
	$('.website-check').show();
	error=1;
}else{
	$('.website-check').hide();
}

	//skype  validation
	//start
	if($('#skype').val() == ''){
	//alert(name);
	$('#skype').focus();
	$('.skypea-check').show();
	error=1;
}else{
	$('.skypea-check').hide();
}
	//end
	
	//end
	
	//whatsapp number validation
	//start
	if($('#whatsapp1').val() == ''){
	//alert(name);
	$('#whatsapp1').focus();
	$('.whatupa-check').show();
	error=1;
}else{
	$('.whatupa-check').hide();
}
	//end
	
	
	//phone number validation
	//start
	if($('#phone1').val() == ''){
	//alert(name);
	$('#phone1').focus();
	$('.phonea-check').show();
	error=1;
}else{
	$('.phonea-check').hide();
}
	//end
	//zip validation
	//start
	if($('#zip').val() == ''){
	//alert(name);
	$('#zip').focus();
	$('.zip-check').show();
	error=1;
}else{
	$('.zip-check').hide();
}
	//end
	
	//city validation
	//start
	if($('#city').val() == ''){
	//alert(name);
	$('#city').focus();
	$('.citya-check').show();
	error=1;
}else{
	$('.citya-check').hide();
}
	//end
	
	//country validation
	//start
	if($('#country').val() == ''){
	//alert(name);
	$('#country').focus();
	$('.countrya-check').show();
	error=1;
}else{
	$('.countrya-check').hide();
}
	//end
	
	//address validation
	//start
	if($('#address1').val() == ''){
	//alert(name);
	$('#address1').focus();
	$('.addressa-check').show();
	error=1;
}else{
	$('.addressa-check').hide();
}
	//end
	
	
	
		var emailinvoild =0;
	   var conformemailinvoild =0;
	
	//email validation
	//start
	var sEmail = $('#conformemail1').val();
	if($.trim(sEmail).length == 0){
		$('.conformemail1-check').show();
		$('.conformemail1-involid-check').hide();
		$('#conformemail1').focus();
		error=1;
	}
	if($('#conformemail1').val() != ''){
		if(validateEmail(sEmail)){
			
			$('.conformemail1-check').hide();
			$('.conformemail1-involid-check').hide();
			conformemailinvoild =1;
		}else{
			$('.conformemail1-check').hide();
			$('.conformemail1-involid-check').show();
			
			$('#conformemail1').focus();
			error=1;
		}
	}
	//end
	
	//email validation
	//start
	var sEmail = $('#aemail').val();
	if($.trim(sEmail).length == 0){
		$('.emaila-check').show();
		$('.emaila-involid-check').hide();
		
		$('#aemail').focus();
		error=1;
	}
	if($('#aemail').val() != ''){
		if(validateEmail(sEmail)){
			
			$('.emaila-check').hide();
			$('.emaila-involid-check').hide();
			emailinvoild=1;
		}else{
			$('.emaila-check').hide();
			$('.emaila-involid-check').show();
			
			$('#aemail').focus();
			error=1;
		}
	}
	//end
	//alert(emailinvoild);
	//alert(conformemailinvoild);
	
	if(emailinvoild && conformemailinvoild){ 
	
	
	//alert('hi');
	var sEmail = $('#aemail').val();
	var conformemail = $('#conformemail1').val();
	
	  if (sEmail != conformemail)
           {
           //alert('hi');
		   $('#aemail').focus();
		   $('.aconfirm-email-check-match').show();
		   error=1;
           }else{
		    $('.aconfirm-email-check-match').hide();
		   
		   }
	
	
	}
	//name validation
	
	
	if($('#aname').val() == ''){
	//alert(name);
	$('#aname').focus();
	$('.agencya-check').show();
	error=1;
}else{
	$('.agencya-check').hide();
}

if(error == 1){
	return false;
}else{
	
	$('#agency_info').submit();
	
}

});


//password confirm check
/*$("#password_confirmation").keypress(function (e) {
 var password = $("#password").val();
 var password_length = $("#password").val().length;
 var confirmPassword_length = $("#password_confirmation").val();
 var confirmPassword_length = $("#password_confirmation").val().length;
 console.log(password_length);
         if(confirmPassword_length) {
            var confirmPassword = $("#password_confirmation").val();
            if (password != confirmPassword) {
                $('.confirm-password-check-match').show();
				$('.password-check').hide();
				$('.confirm-password-check').hide();
               // return false;
            }
		 }else{
		 
		  $('.confirm-password-check-match').hide();
		 }
			
		});*/


		
		
//jquery for tab active conditions
$(".createagency").addClass("active");
$(".agencyinformation").removeClass("active")		

$('.managerdetails').click(function()
{
	$(".createagency").addClass("active");
	$(".createagency").addClass("show");
	$(".agencyinformation").removeClass("active");
	$(".agencyinformation").removeClass("show");
	$(".agencyinfo").removeClass("active");
	$(".agencyinfo").removeClass("show");
	$(".managerdetails").addClass("active");
	$(".managerdetails").addClass("show")
});
	//jquery for tab active conditions
	<?php if(isset($_GET['tab'])) { ?>

		$(".createagency").removeClass("active");
		$(".agencyinformation").addClass("active")	
	<?php } ?>
	<?php if(isset($_GET['id'])) { ?>
	//jquery for tab active conditions
	$('.agencyinfo').click(function()
	{
		$(".agencyinfo").addClass("active");
		$(".agencyinfo").addClass("show");
		$(".createagency").removeClass("active");
		$(".createagency").removeClass("show");
		$(".managerdetails").removeClass("active");
		$(".managerdetails").removeClass("show");
		$(".agencyinformation").addClass("active")
		$(".agencyinformation").addClass("show")
	});
<?php } ?>
		//phone number validation
		$("#phone").keypress(function (e) {

			if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) 
			{
				$("#errmsg").html("Digits Only").show().fadeOut(5000);
				
				return false;
			}
			else
			{
				$(this).css({"border-color": "#ebedf2","color":"#575962"});
			}
		});
		
	 //mobile number validation
	 $("#mobile").keypress(function (e) {

	 	if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) 
	 	{
	 		$("#errmsg").html("Digits Only").show().fadeOut(5000);
	 		
	 		return false;
	 	}
	 	else
	 	{
	 		$(this).css({"border-color": "#ebedf2","color":"#575962"});
	 	}
	 });
	 //whatup validation
	 
	 $("#whatsapp").keypress(function (e) {

	 	if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) 
	 	{
	 		$("#errmsg").html("Digits Only").show().fadeOut(5000);
	 		
	 		return false;
	 	}
	 	else
	 	{
	 		$(this).css({"border-color": "#ebedf2","color":"#575962"});
	 	}
	 });
	 
	 
	 
	 
	 
	 
	 $("#mobile1").keypress(function (e) {

	 	if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) 
	 	{
	 		$("#errmsg").html("Digits Only").show().fadeOut(5000);
	 		
	 		return false;
	 	}
	 	else
	 	{
	 		$(this).css({"border-color": "#ebedf2","color":"#575962"});
	 	}
	 });
	 
	 $("#phone1").keypress(function (e) {

	 	if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) 
	 	{
	 		$("#errmsg").html("Digits Only").show().fadeOut(5000);
	 		
	 		return false;
	 	}
	 	else
	 	{
	 		$(this).css({"border-color": "#ebedf2","color":"#575962"});
	 	}
	 });
	 
	 
	 $("#whatsapp1").keypress(function (e) {

	 	if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) 
	 	{
	 		$("#errmsg").html("Digits Only").show().fadeOut(5000);
	 		
	 		return false;
	 	}
	 	else
	 	{
	 		$(this).css({"border-color": "#ebedf2","color":"#575962"});
	 	}
	 });

	 $("#createagency").click(function (e) {
	 	var password = $("#password").val();
	 	var confirmPassword = $("#password_confirmation").val();
	 	if (password != confirmPassword) {
	 		$("#name_err").html("Password Mismatch").show();
	 		$(".required").css({"border-style": "solid","border-color" :"red","border-width":"1px"});
	 		return false;
	 	}
	 	
	 });
	 
	 $("#aemail").keypress(function (email) {
	 	
	 	$('#aemail').filter(function(){
	 		var emil=$('#aemail').val();
	 		var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
	 		if( !emailReg.test( emil ) ) {
	 			$("#errmsg").html("validemail Only").show().fadeOut(5000);
	 		} else {
	 			$(this).css({"border-color": "#ebedf2","color":"#575962"});
	 		}
	 	})
	 });
	 
	 var counter = 0;
	 $(".required").each(function() {
	 	if ($(this).val() === "") {
	 		e.preventDefault();
	 		$(this).css('border','1px solid #ff1400');
	 		counter++;
	 	}else { $(this).css('border','2px solid #dadde2'); }
	 }); 
	 
//form validation 

//start









});



function validate() {
	var password1 = $("#password").val();
	var password1_length = $("#password").val().length;
	var password2 = $("#password_confirmation").val();
	var password2_length = $("#password_confirmation").val().length;
	
	$('.password-check').hide();
	$('.confirm-password-check').hide();

	if(password1 == password2) {
		$(".confirm-password-check-match").hide();
		
	}
	else {
		if(password2_length>=password1_length){
			
			$(".confirm-password-check-match").show();
		}else{
			
			$(".confirm-password-check-match").hide();
		}
		
	}
	
	
}

//email validation function
//start
function validateEmail(sEmail) {
	var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
	if (filter.test(sEmail)) {
		return true;
	}
	else {
		
		return false;
	}
}

//end


</script>

  <script language="javascript">
/*document.onmousedown=disableclick;
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

$(document).bind("contextmenu",function(e) {
 e.preventDefault();
});*/
</script>

