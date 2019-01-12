@extends('layouts.app')

@section('content')
<?php 

/*echo '<pre>';
print_r($hotel_Info);
echo '</pre>';*/
$datail_page_url = route('hoteldetail');

?>

<?php 

$NumAdults = '';
if(isset($_GET['hotelid']) && isset($_GET['hotelid'])){

$hotelid = $_GET['hotelid'];
$_GET['checkin'];
$_GET['checkout'];



 $norooms = $_GET['norooms'];

if($norooms){
			
			for($no=1;$no<=$norooms;$no++){
				
				if(isset($_GET['adult'.$no])){
					$NumAdults .= '&adult'.$no.'='.$_GET['adult'.$no];
					$NumAdults .= '&child'.$no.'='.$_GET['child'.$no];
				
				}
				
				if(isset($_GET['child'.$no])){

					for($ch=1;$ch<=$_GET['child'.$no];$ch++){
						$NumAdults .= '&childage'.$no.$ch.'='.$_GET['childage'.$no.$ch];
					}
				
				
				}
						
			}
		}
		
}

if(isset($_GET['hotelid1']) && empty($_GET['hotelid'])){
	
$_GET['checkin'];
$_GET['checkout'];



 $norooms = $_GET['norooms'];

if($norooms){
			
			for($no=1;$no<=$norooms;$no++){
				
				if(isset($_GET['adult'.$no])){
					$NumAdults .= '&adult'.$no.'='.$_GET['adult'.$no];
					$NumAdults .= '&child'.$no.'='.$_GET['child'.$no];
				
				}
				
				if(isset($_GET['child'.$no])){

					for($ch=1;$ch<=$_GET['child'.$no];$ch++){
						$NumAdults .= '&childage'.$no.$ch.'='.$_GET['childage'.$no.$ch];
					}
				
				
				}
						
			}
		}
		
		
$hotel_Info_tbo_s =  explode('|', $hotel_Info_tbo['Map']);


}

$currenytype = 'USD_'.$_GET['currency'];

