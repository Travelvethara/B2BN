@extends('layouts.app')

@section('content')
<?php 





$datail_page_url = route('hoteldetail');

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


$starArray = array();


if(isset($_GET['minstar']) && isset($_GET['maxstar'])){
	
	for($ti=$_GET['minstar'];$ti<=$_GET['maxstar']; $ti++){
		
		$starArray[$ti] = $ti; 
		
	}
	
}



///room adult and child get


$noadultSearch = 0;
$nochildSearch = 0;


   for($roomv=1;$roomv<=$_GET['norooms'];$roomv++){

		   
	   $noadultSearch += $_GET['adult'.$roomv];

		   
	   $nochildSearch += $_GET['child'.$roomv];
	  
	   
	   
   }
   
 //night calculation
 
if(isset($_GET['checkin'])){ 
$date1=date_create($_GET['checkin']);
$date2=date_create($_GET['checkout']);
$diff=date_diff($date1,$date2);
$daycount = $diff->days;

$date_from = $_GET['checkin'];   
$date_from = strtotime($date_from); // Convert date to a UNIX timestamp  
$date_to = $_GET['checkout'];  
$date_to = strtotime($date_to); // Convert date to a UNIX timestamp  

$finalday = $daycount;

//echo $finalday;
  
}



								

?>

<style>
.loading-circle-overlaynew {
    background: rgba(0,0,0,0.8);
    position: fixed;
    top: 0px;
    width: 100%;
    height: 100%;
    z-index: 9999999;
}


</style>


		<div class="loader-fixed" >
	      <img src="img/ldr.gif" />
         </div>
	
