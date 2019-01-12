@extends('layouts.app')

@section('content')
<?php 
$route = 'agency.agencystore';
if (isset($agency) && !empty($agency)){
$route = 'agency.agencyupdate';
}
//active tab
$activetab = 'active show';

$activecon = 'active';

$activecon2 = '';

$activetab2 = '';

$secTab = '';
$actuvemode = '';
if(isset($_GET['id']) && !empty($_GET['id'])){
	$secTab = ''; 
	if(isset($_GET['tab']) && !empty($_GET['tab'])){
	
		if($_GET['tab'] == 1){
			$activetab = 'active show';
			$activecon = 'active';
		}
		if($_GET['tab'] == 2){
			$activetab= '';
			$activecon = '';
			$activecon2 = 'active';
			$activetab2 = 'active show';
			$actuvemode = 'display:none;';
			
		}
	}

}


?>



	<!-- END: Left Aside -->
	
					<!-- BEGIN: Subheader -->
					
					<!-- END: Subheader -->
					<div class="m-content">
						<!--Begin::Section-->
                        <?php if(isset($_GET['id'])) { $tab_id  = '?id='.$_GET['id']; } else{ $tab_id  = ''; } ?>
                        <div class="tabfn m-portlet m-portlet-padding">
						<div class="row">
							<ul class="nav nav-tabs  m-tabs-line m-tabs-line--primary somehti" role="tablist">
											<li class="nav-item m-tabs__item">
												<a class="nav-link m-tabs__link managerdetails {{$activetab}}" data-url="<?php echo URL::to("/agency".$tab_id);?>&tab=1" data-toggle="tab" href="#m_tabs_6_1" role="tab" aria-selected="false">
                                                    Manager Details
												</a>
											</li>
									
											<li class="nav-item m-tabs__item">
												<a class="nav-link m-tabs__link agencyinfo {{$activetab2}}" data-url="<?php echo URL::to("/agency".$tab_id);?>&tab=2"  data-toggle="tab" href="#m_tabs_6_3" role="tab" aria-selected="true" <?php  echo $secTab;?> >
													Agency Information
												</a>
											</li>
                                            
										</ul>
						</div>
                        <div class="tab-content">
										<div class="tab-pane managerdetailstab {{$activecon}}" id="m_tabs_6_1" role="tabpanel">
								<form action="{{ route($route) }}" class="m-form infoagen" method="post" id="signformsubmit" style="{{$actuvemode}}">
                                    
                                  <input type="hidden" name="_token" value="<?php echo @csrf_token(); ?>">
                                  
							<div class=" agency-info-tab {{$activecon}}" >
                            
                            
                             <div class="form-group m-form__group row">
						                      <label class="col-lg-2 col-form-label">Full Name<span class="requiredcls" aria-required="true"> * </span></label>
						                      <div class="col-lg-5">
							                  <input type="text" name="name" class="form-control m-input verfycontent"  placeholder="" <?php if (isset($agency->name) && !empty($agency->name)){?> value="{{ $agency->name }}" <?php }else{ ?>value="{{old('name')}}"<?php } ?> id="name" maxlength="30">
                                              
                                              <span class="error-message fullname-check" style="display:none">
													The field is required.
												 </span>
                                              
                                              
                                              @if ($errors->has('name'))
                   	                          <span class="error-message">   
                       	                      {{ $errors->first('name') }}
                                                   </span>
                                                   @endif 
							                                  <!--<span class="m-form__help">Please enter your full name</span>-->
						                        </div>
					           </div>
                               
                               
                               
                               
                              
                               
                               
                             <div class="form-group m-form__group row">
						                      <label class="col-lg-2 col-form-label">Email<span class="requiredcls" aria-required="true"> * </span></label>
						                       <div class="col-lg-5">
							                   <input type="text" name="email" id="email" class="form-control m-input verfycontent" maxlength="30"   placeholder="" <?php if (isset($agency->email) && !empty($agency->email)){?> value="{{ $agency->email }}" <?php }else{ ?>value="{{old('email')}}"<?php } ?> >
                                               <span class="error-message confirm-email-check-match" style="display:none">
													Email do not match.
												</span>
                                                <span class="error-message email-check" style="display:none">
												 The field is required.
												 </span>
                                                    <span class="error-message email-involid-check" style="display:none">
														The Email is not vaild.
													</span>
                                               
                    	                      <span class="error-message alreadyemail" style="display:none">  
                       						 
                       							  </span>
                                                  
							                                  <!--<span class="m-form__help">Please enter your full name</span>-->
						                         </div>
					           </div>
                               
                               <div class="form-group m-form__group row">
						                      <label class="col-lg-2 col-form-label">Confirm Email<span class="requiredcls" aria-required="true"> * </span></label>
						                       <div class="col-lg-5">
											<input type="email" name="conformemail" id="conformemail" class="form-control verfycontent" maxlength="30"  aria-describedby="emailHelp" <?php if (isset($agency->email) && !empty($agency->email)){?> value="{{ $agency->email }}" <?php }else{ ?>value="{{old('email')}}"<?php } ?>>
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
										<label class="col-lg-2 col-form-label">Phone<span class="requiredcls" aria-required="true"> </span></label>
										<div class="col-lg-5">
											<input type="text" class="form-control "  maxlength="30" name="mphone"     <?php if (isset($agency->phone) && !empty($agency->phone)){?> value="{{ $agency->phone }}" <?php }else{ ?>value="{{old('mphone')}}"<?php } ?> >
											<span class="error-message phonea-checkm" style="display:none"> 
												The field is required.
											</span>
											@if ($errors->has('mphone'))
											<span class="error-message">  
												The field is required.
											</span>
											@endif
											
											<!--<span class="m-form__help">Please enter your full name</span>-->
										</div>
									</div>
                           
                                    <div class="form-group m-form__group row">
						                      <label class="col-lg-2 col-form-label">Mobile<span class="requiredcls" aria-required="true"> * </span></label>
						                       <div class="col-lg-5">
							                <input type="text" class="form-control m-input" name="amobile" id="mobile1" maxlength="30"  placeholder="" <?php if (isset($agency->mobile) && !empty($agency->mobile)){?> value="{{ $agency->mobile }}" <?php }else{ ?>value="{{old('amobile')}}"<?php } ?>>
                                            <span class="error-message mobilea-check" style="display:none"> 
                       						                         The field is required.
                       							                     </span>
                              @if ($errors->has('amobile'))
                              <span class="error-message"> 
                       						  {{ $errors->first('amobile') }}
                       							 </span>@endif 
							                                  <!--<span class="m-form__help">Please enter your full name</span>-->
						                         </div>
					                     </div> 
                                           <div class="form-group m-form__group row">
						                      <label class="col-lg-2 col-form-label">Whatsapp<span class="requiredcls" aria-required="true"> * </span></label>
						                       <div class="col-lg-5">
							                <input type="text" class="form-control m-input"   name="awhatsapp" maxlength="30" id="whatsapp1" placeholder="" <?php if (isset($agency->whatapp) && !empty($agency->whatapp)){?> value="{{ $agency->whatapp }}" <?php }else{ ?>value="{{old('awhatsapp')}}"<?php } ?>>
                                            
                                            <span class="error-message whatupa-check" style="display:none"> 
                       						                         The field is required.
                       							                     </span>
                                  @if ($errors->has('awhatsapp'))
                                  <span class="error-message"> 
                       						  {{ $errors->first('awhatsapp') }}
                       							 </span>@endif 
							                                  <!--<span class="m-form__help">Please enter your full name</span>-->
						                         </div>
					                     </div> 
                                         
                                          <div class="form-group m-form__group row">
						                      <label class="col-lg-2 col-form-label">Skype<span class="requiredcls" aria-required="true">  </span></label>
						                       <div class="col-lg-5">
							            <input type="text" class="form-control m-input required"  name="skype" maxlength="30" id="skype" placeholder="" <?php if (isset($agency->	mskype) && !empty($agency->	mskype)){?> value="{{ $agency->	mskype }}" <?php }else{ ?>value="{{old('skype')}}"<?php } ?>>
                                        <span class="error-message skypea-check" style="display:none"> 
                       						                         The field is required.
                       							                     </span>
                               @if ($errors->has('skype'))
                               <span class="error-message"> 
                       						  {{ $errors->first('skype') }}
                       							 </span>@endif 
							                                  <!--<span class="m-form__help">Please enter your full name</span>-->
						                         </div>
					                     </div> 
                                    
												

                                <div class="form-group m-form__group row">
						                      <label class="col-lg-2 col-form-label">User Id</label>
						                       <div class="col-lg-5">
							                <input type="text" name="userid" tabindex="-1" class="form-control m-input" readonly  placeholder="AUTO" <?php if (isset($agency->userid) && !empty($agency->userid)){?> value="{{ $agency->userid }}" <?php }else{ ?>value="{{old('userid')}}"<?php } ?>>
							                                  <!--<span class="m-form__help">Please enter your full name</span>-->
						                        </div>
					           </div>          	
												  
												  
                                  <?php if (empty($agency->loginid)){ ?>  
                                  
                                  
                                    <div class="form-group m-form__group row">
						                      <label class="col-lg-2 col-form-label">password<span class="requiredcls" aria-required="true"> * </span></label>
						                       <div class="col-lg-5">
							                <input type="password" name="password" class="form-control m-input verfycontent" placeholder="" id="password" maxlength="30" >
                                            <span class="error-message password-check" style="display:none">
																			  The field is required.
																			    </span>
                                            @if ($errors->has('password'))
                    			<span class="error-message"> 
                       						  {{ $errors->first('password') }}
                       							 </span>
                                                  @endif
							                                  <!--<span class="m-form__help">Please enter your full name</span>-->
						                         </div>
					           </div>   
                               
                               
                                <div class="form-group m-form__group row">
						                      <label class="col-lg-2 col-form-label">Confirm Password<span class="requiredcls" aria-required="true"> * </span></label>
						                       <div class="col-lg-5">
							                <input type="password" name="password_confirmation" class="form-control m-input verfycontent"  placeholder="" id="password_confirmation" maxlength="30">
                                            
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
                                               
                                               
                                               <?php if (!empty($agency->loginid)){  ?>
                                               
                                               <div class="form-group m-form__group row">
														 <label class="col-lg-2 col-form-label"></label>
                                                             <div class="col-lg-5">
															    <label class="m-checkbox">
																<input type="checkbox" name="ispassword" class="ispassword"  {{ old('ispassword') ? 'checked' : '' }} > Do You Change Password 
																<span></span>
																</label>
															</div>	
															
												   </div>
                                                   <div class="checkispassword" <?php if(old('ispassword')){  ?> <?php }else{ ?>style="display:none" <?php } ?>>
                                                    <div class="form-group m-form__group row">
						                         <label class="col-lg-2 col-form-label">password<span class="requiredcls" aria-required="true"> * </span></label>
						                       <div class="col-lg-5">
							                 <input type="password" name="password" class="form-control m-input passwordContent" placeholder="" id="password_is"  maxlength="30">
                                            <span class="error-message password-check-is" style="display:none">
																			  The field is required.
																			    </span>
                                            @if ($errors->has('password'))
                    			<span class="error-message"> 
                       						  {{ $errors->first('password') }}
                       							 </span>
							                              
                                                           @endif    <!--<span class="m-form__help">Please enter your full name</span>-->
						                         </div>
					           </div>   
                               
                               
                                <div class="form-group m-form__group row">
						                      <label class="col-lg-2 col-form-label">Confirm Password<span class="requiredcls" aria-required="true"> * </span></label>
						                       <div class="col-lg-5">
							                <input type="password" name="password_confirmation" class="form-control m-input passwordContent"  placeholder="" id="password_confirmation_is" maxlength="30">
                                            
                                            <span class="error-message confirm-password-check_is" style="display:none">
																			  The field is required.
																			    </span>
                                                                                <span class="error-message confirm-password-check-match" style="display:none">
																			  Password do not match.
																			    </span>
							                                  <!--<span class="m-form__help">Please enter your full name</span>-->
						                        </div>
					           </div>
                                                   </div>
                                               <?php }?>
                                             <?php if($type == 'UserInfo' || Auth::user()->user_type == 'SuperAdmin' ) {
												 if(isset($agency) && !empty($agency)) {
												 if($agency->parentagencyid != 0){ 
											 
											//echo $agency->parentagencyid;
											 ?>
                                             <input type="hidden" name="userrolecheck" value="{{Crypt::encrypt(base64_encode(1))}}"/>
                                               <div class="form-group m-form__group row">
														 <label class="col-lg-2 col-form-label"></label>
                                                             <div class="col-lg-5">
															    <label class="m-checkbox">
										<input type="checkbox" name="isagency" class="isagency"  <?php if(isset($agency) && !empty($agency)) { if (isset($agency->parentagencyid) && !empty($agency->parentagencyid)){?> checked="checked" <?php }}else{ ?> {{ old('isagency') ? 'checked' : '' }} <?php } ?>> Is this sub agency 
																<span></span>
																</label>
															</div>	
															
												   </div>
                                                   
                                                  
                                                   <div class="checkisagency" <?php if(isset($agency) && !empty($agency)) { if($agency->parentagencyid !=0){?> style="display:block;" <?php } }else if(old('isagency')){  ?> style="display:block;" <?php }else{ ?> style="display:none;" <?php } ?>  style="display:none">
														
															<div class="form-group m-form__group row">
                                                             <label class="col-lg-2 col-form-label">Agency<span class="requiredcls" aria-required="true"> * </span></label>
                                                              <div class="col-lg-5">
														<select name="agencylevel" class="form-control agencylevel">
                                                       <option value=""> -- Select Name -- </option>
                                                      @foreach($AgencyDetails as  $level)
                                                         <?php if(isset($level->aname)) { ?>
                                                        <option value="{{ $level->id }}" <?php if(isset($agency) && !empty($agency)) { if ($agency->parentagencyid == $level->id){?> {{'selected'}}<?php } }else if(old('agencylevel') == $level->id){ ?>{{'selected'}}<?php } ?>>{{ $level->aname }}</option>
                                                         <?php } ?>
                                                         @endforeach
                                                        </select>
                                                        <span class="error-message agencylevel-check" style="display:none">
																			  The field is required.
																			    </span>
                                                        @if ($errors->has('agencylevel'))
																<span class="error-message"> 
                                                
                       						  {{ $errors->first('agencylevel') }}
                       							  </span>
                                                  @endif
															</div>
                                                            </div>
														
												   </div>
                                                   
                                                   
                                                   
                                                   <?php  }}} ?>
                                                  
												   <div class="m-portlet__foot m-portlet__foot--fit">
												 <div class="m-form__actions m-form__actions">
												    <div class="row">
													    <div class="col-lg-2">
														</div>
														<div class="col-lg-5">
                                                        <?php if(isset($CAgencyDetails) && !empty($CAgencyDetails)){ ?>
                                                        <input type="hidden" name="parentid" value="{{Crypt::encrypt(base64_encode($CAgencyDetails->id))}}"/>
                                                        
                                                        <?php } ?>
                                                             <?php if (!empty($agency->loginid)){  ?> 
															 <input type="hidden" name="loginid" value="{{Crypt::encrypt(base64_encode($agency->loginid))}}"/>
                                                             <input type="hidden" name="agencyid" value="{{Crypt::encrypt(base64_encode($agency->id))}}"/>
															 <button type="submit" name="create_agencyy" class="btn btn-primary update-manager-info">Update Agency</button>
															 <?php }else{  ?>
															<button type="submit" name="create_agencyy" class="btn btn-primary create-agency">Create Agency</button>
                                                            <?php } ?>
                                                            
														</div>
													</div>
													</div>
												
											</div>
											</div>
                                            </form>
                                            <input type="hidden" id="verfytext" value="" />
                                            </div>
                                            
                                            <!------- create agency---------->
								<div class="tab-pane agencyinformation {{$activecon2}}"  id="m_tabs_6_3" role="tabpanel">
												<div class="">
                                 		<form action="{{ route('agency.agencymanager') }}" class="m-form" method="POST" id="agency_info">
                                         <input type="hidden" name="_token" value="<?php echo @csrf_token(); ?>">
                                         <?php if (!empty($agency->loginid)){  ?> 
                                                <input type="hidden" name="agency_id" value="{{Crypt::encrypt(base64_encode($agency->id))}}"/>
										<?php }else{ ?>
										
										<input type="hidden" name="agency_id" id="agencyidinser" value=""/>
										      <?php  }?>
                                        
                                         <div class="form-group m-form__group row">
						                      <label class="col-lg-2 col-form-label">Agency Name<span class="requiredcls" aria-required="true"> * </span></label>
						                       <div class="col-lg-5">
							                 <input type="text" class="form-control m-input"  name="aname" id="aname"  placeholder=""<?php if (isset($agency->aname) && !empty($agency->aname)){?> value="{{ $agency->aname }}" <?php }else{ ?>value="{{old('aname')}}"<?php } ?> maxlength="30">
                                             <span class="error-message agencya-check" style="display:none"> 
                       						                         The field is required.
                       							                     </span>
                             @if ($errors->has('aname'))
                             <span class="error-message"> 
                       						  {{ $errors->first('aname') }}
                                              </span>
                       							 @endif 
							                                  <!--<span class="m-form__help">Please enter your full name</span>-->
						                         </div>
					                     </div>  
												
                                          <div class="form-group m-form__group row">
						                      <label class="col-lg-2 col-form-label">Email<span class="requiredcls" aria-required="true"> * </span></label>
						                       <div class="col-lg-5">
							                <input type="email" class="form-control m-input" name="aemail" id="aemail" maxlength="40" aria-describedby="emailHelp" placeholder="" <?php if (isset($agency->aemail) && !empty($agency->aemail)){?> value="{{ $agency->aemail }}" <?php }else{ ?>value="{{old('aemail')}}"<?php } ?>>
                                                <span class="error-message confirm1-email-check-match" style="display:none">
													Email do not match.
												</span>
                                                <span class="error-message emaila-check" style="display:none"> 
                       						                         The field is required.
                       							                     </span>
                                                                     <span class="error-message emaila-involid-check" style="display:none"> 
                       						                         The Email is not vaild.
                       							                     </span>
                      @if ($errors->has('aemail')) <span class="error-message">
                       						  {{ $errors->first('aemail') }}
                       							</span> @endif 
							                                  <!--<span class="m-form__help">Please enter your full name</span>-->
						                         </div>
					                     </div> 
                                         
                                         
                                         <div class="form-group m-form__group row">
						                      <label class="col-lg-2 col-form-label">Confirm Email<span class="requiredcls" aria-required="true"> * </span></label>
						                       <div class="col-lg-5">
											<input type="email" name="conformemail1" id="conformemail1" class="form-control " maxlength="30"  aria-describedby="emailHelp" <?php if (isset($agency->aemail) && !empty($agency->aemail)){?> value="{{ $agency->aemail }}" <?php }else{ ?>value="{{old('aemail')}}"<?php } ?>>
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
						                      <label class="col-lg-2 col-form-label">Address Line 1<span class="requiredcls" aria-required="true"> * </span></label>
						                       <div class="col-lg-5">
                                               <textarea class="form-control m-input"  name="address1"  id="address1" style="height: 90px;"><?php if (isset($agency->address1) && !empty($agency->address1)){ echo $agency->address1; } ?></textarea>
       
                                             <span class="error-message addressa-check" style="display:none"> 
                       						                         The field is required.
                       							                     </span>
                               @if ($errors->has('address1'))
                               <span class="error-message"> 
                       						  {{ $errors->first('address1') }}
                       							 </span>@endif 
							                                  <!--<span class="m-form__help">Please enter your full name</span>-->
						                         </div>
					                     </div>  
												
                                          <div class="form-group m-form__group row">
						                      <label class="col-lg-2 col-form-label">Address Line 2</label>
						                       <div class="col-lg-5">
                                               
                                               <textarea class="form-control m-input" name="address2" id="address2" style="height: 90px;"><?php if (isset($agency->address2) && !empty($agency->address2)){ echo $agency->address2; } ?></textarea>
                                               
							                                  <!--<span class="m-form__help">Please enter your full name</span>-->
						                         </div>
					                     </div>   
                                         
                                         <div class="form-group m-form__group row">
						                      <label class="col-lg-2 col-form-label">Country<span class="requiredcls" aria-required="true"> * </span></label>
						                       <div class="col-lg-5">
							            
                                            <select name="country" class="form-control countrya" id="country">
                                                       <option value=""> -- Select Contry Name -- </option>
                                                      @foreach($CountryName as  $level)
                                                        <option value="{{ $level}}" <?php if(isset($agency) && !empty($agency)) { if ($agency->country == $level ){ ?> {{'selected'}}<?php } }else if(old('country') == $level){ ?>{{'selected'}}<?php } ?>>{{ $level }}</option>
                                                         @endforeach
                                                        </select>
                                            
                                            <span class="error-message countrya-check" style="display:none"> 
                       						                         The field is required.
                       							                     </span>
                               @if ($errors->has('country'))
                               <span class="error-message"> 
                       						  {{ $errors->first('country') }}
                       							 </span>@endif 
							                                  <!--<span class="m-form__help">Please enter your full name</span>-->
						                         </div>
					                     </div> 
                                         
                                         
                                           <div class="form-group m-form__group row cityallo" <?php if(isset($agency) && !empty($agency)) { if($agency->country == 'Pakistan') { ?> style="display:none"; <?php } } ?>>
						                      <label class="col-lg-2 col-form-label">City<span class="requiredcls" aria-required="true"> * </span></label>
						                       <div class="col-lg-5">
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
						                      <label class="col-lg-2 col-form-label">City<span class="requiredcls" aria-required="true"> * </span></label>
						                       <div class="col-lg-5">
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
						                      <label class="col-lg-2 col-form-label">Zip / Postal Code<span class="requiredcls" aria-required="true"> * </span></label>
						                       <div class="col-lg-5">
							               	<input type="text" class="form-control m-input"  name="zip" id="zip" placeholder=""  maxlength="30" <?php if (isset($agency->pcode) && !empty($agency->pcode)){?> value="{{ $agency->pcode }}" <?php }else{ ?>value="{{old('zip')}}"<?php } ?>>
                                            <span class="error-message zip-check" style="display:none"> 
                       						                         The field is required.
                       							                     </span>
                               @if ($errors->has('zip'))
                               <span class="error-message"> 
                       						  {{ $errors->first('zip') }}
                       							 </span>@endif 
							                                  <!--<span class="m-form__help">Please enter your full name</span>-->
						                         </div>
					                     </div> 
                                         
                                         
                                            <div class="form-group m-form__group row">
						                      <label class="col-lg-2 col-form-label">Phone<span class="requiredcls" aria-required="true">  </span></label>
						                       <div class="col-lg-5">
							              <input type="text" class="form-control m-input"  name="aphone" id="phone1" maxlength="30"  placeholder="" <?php if (isset($agency->aphone) && !empty($agency->aphone)){?> value="{{ $agency->aphone }}" <?php }else{ ?>value="{{old('aphone')}}"<?php } ?>>
                                          <span class="error-message phonea-check" style="display:none"> 
                       						                         The field is required.
                       							                     </span>
                                @if ($errors->has('aphone'))
                                <span class="error-message"> 
                       						  {{ $errors->first('aphone') }}
                       							 </span>@endif 
							                                  <!--<span class="m-form__help">Please enter your full name</span>-->
						                         </div>
					                     </div> 
                                         
                                         
                                            
                                         
                                           
                                         
                                         
                                           <div class="form-group m-form__group row">
						                      <label class="col-lg-2 col-form-label">Website<span class="requiredcls" aria-required="true">  </span></label>
						                       <div class="col-lg-5">
							                <input type="text" class="form-control m-input"  name="website" placeholder=""<?php if (isset($agency->website) && !empty($agency->website)){?> value="{{ $agency->website }}" <?php }else{ ?>value="{{old('website')}}"<?php } ?> maxlength="50">
                                                                                                              <span class="error-message website-check" style="display:none"> 
                       						                         The field is required.
                       							                     </span>

                                 @if ($errors->has('website'))
                                 <span class="error-message"> 
                       						  {{ $errors->first('website') }}
                       							 </span>@endif 
							                                  <!--<span class="m-form__help">Please enter your full name</span>-->
						                         </div>
					                     </div> 
                                         
                                           <div class="form-group m-form__group row">
						                      <label class="col-lg-2 col-form-label">Register / IATA No<span class="requiredcls" aria-required="true"> * </span></label>
						                       <div class="col-lg-5">
							               <input type="text" class="form-control m-input required" name="register_number"  id="register_number"  placeholder="" <?php if (isset($agency->rnumber) && !empty($agency->rnumber)){?> value="{{ $agency->rnumber }}" <?php }else{ ?>value="{{old('register_number')}}"<?php } ?> maxlength="30">
                                           
                                           <span class="error-message registarction-check" style="display:none"> 
                       						                         The field is required.
                       							                     </span>
                                @if ($errors->has('register_number')) <span class="error-message"> 
                       						  {{ $errors->first('register_number') }}
                       							 </span>@endif 
							                                  <!--<span class="m-form__help">Please enter your full name</span>-->
						                         </div>
					                     </div>                              
												  
												 
												 
												  
												 
												<div class="m-portlet__foot m-portlet__foot--fit">
												 <div class="m-form__actions m-form__actions">
												    <div class="row">
													   <div class="col-lg-2">
													   </div>
														<div class="col-lg-5">
                                                        <span class="error-message verfycontenterror" style="display:none"> 
                                                        Please fill your manager details
                       				
                                        		                     </span>
                                 
                                            
                                     
                                     <input type="hidden" value="<?php if (!empty($agency->loginid)){ echo '345'; } ?>" id="updateagencyinformation"/>
                                                                     
									<button type="submit" class="btn btn-primary update-agency">Update Agency Info</button>
									
														</div>
													</div>
													</div>
											</div>
                                            </form>
											</div>
							</div>
						<!--End::Section-->

						
						<!--End::Section-->
					</div>
                    </div>
				</div>
              <?php if(isset($_GET['datas'])) {?>
                	<div class="modal fade show modelshow" id="m_modal_6" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" style="display: block; padding-right: 17px;">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
    <!--  <div class="modal-header">
     <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>-->
      <div class="modal-body">
        The Agency information has been updated successfully.
      </div>
      <div class="modal-close-btn">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="closeurl">×</span>
        </button>
        </div>
     <div class="modal-footer">
        <!--<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>-->
        <button type="button" class="btn btn-primary closeurl">Ok</button>
      </div>
    </div>
  </div>
</div>
<?php } ?>




 <?php if(isset($_GET['datasm'])) {?>
                	<div class="modal fade show modelshow" id="m_modal_6" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" style="display: block; padding-right: 17px;">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
    <!--  <div class="modal-header">
     <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>-->
      <div class="modal-body">
        The Manager detail has been updated successfully.
      </div>
      <div class="modal-close-btn">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="closeurl">×</span>
        </button>
        </div>
     <div class="modal-footer">
        <!--<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>-->
        <button type="button" class="btn btn-primary closeurl">Ok</button>
      </div>
    </div>
  </div>
</div>
<?php } ?>



<?php if(isset($_GET['datas1a'])) {?>
                	<div class="modal fade show modelshow" id="m_modal_6" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" style="display: block; padding-right: 17px;">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
    <!--  <div class="modal-header">
     <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>-->
      <div class="modal-body">
        The Agency information added successfully.
      </div>
      <div class="modal-close-btn">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="closeurl">×</span>
        </button>
        </div>
     <div class="modal-footer">
        <!--<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>-->
        <button type="button" class="btn btn-primary closeurl">Ok</button>
      </div>
    </div>
  </div>
</div>
<?php } ?> 

                
                
		
			<!-- end:: Body -->
            <!-- begin::Footer -->
								 <?php if(isset($_GET['id']) && !empty($_GET['id'])){?> 
                                       <?php $tab = ''; if(isset($_GET['tab']) && !empty($_GET['tab'])){ $tab = $_GET['tab']; }?>    
                                <input type="hidden" id="homeurl" value="<?php echo URL::to("/agency?id=".$_GET['id']);?>&tab=<?php echo $tab;?>"/>
                                <?php }else{ ?>
                                <input type="hidden" id="homeurl" value="<?php echo URL::to("/agency");?>"/>
                                <?php } ?>
@endsection
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
$(document).ready(function (){
	var agencyInsertAjax = "{{ URL::to('agencyInsertAjax')}}";
	var agencyInsertAjaxValidate = "{{ URL::to('agencyInsertAjaxValidate')}}";
	
	//
	
	$(document).on('change', '.countrya', function(){
			
               var country = $(this).val();			
			  
			   if(country == 'Pakistan'){
				   
				   $('.citypo').show();
				   $('.cityallo').hide();
				   $('.cityall').removeAttr('id');
				   $(".cityp").attr("id", "city");
				   $(".cityp").attr("name", "city");
				   $(".cityall").removeAttr("name", "city");
				   
			   }else{
				   $('.citypo').hide();
				   $('.cityallo').show();
				   $('.cityp').removeAttr('id');
				   $(".cityall").attr("id", "city");
				   $(".cityall").attr("name", "city");
				   $(".cityp").removeAttr("name", "city");
			   }
			
		});
		
		
	//updateinfo

	
	
	
	$(document).on('click', '.update-manager-info', function(){
	
	var error = 0;
	
	if($('.isagency').prop('checked')==true){
			
			//var error = 1;
		if($('.agencylevel').val() == ''){
			
			$('.agencylevel-check').show();
			var error = 1;
		
		}else{
		$('.agencylevel-check').hide();
		
		}	
	
	}else{
		    $('.agencylevel-check').hide();
		
	}
	
	
	if($('.ispassword').prop('checked')==true){
		
		
		if($('#password_is').val() == ''){
		$('.password-check-is').show();
			var error = 1;
		}else{
		
		$('.password-check-is').hide();
		}
		
		if($('#password_confirmation_is').val() == ''){
			
			$('.confirm-password-check_is').show();
			var error = 1;
		
		}else{
		$('.confirm-password-check_is').hide();
		
		}

	
	}else{
		   $('.password-check-is').hide();
		   $('.confirm-password-check_is').hide();
			//var error = 0;
	}

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
	
	
	
	
			//phone number validation
	//start
	if($('#phone').val() == ''){
	//alert(name);
	$('#phone').focus();
	$('.phonea-checkm').show();
	error=1;
}else{
	$('.phonea-checkm').hide();
}
	
	
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
			 $('.confirm-email-check-match').hide();
			conformemailinvoild =1;
		}else{
			$('.conformemail-check').hide();
			 $('.confirm-email-check-match').hide();
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
	 $('.confirm-email-check-match').hide();
	emailinvoild= 1;
	//return false;
	}else{
		$('.email-check').hide();
		$('.email-involid-check').show();
		 $('.confirm-email-check-match').hide();
		$('#email').focus();
		error=1;
		//return false;
	}
	}
	
	
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
	
	//end
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

	if(error == 1){
		return false;
	}else{
		//alert('hi');
		$('#signformsubmit').submit();
	
	}
		
});

		
		
		
		
	
	
	$(document).on('click', '.create-agency', function(){
	
	var error = 0;
	
	if($('.isagency').prop('checked')==true){
			
			//var error = 1;
		if($('.agencylevel').val() == ''){
			
			$('.agencylevel-check').show();
			var error = 1;
		
		}else{
		$('.agencylevel-check').hide();
		
		}	
	
	}else{
		    $('.agencylevel-check').hide();
		
	}
	
	
	if($('.ispassword').prop('checked')==true){
		
		
		if($('#password_is').val() == ''){
		$('.password-check-is').show();
			var error = 1;
		}else{
		
		$('.password-check-is').hide();
		}
		
		if($('#password_confirmation_is').val() == ''){
			
			$('.confirm-password-check_is').show();
			var error = 1;
		
		}else{
		$('.confirm-password-check_is').hide();
		
		}

	
	}else{
		   $('.password-check-is').hide();
		   $('.confirm-password-check_is').hide();
			//var error = 0;
	}

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
	
	
	
	
			//phone number validation
	//start
		if($('#whatsapp1').val() == ''){
	//alert(name);
	  $('#whatsapp1').focus();
	  $('.whatupa-check').show();
	  error=1;
	}else{
	  $('.whatupa-check').hide();
	}
	
	
	if($('#mobile1').val() == ''){
	//alert(name);
	  $('#mobile1').focus();
	  $('.mobilea-check').show();
	  error=1;
	}else{
	  $('.mobilea-check').hide();
	}
	if($('#phone').val() == ''){
	//alert(name);
	$('#phone').focus();
	$('.phonea-checkm').show();
	error=1;
}else{
	$('.phonea-checkm').hide();
}
	
	
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
			 $('.confirm-email-check-match').hide();
			conformemailinvoild =1;
		}else{
			$('.conformemail-check').hide();
			 $('.confirm-email-check-match').hide();
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
	 $('.confirm-email-check-match').hide();
	emailinvoild= 1;
	//return false;
	}else{
		$('.email-check').hide();
		$('.email-involid-check').show();
		 $('.confirm-email-check-match').hide();
		$('#email').focus();
		error=1;
		//return false;
	}
	}
	
	
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
	
	//end
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

	if(error == 1){
		return false;
	}else{
	     
		$('.agencyinfo').show();
		 $('.agencyinformation').show();
		 
		 
		 //$('.managerdetails').hide();
		   $('.infoagencyform').hide();
		 
		 $(".managerdetails").removeClass("active");
		 $(".managerdetails").removeClass("show");
		 $(".agencyinfo").addClass("active");
		 $(".agencyinfo").addClass("show");
		 
		 $('.managerdetailstab').hide();

		//$('#signformsubmit').submit();
	      //$('#agency_info').submit();
		  
		  
		  
		  $.ajax({
        type:"POST",
        url:agencyInsertAjaxValidate,
        data:$('#signformsubmit').serialize(),
        success: function(data){
			if(data == 'ok'){
				$('.alreadyemail').hide();
		 $('.agencyinfo').show();
		 $('.agencyinformation').show();
		 //$('.managerdetails').hide();
		   $('.infoagencyform').hide();
		 
		 $(".managerdetails").removeClass("active");
		 $(".managerdetails").removeClass("show");
		 $(".agencyinfo").addClass("active");
		 $(".agencyinfo").addClass("show");
		 
		 $('.managerdetailstab').hide();
				
				
				
			}
			
			},
        error: function(data){
			if(data.responseJSON.email != ''){
			$('.alreadyemail').show();
			$('.alreadyemail').html(data.responseJSON.email);
			
			}
			
			if(data.responseJSON.password != ''){
			
			
			
			}
			
			
			
        }
    })
		  
		  
		  
		  
		return false;
	
	}
		
});







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
/*	if($('#website').val() == ''){
	//alert(name);
	  $('#website').focus();
	  $('.website-check').show();
	  error=1;
	}else{
	  $('.website-check').hide();
	}*/
	
	//skype  validation
	//start
