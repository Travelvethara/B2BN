<?php

namespace App\Http\Controllers\Profile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Hotel\HotelApiController;

class ProfileController extends HotelApiController
{
    public function __construct()
    {
        $this->middleware('auth');
    }
	
	
	/**
     * Ageny index module. It is profile for agency and user. they can edit own profile.
     *
     *@param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $notification_Controller = controller::notification_Controller();

        //print_r($RoleIdPremissions);

        $data['whologin'] = $notification_Controller['whologin'];

        $data['activeDetails'] = $notification_Controller['agency_array'];

        $data['agecnyresultsnotification'] = $notification_Controller['agecnyresults_notification'];

        $data['agecnyresultsnotificationread'] = $notification_Controller['agecnyresults_notification_read'];

        $data['userresultsnotification'] = $notification_Controller['user_results_notification'];

        $data['userresultsnotificationread'] = $notification_Controller['user_results_notification_read'];

        $data['pagename'] = 'profile';
        if (Auth::check()) {
            $Loginid = Auth::user()->id;
            $data['CAgencyDetails'] = '';
            $RoleIdPremissions = controller::Role_Permissions();
            //print_r($RoleIdPremissions);
            $data['Premissions'] = $RoleIdPremissions;

            /*  echo '<pre>';
           print_r($CAgencydetails);
           echo '</pre>';*/

            if (Auth::user()->user_type == 'AgencyManger') {
                $CAgencydetails = DB::table('agency')->where('loginid', '=', ''.$Loginid.'')->get();

                $data['name'] = $CAgencydetails[0]->name;
                $data['email'] = $CAgencydetails[0]->email;
                $data['phone'] = $CAgencydetails[0]->phone;
                $data['userid'] = $CAgencydetails[0]->userid;
                $data['id'] = $CAgencydetails[0]->id;
                $data['loginid'] = $Loginid;
                $data['type'] = 'AgencyManger';
            }

            if (Auth::user()->user_type == 'SubAgencyManger') {
                $CAgencydetails = DB::table('agency')->where('loginid', '=', ''.$Loginid.'')->get();
                $data['name'] = $CAgencydetails[0]->name;
                $data['email'] = $CAgencydetails[0]->email;
                $data['phone'] = $CAgencydetails[0]->phone;
                $data['userid'] = $CAgencydetails[0]->userid;
                $data['id'] = $CAgencydetails[0]->id;
                $data['loginid'] = $Loginid;
                $data['type'] = 'AgencyManger';
            }

            if (Auth::user()->user_type == 'UserInfo') {
                $CAgencydetails = DB::table('userinformation')->where('loginid', '=', ''.$Loginid.'')->get();
                $data['name'] = $CAgencydetails[0]->name;
                $data['email'] = $CAgencydetails[0]->email;
                $data['phone'] = $CAgencydetails[0]->phone;
                $data['userid'] = $CAgencydetails[0]->userid;
                $data['id'] = $CAgencydetails[0]->id;
                $data['loginid'] = $Loginid;
                $data['type'] = 'UserInfo';
            }

