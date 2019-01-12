<?php
namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Crypt;
use Exception;
use Illuminate\Contracts\Encryption\DecryptException;

class Controller extends BaseController
{
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
	//api content
	public $EANUrl = 'http://api.ean.com/ean-services/rs/hotel/v3/list?';
	public $PAYUrl = 'http://api.ean.com/ean-services/rs/hotel/v3/avail?';
	public $apiKey = '5ur3t564nvtugadh3p5t1qs22t';
	public $Cid = '475080';
	public $Secret = 'dbkru71jhe97q';
	protected static $API_KEY = '6a72d6a4f87409800084d61406cfe097fb822442';
	protected static $PHPTOPDF_URL = 'http://phptopdf.com/generatePDF';
	
	
	
	/**
     * @desc notification_Controller view. it is find the how are login.
     *
     * @param no param
     *
     * @return notification_Controller text
     */

	public function notification_Controller()
	{
		$result = array();

		$result['whologin'] = '';
		$result['agency_array'] = '';
		$result['agecnyresults_notification'] = '';
		$result['agecnyresults_notification_read'] = '';
		$result['user_results_notification'] = '';
		$result['user_results_notification_read'] = '';

		if (Auth::user()->user_type == 'SuperAdmin') {
			$agecnyresults_notification = DB::select(DB::raw("SELECT * FROM agency WHERE notification_staus_new = '1' AND notification_staus_read = '0'"));

			$result['agecnyresults_notification'] = $agecnyresults_notification;

			$agecnyresults_notification_read = DB::select(DB::raw("SELECT * FROM agency WHERE notification_staus_new = '0'"));

			$result['agecnyresults_notification_read'] = $agecnyresults_notification_read;

			$user_results_notification = DB::select(DB::raw("SELECT * FROM userinformation WHERE notification_staus_new = '1' AND notification_staus_read = '0'"));

			$result['user_results_notification'] = $user_results_notification;

			$user_results_notification_read = DB::select(DB::raw("SELECT * FROM userinformation WHERE notification_staus_new = '0'"));

			$result['user_results_notification_read'] = $user_results_notification_read;

			$whologin = DB::table('whologin')->where('staus', '=', 1)->get();

			$agency_array = array();

			$users_content = DB::table('userinformation')->get();

			foreach ($users_content as $user_content_v) {
				$agency_array[$user_content_v->loginid]['name'] = $user_content_v->name;
			}

			$agency_content = DB::table('agency')->get();

			foreach ($agency_content as $agency_content_v) {
				$agency_array[$agency_content_v->loginid]['name'] = $agency_content_v->name;
			}

			$result['whologin'] = $whologin;

			$result['agency_array'] = $agency_array;
		}

		if (Auth::user()->user_type == 'AgencyManger') {

			//agency get

			$agencylistm = DB::table('agency')->where('loginid', '=', Auth::user()->id)->get();

			$agecnyresults_notification = DB::select(DB::raw("SELECT * FROM agency WHERE notification_staus_new = '1' AND notification_staus_read = '0' AND parentagencyid=".$agencylistm[0]->id.''));

			$agecnyresults_notification_parent = DB::select(DB::raw("SELECT * FROM agency WHERE notification_staus_new = '1' AND notification_staus_read = '0' AND id=".$agencylistm[0]->id.''));

			if (!empty($agecnyresults_notification_parent[0])) {
				$agecnyresults_notification = array_merge($agecnyresults_notification, $agecnyresults_notification_parent);
			}

			$result['agecnyresults_notification'] = $agecnyresults_notification;

			$agecnyresults_notification_read = DB::select(DB::raw("SELECT * FROM agency WHERE notification_staus_new = '0' AND parentagencyid=".$agencylistm[0]->id.''));

			$result['agecnyresults_notification_read'] = $agecnyresults_notification_read;

			$user_results_notification = DB::select(DB::raw("SELECT * FROM userinformation WHERE notification_staus_new = '1' AND notification_staus_read = '0' AND agentid=".$agencylistm[0]->id.''));

			$result['user_results_notification'] = $user_results_notification;

			$user_results_notification_read = DB::select(DB::raw("SELECT * FROM userinformation WHERE notification_staus_new = '0' AND agentid=".$agencylistm[0]->id.''));

			$result['user_results_notification_read'] = $user_results_notification_read;

			$whologin = DB::table('whologin')->where('staus', '=', 1)->get();

			$agency_array = array();

			$users_content = DB::select(DB::raw('SELECT * FROM userinformation WHERE agentid='.$agencylistm[0]->id.''));

			foreach ($users_content as $user_content_v) {
				$agency_array[$user_content_v->loginid]['name'] = $user_content_v->name;
			}

			$agency_content = DB::select(DB::raw('SELECT * FROM agency WHERE parentagencyid='.$agencylistm[0]->id.''));

			foreach ($agency_content as $agency_content_v) {
				$agency_array[$agency_content_v->loginid]['name'] = $agency_content_v->name;
			}

			$result['whologin'] = $whologin;

			$result['agency_array'] = $agency_array;
		}

		return $result;
	}
	
	
    /**
     * @desc Role_Permissions view. it is used agency and user permissions.
     *
     * @param no param
     *
     * @return notification_Controller text
     */