$url = "https://free.currencyconverterapi.com/api/v5/convert?q=".$currenytype."&compact=ultra"; 
$cur=curl_init();
curl_setopt($cur,CURLOPT_URL,$url);
curl_setopt($cur, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
curl_setopt($cur,CURLOPT_HTTPHEADER,array('Accept:application/xml'));
curl_setopt($cur, CURLOPT_HTTPHEADER, array('Content-Type: text/xml,charset=UTF-8'));
curl_setopt($cur, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($cur, CURLOPT_RETURNTRANSFER,1);
$currency_curl_value = curl_exec($cur);
$cureency_result = json_decode($currency_curl_value, true);

$currecny_price = $cureency_result[$currenytype];


if(isset($_GET['tha'])){

echo '<pre>';
print_r($currecny_price);
echo '</pre>';
exit;
}


 /* echo '<pre>';
print_r($hotel_Info);
echo '</pre>'; 
exit;*/


?>

<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
<!-- END: Left Aside -->
<div class="m-grid__item m-grid__item--fluid m-wrapper">
	<!-- BEGIN: Subheader -->
	<!--<div class="m-subheader ">
		<div class="d-flex align-items-center">
			<div class="mr-auto">
				<h3 class="m-subheader__title ">
					Hotel List 
					<i class="responsivefilter fa fa-filter"></i>
                    <i class="modifyeaarchicon flaticon-search" data-toggle="m-tooltip" data-placement="bottom" data-original-title="Modify Search"></i>
				</h3>
			</div>
		</div>
	</div> -->
	<!-- END: Subheader -->
	<div class="m-content list-page">
		<!--Begin::Section-->
        
        
        <input type="hidden" name="currecny" id="currecny" value="<?php if(isset($_GET['currency'])){ echo $_GET['currency']; }?>"/>
        <div class="user-content user-content-search">
			<form action="{{ route('hotellist') }}" method="get" id="hotelserch"/>
			
			<div class="m-portlet m-portlet-padding user-info">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group m-form__group">
							<input type="text" class="form-control m-input Destination required" id="showresule" name="city" placeholder="Enter a location" value="<?php if(isset($_GET['city'])){ echo $_GET['city']; }?>">
							
							<input type="hidden" name="cityid" id="cityid" value="<?php if(isset($_GET['cityid'])){ echo $_GET['cityid']; }?>"/>
							<input type="hidden" name="cityname" id="cityname" value="<?php if(isset($_GET['cityname'])){ echo $_GET['cityname']; }?>"/>
							
						</div>
					</div>
					<div class="col-md-2 ">
						<div class="form-group m-form__group positionrelative claendericon ">
							<div class='input-group' id='m_daterangepicker_1_validate'>
								
								<!--<input type='text' class="form-control m-input required" readonly  placeholder="Select date range"/>-->
								<input type="text" class="form-control required" id="m_datepicker_1" readonly placeholder="Select date" name="checkin" value="<?php if(isset($_GET['checkin'])){ echo $_GET['checkin']; }?>"/>
								
							</div>
							<span><i class="far fa-calendar-alt"></i></span>
						</div>
					</div>
					<div class="col-md-2 ">
						<div class="form-group m-form__group positionrelative claendericon ">
							<div class='input-group' id='m_daterangepicker_1_validate'>
								
								<!--<input type='text' class="form-control m-input required" readonly  placeholder="Select date range"/>-->
								<input type="text" class="form-control required" id="m_datepicker_2" readonly placeholder="Select date" name="checkout" value="<?php if(isset($_GET['checkout'])){ echo $_GET['checkout']; }?>"/>
								
							</div>
							<span><i class="far fa-calendar-alt"></i></span>
						</div>
					</div>
														<!--<div class="col-md-2 ">
															<div class="form-group m-form__group positionrelative claendericon">
																<input type="text" class="form-control m-input checkoutorlando" id="checkoutorlando"  placeholder="Chack Out" name="checkout">
																<span><i class="far fa-calendar-alt"></i></span>
															</div>
														</div>-->
														<div class="col-md-2 ">
															<div class="form-group m-form__group no-days-block">
																<!--<lable> <b>2</b> days </lable>-->
															</div>
														</div>
													</div>
													<input type="hidden" name="norooms" id="norooms" value="1"/>
													
												    <!--<div class="row marginten">
													  <div class="col-md-12">
														<h5>Star Rating</h5>
													  </div>	
													</div>-->
												   <!--<div class=" star-rating-blocks clear">
												    <div class="rating-block-one">
														<label class="m-checkbox m-checkbox--square">
															<input type="checkbox"> 1
													        <span></span>
											             </label>
													</div>
													 <div class="rating-block-one">
														<label class="m-checkbox m-checkbox--square">
															<input type="checkbox"> 2
													        <span></span>
											             </label>
													</div>
													 <div class="rating-block-one">
														<label class="m-checkbox m-checkbox--square">
															<input type="checkbox"> 3
													        <span></span>
											             </label>
													</div>
													 <div class="rating-block-one">
														<label class="m-checkbox m-checkbox--square">
															<input type="checkbox"> 4
													        <span></span>
											             </label>
													</div>
													 <div class="rating-block-one">
														<label class="m-checkbox m-checkbox--square">
															<input type="checkbox"> 5
													        <span></span>
											             </label>
													</div>
												</div>-->
												
												<div class="row nomargin">
													<div class="col-md-6">
														<button type="button" class="btn btn-primary" id="home_btnsubmit">Search Hotels</button>
													</div>
												</div>
											</div>
										</form>
									</div>
        
        
        
        
            <div class="hotel-details-u m-portlet roboto">
            	<div class="hotel-details-u-top clearfix">
                	<div class="hotel-details-u-top-left">
                    	<div class="hotel-informations-o-part-up">
                                	<div class="ho-name">
                                    	 <?php  if(isset($_GET['hotelid1']) && empty($_GET['hotelid'])){ ?>
                 {{$hotel_Info_tbo['attributes']['HotelName']}}
                   
                   
                    <?php }else{ ?>
						{{$hotel_Info->HotelName}}
                   <?php } ?>
                                    </div>
                                    <div class="star-ratings-trip-advisors">
                                    	<div class="hotel-list-star">
                                        	<ul>
                                            
                                            <?php  if(isset($_GET['hotelid1']) && empty($_GET['hotelid'])){ ?> 
						 
						 @for($s=1;$s<=round($hotel_Info_tbo['TripAdvisorRating']);$s++)
							<li><img src="{{asset('img/star.png')}}">
                                                </li>
							@endfor
						 <?php }else{ ?>
							@for($s=1;$s<=round($hotel_Info->StarRating);$s++)
					
                            
                            <li><img src="{{asset('img/star.png')}}">
                                                </li>
                            
							@endfor
                            <?php } ?>
                            </ul>
                                        </div>
                                        <div class="hotel-list-trip">
                                        	<div class="trip-icons">
                                            	<img src="{{asset('img/tripicon.png')}}" />
                                            </div>
                                            <div class="trip-icons-ratings">
                                            	<ul>
                                                	<li><img src="{{asset('img/trip-ratings.png')}}"></li>
                                                    <li><img src="{{asset('img/trip-ratings.png')}}"></li>
                                                    <li><img src="{{asset('img/trip-ratings.png')}}"></li>
                                                    <li><img src="{{asset('img/trip-ratings.png')}}"></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="hotel-o-address">
                                    	<?php  if(isset($_GET['hotelid1']) && empty($_GET['hotelid'])){ ?> 
						 {{$hotel_Info_tbo['Address']}}
						<?php }else{ ?>
							 {{$hotel_Info->Address}} 
                             <?php } ?>
                                    </div>
                                 </div>
                    </div>
                    <div class="hotel-details-u-top-right">
                    	    <div class="hotel-details-r-l">
                                	<div class="h-l-best-price-tag">
                                    	From
                                    </div>
                                    <div class="h-l-best-price bestpricec">
                                    	No Price
                                    </div>
                                    <i>For Min</i>
                                    </div>
                                    <div class="hotel-details-r-r">
                                    	<a href="#booknowshow" class="btn-black">
                                        	select room
                                        </a>
                                    </div>
                                  
                                
                    </div>
                </div>
                
                
                
                <div class="hotel-details-u-bottom">
                	<div class="hotel-details-banner-features clearfix spacebanner">
                    	<div class="hotel-details-banner">
                        	<div class="hoteldetailbanner slider">
                            
                             <?php 
							 if(isset($hotel_Info->Images->Image)){
							 
							 
						foreach($hotel_Info->Images->Image as $hotelimage){
                      
							?>
                            
        <img src="{{$hotelimage}}"  style="width:50%;height:auto;" />

          
       <?php }}else{ ?>
       <img src="{{asset('img/noimage.png')}}"  style="width:50%;height:auto;" />
       
       <?php } ?>
    </div>
                            </div>
                            <div class="hotel-detail-features">
                                <h2>Hotel Features</h2>
                            	<ul class="clearfix">
					<?php 
					
					if(isset($_GET['hotelid1']) && empty($_GET['hotelid'])){ 
					
					for($r=1;$r<=8;$r++){
						 if(isset($hotel_Info_tbo['HotelFacilities']['HotelFacility'][$r]) && !empty($hotel_Info_tbo['HotelFacilities']['HotelFacility'][$r])){  ?>
                        <li>{{$hotel_Info_tbo['HotelFacilities']['HotelFacility'][$r]}}</li>
						<?php 
						 }
					}
					
					
					} else{
					
					
					
   $g = 1;
   foreach($hotel_Info->Facilities->Facility as $facil) { 
   ?>
				
					<li>{{$facil->FacilityName}}</li>
					<?php if($g > 9) { break; } $g++;  } } ?>
 
					
					
				</ul>
                                <!--<a href="">View More</a>-->
                            </div>
                        </div>
                        <div class="spacebanner hotel-description">
                        	<h2>Hotel Description</h2>
                            <?php if(isset($_GET['hotelid1']) && empty($_GET['hotelid'])){ ?>
			
			<p>{{$hotel_Info_tbo['Description']}}</p>
			<?php
			} else{ ?>
				<p>{{$hotel_Info->Description}}</p>
                <?php } ?>
                        </div>
                         <div class="spacebanner Rooms-And-Rates booknowshowlist">
                        	<h2>Rooms And Rates</h2>
                   <table id="booknowshow" >
						<tbody>
							<?php $i=1;?>
                             <?php   $roomurl = ''; 
							 if(isset($hotel_details->Option) && !empty($hotel_details->Option)){
							 
							 ?>  
							@foreach($hotel_details->Option as $HotelRoomResponse)
                            <?php 
							
						
							
							$roomurl = ''; ?> 
							<?php $roomc = 1; ?>
                            @foreach($HotelRoomResponse->Rooms->Room as $HotelRoomResponse_Rooms)
                            <?php $roomurl .='roomid'.$roomc.'='.$HotelRoomResponse_Rooms->RoomId.'&';  ?>
                            <?php ++$roomc; ?>
                            @endforeach
                            
                            <?php 
							if(isset($hotel_detail_mark_up)){
								   $new_width = ($hotel_detail_mark_up / 100) * $HotelRoomResponse->TotalPrice;
								   $Total_price = $HotelRoomResponse->TotalPrice + $new_width;
								}else{
								   $Total_price = $HotelRoomResponse->TotalPrice;
								}
								
							if(isset($_GET['markup']) && !empty($_GET['markup'])){
                                    	$addMarkupPrice = (($_GET['markup'] / 100) * $Total_price);
									
									    $Total_price = $Total_price +  $addMarkupPrice;
                              }
			
							
							$Total_price = $currecny_price * $Total_price;
							
							?>
							<tr>
                               
								<td><h5>{{$HotelRoomResponse->Rooms->Room->RoomName }}</h5>
                                </td>
                                
								<td><a href="javascript:void(0)" class="Cancellationpoilcyajaxclick" data-id="<?php echo $HotelRoomResponse->OptionId; ?>" data-sub="Travelanda" data-hotelid="<?php if(isset($_GET['hotelid'])) { echo $_GET['hotelid'];  } ?>">Cancellation Policy</a></td>
                                <td class="text-center">
                            	<div class="table-api-price">
                                    <p class="minpriceget" data-price="{{round($Total_price)}}"><?php if(isset($_GET['currency'])){ echo $_GET['currency']; }?> {{number_format($Total_price, 2)}}</p>
                                </div>
                            </td>
                                
                                  
                                  <td class="text-right">
                            	<a class="btn btn-primary" href="{{route('payment')}}?hotelid=<?php echo $_GET['hotelid']; ?>&checkin=<?php echo $_GET['checkin']; ?>&checkout=<?php echo $_GET['checkout']; ?>&optionID=<?php echo $HotelRoomResponse->OptionId; ?>&norooms=<?php echo $_GET['norooms']; ?>&<?php echo $NumAdults; ?>&<?php echo $roomurl; ?> <?php if(!empty($_GET['bookingid'])){ ?>&bookingid=<?php echo $_GET['bookingid']; ?>  <?php }else{ ?><?php } ?> <?php if(!empty($_GET['markup'])){ ?>&markup=<?php echo $_GET['markup']; ?>  <?php } ?><?php if(!empty($_GET['currency'])){ ?>&currency=<?php echo $_GET['currency']; ?>  <?php } ?> "> Book Now </a>
                            </td>
                            
                            
                                  
                                  
							</tr>   
							
							<?php ++$i;?> 
							@endforeach
                            <?php } ?>
                            
                            
                            
                             <?php   $roomurl = '';
							 
							 $roomoption = 101; 
							 $RoomTypeCode= '';
													
							 if(isset($RoomCombinationArray[1]) && !empty($RoomCombinationArray[1])){
							 $run = 1;
							 ?>  
							@foreach($RoomCombinationArray as $values)
                            
                            
                            <?php 
							
			             
						 
						 
						 $noROOMS = $_GET['norooms']; 
						 
						    //price
							
							if(isset($hotel_detail_mark_up)){
								   $new_width = ($hotel_detail_mark_up / 100) * $RoomCombinationarray_Combination[0]['TotalFare'.$values['RoomCombination']['index'][$noROOMS]];
								   $Total_price = $RoomCombinationarray_Combination[0]['TotalFare'.$values['RoomCombination']['index'][$noROOMS]] + $new_width;
								}else{
								   $Total_price = $RoomCombinationarray_Combination[0]['TotalFare'.$values['RoomCombination']['index'][$noROOMS]];
								}
								
								if(isset($_GET['markup']) && !empty($_GET['markup'])){
                                    	$addMarkupPrice = (($_GET['markup'] / 100) * $Total_price);
									
									    $Total_price = $Total_price +  $addMarkupPrice;
                                }
							        $Total_price = $currecny_price * $Total_price;
									
									$RoomTypeCode = $values['RoomCombination']['rooomcodes'];
									
							?>
                            
                            <tr class="tboholidays{{$values['RoomCombination']['index'][$noROOMS]}} tboholidays hotellists{{$run}}" data-romm="{{base64_encode(json_encode($values['RoomCombination']['index']))}}" data-combi="{{$values['RoomCombination']['index'][$noROOMS]}}" >
                                
                                <td><h5>{{$RoomCombinationarray_Combination[0]['RoomTypeName'.$values['RoomCombination']['index'][$noROOMS]] }}</h5>
                                <!--<a href="">Room Facilities</a>-->
                                </td>
                                <td><a href="javascript:void(0)" class="Cancellationpoilcyajaxclick" data-id="" data-sub="TboHolidays" data-hotelid="<?php if(isset($_GET['hotelid1'])) { echo $_GET['hotelid1'];  } ?>" >Cancellation Policy</a></td>
                                 <td class="text-center">
                            	<div class="table-api-price">
                                    <p class="minpriceget" data-price="{{$Total_price}}"><?php if(isset($_GET['currency'])){ echo $_GET['currency']; }?> {{$Total_price}} </p>
                                </div>
                            </td>
                                  <td class="text-right">
                            	<a style="display:none;" class="btn btn-primary booknow{{$run}}" href="{{route('tboPayment')}}?hotelid=<?php echo $_GET['hotelid1']; ?>&resultindex=<?php echo $_GET['resultindex']; ?>&checkin=<?php echo $_GET['checkin']; ?>&checkout=<?php echo $_GET['checkout']; ?><?php echo $RoomTypeCode; ?>&norooms=<?php echo $_GET['norooms']; ?>&<?php echo $NumAdults; ?>& <?php if(!empty($_GET['bookingid'])){ ?>&bookingid=<?php echo $_GET['bookingid']; ?>  <?php }else{ ?><?php } ?><?php if(!empty($_GET['markup'])){ ?>&markup=<?php echo $_GET['markup']; ?>  <?php } ?><?php if(!empty($_GET['currency'])){ ?>&currency=<?php echo $_GET['currency']; ?>  <?php } ?> "> Book Now </a>
                            </td>
							</tr> 
                            
                            <?php ++$run; ?>
							@endforeach
                            <?php } ?>
							
						</tbody>
					</table>
                    <div class="poilcydetail poilcydetailchange"><h5 style=""> <img src="{{asset('img/throbber_13.gif')}}"/> <span>Loading...</span></h5></div>
                        </div>
                         <div class="spacebanner hotel-policy">
                        	<h2>Hotel Policy</h2>
                           <?php if(isset($_GET['hotelid1']) && empty($_GET['hotelid'])){ ?>
			
			<p>{{$hotel_Info_tbo['Description']}}</p>
			<?php
			} else{ ?>
				<p>{{$hotel_Info->Description}}</p>
                <?php } ?>
                        </div>
                    </div>
                
                
    </div>
                
                
                </div>
            </div>
        </div>
        
        
        
        
		
		<!--<div class="list-filters-and-lists clear">
			
			
			<div class="list-filters">
				<div class="back-to-liat">
					<a href="#">
						<i class="fas fa-long-arrow-alt-left"></i>
					Back to List </a>
				</div>
				
				<div class="m-portlet">  
					
					<div class="modify-search positionrelative">
						<h5>FIlter By</h5><i class="la la-close closefiltericon"></i>
									<!--,<i class="fas fa-angle-down"></i>
										<i class="fas fa-angle-up"></i>
									</div>
									
									<div class="m-portlet__body">  
										<div class="m-accordion m-accordion--default m-accordion--toggle-arrow" id="m_accordion_6" role="tablist"> 
											<!--begin::Item-->              
               <?php /*?>     <div class="m-accordion__item m-accordion__item--info ">
                        <div class="m-accordion__item-head" role="tab" id="m_accordion_6_item_1_head" data-toggle="collapse" href="#m_accordion_6_item_1_body" aria-expanded="true">
                            
                            <span class="m-accordion__item-title">Filter by Price</span>
                                 
                            <span class="m-accordion__item-mode"></span>     
                        </div>

                        <div class="m-accordion__item-body collapse show" id="m_accordion_6_item_1_body" role="tabpanel" aria-labelledby="m_accordion_6_item_1_head" data-parent="#m_accordion_6" style=""> 
                            <div class="m-accordion__item-content">
                                <p>
                                   <!--<input type="text" class="form-control" placeholder="Hotel Name"/>-->
                                   
                                   
                                </p>
                            </div>
                        </div>
                        </div><?php */?>
                        <!--end::Ite
                        <!--begin::Item-
                        <div class="m-accordion__item m-accordion__item--brand">
                        	<div class="m-accordion__item-head collapsed" role="tab" id="m_accordion_6_item_2_head" data-toggle="collapse" href="#m_accordion_6_item_2_body" aria-expanded="false">
                        		
                        		<span class="m-accordion__item-title">Star rating</span>
                        		
                        		<span class="m-accordion__item-mode"></span>     
                        	</div>

                        	<div class="m-accordion__item-body collapse" id="m_accordion_6_item_2_body" role="tabpanel" aria-labelledby="m_accordion_6_item_2_head" data-parent="#m_accordion_6" style=""> 
                        		<div class="m-accordion__item-content">
                        			<p>
                        				<div class="star-checkbox">
                        					<div class="star-one">
                        						<label class="m-checkbox m-checkbox--solid m-checkbox--success">
                        							<input type="checkbox" id="5star" class="star" > 
                        							<div class="star-star">
                        								<i class="fas fa-star"></i>
                        								<i class="fas fa-star"></i>
                        								<i class="fas fa-star"></i>
                        								<i class="fas fa-star"></i>
                        								<i class="fas fa-star"></i>
                        							</div>
                        							<span></span>
                        						</label>
                        					</div>
                        					<div class="star-one">
                        						<label class="m-checkbox m-checkbox--solid m-checkbox--success">
                        							<input type="checkbox" id="4star" class="star"> 
                        							<div class="star-star">
                        								<i class="fas fa-star"></i>
                        								<i class="fas fa-star"></i>
                        								<i class="fas fa-star"></i>
                        								<i class="fas fa-star"></i>
                        							</div>
                        							<span></span>
                        						</label>
                        					</div>
                        					<div class="star-one">
                        						<label class="m-checkbox m-checkbox--solid m-checkbox--success" >
                        							<input type="checkbox" id="3star" class="star"> 
                        							<div class="star-star">
                        								<i class="fas fa-star"></i>
                        								<i class="fas fa-star"></i>
                        								<i class="fas fa-star"></i>
                        							</div>
                        							<span></span>
                        						</label>
                        					</div>
                        					<div class="star-one">
                        						<label class="m-checkbox m-checkbox--solid m-checkbox--success" >
                        							<input type="checkbox" id="2star" class="star"> 
                        							<div class="star-star">
                        								<i class="fas fa-star"></i>
                        								<i class="fas fa-star"></i>
                        							</div>
                        							<span></span>
                        						</label>
                        					</div>
                        					<div class="star-one" >
                        						<label class="m-checkbox m-checkbox--solid m-checkbox--success" >
                        							<input type="checkbox" id="1star" class="star"> 
                        							<div class="star-star">
                        								<i class="fas fa-star"></i>
                        							</div>
                        							<span></span>
                        						</label>
                        					</div>
                        				</div>
                        			</p>
                        		</div>
                        	</div>
                        </div>   
                        <!--end::Item

                        <!--begin::Item
                        <div class="m-accordion__item m-accordion__item--brand">
                        	<div class="m-accordion__item-head collapsed" role="tab" id="m_accordion_8_item_3_head" data-toggle="collapse" href="#m_accordion_6_item_3_body" aria-expanded="false">
                        		
                        		<span class="m-accordion__item-title">Price</span>
                        		
                        		<span class="m-accordion__item-mode"></span>     
                        	</div>

                        	<div class="m-accordion__item-body collapse" id="m_accordion_6_item_3_body" role="tabpanel" aria-labelledby="m_accordion_6_item_3_head" data-parent="#m_accordion_6" style=""> 
                        		<div class="m-accordion__item-content">
                        			<div class="form-group m-form__group row">
                        				
                        				<div class="col-lg-12 col-md-12 col-sm-12">
                        					<div class="m-ion-range-slider">
                        						<input type="hidden" id="m_slider_3"/>
                        					</div>
                        					
                        				</div>
                        			</div>
                        		</div>
                        	</div>                       
                        </div>
                        <!--end::Item

                    </div>
                </div>
                
                
            </div>
        </div>
        
        
        
        <div class="list-lists">
        	<div class="m-portlet m-portlet--tabs">
        		<div class="m-portlet__head">
        			<div class="m-portlet__head-tools">
        				<div class="list-sorting">
        					<ul class="nav nav-pills nav-pills--brand m-nav-pills--btn-pill m-nav-pills--btn-sm" role="tablist">
        						<li class="nav-item m-tabs__item lowprcie ">
        							<a class="nav-link m-tabs__link active show sortingTab" data-toggle="tab" href="#m_portlet_base_demo_1_tab_content" role="tab" aria-selected="true">
        								<i class="fa fa-dollar"></i> Price
        							</a>
        						</li>
        						<!--<li>Recommended</li>
        						<li class="nav-item m-tabs__item lowstar ">
        							<a class="nav-link m-tabs__link starTabnew" data-toggle="tab" href="#m_portlet_base_demo_1_tab_content" role="tab" aria-selected="true">
        								<i class="fa fa-star-o"></i> Star Rating
        							</a>
        						</li>
        					</ul>
        				</div>
        			</div>
        		</div>  
        		
        		
        		<div class="m-portlet__body">
        			<div class="tab-content">
        				<div class="list-wrap">
        					<ul class="ajaxhotellist">
                            <?php
						   /*  echo '<pre>';
							print_r($hotel_list_xml->Body->Error->ErrorText);
							echo '</pre>';*/
							?>
                            @if(isset($hotel_list_xml->Body->Error->ErrorText))
                            
                            <li class="hotellist-result noresult">
        							<div class="list-wrap-contents clear">
        								
        								<div class="list-wrap-two">
        									
        									<div class="hotel-address noresult-data">
        										{{$hotel_list_xml->Body->Error->ErrorText}}
        									</div>
        									
        								</div>
        								
        							</div>
        							
        						</li>
                            
                            
                            @endif
                              
                              
                              <?php 
							  
							  
							 /* echo '<pre>';
							  print_r($hotel_tbolist_xml);
							  echo '</pre>';
							  */
							  
							  $tbohotelholiday = array();
							  $tbohotelholiday_c = array();
							  $tbohotelholiday_array = array(); 
							 /* echo '<pre>';
									print_r($hotel_tbolist_xml);
									echo '</pre>'; 
									exit;*/
								$starrating = '';	
							if(!empty($hotel_tbolist_xml['HotelResultList']['HotelResult'])){
								
								foreach($hotel_tbolist_xml['HotelResultList']['HotelResult'] as $roomvalues){
									
									if($roomvalues['HotelInfo']['Rating'] == 'FourStar'){  $starrating = 4;  }
									if($roomvalues['HotelInfo']['Rating'] == 'FiveStar'){  $starrating = 5;  }
									if($roomvalues['HotelInfo']['Rating'] == 'ThreeStar'){  $starrating = 3;  }
									if($roomvalues['HotelInfo']['Rating'] == 'TwoStar'){  $starrating = 2;  } 
									if($roomvalues['HotelInfo']['Rating'] == 'OneStar'){  $starrating = 1;  } 
									
									$HotelName = str_replace(' ','',$roomvalues['HotelInfo']['HotelName']);
									$tbohotelholiday_array[$HotelName] = $HotelName;
									$HotelName = str_replace(' ','',$roomvalues['HotelInfo']['HotelName']);
//									print_r(str_replace(' ','',$roomvalues['HotelInfo']['HotelName']));
									$tbohotelholiday[$roomvalues['HotelInfo']['HotelCode']]['code'] = $roomvalues['HotelInfo']['HotelCode'];
									$tbohotelholiday[$HotelName]['codes'] = $roomvalues['HotelInfo']['HotelCode'];
									$tbohotelholiday[$HotelName]['ResultIndexs'] = $roomvalues['ResultIndex'];
									$tbohotelholiday[$roomvalues['HotelInfo']['HotelCode']]['ResultIndex'] = $roomvalues['ResultIndex'];
									$tbohotelholiday[$roomvalues['HotelInfo']['HotelCode']]['HotelPicture'] = $roomvalues['HotelInfo']['HotelPicture'];
									$tbohotelholiday[$roomvalues['HotelInfo']['HotelCode']]['HotelAddress'] = $roomvalues['HotelInfo']['HotelAddress'];
									$tbohotelholiday[$roomvalues['HotelInfo']['HotelCode']]['TripAdvisorRating'] = $starrating;
									$attr = '@attributes';
									$tbohotelholiday[$roomvalues['HotelInfo']['HotelCode']]['MinHotelPrice'] = $roomvalues['MinHotelPrice'][$attr]['OriginalPrice'];
								
								
								}
								
								
				
							}
							
					         $tbohotelholiday_d = array();
							  ?>
                           
                              
                            @if(isset($hotel_list_xml->Body->Hotels->Hotel))
        						@foreach($hotel_list_xml->Body->Hotels->Hotel as $hotel_list)
                                <?php
								//echo $hotel_detail_mark_up;
								//echo $hotel_list->Options->Option->TotalPrice;
								$HotelName = str_replace(' ','',$hotel_list->HotelName);
								$tboholidayCode = '';
                              foreach($tbohotelholiday_array as $tbohotelholiday_hotelname){
								  
								  
								  
								  
					             $tbohotelholiday_c[$tbohotelholiday[$tbohotelholiday_hotelname]['codes']] = 2;
								  
								 similar_text($tbohotelholiday_hotelname, $HotelName, $percent);
								if($tbohotelholiday_c[$tbohotelholiday[$tbohotelholiday_hotelname]['codes']] !=''){
								  
								  if($percent>87){  
						               $tbohotelholiday_c[$tbohotelholiday[$tbohotelholiday_hotelname]['codes']] = 1;
								       $tboholidayCode = '&hotelid1='.$tbohotelholiday[$tbohotelholiday_hotelname]['codes'].'&resultindex='.$tbohotelholiday[$tbohotelholiday_hotelname]['ResultIndexs'];
								  
								  }
							  }
							  }
								
								if(isset($hotel_detail_mark_up)){
								$markup_price = $hotel_list->Options->Option->TotalPrice % 100;
									$new_width = ($hotel_detail_mark_up / 100) * $hotel_list->Options->Option->TotalPrice;
								   $Total_price = $hotel_list->Options->Option->TotalPrice + $new_width;
								}else{
								$Total_price = $hotel_list->Options->Option->TotalPrice;
								}
									
								 
								   //echo $hotel_list->Options->Option->TotalPrice;
								   
								   
								 ?>
        						<li class="hotellist-result hotellist{{$hotel_list->HotelId}}" data-hotelid="{{$hotel_list->HotelId}}" data-star="{{round($hotel_list->StarRating)}}" data-price="{{$Total_price}}">
        							<div class="list-wrap-contents clear">
        								<div class="list-wrap-one">
        									<img src="{{$hotel_detail_xml['_'.$hotel_list->HotelId]->Images->Image[0]}}" alt="htel-images">	
        								</div>
        								<div class="list-wrap-two">
        									<a href="{{$datail_page_url}}{{$hotel_detail_url}}&hotelid={{$hotel_list->HotelId}}{{$tboholidayCode}}&cityid={{$_GET['cityid']}}&currency={{$hotel_list_xml->Body->Currency}}&Nationality={{$hotel_list_xml->Body->Nationality}}">{{$hotel_list->HotelName}}</a>
        									<div class="hotel-address">
        										{{$hotel_detail_xml['_'.$hotel_list->HotelId]->Address}}
        									</div>
        									<div class="star-star">
        										@for($i=1;$i<=5;$i++)  
        										@if(round($hotel_list->StarRating)  >= $i)
        										<i class="fas fa-star"></i>	
        										@endif	
        										@endfor
        									</div>
        								</div>
        								<div class="list-wrap-three">
        									<div class="price">
        										$ {{$Total_price}}
        									</div>
        									<i>Per Night</i>
        								</div>
                                        
        							</div>
        							
        						</li>
        						@endforeach
                                 @endif
                                 
                                 <?php 
								 
								/* echo '<pre>';
								 print_r($hotel_tbolist_xml);
								 echo '<pre>';*/
								 
								
								 
								 if(isset($_GET['test1'])){
									 
									 echo '<pre>';
								 print_r($hotel_tbolist_xml);
								 echo '<pre>';
									 
								 }
								 
								 
								 
								 ?>
                               
        					</ul>
        			</div>
        		</div>
        	</div>
        </div>
    </div> 
    
</div>
<!--End::Section-->

<!--End::Section-->

<div class="modal modalviewmore fade show modelshow poilcydetailresult" id="m_modal_6 popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">

       <div class="modal-body">
       <div class="poilcydetail">
       
       <h5 style="">Loading...</h5>
       
       
                </div>
                        </div>
  
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="closeurl">×</span>
        </button>
  
      </div>
      
 
 <div class="modalviewmorebody">
 
 </div>

    </div>
  </div>


</div>
       <!-- <div class="custom-lightbox">
        	<div class="custom-lightbox-content">
             <div class="custom-l-close">
             	<span aria-hidden="true" class="closeurl">×</span>
             </div>
             <div class="poilcydetail"><div><h5 class="cancellationheading">Free Cancellation Deadline:2018-10-19</h5><div class="alert-message_alter"><h5>Chargable cancellation Date</h5><div class=""><span>1</span> If you will cancel the booking before  <b>2018-10-20</b> then you should  pay  <b<100% <="" b=""> penalty for this booking.</b<100%></div><div class=""><span>2</span> If you will cancel the booking before  <b>2018-12-31</b> then you should  pay  <b<100% <="" b=""> penalty for this booking.</b<100%></div></div><div class="alert-message alert-message_alter"><h5>Cancel Message</h5><p><span>1</span> : Children 0-18 year(s) must use an extra bed. Guests 19 years and older are considered adults.</p><p><span>2</span> : Please note that for customers booking the ‘Breakfast, Internet and Airport Transfers’ packages only. The airport transfer is provided via hotel shuttle bus, which runs on a schedule. For further information and arrangements contact hotel directly.,Please note that any changes in tax structure due to government policies will result in revised taxes, which will be applicable to all reservations and will be charged additionally during check out.</p></div></div></div>
            	
            </div>
        </div> -->
          
	<style>
	.loading-circle-overlay {
    background: rgba(0,0,0,0.8);
    position: fixed;
    top: 0px;
    width: 100%;
    height: 100%;
    z-index: 9999999;
}
	</style>
    <div class="full-loader loading-circle-overlay" style="display:none">
              <div class="preLoader" style="text-align: center;color: #000; margin-top: 200px;">
    <p class="loaderImg loading-path-guide-content border-radius"><strong>Updating your results</strong><br>
      <img src="img/loading_blue.gif" alt=""></p>
  </div>
</div>
    
      
		
		<script type="text/javascript">
			var hotelajax = "{{ URL::to('/ajaxhotellist')}}";
			
			
			var Cancellationpoilcyajax = "{{ URL::to('/Cancellationpoilcyajax')}}";
			var updateDetailajax = "{{ URL::to('/updateDetailajax')}}";
			$(document).ready(function(){
				
				
				window.onload=function(){
					
					hotelroomprice(1);
      // Run code
                     };
				
				
	
				
	
				
				var fruits = [];
 $('.minpriceget').each(function(){
  var room_parti_id =  $(this).data('price');
  //console.log(room_parti_id);
  fruits.push(room_parti_id);

 });
 
 var min_vlaue = Math.min.apply(Math,fruits);
 var min_curreny = $('#currecny').val();
 
 $('.bestpricec').html(min_curreny+' '+addCommas(min_vlaue));
				$(document).on('click', '.closeurl', function(){
				
				$('.poilcydetailresult').hide();
				$('.poilcydetail').html('<h5 style="">Loading...</h5>');
				});
		//ajax
		$(document).on('click', '.Cancellationpoilcyajaxclick', function(){
			
			var optionId = $(this).data('id');
			var subid = $(this).data('sub');
			var hotelid = $(this).data('hotelid');
			$('.poilcydetailresult').show();
		var Cancellationpoilcyajaxurl = 'optionId='+optionId+'&sub='+subid+'&hotelid='+hotelid; 
		
		$.ajax({
			type: "GET",
			url: Cancellationpoilcyajax,
			data: Cancellationpoilcyajaxurl,
			cache: false,
			success: function(data){
				
				$('.poilcydetail').html(data);
				
				}
		});
		});		
				
				
				
				
				
				
			$(document).on('click', '.responsivefilter', function(){
		$('.list-filters').addClass('showresponsivefilter');
		
	});
	
	$(document).on('click', '.closefiltericon', function(){
		$('.list-filters').removeClass('showresponsivefilter');
		
		
	});	
				
		//
		ajaxjsonhoteljquery();
		
		$(window).scroll(function() {
        if($(window).scrollTop() + $(window).height() >= $(document).height()) {
           // console.log('hi');
		   $('.loader-list-loader').show();
		   ajaxjsonhoteljquery();
        }
    });	
				$(document).on('click', '.starTabnew', function(){
		//$('.starTab').removeClass('tabActive');
		  $(this).addClass('active');
		  $(this).addClass('show');
		  //$(this).removeClass('active');
		  //$('.sortingTab').removeClass('active');
		});
			
			
			
				
			// Mani
			$(document).on('click', '.sortingTab', function(){
				 $(this).addClass('active');
		  $(this).addClass('show');
		  //$(this).addClass('active');
		 // $(this).removeClass('active');
		  //$('.starTab').removeClass('active');
		});
	// End
	
	var starSort = 1;
	$(document).on('click', '.lowstar', function(){
		//$('.nearhotel').html('Nearest');
		if(starSort == 1){
			$('.hotellist-result').sort(function (a, b) {
				return $(a).data('star') - $(b).data('star');
			}).map(function () {
				return $(this).closest('.hotellist-result');
			}).each(function (_, container) {
				$(container).parent().append(container);
			});
			$(this).html('<a class="nav-link m-tabs__link starTabnew active show" data-toggle="tab" href="#m_portlet_base_demo_1_tab_content" role="tab" aria-selected="true"><i class="fa fa-star-o"></i> Star Rating</a>');
			$('#starsort').val(starSort);
			$('#pricesort').val(0);
			starSort = 2;
		} else {
			$('.hotellist-result').sort(function (a, b) {
				return $(b).data('star') - $(a).data('star');
			}).map(function () {
				return $(this).closest('.hotellist-result');
			}).each(function (_, container) {
				$(container).parent().append(container);
			});
			$(this).html('<a class="nav-link m-tabs__link starTabnew active show" data-toggle="tab" href="#m_portlet_base_demo_1_tab_content" role="tab" aria-selected="true"><i class="fa fa-star-o"></i> Star Rating</a>');
			$('#starsort').val(starSort);
			$('#pricesort').val(0);
			starSort = 1;
		}
		
	});	
	
			//sortin
			
			var priceSort = 1;
			$(document).on('click', '.lowprcie', function(){
		//$('.nearhotel').html('Nearest');
		if(priceSort == 1){
			$('.hotellist-result').sort(function (a, b) {
				return $(a).data('price') - $(b).data('price');
			}).map(function () {
				return $(this).closest('.hotellist-result');
			}).each(function (_, container) {
				$(container).parent().append(container);
			});
			$(this).html('<a class="nav-link m-tabs__link active show" data-toggle="tab" href="#m_portlet_base_demo_1_tab_content" role="tab"aria-selected="true"><i class="fa fa-dollar"></i> Price</a>');
			$('#pricesort').val(priceSort);
			$('#starsort').val(0);
			priceSort = 2;
		} else {
			$('.hotellist-result').sort(function (a, b) {
				return $(b).data('price') - $(a).data('price');
			}).map(function () {
				return $(this).closest('.hotellist-result');
			}).each(function (_, container) {
				$(container).parent().append(container);
			});
			$(this).html('<a class="nav-link m-tabs__link active show" data-toggle="tab" href="#m_portlet_base_demo_1_tab_content" role="tab"aria-selected="true"><i class="fa fa-dollar"></i> Price</a>');
			$('#pricesort').val(priceSort);
			$('#starsort').val(0);
			priceSort = 1;
			
		}
		
		
	});	
			
			
				//hotelajax();
			/*$(document).on('click', '.paginationnext', function() {
				
				var pagec = $('.paginationnext').data('pagec');
				console.log(pagec);
				var prevpag = parseInt(pagec) - parseInt(1);
				var nextpag = parseInt(pagec) + parseInt(1);
				
				$('.hotelapage'+prevpag).hide();
				$('.hotelapage'+pagec).show();
				$('.paginationnext').html('page'+nextpag);
				$('.paginationprev').html('page'+pagec);
				$('.paginationprev').show();
				$('.paginationnext').attr("data-pagec",+nextpag+1);
				$('.paginationprev').attr('data-pagec'+prevpag);
				
				 
				
			});*/
			
			
			
			$(document).on('change', '.star', function() {
				$('.full-loader').show();
				var maxrating = '';
				for(i=0;i<=5;i++){
					if($('#' + i + 'star').is(':checked')){
						maxrating = i;
						
					}
				}
				$('#maxstar').val(maxrating);
				var minrating = '';
				for(i=5;i>=0;i--){
					if($('#' + i + 'star').is(':checked')){
						minrating = i;
						
					}
				}
				
				$('#minstar').val(minrating);
            //$TIPlugin('#Mod_maxstar').val(maxrating);
            $('#maxstar').val(maxrating);
            $('#minstar').val(minrating);
            //$('.loder-edit').show();
            //ajaxjsonhotel();
			for(i=minrating;i<=maxrating;i++){
				
				$('#'+i+'star').prop('checked', true);
			}
            
            ajaxjsonhoteljquery_values();
			//hotelajax();
		});	
			
			
			
		});
		
		
		function hotelroompricenew(no){
	       var num = parseInt(no) + parseInt(1);
	      hotelroomprice(num); 
	 
       }
			
			function hotelroomprice(no){
				var romm = $('.hotellists'+no).data('romm');
				  			var thehref = '<?php echo $_SERVER['QUERY_STRING']; ?>&romm='+romm; 
		
						$.ajax({
							type: "GET",
							url: updateDetailajax,
							data: thehref,
							cache: false,
							success: function(data){
								$('.booknow'+no).show();
								$('.imageloder'+no).html('');
								hotelroompricenew(no);
								var obj = jQuery.parseJSON( data );
								$('.booknow')
								if(obj.value == 'false'){
								
								$('.hotellists'+no).hide();
								}
								
							
							}
						});
				
				
				  
				  
				  
				  
				  
				  
				  
				
	   
			}
			
			function ajaxjsonhoteljquery(){
		//console.log('hi');
		var thehref = '';
		var checkin = $('#checkin').val();
		var cityid = $('#cityid').val();
		
		var currencycode = $('#currencycode').val();
		var checkout = $('#checkout').val();
		var norooms = $('#norooms').val();
		var maxrating = $('#maxstar').val();
		var minrating = $('#minstar').val();
		var pageno = $('#pageno').val();
		var hotelname = '';
		var pricerangemin = $('#pricerangemin').val();
		var pricerangemax = $('#pricerangemax').val();
		var hotel_detail_url = $('#hotel_detail_url').val();
		hotel_detail_url
		linkadult ='norooms='+norooms;
		for(ro = 1; ro<=norooms; ro++){
			var noadult = $('#noadult'+ro).val();
			var nochild = $('#nochild'+ro).val();
			linkadult += '&adult'+ro+'='+noadult+'&child'+ro+'='+nochild;
			if(nochild){
				for(chi = 1; chi<=nochild; chi++){
					var nochildage = $('#nochildage'+ro+chi).val();
					linkadult +='&childage'+ro+''+chi+'='+nochildage;
				}
			}
		}

		return false;
		//$('.full-loader').show();
		var thehref = 'cityid='+cityid+'&longitude='+longitude+'&currencycode='+currencycode+'&checkin='+checkin+'&checkout='+checkout+'&'+linkadult+'&maxrating='+maxrating+'&minrating='+minrating+'&pricerangemin='+pricerangemin+'&pricerangemax='+pricerangemax+'&hotelname='+hotelname+'&pageno='+pageno+'&hotel_detail_url='+hotel_detail_url+'&cityid='+cityid; 
		
		$.ajax({
			type: "GET",
			url: hotelajax,
			data: thehref,
			cache: false,
			success: function(data){
				$('.ajaxhotellist').append(data);
				var pagenoadd = parseInt(pageno) + parseInt(10);
				$('#pageno').val(pagenoadd);
				var pricesort = $('#pricesort').val();
				var starsort = $('#starsort').val();
			  
			   if(pricesort == 1){
			    ajaxjsonhoteljquerysortlow(pricesort);
			   }
			   if(pricesort == 2){
			    ajaxjsonhoteljquerysorthigh(pricesort);
			   }
			   //star
			    if(starsort == 1){
			    ajaxjsonhoteljquerysortstarsortlow(starsort);
			   }
			   if(starsort == 2){
			    ajaxjsonhoteljquerysortstarsorthigh(starsort);
			   }
				ajaxjsonhoteljquery_values();
				$('.full-loader').hide();
				$('.loader-list-loader').hide();
			}
		});}
		
		function starjquery(minrating, maxrating, hotelid,hotelstar){
			var hotelid = 2;
			for(starvar = minrating; starvar <=maxrating; starvar++){
				if( hotelstar == starvar)
				{
					var hotelid = 1;	
				}
			}
			
			return hotelid;
			
		}
		
	function pricejquery(minprice, maxprice, hotelid, hotelprice){
	hotelid = 2;
	if(minprice<=hotelprice && hotelprice<=maxprice){
	
			  var hotelid = 1;	
		}
	
	return hotelid;
	
	}	

		
		function ajaxjsonhoteljquerysortlow(pricesort){
			
			$('.hotellist-result').sort(function (a, b) {
				return $(a).data('price') - $(b).data('price');
			}).map(function () {
				return $(this).closest('.hotellist-result');
			}).each(function (_, container) {
				$(container).parent().append(container);
			});
			$(this).html('<a class="nav-link m-tabs__link active show" data-toggle="tab" href="#m_portlet_base_demo_1_tab_content" role="tab"aria-selected="true"><i class="fa fa-dollar"></i> Price</a>');
		
		}
		function ajaxjsonhoteljquerysorthigh(pricesort){
			$('.hotellist-result').sort(function (a, b) {
				return $(b).data('price') - $(a).data('price');
			}).map(function () {
				return $(this).closest('.hotellist-result');
			}).each(function (_, container) {
				$(container).parent().append(container);
			});
			$(this).html('<a class="nav-link m-tabs__link active show" data-toggle="tab" href="#m_portlet_base_demo_1_tab_content" role="tab"aria-selected="true"><i class="fa fa-dollar"></i> Price</a>');
		}
		

				
		function ajaxjsonhoteljquerysortstarsortlow(pricesort){
			$('.hotellist-result').sort(function (a, b) {
				return $(a).data('star') - $(b).data('star');
			}).map(function () {
				return $(this).closest('.hotellist-result');
			}).each(function (_, container) {
				$(container).parent().append(container);
			});
			$(this).html('<a class="nav-link m-tabs__link" data-toggle="tab" href="#m_portlet_base_demo_1_tab_content" role="tab" aria-selected="true"><i class="fa fa-star-o"></i> Star Rating</a>');
		}
		
		function ajaxjsonhoteljquerysortstarsorthigh(pricesort){
			$('.hotellist-result').sort(function (a, b) {
				return $(b).data('star') - $(a).data('star');
			}).map(function () {
				return $(this).closest('.hotellist-result');
			}).each(function (_, container) {
				$(container).parent().append(container);
			});
			$(this).html('<a class="nav-link m-tabs__link" data-toggle="tab" href="#m_portlet_base_demo_1_tab_content" role="tab" aria-selected="true"><i class="fa fa-star-o"></i> Star Rating</a>');
		}		
				
		function ajaxjsonhoteljquery_values(){
				$('.full-loader').show(); 
		$('.hotellist-result').removeAttr( "style" );
		var maxrating = $('#maxstar').val();
		var minrating = $('#minstar').val();
	     var minprice = $('#pricerangemin').val();
		 var maxprice = $('#pricerangemax').val();
		
		
		var detailsurl = $('.detailsurl').val();
		$('.hotellist-result').each(function(){
		var hotelid = $(this).data('hotelid');
		$('.hotellist'+hotelid).not(':last').remove();
		if(maxprice && maxrating){
           var hotelstar = $(this).data('star');
			var hotelprice = $(this).data('price');
			var checkhidehotelid = pricejquery(minprice, maxprice, hotelid,hotelprice);
			if(checkhidehotelid == 1){
			var checkhidehotelid = starjquery(minrating, maxrating, hotelid,hotelstar);
			}
			if(checkhidehotelid == 2){
			$('.hotellist'+hotelid).hide();
			}else if(checkhidehotelid == 1){
			$('.hotellist'+hotelid).show();
			}			
		}else if(maxprice){
			var hotelprice = $(this).data('price');
			var checkhidehotelid = pricejquery(minprice, maxprice, hotelid,hotelprice);
			if(checkhidehotelid == 2){
			$('.hotellist'+hotelid).hide();
			}else if(checkhidehotelid == 1){
			$('.hotellist'+hotelid).show();
			}
			
			
		}else if(maxrating){
			var hotelstar = $(this).data('star');
			var checkhidehotelid = starjquery(minrating, maxrating, hotelid,hotelstar);
			if(checkhidehotelid == 2){
			$('.hotellist'+hotelid).hide();
			}else if(checkhidehotelid == 1){
			$('.hotellist'+hotelid).show();
			}
		}
			});
			$('.full-loader').hide();
		}
		//star
		
	function starjquery(minrating, maxrating, hotelid,hotelstar){
	var hotelid = 2;
	for(starvar = minrating; starvar <=maxrating; starvar++){
	if( hotelstar == starvar)
	{
	  var hotelid = 1;	
	}
	}
	
	return hotelid;
	
	}
		
		
	</script>
    
    <script>
								var homesearchurl = "{{ URL::to('/homesearch')}}";

//homwsearch autocomplete
$(".Destination" ).autocomplete({
	minLength: 3,
	source: function( request, response ) {
		$.ajax({
			url: homesearchurl,
			type: 'GET',
			dataType: "json",
			data: {search: request.term},
			success: function( data ) {
				response(data);
				
			}
		});
	},
	select: function (event, ui) 
	{
		
	  //document.getElementById('#Destinationclass').value = ui.item.Destination;
	  
	  $('#showresule').val(ui.item.value);;
	 // display the selected text
		   $('#cityid').val(ui.item.cityid); // save selected id to input
		   return false;
		}
	});





//Autocomplete Detapicker Start
$( ".checkinorlando" ).datepicker({
	defaultDate: +1,        
	dateFormat: 'YY-mm-dd',
	minDate: new Date() ,     
	onSelect: function(dateText, inst) {
		if($('.checkoutorlando').val() == '') {
			var current_date = $.datepicker.parseDate('YY-mm-dd', dateText);
			current_date.setDate(current_date.getDate()+1);
			$('.checkoutorlando').datepicker('setDate', current_date);
		}
	},
	onClose: function(selectedDate, test) {
		if(selectedDate != ""){
			var $date = new Date($( ".checkinorlando" ).datepicker( "getDate" ));
			$date.setDate($date.getDate()+1);

			$( ".checkoutorlando" ).datepicker( "option", "minDate", $date );
			$( ".checkoutorlando" ).datepicker('setDate', $date);

			var $minusDate = new Date($( ".checkinorlando" ).datepicker( "getDate" ));
			$minusDate.setDate($minusDate.getDate()-1);
			var maxDate = new Date($minusDate);
			maxDate.setMonth(maxDate.getMonth()+ 2);
			$( ".checkoutorlando" ).focus();
		}            
	}

});
$( ".checkoutorlando" ).datepicker({
	dateFormat: 'YY-mm-dd',
	beforeShow: function(input, inst) {
	},
	minDate: new Date(),
	onClose: function( selectedDate ) {
		if(selectedDate != ""){
		}
	}
});


//Autocomplete Detapicker End


  // Destination and checkin,checkout validation
  $(document).on('click', '#home_btnsubmit', function(e){
  	var counter = 0;
  	$(".required").each(function() {
  		if ($(this).val() === "") {
			e.preventDefault(); // stops the default action of an element
			//console.log(e.preventDefault());
			$(this).css('border','1px solid #ff1400');
			counter++;
		}else { $(this).css('border','2px solid #dadde2'); }
	});
	
	
	var norooms = $('#norooms').val();
	//alert(norooms);
	  for(nr=1;nr<=norooms;nr++)
	  {
		var nochild = $('#nochild'+nr).val();
		
		if(nochild){
			for(cr=1;cr<=nochild;cr++){
			var value = $('.nochildageclassva11').val();
				// alert(value);
				 if($('.nochildageclassva'+nr+cr).val() == 0){
				 $('.nochildageclassva'+nr+cr).css('border','1px solid #ff1400');
				 var counter = 1;
				 }else{
				 $('.nochildageclassva'+nr+cr).css('border','2px solid #dadde2');
				 }
				
			}
		}
		  
	  }
	
	
	
  	if(counter == 0){
  		$('#hotelserch').submit(); 
		 //alert('form is submitrd');//that is form id "#formid"
		} else {
			$('.required').each(function(){
				if($(this).val() == ''){
					this.focus();
					return false;
				}
			});
		}
	});
	
//no of child	
$(document).on('change', '.nochild', function(){
		
		var addchild = $(this).val(); 
		
		var Proom = $(this).data('room');
		
		for(p=1;p<=addchild;p++){
		///$('.searchroomlist'+Proom).show();
		$('.nochildageclass'+Proom+p).show();
	}
	
	for (n=3; n>addchild; n--) {
		$('.nochildageclass'+Proom+n).hide();
	}
	
	
	
});


	$(document).on('click', '.checkinorlando', function(){
		
		
		$('.dropdown-menu').hide();
		
	});
	
	$(document).on('click', '.checkoutorlando', function(){
		
		
		$('.dropdown-menu').hide();
		
	});
	$(document).on('click', '.Addrooms', function(){
		//Add Rooms
		
		var room =$('#addmaxroom').val();
		$('#norooms').val(room);
		//alert(room);
		$('.searchroomlist'+room).show();
		var addroom = parseInt(room) + parseInt(1);
		$('#addmaxroom').val(addroom);
		$('#removeminroom').val(room);
		$('.delaterooms').show();
		
		if(room == 5){
			$('.Addrooms').hide();
		}
		
		
	});
	

	
	
	$(document).on('click', '.delaterooms', function(){
		//Add Rooms
		
		var room =$('#removeminroom').val();
		//alert(room);
		$('.searchroomlist'+room).hide();
		var removeroom = parseInt(room) - parseInt(1);
		$('#addmaxroom').val(room);
		$('#removeminroom').val(removeroom);
		var totalrooms = parseInt(removeroom) - parseInt(1);
		$('#norooms').val(removeroom);
		//$('.delaterooms').show();
		$('.Addrooms').show();
		//min if room check
		
		if(room == 2){
			$('.delaterooms').hide();
		}else{
			$('.delaterooms').show();
			
		}
		
	});
	
	$(document).on('click', '.modifyeaarchicon', function(e){
		
		$('.user-content-search').toggle();
		
	});

	function addCommas(x) {
    var parts = x.toString().split(".");
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return parts.join(".");
}
	

</script>

    
	
	@endsection
    
   <style>
        /* jssor slider loading skin spin css */
        .jssorl-009-spin img {
            animation-name: jssorl-009-spin;
            animation-duration: 1.6s;
            animation-iteration-count: infinite;
            animation-timing-function: linear;
        }

        @keyframes jssorl-009-spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }


        .jssorb051 .i {position:absolute;cursor:pointer;}
        .jssorb051 .i .b {fill:#fff;fill-opacity:0.5;}
        .jssorb051 .i:hover .b {fill-opacity:.7;}
        .jssorb051 .iav .b {fill-opacity: 1;}
        .jssorb051 .i.idn {opacity:.3;}

        .jssora051 {display:block;position:absolute;cursor:pointer;}
        .jssora051 .a {fill:none;stroke:#fff;stroke-width:360;stroke-miterlimit:10;}
        .jssora051:hover {opacity:.8;}
        .jssora051.jssora051dn {opacity:.5;}
        .jssora051.jssora051ds {opacity:.3;pointer-events:none;}
    </style> 
    