<link rel="stylesheet" href="https://code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">

  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
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

        <div class="list-of-hotels-and-filters roboto">
        	<div class="list-od-dest">
            <div class="closefiltericon">
            <i class="fa fa-close"></i>
            </div>
            <span class="totalresultfound"> </span> Hotels Found in <?php echo $_GET['city']; ?> <a href="{{URL::to('hotelsearch')}}"> <i  class="fa fa-edit"></i></a><i class="responsivefilter fa fa-filter"></i>
            </div>
            <div class="list-od-filters">
            	
                <ul class="nav nav-pills nav-pills--brand m-nav-pills--btn-pill m-nav-pills--btn-sm" role="tablist">
        						<li class="nav-item m-tabs__item lowprcie ">

        						<a class="nav-link m-tabs__link active show" data-toggle="tab" href="#m_portlet_base_demo_1_tab_content" role="tab" aria-selected="true"><i class="fa fa-dollar"></i> 

        						<span class="spansixe">Price</span>
        						<img class="price_sort_icon" src="{{asset('img/si1.png')}}" /></a></li>

        						<!--<li>Recommended</li>-->
        						<li class="nav-item m-tabs__item lowstar "><a class="nav-link m-tabs__link starTabnew" data-toggle="tab" href="#m_portlet_base_demo_1_tab_content" role="tab" aria-selected="false"><i class="fa fa-star-o"></i> <span class="spansixe"> Star</span>  
        						<img class="star_sort_icon" src="{{asset('img/si2.png')}}" /></a></li>
        					</ul>
            </div>
            </div>
            
            <div class="search-for-results m-portlet">
            	<div class="search-for-results-block">
                	<label>Destination</label>
                    <p><?php if(isset($_GET['city'])) { echo $_GET['city']; } ?></p>
                </div>
                <div class="search-for-results-block">
                	<label>CheckIn Date</label>
                    <p><?php if(isset($_GET['checkin'])) { echo $_GET['checkin']; } ?></p>
                </div>
                <div class="search-for-results-block">
                	<label>CheckOut Date</label>
                    <p><?php if(isset($_GET['checkout'])) { echo $_GET['checkout']; } ?></p>
                </div>
                <div class="search-for-results-block">
                	<label>Nights</label>
                    <p><?php if(isset($finalday)) { echo $finalday; } ?></p>
                </div>
                <div class="search-for-results-block">
                	<label>Room</label>
                    <p><?php if(isset($_GET['norooms'])) { echo $_GET['norooms']; } ?></p>
                </div>
                 <div class="search-for-results-block">
                	<label>Adults</label>
                    <p>{{$noadultSearch}}</p>
                </div>
                 <div class="search-for-results-block">
                	<label>Children</label>
                    <p>{{$nochildSearch}}</p>
                </div>
                 <div class="search-for-results-block">
                	 <button type="button" class="btn btn-primary changesearchs" id="changesearch">Change Search</button>
                </div>
                 
            </div>
            
            <div class="modify-search-part">
            <form action="{{ route('hotellist') }}" method="get" id="hotelserch" class="hotelserchtarget" />
            	<div class="m-portlet m-portlet-padding user-info">
      <div class="row">
        <div class="col-md-6">
          <div class="form-group m-form__group">
            <label>Destination</label>
            <input type="text" class="form-control m-input Destination required ui-autocomplete-input" id="showresule" name="city" placeholder="Enter a location" autocomplete="off" value="<?php if(isset($_GET['city'])) { 	echo $_GET['city']; }  ?>">
            <input type="hidden" name="cityid" id="cityid" value="<?php if(isset($_GET['cityid'])) { 	echo $_GET['cityid']; }  ?>">
            <input type="hidden" name="cityname" id="cityname" value="<?php if(isset($_GET['cityname'])) { 	echo $_GET['cityname']; }  ?>"/>
          </div>
        </div>
        <div class="col-md-3 selectdatealter">
          <div class="form-group m-form__group positionrelative claendericon ">
            <div class="input-group" id="m_daterangepicker_1_validate"> 
              
            <!-- <input type='text' class="form-control m-input required" readonly  placeholder="Select date range"/>-->
              <label>Checkin Date</label>
              <input type="text" class="form-control required" id="m_datepicker_1" readonly="" placeholder="Select date" name="checkin" value="<?php if(isset($_GET['checkin'])) { 	echo $_GET['checkin']; }  ?>">
            </div>
            <span><i class="far fa-calendar-alt"></i></span> </div>
        </div>
        <div class="col-md-3 selectdatealter">
          <div class="form-group m-form__group positionrelative claendericon ">
            <div class="input-group" id="m_daterangepicker_1_validate"> 
              
           <!-- <input type='text' class="form-control m-input required" readonly  placeholder="Select date range"/> -->
              <label>CheckOut Date</label>
              <input type="text" class="form-control required" id="m_datepicker_2" readonly="" placeholder="Select date" name="checkout" value="<?php if(isset($_GET['checkout'])) { 	echo $_GET['checkout']; }  ?>">
            </div>
            <span><i class="far fa-calendar-alt"></i></span> </div>
        </div>
   <!-- <div class="col-md-2 ">
															<div class="form-group m-form__group positionrelative claendericon">
																<input type="text" class="form-control m-input checkoutorlando" id="checkoutorlando"  placeholder="Chack Out" name="checkout">
																<span><i class="far fa-calendar-alt"></i></span>
															</div>
														</div>
       <div class="col-md-2 ">
															<div class="form-group m-form__group no-days-block">
															<lable> <b>2</b> days </lable>
															</div>
														</div> -->
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group m-form__group">
            <label>Hotel Name</label>
            <input type="text" class="form-control PropertyName ui-autocomplete-input" placeholder="Enter any Hotel Name" name="hotelname" autocomplete="off" value="<?php if(isset($_GET['hotelname'])) { 	echo $_GET['hotelname']; }  ?>">
          </div>
        </div>
        <div class="col-md-2">
          <div class="form-group m-form__group">
            <label>Nationality</label>
            <select class="form-control m-input " name="nationaltly">
                            <option value="AF" >Afghanistan</option>
                            <option value="AX">Ã…land Islands</option>
                            <option value="AL">Albania</option>
                            <option value="DZ">Algeria</option>
                            <option value="AS">American Samoa</option>
                            <option value="AD">Andorra</option>
                            <option value="AO">Angola</option>
                            <option value="AI">Anguilla</option>
                            <option value="AQ">Antarctica</option>
                            <option value="AG">Antigua and Barbuda</option>
                            <option value="AR">Argentina</option>
                            <option value="AM">Armenia</option>
                            <option value="AW">Aruba</option>
                            <option value="AU">Australia</option>
                            <option value="AT">Austria</option>
                            <option value="AZ">Azerbaijan</option>
                            <option value="BS">Bahamas</option>
                            <option value="BH">Bahrain</option>
                            <option value="BD">Bangladesh</option>
                            <option value="BB">Barbados</option>
                            <option value="BY">Belarus</option>
                            <option value="BE">Belgium</option>
                            <option value="BZ">Belize</option>
                            <option value="BJ">Benin</option>
                            <option value="BM">Bermuda</option>
                            <option value="BT">Bhutan</option>
                            <option value="BO">Bolivia</option>
                            <option value="BQ">Bonaire</option>
                            <option value="BA">Bosnia and Herzegovina</option>
                            <option value="BW">Botswana</option>
                            <option value="BV">Bouvet Island</option>
                            <option value="BR">Brazil</option>
                            <option value="IO">British Indian Ocean Territory</option>
                            <option value="VG">British Virgin Islands</option>
                            <option value="BN">Brunei</option>
                            <option value="BG">Bulgaria</option>
                            <option value="BF">Burkina Faso</option>
                            <option value="BI">Burundi</option>
                            <option value="KH">Cambodia</option>
                            <option value="CM">Cameroon</option>
                            <option value="CA">Canada</option>
                            <option value="CV">Cape Verde</option>
                            <option value="KY">Cayman Islands</option>
                            <option value="CF">Central African Republic</option>
                            <option value="TD">Chad</option>
                            <option value="CL">Chile</option>
                            <option value="CN">China</option>
                            <option value="CX">Christmas Island</option>
                            <option value="CC">Cocos (Keeling) Islands</option>
                            <option value="CO">Colombia</option>
                            <option value="KM">Comoros</option>
                            <option value="CG">Congo</option>
                            <option value="CK">Cook Islands</option>
                            <option value="CR">Costa Rica</option>
                            <option value="CI">CÃ´te d'Ivoire</option>
                            <option value="HR">Croatia</option>
                            <option value="CU">Cuba</option>
                            <option value="CW">CuraÃ§ao</option>
                            <option value="CY">Cyprus</option>
                            <option value="CZ">Czech Republic</option>
                            <option value="CD">Democratic Republic of the Congo</option>
                            <option value="DK">Denmark</option>
                            <option value="DJ">Djibouti</option>
                            <option value="DM">Dominica</option>
                            <option value="DO">Dominican Republic</option>
                            <option value="EC">Ecuador</option>
                            <option value="EG">Egypt</option>
                            <option value="SV">El Salvador</option>
                            <option value="GQ">Equatorial Guinea</option>
                            <option value="ER">Eritrea</option>
                            <option value="EE">Estonia</option>
                            <option value="ET">Ethiopia</option>
                            <option value="FK">Falkland Islands (Malvinas)</option>
                            <option value="FO">Faroe Islands</option>
                            <option value="FJ">Fiji</option>
                            <option value="FI">Finland</option>
                            <option value="FR">France</option>
                            <option value="GF">French Guiana</option>
                            <option value="PF">French Polynesia</option>
                            <option value="TF">French Southern Territories</option>
                            <option value="GA">Gabon</option>
                            <option value="GM">Gambia</option>
                            <option value="GE">Georgia</option>
                            <option value="DE">Germany</option>
                            <option value="GH">Ghana</option>
                            <option value="GI">Gibraltar</option>
                            <option value="GR">Greece</option>
                            <option value="GL">Greenland</option>
                            <option value="GD">Grenada</option>
                            <option value="GP">Guadeloupe</option>
                            <option value="GU">Guam</option>
                            <option value="GT">Guatemala</option>
                            <option value="GG">Guernsey</option>
                            <option value="GN">Guinea</option>
                            <option value="GW">Guinea-Bissau</option>
                            <option value="GY">Guyana</option>
                            <option value="HT">Haiti</option>
                            <option value="HM">Heard Island and McDonald Islands</option>
                            <option value="VA">Holy See (Vatican City State)</option>
                            <option value="HN">Honduras</option>
                            <option value="HK">Hong Kong</option>
                            <option value="HU">Hungary</option>
                            <option value="IS">Iceland</option>
                            <option value="IN">India</option>
                            <option value="ID">Indonesia</option>
                            <option value="IR">Iran</option>
                            <option value="IQ">Iraq</option>
                            <option value="IE">Ireland</option>
                            <option value="IM">Isle of Man</option>
                            <option value="IL">Israel</option>
                            <option value="IT">Italy</option>
                            <option value="JM">Jamaica</option>
                            <option value="JP">Japan</option>
                            <option value="JE">Jersey</option>
                            <option value="JO">Jordan</option>
                            <option value="KZ">Kazakhstan</option>
                            <option value="KE">Kenya</option>
                            <option value="KI">Kiribati</option>
                            <option value="XK">Kosovo</option>
                            <option value="KW">Kuwait</option>
                            <option value="KG">Kyrgyzstan</option>
                            <option value="LA">Laos</option>
                            <option value="LV">Latvia</option>
                            <option value="LB">Lebanon</option>
                            <option value="LS">Lesotho</option>
                            <option value="LR">Liberia</option>
                            <option value="LY">Libya</option>
                            <option value="LI">Liechtenstein</option>
                            <option value="LT">Lithuania</option>
                            <option value="LU">Luxembourg</option>
                            <option value="MO">Macau</option>
                            <option value="MK">Macedonia</option>
                            <option value="MG">Madagascar</option>
                            <option value="MW">Malawi</option>
                            <option value="MY">Malaysia</option>
                            <option value="MV">Maldives</option>
                            <option value="ML">Mali</option>
                            <option value="MT">Malta</option>
                            <option value="MH">Marshall Islands</option>
                            <option value="MQ">Martinique</option>
                            <option value="MR">Mauritania</option>
                            <option value="MU">Mauritius</option>
                            <option value="YT">Mayotte</option>
                            <option value="MX">Mexico</option>
                            <option value="FM">Micronesia</option>
                            <option value="MD">Moldova</option>
                            <option value="MC">Monaco</option>
                            <option value="MN">Mongolia</option>
                            <option value="ME">Montenegro</option>
                            <option value="MS">Montserrat</option>
                            <option value="MA">Morocco</option>
                            <option value="MZ">Mozambique</option>
                            <option value="MM">Myanmar</option>
                            <option value="NA">Namibia</option>
                            <option value="NR">Nauru</option>
                            <option value="NP">Nepal</option>
                            <option value="NL">Netherlands</option>
                            <option value="AN">Netherlands Antilles</option>
                            <option value="NC">New Caledonia</option>
                            <option value="NZ">New Zealand</option>
                            <option value="NI">Nicaragua</option>
                            <option value="NE">Niger</option>
                            <option value="NG">Nigeria</option>
                            <option value="NU">Niue</option>
                            <option value="NF">Norfolk Island</option>
                            <option value="KP">North Korea</option>
                            <option value="MP">Northern Mariana Islands</option>
                            <option value="NO">Norway</option>
                            <option value="OM">Oman</option>
                            <option value="PK">Pakistan</option>
                            <option value="PW">Palau</option>
                            <option value="PS">Palestinian Territory</option>
                            <option value="PA">Panama</option>
                            <option value="PG">Papua New Guinea</option>
                            <option value="PY">Paraguay</option>
                            <option value="PE">Peru</option>
                            <option value="PH">Philippines</option>
                            <option value="PN">Pitcairn</option>
                            <option value="PL">Poland</option>
                            <option value="PT">Portugal</option>
                            <option value="PR">Puerto Rico</option>
                            <option value="QA">Qatar</option>
                            <option value="RE">RÃ©union</option>
                            <option value="RO">Romania</option>
                            <option value="RU">Russia</option>
                            <option value="RW">Rwanda</option>
                            <option value="BL">Saint BarthÃ©lemy</option>
                            <option value="SH">Saint Helena</option>
                            <option value="KN">Saint Kitts and Nevis</option>
                            <option value="LC">Saint Lucia</option>
                            <option value="MF">Saint Martin</option>
                            <option value="PM">Saint Pierre and Miquelon</option>
                            <option value="VC">Saint Vincent and the Grenadines</option>
                            <option value="WS">Samoa</option>
                            <option value="SM">San Marino</option>
                            <option value="ST">Sao Tome and Principe</option>
                            <option value="SA">Saudi Arabia</option>
                            <option value="SN">Senegal</option>
                            <option value="RS">Serbia</option>
                            <option value="SC">Seychelles</option>
                            <option value="SL">Sierra Leone</option>
                            <option value="SG">Singapore</option>
                            <option value="SK">Slovakia</option>
                            <option value="SI">Slovenia</option>
                            <option value="SB">Solomon Islands</option>
                            <option value="SO">Somalia</option>
                            <option value="ZA">South Africa</option>
                            <option value="GS">South Georgia and the South Sandwich Islands</option>
                            <option value="KR">South Korea</option>
                            <option value="SS">South Sudan</option>
                            <option value="ES">Spain</option>
                            <option value="LK">Sri Lanka</option>
                            <option value="SD">Sudan</option>
                            <option value="SR">Suriname</option>
                            <option value="SJ">Svalbard and Jan Mayen</option>
                            <option value="SZ">Swaziland</option>
                            <option value="SE">Sweden</option>
                            <option value="CH">Switzerland</option>
                            <option value="SY">Syria</option>
                            <option value="TW">Taiwan</option>
                            <option value="TJ">Tajikistan</option>
                            <option value="TZ">Tanzania</option>
                            <option value="TH">Thailand</option>
                            <option value="TL">Timor-Leste</option>
                            <option value="TG">Togo</option>
                            <option value="TK">Tokelau</option>
                            <option value="TO">Tonga</option>
                            <option value="TT">Trinidad and Tobago</option>
                            <option value="TN">Tunisia</option>
                            <option value="TR">Turkey</option>
                            <option value="TM">Turkmenistan</option>
                            <option value="TC">Turks and Caicos Islands</option>
                            <option value="TV">Tuvalu</option>
                            <option value="UG">Uganda</option>
                            <option value="UA">Ukraine</option>
                            <option value="AE">United Arab Emirates</option>
                            <option value="GB">United Kingdom</option>
                            <option value="US">United States</option>
                            <option value="UM">United States Minor Outlying Islands</option>
                            <option value="UY">Uruguay</option>
                            <option value="VI">US Virgin Islands</option>
                            <option value="UZ">Uzbekistan</option>
                            <option value="VU">Vanuatu</option>
                            <option value="VE">Venezuela</option>
                            <option value="VN">Vietnam</option>
                            <option value="WF">Wallis and Futuna</option>
                            <option value="EH">Western Sahara</option>
                            <option value="YE">Yemen</option>
                            <option value="ZM">Zambia</option>
                            <option value="ZW">Zimbabwe</option>
                          </select>
          </div>
        </div>
        <div class="col-md-2">
          <div class="form-group m-form__group">
            <label>Star Rating</label>
            <select class="form-control m-input starratingmodify" name="star">
              <option value="">--Select--</option>
              <option value="5" <?php if($_GET['star'] == '5') { ?> selected="selected" <?php  }  ?> >5</option>
              <option value="4" <?php if($_GET['star'] == '4') { ?> selected="selected" <?php  }  ?>>4</option>
              <option value="3" <?php if($_GET['star'] == '3') { ?> selected="selected" <?php  }  ?>>3</option>
              <option value="2" <?php if($_GET['star'] == '2') { ?> selected="selected" <?php  }  ?>>2</option>
              <option value="1" <?php if($_GET['star'] == '1') { ?> selected="selected" <?php  }  ?>>1</option>
            </select>
          </div>
          <input type="hidden" name="minstar" id="minstarmodify" value="">
          <input type="hidden" name="maxstar" id="maxstarmodify" value="">
        </div>
        <div class="col-md-2">
          <div class="form-group m-form__group">
            <label>Currency</label>
            <select class="form-control m-input " name="currency">
              <option value="USD" <?php if($_GET['currency'] == 'USD') { ?> selected="selected" <?php  }  ?>>USD</option>
              <option value="GBP" <?php if($_GET['currency'] == 'GBP') { ?> selected="selected" <?php  }  ?>>GBP</option>
              <option value="PKR" <?php if($_GET['currency'] == 'PKR') { ?> selected="selected" <?php  }  ?>>PKR</option>
              <option value="EUR" <?php if($_GET['currency'] == 'EUR') { ?> selected="selected" <?php  }  ?>>EUR</option>
              <option value="HKD" <?php if($_GET['currency'] == 'HKD') { ?> selected="selected" <?php  }  ?>>HKD</option>
            </select>
          </div>
        </div>
      </div>
      <input type="hidden" name="norooms" id="norooms" value="<?php if(isset($_GET['norooms'])) { echo $_GET['norooms']; } ?>"/>
       @for($i=1;$i<=5;$i++)
           
													<div class="row searchroomlist{{$i}}" <?php if($i>$_GET['norooms']) {?> style="display:none"; <?php } ?>>
														
														<div class="col-md-3" >
															<div class="form-group m-form__group">
																<select class="form-control m-input noadultclass{{$i}}" name="adult{{$i}}" id="noadult{{$i}}">
																	<option value="1" <?php if($_GET['adult'.$i] == 1){ ?> selected="selected" <?php  }?> >1 Adult</option>
																	<option value="2" <?php if($_GET['adult'.$i] == 2){ ?> selected="selected" <?php  }?>>2 Adults</option>
																	<option value="3" <?php if($_GET['adult'.$i] == 3){ ?> selected="selected" <?php  }?>>3 Adults</option>
																	<option value="4" <?php if($_GET['adult'.$i] == 4){ ?> selected="selected" <?php  }?>>4 Adults</option>
																	<option value="5" <?php if($_GET['adult'.$i] == 5){ ?> selected="selected" <?php  }?>>5 Adults</option>
																</select>
															</div>		
														</div>
														<div class="col-md-3">
															<div class="form-group m-form__group">
																<select class="form-control m-input nochildclass{{$i}} nochild" name="child{{$i}}" id="nochild{{$i}}" data-room="{{$i}}">
																	<option value="0" <?php if($_GET['child'.$i] == 0){ ?> selected="selected" <?php  }?>>Child</option>
																	<option value="1"  <?php if($_GET['child'.$i] == 1){ ?> selected="selected" <?php  }?>>1 Child</option>
																	<option value="2" <?php if($_GET['child'.$i] == 2){ ?> selected="selected" <?php  }?>>2 Child</option>
																	<option value="3" <?php if($_GET['child'.$i] == 3){ ?> selected="selected" <?php  }?>>3 Child</option>
																</select>
															</div>	
														</div>
														@for($c=1;$c<=3;$c++)
														<div class="col-md-2 nochildageclass{{$i}}{{$c}} childageperroom{{$i}} " <?php if($c>$_GET['child'.$i]) {?> style="display:none"; <?php } ?>>
															<div class="form-group m-form__group" >
																<select class="form-control m-input nochildageclassva{{$i}}{{$c}}" name="childage{{$i}}{{$c}}" id="nochildage{{$i}}{{$c}}">
																	<option value="0" <?php if($_GET['childage'.$i.$c] == 0){ ?> selected="selected" <?php  }?>>Age</option>
																	<option value="1" <?php if($_GET['childage'.$i.$c] == 1){ ?> selected="selected" <?php  }?>>1</option>
																	<option value="2" <?php if($_GET['childage'.$i.$c] == 2){ ?> selected="selected" <?php  }?>>2</option>
																	<option value="3" <?php if($_GET['childage'.$i.$c] == 3){ ?> selected="selected" <?php  }?>>3</option>
																	<option value="4" <?php if($_GET['childage'.$i.$c] == 4){ ?> selected="selected" <?php  }?>>4</option>
																	<option value="5" <?php if($_GET['childage'.$i.$c] == 5){ ?> selected="selected" <?php  }?>>5</option>
																	<option value="6" <?php if($_GET['childage'.$i.$c] == 6){ ?> selected="selected" <?php  }?>>6</option>
																	<option value="7" <?php if($_GET['childage'.$i.$c] == 7){ ?> selected="selected" <?php  }?>>7</option>
																	<option value="8" <?php if($_GET['childage'.$i.$c] == 8){ ?> selected="selected" <?php  }?>>8</option>
																	<option value="9" <?php if($_GET['childage'.$i.$c] == 9){ ?> selected="selected" <?php  }?>>9</option>
																	<option value="10" <?php if($_GET['childage'.$i.$c] == 10){ ?> selected="selected" <?php  }?>>10</option>
																	<option value="11" <?php if($_GET['childage'.$i.$c] == 11){ ?> selected="selected" <?php  }?>>11</option>
																	
																</select>
															</div>		
														</div>
														@endfor
													</div>
													@endfor
            
            <div class="row">
        <div class="col-md-3 Addrooms">
         <input type="hidden" id="addmaxroom" value="<?php if(isset($_GET['norooms'])) { echo $_GET['norooms']+1; }?>"/>
          <i class="fas fa-plus-square"></i> <b>Add rooms</b> </div>
        <div class="col-md-3 delaterooms">
         <input type="hidden" id="removeminroom" value="<?php if(isset($_GET['norooms'])) { echo $_GET['norooms']+1; }?>"/>
          <i class="fas fa-minus-square"></i> <b>Remove rooms</b> </div>
       
        
      </div>
      <div class="row">
      	  <div class="col-md-3">
          <div class="form-group m-form__group">
            <label>Mark Up</label>
             <input type="text" class="form-control m-input" onkeyup="numonly(this);" id="markup" placeholder="Enter a markup" name="markup" value="<?php if(isset($_GET['markup'])) { 	echo $_GET['markup']; }  ?>">
          </div>
        </div>
         <div class="col-md-3 nightsshowa">
          <div class="form-group m-form__group">
            <label>Nights</label>
            <select class="form-control m-input nights" name="nights">
                          <option value="1" <?php if($_GET['nights'] == '1') { ?> selected="selected" <?php  }  ?> >1</option>
            
                            <option value="2" <?php if($_GET['nights'] == '2') { ?> selected="selected" <?php  }  ?>>2</option>
            
                            <option value="3" <?php if($_GET['nights'] == '3') { ?> selected="selected" <?php  }  ?>>3</option>
            
                            <option value="4" <?php if($_GET['nights'] == '4') { ?> selected="selected" <?php  }  ?>>4</option>
            
                            <option value="5" <?php if($_GET['nights'] == '5') { ?> selected="selected" <?php  }  ?>>5</option>
            
                            <option value="6" <?php if($_GET['nights'] == '6') { ?> selected="selected" <?php  }  ?>>6</option>
            
                            <option value="7" <?php if($_GET['nights'] == '7') { ?> selected="selected" <?php  }  ?>>7</option>
            
                            <option value="8" <?php if($_GET['nights'] == '8') { ?> selected="selected" <?php  }  ?>>8</option>
            
                            <option value="9" <?php if($_GET['nights'] == '9') { ?> selected="selected" <?php  }  ?>>9</option>
            
                            <option value="10" <?php if($_GET['nights'] == '10') { ?> selected="selected" <?php  }  ?>>10</option>
            
                            <option value="11" <?php if($_GET['nights'] == '11') { ?> selected="selected" <?php  }  ?>>11</option>
            
                            <option value="12" <?php if($_GET['nights'] == '12') { ?> selected="selected" <?php  }  ?>>12</option>
            
                            <option value="13" <?php if($_GET['nights'] == '13') { ?> selected="selected" <?php  }  ?>>13</option>
            
                            <option value="14" <?php if($_GET['nights'] == '14') { ?> selected="selected" <?php  }  ?> >14</option>
            
                            <option value="15" <?php if($_GET['nights'] == '15') { ?> selected="selected" <?php  }  ?>>15</option>
            
                            <option value="16" <?php if($_GET['nights'] == '16') { ?> selected="selected" <?php  }  ?>>16</option>
            
                            <option value="17" <?php if($_GET['nights'] == '17') { ?> selected="selected" <?php  }  ?>>17</option>
            
                            <option value="18" <?php if($_GET['nights'] == '18') { ?> selected="selected" <?php  }  ?>>18</option>
            
                            <option value="19" <?php if($_GET['nights'] == '19') { ?> selected="selected" <?php  }  ?>>19</option>
            
                            <option value="20" <?php if($_GET['nights'] == '20') { ?> selected="selected" <?php  }  ?>>20</option>
            
                            <option value="21" <?php if($_GET['nights'] == '21') { ?> selected="selected" <?php  }  ?>>21</option>
            
                            <option value="22" <?php if($_GET['nights'] == '22') { ?> selected="selected" <?php  }  ?>>22</option>
            
                            <option value="23" <?php if($_GET['nights'] == '23') { ?> selected="selected" <?php  }  ?>>23</option>
            
                            <option value="24" <?php if($_GET['nights'] == '24') { ?> selected="selected" <?php  }  ?>>24</option>
            
                            <option value="25" <?php if($_GET['nights'] == '25') { ?> selected="selected" <?php  }  ?>>25</option>
            
                            <option value="26" <?php if($_GET['nights'] == '26') { ?> selected="selected" <?php  }  ?>>26</option>
            
                            <option value="27" <?php if($_GET['nights'] == '27') { ?> selected="selected" <?php  }  ?>>27</option>
            
                            <option value="28" <?php if($_GET['nights'] == '28') { ?> selected="selected" <?php  }  ?>>28</option>
            
                            <option value="29" <?php if($_GET['nights'] == '29') { ?> selected="selected" <?php  }  ?>>29</option>
            
                            <option value="30" <?php if($_GET['nights'] == '30') { ?> selected="selected" <?php  }  ?>>30</option>
            
                          </select>
          </div>
        </div>
      </div>
    <!-- <div class="row marginten">
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
												</div> -->
      
      <div class="row nomargin">
        <div class="col-md-6">
          <button type="button" class="btn btn-primary" id="home_btnsubmit">Modify Search</button>
          
          <button type="button" class="btn btn-primary cancelsearch" id="cancelsearchs">Cancel</button>
          
          <div class="star-one" style="display:inline-block; padding-left:10px">
                        						<label class="m-checkbox m-checkbox--solid m-checkbox--success">
                        							<input type="checkbox" id="newtactive" class="" > 
                                                    <div class="star-star">
                        								In a new window
                        							</div>
                        							<span></span>
                        							
                        						</label>
                        					</div>
        </div>
       
      </div>
    </div>
    </form>
            </div>
            
            
            <div class="hotel-u-lists clear roboto">
            	<div class="list-filters .m-portlet">
                	<div class="m-accordion m-accordion--default m-accordion--toggle-arrow" id="m_accordion_6" role="tablist"> 
											<!--begin::Item-->              
                                       <!--end::Item--> 

                        <!--begin::Item--> 
                        <!--<div class="m-accordion__item m-accordion__item--brand">
                        	<div class="m-accordion__item-head collapsed" role="tab" id="m_accordion_6_item_2_head" data-toggle="collapse" href="#m_accordion_12_item_2_body" aria-expanded="false">
                        		
                        		<span class="m-accordion__item-title">Search By Hotel Name</span>
                        		
                        		<span class="m-accordion__item-mode"></span>     
                        	</div>

                        	<div class="m-accordion__item-body collapse" id="m_accordion_12_item_2_body" role="tabpanel" aria-labelledby="m_accordion_6_item_2_head" data-parent="#m_accordion_6" style=""> 
                        		<div class="m-accordion__item-content">
                        			<label>Enter Hotel Name </label>
                                    <div class="hotelnametitle-icon clearfix">
                                    	<div class="hotelnametitle">
                        				<input type="text" class="form-control m-input Hotelnameserachlist" id="Hotelnameserach"  name="city" placeholder="" >
                        		         </div>
                                         <div class="hotelnameicon">
                                         	<button type="button" class="btn btn-primary"> <i class="fa fa-search"></i></button>
                                         </div>
                                         </div>
                                </div>
                        	</div>
                        </div>-->
                        
                        
                        
                        
                        <div class="m-accordion__item m-accordion__item--brand">
                        	<div class="m-accordion__item-head collapsed" role="tab" id="m_accordion_6_item_1_head" data-toggle="collapse" href="#m_accordion_6_item_2_body" aria-expanded="false">
                        		
                        		<span class="m-accordion__item-title">Star rating</span>
                        		
                        		<span class="m-accordion__item-mode"></span>     
                        	</div>

                        	<div class="m-accordion__item-body collapse" id="m_accordion_6_item_2_body" role="tabpanel" aria-labelledby="m_accordion_6_item_2_head" data-parent="#m_accordion_6" style=""> 
                        		<div class="m-accordion__item-content">
                        			<div class="star-checkbox">
                                        
                                        
                        					<div class="star-one">
                        						<label class="m-checkbox m-checkbox--solid m-checkbox--success">
                        							<input type="checkbox" id="5star" class="star" <?php if(isset($starArray)){if(in_array('5',$starArray)) { ?> checked="checked" <?php  }} ?> > 
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
                        							<input type="checkbox" id="4star" class="star" <?php if(isset($starArray)){if(in_array('4',$starArray)) { ?> checked="checked" <?php  }} ?> > 
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
                        							<input type="checkbox" id="3star" class="star" <?php if(isset($starArray)){if(in_array('3',$starArray)) { ?> checked="checked" <?php  }} ?> > 
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
                        							<input type="checkbox" id="2star" class="star" <?php if(isset($starArray)){if(in_array('2',$starArray)) { ?> checked="checked" <?php  }} ?> > 
                        							<div class="star-star">
                        								<i class="fas fa-star"></i>
                        								<i class="fas fa-star"></i>
                        							</div>
                        							<span></span>
                        						</label>
                        					</div>
                        					<div class="star-one" >
                        						<label class="m-checkbox m-checkbox--solid m-checkbox--success" >
                        							<input type="checkbox" id="1star" class="star" <?php if(isset($starArray)){if(in_array('1',$starArray)) { ?> checked="checked" <?php  }} ?> > 
                        							<div class="star-star">
                        								<i class="fas fa-star"></i>
                        							</div>
                        							<span></span>
                        						</label>
                        					</div>
                        				</div>
                        			
                        		</div>
                        	</div>
                        </div>   
                        <!--end::Item--> 

                        <!--begin::Item--> 
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
                        
                        <div class="m-accordion__item m-accordion__item--brand">
                        	<div class="m-accordion__item-head collapsed" role="tab" id="m_accordion_6_item_4_head" data-toggle="collapse" href="#m_accordion_6_item_4_body" aria-expanded="false">
                        		
                        		<span class="m-accordion__item-title">Board Type</span>
                        		
                        		<span class="m-accordion__item-mode"></span>     
                        	</div>

                        	<div class="m-accordion__item-body collapse" id="m_accordion_6_item_4_body" role="tabpanel" aria-labelledby="m_accordion_6_item_4_head" data-parent="#m_accordion_6" style=""> 
                        		<div class="m-accordion__item-content">
                        			<div class="star-checkbox">
                                        
                                        
                        					<div class="star-one">
                        						<label class="m-checkbox m-checkbox--solid m-checkbox--success">
                        							<input type="checkbox" id="mealtype" class="mealtype" value="Room Only" > 
                                                    <div class="star-star">
                        								Room Only
                        							</div>
                        							<span></span>
                        							
                        						</label>
                        					</div>
                        					<div class="star-one">
                        						<label class="m-checkbox m-checkbox--solid m-checkbox--success">
                        							<input type="checkbox" id="mealtype" class="mealtype" value="Breakfast Buffet" > 
                        							<div class="star-star">
                        								Breakfast Buffet
                        							</div>
                        							<span></span>
                        						</label>
                        					</div>
                        					<div class="star-one">
                        						<label class="m-checkbox m-checkbox--solid m-checkbox--success" >
                        							<input type="checkbox" id="mealtype" class="mealtype" value="Breakfast" > 
                        							<div class="star-star">
                        								Breakfast
                        							</div>
                        							<span></span>
                        						</label>
                        					</div>
                        					<div class="star-one">
                        						<label class="m-checkbox m-checkbox--solid m-checkbox--success" >
                        							<input type="checkbox" id="mealtype" class="mealtype" value="Bed and Breakfast" > 
                        							<div class="star-star">
                        								Bed and Breakfast
                        							</div>
                        							<span></span>
                        						</label>
                        					</div>
                        					<div class="star-one" >
                        						<label class="m-checkbox m-checkbox--solid m-checkbox--success" >
                        							<input type="checkbox" id="mealtype" class="mealtype" value="Bed and Buffet Breakfast" > 
                        							<div class="star-star">
                        								Bed and Buffet Breakfast
                        							</div>
                        							<span></span>
                        						</label>
                        					</div>
                                            
                                            <div class="star-one" >
                        						<label class="m-checkbox m-checkbox--solid m-checkbox--success" >
                        							<input type="checkbox" id="mealtype" class="mealtype" value="Continental Breakfast" > 
                        							<div class="star-star">
                        								Continental Breakfast
                        							</div>
                        							<span></span>
                        						</label>
                        					</div>
                                            
                        				</div>
                        			
                        		</div>
                        	</div>
                        </div>
                        
                        
                        
                        <!--end::Item--> 

                    </div>
                </div>
                <div class="list-lists hotellistcontent">
                	<ul class="listofhotel_ul">
                    <?php 
					 $tbohotelholiday = array();
							  $tbohotelholiday_c = array();
							  $tbohotelholiday_array = array();
							  
							  
								$starrating = '';
								$sessionId = '';
							
							
			
							$tbohotelholiday_arraynew = array();	
							
							
							
							
								
							if(!empty($hotel_tbolist_xml['HotelResultList']['HotelResult'])){
								$sessionId = $hotel_tbolist_xml['SessionId'];
								if(isset($hotel_tbolist_xml['HotelResultList']['HotelResult'][0]) && !empty($hotel_tbolist_xml['HotelResultList']['HotelResult'][0])){
								foreach($hotel_tbolist_xml['HotelResultList']['HotelResult'] as $roomvalues){
									//$tbohotelholidaytrip_array = array();  
									if(!empty($roomvalues['HotelInfo']['HotelName'])){
									if($roomvalues['HotelInfo']['Rating'] == 'FourStar'){  $starrating = 4;  }
									if($roomvalues['HotelInfo']['Rating'] == 'FiveStar'){  $starrating = 5;  }
									if($roomvalues['HotelInfo']['Rating'] == 'ThreeStar'){  $starrating = 3;  }
									if($roomvalues['HotelInfo']['Rating'] == 'TwoStar'){  $starrating = 2;  } 
									if($roomvalues['HotelInfo']['Rating'] == 'OneStar'){  $starrating = 1;  } 
									$HotelName1 = (string)$roomvalues['HotelInfo']['HotelName'];
									$tbohotelholiday_arraynew[$HotelName1] = $HotelName1;
									
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
									if(isset($roomvalues['HotelInfo']['TripAdvisorRating']) && !empty($roomvalues['HotelInfo']['TripAdvisorRating'])){
									$tbohotelholidaytrip_array['Tboholidays']['TripAdvisorRating'] = round($roomvalues['HotelInfo']['TripAdvisorRating']);
									$tbohotelholidaytrip_array['Tboholidays']['TripAdvisorReviewURL'] = $roomvalues['HotelInfo']['TripAdvisorReviewURL'];
									}
									$attr = '@attributes';
									$tbohotelholiday[$roomvalues['HotelInfo']['HotelCode']]['MinHotelPrice'] = $roomvalues['MinHotelPrice'][$attr]['OriginalPrice'];
								
								
								}
								
								}
								}else{
									
									
									
									
									
									
								
								if(!empty($hotel_tbolist_xml['HotelResultList']['HotelResult']['HotelInfo']['HotelName'])){
									if($hotel_tbolist_xml['HotelResultList']['HotelResult']['HotelInfo']['Rating'] == 'FourStar'){  $starrating = 4;  }
									if($hotel_tbolist_xml['HotelResultList']['HotelResult']['HotelInfo']['Rating'] == 'FiveStar'){  $starrating = 5;  }
									if($hotel_tbolist_xml['HotelResultList']['HotelResult']['HotelInfo']['Rating'] == 'ThreeStar'){  $starrating = 3;  }
									if($hotel_tbolist_xml['HotelResultList']['HotelResult']['HotelInfo']['Rating'] == 'TwoStar'){  $starrating = 2;  } 
									if($hotel_tbolist_xml['HotelResultList']['HotelResult']['HotelInfo']['Rating'] == 'OneStar'){  $starrating = 1;  }
									
									$HotelName1 = (string)$hotel_tbolist_xml['HotelResultList']['HotelResult']['HotelInfo']['HotelName'];
									$tbohotelholiday_arraynew[$HotelName1] = $HotelName1;
									
									$HotelName = str_replace(' ','',$hotel_tbolist_xml['HotelResultList']['HotelResult']['HotelInfo']['HotelName']);
									$tbohotelholiday_array[$HotelName] = $HotelName;
									$HotelName = str_replace(' ','',$hotel_tbolist_xml['HotelResultList']['HotelResult']['HotelInfo']['HotelName']);
//									print_r(str_replace(' ','',$hotel_tbolist_xml['HotelResultList']['HotelResult']['HotelInfo']['HotelName']));
									$tbohotelholiday[$hotel_tbolist_xml['HotelResultList']['HotelResult']['HotelInfo']['HotelCode']]['code'] = $hotel_tbolist_xml['HotelResultList']['HotelResult']['HotelInfo']['HotelCode'];
									$tbohotelholiday[$HotelName]['codes'] = $hotel_tbolist_xml['HotelResultList']['HotelResult']['HotelInfo']['HotelCode'];
									$tbohotelholiday[$HotelName]['ResultIndexs'] = $hotel_tbolist_xml['HotelResultList']['HotelResult']['ResultIndex'];
									$tbohotelholiday[$hotel_tbolist_xml['HotelResultList']['HotelResult']['HotelInfo']['HotelCode']]['ResultIndex'] = $hotel_tbolist_xml['HotelResultList']['HotelResult']['ResultIndex'];
									$tbohotelholiday[$hotel_tbolist_xml['HotelResultList']['HotelResult']['HotelInfo']['HotelCode']]['HotelPicture'] = $hotel_tbolist_xml['HotelResultList']['HotelResult']['HotelInfo']['HotelPicture'];
									$tbohotelholiday[$hotel_tbolist_xml['HotelResultList']['HotelResult']['HotelInfo']['HotelCode']]['HotelAddress'] = $hotel_tbolist_xml['HotelResultList']['HotelResult']['HotelInfo']['HotelAddress'];
									$tbohotelholiday[$hotel_tbolist_xml['HotelResultList']['HotelResult']['HotelInfo']['HotelCode']]['TripAdvisorRating'] = $starrating;
									if(isset($roomvalues['HotelInfo']['TripAdvisorRating']) && !empty($roomvalues['HotelInfo']['TripAdvisorRating'])){
									$tbohotelholidaytrip_array['Tboholidays']['TripAdvisorRating'] = round($hotel_tbolist_xml['HotelResultList']['HotelResult']['HotelInfo']['TripAdvisorRating']);
									$tbohotelholidaytrip_array['Tboholidays']['TripAdvisorReviewURL'] = $hotel_tbolist_xml['HotelResultList']['HotelResult']['HotelInfo']['TripAdvisorReviewURL'];
									}
									
									
									
									$attr = '@attributes';
									$tbohotelholiday[$hotel_tbolist_xml['HotelResultList']['HotelResult']['HotelInfo']['HotelCode']]['MinHotelPrice'] = $hotel_tbolist_xml['HotelResultList']['HotelResult']['MinHotelPrice'][$attr]['OriginalPrice'];
								
								
								}
								
								
								
							   }
								
							}
							
							
						
							
							
							
					         $tbohotelholiday_d = array();
							 $tbohotelholiday_price_array = array();
							 $match_array = array();
							 $match_array_tbo = array();
					
					
					?>
                    @if(isset($hotelDetailArray))
        						@foreach($hotelDetailArray as $hotel_list)
                                <?php 
								$HotelName = str_replace(' ','',$hotel_list->HotelName);
								foreach($tbohotelholiday_array as $tbohotelholiday_hotelname){
									
									similar_text($tbohotelholiday_hotelname, $HotelName, $percent);
									$match_array[$HotelName][] = $percent;
									$match_array_tbo[$tbohotelholiday_hotelname][] = $percent;
									
								}
								
								?>
                                
                                @endforeach
                      @endif
                    
                    <?php 
					
					
					
						
							if(isset($_GET['tbo'])){
								
								?>
                                 @if(isset($hotelDetailArray))
        						@foreach($hotelDetailArray as $hotel_list)
                                <?php 
						
							$HotelName = $hotel_list->HotelName;
							foreach($tbohotelholiday_arraynew as $tbohotelholiday_hotelname){
									
									similar_text($tbohotelholiday_hotelname, $HotelName, $percent);
									
									
									echo '<pre>';
									print_r($HotelName);
									print_r($tbohotelholiday_hotelname);
									print_r($percent);
									echo '</pre>';
									
									
									$HotelName1 = str_replace(' ','',$HotelName);
									
									$match_array[$HotelName1][] = $percent;
									$match_array_tbo[$tbohotelholiday_hotelname][] = $percent;
									
								}
							
							
							
							?>
                              @endforeach
                      @endif
                            
                            <?php 
							
							echo '<pre>';
				print_r($match_array);
				echo '</pre>';
							
							
							}
							
					
					
					
					
					
					$rrt=1;
					$ss = 1;
					$run = 1;
					?>
                    
                    @if(isset($hotelDetailArray))
        						@foreach($hotelDetailArray as $hotel_list)
                                <?php 
								
								//mealtype get
								$hotelListBoardArray  = ''; 
								
								
								$board = 1;
								foreach($hotel_list->Options->Option as $hotelListBoard){
									
									if($board == 1){
										
										$hotelListBoardArray = $hotelListBoard->BoardType;
									}else{
									
									    $hotelListBoardArray .= ','.$hotelListBoard->BoardType;
									}
									
									++$board;
								}
								
								$HotelName = str_replace(' ','',$hotel_list->HotelName);
								$tboholidayCode = '';
								 $MinHotelPrice = 0;
								 $tbohotelholiday_price_array['Travellanda'] = '';
								  $tbohotelholiday_price_array['Travellanda'] = $hotel_list->Options->Option->TotalPrice;
                              foreach($tbohotelholiday_array as $tbohotelholiday_hotelname){
								  
								  //travelan price
								 
								  
					             $tbohotelholiday_c[$tbohotelholiday[$tbohotelholiday_hotelname]['codes']] = 2;
								  $tbohotelholiday_price_array['Tboholidays'] = '';
								 $MinHotelPrice = 0;
								if($tbohotelholiday_c[$tbohotelholiday[$tbohotelholiday_hotelname]['codes']] !=''){
								  
								 
								  if(max($match_array[$HotelName])>87){  
						               $tbohotelholiday_c[$tbohotelholiday[$tbohotelholiday_hotelname]['codes']] = 1;
								       $tboholidayCode = '&hotelid1='.$tbohotelholiday[$tbohotelholiday_hotelname]['codes'].'&resultindex='.$tbohotelholiday[$tbohotelholiday_hotelname]['ResultIndexs'];
									   
									   $MinHotelPrice = $tbohotelholiday[$tbohotelholiday[$tbohotelholiday_hotelname]['codes']]['MinHotelPrice'];
									  $tbohotelholiday_price_array['Tboholidays'] = $MinHotelPrice;
									
									   
								  
								  }
							  }
							  }
							  
							
							  $bestsub = '';
							  $secsub = '';
							  
							  $bestsub = 'Travellanda';
							  $secsub = 'Tboholidays';
							  
							  
							 // echo '<pre>';
							  //print_r($tbohotelholiday_price_array);
							  //echo '</pre>';
							  $Total_price_max = '';
							  if($MinHotelPrice !=0){
							  if($hotel_list->Options->Option->TotalPrice<$MinHotelPrice){
								  
								      array_search(min($tbohotelholiday_price_array), $tbohotelholiday_price_array);
									
									 $bestsub = array_search(min($tbohotelholiday_price_array), $tbohotelholiday_price_array);
							         $secsub = array_search(max($tbohotelholiday_price_array), $tbohotelholiday_price_array);
									 
									 $minPrice = min($tbohotelholiday_price_array);
							  
							  //maxprice
							 
							  if(isset($hotel_detail_mark_up)){
								$markup_price = max($tbohotelholiday_price_array) % 100;
									$new_width = ($hotel_detail_mark_up / 100) * max($tbohotelholiday_price_array);
								    $Total_price_max = max($tbohotelholiday_price_array) + $new_width;
								}else{
								   $Total_price_max = max($tbohotelholiday_price_array);
								}
							  
							  }
							  }else{
							  
							      $bestsub = array_search(max($tbohotelholiday_price_array), $tbohotelholiday_price_array);
							      $minPrice = max($tbohotelholiday_price_array);
							  }
							  //echo $bestsub;
							  
							  
							  
							 
								
								if(isset($hotel_detail_mark_up)){
								$markup_price = $minPrice % 100;
									$new_width = ($hotel_detail_mark_up / 100) * $minPrice;
								    $Total_price = $minPrice + $new_width;
									
									if(isset($_GET['testhotel'])){
									
									echo 'Agent Markup price: '.$new_width;
									
								     }
								}else{
								$Total_price = $minPrice;
								}
								
								if(isset($_GET['markup']) && !empty($_GET['markup'])){
                                    		$Total_price_max_markup=  (($_GET['markup'] / 100) * $Total_price_max);
											
											if(isset($_GET['testhotel'])){
									
									     echo 'Search Markup price: '.$Total_price_max_markup;
									
								     }
											
											
                                  }
								
								
								
							  $noimage = '';
							 // if(isset($hotel_list_Options_array_new['_'.$hotel_list->HotelId]->Images->Image[0])){
							      
								//   $noimage = $hotel_list_Options_array_new['_'.$hotel_list->HotelId]->Images->Image[0];
							     
							//  }else{
							  
							       $noimage = asset('img/noimage.png');
							  
							//  }
							
						  
								?>
                    	<li class="clear hotellist-result hotellist{{$hotel_list->HotelId}} hotellists{{$run}}" data-hotelid="{{$hotel_list->HotelId}}" data-star="{{round($hotel_list->StarRating)}}" data-price="{{$Total_price}}" data-hotelname="{{$hotel_list->HotelName}}" data-boardtype="{{$hotelListBoardArray}}">
                         <a href="{{$datail_page_url}}{{$hotel_detail_url}}&hotelid={{$hotel_list->HotelId}}{{$tboholidayCode}}&session={{$sessionId}}&cityid={{$_GET['cityid']}}&currency={{$_GET['currency']}}&Nationality=IN&markup=<?PHP if(isset($_GET['markup']) && !empty($_GET['markup'])){  echo $_GET['markup']; }?>" class="clear">
                        	<div class="hotel-image-u-part image-update">
                            	<div class="image-loader image-loaders{{$hotel_list->HotelId}}"><img src="{{asset('img/image_loader.gif')}}" alt="htel-images"/></div>
                                
                                <div class="image-hotel image-hotelloader{{$hotel_list->HotelId}}" style="display:none;"><img class="loadimage{{$hotel_list->HotelId}}" src="" alt="htel-images"/></div>
                                
                                
                                
                            </div>
                            <div class="hotel-informations-o-part m-portlet clearfix">
                            	<div class="hotel-informations-o-part-left">
                                 <div class="hotel-informations-o-part-up">
                                	<div class="ho-name">
                                    	{{$hotel_list->HotelName}}
                                    </div>
                                    <div class="star-ratings-trip-advisors">
                                    	<div class="hotel-list-star">
                                        	<ul>
                                            @for($i=1;$i<=5;$i++)  
        										@if(round($hotel_list->StarRating)  >= $i)
                                            	<li><img src="{{asset('img/star.png')}}" />
                                                @endif	
        										@endfor
                                            </ul>
                                        </div>
                                        <div class="hotel-list-trip">
                                        <?php  if($MinHotelPrice != 0) { if(isset($tbohotelholidaytrip_array['Tboholidays']['TripAdvisorRating']) && !empty($tbohotelholidaytrip_array['Tboholidays']['TripAdvisorRating'])) {?>
                                        	<div class="trip-icons">
                                            	<img src="{{asset('img/tripicon.png')}}" />
                                            </div>
                                            <?php }} ?>
                                            
                                           
                                            <div class="trip-icons-ratings">
                                             <?php  if($MinHotelPrice != 0) { if(isset($tbohotelholidaytrip_array['Tboholidays']['TripAdvisorRating']) && !empty($tbohotelholidaytrip_array['Tboholidays']['TripAdvisorRating'])) {?>
                                            	<ul>
                                                @for($i=1;$i<=5;$i++)  
        										@if(round($tbohotelholidaytrip_array['Tboholidays']['TripAdvisorRating'])  >= $i)
                                                	<li><img src="{{asset('img/trip-ratings.png')}}" /></li>
                                                @endif	
        										@endfor
                                                </ul>
                                                <?php } } ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="hotel-o-address hoteladdress-update">
                                    {{$_GET['city']}}
                                    </div>
                                 </div> 
                                 <div class="hotel-informations-o-part-low">
                                 	<ul>
                                    <?php  if(isset($Total_price_max) && !empty($Total_price_max)) { ?>	
                                    	<li>
                                        	<span>{{$secsub}}</span>
                                        	 <?php 
                                    	if(isset($_GET['markup']) && !empty($_GET['markup'])){
                                    		$Total_price_max =  number_format(((($_GET['markup'] / 100) * $Total_price_max)+$Total_price_max),2);
                                   		 }
										 $Total_price_max  = $Total_price_max * $currecny_price
                                   		 ?>
                                            <p><?php echo $_GET['currency']; ?> {{number_format($Total_price_max, 2)}}</p>
                                        </li>
                                        
                                        <?php } ?>
                                    </ul>
                                 </div>  
                                </div>
                                <div class="hotel-informations-o-part-right">
                                	<div class="h-l-best-price-tag">
                                    	Best Price
                                    </div>
                                    <div class="h-l-best-price">
                                    <?php 
									if(isset($_GET['manitest123'])){
									
									
									$addMarkupPrice = (($_GET['markup'] / 100) * $Total_price);
									
									$Total_price1 = $Total_price +  $addMarkupPrice;
									
									//echo $Total_price1;
									 	
										
									}
									
                                    if(isset($_GET['markup']) && !empty($_GET['markup'])){
                                    	$addMarkupPrice = (($_GET['markup'] / 100) * $Total_price);
									
									    $Total_price = $Total_price +  $addMarkupPrice;
                                    }
									
									$Total_price  = $Total_price * $currecny_price
                                    ?>
                                    	
                                    	<?php echo $_GET['currency']; ?> {{number_format($Total_price, 2)}}
                                    </div>
                                    <i>For  Min</i>
                                   <!-- <span>{{$bestsub}}</span>-->
                                </div>
                            </div>
                            </a>
                        </li>
                        <?php ++$run; ?>
                       @endforeach
                      @endif
                      <?php if(isset($_GET['pag']) && !empty($_GET['pag'])) { $pag = $_GET['pag']; }else{ $pag = 20; }  ?>
                    <button type="button" class="btn btn-primary loadmorelist" id="loadmorelist" data-num="{{$pag}}" value="{{$pag}}">Load More</button>
                    <?php 
					 /* if(!empty($hotel_tbolist_xml['HotelResultList']['HotelResult'])){
						  
						
								if(isset($hotel_tbolist_xml['HotelResultList']['HotelResult'][0]) && !empty($hotel_tbolist_xml['HotelResultList']['HotelResult'][0])){
								   foreach($hotel_tbolist_xml['HotelResultList']['HotelResult'] as $roomvalues){
									   $HotelName = str_replace(' ','',$roomvalues['HotelInfo']['HotelName']);
									  
									   
									 if(!empty($roomvalues['HotelInfo']['HotelName'])){
									 $starrating = '';
									if($roomvalues['HotelInfo']['Rating'] == 'FourStar'){  $starrating = 4;  }
									if($roomvalues['HotelInfo']['Rating'] == 'FiveStar'){  $starrating = 5;  }
									if($roomvalues['HotelInfo']['Rating'] == 'ThreeStar'){  $starrating = 3;  }
									if($roomvalues['HotelInfo']['Rating'] == 'TwoStar'){  $starrating = 2;  } 
									if($roomvalues['HotelInfo']['Rating'] == 'OneStar'){  $starrating = 1;  } 
									
									$HotelName = str_replace(' ','',$roomvalues['HotelInfo']['HotelName']);
									
									$TripAdvisorRating = '';
									$TripAdvisorReviewURL = '';
									if(isset($roomvalues['HotelInfo']['TripAdvisorRating']) && !empty($roomvalues['HotelInfo']['TripAdvisorRating'])){
									$TripAdvisorRating = round($roomvalues['HotelInfo']['TripAdvisorRating']);
									$TripAdvisorReviewURL = $roomvalues['HotelInfo']['TripAdvisorReviewURL'];
									}
									$attr = '@attributes';
									$MinHotelPrice = $roomvalues['MinHotelPrice'][$attr]['OriginalPrice'];
									
									$minPrice = $MinHotelPrice;
								
								if(isset($hotel_detail_mark_up)){
								$markup_price = $minPrice % 100;
									$new_width = ($hotel_detail_mark_up / 100) * $minPrice;
								    $Total_price = $minPrice + $new_width;
								   }else{
								   $Total_price = $minPrice;
								    }  
									   
									   
									 }
									 
									 ?>
                                     
                                     <li class="clear hotellist-result hotellist{{$roomvalues['HotelInfo']['HotelCode']}}" data-hotelid="{{$roomvalues['HotelInfo']['HotelCode']}}" data-star="{{round($starrating)}}" data-price="{{$Total_price}}" data-hotelname="{{$roomvalues['HotelInfo']['HotelName']}}">
                         <a href="" class="clear">
                        	<div class="hotel-image-u-part">
                            	<img src="{{$roomvalues['HotelInfo']['HotelPicture']}}" alt="htel-images"/>
                            </div>
                            <div class="hotel-informations-o-part m-portlet clearfix">
                            	<div class="hotel-informations-o-part-left">
                                 <div class="hotel-informations-o-part-up">
                                	<div class="ho-name">
                                    	{{$roomvalues['HotelInfo']['HotelName']}}
                                    </div>
                                    <div class="star-ratings-trip-advisors">
                                    	<div class="hotel-list-star">
                                        	<ul>
                                            @for($i=1;$i<=5;$i++)  
        										@if(round($starrating) >= $i)
                                            	<li><img src="{{asset('img/star.png')}}" />
                                                @endif	
        										@endfor
                                            </ul>
                                        </div>
                                        <div class="hotel-list-trip">
                                        <?php  if(isset($TripAdvisorRating) && !empty($TripAdvisorRating)) {?>
                                        	<div class="trip-icons">
                                            	<img src="{{asset('img/tripicon.png')}}" />
                                            </div>
                                            <?php } ?>
                                            
                                           
                                            <div class="trip-icons-ratings">
                                             <?php   if(isset($TripAdvisorRating) && !empty($TripAdvisorRating)) {?>
                                            	<ul>
                                                @for($i=1;$i<=5;$i++)  
        										@if(round($TripAdvisorRating)  >= $i)
                                                	<li><img src="{{asset('img/trip-ratings.png')}}" /></li>
                                                @endif	
        										@endfor
                                                </ul>
                                                <?php  } ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="hotel-o-address">
                                    	{{$roomvalues['HotelInfo']['HotelAddress']}}
                                    </div>
                                 </div> 
                                 <div class="hotel-informations-o-part-low">
                                 	
                                 </div>  
                                </div>
                                <div class="hotel-informations-o-part-right">
                                	<div class="h-l-best-price-tag">
                                    	Best Price
                                    </div>
                                    <div class="h-l-best-price">
                                    	$ {{$Total_price}}
                                    </div>
                                    <i>For  Min</i>
                                    <span>Tboholidays</span>
                                </div>
                            </div>
                            </a>
                        </li>
                                     
                                     
                                     
                                     
                                     
                                     <?php 
									
									
								   
								   }
								   }
					  }*/
					
					?> 
                    
                    <button type="button" class="btn btn-primary loadmore" id="loadmore" data-num="20" value="20">Load More</button>
                    
                          
                    </ul>
                    
                </div>
                  
            </div>
        </div>
        
        
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

