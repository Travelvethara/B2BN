<?php

namespace App\Http\Controllers\Bookingreport;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use App\Http\Controllers\Hotel\HotelApiController;
use PDF;

class BookingreportController extends HotelApiController
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Ageny vouchecd_booking module. It is list booking reprt.
     *
     *@param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function vouchecd_booking()
    {

        //get data from database

        $notification_Controller = controller::notification_Controller();

        //print_r($RoleIdPremissions);

        $data['whologin'] = $notification_Controller['whologin'];

        $data['activeDetails'] = $notification_Controller['agency_array'];

        $data['agecnyresultsnotification'] = $notification_Controller['agecnyresults_notification'];

        $data['agecnyresultsnotificationread'] = $notification_Controller['agecnyresults_notification_read'];

        $data['userresultsnotification'] = $notification_Controller['user_results_notification'];

        $data['userresultsnotificationread'] = $notification_Controller['user_results_notification_read'];

        $data['pagename'] = 'vouchecdbooking';

        $vouched_booking = DB::table('payment')->where('booking_confirm', '=', '1')->get();

        $CancelPolicy_tbo = array();

        $hotel_booking = array();

        $RolenameArray = array();

        foreach ($vouched_booking as $vouched_booking_get) {
            if ($vouched_booking_get->user_type == 'AgencyManger') {
                $agency = DB::table('agency')->where('loginid', '=', $vouched_booking_get->login_id)->get();

                $RolenameArray['AgencyManger'][$vouched_booking_get->login_id] = $agency[0]->aname;
            }

            if ($vouched_booking_get->user_type == 'SubAgencyManger') {
                $agency = DB::table('agency')->where('loginid', '=', $vouched_booking_get->login_id)->get();

                $RolenameArray['SubAgencyManger'][$vouched_booking_get->login_id] = $agency[0]->aname;
            }

            if ($vouched_booking_get->user_type == 'UserInfo') {
                $userinformation = DB::table('userinformation')->where('loginid', '=', $vouched_booking_get->login_id)->get();

                $RolenameArray['UserInfo'][$vouched_booking_get->login_id] = $userinformation[0]->name;
            }

            if ($vouched_booking_get->user_type == 'SuperAdmin') {
                $RolenameArray['SuperAdmin'][0] = 'SuperAdmin';
            }

            if ($vouched_booking_get->supplier == 'tbo') {
                $hotel_booking = $this->tbobboking_details($vouched_booking_get->BookingReference);

                $attr = '@attributes';

                $hotel_booking['hotel_booking']['bookingid'.$vouched_booking_get->BookingReference] = $hotel_booking;

                $CancelPolicy_tbo['CancelPolicy']['bookingid'.$vouched_booking_get->BookingReference] = $hotel_booking['sBody']['HotelBookingDetailResponse']['BookingDetail']['HotelCancelPolicies']['CancelPolicy'];

            }
        }

        $data['RolenameArray'] = $RolenameArray;

        $data['CancelPolicy_tbo'] = $CancelPolicy_tbo;

        $data['vouched_booking'] = $vouched_booking;

        $data['hotel_booking'] = $hotel_booking;

        $RoleIdPremissions = controller::Role_Permissions();

        $data['Premissions'] = $RoleIdPremissions;

        return view('bookingreport.voucherbookingList', $data);
    }
	
	/**
     * Ageny unvouchecd_booking module. It is list booking reprt.
     *
     *@param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */

    public function unvouchecd_booking()
    {
        $data['pagename'] = 'unvouchecdbooking';

        //get data from database

        //>=

        $notification_Controller = controller::notification_Controller();

        //print_r($RoleIdPremissions);

        $data['whologin'] = $notification_Controller['whologin'];

        $data['activeDetails'] = $notification_Controller['agency_array'];

        $data['agecnyresultsnotification'] = $notification_Controller['agecnyresults_notification'];

        $data['agecnyresultsnotificationread'] = $notification_Controller['agecnyresults_notification_read'];

        $data['userresultsnotification'] = $notification_Controller['user_results_notification'];

        $data['userresultsnotificationread'] = $notification_Controller['user_results_notification_read'];

        $today = date('Y-m-d');

        $vouched_booking = DB::table('payment')->where('checkin', '>=', $today)->where('booking_confirm', '!=', 2)->get();

        /*echo "<pre>";

        print_r($vouched_booking);

        echo "</pre>";*/

        $agency_id = array();

        $agencyCraditlimit = array();

        $subagencyCraditlimit = array();

        $useragencyCraditlimit = array();

        foreach ($vouched_booking as $getdetails) {
            $login_ID = $getdetails->login_id;

            //agency

            $checkcreditlimit = '';

            if ($getdetails->user_type == 'AgencyManger') {
                $checkcreditlimit = DB::table('agency')->where('loginid', '=', $login_ID)->get();

                if (!empty($checkcreditlimit)) {
                    $agencyCraditlimit[$checkcreditlimit[0]->loginid] = $checkcreditlimit[0]->current_credit_limit;
                }
            }

            if ($getdetails->user_type == 'SubAgencyManger') {
                $agaeny_id = DB::table('agency')->where('loginid', '=', $login_ID)->get();

                $subagaeny_id = DB::table('agency')->where('id', '=', $agaeny_id[0]->parentagencyid)->get();

                if (!empty($subagaeny_id)) {
                    $subagencyCraditlimit[$agaeny_id[0]->loginid] = $subagaeny_id[0]->current_credit_limit;
                }
            }

            if ($getdetails->user_type == 'UserInfo') {
                $agaeny_id = DB::table('userinformation')->where('loginid', '=', $login_ID)->get();

                $subagaeny_id = DB::table('agency')->where('id', '=', $agaeny_id[0]->agentid)->get();

                if (!empty($subagaeny_id)) {
                    $useragencyCraditlimit[$agaeny_id[0]->loginid] = $subagaeny_id[0]->current_credit_limit;
                }
            }
        }

        $agency = DB::table('agency')->get();

        $userinformation = DB::table('userinformation')->get();

        $userinformationArray = array();

        $agencyArray = array();

        foreach ($agency as $agency_info) {
            $agencyArray[$agency_info->loginid] = $agency_info->aname;
        }

        foreach ($userinformation as $userinformation_info) {
            $userinformationArray[$userinformation_info->loginid] = $userinformation_info->name;
        }

        $data['agencyArray'] = $agencyArray;

        $data['userinformationArray'] = $userinformationArray;

        //exit;

        $data['agency_cradit'] = $agencyCraditlimit;

        $data['vouched_booking'] = $vouched_booking;

        $data['agencyCraditlimit'] = $agencyCraditlimit;

        $data['useragencyCraditlimit'] = $useragencyCraditlimit;

        $data['subagencyCraditlimit'] = $subagencyCraditlimit;

        $RoleIdPremissions = controller::Role_Permissions();

        $data['Premissions'] = $RoleIdPremissions;

        return view('bookingreport.unvoucherbookingList', $data);
    }
	
	/**
     * Ageny paybookingurl module. It is list booking reprt.
     *
     *@param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */

    public function paybookingurl(Request $request)
    {
        $Booking_payment = DB::table('payment')->where('id', '=', $request->input('bookingid'))->get();

        $datainsert = array();

        if ($Booking_payment[0]->user_type == 'SuperAdmin') {
            $datainsert['booking_confirm'] = 1;
        } else {

            //agency manager

            if ($Booking_payment[0]->user_type == 'AgencyManger') {
                $checkcreditlimit = DB::table('agency')->where('loginid', '=', $Booking_payment[0]->login_id)->get();

                if ($Booking_payment[0]->totalprice <= $checkcreditlimit[0]->current_credit_limit) {
                    $datainsert['booking_confirm'] = 1;

                    //minmize condttions

                    $bal_limit = $checkcreditlimit[0]->current_credit_limit - $Booking_payment[0]->totalprice;

                    //update

                    $lastInsertedID = DB::table('agency')->where('id', $checkcreditlimit[0]->id)->update(['current_credit_limit' => $bal_limit]);
                } else {
                    $datainsert['booking_confirm'] = 0;
                }
            } elseif ($Booking_payment[0]->user_type == 'SubAgencyManger') {
                $checkcreditlimit_parent = DB::table('agency')->where('loginid', '=', $Booking_payment[0]->login_id)->get();

                $checkcreditlimit = DB::table('agency')->where('id', '=', $checkcreditlimit_parent[0]->parentagencyid)->get();

                if ($Booking_payment[0]->totalprice <= $checkcreditlimit[0]->current_credit_limit) {
                    $datainsert['booking_confirm'] = 1;

                    //minmize condttions

                    $bal_limit = $checkcreditlimit[0]->current_credit_limit - $Booking_payment[0]->totalprice;

                    //update

                    $lastInsertedID = DB::table('agency')->where('id', $checkcreditlimit[0]->id)->update(['current_credit_limit' => $bal_limit]);
                } else {
                    $datainsert['booking_confirm'] = 0;
                }
            } elseif ($Booking_payment[0]->user_type == 'UserInfo') {
                $userinformation = DB::table('userinformation')->where('loginid', '=', $Booking_payment[0]->login_id)->get();

                if ($userinformation[0]->agentid != 0) {

                    //agency user

                    $checkcreditlimit = DB::table('agency')->where('id', '=', $userinformation[0]->agentid)->get();

                    if ($Booking_payment[0]->totalprice <= $checkcreditlimit[0]->current_credit_limit) {
                        $datainsert['booking_confirm'] = 1;

                        //minmize condttions

                        $bal_limit = $checkcreditlimit[0]->current_credit_limit - $Booking_payment[0]->totalprice;

                        //update

                        $lastInsertedID = DB::table('agency')->where('id', $checkcreditlimit[0]->id)->update(['current_credit_limit' => $bal_limit]);
                    } else {
                        $datainsert['booking_confirm'] = 0;
                    }
                } else {

                    //admin user

                    $datainsert['booking_confirm'] = 1;
                }
            }

            //sub agency manager

            //user info
        }

        if ($datainsert['booking_confirm'] == 1) {
            DB::table('payment')->where('id', $request->input('bookingid'))->update(['booking_confirm' => 1]);
        }

        $listarray = array();

        $listarray['bookingConfirm'] = $datainsert['booking_confirm'];

        if (!empty($request->input('rolename'))) {
            $listarray['URL'] = url('/agencyUnBookingdetails');
        } else {
            $listarray['URL'] = url('/unvouchecdbooking');
        }

        echo json_encode($listarray);

        exit;
    }
	
	
	/**
     * Ageny cancelled_booking module. It is list booking reprt.
     *
     * @return \Illuminate\Http\Response
     */

    public function cancelled_booking()
    {

        //get data from database

        $notification_Controller = controller::notification_Controller();

        //print_r($RoleIdPremissions);

        $data['whologin'] = $notification_Controller['whologin'];

        $data['activeDetails'] = $notification_Controller['agency_array'];

        $data['agecnyresultsnotification'] = $notification_Controller['agecnyresults_notification'];

        $data['agecnyresultsnotificationread'] = $notification_Controller['agecnyresults_notification_read'];

        $data['userresultsnotification'] = $notification_Controller['user_results_notification'];

        $data['userresultsnotificationread'] = $notification_Controller['user_results_notification_read'];

        $data['pagename'] = 'cancelledbooking';

        $vouched_booking = DB::table('payment')->where('booking_confirm', '=', '2')->get();

        $agency_booking1 = array();

        if (Auth::user()->user_type == 'SuperAdmin') {
            $agency_booking1 = $vouched_booking;
        }

        //echo Auth::user()->user_type;

        $Loginid = Auth::user()->id;

        if (Auth::user()->user_type == 'AgencyManger') {
            $agency_booking = DB::table('payment')->where('login_id', '=', $Loginid)->where('booking_confirm', '=', 2)->get();

            foreach ($agency_booking as $agency_booking_values) {
                $agency_booking1[] = $agency_booking_values;
            }

            $agaency_id_check = DB::table('agency')->where('loginid', '=', $Loginid)->get();

            //include  sub agency

            $parentagencyid = DB::table('agency')->where('parentagencyid', '=', $agaency_id_check[0]->id)->get();

            //uesr

            $userinfo = DB::table('userinformation')->where('agentid', '=', $agaency_id_check[0]->id)->get();

            /* echo '<pre>';

               print_r($userinfo);

               echo '</pre>';*/

            if (!empty($parentagencyid[0]->id)) {
                $agency_booking_sub = DB::table('payment')->where('login_id', '=', $parentagencyid[0]->loginid)->where('booking_confirm', '=', 2)->get();

                foreach ($agency_booking_sub as $agency_booking_sub_values) {
                    $agency_booking1[] = $agency_booking_sub_values;
                }
            }

            if (!empty($userinfo[0]->id)) {
                $agency_booking_user = DB::table('payment')->where('login_id', '=', $userinfo[0]->loginid)->where('booking_confirm', '=', 2)->get();

                foreach ($agency_booking_user as $agency_booking_user_values) {
                    $agency_booking1[] = $agency_booking_user_values;
                }
            }
        }

        if (Auth::user()->user_type == 'SubAgencyManger') {
            $agaency_id_check = DB::table('agency')->where('loginid', '=', $Loginid)->get();

            $parentagencyid = DB::table('agency')->where('parentagencyid', '=', $agaency_id_check[0]->id)->get();

            if (!empty($parentagencyid[0]->id)) {
                $agency_booking = DB::table('payment')->where('login_id', '=', $parentagencyid[0]->loginid)->where('booking_confirm', '=', '2')->where('user_type', '=', 'SubAgencyManger')->get();
            }
        }

        if (Auth::user()->user_type == 'UserInfo') {
            $user_id_check = DB::table('userinformation')->where('loginid', '=', $Loginid)->get();

            if (!empty($user_id_check[0]->id)) {
                $agency_booking = DB::table('payment')->where('login_id', '=', $Loginid)->where('booking_confirm', '=', '2')->where('user_type', '=', 'UserInfo')->get();

                /* echo '<pre>';

                print_r($agency_booking);

                echo '</pre>';*/

                foreach ($agency_booking as $agency_booking_values) {
                    $agency_booking1[] = $agency_booking_values;
                }
            }
        }

        $data['vouched_booking'] = $agency_booking1;

        $RoleIdPremissions = controller::Role_Permissions();

        $data['Premissions'] = $RoleIdPremissions;

        return view('bookingreport.cancellationbookingList', $data);
    }
	
	
		/**
     * Ageny agencyddetailbookingreport module. It is list booking reprt.
     *
     * @return \Illuminate\Http\Response
     */

    public function agencyddetailbookingreport()
    {
        $data['pagename'] = 'agencyddetailbookingreport';

        $notification_Controller = controller::notification_Controller();

        //print_r($RoleIdPremissions);

        $data['whologin'] = $notification_Controller['whologin'];

        $data['activeDetails'] = $notification_Controller['agency_array'];

        $data['agecnyresultsnotification'] = $notification_Controller['agecnyresults_notification'];

        $data['agecnyresultsnotificationread'] = $notification_Controller['agecnyresults_notification_read'];

        $data['userresultsnotification'] = $notification_Controller['user_results_notification'];

        $data['userresultsnotificationread'] = $notification_Controller['user_results_notification_read'];

        $agency = DB::table('agency')->where('parentagencyid', '=', 0)->get();

        $agency_creadit_limit = array();

        $agencyarray = array();

        $agency_creadit_limit_total = array();

        foreach ($agency as $agency_creadit_limit_list) {
            $agency_booking = DB::table('payment')->where('login_id', '=', $agency_creadit_limit_list->loginid)->where('booking_confirm', '=', '1')->get();

            $totalprice = 0;

            $totalprice_sub = 0;

            $totalprice_user = 0;

            if (!empty($agency_booking[0]->totalprice)) {
                foreach ($agency_booking as $agency_booking_List) {
                    $totalprice += $agency_booking_List->totalprice;

                    $agency_creadit_limit_total[$agency_creadit_limit_list->loginid] = $totalprice;
                }
            }

            //Sub agency

            $Sub_agency = DB::table('agency')->where('parentagencyid', '=', $agency_creadit_limit_list->id)->get();

            if (!empty($Sub_agency)) {
                foreach ($Sub_agency as $Sub_agencyList) {
                    $agency_booking_sub = DB::table('payment')->where('login_id', '=', $Sub_agencyList->loginid)->where('booking_confirm', '=', '1')->get();

                    if (!empty($agency_booking_sub[0]->totalprice)) {
                        $totalprice_sub += $agency_booking_sub[0]->totalprice;

                        $agency_creadit_limit_total[$agency_creadit_limit_list->id] = $totalprice_sub;
                    }
                }
            }

            //User Info

            $userinformation = DB::table('userinformation')->where('agentid', '=', $agency_creadit_limit_list->id)->get();

            if (!empty($userinformation)) {
                foreach ($userinformation as $userinformationList) {
                    $agency_booking_sub = DB::table('payment')->where('login_id', '=', $userinformationList->loginid)->where('booking_confirm', '=', '1')->get();

                    if (!empty($agency_booking_sub[0]->totalprice)) {
                        $totalprice_user += $agency_booking_sub[0]->totalprice;

                        $agency_creadit_limit_total[$agency_creadit_limit_list->id] = $totalprice_user;
                    }
                }
            }
        }

        $RoleIdPremissions = controller::Role_Permissions();

        $data['Premissions'] = $RoleIdPremissions;

        $data['agency'] = $agency;

        $data['agency_creadit_limit_total'] = $agency_creadit_limit_total;

        return view('bookingreport.agencyddetailbookingreport', $data);
    }

    //agent wise booking
	
	
	
	/**
     * Ageny agentbookingwise module. It is list agent wise booking reprt.
     *
     *@param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */

    public function agentbookingwise()
    {
        $data['pagename'] = 'agentbookingwise';

        $notification_Controller = controller::notification_Controller();

        //print_r($RoleIdPremissions);

        $data['whologin'] = $notification_Controller['whologin'];

        $data['activeDetails'] = $notification_Controller['agency_array'];

        $data['agecnyresultsnotification'] = $notification_Controller['agecnyresults_notification'];

        $data['agecnyresultsnotificationread'] = $notification_Controller['agecnyresults_notification_read'];

        $data['userresultsnotification'] = $notification_Controller['user_results_notification'];

        $data['userresultsnotificationread'] = $notification_Controller['user_results_notification_read'];

        $agency = DB::table('agency')->where('parentagencyid', '=', 0)->get();

        $agency_creadit_limit = array();

        $agencyarray = array();

        $agency_creadit_limit_total = array();

        foreach ($agency as $agency_creadit_limit_list) {
            $agency_booking = DB::table('payment')->where('login_id', '=', $agency_creadit_limit_list->loginid)->where('booking_confirm', '=', '1')->get();

            $totalprice = 0;

            $totalprice_sub = 0;

            $totalprice_user = 0;

            if (!empty($agency_booking[0]->totalprice)) {
                foreach ($agency_booking as $agency_booking_List) {
                    $totalprice += $agency_booking_List->totalprice;

                    $agency_creadit_limit_total[$agency_creadit_limit_list->loginid] = $totalprice;
                }
            }

            //Sub agency

            $Sub_agency = DB::table('agency')->where('parentagencyid', '=', $agency_creadit_limit_list->id)->get();

            if (!empty($Sub_agency)) {
                foreach ($Sub_agency as $Sub_agencyList) {
                    $agency_booking_sub = DB::table('payment')->where('login_id', '=', $Sub_agencyList->loginid)->where('booking_confirm', '=', '1')->get();

                    if (!empty($agency_booking_sub[0]->totalprice)) {
                        $totalprice_sub += $agency_booking_sub[0]->totalprice;

                        $agency_creadit_limit_total[$agency_creadit_limit_list->id] = $totalprice_sub;
                    }
                }
            }

            //User Info

            $userinformation = DB::table('userinformation')->where('agentid', '=', $agency_creadit_limit_list->id)->get();

            if (!empty($userinformation)) {
                foreach ($userinformation as $userinformationList) {
                    $agency_booking_sub = DB::table('payment')->where('login_id', '=', $userinformationList->loginid)->where('booking_confirm', '=', '1')->get();

                    if (!empty($agency_booking_sub[0]->totalprice)) {
                        $totalprice_user += $agency_booking_sub[0]->totalprice;

                        $agency_creadit_limit_total[$agency_creadit_limit_list->id] = $totalprice_user;
                    }
                }
            }
        }

        $RoleIdPremissions = controller::Role_Permissions();

        $data['Premissions'] = $RoleIdPremissions;

        $data['agency'] = $agency;

        $data['agency_creadit_limit_total'] = $agency_creadit_limit_total;

        return view('bookingreport.agentbookingwise', $data);
    }
	
	
	/**
     * Ageny agentbooking module. It is list agent wise booking reprt.
     *
     * @return \Illuminate\Http\Response
     */

    public function agentbooking()
    {
        if (empty($_GET['id'])) {
            return redirect('/agentbooking');

            exit;
        }

        if (isset($_GET['id']) && !empty($_GET['id'])) {
            $id = $_GET['id'];
            try {
                $decrypted_id = base64_decode($id);
            } catch (DecryptException $e) {
                return redirect('/agentbooking');
            }
        }

        $data['pagename'] = 'agentbooking';

        //get data from database

        $notification_Controller = controller::notification_Controller();

        //print_r($RoleIdPremissions);

        $data['whologin'] = $notification_Controller['whologin'];

        $data['activeDetails'] = $notification_Controller['agency_array'];

        $data['agecnyresultsnotification'] = $notification_Controller['agecnyresults_notification'];

        $data['agecnyresultsnotificationread'] = $notification_Controller['agecnyresults_notification_read'];

        $data['userresultsnotification'] = $notification_Controller['user_results_notification'];

        $data['userresultsnotificationread'] = $notification_Controller['user_results_notification_read'];

        $parant_agency_id = array();

        $id = base64_decode($_GET['id']);

        $agency_check = DB::table('agency')->where('id', '=', $id)->get();

        $users = DB::table('users')

            ->get();

        /*echo '<pre>';

        print_r($users[0]->password);

        echo '</pre>';

echo Hash::make('secret');*/

        if (isset($_GET['bookingstatus']) && !empty($_GET['bookingstatus'])) {
            $ids = explode(',', $_GET['bookingstatus']);

            $vouched_booking = DB::table('payment')

                ->where('login_id', '=', $agency_check[0]->loginid)

                ->whereIn('booking_confirm', $ids)

                ->get();
        } else {
            $vouched_booking = DB::table('payment')->where('login_id', '=', $agency_check[0]->loginid)->get();
        }

        /*	echo '<pre>';

        print_r($vouched_booking);

        echo '</pre>';



        exit;*/

        //active agency list array

        $agency = DB::table('agency')->where('activestatus', '=', 1)->get();

        $active_agency = array();

        foreach ($agency as $agency_list) {
            $active_agency[$agency_list->id] = $agency_list->name;
        }

        $parant_agency_name = array();

        foreach ($vouched_booking as $vouched_booking_values) {
            if ($vouched_booking_values->user_type == 'AgencyManger') {
                $agency = DB::table('agency')->where('loginid', '=', $vouched_booking_values->login_id)->get();

                $parant_agency_id[$vouched_booking_values->login_id] = $agency[0]->id;

                $parant_agency_name[$vouched_booking_values->login_id] = $agency[0]->name;
            }

            if ($vouched_booking_values->user_type == 'SubAgencyManger') {
                $agency = DB::table('agency')->where('loginid', '=', $vouched_booking_values->login_id)->get();

                $parant_agency_id[$vouched_booking_values->login_id] = $agency[0]->parentagencyid;

                $agencyname = DB::table('agency')->where('id', '=', $agency[0]->parentagencyid)->get();

                $parant_agency_name[$vouched_booking_values->login_id] = $agencyname[0]->name;

                //echo 'SubAgencyManger';
            }

            if ($vouched_booking_values->user_type == 'UserInfo') {
                $userinformation = DB::table('userinformation')->where('loginid', '=', $vouched_booking_values->login_id)->get();

                $parant_agency_id[$vouched_booking_values->login_id] = $userinformation[0]->agentid;

                $agencyname = DB::table('agency')->where('id', '=', $userinformation[0]->agentid)->get();

                $parant_agency_name[$vouched_booking_values->login_id] = $agencyname[0]->name;

                //echo 'SubAgencyManger';
            }
        }

        $agency = DB::table('agency')->get();

        $userinformation = DB::table('userinformation')->get();

        $userinformationArray = array();

        $agencyArray = array();

        foreach ($agency as $agency_info) {
            $agencyArray[$agency_info->loginid] = $agency_info->aname;
        }

        $data['vouched_booking'] = $vouched_booking;

        $data['agencyArray'] = $agencyArray;

        $data['parant_agency_name'] = $parant_agency_name;

        $data['active_agency'] = $active_agency;

        $data['parant_agency_id'] = $parant_agency_id;

        $RoleIdPremissions = controller::Role_Permissions();

        $data['Premissions'] = $RoleIdPremissions;

        return view('bookingreport.agentbooking', $data);
    }

	
	/**
     * Ageny admininvoicebooking module. It is get invoice from database.
     *
     * @return \Illuminate\Http\Response
     */

    public function admininvoicebooking()
    {
        if (empty($_GET['id'])) {
            return redirect('/agencyddetailbookingreport');

            exit;
        }

        if (isset($_GET['id']) && !empty($_GET['id'])) {
            $id = $_GET['id'];
            try {
                $decrypted_id = base64_decode($id);
            } catch (DecryptException $e) {
                return redirect('/agencyddetailbookingreport');
            }
        }

        $data['pagename'] = 'admininvoicebooking';

        //get data from database

        $notification_Controller = controller::notification_Controller();

        //print_r($RoleIdPremissions);

        $data['whologin'] = $notification_Controller['whologin'];

        $data['activeDetails'] = $notification_Controller['agency_array'];

        $data['agecnyresultsnotification'] = $notification_Controller['agecnyresults_notification'];

        $data['agecnyresultsnotificationread'] = $notification_Controller['agecnyresults_notification_read'];

        $data['userresultsnotification'] = $notification_Controller['user_results_notification'];

        $data['userresultsnotificationread'] = $notification_Controller['user_results_notification_read'];

        $parant_agency_id = array();

        $agency_booking1 = array();

        //get data

        if (!empty($_GET['startdate']) || !empty($_GET['enddate'])) {
            $startdate = date('Y-m-d', strtotime($_GET['startdate']));

            $enddate = date('Y-m-d', strtotime($_GET['enddate']));

            //$vouched_booking = DB::select('select * from payment where booking_confirm=1 AND bookingdate <="'.$enddate.'"');

            $id = base64_decode($_GET['id']);

            $agency_check = DB::table('agency')->where('id', '=', $id)->get();

            $agency_booking = DB::table('payment')->where('login_id', '=', $agency_check[0]->loginid)->where('Bookdate', '>=', $startdate)->where('Bookdate', '<=', $enddate)->where('booking_confirm', '=', '1')->get();

            foreach ($agency_booking as $agency_booking_values) {
                $agency_booking1[] = $agency_booking_values;
            }

            $agaency_id_check = DB::table('agency')->where('id', '=', $id)->get();

            //include  sub agency

            $parentagencyid = DB::table('agency')->where('parentagencyid', '=', $agaency_id_check[0]->id)->get();

            //uesr

            $userinfo = DB::table('userinformation')->where('agentid', '=', $agaency_id_check[0]->id)->get();

            if (!empty($parentagencyid[0]->id)) {
                $agency_booking_sub = DB::table('payment')->where('login_id', '=', $parentagencyid[0]->loginid)->where('Bookdate', '>=', $startdate)->where('Bookdate', '<=', $enddate)->where('booking_confirm', '=', '1')->get();

                foreach ($agency_booking_sub as $agency_booking_sub_values) {
                    $agency_booking1[] = $agency_booking_sub_values;
                }
            }

            if (!empty($userinfo[0]->id)) {
                $agency_booking_user = DB::table('payment')->where('login_id', '=', $userinfo[0]->id)->where('Bookdate', '>=', $startdate)->where('Bookdate', '<=', $enddate)->where('booking_confirm', '=', '1')->get();

                foreach ($agency_booking_user as $agency_booking_user_values) {
                    $agency_booking1[] = $agency_booking_user_values;
                }
            }
        } else {

            //login id check

            $id = base64_decode($_GET['id']);

            $agency_check = DB::table('agency')->where('id', '=', $id)->get();

            $agency_booking = DB::table('payment')->where('login_id', '=', $agency_check[0]->loginid)->where('booking_confirm', '=', '1')->get();

            foreach ($agency_booking as $agency_booking_values) {
                $agency_booking1[] = $agency_booking_values;
            }

            $agaency_id_check = DB::table('agency')->where('id', '=', $id)->get();

            //include  sub agency

            $parentagencyid = DB::table('agency')->where('parentagencyid', '=', $agaency_id_check[0]->id)->get();

            //uesr

            $userinfo = DB::table('userinformation')->where('agentid', '=', $agaency_id_check[0]->id)->get();

            if (!empty($parentagencyid[0]->id)) {
                $agency_booking_sub = DB::table('payment')->where('login_id', '=', $parentagencyid[0]->loginid)->where('booking_confirm', '=', '1')->get();

                foreach ($agency_booking_sub as $agency_booking_sub_values) {
                    $agency_booking1[] = $agency_booking_sub_values;
                }
            }

            if (!empty($userinfo[0]->id)) {
                $agency_booking_user = DB::table('payment')->where('login_id', '=', $userinfo[0]->id)->where('booking_confirm', '=', '1')->get();

                foreach ($agency_booking_user as $agency_booking_user_values) {
                    $agency_booking1[] = $agency_booking_user_values;
                }
            }
        }

        /*	echo '<pre>';

        print_r($vouched_booking);

        echo '</pre>';



        exit;*/

        //active agency list array

        $agency = DB::table('agency')->where('activestatus', '=', 1)->where('parentagencyid', '<=', 0)->get();

        $active_agency = array();

        foreach ($agency as $agency_list) {
            $active_agency[$agency_list->id] = $agency_list->name;
        }

        $parant_agency_name = array();

        foreach ($agency_booking1 as $vouched_booking_values) {
            if ($vouched_booking_values->user_type == 'AgencyManger') {
                $agency = DB::table('agency')->where('loginid', '=', $vouched_booking_values->login_id)->get();

                $parant_agency_id[$vouched_booking_values->login_id] = $agency[0]->id;

                $parant_agency_name[$vouched_booking_values->login_id] = $agency[0]->name;
            }

            if ($vouched_booking_values->user_type == 'SubAgencyManger') {
                $agency = DB::table('agency')->where('loginid', '=', $vouched_booking_values->login_id)->get();

                $parant_agency_id[$vouched_booking_values->login_id] = $agency[0]->parentagencyid;

                $agencyname = DB::table('agency')->where('id', '=', $agency[0]->parentagencyid)->get();

                $parant_agency_name[$vouched_booking_values->login_id] = $agencyname[0]->name;

                //echo 'SubAgencyManger';
            }

            if ($vouched_booking_values->user_type == 'UserInfo') {
                $userinformation = DB::table('userinformation')->where('loginid', '=', $vouched_booking_values->login_id)->get();

                $parant_agency_id[$vouched_booking_values->login_id] = $userinformation[0]->agentid;

                $agencyname = DB::table('agency')->where('id', '=', $userinformation[0]->agentid)->get();

                $parant_agency_name[$vouched_booking_values->login_id] = $agencyname[0]->name;

                //echo 'SubAgencyManger';
            }
        }

        $agency = DB::table('agency')->get();

        $userinformation = DB::table('userinformation')->get();

        $userinformationArray = array();

        $agencyArray = array();

        foreach ($agency as $agency_info) {
            $agencyArray[$agency_info->loginid] = $agency_info->aname;
        }

        $agency_creadit_limit_total['current_credit_limit'] = $agaency_id_check[0]->current_credit_limit;

        $agency_creadit_limit_total['creditLimit'] = $agaency_id_check[0]->creditLimit;

        $data['agency_creadit_limit_total'] = $agency_creadit_limit_total;

        $data['vouched_booking'] = $agency_booking1;

        $data['agencyArray'] = $agencyArray;

        $data['parant_agency_name'] = $parant_agency_name;

        $data['active_agency'] = $active_agency;

        $data['parant_agency_id'] = $parant_agency_id;

        $RoleIdPremissions = controller::Role_Permissions();

        $data['Premissions'] = $RoleIdPremissions;

        return view('bookingreport.admininvoicebooking', $data);
    }
	
	
	/**
     * Ageny agentinvoicebooking module. It is get invoice from database.
     *
     * @return \Illuminate\Http\Response
     */

    public function agentinvoicebooking()
    {
        $data['pagename'] = 'agentinvoicebooking';

        //get data from database

        $notification_Controller = controller::notification_Controller();

        //print_r($RoleIdPremissions);

        $data['whologin'] = $notification_Controller['whologin'];

        $data['activeDetails'] = $notification_Controller['agency_array'];

        $data['agecnyresultsnotification'] = $notification_Controller['agecnyresults_notification'];

        $data['agecnyresultsnotificationread'] = $notification_Controller['agecnyresults_notification_read'];

        $data['userresultsnotification'] = $notification_Controller['user_results_notification'];

        $data['userresultsnotificationread'] = $notification_Controller['user_results_notification_read'];

        $parant_agency_id = array();

        //get data

        $Loginid = Auth::user()->id;

        $agency_booking1 = array();

        //echo Auth::user()->user_type;

        if (Auth::user()->user_type == 'AgencyManger') {
            if (!empty($_GET['startdate']) || !empty($_GET['enddate'])) {
                $startdate = date('Y-m-d', strtotime($_GET['startdate']));

                $enddate = date('Y-m-d', strtotime($_GET['enddate']));

                $agency_booking = DB::table('payment')->where('login_id', '=', $Loginid)->where('Bookdate', '>=', $startdate)->where('Bookdate', '<=', $enddate)->where('sendnotifictaion', '=', 1)->get();
            } else {
                $agency_booking = DB::table('payment')->where('login_id', '=', $Loginid)->where('sendnotifictaion', '=', 1)->get();
            }

            foreach ($agency_booking as $agency_booking_values) {
                $agency_booking1[] = $agency_booking_values;
            }

            $agaency_id_check = DB::table('agency')->where('loginid', '=', $Loginid)->get();

            //include  sub agency

            $parentagencyid = DB::table('agency')->where('parentagencyid', '=', $agaency_id_check[0]->id)->get();

            //uesr

            $userinfo = DB::table('userinformation')->where('agentid', '=', $agaency_id_check[0]->id)->get();

            $payment_user = DB::table('payment')->get();

            /*echo '<pre>';

               print_r($payment_user);

               echo '</pre>';*/

            if (!empty($parentagencyid[0]->id)) {
                if (!empty($_GET['startdate']) || !empty($_GET['enddate'])) {
                    $startdate = date('Y-m-d', strtotime($_GET['startdate']));

                    $enddate = date('Y-m-d', strtotime($_GET['enddate']));

                    $agency_booking_sub = DB::table('payment')->where('login_id', '=', $parentagencyid[0]->loginid)->where('Bookdate', '>=', $startdate)->where('Bookdate', '<=', $enddate)->where('sendnotifictaion', '=', 1)->get();
                } else {
                    $agency_booking_sub = DB::table('payment')->where('login_id', '=', $parentagencyid[0]->loginid)->where('sendnotifictaion', '=', 1)->get();
                }

                foreach ($agency_booking_sub as $agency_booking_sub_values) {
                    $agency_booking1[] = $agency_booking_sub_values;
                }
            }

            if (!empty($userinfo[0]->id)) {
                if (!empty($_GET['startdate']) || !empty($_GET['enddate'])) {
                    $startdate = date('Y-m-d', strtotime($_GET['startdate']));

                    $enddate = date('Y-m-d', strtotime($_GET['enddate']));

                    $agency_booking_user = DB::table('payment')->where('login_id', '=', $userinfo[0]->loginid)->where('Bookdate', '>=', $startdate)->where('Bookdate', '<=', $enddate)->where('sendnotifictaion', '=', 1)->get();
                } else {
                    $agency_booking_user = DB::table('payment')->where('login_id', '=', $userinfo[0]->loginid)->where('sendnotifictaion', '=', 1)->get();
                }

                foreach ($agency_booking_user as $agency_booking_user_values) {
                    $agency_booking1[] = $agency_booking_user_values;
                }
            }
        }

        if (Auth::user()->user_type == 'SubAgencyManger') {
            $agaency_id_check = DB::table('agency')->where('loginid', '=', $Loginid)->get();

            $parentagencyid = DB::table('agency')->where('parentagencyid', '=', $agaency_id_check[0]->id)->get();

            if (!empty($parentagencyid[0]->id)) {
                if (!empty($_GET['startdate']) || !empty($_GET['enddate'])) {
                    $startdate = date('Y-m-d', strtotime($_GET['startdate']));

                    $enddate = date('Y-m-d', strtotime($_GET['enddate']));

                    $agency_booking = DB::table('payment')->where('login_id', '=', $parentagencyid[0]->loginid)->where('user_type', '=', 'SubAgencyManger')->where('Bookdate', '>=', $startdate)->where('Bookdate', '<=', $enddate)->where('sendnotifictaion', '=', 1)->get();
                } else {
                    $agency_booking = DB::table('payment')->where('login_id', '=', $parentagencyid[0]->loginid)->where('user_type', '=', 'SubAgencyManger')->where('sendnotifictaion', '=', 1)->get();
                }

                foreach ($agency_booking as $agency_booking_values) {
                    $agency_booking1[] = $agency_booking_values;
                }
            }
        }

        if (Auth::user()->user_type == 'UserInfo') {
            $user_id_check = DB::table('userinformation')->where('loginid', '=', $Loginid)->get();

            $agaency_id_check = DB::table('agency')->where('id', '=', $user_id_check[0]->agentid)->get();

            //parent agency

            $user_id_check[0]->agentid;

            if (!empty($user_id_check[0]->id)) {
                if (!empty($_GET['startdate']) || !empty($_GET['enddate'])) {
                    $startdate = date('Y-m-d', strtotime($_GET['startdate']));

                    $enddate = date('Y-m-d', strtotime($_GET['enddate']));

                    $agency_booking = DB::table('payment')->where('login_id', '=', $Loginid)->where('user_type', '=', 'UserInfo')->where('Bookdate', '>=', $startdate)->where('Bookdate', '<=', $enddate)->where('sendnotifictaion', '=', 1)->get();
                } else {
                    $agency_booking = DB::table('payment')->where('login_id', '=', $Loginid)->where('user_type', '=', 'UserInfo')->where('sendnotifictaion', '=', 1)->get();
                }

                foreach ($agency_booking as $agency_booking_values) {
                    $agency_booking1[] = $agency_booking_values;
                }
            }
        }

        /*	echo '<pre>';

        print_r($vouched_booking);

        echo '</pre>';



        exit;*/

        //active agency list array

        $agency = DB::table('agency')->where('activestatus', '=', 1)->where('parentagencyid', '<=', 0)->get();

        $active_agency = array();

        foreach ($agency as $agency_list) {
            $active_agency[$agency_list->id] = $agency_list->name;
        }

        $parant_agency_name = array();

        foreach ($agency_booking1 as $vouched_booking_values) {
            if ($vouched_booking_values->user_type == 'AgencyManger') {
                $agency = DB::table('agency')->where('loginid', '=', $vouched_booking_values->login_id)->get();

                $parant_agency_id[$vouched_booking_values->login_id] = $agency[0]->id;

                $parant_agency_name[$vouched_booking_values->login_id] = $agency[0]->name;
            }

            if ($vouched_booking_values->user_type == 'SubAgencyManger') {
                $agency = DB::table('agency')->where('loginid', '=', $vouched_booking_values->login_id)->get();

                $parant_agency_id[$vouched_booking_values->login_id] = $agency[0]->parentagencyid;

                $agencyname = DB::table('agency')->where('id', '=', $agency[0]->parentagencyid)->get();

                $parant_agency_name[$vouched_booking_values->login_id] = $agencyname[0]->name;

                //echo 'SubAgencyManger';
            }

            if ($vouched_booking_values->user_type == 'UserInfo') {
                $userinformation = DB::table('userinformation')->where('loginid', '=', $vouched_booking_values->login_id)->get();

                $parant_agency_id[$vouched_booking_values->login_id] = $userinformation[0]->agentid;

                $agencyname = DB::table('agency')->where('id', '=', $userinformation[0]->agentid)->get();

                $parant_agency_name[$vouched_booking_values->login_id] = $agencyname[0]->name;

                //echo 'SubAgencyManger';
            }
        }

        $agency = DB::table('agency')->get();

        $userinformation = DB::table('userinformation')->get();

        $userinformationArray = array();

        $agencyArray = array();

        foreach ($agency as $agency_info) {
            $agencyArray[$agency_info->loginid] = $agency_info->aname;
        }

        $agency = DB::table('agency')->get();

        $userinformation = DB::table('userinformation')->get();

        $userinformationArray = array();

        $agencyArray = array();

        foreach ($agency as $agency_info) {
            $agencyArray[$agency_info->loginid] = $agency_info->aname;
        }

        foreach ($userinformation as $userinformation_info) {
            $userinformationArray[$userinformation_info->loginid] = $userinformation_info->name;
        }

        $data['agencyArray'] = $agencyArray;

        $data['userinformationArray'] = $userinformationArray;

        $data['vouched_booking'] = $agency_booking1;

        $data['agencyArray'] = $agencyArray;

        $data['parant_agency_name'] = $parant_agency_name;

        $data['active_agency'] = $active_agency;

        $data['parant_agency_id'] = $parant_agency_id;

        $RoleIdPremissions = controller::Role_Permissions();

        $data['Premissions'] = $RoleIdPremissions;

        return view('bookingreport.agentvoicebooking', $data);
    }
	
	
	/**
     * Ageny invoicepayment module. It is get invoice from database.
     *
     * @return \Illuminate\Http\Response
     */

    public function invoicepayment(Request $request)
    {
        $PDF_NAME = 'pdf_invoice_MA'.base64_encode($request->input('bookingid'));

        $payment_booking = DB::table('payment')->where('id', '=', $request->input('bookingid'))->get();

        require_once 'tcpdf/pdfblock/tcpdf_include.php';

        require_once 'tcpdf/tcpdf.php';

        $pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information

        $pdf->SetAuthor('NEW B2B Admin');

        $pdf->SetTitle('NEW B2B Voucher');

        //$pdf->SetSubject('TCPDF Tutorial');

        //$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);

        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER); // set auto page breaks

        $pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);

        // set image scale factor

        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)

        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once dirname(__FILE__).'/lang/eng.php';

            $pdf->setLanguageArray($l);
        }

        $pdf->SetMargins(0, 0, 0, true);

        $pdf->SetFont('times', '', 10);

        $pdf->AddPage(); // add a page

        $pdf->writeHTMLCell(0, 0, '', '', $payment_booking[0]->Vouchertemplate, '0', 1, 0, true, 'L', true);

        $pdf->Output(__DIR__.'/../../../../public/pdf/'.$PDF_NAME.'.pdf', 'F');

        $URL = URL::to('/');

        //echo $URL.'/pdf/'.$PDF_NAME.'.pdf';

        $data = array('value' => $URL.'/pdf/'.$PDF_NAME.'.pdf', 'name' => $PDF_NAME);

        return $data;

        exit;
    }
	
	
	/**
     * Ageny invoicepaymentemail module. It is get invoice from database.
     *
     * @return \Illuminate\Http\Response
     */

    public function invoicepaymentemail(Request $request)
    {

        //////vouchertemplate

        //agency detal get

        $payment_booking = DB::table('payment')->where('id', '=', $_POST['bookingid'])->get();

        $Vochername = '';

        $Name = '';

        $Hotelname = '';

        $email = '';

        $Address = '';

        $NoRooms = '';

        $Child = '';

        $Desitination = '';

        if ($payment_booking[0]->supplier == 'travelanda') {
            $roomdeatils = (array) unserialize($payment_booking[0]->roomdeatils);

            $getBookingDetails = $this->getBookingDetails($payment_booking[0]);

            $roomcontent = '';

            $f = 1;

            for ($r = 0; $r < $payment_booking[0]->no_of_room; ++$r) {
                $RoomPrice = base64_decode(Crypt::decrypt($roomdeatils[$r]['RoomPrice']));

                $roomcontent .= ' <tr style="line-height: 30px;">

      <td style="border-bottom: 1px solid #b0b0b0;border-right: 1px solid #b0b0b0;border-left: 1px solid #b0b0b0">'.$f.'</td>

      <td style="border-bottom: 1px solid #b0b0b0;font-size: 10px;border-right: 1px solid #b0b0b0">'.$getBookingDetails->Body->Bookings->HotelBooking->Rooms->Room[$r]->RoomName.'</td>

      <td style="border-bottom: 1px solid #b0b0b0;border-right: 1px solid #b0b0b0">'.$getBookingDetails->Body->Bookings->HotelBooking->Rooms->Room[$r]->NumAdults.'</td>

      <td style="border-bottom: 1px solid #b0b0b0;border-right: 1px solid #b0b0b0">'.$getBookingDetails->Body->Bookings->HotelBooking->Rooms->Room[$r]->NumChildren.'</td>

      <td style="border-bottom: 1px solid #b0b0b0;border-right: 1px solid #b0b0b0">$ '.$RoomPrice.'</td>

   </tr>';

                ++$f;
            }

            $Gethotelresponse = HotelApiController::Gethotelresponse($payment_booking[0]->hotelid);

            $Vochername = $getBookingDetails->Body->Bookings->HotelBooking->BookingReference;

            $Name = $getBookingDetails->Body->Bookings->HotelBooking->LeaderName;

            $Hotelname = $getBookingDetails->Body->Bookings->HotelBooking->HotelName;

            $email = $payment_booking[0]->email;

            $Address = $Gethotelresponse->Body->Hotels->Hotel->Address;

            $bookiingdate = $payment_booking[0]->Bookdate;

            $TotalPrice = $payment_booking[0]->totalprice;

            $Desitination = '';
        }

        if ($payment_booking[0]->supplier == 'tbo') {
            $getBookingDetails = $this->tbobboking_details($payment_booking[0]->BookingReference);

            $tboHolidaysHotelDetails = HotelApiController::tboHolidaysHotelDetails($payment_booking[0]->hotelid);
        }

        $tempalte = '<div class="" style="width: 90%;MARGIN: AUTO;"><table style="width:100%">
				
				   <h3 style="text-align: center">BOOKING INVOICE</h3>
				
				   <h4 style="text-align: center;MARGIN-BOTTOM: 20px;padding-bottom: 20px;border-bottom: 1px dashed #ccc;">New B2B</h4>
				
				   <tr style="line-height: 30px"> 
				
					  <td ><spam style="font-weight:500;">INVOICE ID :</spam> '.$Vochername.'</td>
				
					  <td style="text-align: right;"><spam style="font-weight:500;">DATE :</spam> '.$bookiingdate.'</spam></td>
				
				   </tr>
				
				   <tr style="line-height: 30px">
				
					  <td><spam style="font-weight:500;"><spam style="font-weight:500;">Name : </spam>'.$Name.'</td>
				
					  <td style="text-align: right;"><spam style="font-weight:500;">E-mail :</spam> '.$email.'</td>
				
				   </tr>
				
				   <tr style="line-height: 30px">
				
					  <td><spam style="font-weight:500;">Hotel Name :</spam> '.$Hotelname.'</td>
				
					  <td style="text-align: right;"><spam style="font-weight:500;">Hote Address :</spam> '.$Address.'</td>
				
				   </tr>
				
				</table>
				
				<table style="text-align: center;width:100%">
				
				   <tr style="background-color: #666666;color: #fff;line-height: 30px;">
				
					  <th style="border-bottom: 1px solid #b0b0b0;border-left: 1px solid #b0b0b0">S.No</th>
				
					  <th style="border-bottom: 1px solid #b0b0b0;border-right: 1px solid #b0b0b0">ROOM DETAIL</th>
				
					  <th style="border-bottom: 1px solid #b0b0b0;border-right: 1px solid #b0b0b0">ADULT</th>
				
					  <th style="border-bottom: 1px solid #b0b0b0;border-right: 1px solid #b0b0b0">CHILDREN</th>
				
					  <th style="border-bottom: 1px solid #b0b0b0;border-right: 1px solid #b0b0b0">PRICE</th>
				
				   </tr>
				
				  '.$roomcontent.'
				
				   <tr style="line-height: 30px;">
				
					  <td ></td>
				
					  <td ></td>
				
					  <td style="border-right: 1px solid #b0b0b0;">Discount Applied</td>
				
					  <td style="border-bottom: 1px solid #b0b0b0;"></td>
				
					  <td style="border-bottom: 1px solid #b0b0b0;border-right: 1px solid #b0b0b0">$ 0</td>
				
				   </tr>
				
				   <tr style="line-height: 30px;">
				
					  <td ></td>
				
					  <td ></td>
				
					  <td style="border-right: 1px solid #b0b0b0"> GRAND TOTAL</td>
				
					  <td style="border-bottom: 1px solid #b0b0b0;"></td>
				
					  <td style="border-bottom: 1px solid #b0b0b0;border-right: 1px solid #b0b0b0">$ '.$TotalPrice.'</td>
				
				   </tr>
				
				
				
				</table> <h2 style="font-size: 12px;line-height: 50px"> THANKYOU FOR BOOKING WITH NEW B2B</h2></div>';

        $mail = $tempalte;

        $to = $payment_booking[0]->email;

        $subject = 'Booking Invoice';

        $message = $mail;

        $headers = "From: B2B project<admin@livebeds.com>\r\n";

        $headers .= "MIME-Version: 1.0\r\n";

        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

        mail($to,$subject,$message,$headers);
    }
	
	/**
     * Ageny voucherpaymentemail module. It is get invoice from database.
     *
     * @return \Illuminate\Http\Response
     */

    public function voucherpaymentemail(Request $request)
    {

        //////vouchertemplate

        //agency detal get

        $payment_booking = DB::table('payment')->where('id', '=', $_POST['bookingid'])->get();

        $guest = unserialize($payment_booking[0]->guest);

        $Servicename = '';

        $Servicetype = '';

        $MealBasis = '';

        $ServiceAddress = '';

        $RoomServiceType = '';

        $NoRooms = '';

        $Child = '';

        $Desitination = '';

        $starCategory = '';

        $Reservationstatus = '';

        $GuestName = '';

        $NoAdult = '';

        $Infants = '';

        $PoliciesDetails = '';

        if ($payment_booking[0]->supplier == 'travelanda') {
            $getBookingDetails = $this->getBookingDetails($payment_booking[0]);

            $Gethotelresponse = HotelApiController::Gethotelresponse($payment_booking[0]->hotelid);

            $Description = '';

            if (isset($Gethotelresponse->Body->Hotels->Hotel->Description)) {
                $Description = $Gethotelresponse->Body->Hotels->Hotel->Description;
            }

            if (isset($getBookingDetails->Body->Bookings)) {
                foreach ($getBookingDetails->Body->Bookings->HotelBooking as $HotelBooking) {
                    if ($payment_booking[0]->BookingReference == $HotelBooking->BookingReference) {
                        $bo = 1;

                        if (isset($HotelBooking->Policies->Policy)) {
                            $PoliciesDetails .= $Description;

                            $PoliciesDetails .= '<div class="" style="margin-bottom: 5px;"><span> </span> You may cancel your reservation for no charge before this deadline. 

		 Please note that we will assess full payment of reservation if you must cancel after this deadline.</div>';

                            foreach ($HotelBooking->Policies->Policy as $Policy) {
                                if ($Policy->Type == 'Percentage') {
                                    $PoliciesDetails .= '<div class="" style="margin-bottom: 5px;"><span></span> If you will cancel the booking after  <b>'.$Policy->From.'</b> then you should  pay  <b'.$Policy->Value.'% </b> penalty for this booking.</div>';
                                }

                                if ($Policy->Type == 'Amount') {
                                    $PoliciesDetails .= ' <div class="" style="margin-bottom: 5px;"><span> </span> If you will cancel the booking after  <b>'.$Policy->From.'</b> then you should  pay $ <b>'.$Policy->Value.'</b> penalty for this booking.</div>';
                                }

                                if ($Policy->Type == 'Nights') {
                                    $PoliciesDetails .= '<div class="" style="margin-bottom: 5px;"><span></span> If you will cancel the booking after  <b>'.$Policy->From.'</b> then you should  pay <b>'.$Policy->Value.'</b> night price penalty for this booking.</div>';
                                }

                                ++$bo;
                            }
                        }

                        // echo '<pre>';

                        //print_r($payment_booking);

                        // print_r($HotelBooking);

                        //echo '</pre>';

                        /*echo '<pre>';

    print_r($guest);

    echo '</pre>';*/

                        //guest dateil

                        $roomGuestDetails = '';

                        foreach ($guest as $guestDetails) {
                            if ($guestDetails['adult'] != 0) {
                                for ($a = 1; $a <= $guestDetails['adult']; ++$a) {
                                    $roomGuestDetails .= '<p style="margin:0;">'.$guestDetails['title'][$a].'.'.$guestDetails['firstname'][$a].' '.$guestDetails['lastname'][$a].'</p>';
                                }
                            }

                            if ($guestDetails['child'] != 0) {
                                for ($c = 1; $c <= $guestDetails['child']; ++$c) {
                                    $roomGuestDetails .= '<p style="margin:0;">'.$guestDetails['firstname'][$c].' '.$guestDetails['lastname'][$c].'</p>';
                                }
                            }
                        }

                        $RoomName = '';

                        $NumAdults = '';

                        $NumChildren = '';

                        $room = 0;

                        foreach ($HotelBooking->Rooms->Room as $roomDetails) {
                            $RoomName = $roomDetails->RoomName;

                            $NumAdults += $roomDetails->NumAdults;

                            $NumChildren += $roomDetails->NumChildren;

                            ++$room;
                        }

                        $Servicename = $HotelBooking->HotelName;

                        $Servicetype = 'Hotel';

                        $MealBasis = $HotelBooking->BoardType;

                        $ServiceAddress = $HotelBooking->City;

                        $RoomServiceType = $RoomName;

                        $NoRooms = $room;

                        $Child = $NumChildren;

                        $Desitination = $HotelBooking->City;

                        $starCategory = '';

                        $Reservationstatus = 'Confirm';

                        $GuestName = $roomGuestDetails;

                        $NoAdult = $NumAdults;

                        $Infants = $NumChildren;
                    }
                }
            }
        }

        if ($payment_booking[0]->supplier == 'tbo') {
            $getBookingDetails = $this->tbobboking_details($payment_booking[0]->BookingReference);

            $tboHolidaysHotelDetails = HotelApiController::tboHolidaysHotelDetails($payment_booking[0]->hotelid);

            /*	echo '<pre>';

        print_r($tboHolidaysHotelDetails['sBody']['HotelDetailsResponse']['HotelDetails']['Description']);

        echo '</pre>';*/

            $RoomName = '';

            if (!empty($getBookingDetails['sBody']['HotelBookingDetailResponse']['BookingDetail']['Roomtype']['RoomDetails'])) {
                for ($r = 0; $r < $payment_booking[0]->no_of_room; ++$r) {
                    $RoomName .= '<p>'.$getBookingDetails['sBody']['HotelBookingDetailResponse']['BookingDetail']['Roomtype']['RoomDetails'][$r]['RoomName'].'</p>';
                }
            }

            //guest dateil

            $roomGuestDetails = '';

            $NumAdults = 0;

            $NumChildren = 0;

            foreach ($guest as $guestDetails) {
                $NumAdults += $guestDetails['adult'];

                if ($guestDetails['adult'] != 0) {
                    for ($a = 1; $a <= $guestDetails['adult']; ++$a) {
                        $roomGuestDetails .= '<p style="margin:0;">'.$guestDetails['title'][$a].'.'.$guestDetails['firstname'][$a].' '.$guestDetails['lastname'][$a].'</p>';
                    }
                }

                if ($guestDetails['child'] != 0) {
                    $NumChildren += $guestDetails['child'];

                    for ($c = 1; $c <= $guestDetails['child']; ++$c) {
                        $roomGuestDetails .= '<p style="margin:0;">'.$guestDetails['firstname'][$c].' '.$guestDetails['lastname'][$c].'</p>';
                    }
                }
            }

            $PoliciesDetails .= $tboHolidaysHotelDetails['sBody']['HotelDetailsResponse']['HotelDetails']['Description'];

            $PoliciesDetails .= '<div class=""><span> </span> You may cancel your reservation for no charge before this deadline. 

		 Please note that we will assess full payment of reservation if you must cancel after this deadline.</div>';

            $attr = '@attributes';

            $bo = 1;

            if (isset($getBookingDetails['sBody']['HotelBookingDetailResponse']['BookingDetail']['HotelCancelPolicies']['CancelPolicy'][0])) {
                foreach ($getBookingDetails['sBody']['HotelBookingDetailResponse']['BookingDetail']['HotelCancelPolicies']['CancelPolicy'] as $Policy) {
                    if ($Policy[$attr]['ChargeType'] == 'Fixed') {
                        $PoliciesDetails .= '<div class="">If you will cancel the booking  <b>'.$Policy[$attr]['FromDate'].'</b> to  <b>'.$Policy[$attr]['ToDate'].'</b> then you should pay '.$Policy[$attr]['Currency'].''.$Policy[$attr]['CancellationCharge'].' penalty for this booking</div>';
                    }

                    if ($Policy[$attr]['ChargeType'] == 'Percentage') {
                        $PoliciesDetails .= '<div class=""><span>If you will cancel the booking  <b>'.$Policy[$attr]['FromDate'].' </b> to  <b>'.$Policy[$attr]['ToDate'].'</b> then you should pay '.$Policy[$attr]['CancellationCharge'].' % penalty for this booking</div>';
                    }

                    if ($Policy[$attr]['ChargeType'] == 'Night') {
                        $PoliciesDetails .= '<div class=""><span>If you will cancel the booking  <b>'.$Policy[$attr]['FromDate'].' </b> to  <b>'.$Policy[$attr]['ToDate'].'</b> then you should pay '.$Policy[$attr]['CancellationCharge'].' % penalty for this booking</div>';
                    }

                    ++$bo;
                }
            }

            $Servicename = $getBookingDetails['sBody']['HotelBookingDetailResponse']['BookingDetail']['HotelName'];

            $Servicetype = 'Hotel';

            $MealBasis = $getBookingDetails['sBody']['HotelBookingDetailResponse']['BookingDetail']['HotelName'];

            $ServiceAddress = $getBookingDetails['sBody']['HotelBookingDetailResponse']['BookingDetail']['AddressLine1'];

            $RoomServiceType = $RoomName;

            $NoRooms = $payment_booking[0]->no_of_room;

            $Child = ''; //$NumChildren;

            $Desitination = $getBookingDetails['sBody']['HotelBookingDetailResponse']['BookingDetail']['City'];

            $starCategory = '';

            $Reservationstatus = 'Confirm';

            $GuestName = $roomGuestDetails;

            $NoAdult = $NumAdults;

            $Infants = $NumChildren;
        }

        $name = '';

        $address = '';

        $city = '';

        $country = '';

        if ($payment_booking[0]->user_type == 'AgencyManger') {
            $agency = DB::table('agency')->where('loginid', '=', $payment_booking[0]->login_id)->get();

            /*	echo '<pre>';

        print_r($agency);

        echo '</pre>';*/

            $name = $agency[0]->aname;

            $address = $agency[0]->address1;

            $city = $agency[0]->city;

            $country = $agency[0]->country;
        }

        if ($payment_booking[0]->user_type == 'SubAgencyManger') {
            $agency = DB::table('agency')->where('loginid', '=', $payment_booking[0]->login_id)->get();

            /*	echo '<pre>';

        print_r($agency);

        echo '</pre>';*/

            $name = $agency[0]->aname;

            $address = $agency[0]->address1;

            $city = $agency[0]->city;

            $country = $agency[0]->country;
        }

        if ($payment_booking[0]->user_type == 'UserInfo') {
            $userinformation = DB::table('userinformation')->where('loginid', '=', $payment_booking[0]->login_id)->get();

            /*	echo '<pre>';

        print_r($userinformation);

        echo '</pre>';*/

            $name = $userinformation[0]->name;

            $address = $userinformation[0]->email;

            $city = $userinformation[0]->phone;
        }

        /*echo '<pre>';

        print_r($guest[0]['firstname'][1]);

        echo '</pre>';*/

        $date1 = date_create($payment_booking[0]->checkin);

        $date2 = date_create($payment_booking[0]->checkout);

        $diff = date_diff($date1, $date2);

        $daycount = $diff->days;

        $tempalte = '<!DOCTYPE html>
					
					<html>
					
					<head>
					
					<meta charset="UTF-8">
					
					<title>Voucher</title>
					
					</head>
					
					<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500" rel="stylesheet">
					
					<body style="font-family: "Roboto", sans-serif;background:#f0f4f5;font-size:13px;color:#6e6963">
					
						<div class="container" style="max-width:900px;margin:auto;">
					
						<div id="outprint">
					
						   <header style="font-size: 14px; font-weight: 500;background: #036292;text-align: center;color: #ffffff;text-transform: uppercase;padding: 10px;"> Please Present this voucher upon arrival </header>
					
							<div class="below-header" style="padding:20px;background:#ffffff;margin-bottom:20px;border:1px solid #e2e2e2;">
					
							<div class="logo-invoice-details" style=" margin-bottom:10px;">
					
								<div class="logo" style="padding-top:20px;width: 50%;float: left;">
					
									<img src="'.asset('img/logo_default_dark.png').'">
					
								</div>
					
								<div class="l-invoice-details" style="width: 50%;float: right;text-align: right;">
					
									<h1 style="margin-top: 0;font-size: 30px;margin-bottom:10px;"><span style="font-weight:300;">Service</span> Voucher</h1>
					
									<p style="margin:0;">'.$name.'</p>
					
									<address style="    width: 150px;margin-left: auto;font-style: normal;">
					
										'.$address.', '.$city.', '.$country.'.
					
									</address>
					
								</div>
					
								<div style="display:table;clear:both;">
					
								</div>
					
							</div>
					
					
					
							<div class="booking-information" style="position:relative;margin-bottom:10px;">
					
								<div class="booking-information-left" style="width:65%;float:left">
					
									<div class="booking-information-left-header" style="    border: 1px solid #eceeeb;
					
						border-bottom: none;    padding: 10px; background: #f7f9f8;font-weight: 500;font-size: 14px;">
					
										Booking Information
					
									</div>
					
								   <table style="width: 100%;text-align: left;border-collapse: collapse;">
					
									<tr>
					
										<th style="padding: 10px;border: 1px solid #eceeeb;font-weight: 400;">Voucher No</th>
					
										<td style="padding: 10px;border: 1px solid #eceeeb;font-weight: 600;text-align: left;">LBVN'.$payment_booking[0]->hotelid.'</td>
					
									</tr>
					
										<tr>
					
										<th style="padding: 10px;border: 1px solid #eceeeb;font-weight: 400;">LB REF No</th>
					
										<td style="padding: 10px;border: 1px solid #eceeeb;font-weight: 600;text-align: left;">LBHR'.$payment_booking[0]->hotelid.'</td>
					
									</tr>
					
										<tr>
					
										<th style="padding: 10px;border: 1px solid #eceeeb;font-weight: 400;">Supplier Ref No</th>
					
										<td style="padding: 10px;border: 1px solid #eceeeb;font-weight: 600;text-align: left;">'.$payment_booking[0]->id.$payment_booking[0]->hotelid.$payment_booking[0]->login_id.'</td>
					
									</tr>
					
										<tr>
					
										<th style="padding: 10px;border: 1px solid #eceeeb;font-weight: 400;">Re-confirmation No/Msg</th>
					
										<td style="padding: 10px;border: 1px solid #eceeeb;font-weight: 600;text-align: left;">'.$payment_booking[0]->login_id.$payment_booking[0]->hotelid.$payment_booking[0]->id.'</td>
					
									</tr>
					
										<tr>
					
										<th style="padding: 10px;border: 1px solid #eceeeb;font-weight: 400;">Lead Name</th>
					
										<td style="padding: 10px;border: 1px solid #eceeeb;font-weight: 600;text-align: left;">'.$guest[0]['firstname'][1].''.$guest[0]['lastname'][1].'</td>
					
									</tr>
					
									<tr>
					
										<th style="padding: 10px;border: 1px solid #eceeeb;font-weight: 400;">Issued on</th>
					
										<td style="padding: 10px;border: 1px solid #eceeeb;font-weight: 600;text-align: left;">'.date('d/M/Y, D', strtotime($payment_booking[0]->bookingdate)).'</td>
					
									</tr>
					
								   </table>
					
								</div>
					
								<div class="booking-information-right" style="    width: 35%;float: left;position: absolute;height: 100%;right: 0;top: 0;">
					
					
					
								<div class="booking-information-right-top" style="    height: calc(100% - 38px);position: relative;top: 0;">
					
									<div class="booking-information-right-top-left" style="float:left; width: 50%;height: 100%;background: #f38321;color: #ffffff;text-align: center;">
					
										<p style="margin-top: 0;font-size: 14px;padding-top: 40px;">Check In</p>
					
										<h1 style=" font-size: 46px;margin: 0;margin-bottom: 12px;">'.date('d', strtotime($payment_booking[0]->checkin)).'</h1>
					
										<i  style="display:block;margin-bottom: 7px;">'.date('M', strtotime($payment_booking[0]->checkin)).', '.date('Y', strtotime($payment_booking[0]->checkin)).'</i>
					
										<i>'.date('D', strtotime($payment_booking[0]->checkin)).'</i>
					
									</div>
					
								   <div class="booking-information-right-top-left" style="float:left;width: 50%;height: 100%;background: #38a4ff;color: #ffffff;text-align: center;">
					
										<p style="margin-top: 0;font-size: 14px;padding-top: 40px;">Check Out</p>
					
										<h1 style=" font-size: 46px;margin: 0;margin-bottom: 12px;">'.date('d', strtotime($payment_booking[0]->checkout)).'</h1>
					
										<i  style="display:block;margin-bottom: 7px;">'.date('M', strtotime($payment_booking[0]->checkout)).', '.date('Y', strtotime($payment_booking[0]->checkout)).'</i>
					
										<i>'.date('D', strtotime($payment_booking[0]->checkout)).'</i>
					
									</div>
					
								</div>
					
								<div class="booking-information-right-bottom" style="    background: #e4293e;color: #ffffff;text-align: center;font-size: 32px;
					
						font-weight: 600;">
					
									'.$daycount.' Nights
					
								</div>
					
					
					
								</div>
					
								 <div style="display:table;clear:both;">
					
								</div>
					
							</div>
					
					
					
							<div class="accomodation-details" style="margin-bottom:10px;">
					
								<div class="booking-information-left-header" style="    border: 1px solid #eceeeb;
					
						border-bottom: none;    padding: 10px; background: #f7f9f8;font-weight: 500;font-size: 14px;">
					
										Accomodation Details
					
									</div>
					
					
					
									<div class="accomodation-left-right">
					
										<div class="accomodation-left" style="width:50%;float:left;">
					
											<table style="width: 100%;text-align: left;border-collapse: collapse;">
					
									<tr>
					
										<th style="padding: 10px;border: 1px solid #eceeeb;font-weight: 400;width:35%; ">Servicename</th>
					
										<td style="padding: 10px;border: 1px solid #eceeeb;font-weight: 600;text-align: left;">'.$Servicename.'</td>
					
									</tr>
					
										<tr>
					
										<th style="padding: 10px;border: 1px solid #eceeeb;font-weight: 400;width:35%;">Service Type </th>
					
										<td style="padding: 10px;border: 1px solid #eceeeb;font-weight: 600;text-align: left;">'.$Servicetype.'</td>
					
									</tr>
					
					
					
										<tr>
					
										<th style="padding: 10px;border: 1px solid #eceeeb;font-weight: 400;width:35%;">Meal Basis </th>
					
										<td style="padding: 10px;border: 1px solid #eceeeb;font-weight: 600;text-align: left;">'.$MealBasis.'</td>
					
									</tr>
					
										<tr>
					
										<th style="padding: 10px;border: 1px solid #eceeeb;font-weight: 400;width:35%;">Service Address</th>
					
										<td style="padding: 10px;border: 1px solid #eceeeb;font-weight: 600;text-align: left;">'.$ServiceAddress.'</td>
					
									</tr>
					
									<tr>
					
										<th style="padding: 10px;border: 1px solid #eceeeb;font-weight: 400;width:35%;">RoomService Type</th>
					
										<td style="padding: 10px;border: 1px solid #eceeeb;font-weight: 600;text-align: left;">'.$RoomServiceType.'</td>
					
									</tr>
					
									<tr>
					
										<th style="padding: 10px;border: 1px solid #eceeeb;font-weight: 400;width:35%;">No Rooms</th>
					
										<td style="padding: 10px;border: 1px solid #eceeeb;font-weight: 600;text-align: left;">'.$NoRooms.'</td>
					
									</tr>
					
								   </table>
					
										</div>
					
										<div class="accomodation-right" style="width:50%;float:left;">
					
											<table style="width: 100%;text-align: left;border-collapse: collapse;">
					
									<tr>
					
										<th style="padding: 10px;border: 1px solid #eceeeb;font-weight: 400;width:35%;">Child </th>
					
										<td style="padding: 10px;border: 1px solid #eceeeb;font-weight: 600;text-align: left;">'.$Child.'</td>
					
									</tr>
					
										<tr>
					
										<th style="padding: 10px;border: 1px solid #eceeeb;font-weight: 400;width:35%;">Desitination</th>
					
										<td style="padding: 10px;border: 1px solid #eceeeb;font-weight: 600;text-align: left;">'.$Desitination.'</td>
					
									</tr>
					
					
					
										<tr>
					
										<th style="padding: 10px;border: 1px solid #eceeeb;font-weight: 400;width:35%;">Reservation Status</th>
					
										<td style="padding: 10px;border: 1px solid #eceeeb;font-weight: 600;text-align: left;">'.$Reservationstatus.'</td>
					
									</tr>
					
										<tr>
					
										<th style="padding: 10px;border: 1px solid #eceeeb;font-weight: 400;width:35%;">NoAdult</th>
					
										<td style="padding: 10px;border: 1px solid #eceeeb;font-weight: 600;text-align: left;">'.$NoAdult.'</td>
					
									</tr>
					
									<tr>
					
										<th style="padding: 10px;border: 1px solid #eceeeb;font-weight: 400;width:35%;">Infants</th>
					
										<td style="padding: 10px;border: 1px solid #eceeeb;font-weight: 600;text-align: left;">'.$Infants.'</td>
					
									</tr>
					
										<tr>
					
										<th style="padding: 10px;border: 1px solid #eceeeb;font-weight: 400;width:35%;">Guest Name</th>
					
										<td style="padding: 10px;border: 1px solid #eceeeb;font-weight: 600;text-align: left;">'.$GuestName.'</td>
					
									</tr>
					
								   </table>
					
										</div>
					
										  <div style="display:table;clear:both;">
					
								</div>
					
									</div>
					
							</div>
					
					
					
							<div class="importantnotes">
					
								<div class="booking-information-left-header" style="    border: 1px solid #eceeeb;
					
						border-bottom: none;    padding: 10px; background: #f7f9f8;font-weight: 500;font-size: 14px;">
					
										Important Notes
					
									</div>
					
					
					
									<div style="border:1px solid #eceeeb;padding:20px;">
					
								'.$PoliciesDetails.'
					
							</div>
					
							 </div>
					
							<div class="map" style="margin-bottom:10px;">
					
								<h1>Hotel Map</h1>
					
								<img style="width:100%" src="'.asset('img/map.jpg').'">
					
								<div id="map"></div>
					
					
					
							</div>
					
						 </div>    
					
					
					
						</div>
					
					</body>
					
					</html>';

        $mail = $tempalte;

        $to = $payment_booking[0]->email;

        $subject = 'Booking Voucher';

        $message = $mail;

        $headers = "From: B2B project<admin@livebeds.com>\r\n";

        $headers .= "MIME-Version: 1.0\r\n";

        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

        mail($to,$subject,$message,$headers);
    }
	
	
	/**
     * Ageny voucherpayment module. It is get voucher from database.
     *
     *@param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function voucherpayment(Request $request)
    {
        $PDF_NAME = 'pdf_voucher_MA'.base64_encode($request->input('bookingid'));

        $payment_booking = DB::table('payment')->where('id', '=', $request->input('bookingid'))->get();

        require_once 'tcpdf/pdfblock/tcpdf_include.php';

        require_once 'tcpdf/tcpdf.php';

        $pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information

        $pdf->SetAuthor('NEW B2B Admin');

        $pdf->SetTitle('NEW B2B Voucher');

        //$pdf->SetSubject('TCPDF Tutorial');

        //$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);

        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER); // set auto page breaks

        $pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);

        // set image scale factor

        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)

        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once dirname(__FILE__).'/lang/eng.php';

            $pdf->setLanguageArray($l);
        }

        $pdf->SetMargins(0, 0, 0, true);

        $pdf->SetFont('times', '', 10);

        $pdf->AddPage(); // add a page

        $pdf->writeHTMLCell(0, 0, '', '', $payment_booking[0]->Mailtemplate, '0', 1, 0, true, 'L', true);

        $pdf->Output(__DIR__.'/../../../../public/pdf/'.$PDF_NAME.'.pdf', 'F');

        $URL = URL::to('/');

        //echo $URL.'/pdf/'.$PDF_NAME.'.pdf';

        $data = array('value' => $URL.'/pdf/'.$PDF_NAME.'.pdf', 'name' => $PDF_NAME);

        return $data;

        exit;
    }
	
	/**
     * Ageny ajaxbookingcheck module. It is get from database.
  
     * @return \Illuminate\Http\Response
     */

    public function ajaxbookingcheck()
    {
        $payment_booking = DB::table('payment')->where('id', '=', $_GET['bookingid'])->get();


        $CheckInDate = $payment_booking[0]->checkin;

        $CheckOutDate = $payment_booking[0]->checkout;

        $HotelId = $payment_booking[0]->hotelid;

        $guest_booking = unserialize($payment_booking[0]->guest);

        $link_adult = '';

        $link_room = '';

        $link_room = '&norooms='.$payment_booking[0]->no_of_room;

        for ($i = 0; $i < $payment_booking[0]->no_of_room; ++$i) {
            $link_room .= '&adult'.$i.'='.$guest_booking[$i]['adult'].'child'.$i.'='.$guest_booking[$i]['child'];

            if ($guest_booking[$i]['child'] != 0) {
                $link_adult .= '<Children>';

                for ($ch = 1; $ch <= $guest_booking[$i]['child']; ++$ch) {
                    if (!empty($guest_booking[$i]['age'])) {
                        $link_adult .= '&childage'.$i.$ch.'='.$guest_booking[$i]['age'][$ch];
                    } else {
                        $link_adult .= '&childage'.$i.$ch.'=4';
                    }
                }
            }
        }

        //echo htmlspecialchars($link_adult);

        exit;
    }
	
	
	/**
     * Ageny mailsentpayment module. It is get from database.
  
     * @return \Illuminate\Http\Response
     */


    public function mailsentpayment(Request $request)
    {

        //echo "<pre>";

        //print_r($request->all());

        $PDF_NAME = 'pdf_mail_MA'.base64_encode($request->input('bookingid'));

        $payment_booking = DB::table('payment')->where('id', '=', $request->input('bookingid'))->get();

        //echo "</pre>";

        //exit;

        require_once 'tcpdf/pdfblock/tcpdf_include.php';

        require_once 'tcpdf/tcpdf.php';

        $pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information

        $pdf->SetAuthor('NEW B2B Admin');

        $pdf->SetTitle('NEW B2B Voucher');

        //$pdf->SetSubject('TCPDF Tutorial');

        //$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);

        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER); // set auto page breaks

        $pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);

        // set image scale factor

        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)

        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once dirname(__FILE__).'/lang/eng.php';

            $pdf->setLanguageArray($l);
        }

        $pdf->SetMargins(0, 0, 0, true);

        $pdf->SetFont('times', '', 10);

        $pdf->AddPage(); // add a page

        $pdf->writeHTMLCell(0, 0, '', '', $payment_booking[0]->Vouchertemplate, '0', 1, 0, true, 'L', true);

        $pdf->Output(__DIR__.'/../../../../public/pdf/'.$PDF_NAME.'.pdf', 'F');

        $URL = URL::to('/');

        $data = $URL.'/pdf/'.$PDF_NAME.'.pdf';

        /*

        $email = $payment_booking[0]->email;



        Mail::send('sitio.enviar_producto', array(), function($message) use ($email) {

            $message

                ->from('vtravelinsertinfo@gmail.com', 'B2B')

                ->to($email)

                ->attach('./pdf/'.$PDF_NAME.'.pdf')

                ->subject('Testing Mail');

        });

        exit;*/

        $payment_booking[0]->email;

        $to = $payment_booking[0]->email;

        $subject = 'B2B Booking details';

        $message = 'test';

        $attach = ($PDF_NAME.'.pdf');

        $message = $data;

        //$m->attach(storage_path('invoice-test.pdf'), 'invoice.pdf', ['mime' => 'application/pdf']);

        $addAttachment = array(

            'as' => $data,

            'mime' => 'application/pdf', );

        $isHTML = 'true';

        $headers = "From: B2B project<admin@livebeds.com>\r\n";

        $headers .= "MIME-Version: 1.0\r\n";

        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

        $headers .= 'Content-Disposition: attachment; filename="'.$data."\"\r\n";

        mail($to,$subject,$message,$headers);

        if ($data) {
            $result = 1;
        } else {
            $result = 0;
        }

        return $result;

        exit;
    }
	
	/**
     * Ageny sendtemplate module. It is get from database.
	 *@param  \Illuminate\Http\Request  $request
  
     * @return \Illuminate\Http\Response
     */

    public function sendtemplate(Request $request)
    {
        $payment_booking = DB::table('payment')->where('id', '=', $_POST['bookingid'])->get();

        $payment_update = DB::table('payment')->where('id', $_POST['bookingid'])->update(['sendnotifictaion' => '1']);

        if (isset($payment_update)) {
            echo '1';
        }
    }
	
		/**
     * Ageny invoicetemplate module. It is get from database.
	 *@param  \Illuminate\Http\Request  $request
  
     * @return \Illuminate\Http\Response
     */

    public function invoicetemplate(Request $request)
    {

        //////vouchertemplate

        //agency detal get

        $payment_booking = DB::table('payment')->where('id', '=', $_POST['bookingid'])->get();

        $Vochername = '';

        $Name = '';

        $Hotelname = '';

        $email = '';

        $Address = '';

        $NoRooms = '';

        $Child = '';

        $Desitination = '';

        if ($payment_booking[0]->supplier == 'travelanda') {
            $roomdeatils = (array) unserialize($payment_booking[0]->roomdeatils);

            $getBookingDetails = $this->getBookingDetails($payment_booking[0]);

            $roomcontent = '';

            $f = 1;

            for ($r = 0; $r < $payment_booking[0]->no_of_room; ++$r) {
                $RoomPrice = base64_decode(Crypt::decrypt($roomdeatils[$r]['RoomPrice']));

                $roomcontent .= ' <tr style="line-height: 30px;">

      <td style="border-bottom: 1px solid #b0b0b0;border-right: 1px solid #b0b0b0;border-left: 1px solid #b0b0b0">'.$f.'</td>

      <td style="border-bottom: 1px solid #b0b0b0;font-size: 10px;border-right: 1px solid #b0b0b0">'.$getBookingDetails->Body->Bookings->HotelBooking->Rooms->Room[$r]->RoomName.'</td>

      <td style="border-bottom: 1px solid #b0b0b0;border-right: 1px solid #b0b0b0">'.$getBookingDetails->Body->Bookings->HotelBooking->Rooms->Room[$r]->NumAdults.'</td>

      <td style="border-bottom: 1px solid #b0b0b0;border-right: 1px solid #b0b0b0">'.$getBookingDetails->Body->Bookings->HotelBooking->Rooms->Room[$r]->NumChildren.'</td>

      <td style="border-bottom: 1px solid #b0b0b0;border-right: 1px solid #b0b0b0">$ '.$RoomPrice.'</td>

   </tr>';

                ++$f;
            }

            $Gethotelresponse = HotelApiController::Gethotelresponse($payment_booking[0]->hotelid);

            $Vochername = $getBookingDetails->Body->Bookings->HotelBooking->BookingReference;

            $Name = $getBookingDetails->Body->Bookings->HotelBooking->LeaderName;

            $Hotelname = $getBookingDetails->Body->Bookings->HotelBooking->HotelName;

            $email = $payment_booking[0]->email;

            $Address = $Gethotelresponse->Body->Hotels->Hotel->Address;

            $bookiingdate = $payment_booking[0]->Bookdate;

            $TotalPrice = $payment_booking[0]->totalprice;

            $Desitination = '';
        }

        if ($payment_booking[0]->supplier == 'tbo') {
            $getBookingDetails = $this->tbobboking_details($payment_booking[0]->BookingReference);

            $tboHolidaysHotelDetails = HotelApiController::tboHolidaysHotelDetails($payment_booking[0]->hotelid);
        }

			$tempalte = '<div class="" style="width: 90%;MARGIN: AUTO;"><table style="width:100%">
	
	   <h3 style="text-align: center">BOOKING VOUCHER</h3>
	
	   <h4 style="text-align: center;MARGIN-BOTTOM: 20px;padding-bottom: 20px;border-bottom: 1px dashed #ccc;">New B2B</h4>
	
	   <tr style="line-height: 30px"> 
	
		  <td ><spam style="font-weight:500;">VOUCHER ID :</spam> '.$Vochername.'</td>
	
		  <td style="text-align: right;"><spam style="font-weight:500;">DATE :</spam> '.$bookiingdate.'</spam></td>
	
	   </tr>
	
	   <tr style="line-height: 30px">
	
		  <td><spam style="font-weight:500;"><spam style="font-weight:500;">Name : </spam>'.$Name.'</td>
	
		  <td style="text-align: right;"><spam style="font-weight:500;">E-mail :</spam> '.$email.'</td>
	
	   </tr>
	
	   <tr style="line-height: 30px">
	
		  <td><spam style="font-weight:500;">Hotel Name :</spam> '.$Hotelname.'</td>
	
		  <td style="text-align: right;"><spam style="font-weight:500;">Hote Address :</spam> '.$Address.'</td>
	
	   </tr>
	
	</table>
	
	<table style="text-align: center;width:100%">
	
	   <tr style="background-color: #666666;color: #fff;line-height: 30px;">
	
		  <th style="border-bottom: 1px solid #b0b0b0;border-left: 1px solid #b0b0b0">S.No</th>
	
		  <th style="border-bottom: 1px solid #b0b0b0;border-right: 1px solid #b0b0b0">ROOM DETAIL</th>
	
		  <th style="border-bottom: 1px solid #b0b0b0;border-right: 1px solid #b0b0b0">ADULT</th>
	
		  <th style="border-bottom: 1px solid #b0b0b0;border-right: 1px solid #b0b0b0">CHILDREN</th>
	
		  <th style="border-bottom: 1px solid #b0b0b0;border-right: 1px solid #b0b0b0">PRICE</th>
	
	   </tr>
	
	  '.$roomcontent.'
	
	   <tr style="line-height: 30px;">
	
		  <td ></td>
	
		  <td ></td>
	
		  <td style="border-right: 1px solid #b0b0b0;">Discount Applied</td>
	
		  <td style="border-bottom: 1px solid #b0b0b0;"></td>
	
		  <td style="border-bottom: 1px solid #b0b0b0;border-right: 1px solid #b0b0b0">$ 0</td>
	
	   </tr>
	
	   <tr style="line-height: 30px;">
	
		  <td ></td>
	
		  <td ></td>
	
		  <td style="border-right: 1px solid #b0b0b0"> GRAND TOTAL</td>
	
		  <td style="border-bottom: 1px solid #b0b0b0;"></td>
	
		  <td style="border-bottom: 1px solid #b0b0b0;border-right: 1px solid #b0b0b0">$ '.$TotalPrice.'</td>
	
	   </tr>
	
	
	
	</table> <h2 style="font-size: 12px;line-height: 50px"> THANKYOU FOR BOOKING WITH NEW B2B</h2></div>';

        echo $tempalte;
    }
	
	
	
	/**
     * Ageny vouchertemplate module. It is get from database.
	 *@param  \Illuminate\Http\Request  $request
  
     * @return \Illuminate\Http\Response
     */

    public function vouchertemplate(Request $request)
    {

        //////vouchertemplate

        //agency detal get

        $payment_booking = DB::table('payment')->where('id', '=', $_POST['bookingid'])->get();

        $guest = unserialize($payment_booking[0]->guest);

        $Servicename = '';

        $Servicetype = '';

        $MealBasis = '';

        $ServiceAddress = '';

        $RoomServiceType = '';

        $NoRooms = '';

        $Child = '';

        $Desitination = '';

        $starCategory = '';

        $Reservationstatus = '';

        $GuestName = '';

        $NoAdult = '';

        $Infants = '';

        $PoliciesDetails = '';

        if ($payment_booking[0]->supplier == 'travelanda') {
            $getBookingDetails = $this->getBookingDetails($payment_booking[0]);

            $Gethotelresponse = HotelApiController::Gethotelresponse($payment_booking[0]->hotelid);

            $Description = '';

            if (isset($Gethotelresponse->Body->Hotels->Hotel->Description)) {
                $Description = $Gethotelresponse->Body->Hotels->Hotel->Description;
            }

            if (isset($getBookingDetails->Body->Bookings)) {
                foreach ($getBookingDetails->Body->Bookings->HotelBooking as $HotelBooking) {
                    if ($payment_booking[0]->BookingReference == $HotelBooking->BookingReference) {
                        $bo = 1;

                        if (isset($HotelBooking->Policies->Policy)) {
                            $PoliciesDetails .= $Description;

                            $PoliciesDetails .= '<div class="" style="margin-bottom: 5px;"><span> </span> You may cancel your reservation for no charge before this deadline. 

		 Please note that we will assess full payment of reservation if you must cancel after this deadline.</div>';

                            foreach ($HotelBooking->Policies->Policy as $Policy) {
                                if ($Policy->Type == 'Percentage') {
                                    $PoliciesDetails .= '<div class="" style="margin-bottom: 5px;"><span></span> If you will cancel the booking after  <b>'.$Policy->From.'</b> then you should  pay  <b'.$Policy->Value.'% </b> penalty for this booking.</div>';
                                }

                                if ($Policy->Type == 'Amount') {
                                    $PoliciesDetails .= ' <div class="" style="margin-bottom: 5px;"><span> </span> If you will cancel the booking after  <b>'.$Policy->From.'</b> then you should  pay $ <b>'.$Policy->Value.'</b> penalty for this booking.</div>';
                                }

                                if ($Policy->Type == 'Nights') {
                                    $PoliciesDetails .= '<div class="" style="margin-bottom: 5px;"><span></span> If you will cancel the booking after  <b>'.$Policy->From.'</b> then you should  pay <b>'.$Policy->Value.'</b> night price penalty for this booking.</div>';
                                }

                                ++$bo;
                            }
                        }

                        // echo '<pre>';

                        //print_r($payment_booking);

                        // print_r($HotelBooking);

                        //echo '</pre>';

                        /*echo '<pre>';

    print_r($guest);

    echo '</pre>';*/

                        //guest dateil

                        $roomGuestDetails = '';

                        foreach ($guest as $guestDetails) {
                            if ($guestDetails['adult'] != 0) {
                                for ($a = 1; $a <= $guestDetails['adult']; ++$a) {
                                    $roomGuestDetails .= '<p style="margin:0;">'.$guestDetails['title'][$a].'.'.$guestDetails['firstname'][$a].' '.$guestDetails['lastname'][$a].'</p>';
                                }
                            }

                            if ($guestDetails['child'] != 0) {
                                for ($c = 1; $c <= $guestDetails['child']; ++$c) {
                                    $roomGuestDetails .= '<p style="margin:0;">'.$guestDetails['firstname'][$c].' '.$guestDetails['lastname'][$c].'</p>';
                                }
                            }
                        }

                        $RoomName = '';

                        $NumAdults = '';

                        $NumChildren = '';

                        $room = 0;

                        foreach ($HotelBooking->Rooms->Room as $roomDetails) {
                            $RoomName = $roomDetails->RoomName;

                            $NumAdults += $roomDetails->NumAdults;

                            $NumChildren += $roomDetails->NumChildren;

                            ++$room;
                        }

                        $Servicename = $HotelBooking->HotelName;

                        $Servicetype = 'Hotel';

                        $MealBasis = $HotelBooking->BoardType;

                        $ServiceAddress = $HotelBooking->City;

                        $RoomServiceType = $RoomName;

                        $NoRooms = $room;

                        $Child = $NumChildren;

                        $Desitination = $HotelBooking->City;

                        $starCategory = '';

                        $Reservationstatus = 'Confirm';

                        $GuestName = $roomGuestDetails;

                        $NoAdult = $NumAdults;

                        $Infants = $NumChildren;
                    }
                }
            }
        }

        if ($payment_booking[0]->supplier == 'tbo') {
            $getBookingDetails = $this->tbobboking_details($payment_booking[0]->BookingReference);

            $tboHolidaysHotelDetails = HotelApiController::tboHolidaysHotelDetails($payment_booking[0]->hotelid);

            /*	echo '<pre>';

        print_r($tboHolidaysHotelDetails['sBody']['HotelDetailsResponse']['HotelDetails']['Description']);

        echo '</pre>';*/

            $RoomName = '';

            if (!empty($getBookingDetails['sBody']['HotelBookingDetailResponse']['BookingDetail']['Roomtype']['RoomDetails'])) {
                for ($r = 0; $r < $payment_booking[0]->no_of_room; ++$r) {
                    $RoomName .= '<p>'.$getBookingDetails['sBody']['HotelBookingDetailResponse']['BookingDetail']['Roomtype']['RoomDetails'][$r]['RoomName'].'</p>';
                }
            }

            //guest dateil

            $roomGuestDetails = '';

            $NumAdults = 0;

            $NumChildren = 0;

            foreach ($guest as $guestDetails) {
                $NumAdults += $guestDetails['adult'];

                if ($guestDetails['adult'] != 0) {
                    for ($a = 1; $a <= $guestDetails['adult']; ++$a) {
                        $roomGuestDetails .= '<p style="margin:0;">'.$guestDetails['title'][$a].'.'.$guestDetails['firstname'][$a].' '.$guestDetails['lastname'][$a].'</p>';
                    }
                }

                if ($guestDetails['child'] != 0) {
                    $NumChildren += $guestDetails['child'];

                    for ($c = 1; $c <= $guestDetails['child']; ++$c) {
                        $roomGuestDetails .= '<p style="margin:0;">'.$guestDetails['firstname'][$c].' '.$guestDetails['lastname'][$c].'</p>';
                    }
                }
            }

            $PoliciesDetails .= $tboHolidaysHotelDetails['sBody']['HotelDetailsResponse']['HotelDetails']['Description'];

            $PoliciesDetails .= '<div class=""><span> </span> You may cancel your reservation for no charge before this deadline. 

		 Please note that we will assess full payment of reservation if you must cancel after this deadline.</div>';

            $attr = '@attributes';

            $bo = 1;

            if (isset($getBookingDetails['sBody']['HotelBookingDetailResponse']['BookingDetail']['HotelCancelPolicies']['CancelPolicy'][0])) {
                foreach ($getBookingDetails['sBody']['HotelBookingDetailResponse']['BookingDetail']['HotelCancelPolicies']['CancelPolicy'] as $Policy) {
                    if ($Policy[$attr]['ChargeType'] == 'Fixed') {
                        $PoliciesDetails .= '<div class="">If you will cancel the booking  <b>'.$Policy[$attr]['FromDate'].'</b> to  <b>'.$Policy[$attr]['ToDate'].'</b> then you should pay '.$Policy[$attr]['Currency'].''.$Policy[$attr]['CancellationCharge'].' penalty for this booking</div>';
                    }

                    if ($Policy[$attr]['ChargeType'] == 'Percentage') {
                        $PoliciesDetails .= '<div class=""><span>If you will cancel the booking  <b>'.$Policy[$attr]['FromDate'].' </b> to  <b>'.$Policy[$attr]['ToDate'].'</b> then you should pay '.$Policy[$attr]['CancellationCharge'].' % penalty for this booking</div>';
                    }

                    if ($Policy[$attr]['ChargeType'] == 'Night') {
                        $PoliciesDetails .= '<div class=""><span>If you will cancel the booking  <b>'.$Policy[$attr]['FromDate'].' </b> to  <b>'.$Policy[$attr]['ToDate'].'</b> then you should pay '.$Policy[$attr]['CancellationCharge'].' % penalty for this booking</div>';
                    }

                    ++$bo;
                }
            }

            $Servicename = $getBookingDetails['sBody']['HotelBookingDetailResponse']['BookingDetail']['HotelName'];

            $Servicetype = 'Hotel';

            $MealBasis = $getBookingDetails['sBody']['HotelBookingDetailResponse']['BookingDetail']['HotelName'];

            $ServiceAddress = $getBookingDetails['sBody']['HotelBookingDetailResponse']['BookingDetail']['AddressLine1'];

            $RoomServiceType = $RoomName;

            $NoRooms = $payment_booking[0]->no_of_room;

            $Child = ''; //$NumChildren;

            $Desitination = $getBookingDetails['sBody']['HotelBookingDetailResponse']['BookingDetail']['City'];

            $starCategory = '';

            $Reservationstatus = 'Confirm';

            $GuestName = $roomGuestDetails;

            $NoAdult = $NumAdults;

            $Infants = $NumChildren;
        }

        $name = '';

        $address = '';

        $city = '';

        $country = '';

        if ($payment_booking[0]->user_type == 'AgencyManger') {
            $agency = DB::table('agency')->where('loginid', '=', $payment_booking[0]->login_id)->get();

            /*	echo '<pre>';

        print_r($agency);

        echo '</pre>';*/

            $name = $agency[0]->aname;

            $address = $agency[0]->address1;

            $city = $agency[0]->city;

            $country = $agency[0]->country;
        }

        if ($payment_booking[0]->user_type == 'SubAgencyManger') {
            $agency = DB::table('agency')->where('loginid', '=', $payment_booking[0]->login_id)->get();

            /*	echo '<pre>';

        print_r($agency);

        echo '</pre>';*/

            $name = $agency[0]->aname;

            $address = $agency[0]->address1;

            $city = $agency[0]->city;

            $country = $agency[0]->country;
        }

        if ($payment_booking[0]->user_type == 'UserInfo') {
            $userinformation = DB::table('userinformation')->where('loginid', '=', $payment_booking[0]->login_id)->get();

            /*	echo '<pre>';

        print_r($userinformation);

        echo '</pre>';*/

            $name = $userinformation[0]->name;

            $address = $userinformation[0]->email;

            $city = $userinformation[0]->phone;
        }

        /*echo '<pre>';

        print_r($guest[0]['firstname'][1]);

        echo '</pre>';*/

        $date1 = date_create($payment_booking[0]->checkin);

        $date2 = date_create($payment_booking[0]->checkout);

        $diff = date_diff($date1, $date2);

        $daycount = $diff->days;


        $tempalte = '
		
				<!DOCTYPE html>
		
		<html>
		
		<head>
		
		<meta charset="UTF-8">
		
		<title>Voucher</title>
		
		</head>
		
		<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500" rel="stylesheet">
		
		<body style="font-family: "Roboto", sans-serif;background:#f0f4f5;font-size:13px;color:#6e6963">
		
			<div class="container" style="max-width:900px;margin:auto;">
		
			<div id="outprint">
		
			   <header style="font-size: 14px; font-weight: 500;background: #036292;text-align: center;color: #ffffff;text-transform: uppercase;padding: 10px;"> Please Present this voucher upon arrival </header>
		
				<div class="below-header" style="padding:20px;background:#ffffff;margin-bottom:20px;border:1px solid #e2e2e2;">
		
				<div class="logo-invoice-details" style=" margin-bottom:10px;">
		
					<div class="logo" style="padding-top:20px;width: 50%;float: left;">
		
						<img src="img/logo_default_dark.png">
		
					</div>
		
					<div class="l-invoice-details" style="width: 50%;float: right;text-align: right;">
		
						<h1 style="margin-top: 0;font-size: 30px;margin-bottom:10px;"><span style="font-weight:300;">Service</span> Voucher</h1>
		
						<p style="margin:0;">'.$name.'</p>
		
						<address style="    width: 150px;margin-left: auto;font-style: normal;">
		
							'.$address.', '.$city.', '.$country.'.
		
						</address>
		
					</div>
		
					<div style="display:table;clear:both;">
		
					</div>
		
				</div>
		
		
		
				<div class="booking-information" style="position:relative;margin-bottom:10px;">
		
					<div class="booking-information-left" style="width:65%;float:left">
		
						<div class="booking-information-left-header" style="    border: 1px solid #eceeeb;
		
			border-bottom: none;    padding: 10px; background: #f7f9f8;font-weight: 500;font-size: 14px;">
		
							Booking Information
		
						</div>
		
					   <table style="width: 100%;text-align: left;border-collapse: collapse;">
		
						<tr>
		
							<th style="padding: 10px;border: 1px solid #eceeeb;font-weight: 400;">Voucher No</th>
		
							<td style="padding: 10px;border: 1px solid #eceeeb;font-weight: 600;text-align: left;">LBVN'.$payment_booking[0]->hotelid.'</td>
		
						</tr>
		
							<tr>
		
							<th style="padding: 10px;border: 1px solid #eceeeb;font-weight: 400;">LB REF No</th>
		
							<td style="padding: 10px;border: 1px solid #eceeeb;font-weight: 600;text-align: left;">LBHR'.$payment_booking[0]->hotelid.'</td>
		
						</tr>
		
							<tr>
		
							<th style="padding: 10px;border: 1px solid #eceeeb;font-weight: 400;">Supplier Ref No</th>
		
							<td style="padding: 10px;border: 1px solid #eceeeb;font-weight: 600;text-align: left;">'.$payment_booking[0]->id.$payment_booking[0]->hotelid.$payment_booking[0]->login_id.'</td>
		
						</tr>
		
							<tr>
		
							<th style="padding: 10px;border: 1px solid #eceeeb;font-weight: 400;">Re-confirmation No/Msg</th>
		
							<td style="padding: 10px;border: 1px solid #eceeeb;font-weight: 600;text-align: left;">'.$payment_booking[0]->login_id.$payment_booking[0]->hotelid.$payment_booking[0]->id.'</td>
		
						</tr>
		
							<tr>
		
							<th style="padding: 10px;border: 1px solid #eceeeb;font-weight: 400;">Lead Name</th>
		
							<td style="padding: 10px;border: 1px solid #eceeeb;font-weight: 600;text-align: left;">'.$guest[0]['firstname'][1].''.$guest[0]['lastname'][1].'</td>
		
						</tr>
		
						<tr>
		
							<th style="padding: 10px;border: 1px solid #eceeeb;font-weight: 400;">Issued on</th>
		
							<td style="padding: 10px;border: 1px solid #eceeeb;font-weight: 600;text-align: left;">'.date('d/M/Y, D', strtotime($payment_booking[0]->bookingdate)).'</td>
		
						</tr>
		
		
					   </table>
		
					</div>
		
					<div class="booking-information-right" style="    width: 35%;float: left;position: absolute;height: 100%;right: 0;top: 0;">
		
		
		
					<div class="booking-information-right-top" style="    height: calc(100% - 38px);position: relative;top: 0;">
		
						<div class="booking-information-right-top-left" style="float:left; width: 50%;height: 100%;background: #f38321;color: #ffffff;text-align: center;">
		
							<p style="margin-top: 0;font-size: 14px;padding-top: 40px;">Check In</p>
		
							<h1 style=" font-size: 46px;margin: 0;margin-bottom: 12px;">'.date('d', strtotime($payment_booking[0]->checkin)).'</h1>
		
							<i  style="display:block;margin-bottom: 7px;">'.date('M', strtotime($payment_booking[0]->checkin)).', '.date('Y', strtotime($payment_booking[0]->checkin)).'</i>
		
							<i>'.date('D', strtotime($payment_booking[0]->checkin)).'</i>
		
						</div>
		
					   <div class="booking-information-right-top-left" style="float:left;width: 50%;height: 100%;background: #38a4ff;color: #ffffff;text-align: center;">
		
							<p style="margin-top: 0;font-size: 14px;padding-top: 40px;">Check Out</p>
		
							<h1 style=" font-size: 46px;margin: 0;margin-bottom: 12px;">'.date('d', strtotime($payment_booking[0]->checkout)).'</h1>
		
							<i  style="display:block;margin-bottom: 7px;">'.date('M', strtotime($payment_booking[0]->checkout)).', '.date('Y', strtotime($payment_booking[0]->checkout)).'</i>
		
							<i>'.date('D', strtotime($payment_booking[0]->checkout)).'</i>
		
						</div>
		
					</div>
		
					<div class="booking-information-right-bottom" style="    background: #e4293e;color: #ffffff;text-align: center;font-size: 32px;
		
			font-weight: 600;">
		
						'.$daycount.' Nights
		
					</div>
		
		
		
					</div>
		
					 <div style="display:table;clear:both;">
		
					</div>
		
				</div>
		
		
		
				<div class="accomodation-details" style="margin-bottom:10px;">
		
					<div class="booking-information-left-header" style="    border: 1px solid #eceeeb;
		
			border-bottom: none;    padding: 10px; background: #f7f9f8;font-weight: 500;font-size: 14px;">
		
							Accomodation Details
		
						</div>
		
		
		
						<div class="accomodation-left-right">
		
							<div class="accomodation-left" style="width:50%;float:left;">
		
								<table style="width: 100%;text-align: left;border-collapse: collapse;">
		
						<tr>
		
							<th style="padding: 10px;border: 1px solid #eceeeb;font-weight: 400;width:35%; ">Servicename</th>
		
							<td style="padding: 10px;border: 1px solid #eceeeb;font-weight: 600;text-align: left;">'.$Servicename.'</td>
		
						</tr>
		
							<tr>
		
							<th style="padding: 10px;border: 1px solid #eceeeb;font-weight: 400;width:35%;">Service Type </th>
		
							<td style="padding: 10px;border: 1px solid #eceeeb;font-weight: 600;text-align: left;">'.$Servicetype.'</td>
		
						</tr>
		
		
		
							<tr>
		
							<th style="padding: 10px;border: 1px solid #eceeeb;font-weight: 400;width:35%;">Meal Basis </th>
		
							<td style="padding: 10px;border: 1px solid #eceeeb;font-weight: 600;text-align: left;">'.$MealBasis.'</td>
		
						</tr>
		
							<tr>
		
							<th style="padding: 10px;border: 1px solid #eceeeb;font-weight: 400;width:35%;">Service Address</th>
		
							<td style="padding: 10px;border: 1px solid #eceeeb;font-weight: 600;text-align: left;">'.$ServiceAddress.'</td>
		
						</tr>
		
						<tr>
		
							<th style="padding: 10px;border: 1px solid #eceeeb;font-weight: 400;width:35%;">RoomService Type</th>
		
							<td style="padding: 10px;border: 1px solid #eceeeb;font-weight: 600;text-align: left;">'.$RoomServiceType.'</td>
		
						</tr>
		
						<tr>
		
							<th style="padding: 10px;border: 1px solid #eceeeb;font-weight: 400;width:35%;">No Rooms</th>
		
							<td style="padding: 10px;border: 1px solid #eceeeb;font-weight: 600;text-align: left;">'.$NoRooms.'</td>
		
						</tr>
		
					   </table>
		
							</div>
		
							<div class="accomodation-right" style="width:50%;float:left;">
		
								<table style="width: 100%;text-align: left;border-collapse: collapse;">
		
						<tr>
		
							<th style="padding: 10px;border: 1px solid #eceeeb;font-weight: 400;width:35%;">Child </th>
		
							<td style="padding: 10px;border: 1px solid #eceeeb;font-weight: 600;text-align: left;">'.$Child.'</td>
		
						</tr>
		
							<tr>
		
							<th style="padding: 10px;border: 1px solid #eceeeb;font-weight: 400;width:35%;">Desitination</th>
		
							<td style="padding: 10px;border: 1px solid #eceeeb;font-weight: 600;text-align: left;">'.$Desitination.'</td>
		
						</tr>
		
		
		
							<tr>
		
							<th style="padding: 10px;border: 1px solid #eceeeb;font-weight: 400;width:35%;">Reservation Status</th>
		
							<td style="padding: 10px;border: 1px solid #eceeeb;font-weight: 600;text-align: left;">'.$Reservationstatus.'</td>
		
						</tr>
		
							<tr>
		
							<th style="padding: 10px;border: 1px solid #eceeeb;font-weight: 400;width:35%;">NoAdult</th>
		
							<td style="padding: 10px;border: 1px solid #eceeeb;font-weight: 600;text-align: left;">'.$NoAdult.'</td>
		
						</tr>
		
						<tr>
		
							<th style="padding: 10px;border: 1px solid #eceeeb;font-weight: 400;width:35%;">Infants</th>
		
							<td style="padding: 10px;border: 1px solid #eceeeb;font-weight: 600;text-align: left;">'.$Infants.'</td>
		
						</tr>
		
							<tr>
		
							<th style="padding: 10px;border: 1px solid #eceeeb;font-weight: 400;width:35%;">Guest Name</th>
		
							<td style="padding: 10px;border: 1px solid #eceeeb;font-weight: 600;text-align: left;">'.$GuestName.'</td>
		
						</tr>
		
					   </table>
		
							</div>
		
							  <div style="display:table;clear:both;">
		
					</div>
		
						</div>
		
				</div>
		
		
		
				<div class="importantnotes">
		
					<div class="booking-information-left-header" style="    border: 1px solid #eceeeb;
		
			border-bottom: none;    padding: 10px; background: #f7f9f8;font-weight: 500;font-size: 14px;">
		
							Important Notes
		
						</div>
		
		
		
						<div style="border:1px solid #eceeeb;padding:20px;">
		
					'.$PoliciesDetails.'
		
				</div>
		
				 </div>
		
				<div class="map" style="margin-bottom:10px;">
		
					<h1>Hotel Map</h1>
		
					<img style="width:100%" src="'.asset('img/map.jpg').'">
		
					<div id="map"></div>
		
		
		
				</div>
		
			 </div>    
		
				<div class="print-close" style="display:inline-block;padding:7px;background:#d8d6d7">
		
					<input type="button" style="background:#f9783e;border:1px solid #e08558;text-align:center;cursor:pointer;  color:#ffffff;padding:7px;" value="Print" class="Printdocument" /> 
		
		
		
				<input type="button" style=" margin-left:3px; background:#ffffff;border:1px solid #ffffff;text-align:center;cursor:pointer;  color:#333333;padding:7px;" value="Close" class="closevocher"/> 
		
		   </div>
		
		
		
			</div>
		
		</body>
		
		</html>



		';

        echo $tempalte;
    }
	
	
	/**
     * Ageny tbobboking_details module. It is get from database.
	 *@param  \Illuminate\Http\Request  $request
  
     * @return \Illuminate\Http\Response
     */

    public function tbobboking_details($id)
    {
        $url = 'http://api.tbotechnology.in/HotelAPI_V7/HotelService.svc';

        // The value for the SOAPAction: header It will change among methods

        $action = 'http://TekTravel/HotelBookingApi/HotelBookingDetail';

        // Get the SOAP data into a string, I am using HEREDOC syntax

        // but how you do this is irrelevant, the point is just get the

        // body of the request into a string

        // You need to take reference of document to use specific request for specific method, here was:Action will change

        $mySOAP = <<<EOD

<?xml version="1.0" encoding="utf-8" ?>

<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:hot="http://TekTravel/HotelBookingApi">

<soap:Header xmlns:wsa='http://www.w3.org/2005/08/addressing' >

<hot:Credentials UserName="hldypln" Password="Hol@93669601"> </hot:Credentials>

<wsa:Action>http://TekTravel/HotelBookingApi/HotelBookingDetail</wsa:Action>

<wsa:To>http://api.tbotechnology.in/hotelapi_v7/hotelservice.svc</wsa:To>

</soap:Header>

<soap:Body>

<hot:HotelBookingDetailRequest>

<hot:BookingId>$id</hot:BookingId>

</hot:HotelBookingDetailRequest>

</soap:Body>

</soap:Envelope>

EOD;

        // The HTTP headers for the request (based on image above)

        // Content-Type and SOAPAction are important parameter

        $headers = array(

            'Content-Type: application/soap+xml; charset=utf-8',

            'Content-Length: '.strlen($mySOAP),

            'SOAPAction: '.$action,

        );

        // Build the cURL session

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_POST, true);

        // Set required soap header

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // Set request xml

        curl_setopt($ch, CURLOPT_POSTFIELDS, $mySOAP);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Send the request and check the response

        // below you will be requesting our api using  curl_exec($ch), and $result contains api response

        if (($result = curl_exec($ch)) === false) {
            die('cURL error: '.curl_error($ch)."<br />\n");
        } else {
            $response = preg_replace("/(<\/?)(\w+):([^>]*>)/", '$1$2$3', $result);

            $xml = new \SimpleXMLElement($response);

            $array = json_decode(json_encode((array) $xml), true);

            return $array;
        }

        curl_close($ch);
    }

    public function getBookingDetails($getDetailsBook)
    {
        $url = 'http://xmldemo.travellanda.com/xmlv1/HotelBookingDetailsRequest.xsd';

        $checkIn = $getDetailsBook->checkin;

        $checkOut = $getDetailsBook->checkout;

        $BookingStart = date('Y-m-d', strtotime($getDetailsBook->Bookdate));

        $BookingEnd = date('Y-m-d', strtotime($getDetailsBook->Bookdate));

        $adminportal = DB::select('SELECT * FROM adminportal WHERE id=1');

        $user = $adminportal[0]->Travelanda_Test_Usename;

        $password = $adminportal[0]->Travelanda_Test_Password;

        if ($adminportal[0]->Travelanda_Live == '1') {
            $user = $adminportal[0]->Travelanda_Test_Usename; //$adminportal[0]->Travelanda_Live_Username;

            $password = $adminportal[0]->Travelanda_Test_Password; //$adminportal[0]->Travelanda_Live_Password;
        }

        //$user = 'a8f59bf51803d0f189b76cbf45ecff2e';

        //$password = 'jRTLGatyuxRx';

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