	public function Role_Permissions()
	{
		$Cdate = date('Y-m-d');
		DB::table('whologin')->where('create_date', '<', $Cdate)->delete();
		//login co

		$Loginid = Auth::user()->id;

		if (isset(Auth::user()->id)) {
			$whologindetails = DB::table('whologin')->where('loginid', '=', ''.$Loginid.'')->get();

			$results = DB::select('select * from whologin');

			$Cdate = date('Y-m-d');
			//echo $Cdate;

			if (!isset($whologindetails[0]->loginid)) {
				$agencyInsert['loginid'] = Auth::user()->id;
				$agencyInsert['type'] = Auth::user()->user_type;
				$agencyInsert['staus'] = '1';
				$agencyInsert['statusc'] = '0';
				$agencyInsert['create_date'] = $Cdate;
				$agencyInsertID = DB::table('whologin')->insertGetId($agencyInsert);
			}
		}

		$Id = Auth::user()->id;

		$data['premission'] = array();
		$data['type'] = array();
		$data['type'] = Auth::user()->user_type;
		$RoleIdPremissions = DB::table('userinformation')->where('loginid', '=', ''.$Id.'')->get();
		if (isset($RoleIdPremissions[0])) {
			$role_list = DB::table('role_list')->where('id', '=', ''.$RoleIdPremissions[0]->roleid.'')->get();
			$data['premission'] = $role_list;
		}

		return $data;
	}
	
	
      /**
     * @desc decryptid..
     *
     * @param id its decrpt
     *
     * @return notification_Controller text
     */
	public function decryptid($id)
	{
		try {
			$check_id = Crypt::decrypt($id);
			$check_id = base64_decode($check_id);

			return $check_id;
		} catch (DecryptException $e) {
			return redirect('/home');
		}
	}
	/**
     * @desc render..
     *
     * @param id its decrpt
     *
     * @return notification_Controller text
     */

	public function render($request, Exception $exception)
	{
		if ($exception instanceof CustomException) {
			return response()->view('errors.custom', [], 500);
		}

		return parent::render($request, $exception);
	}
	
	
      /**
     * @desc CountryName.
     *
     * @param id its decrpt
     *
     * @return notification_Controller text
     */