            return view('profile.profile', $data);
        } else {
            return redirect('/');
        }
    }
	
	
   /**
     * Ageny profileupdate module. It is profile for agency and user. they can update own profile.
     *
     *@param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
	

    public function profileupdate(Request $request)
    {
        $validator = $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|email|',
            'phone' => 'required',

        ]);
        if ($request->input('changepassword')) {
            $validator1 = $this->validate($request, [

                'password' => 'required|string|min:6|confirmed',

            ]);
        }

        $update_array = array();
        if ($request->input('type') == 'AgencyManger') {
            $user_type = 'Agency';

            $lastInsertedID = DB::table('agency')->where('id', $request->input('id'))->update(['name' => $request->input('name'), 'email' => $request->input('email'), 'phone' => $request->input('phone')]);

            $password = Hash::make($request->input('password'));

            $users = DB::table('users')->where('id', $request->input('loginid'))->update(['email' => $request->input('email'), 'name' => $request->input('name')]);
            if ($request->input('changepassword')) {
                $crybtPassword = Crypt::encrypt(base64_encode($request->input('password')));
                $users = DB::table('users')->where('id', $request->input('loginid'))->update(['email' => $request->input('email'), 'password' => $password, 'crybtPassword' => $crybtPassword]);

                $update_array['Password']['from'] = 'changed';
                $update_array['Password']['to'] = 'changed';
            }

            //agancy update news

            $select_table = DB::table('agency')->where('id', '=', ''.$request->input('id').'')->get();

            /*echo '<pre>';
            print_r($select_table[0]);
            echo '</pre>';*/
            if (isset($select_table[0]) && !empty($select_table[0])) {
                if ($select_table[0]->name != $request->input('name')) {
                    $update_array['Name']['from'] = $select_table[0]->name;
                    $update_array['Name']['to'] = $request->input('name');
                }
                if ($select_table[0]->email != $request->input('email')) {
                    $update_array['Email']['from'] = $select_table[0]->email;
                    $update_array['Email']['to'] = $request->input('email');
                }
                if ($select_table[0]->phone != $request->input('mphone')) {
                    $update_array['Phone']['from'] = $select_table[0]->phone;
                    $update_array['Phone']['to'] = $request->input('mphone');
                }

                $update_array_data = array();

                if (isset($update_array)) {
                    $update_array_data['UserRole'] = 'Agency';
                    $update_array_data['Rid'] = $request->input('id');
                    $update_array_new = serialize($update_array);
                    $update_array_data['Updatedetail'] = $update_array_new;
                    $UpdateDetail = DB::table('UpdateDetail')->insertGetId($update_array_data);
                }
            }
        }

        if ($request->input('type') == 'UserInfo') {
            $user_type = 'User';

            $lastInsertedID = DB::table('userinformation')->where('id', $request->input('id'))->update(['name' => $request->input('name'), 'email' => $request->input('email'), 'phone' => $request->input('phone')]);

            $password = Hash::make($request->input('password'));
            $users = DB::table('users')->where('id', $request->input('loginid'))->update(['email' => $request->input('email')]);
            if ($request->input('changepassword')) {
                $crybtPassword = Crypt::encrypt(base64_encode($request->input('password')));
                $users = DB::table('users')->where('id', $request->input('loginid'))->update(['email' => $request->input('email'), 'password' => $password, 'crybtPassword' => $crybtPassword]);
            }

            $select_table = DB::table('agency')->where('id', '=', ''.$request->input('id').'')->get();

            /*echo '<pre>';
            print_r($select_table[0]);
            echo '</pre>';*/
            if (isset($select_table[0]) && !empty($select_table[0])) {
                if ($select_table[0]->name != $request->input('name')) {
                    $update_array['Name']['from'] = $select_table[0]->name;
                    $update_array['Name']['to'] = $request->input('name');
                }
                if ($select_table[0]->email != $request->input('email')) {
                    $update_array['Email']['from'] = $select_table[0]->email;
                    $update_array['Email']['to'] = $request->input('email');
                }
                if ($select_table[0]->phone != $request->input('mphone')) {
                    $update_array['Phone']['from'] = $select_table[0]->phone;
                    $update_array['Phone']['to'] = $request->input('mphone');
                }

                $update_array_data = array();

                if (isset($update_array)) {
                    $update_array_data['UserRole'] = 'User';
                    $update_array_data['Rid'] = $request->input('id');
                    $update_array_new = serialize($update_array);
                    $update_array_data['Updatedetail'] = $update_array_new;
                    $UpdateDetail = DB::table('UpdateDetail')->insertGetId($update_array_data);
                }
            }
        }

        $data = array('name' => 'Admin', 'username' => $request->input('email'), 'usertype' => $user_type);
        $mail = view('mail.admin.updatemail', $data);

        $to = 'maniprakashpalani@gmail.com'; //'vasistcompany@gmail.com';
        $subject = $user_type.' Profile Updated';
        $message = $mail;
        $headers = 'MIME-Version: 1.0'."\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";
        $headers .= 'From: B2B project <travelinsertinfo@gmail.com>'."\r\n";
        mail($to, $subject, $message, $headers);

        return redirect()->route('profile', ['datas' => 'update']);
    }

    /**
     * @desc ajax call from adminApicontrol view
     *
     * @param no param
     *
     * @return Cancellation text
     */
    public function adminApicontrol()
    {
        $notification_Controller = controller::notification_Controller();

        //print_r($RoleIdPremissions);

        $data['pagename'] = 'adminApicontrol';

        $data['whologin'] = $notification_Controller['whologin'];

        $data['activeDetails'] = $notification_Controller['agency_array'];

        $data['agecnyresultsnotification'] = $notification_Controller['agecnyresults_notification'];

        $data['agecnyresultsnotificationread'] = $notification_Controller['agecnyresults_notification_read'];

        $data['userresultsnotification'] = $notification_Controller['user_results_notification'];

        $data['userresultsnotificationread'] = $notification_Controller['user_results_notification_read'];

        if (Auth::check()) {
            $Loginid = Auth::user()->id;
            $data['CAgencyDetails'] = '';
            $RoleIdPremissions = controller::Role_Permissions();
            //print_r($RoleIdPremissions);
            $data['Premissions'] = $RoleIdPremissions;
            $adminportal = DB::table('adminportal')->where('id', '=', 1)->get();

            $data['adminportal'] = $adminportal[0];

            return view('profile.adminportal', $data);
        } else {
            return redirect('/');
        }
    }

    /**
     * @desc ajax call from apiprofiledata view
     *
     * @param no param
     *
     * @return Cancellation text
     */
    public function apiprofiledata()
    {
        $notification_Controller = controller::notification_Controller();

        //print_r($RoleIdPremissions);

        $data['pagename'] = 'adminApicontrol';

        $data['whologin'] = $notification_Controller['whologin'];

        $data['activeDetails'] = $notification_Controller['agency_array'];

        $data['agecnyresultsnotification'] = $notification_Controller['agecnyresults_notification'];

        $data['agecnyresultsnotificationread'] = $notification_Controller['agecnyresults_notification_read'];

        $data['userresultsnotification'] = $notification_Controller['user_results_notification'];

        $data['userresultsnotificationread'] = $notification_Controller['user_results_notification_read'];

        $travelanda = DB::select('select * from payment WHERE supplier="travelanda" AND booking_confirm=1');
        //Hotelname get from api using array
        $TravelladaArray = array();

        if (!empty($travelanda)) {
            foreach ($travelanda as $payment_booking) {
                $getBookingDetails = $this->getBookingDetails($payment_booking);
                $TravelladaArray[$payment_booking->hotelid] = $getBookingDetails->Body->Bookings->HotelBooking[0]->HotelName;
            }
        }

        $tbo = DB::select('select * from payment WHERE supplier="tbo" AND booking_confirm=1');

        //Hotelname get from api using array
        $TboArray = array();

        if (!empty($tbo)) {
            foreach ($tbo as $payment_booking) {
                $getBookingDetails = $this->tbobboking_details($payment_booking->BookingReference);
                $TboArray[$payment_booking->hotelid] = $getBookingDetails['sBody']['HotelBookingDetailResponse']['BookingDetail']['HotelName'];
            }
        }
        $data['travelanda'] = $travelanda;

        $data['tbo'] = $tbo;

        $data['TboArray'] = $TboArray;

        $data['TravelladaArray'] = $TravelladaArray;

        if (Auth::check()) {
            $Loginid = Auth::user()->id;
            $data['CAgencyDetails'] = '';
            $RoleIdPremissions = controller::Role_Permissions();
            //print_r($RoleIdPremissions);
            $data['Premissions'] = $RoleIdPremissions;
            $adminportal = DB::table('profileInfoApi')->where('id', '=', 1)->get();
            $adminportal1 = DB::table('profileInfoApi')->where('id', '=', 2)->get();

            $data['adminportal'] = $adminportal[0];
            $data['adminportal1'] = $adminportal1[0];

            return view('profile.adminprofiledata', $data);
        } else {
            return redirect('/');
        }
    }
	
	
    /**
     * @desc adminApicontrolupdate view
     *
     * @param no param
     *
     * @return Cancellation text
     */

    public function adminApicontrolupdate(Request $request)
    {
        $update_array = array();

        $user_type = 'Agency';

        if ($request->input('supplier') == 'travellanda') {
            $islive = 0;

            if ($request->input('isagency') == 'on') {
                $islive = 1;
            }

            $lastInsertedID = DB::table('adminportal')->where('id', 1)->update(['Travelanda_Test_Usename' => $request->input('testusername'), 'Travelanda_Test_Password' => $request->input('Testpassword'), 'Travelanda_Live_Username' => $request->input('liveusername'), 'Travelanda_Live_Password' => $request->input('livepassword'), 'Travelanda_Live' => $islive]);
        }

        if ($request->input('supplier') == 'tbo') {
            $islive = 0;

            if ($request->input('isagency') == 'on') {
                $islive = 1;
            }

            $lastInsertedID = DB::table('adminportal')->where('id', 1)->update(['Tbo_Test_Usename' => $request->input('testusername'), 'Tbo_Test_Password' => $request->input('Testpassword'), 'Tbo_Live_Username' => $request->input('liveusername'), 'Tbo_Live_Password' => $request->input('livepassword'), 'Tbo_Live' => $islive]);
        }

        /*	$data = array('name'=>'Admin','username'=>$request->input('email'),'usertype'=>$user_type);
    	$mail = view('mail.admin.updatemail',$data);

    	$to = 'maniprakashpalani@gmail.com';//'vasistcompany@gmail.com';
    	$subject = $user_type." Profile Updated" ;
    	$message = $mail;
    	$headers  = 'MIME-Version: 1.0' . "\r\n";
    	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    	$headers .= 'From: B2B project <travelinsertinfo@gmail.com>' . "\r\n";
    	mail($to,$subject,$message,$headers);*/

        return redirect()->route('adminApicontrol', ['datas' => 'update']);
    }
    //update
	
	/**
     * @desc apiprofiledataupdate view
     *
     * @param no param
     *
     * @return Cancellation text
     */

    public function apiprofiledataupdate(Request $request)
    {
        $update_array = array();

        $user_type = 'Agency';

        if ($request->input('supplier') == 'travellanda') {
            DB::table('profileInfoApi')->where('id', 1)->update(['creditLimit' => $request->input('creditlimit'), 'name' => $request->input('Testpassword'), 'email' => $request->input('email'), 'supplier' => 'travellanda']);
        }

        if ($request->input('supplier') == 'tbo') {
            DB::table('profileInfoApi')->where('id', 2)->update(['creditLimit' => $request->input('creditlimit'), 'name' => $request->input('Testpassword'), 'email' => $request->input('email'), 'supplier' => 'tbo']);
        }

        /*	$data = array('name'=>'Admin','username'=>$request->input('email'),'usertype'=>$user_type);
    	$mail = view('mail.admin.updatemail',$data);

    	$to = 'maniprakashpalani@gmail.com';//'vasistcompany@gmail.com';
    	$subject = $user_type." Profile Updated" ;
    	$message = $mail;
    	$headers  = 'MIME-Version: 1.0' . "\r\n";
    	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    	$headers .= 'From: B2B project <travelinsertinfo@gmail.com>' . "\r\n";
    	mail($to,$subject,$message,$headers);*/

        return redirect()->route('apiprofiledata', ['datas' => 'update']);
    }
	
	
     /**
     * @desc apiprofiledataajax view. 
     *
     * @param no param
     *
     * @return Cancellation text
     */

    public function apiprofiledataajax(Request $request)
    {

        //TRAVELNADA
        if ($_GET['supplier'] == 'travelanada') {
            if (!empty($_GET['days'])) {
                $days = $_GET['days'];
            } else {
                $days = 1;
            }

            //payment count
            //echo 'select * from payment WHERE `Bookdate` > DATE(NOW() - INTERVAL '.$days.' DAY) AND supplier="travelanda"';

            $payment = DB::select('select * from payment WHERE `Bookdate` > DATE(NOW() - INTERVAL '.$days.' DAY) AND supplier="travelanda"');

            $paymentCount = count($payment);
        }

        //TRAVELNADA
        if ($_GET['supplier'] == 'tbo') {
            if (isset($_GET['days'])) {
                $days = $_GET['days'];
            } else {
                $days = 1;
            }

            //payment count

            $payment = DB::select('select * from payment WHERE `Bookdate` > DATE(NOW() - INTERVAL '.$days.' DAY) AND supplier="tbo"');

            $paymentCount = count($payment);
        }

        echo $paymentCount;
    }
}
