@extends('layouts.app')



@section('content')



<?php 





?>

<div class="m-grid__item m-grid__item--fluid m-wrapper">

					<!-- BEGIN: Subheader -->

					<div class="m-subheader ">

						<div class="d-flex align-items-center">

							<div class="mr-auto">

								<h3 class="m-subheader__title ">

									Notification for Agent

                                  

								</h3>

                                

                              

                                

							</div>

                            

						</div>

					</div>

					<!-- END: Subheader -->

					<div class="m-content agencies_list">

					  <div class="agency-list below-h3-heading">

                                <!--<a href="{{route('agency')}}">Create Agency</a>-->

                                

                                </div>

                          <div class="m-portlet m-portlet--mobile">

							

							<div class="m-portlet__body">

								<!--begin: Search Form -->

								<div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">

									<div class="row align-items-center">

										<div class="col-xl-8 order-2 order-xl-1">

											<div class="form-group m-form__group row align-items-center">

												<div class="col-md-4">

													<div class="m-form__group m-form__group--inline">

														<div class="m-form__label">

															<label>

																Type:

															</label>

														</div>

														<div class="m-form__control">

															<select class="form-control m-bootstrap-select" id="m_form_agency_level">

																<option value="">

																	All

																</option>

																<option value="1">

																	Parent

																</option>

																<option value="2">

																	Sub

																</option>



															</select>

														</div>

													</div>

													<div class="d-md-none m--margin-bottom-10"></div>

												</div>

											

												<div class="col-md-4">

													<div class="m-input-icon m-input-icon--left">

														<input type="text" class="form-control m-input" placeholder="Search..." id="generalSearch">

														<span class="m-input-icon__icon m-input-icon__icon--left">

															<span>

																<i class="la la-search"></i>

															</span>

														</span>

													</div>

												</div>

											</div>

										</div>

										

									</div>

								</div>

								<!--end: Search Form -->

		<!--begin: Datatable -->

								<table class="m-datatable" id="html_table" width="100%">

									<thead>

										<tr>

											<th title="Field #1">

												Date

											</th>

											<th title="Field #2">

												Agency Name

											</th>

											<th title="Field #3">

												Type

											</th>

											<th title="Field #4">

												City

											</th>

											<th title="Field #5">

												Country

											</th>

											<th title="Field #6">

												Action

											</th>

											

											

											

										</tr>

									</thead>

									<tbody>

                                    @foreach ($AgencyDetails as $details)

                                             
										<tr class="">

											<td class="">

                                                <?php echo date('Y-m-d', strtotime($details->updated_at));?>

											</td>

											<td>

												{{$details->aname}}

											</td>

											<td><?php if(isset($details->parentagencyid) && ($details->parentagencyid < 1)) { ?>1<?php

                               } else { ?> 2 <?php } ?></td>

											<td>

												{{$details->city}}

											</td>

											<td>

												{{$details->country}}

											</td>

											<td>

												
                                                <a href="{{route('agency.viewagency')}}?id={{Crypt::encrypt(base64_encode($details->id))}}" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill"><i class="fas fa-eye" data-id="1"></i></a>


                                                <a href="javascript:void(0)" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill">
											<i class="far fa-trash-alt Deletetresh DeleteRole" data-id="{{$details->id}}"></i>
										    </a>



											</td>

											

										</tr>
                                                  
                                        @endforeach

									</tbody>

								</table>

                               

								<!--end: Datatable -->

							</div>

						</div>      

                                

						

                   </div>

                   

                   <input type="hidden" id="offset" value="10" />

                   

                   <form id="rolelistform" action="{{route('notificationagencytrash')}}" method="POST" style="display: none;">

                                     <input type="hidden" name="_token" value="<?php echo @csrf_token(); ?>">

                                     <div class="deleteagency">


                                   </div>

                                    </form>

              			

				</div>

       <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>         

                

                <script>

				$(document).ready(function () {





	   $(document).on('click', '.Deletetresh', function(){

	   

	   var id = $(this).data('id');

	  

       var r = confirm("Are you sure you want to Delete now?");

       //cancel clicked : stop button default action 

       if (r === false) {

           return false;

        }

        

		else if(r === true){

			

			 	var storehidden = '<input type="hidden" value="'+id+'" name="id"/>';

			$('.deleteagency').append(storehidden);

			

			$('#rolelistform').submit();

		

		

		}

        //action continues, saves in database, no need for more code





   });

    });

				</script>





@endsection