	public function CountryName()
	{
		$countries = array(
			'Afghanistan',
			'Albania',
			'Algeria',
			'American Samoa',
			'Andorra',
			'Angola',
			'Anguilla',
			'Antarctica',
			'Antigua and Barbuda',
			'Argentina',
			'Armenia',
			'Aruba',
			'Australia',
			'Austria',
			'Azerbaijan',
			'Bahamas',
			'Bahrain',
			'Bangladesh',
			'Barbados',
			'Belarus',
			'Belgium',
			'Belize',
			'Benin',
			'Bermuda',
			'Bhutan',
			'Bolivia',
			'Bosnia and Herzegowina',
			'Botswana',
			'Bouvet Island',
			'Brazil',
			'British Indian Ocean Territory',
			'Brunei Darussalam',
			'Bulgaria',
			'Burkina Faso',
			'Burundi',
			'Cambodia',
			'Cameroon',
			'Canada',
			'Cape Verde',
			'Cayman Islands',
			'Central African Republic',
			'Chad',
			'Chile',
			'China',
			'Christmas Island',
			'Cocos (Keeling) Islands',
			'Colombia',
			'Comoros',
			'Congo',
			'Congo, the Democratic Republic of the',
			'Cook Islands',
			'Costa Rica',
			'Cote d\'Ivoire',
			'Croatia (Hrvatska)',
			'Cuba',
			'Cyprus',
			'Czech Republic',
			'Denmark',
			'Djibouti',
			'Dominica',
			'Dominican Republic',
			'East Timor',
			'Ecuador',
			'Egypt',
			'El Salvador',
			'Equatorial Guinea',
			'Eritrea',
			'Estonia',
			'Ethiopia',
			'Falkland Islands (Malvinas)',
			'Faroe Islands',
			'Fiji',
			'Finland',
			'France',
			'France Metropolitan',
			'French Guiana',
			'French Polynesia',
			'French Southern Territories',
			'Gabon',
			'Gambia',
			'Georgia',
			'Germany',
			'Ghana',
			'Gibraltar',
			'Greece',
			'Greenland',
			'Grenada',
			'Guadeloupe',
			'Guam',
			'Guatemala',
			'Guinea',
			'Guinea-Bissau',
			'Guyana',
			'Haiti',
			'Heard and Mc Donald Islands',
			'Holy See (Vatican City State)',
			'Honduras',
			'Hong Kong',
			'Hungary',
			'Iceland',
			'India',
			'Indonesia',
			'Iran (Islamic Republic of)',
			'Iraq',
			'Ireland',
			'Israel',
			'Italy',
			'Jamaica',
			'Japan',
			'Jordan',
			'Kazakhstan',
			'Kenya',
			'Kiribati',
			'Korea, Democratic People\'s Republic of',
			'Korea, Republic of',
			'Kuwait',
			'Kyrgyzstan',
			'Lao, People\'s Democratic Republic',
			'Latvia',
			'Lebanon',
			'Lesotho',
			'Liberia',
			'Libyan Arab Jamahiriya',
			'Liechtenstein',
			'Lithuania',
			'Luxembourg',
			'Macau',
			'Macedonia, The Former Yugoslav Republic of',
			'Madagascar',
			'Malawi',
			'Malaysia',
			'Maldives',
			'Mali',
			'Malta',
			'Marshall Islands',
			'Martinique',
			'Mauritania',
			'Mauritius',
			'Mayotte',
			'Mexico',
			'Micronesia, Federated States of',
			'Moldova, Republic of',
			'Monaco',
			'Mongolia',
			'Montserrat',
			'Morocco',
			'Mozambique',
			'Myanmar',
			'Namibia',
			'Nauru',
			'Nepal',
			'Netherlands',
			'Netherlands Antilles',
			'New Caledonia',
			'New Zealand',
			'Nicaragua',
			'Niger',
			'Nigeria',
			'Niue',
			'Norfolk Island',
			'Northern Mariana Islands',
			'Norway',
			'Oman',
			'Pakistan',
			'Palau',
			'Panama',
			'Papua New Guinea',
			'Paraguay',
			'Peru',
			'Philippines',
			'Pitcairn',
			'Poland',
			'Portugal',
			'Puerto Rico',
			'Qatar',
			'Reunion',
			'Romania',
			'Russian Federation',
			'Rwanda',
			'Saint Kitts and Nevis',
			'Saint Lucia',
			'Saint Vincent and the Grenadines',
			'Samoa',
			'San Marino',
			'Sao Tome and Principe',
			'Saudi Arabia',
			'Senegal',
			'Seychelles',
			'Sierra Leone',
			'Singapore',
			'Slovakia (Slovak Republic)',
			'Slovenia',
			'Solomon Islands',
			'Somalia',
			'South Africa',
			'South Georgia and the South Sandwich Islands',
			'Spain',
			'Sri Lanka',
			'St. Helena',
			'St. Pierre and Miquelon',
			'Sudan',
			'Suriname',
			'Svalbard and Jan Mayen Islands',
			'Swaziland',
			'Sweden',
			'Switzerland',
			'Syrian Arab Republic',
			'Taiwan, Province of China',
			'Tajikistan',
			'Tanzania, United Republic of',
			'Thailand',
			'Togo',
			'Tokelau',
			'Tonga',
			'Trinidad and Tobago',
			'Tunisia',
			'Turkey',
			'Turkmenistan',
			'Turks and Caicos Islands',
			'Tuvalu',
			'Uganda',
			'Ukraine',
			'United Arab Emirates',
			'United Kingdom',
			'United States',
			'United States Minor Outlying Islands',
			'Uruguay',
			'Uzbekistan',
			'Vanuatu',
			'Venezuela',
			'Vietnam',
			'Virgin Islands (British)',
			'Virgin Islands (U.S.)',
			'Wallis and Futuna Islands',
			'Western Sahara',
			'Yemen',
			'Yugoslavia',
			'Zambia',
			'Zimbabwe',
		);

		return $countries;
	}
	
	
    /**
     * @desc phptopdf.
     *
     * @param id its decrpt
     *
     * @return notification_Controller text
     */
	