/*	if($('#skype').val() == ''){
	//alert(name);
	  $('#skype').focus();
	  $('.skypea-check').show();
	  error=1;
	}else{
	  $('.skypea-check').hide();
	}*/
	//end
	
	//end
	
	//whatsapp number validation
	//start

	//end
	
	
	//phone number validation
	//start
	/*if($('#phone1').val() == ''){
	//alert(name);
	  $('#phone1').focus();
	  $('.phonea-check').show();
	  error=1;
	}else{
	  $('.phonea-check').hide();
	}*/
	
	
	//phone number validation
	//start
	
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
			$('.confirm1-email-check-match').hide();
			conformemailinvoild =1;
		}else{
			$('.conformemail1-check').hide();
			$('.conformemail1-involid-check').show();
			$('.confirm1-email-check-match').hide();
			
			$('#conformemail1').focus();
			error=1;
		}
	}
	
	
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
	$('.confirm1-email-check-match').hide();
	emailinvoild=1;
	}else{
		$('.emaila-check').hide();
		$('.emaila-involid-check').show();
		$('.confirm1-email-check-match').hide();
		$('#aemail').focus();
		error=1;
	}
	}
	
	if(emailinvoild && conformemailinvoild){ 
	
	
	//alert('hi');
	var sEmail = $('#aemail').val();
	var conformemail = $('#conformemail1').val();
	
	  if (sEmail != conformemail)
           {
           //alert('hi');
		   $('#aemail').focus();
		   $('.confirm1-email-check-match').show();
		   error=1;
           }else{
		    $('.confirm1-email-check-match').hide();
		   
		   }
	
	
	}
	//end
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
		
		
		var updateagencyinformation = $('#updateagencyinformation').val();
		
		if(updateagencyinformation == '345'){
			
			$('#agency_info').submit();
			return false;
			}else{
		
		
		var verfitxt = '';
		//$('#agency_info').submit();
		$( ".verfycontent" ).each(function() {
			
			var verfycontentC = $(this).val();
			if(verfycontentC == '' && $.trim(verfycontentC) == ''){
				verfitxt = 1;
				
				
			}
			
			
			
			
		});


		if(verfitxt == 1){
			
			$('.verfycontenterror').show();
			return false;
		}else{
			$.ajax({
        type:"POST",
        url:agencyInsertAjax,
        data:$('#signformsubmit').serialize(),
        success: function(data){ 
		$('#agencyidinser').val(data);
		$('#agency_info').submit()
		
		},
        error: function(data){}
    });

			
		   //$('#signformsubmit').submit();
		return false;
		}
		return false;
	      //$('#agency_info').submit();
		
	
	}
		
	}
	
	
});
	
	
	
	
	
	
	
	
	<?php if(isset($_GET['id'])) { ?>
			
			<?php if((isset($_GET['tab'])) == '2' ) { ?>
		//$(".agencyinformation").addClass("active");
		$(".infoagen").addClass("infoagencyform");
			<?php } ?>
			
			
	$('.agencyinfo').click(function()
	{
		$(".agencyinformation").addClass("active");
		
		
		$(".agencyinformation").addClass("show");
		$(".agencyinformation").show();
		
		
		$(".infoagen").hide();
		
		var verfitxt = '';
		//$('#agency_info').submit();
		$( ".verfycontent" ).each(function() {
			
			var verfycontentC = $(this).val();
			if(verfycontentC == '' && $.trim(verfycontentC) == ''){
				verfitxt = 1;
				
				
			}
			
			
			
			
		});
		
		if(verfitxt == 1){
			
			$('.verfycontenterror').show();
			return false;
		}else{
		
		
		     $('.verfycontenterror').hide();
		
		}
	
		
	});
	
	
	<?php } ?>
	
	
	
	
	
