<?php 
namespace App\Http\Controllers\Agency;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Crypt;

class AgencylistController extends Controller
{
    /**
     * __construct.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Ageny module Index. it is list for agency and sub agency.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $getname = Route::getCurrentRoute()->getActionName();

        $data['pagename'] = 'agencylist';

        if (Auth::user()->user_type == 'AgencyManger') {
            return redirect('/subagencylist');
        }
        //sub agency manager
        if (Auth::user()->user_type == 'SubAgencyManger') {
            return redirect('/home');
        }

        $products = DB::table('agency')->where('delete_status', '=', '1')->orderBy('agency.updated_at', 'DESC')->get();

        $data['products'] = $products;

        $RoleIdPremissions = controller::Role_Permissions();

        $notification_Controller = controller::notification_Controller();

        //print_r($RoleIdPremissions);

        $data['whologin'] = $notification_Controller['whologin'];

        $data['activeDetails'] = $notification_Controller['agency_array'];

        $data['agecnyresultsnotification'] = $notification_Controller['agecnyresults_notification'];

        $data['agecnyresultsnotificationread'] = $notification_Controller['agecnyresults_notification_read'];

        $data['userresultsnotification'] = $notification_Controller['user_results_notification'];

        $data['userresultsnotificationread'] = $notification_Controller['user_results_notification_read'];

        $data['Premissions'] = $RoleIdPremissions;

        if ($RoleIdPremissions['type'] == 'UserInfo') {
            if ($RoleIdPremissions['premission'][0]->agency_list == 1) {

                // $data['type'] = 'UserInfo';

                return view('agency.agencyList', $data);
            } else {
                return redirect('/home');
            }
        } else {
            return view('agency.agencyList', $data);
        }
    }

    /**
     * Ageny subagencylist Index. it is list for sub agency.
     *
     * @return \Illuminate\Http\Response
     */
    public function subagencylist()
    {
        if (Auth::check()) {
            $getname = Route::getCurrentRoute()->getActionName();

            $notification_Controller = controller::notification_Controller();

            //print_r($RoleIdPremissions);

            $data['whologin'] = $notification_Controller['whologin'];

            $data['activeDetails'] = $notification_Controller['agency_array'];

            $data['agecnyresultsnotification'] = $notification_Controller['agecnyresults_notification'];

            $data['agecnyresultsnotificationread'] = $notification_Controller['agecnyresults_notification_read'];

            $data['userresultsnotification'] = $notification_Controller['user_results_notification'];

            $data['userresultsnotificationread'] = $notification_Controller['user_results_notification_read'];

            $data['pagename'] = 'subagencylist';

            $RoleId = Auth::user()->RoleID;

            $Loginid = Auth::user()->id;

            if (Auth::user()->user_type == 'AgencyManger') {

                ///$RoleIdPremissions =DB::table('role_list')->where('id','=',''.$RoleId.'')->get();

                $CAgencydetails = DB::table('agency')->where('delete_status', '=', '1')->where('loginid', '=', ''.$Loginid.'')->get();

                $data['CAgencyDetails'] = $CAgencydetails[0];

                $CAgencydetails_id = $CAgencydetails[0]->id;
            }

            //exit;

            if (isset($_GET['id']) && !empty($_GET['id'])) {
                $CAgencydetails_id_check = base64_decode(Crypt::decrypt($_GET['id']));

                $CAgencydetails_id = 1;
                if ($CAgencydetails_id_check) {
                    $CAgencydetails_id = $CAgencydetails_id_check;
                }
            }

            $products = array();

            if (isset($CAgencydetails_id)) {
                $products = DB::table('agency')->where('parentagencyid', '=', ''.$CAgencydetails_id.'')->orderBy('agency.updated_at', 'DESC')->get();
            }

            $data['products'] = $products;

            return view('agency.agencyLists', $data);
        }
    }