<div class="fullloader">
  
</div>

        
		
        
</div>
<input type="hidden" name="currencycode" id="currencycode" value="USD" >
<input type="hidden" name="" id="pageno" value="20" >
<input type="hidden" name="" id="pricesort" value="0" >
<input type="hidden" name="" id="starsort" value="0" >
<input type="hidden" name="" id="divcount" value="0" >

<input type="hidden" name="cityid" id="cityid" value="<?php echo $_GET['cityid'];?>" >
<input type="hidden" name="cityname" id="cityname" value="<?php if(isset($_GET['cityname'])){ echo $_GET['cityname']; }?>"/>
<input type="hidden" name="longitude" id="longitude" value="<?php echo $_GET['cityid'];?>" > 
<input type="hidden" name="Checkin" id="checkin" value="<?php echo $_GET['checkin'];?>" >
<input type="hidden" name="Checkout" id="checkout" value="<?php echo $_GET['checkout'];?>" >
<input type="hidden" id="norooms" value="<?php echo $_GET['norooms']; ?>" name="norooms"/>
<?php for($ro=1;$ro<=$_GET['norooms'];$ro++){?>
	<input type="hidden" id="noadult<?php echo $ro;?>" value="<?php echo $_GET['adult'.$ro]; ?>" name="adult<?php echo $ro;?>"/>
	<input type="hidden" id="nochild<?php echo $ro;?>" value="<?php echo $_GET['child'.$ro]; ?>" name="child<?php echo $ro;?>"/>
	<?php for($chi=1;$chi<=$_GET['child'.$ro];$chi++){?>
		<input type="hidden" id="nochildage<?php echo $ro.$chi; ?>" value="<?php echo $_GET['childage'.$ro.$chi]; ?>" name="childage<?php echo $ro.$chi; ?>"/>        
		<?PHP } } ?> 
		
		
		<input type="hidden" id="minstar" value="<?php if(isset($_GET['minstar'])){ echo $_GET['minstar']; }?>"/>
		<input type="hidden" id="maxstar" value="<?php if(isset($_GET['maxstar'])){ echo $_GET['maxstar']; }?>"/> 
		
		<input type="hidden" id="pricerangemin" value=""/>
		<input type="hidden" id="pricerangemax" value=""/>
        <input type="hidden" id="mealtypeinput" value=""/>
        
        
        <input type="hidden" id="hotel_detail_url" value="{{$hotel_detail_url}}"/> 
        <input type="hidden" id="homeurls" value="{{route('hotellist')}}?<?php echo $_SERVER["QUERY_STRING"];?>"/>                

      
		
		<script type="text/javascript">
		//alert('ab');
			var hotelajax = "{{ URL::to('/ajaxhotellist')}}";
			
			$(document).ready(function(){
				
				window.onload=function(){
					
					hotelimage(1);
      // Run code
                       };
					   
					   
					
					
				$(document).on('click', '.loadmorelist', function(){
					
					
					$('.loader-fixed').show();
					
				var url  = $('#homeurls').val();
				
				var pag = parseInt($(this).val()) + parseInt(20);
				console.log(pag);
				window.location.href = url+'&pag='+pag;
		
		
	              });	   
					   
				
				$(document).on('click', '.changesearchs', function(){
					
					
					$('.search-for-results').hide();
					$('.modify-search-part').show();
		
		
	              });
				  
				  
				  $(document).on('click', '.cancelsearch', function(){
					
					
					$('.search-for-results').show();
					$('.modify-search-part').hide();
		
		
	              });
	
	
				
				
				var temp_count = $('.hotellist-result').length;
				$('.totalresultfound').html(temp_count);
				
				$('.loader-fixed').hide();	
				ajaxjsonhoteljquery();
				
			var totalresult = $('.hotellist-result').length;

			$('.totalresultfound').html(totalresult);
				
			$(document).on('click', '.responsivefilter', function(){
		$('.list-filters').addClass('showresponsivefilter');
		
	});
	
	$(document).on('click', '.closefiltericon', function(){
		$('.list-filters').removeClass('showresponsivefilter');
	});	
	
	
	
	
	
		$(document).on('change', '.mealtype', function() {
			$('.loader-fixed').show();
		    var amenities = '';
			$('.mealtype').each(function(){
			    if(this.checked){
				if(amenities) {	
				if($(this).val()) {
			    amenities  += ','+$(this).val();
				}
				}else{
					if($(this).val()) {
					amenities  += $(this).val();
					}
				    }
				}
				//alert(amenities);
				$('#mealtypeinput').val(amenities);
				 
			});
	//$('.loder-edit').show();
     //ajaxjsonhotel();
	 
	 setTimeout(function(){  ajaxjsonhoteljquery_values(); }, 3000);
	 
    });	
				
		//
		ajaxjsonhoteljquery_values();
		
		/*$(window).scroll(function() {
	        if($(window).scrollTop() + $(window).height() >= $(document).height()) {
	           // console.log('hi');
			   $('.loader-list-loader').show();
			   ajaxjsonhoteljquery();
	        }
    	});	*/
		$(document).on('click', '.starTabnew', function(){
		//$('.starTab').removeClass('tabActive');
		  $(this).addClass('active');
		  $(this).addClass('show');
		  $('.price_sort_icon').show();
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

		$('.price_sort_icon').attr('src','img/si2.png');
		if(starSort == 1){
			$('.hotellist-result').sort(function (a, b) {
				return $(a).data('star') - $(b).data('star');
			}).map(function () {
				return $(this).closest('.hotellist-result');
			}).each(function (_, container) {
				$(container).parent().append(container);
			});
			$(this).html('<a class="nav-link m-tabs__link starTabnew active show" data-toggle="tab" href="#m_portlet_base_demo_1_tab_content" role="tab" aria-selected="true"><i class="fa fa-star-o"></i> <span class="spansixe"> Star </span><img class="star_sort_icon" src="img/si1.png" /></a>');
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
			$(this).html('<a class="nav-link m-tabs__link starTabnew active show" data-toggle="tab" href="#m_portlet_base_demo_1_tab_content" role="tab" aria-selected="true"><i class="fa fa-star-o"></i> <span class="spansixe"> Star </span><img class="star_sort_icon" src="img/si3.png" /></a>');
			$('#starsort').val(starSort);
			$('#pricesort').val(0);
			starSort = 1;
		}
		
	});	
	
			//sortin
			
			var priceSort = 1;
			$(document).on('click', '.lowprcie', function(){
		//$('.nearhotel').html('Nearest');
		$('.star_sort_icon').attr('src','img/si2.png');
		//console.log(priceSort);
		if(priceSort == 1){
			$('.hotellist-result').sort(function (a, b) {
				return $(a).data('price') - $(b).data('price');
			}).map(function () {
				return $(this).closest('.hotellist-result');
			}).each(function (_, container) {
				$(container).parent().append(container);
			});
			$(this).html('<a class="nav-link m-tabs__link active show" data-toggle="tab" href="#m_portlet_base_demo_1_tab_content" role="tab"aria-selected="true"><i class="fa fa-dollar"></i> <span class="spansixe">Price</span><img class="price_sort_icon" src="img/si1.png" /></a>');
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
			$(this).html('<a class="nav-link m-tabs__link active show" data-toggle="tab" href="#m_portlet_base_demo_1_tab_content" role="tab"aria-selected="true"><i class="fa fa-dollar"></i><span class="spansixe"> Price</span><img class="price_sort_icon" src="img/si3.png" /></a>');
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
				$('.fullloader').hide();
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
            $('.loader-fixed').show();
            setTimeout(function(){  ajaxjsonhoteljquery_values(); }, 3000);
			//hotelajax();
		});	
			
		$('.loader-fixed').hide();	
			
		});
			
			
			
		function ajaxjsonhoteljquery(){

		$('.loadmore_icon').show();
		 $('#loadmore').hide();
		//console.log('hi');
		var thehref = '';
		var checkin = $('#checkin').val();
		var cityid = $('#cityid').val();
		var divcount = $('#divcount').val();
		var beforelength = $('.hotellist-result').length;
		var currencycode = $('#currencycode').val();
		var checkout = $('#checkout').val();
		var norooms = $('#norooms').val();
		var maxrating = $('#maxstar').val();
		var minrating = $('#minstar').val();
		var pageno = $('#pageno').val();
		var mealtypeinput = $('#mealtypeinput').val();
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
		
	var hotelaname = [];	
		
/*	$(".hotellist-result").each(function( index ) {
		var hotelids = $(this).data('hotelid');
		
	  var thehref = '<?php echo $_SERVER['QUERY_STRING']; ?>&hotelids='+hotelids; 
		var myObject = [];
		$.ajax({
			type: "GET",
			url: hotelajax,
			data: thehref,
			cache: false,
			success: function(data){
				$('.image-loader').hide();
				$('.image-hotel').show();
				$('.loadimage'+hotelids).attr("src",data);
				//$('.loadimage'+hotelids).css("width" , "100% !important");
				$('.loadimage'+hotelids).css("cssText", "width: 100% !important;");
				
				
				
			}
		});
		
	});*/
		
		
}


 function hotelimagenew(no){
	var num = parseInt(no) + parseInt(1);
	hotelimage(num); 
	 
 }

 
   function hotelimage(no){
	   

	   
	   var hotelids = $('.hotellists'+no).data('hotelid');
	
	    var thehref = '<?php echo $_SERVER['QUERY_STRING']; ?>&hotelids='+hotelids; 
		var myObject = [];
		$.ajax({
			type: "GET",
			url: hotelajax,
			data: thehref,
			cache: false,
			success: function(data){
				if(data){
				hotelimagenew(no);
				$('.image-loaders'+hotelids).hide();
				$('.image-hotelloader'+hotelids).show();
				$('.loadimage'+hotelids).attr("src",data);
				$('.loadimage'+hotelids).css("width" , "100% !important");
				$('.loadimage'+hotelids).css("cssText", "width: 100% !important;");
				
				}
				
			}
		});
	   
	   
	   
	   
	   
	   
	   
  
 }
 



		
		function lowestresultreload(beforelength){
			
			var totalresultcount = $('.hotellist-result').length;
			var lowresult = parseInt(totalresultcount)-parseInt(beforelength);
			
			if(parseInt(lowresult) > parseInt(1)){
				ajaxjsonhoteljquery();
			}
			$('#loadmore').hide();
			$('.loadmore_icon').show();
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
		$('.loader-fixed').show();
		$('.hotellist-result').removeAttr( "style" );
		var maxrating = $('#maxstar').val();
		var minrating = $('#minstar').val();
	     var minprice = $('#pricerangemin').val();
		 var maxprice = $('#pricerangemax').val();
		 var mealtypeinput = $('#mealtypeinput').val();
		var detailsurl = $('.detailsurl').val();
		$('.hotellist-result').each(function(){
		var hotelid = $(this).data('hotelid');
		$('.hotellist'+hotelid).not(':last').remove();
		if(maxrating && mealtypeinput){
           var hotelstar = $(this).data('star');
			var boardtypes = $(this).data('boardtype');
			var hotelprice = $(this).data('price');
			var checkhidehotelid = starjquery(minrating, maxrating, hotelid,hotelstar);
			if(checkhidehotelid == 1){
			var checkhidehotelid = boardtype(boardtypes, mealtypeinput, hotelid);
			}
			if(checkhidehotelid == 1){
			var checkhidehotelid = pricejquery(minprice, maxprice, hotelid,hotelprice);
			}
			
			if(checkhidehotelid == 2){
			$('.hotellist'+hotelid).hide();
			}else if(checkhidehotelid == 1){
			$('.hotellist'+hotelid).show();
			}			
		}else if(maxrating && mealtypeinput){
           var hotelstar = $(this).data('star');
			var boardtypes = $(this).data('boardtype');
			var checkhidehotelid = starjquery(minrating, maxrating, hotelid,hotelstar);
			if(checkhidehotelid == 1){
			var checkhidehotelid = boardtype(boardtypes, mealtypeinput, hotelid);
			}
			if(checkhidehotelid == 2){
			$('.hotellist'+hotelid).hide();
			}else if(checkhidehotelid == 1){
			$('.hotellist'+hotelid).show();
			}			
		}else if(maxprice && mealtypeinput){
            var boardtypes = $(this).data('boardtype');
			var hotelprice = $(this).data('price');
			var checkhidehotelid = pricejquery(minprice, maxprice, hotelid,hotelprice);
			if(checkhidehotelid == 1){
			var checkhidehotelid = boardtype(boardtypes, mealtypeinput, hotelid);
			}
			if(checkhidehotelid == 2){
			$('.hotellist'+hotelid).hide();
			}else if(checkhidehotelid == 1){
			$('.hotellist'+hotelid).show();
			}			
		}else if(maxprice && maxrating){
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
		}else if(mealtypeinput){
			var boardtypes = $(this).data('boardtype');
			var checkhidehotelid = boardtype(boardtypes, mealtypeinput, hotelid);
			if(checkhidehotelid == 2){
			$('.hotellist'+hotelid).hide();
			}else if(checkhidehotelid == 1){
			$('.hotellist'+hotelid).show();
			}
		}
			});
			$('.fullloader').html('');
			var totalresult = $('.hotellist-result').length;

			$('.totalresultfound').html(totalresult);
			 var count ='';
			$('li.hotellist-result:visible').each(function(){
		      var count = $('li.hotellist-result:visible').length;
			$('.totalresultfound').html(count);
		     });
			
		$('.loader-fixed').hide();
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
	
	
	
	function boardtype(boardtypes, mealtypeinput, hotelid){
		var arr = [];
		var arrinput = [];
		var arr1 = [];
		if(boardtypes.indexOf(',') > -1){
							
			var array = boardtypes.split(',');
			$.each(array, function( key, arraylists ) {
				arr.push(arraylists);
			});
			
			}else{
			
			   arr.push(boardtypes);
			}
			
			
			
		if(mealtypeinput.indexOf(',') > -1){
							
			var array = mealtypeinput.split(',');
			$.each(array, function( key, arraylists ) {
				arrinput.push(arraylists);
			});
			
			}else{
			
			   arrinput.push(mealtypeinput);
			}
	
		$.each(arrinput, function( key, arraylistsresult ) {
									   
			   if(jQuery.inArray(arraylistsresult, arr) >  -1 ) {
					arr1.push(1);
				 }else{
					 arr1.push(0);
				}
				
		});	
		
		
		
		var hotelid = 2;
		if(arr1){
		var max_value = Math.max.apply(null, arr1) // 4;

							//min get result
		 						
		  if(max_value == 1){
	
			
				var hotelid = 1;	
		
		  }
		}


			//console.log(arr);
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
	$(document).on('click', '.Addrooms', function(){});
	

	
	
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

	$(document).on('click', '#loadmore', function(e){
$('.loader-fixed').show();
		var divcount = $('#divcount').val();
		ajaxjsonhoteljquery();
		
		setTimeout(function(){  ajaxjsonhoteljquery_values(); }, 3000);
		
	});
	
	
	

	
	

</script>



<script>
								var homesearchurl = "{{ URL::to('/homesearch')}}";
								var homesearchurlnew = "{{ URL::to('/hotelsearchn')}}";

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
		    $('#cityname').val(ui.item.cityname); // save selected id to input
		   return false;
		}
	});
	
	
	$(".PropertyName" ).autocomplete({
	minLength: 3,
	source: function( request, response ) {
		$.ajax({
			url: homesearchurlnew,
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
	  
	  $('.PropertyName').val(ui.item.value);;
	 // display the selected text
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


$(document).ready(function(e) {
	var Hotealnamearray = [];
	var HotelnameArray = [];
	$('.hotellist-result').each(function() {
	
	var Hotelid = $(this).data('hotelid');
	var Hotelname = $(this).data('hotelname');
	HotelnameArray.push(Hotelname);
	Hotealnamearray.push({
            Id: Hotelid, 
            name:  Hotelname
        });
	});

	
	$( ".d" ).autocomplete({
      source: HotelnameArray
    });
	
	
	
	$(document).on('click', '.starrating', function(){
		
		var starratingValue = $(this).val();
		
		if(starratingValue){
		$('#minstar').val(starratingValue);
		$('#maxstar').val(starratingValue);
			
		}else{
		
		$('#minstar').val('');
		$('#maxstar').val('');
		
		}
		
		
		
		
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
		/*$('.searchroomlist2').hide();
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
			
			
		}*/
		
		
	});
	
	
	
	$(document).on('change', '.starmodify', function() {});	
			

	
	
	
	$(document).on('click', '.checkinorlando', function(){
		
		
		$('.dropdown-menu').hide();
		
	});
	
	$(document).on('change', '.nights', function(){
		
		var date = $('#m_datepicker_1').datepicker('getDate');
		var count_input = $(this).val();
		var count_num = parseInt(count_input);
		var time_count = parseInt(1000*60*60*24*count_num);
		if(date.getTime()){
		}else{
		date = new Date(); 
		}
		date.setTime(date.getTime() + (time_count))
		$('#m_datepicker_2').datepicker("setDate", date);
		$('#date_count').val(count_num);
		
	});
	
	
	$(document).on('change', '#m_datepicker_2', function(){
		$(".nightsshowa").show();
			var From_date = new Date($("#m_datepicker_1").val());
			var To_date = new Date($("#m_datepicker_2").val());
			var diff_date =  To_date - From_date;

			var years = Math.floor(diff_date/31536000000);
			var months = Math.floor((diff_date % 31536000000)/2628000000);
			var days = Math.floor(((diff_date % 31536000000) % 2628000000)/86400000);
			$("#date_count").html(years+" year(s) "+months+" month(s) "+days+" and day(s)");
			$("#date_count").val(days);
			$('#above_one_month').html('');
			$('.nights').val(days).attr("selected", "selected");
			if(months>=1){
				$("#m_datepicker_2").focus();
				$('#above_one_month').html('select below 30 days');
				$("#m_datepicker_2").val('');
			}
	
		
		
	});
	
	
	$(document).on('click', '.checkoutorlando', function(){
		
		
		$('.dropdown-menu').hide();
		
	});
	$(document).on('change', '.Addrooms', function(){
		//Add Rooms
		
		var room =$(this).val();
		//alert(room);
		for(i=1;i<=room;i++){
			
			$('.searchroomlist'+i).show();
			
		}
		for(i=4;i>room;i--){
			
			$('.searchroomlist'+i).hide();
			$().val('');
			$('.noadult'+i).val('0').attr("selected", "selected");
			$('.nochild'+i).val('0').attr("selected", "selected");
			var nochild = $('.nochild'+i).val();
			for(c=3;c>nochild;c--){
			  $('.nochildage'+i+c).val('');
			
			}
			
			
		}
		
		
/*		$('#norooms').val(room);
		//alert(room);
		$('.searchroomlist'+room).show();
		var addroom = parseInt(room) + parseInt(1);
		$('#addmaxroom').val(addroom);
		$('#removeminroom').val(room);
		$('.delaterooms').show();
		
		if(room == 5){
			$('.Addrooms').hide();
		}*/
		
		
	});
	$(document).on('click', '.nochild', function(){
		var addchild = $(this).val(); 
		var Proom = $(this).data('room');
		
		for(p=1;p<=addchild;p++){
		$('.searchroomlist'+Proom).show();
    $('.childagedivshow'+Proom).css('display', 'flex');
		$('.nochildageclass'+Proom+p).show();
	}
	
	for (n=3; n>addchild; n--) {
		$('.nochildageclass'+Proom+n).hide();
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
	
	
	
	
	
});
//Star check

$(document).on('click', '.star', function(e){
  	var values = $(this).val();
  	if(values == 'all'){
	    if($(this).prop('checked')){
			  $('.star').prop('checked', true);
	    }else{
	         $('.star').prop('checked', false);
	    }
	}else{
		$('.allcheckstar').prop('checked', false);
	}
  });


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
		
		
		
		
		
		if($("#newtactive").prop('checked') == true){
			
			$(".hotelserchtarget").attr("target","_blank");
    //do something
          }
		
		
		
  		//$('.loader-fixed').show();
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
  
  function numonly(root){
    var reet = root.value;    
    var arr1=reet.length;      
    var ruut = reet.charAt(arr1-1);   
        if (reet.length > 0){   
        var regex = /[0-9]|\./;   
            if (!ruut.match(regex)){   
            var reet = reet.slice(0, -1);   
            $(root).val(reet);   
            }   
        }  
      	if(parseInt(reet)>parseInt(99)){
      		$('#markup').val(99);
        }
 }

 
 
</script> 



    
	
	@endsection
