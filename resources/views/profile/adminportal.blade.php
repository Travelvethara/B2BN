@extends('layouts.app')
@section('content')
<?php 

?>

	
	<!-- BEGIN: Subheader -->
	
	<div class="">
		<!-- END: Subheader -->
		<div class="m-content">
						<!--Begin::Section-->
                                                <div class="tabfn m-portlet m-portlet-padding">
						<div class="row">
							<ul class="nav nav-tabs  m-tabs-line m-tabs-line--primary somehti" role="tablist">
											<li class="nav-item m-tabs__item">
												<a class="nav-link m-tabs__link managerdetails active show" data-url="http://dev.livebeds.com/agency&amp;tab=1" data-toggle="tab" href="#m_tabs_6_1" role="tab" aria-selected="true">
                                                    Travelanda
												</a>
											</li>
									
											<li class="nav-item m-tabs__item">
												<a class="nav-link m-tabs__link agencyinfo" data-url="http://dev.livebeds.com/agency&amp;tab=2" data-toggle="tab" href="#m_tabs_6_3" role="tab" aria-selected="false">
													TBO Holidays
												</a>
											</li>
                                            
										</ul>
						</div>
                        <div class="tab-content">
										<div class="tab-pane managerdetailstab active show" id="m_tabs_6_1" role="tabpanel">
								<form action="{{ route('adminApicontrolupdate') }}" class="m-form infoagen" method="post" id="signformsubmit" style="">
                                    
                                  <input type="hidden" name="_token" value="<?php echo @csrf_token(); ?>">
                                  
							<div class=" agency-info-tab active">
                            
                            
                             <div class="form-group m-form__group row">
						                      <label class="col-lg-2 col-form-label">Test Key Username<span class="requiredcls" aria-required="true"> </span></label>
						                      <div class="col-lg-5">
							                  <input type="text" name="testusername" class="form-control m-input verfycontent" placeholder="" value="<?php if(isset($adminportal->Travelanda_Test_Usename) && !empty($adminportal->Travelanda_Test_Usename)) { echo $adminportal->Travelanda_Test_Usename; } ?>" id="name" >
                                              
                                              <span class="error-message fullname-check" style="display:none">
													The field is required.
												 </span>
                                              
                                              
                                               
							                                  <!--<span class="m-form__help">Please enter your full name</span>-->
						                        </div>
					           </div>
                               
                               
                               
                               <div class="form-group m-form__group row">
						                      <label class="col-lg-2 col-form-label">Test Key Password<span class="requiredcls" aria-required="true"></span></label>
						                      <div class="col-lg-5">
							                  <input type="text" name="Testpassword" class="form-control m-input verfycontent" placeholder="" value="<?php if(isset($adminportal->Travelanda_Test_Password) && !empty($adminportal->Travelanda_Test_Password)) { echo $adminportal->Travelanda_Test_Password; } ?>" id="name" >
                                              
                                              <span class="error-message fullname-check" style="display:none">
													The field is required.
												 </span>
                                              
                                              
                                               
							                                  <!--<span class="m-form__help">Please enter your full name</span>-->
						                        </div>
					           </div>
                              
                               
                               
                             <div class="form-group m-form__group row">
						                      <label class="col-lg-2 col-form-label">Live Key Username<span class="requiredcls" aria-required="true">  </span></label>
						                      <div class="col-lg-5">
							                  <input type="text" name="liveusername" class="form-control m-input verfycontent" placeholder="" value="<?php if(isset($adminportal->Travelanda_Live_Username) && !empty($adminportal->Travelanda_Live_Username)) { echo $adminportal->Travelanda_Live_Username; } ?>" id="name" >
                                              
                                              <span class="error-message fullname-check" style="display:none">
													The field is required.
												 </span>
                                              
                                              
                                               
							                                  <!--<span class="m-form__help">Please enter your full name</span>-->
						                        </div>
					           </div>
                               
                               <div class="form-group m-form__group row">
						                      <label class="col-lg-2 col-form-label">Live Key Password<span class="requiredcls" aria-required="true"> </span></label>
						                      <div class="col-lg-5">
							                  <input type="text" name="livepassword" class="form-control m-input verfycontent" value="<?php if(isset($adminportal->Travelanda_Live_Password) && !empty($adminportal->Travelanda_Live_Password)) { echo $adminportal->Travelanda_Live_Password; } ?>" id="name" >
                                              
                                              <span class="error-message fullname-check" style="display:none">
													The field is required.
												 </span>
                                              
                                              
                                               
							                                  <!--<span class="m-form__help">Please enter your full name</span>-->
						                        </div>
					           </div>
                             
                                                <div class="form-group m-form__group row">
														 <label class="col-lg-2 col-form-label"></label>
                                                             <div class="col-lg-5">
															    <label class="m-checkbox">
																<input type="checkbox" name="isagency" class="ispassword"  <?php if($adminportal->Travelanda_Live == '1') { echo 'checked="checked"'; } ?>  /> Do You have use live key 
																<span></span>
																</label>
															</div>	
															
												   </div>
                                               
                                               
                                                                                                                                              
												   <div class="m-portlet__foot m-portlet__foot--fit">
												 <div class="m-form__actions m-form__actions">
												    <div class="row">
													    <div class="col-lg-2">
														</div>
														<div class="col-lg-5">
                                                <input type="hidden" name="supplier" value="travellanda">
                                                        
                                                  <button type="submit" name="create_sublier" class="btn btn-primary create-agency">Submit</button>
                                                                                                                        
														</div>
													</div>
													</div>
												
											</div>
											</div>
                                            </form>
                                            <input type="hidden" id="verfytext" value="">
                                            </div>
                                            
                                            <!------- create agency---------->
								<div class="tab-pane agencyinformation" id="m_tabs_6_3" role="tabpanel" style="display: none;">
												<div class="">
                                 		<form action="{{ route('adminApicontrolupdate') }}" class="m-form" method="POST" id="agency_info">
                                      <input type="hidden" name="_token" value="<?php echo @csrf_token(); ?>">
										                                              
                                       
                             <div class="form-group m-form__group row">
						                      <label class="col-lg-2 col-form-label">Test Key Username<span class="requiredcls" aria-required="true"> </span></label>
						                      <div class="col-lg-5">
							                  <input type="text" name="testusername" class="form-control m-input verfycontent" placeholder="" value="<?php if(isset($adminportal->Tbo_Test_Usename) && !empty($adminportal->Tbo_Test_Usename)) { echo $adminportal->Tbo_Test_Usename; } ?>" id="name" >
                                              
                                              <span class="error-message fullname-check" style="display:none">
													The field is required.
												 </span>
                                              
                                              
                                               
							                                  <!--<span class="m-form__help">Please enter your full name</span>-->
						                        </div>
					           </div>
                               
                               
                               
                               <div class="form-group m-form__group row">
						                      <label class="col-lg-2 col-form-label">Test Key Password<span class="requiredcls" aria-required="true"></span></label>
						                      <div class="col-lg-5">
							                  <input type="text" name="Testpassword" class="form-control m-input verfycontent" placeholder="" value="<?php if(isset($adminportal->Tbo_Test_Password) && !empty($adminportal->Tbo_Test_Password)) { echo $adminportal->Tbo_Test_Password; } ?>" id="name" >
                                              
                                              <span class="error-message fullname-check" style="display:none">
													The field is required.
												 </span>
                                              
                                              
                                               
							                                  <!--<span class="m-form__help">Please enter your full name</span>-->
						                        </div>
					           </div>
                              
                               
                               
                             <div class="form-group m-form__group row">
						                      <label class="col-lg-2 col-form-label">Live Key Username<span class="requiredcls" aria-required="true">  </span></label>
						                      <div class="col-lg-5">
							                  <input type="text" name="liveusername" class="form-control m-input verfycontent" placeholder="" value="<?php if(isset($adminportal->Tbo_Live_Usename) && !empty($adminportal->Tbo_Live_Usename)) { echo $adminportal->Tbo_Live_Usename; } ?>" id="name" >
                                              
                                              <span class="error-message fullname-check" style="display:none">
													The field is required.
												 </span>
                                              
                                              
                                               
							                                  <!--<span class="m-form__help">Please enter your full name</span>-->
						                        </div>
					           </div>
                               
                               <div class="form-group m-form__group row">
						                      <label class="col-lg-2 col-form-label">Live Key Password<span class="requiredcls" aria-required="true"> </span></label>
						                      <div class="col-lg-5">
							                  <input type="text" name="livepassword" class="form-control m-input verfycontent" placeholder="" value="<?php if(isset($adminportal->Tbo_Live_Password) && !empty($adminportal->Tbo_Live_Password)) { echo $adminportal->Tbo_Live_Password; } ?>" id="name" >
                                              
                                              <span class="error-message fullname-check" style="display:none">
													The field is required.
												 </span>
                                              
                                              
                                               
							                                  <!--<span class="m-form__help">Please enter your full name</span>-->
						                        </div>
					           </div>
                             
                                                <div class="form-group m-form__group row">
														 <label class="col-lg-2 col-form-label"></label>
                                                             <div class="col-lg-5">
															    <label class="m-checkbox">
																<input type="checkbox" name="isagency" class="ispassword" <?php if($adminportal->Tbo_Live == '1') { echo 'checked="checked"'; } ?>  /> Do You have use live key 
																<span></span>
																</label>
															</div>	
															
												   </div>
                                               
												 
												 
												  
												 
												<div class="m-portlet__foot m-portlet__foot--fit">
												 <div class="m-form__actions m-form__actions">
												    <div class="row">
													   <div class="col-lg-2">
													   </div>
														<div class="col-lg-5">
                                                       
                                           <input type="hidden" name="supplier" value="tbo">
                                                        
                                                  <button type="submit" name="create_sublier" class="btn btn-primary create-agency">Submit</button>
									
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
    	The data was added successfully.
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



<?php if(isset($_GET['id']) && !empty($_GET['id'])){?>           
	<input type="hidden" id="homeurl" value="<?php echo URL::to("/profile?id=".$_GET['id']);?>"/>
<?php }else{ ?>
	<input type="hidden" id="homeurl" value="<?php echo URL::to("/adminApicontrol");?>"/>
<?php } ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
	$(document).ready(function(e) {
		
		
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
		$(".agencyinformation").show();
		
		
		$(".infoagen").hide();

		
	});
		
		
		
		
		$(document).on('click', '.closeurl', function(){

			$('.modelshow').hide();

			var url = $('#homeurl').val();
			window.history.pushState('', '', url);

		});

		$('.changepassword').click(function(e) {
			if(this.checked){
				
				$('.checkpassword').show();

			}else{
				
				$('.checkpassword').hide();
			}
		});
	});
</script>	




@endsection
