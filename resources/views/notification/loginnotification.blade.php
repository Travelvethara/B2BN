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

									Active Users

                                  

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

												S no

											</th>

											<th title="Field #2">

												 Name

											</th>

											<th title="Field #3">

												User Type

											</th>

											

											<th title="Field #6">

												Staus

											</th>

											

											

											

										</tr>

									</thead>

									<tbody>
                                    <?php $i=1;
									
									/*echo '<pre>';
									print_r($whologin);
									echo '</pre>';*/
									
									
									 ?>
                                    @foreach ($whologin as $details)

                                             @if(isset($agencyarray[$details->loginid]))
										<tr class="">

											<td class="">

												{{$i}}

											</td>

											<td>

												{{$agencyarray[$details->loginid]['name']}}

											</td>

											<td>{{ $details->type }}</td>

											

											<td>

                                           <span class="m-badge  m-badge--success m-badge--wide">Active</span>
											</td>

											

										</tr>
                                                  @endif
                                                  <?php ++$i; ?>
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

                                    <!--   <input type="hidden" value="{{$details->id}}" name="id"/>-->

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