    /**
     * Ageny agencyListLoadMore Index. it is list for load agency.
     *
     *@param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function agencyListLoadMore(Request $request)
    {
        $getname = Route::getCurrentRoute()->getActionName();

        $data['pagename'] = strstr($getname, '@');

        $offset = $request->input('offset');

        $parentagency = $request->input('parentagency');

        $subagency = $request->input('subagency');

        $products = DB::table('agency')->where('delete_status', '=', '1')->orderBy('agency.updated_at', 'DESC')->offset($offset)->limit(10);

        if ($parentagency == 1 && $subagency == 1) {
            $result = $products->get();
        }

        if ($parentagency == 1 && $subagency == 0) {
            $result = $products->where('parentagencyid', '<=', 0)->get();
        }

        if ($parentagency == 0 && $subagency == 1) {
            $result = $products->where('parentagencyid', '>', 0)->get();
        }

        if ($parentagency == 0 && $subagency == 0) {
            $result = $products->get();
        }

        echo json_encode($result);

        exit;
    }

    /**
     * Ageny agencyDelete Index. The agency delete using ajax call.
     *
     *@param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function agencyDelete(Request $request)
    {
        $activestatus = 0;

        $agencyID = DB::table('agency')->where('id', $request->input('id'))->update(['activestatus' => $activestatus, 'delete_status' => $activestatus]);

        $userID = DB::table('users')->where('id', $request->input('id'))->update(['activestatus' => $activestatus]);

        $subagencylist = DB::table('agency')->where('parentagencyid', '=', $request->input('id'))->get();

        if (isset($subagencylist[0]->id)) {
            foreach ($subagencylist as $subagencydetails) {
                $agencyID = DB::table('agency')->where('id', $subagencydetails->id)->update(['activestatus' => $activestatus, 'delete_status' => $activestatus]);

                $userID = DB::table('users')->where('id', $subagencydetails->loginid)->update(['activestatus' => $activestatus]);
            }
        }

        return redirect()->route('agencylist', ['datas1' => 'delete']);

        // return redirect('/agencylist');
    }

    /**
     * Ageny agency_bookdetails Index. The agency Booking list.
     *
     *@param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function agency_bookdetails()
    {
        $getname = Route::getCurrentRoute()->getActionName();

        $data['pagename'] = 'agencyBookingList';

        if (Auth::check()) {
            $agency_booking = '';
            $agency_booking_sub = '';
            $agency_booking_user = '';
            $agency_booking1 = '';

            $Loginid = Auth::user()->id;

            //echo Auth::user()->user_type;

            if (Auth::user()->user_type == 'AgencyManger') {
                $agency_booking = DB::table('payment')->where('login_id', '=', $Loginid)->where('booking_confirm', '!=', '2')->get();

                foreach ($agency_booking as $agency_booking_values) {
                    $agency_booking1[] = $agency_booking_values;
                }

                $agaency_id_check = DB::table('agency')->where('loginid', '=', $Loginid)->get();

                //include  sub agency
                $parentagencyid = DB::table('agency')->where('parentagencyid', '=', $agaency_id_check[0]->id)->get();
                //uesr
                $userinfo = DB::table('userinformation')->where('agentid', '=', $agaency_id_check[0]->id)->get();

                if (!empty($parentagencyid[0]->id)) {
                    $agency_booking_sub = DB::table('payment')->where('login_id', '=', $parentagencyid[0]->loginid)->where('booking_confirm', '!=', '2')->get();

                    foreach ($agency_booking_sub as $agency_booking_sub_values) {
                        $agency_booking1[] = $agency_booking_sub_values;
                    }
                }
                if (!empty($userinfo[0]->id)) {
                    $agency_booking_user = DB::table('payment')->where('login_id', '=', $userinfo[0]->id)->where('booking_confirm', '!=', '2')->get();

                    foreach ($agency_booking_user as $agency_booking_user_values) {
                        $agency_booking1[] = $agency_booking_user_values;
                    }
                }
            }

            if (Auth::user()->user_type == 'SubAgencyManger') {
                $agaency_id_check = DB::table('agency')->where('loginid', '=', $Loginid)->get();

                if (!empty($agaency_id_check[0]->id)) {
                    $agency_booking1 = DB::table('payment')->where('login_id', '=', $agaency_id_check[0]->loginid)->where('booking_confirm', '!=', '2')->where('user_type', '=', 'SubAgencyManger')->get();
                }
            }

            if (Auth::user()->user_type == 'UserInfo') {
                $user_id_check = DB::table('userinformation')->where('agentid', '=', $Loginid)->get();

                if (!empty($user_id_check[0]->id)) {
                    $agency_booking1 = DB::table('payment')->where('login_id', '=', $user_id_check[0]->loginid)->where('booking_confirm', '!=', '2')->where('user_type', '=', 'UserInfo')->get();
                }
            }
        }

        $notification_Controller = controller::notification_Controller();

        //print_r($RoleIdPremissions);

        $data['whologin'] = $notification_Controller['whologin'];

        $data['activeDetails'] = $notification_Controller['agency_array'];

        $data['agecnyresultsnotification'] = $notification_Controller['agecnyresults_notification'];

        $data['agecnyresultsnotificationread'] = $notification_Controller['agecnyresults_notification_read'];

        $data['userresultsnotification'] = $notification_Controller['user_results_notification'];

        $data['userresultsnotificationread'] = $notification_Controller['user_results_notification_read'];

        $data['agency_booking'] = $agency_booking1;
        $RoleIdPremissions = controller::Role_Permissions();
        $data['Premissions'] = $RoleIdPremissions;

        return view('agency.agencyBookingList', $data);
    }

    /**
     * Ageny agency_Unbookdetails Index. The agency un paid Booking list.
     *
     *@param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function agency_Unbookdetails()
    {
        $getname = Route::getCurrentRoute()->getActionName();

        $data['pagename'] = 'agencyUnBookingList';

        if (Auth::check()) {
            $agency_booking = '';
            $agency_booking_sub = '';
            $agency_booking_user = '';
            $agency_booking1 = '';

            $Loginid = Auth::user()->id;

            //echo Auth::user()->user_type;

            if (Auth::user()->user_type == 'AgencyManger') {
                $agency_booking = DB::table('payment')->where('login_id', '=', $Loginid)->where('booking_confirm', '!=', '2')->get();

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
                    $agency_booking_sub = DB::table('payment')->where('login_id', '=', $parentagencyid[0]->loginid)->where('booking_confirm', '!=', '2')->get();

                    foreach ($agency_booking_sub as $agency_booking_sub_values) {
                        $agency_booking1[] = $agency_booking_sub_values;
                    }
                }
                if (!empty($userinfo[0]->id)) {
                    $agency_booking_user = DB::table('payment')->where('login_id', '=', $userinfo[0]->loginid)->where('booking_confirm', '!=', '2')->get();

                    foreach ($agency_booking_user as $agency_booking_user_values) {
                        $agency_booking1[] = $agency_booking_user_values;
                    }
                }
            }

            if (Auth::user()->user_type == 'SubAgencyManger') {
                $agaency_id_check = DB::table('agency')->where('loginid', '=', $Loginid)->get();

                $parentagencyid = DB::table('agency')->where('parentagencyid', '=', $agaency_id_check[0]->id)->get();
                if (!empty($parentagencyid[0]->id)) {
                    $agency_booking = DB::table('payment')->where('login_id', '=', $parentagencyid[0]->loginid)->where('booking_confirm', '!=', '2')->where('user_type', '=', 'SubAgencyManger')->get();
                }
            }

            if (Auth::user()->user_type == 'UserInfo') {
                $user_id_check = DB::table('userinformation')->where('loginid', '=', $Loginid)->get();

                $agaency_id_check = DB::table('agency')->where('id', '=', $user_id_check[0]->agentid)->get();

                //parent agency
                $user_id_check[0]->agentid;

                /*if(!empty($agaency_id_check[0]->loginid)){


                $agency_booking =DB::table('payment')->where('login_id','=',$agaency_id_check[0]->loginid)->where('booking_confirm','!=','2')->get();

                foreach($agency_booking as $agency_booking_values){

                   $agency_booking1[] = $agency_booking_values;

                 }


            }

            //sub agency

            if(!empty($agaency_id_check[0]->id)){

                $parentagencyid =DB::table('agency')->where('parentagencyid','=',$agaency_id_check[0]->id)->get();

                 if(!empty($parentagencyid[0]->id)){

                   $agency_booking_sub =DB::table('payment')->where('login_id','=',$parentagencyid[0]->loginid)->where('booking_confirm','!=','2')->get();

                   foreach($agency_booking_sub as $agency_booking_sub_values){

                        $agency_booking1[] = $agency_booking_sub_values;
                   }

               }
            }
            */