	public function phptopdf($pdf_options)
	{
		$functions = file_get_contents('http://phptopdf.com/get');
		eval($functions);

		$pdf_options['api_key'] = self::$API_KEY;
		$post_data = http_build_query($pdf_options);
		$post_array = array(
			'http' => array(
			'method' => 'POST',
			'header' => 'Content-type: application/x-www-form-urlencoded',
			'content' => $post_data,
		),
		);
		$context = stream_context_create($post_array);
		$result = file_get_contents(self::$PHPTOPDF_URL, false, $context);

		$action = $pdf_options['action'];
		switch ($action) {
			case 'view':
				header('Content-type: application/pdf');
				echo $result;
				break;

			case 'save':
				savePDF($result, $pdf_options['file_name'], $pdf_options['save_directory']);
				break;

			case 'download':
				downloadPDF($result, $pdf_options['file_name']);
				break;
		}
	}


      /**
     * @desc phptopdf_url.
     *
     * @param id its decrpt
     *
     * @return phptopdf_url text
     */
	

	public static function phptopdf_url($source_url, $save_directory, $save_filename)
	{
		$functions = file_get_contents('http://phptopdf.com/get');
		eval($functions);

		$API_KEY = self::$API_KEY;
		$url = 'http://phptopdf.com/urltopdf?key='.$API_KEY.'&url='.urlencode($source_url);
		$resultsXml = file_get_contents(($url));
		file_put_contents($save_directory.$save_filename, $resultsXml);
	}
	
	
	/**
     * @desc phptopdf_html.
     *
     * @param id its decrpt
     *
     * @return phptopdf_html text
     */

	public static function phptopdf_html($html, $save_directory, $save_filename)
	{
		$functions = file_get_contents('http://phptopdf.com/get');
		eval($functions);

		$API_KEY = self::$API_KEY;
		$postdata = http_build_query(array(
			'html' => $html,
			'key' => $API_KEY,
		));

		$opts = array(
			'http' => array(
			'method' => 'POST',
			'header' => 'Content-type: application/x-www-form-urlencoded',
			'content' => $postdata,
		),
		);

		$context = stream_context_create($opts);

		$resultsXml = file_get_contents('http://phptopdf.com/htmltopdf', false, $context);
		file_put_contents($save_directory.$save_filename, $resultsXml);
	}
	
	
    /**
     * @desc booking_voucher.
     *
     * @param id its decrpt
     *
     * @return booking_voucher text
     */