// update and insert popup hide


$(document).on('click', '.closeurl', function(){

$('.modelshow').hide();

var url = $('#homeurl').val();
//window.history.pushState('', '', url+'&tab=1');
window.history.pushState('', '', url);

});
	
	
	

	
	$(document).on('click', '.ispassword', function(){
	if(this.checked){
	
	$('.checkispassword').show();
	
	$(".passwordContent").addClass("verfycontent");
	

	}else{
		
		$('.checkispassword').hide();
		$(".passwordContent").removeClass("verfycontent");
	}
	});	
	
	
	$(document).on('click', '.isagency', function(){
	
	if(this.checked){
	
	$('.checkisagency').show();

	}else{
		
		$('.checkisagency').hide();
	}
	});	
	
	
		
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
	 
	 //Thana Start
	 
	 $("#zip").keypress(function (e) {
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
	 
	 
	 	  /*$("#skype").keypress(function (e) {
  if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) 
       {
          $("#errmsg").html("Digits Only").show().fadeOut(5000);
          $(this).css({"border": "1px solid red"});
                 return false;
       }
	   else
	   {
		 $(this).css({"border-color": "#ebedf2","color":"#575962"});
	   }
     });*/
	 
	 
	 /*
	 	  $("#register_number").keypress(function (e) {
  if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) 
       {
          $("#errmsg").html("Digits Only").show().fadeOut(5000);
          $(this).css({"border": "1px solid red"});
                 return false;
       }
	   else
	   {
		 $(this).css({"border-color": "#ebedf2","color":"#575962"});
	   }
     });*/
	 
	 
	 $(".required").each(function() {
        if ($(this).val() === "") {
			e.preventDefault();
      
            counter++;
        }else { $(this).css('border','2px solid #dadde2'); }
    });
	 

	
	
	
	
	
	
	
	 	
	 //Thana End	  
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

<?php if(isset($_GET['id']) && !empty($_GET['id'])){?>
<script>
$(document).ready(function (){


$('.managerdetails').click(function (){
	$(".managerdetailstab").show();
		$(".agencyinformation").removeClass("active");
		
		$(".agencyinformation").removeClass("show");
		$(".agencyinformation").hide();

		$(".infoagen").show();
	var url = $('#homeurl').val();
    window.history.pushState('', '', url+'&tab=1');
});

$('.agencyinfo').click(function (){
	var url = $('#homeurl').val();
    window.history.pushState('', '', url+'&tab=2');
});
	
	
});
	


</script>
<?php }else{  ?>
<script>
$(document).ready(function (){
	
	$('.managerdetails').click(function (){
	$(".managerdetailstab").show();
		$(".agencyinformation").removeClass("active");
		$(".agencyinformation").removeClass("show");
		$(".agencyinformation").hide();
		$(".infoagen").show();
});



$('.agencyinfo').click(function()
	{

		
		$(".agencyinformation").addClass("active");
		
		
		$(".agencyinformation").addClass("show");
		
		
		$(".agencyinfo").addClass("active");
		
		
		$(".agencyinfo").addClass("show");
		
		
		$(".managerdetails").removeClass("active");
		
		
		$(".managerdetails").removeClass("show");
		
		
		
		
		$(".agencyinformation").show();
		
		
		$(".infoagen").hide();
		
		var verfitxt = '';
		//$('#agency_info').submit();
		$( ".verfycontent" ).each(function() {
			
			var verfycontentC = $(this).val();
			if(verfycontentC == '' && $.trim(verfycontentC) == ''){
				verfitxt = 1;
				
				
			}
			
			
			
			
		});
		
		if(verfitxt == 1){
			
			$('.verfycontenterror').show();
			return false;
		}else{
		
		
		     $('.verfycontenterror').hide();
		
		}
	
		
	});
	
	
	
	
});
</script>


<?php } ?> 
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
.infoagencyform
{

}

</style>