                if (!empty($user_id_check[0]->id)) {
                    $agency_booking = DB::table('payment')->where('login_id', '=', $Loginid)->where('booking_confirm', '!=', '2')->where('user_type', '=', 'UserInfo')->get();

                    foreach ($agency_booking as $agency_booking_values) {
                        $agency_booking1[] = $agency_booking_values;
                    }
                }
            }
        }
        $notification_Controller = controller::notification_Controller();

        //print_r($RoleIdPremissions);

        $data['whologin'] = $notification_Controller['whologin'];

        $data['activeDetails'] = $notification_Controller['agency_array'];

        $data['agecnyresultsnotification'] = $notification_Controller['agecnyresults_notification'];

        $data['agecnyresultsnotificationread'] = $notification_Controller['agecnyresults_notification_read'];

        $data['userresultsnotification'] = $notification_Controller['user_results_notification'];

        $data['userresultsnotificationread'] = $notification_Controller['user_results_notification_read'];

        $data['agency_booking'] = $agency_booking1;

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

        $RoleIdPremissions = controller::Role_Permissions();
        $data['Premissions'] = $RoleIdPremissions;
        $data['agencyArray'] = $agencyArray;
        $data['userinformationArray'] = $userinformationArray;

        return view('agency.agencyUnBookingList', $data);
    }

    /**
     * Ageny agency_Cancelleddetails Index. The agency cancel Booking list.
     *
     *@param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function agency_Cancelleddetails()
    {
        $getname = Route::getCurrentRoute()->getActionName();

        $data['pagename'] = 'agencyCancelledBookingList';

        if (Auth::check()) {
            $agency_booking = '';
            $agency_booking_sub = '';
            $agency_booking_user = '';
            $agency_booking1 = '';

            $Loginid = Auth::user()->id;

            //echo Auth::user()->user_type;

            if (Auth::user()->user_type == 'AgencyManger') {
                $agency_booking = DB::table('payment')->where('login_id', '=', $Loginid)->where('booking_confirm', '=', '2')->get();

                foreach ($agency_booking as $agency_booking_values) {
                    $agency_booking1[] = $agency_booking_values;
                }

                $agaency_id_check = DB::table('agency')->where('loginid', '=', $Loginid)->get();

                //include  sub agency
                $parentagencyid = DB::table('agency')->where('parentagencyid', '=', $agaency_id_check[0]->id)->get();
                //uesr
                $userinfo = DB::table('userinformation')->where('agentid', '=', $agaency_id_check[0]->id)->get();

                if (!empty($parentagencyid[0]->id)) {
                    $agency_booking_sub = DB::table('payment')->where('login_id', '=', $parentagencyid[0]->loginid)->where('booking_confirm', '=', '2')->get();

                    foreach ($agency_booking_sub as $agency_booking_sub_values) {
                        $agency_booking1[] = $agency_booking_sub_values;
                    }
                }
                if (!empty($userinfo[0]->id)) {
                    $agency_booking_user = DB::table('payment')->where('login_id', '=', $userinfo[0]->id)->where('booking_confirm', '=', '2')->get();

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

                //$agency_booking =DB::table('payment')->get();

                $agaency_id_check = DB::table('agency')->where('id', '=', $user_id_check[0]->agentid)->get();

                //parent agency
                $user_id_check[0]->agentid;

                /*
            if(!empty($agaency_id_check[0]->loginid)){


                $agency_booking =DB::table('payment')->where('login_id','=',$agaency_id_check[0]->loginid)->where('booking_confirm','=','2')->get();

                foreach($agency_booking as $agency_booking_values){

                   $agency_booking1[] = $agency_booking_values;

                 }


            }

            //sub agency

            if(!empty($agaency_id_check[0]->id)){

                $parentagencyid =DB::table('agency')->where('parentagencyid','=',$agaency_id_check[0]->id)->get();

                 if(!empty($parentagencyid[0]->id)){

                   $agency_booking_sub =DB::table('payment')->where('login_id','=',$parentagencyid[0]->loginid)->where('booking_confirm','=','2')->get();

                   foreach($agency_booking_sub as $agency_booking_sub_values){

                        $agency_booking1[] = $agency_booking_sub_values;
                   }

               }
            }
            */

                if (!empty($user_id_check[0]->id)) {
                    $agency_booking_user = DB::table('payment')->where('login_id', '=', $user_id_check[0]->loginid)->where('booking_confirm', '=', '2')->where('user_type', '=', 'UserInfo')->get();

                    foreach ($agency_booking_user as $agency_booking_user_values) {
                        $agency_booking1[] = $agency_booking_user_values;
                    }
                }
            }
        }
        $notification_Controller = controller::notification_Controller();

        //print_r($RoleIdPremissions);

        $data['whologin'] = $notification_Controller['whologin'];

        $data['activeDetails'] = $notification_Controller['agency_array'];

        $data['agecnyresultsnotification'] = $notification_Controller['agecnyresults_notification'];

        $data['agecnyresultsnotificationread'] = $notification_Controller['agecnyresults_notification_read'];

        $data['userresultsnotification'] = $notification_Controller['user_results_notification'];

        $data['userresultsnotificationread'] = $notification_Controller['user_results_notification_read'];

        $data['agency_booking'] = $agency_booking1;
        $RoleIdPremissions = controller::Role_Permissions();
        $data['Premissions'] = $RoleIdPremissions;

        return view('agency.agencyCancelledBookingList', $data);
    }
}