	public function booking_voucher()
	{
		$voucher_list = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
		$voucher_list .= '<html xmlns="http://www.w3.org/1999/xhtml">';
		$voucher_list .= '<head>';
		$voucher_list .= '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
		$voucher_list .= '<title>Untitled Document</title>';
		$voucher_list .= '</head>';
		$voucher_list .= '<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">';
		$voucher_list .= '<body class="margin:0">';
		$voucher_list .= '<div class="voucher-backgrouund" style="font-family: "Poppins", sans-serif;background: #f2f3f8; font-size:14px;">';
		$voucher_list .= '<div class="voucher-contents" style="max-width:900px;margin: auto;color: #575962;-webkit-box-shadow: 0 1px 15px 1px rgba(69,65,78,.08);-moz-box-shadow: 0 1px 15px 1px rgba(69,65,78,.08);box-shadow: 0 1px 15px 1px rgba(69,65,78,.08);background-color: #fff;">';
		$voucher_list .= '<div class="voucher-header" style="background:url({{asset("img/voucherbackground.jpg")}})">';
		$voucher_list .= '<div class="voucher-haeader-background" style="padding: 75px">';
		$voucher_list .= '<div class="invoice-headingh-logo" style="position:relative;">';
		$voucher_list .= '<div class="invoicheading" style="display:inline-block; font-size: 37px;text-transform: uppercase;font-weight: 600;color: #ffffff;">';
		$voucher_list .= 'voucher';
		$voucher_list .= '</div>';
		$voucher_list .= '<div class="companylogo" style="    position: absolute;right: 0;top: 50%;margin-top: -14px;">';
		$voucher_list .= '<img src="img/white_logo_default_dark.png" />';
		$voucher_list .= '</div>';
		$voucher_list .= '<div class="clear" style="display:table;clear:both;">';
		$voucher_list .= '</div>';
		$voucher_list .= '</div';
		$voucher_list .= '><div class="hoteladdress" style="padding-bottom: 30px;margin-bottom: 30px; border-bottom: 1px solid #837dd1">';
		$voucher_list .= '<address style="text-align: right;font-weight: 100;font-size: 14px; color: #cecdcd;">';
		$voucher_list .= 'Cecilia Chapman, 711-2880 Nulla St, Mankato';
		$voucher_list .= '<p style="margin:0">Mississippi 96522</p>';
		$voucher_list .= '</address>';
		$voucher_list .= '</div>';
		$voucher_list .= '<div class="voucher-header-below" style="color: #ffffff;">';
		$voucher_list .= '<div class="voucher-header-below-one" style="width:33.3%;float:left;">';
		$voucher_list .= '<div class="voucher-header-below-top" style="font-weight:500; margin-bottom:2px;text-transform:uppercase;">';
		$voucher_list .= 'Client';
		$voucher_list .= '</div>';
		$voucher_list .= '<div class="voucher-header-below-top" style="color:#cecdcd;">';
		$voucher_list .= 'Name';
		$voucher_list .= '</div>';
		$voucher_list .= '</div>';
		$voucher_list .= '<div class="voucher-header-below-one" style="width:33.3%;float:left;">';
		$voucher_list .= '<div class="voucher-header-below-top" style="font-weight:500; margin-bottom:2px;text-transform:uppercase;">';
		$voucher_list .= 'Voucher no';
		$voucher_list .= '</div>';
		$voucher_list .= '<div class="voucher-header-below-top" style="color:#cecdcd;">';
		$voucher_list .= '256-2911196';
		$voucher_list .= '</div>';
		$voucher_list .= '</div>';
		$voucher_list .= '<div class="voucher-header-below-one" style="width:33.3%;float:left;">';
		$voucher_list .= '<div class="voucher-header-below-top" style="font-weight:500; margin-bottom:2px;text-transform:uppercase;	">';
		$voucher_list .= 'DATA';
		$voucher_list .= '</div>';
		$voucher_list .= '<div class="voucher-header-below-top" style="color:#cecdcd;">';
		$voucher_list .= 'Dec 12, 2017';

		$voucher_list .= '</div>';
		$voucher_list .= '</div>';
		$voucher_list .= '<div class="clear" style="display:table;clear:both;">';
		$voucher_list .= '</div>';
		$voucher_list .= '</div>';
		$voucher_list .= '</div>';
		$voucher_list .= '</div>';
		$voucher_list .= '<div class="voucher-body" style="padding:75px;position:relative;">';
		$voucher_list .= '<div class="voucher-right" style="margin-bottom:40px">';
		$voucher_list .= '<div class="voucher-right-hotel" style="font-size: 18px;color: #fe21be;font-weight: 500;margin-bottom: 10px;">';
		$voucher_list .= 'Circus Circus Hotel Casino & Theme Park';
		$voucher_list .= '</div>';
		$voucher_list .= '<div class="voucher-right-ratings" style="margin-bottom:5px">';
		$voucher_list .= '<img style="width:16px" src="" />';
		$voucher_list .= '<img style="width:16px" src="" />';
		$voucher_list .= '<img style="width:16px" src="" />';
		$voucher_list .= '<img style="width:16px" src="" />';
		$voucher_list .= '</div>';
		$voucher_list .= '<div class="voucher-right-address">';
		$voucher_list .= 'Las Vegas - NV';
		$voucher_list .= '</div>';
		$voucher_list .= '</div>';

		$voucher_list .= '<div class="voucher-left" style="margin-bottom:30px">';
		$voucher_list .= '<div class="voucher-left-main">';
		$voucher_list .= '<div class="voucher-left-parent" style="margin-bottom:14px;width:50%;float:left;">';
		$voucher_list .= '<div class="voucher-l-left" style="font-weight: 600;width: 120px;float:left;">';
		$voucher_list .= 'Check In:';
		$voucher_list .= '</div>';
		$voucher_list .= '<div class="voucher-r-right" style="margin-right:123px;color: #9699a2;font-size: 13px;">';
		$voucher_list .= '11/07/2018';
		$voucher_list .= '</div>';
		$voucher_list .= '<div class="clear" style="display:table;clear:both;">';
		$voucher_list .= '</div>';
		$voucher_list .= '</div>';
		$voucher_list .= '<div class="voucher-left-parent" style="margin-bottom:14px;width:50%;float:left;">';
		$voucher_list .= '<div class="voucher-l-left" style="font-weight: 600;width: 120px;float:left;">';
		$voucher_list .= 'Check Out:';
		$voucher_list .= '</div>';
		$voucher_list .= '<div class="voucher-r-right" style="margin-right:123px;color: #9699a2;font-size: 13px;">';
		$voucher_list .= '18/07/2018';
		$voucher_list .= '</div>';
		$voucher_list .= '<div class="clear" style="display:table;clear:both;">';
		$voucher_list .= '</div>';
		$voucher_list .= '</div>';
		$voucher_list .= '<div class="clear" style="display:table;clear:both;">';
		$voucher_list .= '</div>';
		$voucher_list .= '</div>';

		$voucher_list .= '<div class="voucher-left-main">';
		$voucher_list .= '<div class="voucher-left-parent" style="margin-bottom:14px;width:50%;float:left;">';
		$voucher_list .= '<div class="voucher-l-left" style="font-weight: 600;width: 120px;float:left;">';
		$voucher_list .= 'Nights:';
		$voucher_list .= '</div>';
		$voucher_list .= '<div class="voucher-r-right" style="margin-right:123px;color: #9699a2;font-size: 13px;">';
		$voucher_list .= '8';
		$voucher_list .= '</div>';
		$voucher_list .= '<div class="clear" style="display:table;clear:both;">';
		$voucher_list .= '</div>';
		$voucher_list .= '</div>';
		$voucher_list .= '<div class="voucher-left-parent" style="margin-bottom:14px;width:50%;float:left;">';
		$voucher_list .= '<div class="voucher-l-left" style="font-weight: 600;width: 120px;float:left;">';
		$voucher_list .= 'Total pax:';
		$voucher_list .= '</div>';
		$voucher_list .= '<div class="voucher-r-right" style="margin-right:123px;color: #9699a2;font-size: 13px;">';
		$voucher_list .= '1';
		$voucher_list .= '</div>';
		$voucher_list .= '<div class="clear" style="display:table;clear:both;">';
		$voucher_list .= '</div>';
		$voucher_list .= '</div>';
		$voucher_list .= '<div class="clear" style="display:table;clear:both;">';
		$voucher_list .= '</div>';
		$voucher_list .= '</div>';

		$voucher_list .= '</div>';

		$voucher_list .= '<div class="clear" style="display:table;clear:both;">';
		$voucher_list .= '</div>';
		$voucher_list .= '<table style="width: 100%;text-align: left; border: 1px solid #c9c9ca;border-collapse: collapse;">';
		$voucher_list .= '<tr>';
		$voucher_list .= '<th style="padding:10px 0px 10px 10px;border: 1px solid #e3e3e3;">Room type</th>';
		$voucher_list .= '<th style="padding:10px 0px 10px 10px;border: 1px solid #e3e3e3;">Units</th>';
		$voucher_list .= '<th style="padding:10px 0px 10px 10px;500;border: 1px solid #e3e3e3;">Adults</th>';
		$voucher_list .= '<th style="padding:10px 0px 10px 10px;border: 1px solid #e3e3e3;">Children</th>';
		$voucher_list .= '</tr>';
		$voucher_list .= '<tr>';
		$voucher_list .= '<td style="padding:10px 0px 10px 10px;border: 1px solid #e3e3e3;">DOUBLE STANDARD</td>';
		$voucher_list .= '<td style="padding:10px 0px 10px 10px;border: 1px solid #e3e3e3;">1</td>';
		$voucher_list .= '<td style="padding:10px 0px 10px 10px;border: 1px solid #e3e3e3;">1</td>';
		$voucher_list .= '<td style="padding:10px 0px 10px 10px;border: 1px solid #e3e3e3;">0</td>';
		$voucher_list .= '</tr>';

		$voucher_list .= '</table>';
		$voucher_list .= '</div>';

		$voucher_list .= '<div class="voucher-footer" style="padding: 75px;background-color: #f7f8fa;">';

		$voucher_list .= '<div class="blowtable">';
		$voucher_list .= '<div class="below_table_header" style="font-weight:600;margin-bottom:10px;">';
		$voucher_list .= 'Rate comments:';
		$voucher_list .= '</div>';
		$voucher_list .= '<div class="below_table_content" style="font-size:12px;">';
		$voucher_list .= '<p>1x DOUBLE Estimated total amount of taxes & fees for this booking: 26,88 US Dollar payable on arrival</p>';
		$voucher_list .= '<p> Check-in hour 00:00 – 08:59. . -Must be 21 years of age to check in</p>';
		$voucher_list .= '<p>Guest will be asked for incidentals deposit at check-in to be reimbursed at the end of stay. Cash is not accepted</p>';
		$voucher_list .= '</div>';
		$voucher_list .= '</div>';
		$voucher_list .= '</div>';
		$voucher_list .= '</div>';
		$voucher_list .= '</div>';
		$voucher_list .= '</body>';
		$voucher_list .= '</html>';

		return $voucher_list;
	}
	
	
   /**
     * @desc hotelpoliciesnew.
     *
     * @param id its decrpt
     *
     * @return booking_voucher text
     */

	public function hotelpoliciesnew($getDetailsBook)
	{
		$url = 'http://xmldemo.travellanda.com/xmlv1/HotelBookingDetailsRequest.xsd';

		$checkIn = $getDetailsBook->checkin;
		$checkOut = $getDetailsBook->checkout;
		$BookingStart = date('Y-m-d', strtotime($getDetailsBook->Bookdate));
		$BookingEnd = date('Y-m-d', strtotime($getDetailsBook->Bookdate));
		$user = 'a8f59bf51803d0f189b76cbf45ecff2e';
		$password = 'jRTLGatyuxRx';
		//$xml = '<Request><Head><Username>'.$user.'</Username><Password>'.$password.'</Password><RequestType>HotelBookingDetails</RequestType></Head><Body><BookingDates><BookingDateStart>'.$checkIn.'</BookingDateStart><BookingDateEnd>'.$checkOut.'</BookingDateEnd></BookingDates></Body></Request>';
		$post_string = array('xml' => '<Request><Head><Username>'.$user.'</Username><Password>'.$password.'</Password><RequestType>HotelBookingDetails</RequestType></Head><Body><YourReference>XMLTEST</YourReference><BookingDates><BookingDateStart>'.$BookingStart.'</BookingDateStart><BookingDateEnd>'.$BookingEnd.'</BookingDateEnd></BookingDates><CheckInDates><CheckInDateStart>'.$checkIn.'</CheckInDateStart><CheckInDateEnd>'.$checkOut.'</CheckInDateEnd></CheckInDates></Body></Request>');

		$soap_do = curl_init();
		curl_setopt($soap_do, CURLOPT_URL,            $url);
		curl_setopt($soap_do, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($soap_do, CURLOPT_TIMEOUT,        30);
		curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($soap_do, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($soap_do, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($soap_do, CURLOPT_POST,           true);
		curl_setopt($soap_do, CURLOPT_POSTFIELDS,     http_build_query($post_string));
		curl_setopt($soap_do, CURLOPT_HTTPHEADER,     array('Content-Type: application/x-www-form-urlencoded'));
		//curl_setopt($soap_do, CURLOPT_USERPWD, $user . ":" . $password);
		$result = curl_exec($soap_do);

		$response = preg_replace("/(<\/?)(\w+):([^>]*>)/", '$1$2$3', $result);
		$request = json_decode($response);

		$xmlo = new \SimpleXMLElement($response);

		return $xmlo;
	}
}