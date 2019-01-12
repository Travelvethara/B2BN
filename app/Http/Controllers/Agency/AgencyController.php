<?php

namespace App\Http\Controllers\Agency;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Mail;
use PDF;

class AgencyController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */

    /**
     * Ageny module Index. it is create by agency and sub agency.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() //Agency Module
    {
        //$pdf = PDF::loadView('myPDF', $data);

        $agencyemailids = '';

        if (Auth::user()->user_type == 'AgencyManger') {

            //update

            $mailEmail = DB::table('agency')->where('loginid', '=', Auth::user()->id)->get();
            $agencyemailids = $mailEmail[0]->email;
        }

        if (Auth::user()->user_type == 'SubAgencyManger') {
            $checkcreditlimit_parent = DB::table('agency')->where('loginid', '=', Auth::user()->id)->get();
            $mailEmail = DB::table('agency')->where('id', '=', $checkcreditlimit_parent[0]->parentagencyid)->get();
            $agencyemailids = $mailEmail[0]->email;
        }

        if (Auth::user()->user_type == 'UserInfo') {
            $userinformation = DB::table('userinformation')->where('loginid', '=', Auth::user()->id)->get();
            if ($userinformation[0]->agentid != 0) {
                //agency user
                $mailEmail = DB::table('agency')->where('id', '=', $userinformation[0]->agentid)->get();
                $agencyemailids = $mailEmail[0]->email;
            }
        }
        echo $agencyemailids;
        $to = $agencyemailids;
        $subject = 'New B2B Booking Confirmation';
        $message = 'gjkhfhjgfhfghkjgjhkjfghj';
        $headers = "From: B2B project<admin@livebeds.com>\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        mail($to, $subject, $message, $headers);

        $getname = Route::getCurrentRoute()->getActionName();

        $data['pagename'] = 'agency';

        if (Auth::check()) {
            $notification_Controller = controller::notification_Controller();

            //print_r($RoleIdPremissions);

            $data['whologin'] = $notification_Controller['whologin'];

            $data['activeDetails'] = $notification_Controller['agency_array'];

            $data['agecnyresultsnotification'] = $notification_Controller['agecnyresults_notification'];

            $data['agecnyresultsnotificationread'] = $notification_Controller['agecnyresults_notification_read'];

            $data['userresultsnotification'] = $notification_Controller['user_results_notification'];

            $data['userresultsnotificationread'] = $notification_Controller['user_results_notification_read'];

            $RoleId = Auth::user()->RoleID;  // Get current User RoleID
            $Currentlogin_id = Auth::user()->id;  //current login id
            //echo Crypt::encrypt(1);
            //check data
            $data['agency'] = '';
            $data['CheckAgency'] = '';
            $data['CAgencyDetails'] = '';
            $data['type'] = '';

            $PakCities = DB::table('PakCities')->get();
            $data['PakCities'] = $PakCities;
            //detination

            if (Auth::user()->user_type == 'SubAgencyManger') {
                return redirect('/home');
            }

            if (Auth::user()->user_type == 'AgencyManger') {
                if (isset($_GET['id']) && !empty($_GET['id'])) {
                    $id = $_GET['id'];
                    try {
                        $decrypted_id = Crypt::decrypt($id);
                        $decrypted_id = base64_decode($decrypted_id);
                    } catch (DecryptException $e) {
                        return redirect('/home');
                    }
                    //$decrypted_id = base64_decode($id);
                    $products = DB::table('agency')->where('id', '=', ''.$decrypted_id.'')->get();
                    if (!empty($products)) {
                        if ($products[0]->parentagencyid == 0) {
                            return redirect('/home');
                        } else {
                            $current_products = DB::table('agency')->where('loginid', '=', ''.$Currentlogin_id.'')->get();

                            //$current_products11=DB::table('agency')->where('parentagencyid','=',''.$current_products[0]->id.'')->get();

                            if (!empty($current_products)) {
                                if ($current_products[0]->id != $products[0]->parentagencyid) {
                                    return redirect('/home');
                                }
                            }
                        }
                    }
                }
            }

            $AgencyDetails = DB::table('agency')->where('parentagencyid', '=', '0')->get();

            $CountryName = controller::CountryName();

            $data['CountryName'] = $CountryName;
            $data['AgencyDetails'] = $AgencyDetails;
            //check user info
            $RoleIdPremissions = controller::Role_Permissions();
            $data['Premissions'] = $RoleIdPremissions;
            //user premissions
            if ($RoleIdPremissions['type'] == 'UserInfo') {
                $data['type'] = 'UserInfo';
                if ($RoleIdPremissions['premission'][0]->agency_open == false) {
                    return redirect('/home');
                }
            }
            $RoleId = Auth::user()->RoleID;
            $Loginid = Auth::user()->id;
            //agency premissions

            if (Auth::user()->user_type == 'AgencyManger') {
                $CAgencydetails = DB::table('agency')->where('loginid', '=', ''.$Loginid.'')->get();
                if (isset($CAgencydetails[0])) {
                    $data['CAgencyDetails'] = $CAgencydetails[0];
                }
                //$data['CheckAgency'] = $RoleIdPremissions[0];
            }

            if (isset($_GET['id']) && !empty($_GET['id'])) {
                $id = $_GET['id'];
                try {
                    $decrypted_id = Crypt::decrypt($id);
                    $decrypted_id = base64_decode($decrypted_id);
                } catch (DecryptException $e) {
                    return redirect('/home');
                }

                //read method for notification

                if (isset($_GET['read']) && !empty($_GET['read'])) {
                    $notification_read_update = DB::table('agency')->where('id', $decrypted_id)->update(['notification_staus_new' => '1', 'notification_staus_read' => '1']);
                }

                //$decrypted_id = base64_decode($id);
                $products = DB::table('agency')->where('id', '=', ''.$decrypted_id.'')->get();
                //check agency
                $data['agency'] = $products[0];
            }

            return view('agency.agency', $data);
        } else {
            return redirect('/');
        }
    }

    /**
     * Ageny agencyInsertAjaxValidate module. It is validate the name , email and password for agency form.
     *
     *@param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function agencyInsertAjaxValidate(Request $request)
    {

        // Validation
        $validator = $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:1|confirmed',

        ]);
        // Validation

        echo 'ok';
    }

    /**
     * Ageny agencyInsertAjax module. It is insert the agent manager info from agency form.
     *
     *@param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function agencyInsertAjax(Request $request)
    {
        $decrypted_parentid = controller::decryptid($request->input('parentid'));
        $insertdata['name'] = $request->input('name');
        $insertdata['email'] = $request->input('email');
        $insertdata['password'] = Hash::make($request->input('password'));
        $insertdata['crybtPassword'] = Crypt::encrypt(base64_encode($request->input('password')));
        $insertdata['RoleID'] = '2';
        $Manger = 'AgencyManger';
        if ($request->input('parentid')) {
            $Manger = 'SubAgencyManger';
        }
        if ($request->input('isagency')) {
            $Manger = 'SubAgencyManger';
        }
        $insertdata['user_type'] = $Manger;
        $insertdata['activestatus'] = '0';
        $lastInsertedID = DB::table('users')->insertGetId($insertdata);
        //user agency add
        $agencyInsert['name'] = $request->input('name');
        $agencyInsert['loginid'] = $lastInsertedID;
        $UserId = 'AGN100'.$lastInsertedID;
        if ($request->input('parentid')) {
            $UserId = 'AGNSUB100'.$lastInsertedID;
        }
        if ($request->input('isagency')) {
            $UserId = 'AGNSUB100'.$lastInsertedID;
        }
        $agencyInsert['userid'] = $UserId;
        $agencyInsert['email'] = $request->input('email');
        $mphone = '';
        $awhatsapp = '';
        $amobile = '';
        $skype = '';
        if ($request->input('mphone')) {
            $mphone = $request->input('mphone');
        }

        if ($request->input('awhatsapp')) {
            $awhatsapp = $request->input('awhatsapp');
        }

        if ($request->input('amobile')) {
            $amobile = $request->input('amobile');
        }

        if ($request->input('skype')) {
            $skype = $request->input('skype');
        }

        $agencyInsert['phone'] = $mphone;
        $agencyInsert['mobile'] = $amobile;
        $agencyInsert['whatapp'] = $awhatsapp;
        $agencyInsert['mskype'] = $skype;
        $parentid = 0;
        if ($request->input('parentid')) {
            $parentid = $decrypted_parentid;
        }
        if ($request->input('isagency')) {
            $parentid = $request->input('agencylevel');
        }
        $agencyInsert['parentagencyid'] = $parentid;
        $agencyInsert['address1'] = '';
        $agencyInsert['address2'] = '';
        $agencyInsert['country'] = '';
        $agencyInsert['amobile'] = '';
        $agencyInsert['awhatsapp'] = '';
        $agencyInsert['city'] = '';
        $agencyInsert['pcode'] = '';
        $agencyInsert['skype'] = '';
        $agencyInsert['website'] = '';
        $agencyInsert['rnumber'] = '';
        $agencyInsert['aname'] = '';
        $agencyInsert['aemail'] = '';
        $agencyInsert['amobile'] = '';
        $agencyInsert['aphone'] = '';
        $agencyInsert['awhatsapp'] = '';
        $agencyInsert['created_at'] = date('Y-m-d H:i:s');
        $agencyInsert['updated_at'] = date('Y-m-d H:i:s');
        if (Auth::user()->user_type == 'AgencyManger') {
            $agencyInsert['notification_staus'] = 1;
        }

        $agencyInsertID = DB::table('agency')->insertGetId($agencyInsert);

        $decrypted_id = Crypt::encrypt(base64_encode($agencyInsertID));
        $agen = Crypt::encrypt(base64_encode('agen'));

        $data = array('name' => $request->input('name'), 'email' => $request->input('email'), 'id' => $decrypted_id, 'us' => $agen);
        //mail

        //user
        //mail start

        //$data = array('name'=>$agency_products[0]->name,'email' => $agency_products[0]->email);

        // $data = array('name'=>'Admin','username'=>$agency_products[0]->email);

        //user

        $mail = view('mail.createagencymail', $data);

        $to = $data['email'];
        $subject = 'Agency Register';
        $message = $mail;
        $headers = "From: B2B project<admin@livebeds.com>\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        mail($to, $subject, $message, $headers);

        //mail end
        //admin
        //mail start

        //adminemail

        //mail end

        $encrypted_id = Crypt::encrypt(base64_encode($agencyInsertID));

        echo $encrypted_id;
    }

    /**
     * Ageny agencystore module. It is insert the agent manager info from agency form.
     *
     *@param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function agencystore(Request $request) //Create New Agency Function
    {

        // Validation
        $validator = $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',

        ]);
        // Validation

        //Check is sub agency or parent Agency
        if ($request->input('isagency')) {
            $validator1 = $this->validate($request, [
                'agencylevel' => 'required',
            ]);
        }
        //Decrypt parent id value from form values
        $decrypted_parentid = controller::decryptid($request->input('parentid'));
        $insertdata['name'] = $request->input('name');
        $insertdata['email'] = $request->input('email');
        $insertdata['password'] = Hash::make($request->input('password'));
        $insertdata['crybtPassword'] = Crypt::encrypt(base64_encode($request->input('password')));
        $insertdata['RoleID'] = '2';
        $Manger = 'AgencyManger';
        if ($request->input('parentid')) {
            $Manger = 'SubAgencyManger';
        }
        if ($request->input('isagency')) {
            $Manger = 'SubAgencyManger';
        }
        $insertdata['user_type'] = $Manger;
        $insertdata['activestatus'] = '0';
        $lastInsertedID = DB::table('users')->insertGetId($insertdata);
        //user agency add
        $agencyInsert['name'] = $request->input('name');
        $agencyInsert['loginid'] = $lastInsertedID;
        $UserId = 'AGN100'.$lastInsertedID;
        if ($request->input('parentid')) {
            $UserId = 'AGNSUB100'.$lastInsertedID;
        }
        if ($request->input('isagency')) {
            $UserId = 'AGNSUB100'.$lastInsertedID;
        }
        $agencyInsert['userid'] = $UserId;
        $agencyInsert['email'] = $request->input('email');
        $agencyInsert['phone'] = $request->input('mphone');
        $agencyInsert['mobile'] = '567567';
        $agencyInsert['whatapp'] = '675675';
        $parentid = 0;
        if ($request->input('parentid')) {
            $parentid = $decrypted_parentid;
        }
        if ($request->input('isagency')) {
            $parentid = $request->input('agencylevel');
        }
        $agencyInsert['parentagencyid'] = $parentid;
        $agencyInsert['address1'] = '';
        $agencyInsert['address2'] = '';
        $agencyInsert['country'] = '';
        $agencyInsert['city'] = '';
        $agencyInsert['pcode'] = '';
        $agencyInsert['skype'] = '';
        $agencyInsert['website'] = '';
        $agencyInsert['rnumber'] = '';
        $agencyInsert['aname'] = '';
        $agencyInsert['aemail'] = '';
        $agencyInsert['amobile'] = '';
        $agencyInsert['aphone'] = '';
        $agencyInsert['awhatsapp'] = '';
        $agencyInsert['created_at'] = date('Y-m-d H:i:s');
        $agencyInsert['updated_at'] = date('Y-m-d H:i:s');
        if (Auth::user()->user_type == 'AgencyManger') {
            $agencyInsert['notification_staus'] = 1;
        }

        $agencyInsertID = DB::table('agency')->insertGetId($agencyInsert);

        $decrypted_id = Crypt::encrypt(base64_encode($agencyInsertID));
        $agen = Crypt::encrypt(base64_encode('agen'));

        $data = array('name' => $request->input('name'), 'email' => $request->input('email'), 'id' => $decrypted_id, 'us' => $agen);

        $mail = view('mail.createagencymail', $data);

        $to = $data['email'];
        $subject = 'Agency Register';
        $message = $mail;
        $headers = "From: B2B project<admin@livebeds.com>\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        mail($to, $subject, $message, $headers);
        $encrypted_id = Crypt::encrypt(base64_encode($agencyInsertID));

        return redirect()->route('agency', ['id' => $encrypted_id, 'tab' => '2', 'datas1' => 'insert']);
    }

    /**
     * Ageny agencyupdate module. Update Agency infromations - In this function we can update the agency, sub agency informations.
     *
     *@param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function agencyupdate(Request $request)
    {
        $id = $request->input('agencyid');
        $loginid = $request->input('loginid');
        $userrolecheck = $request->input('userrolecheck');
        //check encrption
        $decrypted_id = controller::decryptid($id);
        $decrypted_loginid = controller::decryptid($loginid);
        $decrypted_userrolecheck = controller::decryptid($userrolecheck);
        $update_array = array();
        if ($decrypted_id) {
            $users = DB::table('users')->where('id', $decrypted_loginid)->update(['email' => $request->input('email')]);
            if ($request->input('ispassword')) {
                $password = Hash::make($request->input('password'));
                $crybtPassword = Crypt::encrypt(base64_encode($request->input('password')));
                $users = DB::table('users')->where('id', $decrypted_loginid)->update(['password' => $password, 'crybtPassword' => $crybtPassword, 'email' => $request->input('email')]);
                $update_array['Password']['from'] = 'changed';
                $update_array['Password']['to'] = 'changed';
            }

            //update check

            $select_table = DB::table('agency')->where('id', '=', ''.$decrypted_id.'')->get();

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

                if ($select_table[0]->mobile != $request->input('amobile')) {
                    $update_array['Mobile']['from'] = $select_table[0]->mobile;
                    $update_array['Mobile']['to'] = $request->input('amobile');
                }

                if ($select_table[0]->whatapp != $request->input('awhatsapp')) {
                    $update_array['Whatsapp']['from'] = $select_table[0]->whatapp;
                    $update_array['Whatsapp']['to'] = $request->input('awhatsapp');
                }

                if ($select_table[0]->mskype != $request->input('skype')) {
                    $update_array['skype']['from'] = $select_table[0]->mskype;
                    $update_array['skype']['to'] = $request->input('skype');
                }

                $mphone = '';
                $skype = '';

                if ($request->input('mphone')) {
                    $mphone = $request->input('mphone');
                }

                if ($request->input('skype')) {
                    $skype = $request->input('skype');
                }

                $update_array_data = array();

                if (isset($update_array)) {
                    $update_array_data['UserRole'] = 'Agency';
                    $update_array_data['Rid'] = $decrypted_id;
                    $update_array_new = serialize($update_array);
                    $update_array_data['Updatedetail'] = $update_array_new;
                    $UpdateDetail = DB::table('UpdateDetail')->insertGetId($update_array_data);
                }
            }

            $lastInsertedID = DB::table('agency')->where('id', $decrypted_id)->update(['name' => $request->input('name'), 'email' => $request->input('email'), 'phone' => $mphone, 'mobile' => $request->input('amobile'), 'whatapp' => $request->input('awhatsapp'), 'mskype' => $skype, 'notification_staus_new' => '0', 'notification_staus_read' => '0']);

            if ($decrypted_userrolecheck) {
                if (Auth::user()->user_type == 'AgencyManger') {
                    $UserId = 'AGNSUB100'.$decrypted_id;
                    $Manger = 'SubAgencyManger';

                    //get parent id
                    $agencyid = DB::table('agency')->where('loginid', '=', ''.Auth::user()->id.'')->get();
                    $parentid = $agencyid[0]->id;
                } else {
                    $Manger = 'AgencyManger';
                    if ($request->input('isagency')) {
                        $Manger = 'SubAgencyManger';
                    }

                    $UserId = 'AGN100'.$decrypted_id;
                    if ($request->input('isagency')) {
                        $UserId = 'AGNSUB100'.$decrypted_id;
                    }

                    $parentid = 0;
                    if ($request->input('isagency')) {
                        $parentid = $request->input('agencylevel');
                    }
                    $data = array('name' => $request->input('name'), 'username' => 'mani', 'email' => $request->input('email'));

                    $mail = view('mail.createsubagencymail', $data);

                    $to = $data['email'];
                    $subject = 'Sub Agency Agency Created';
                    $message = $mail;
                    $headers = "From: B2B project<admin@livebeds.com>\r\n";
                    $headers .= "MIME-Version: 1.0\r\n";
                    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                    mail($to,$subject,$message,$headers);
                    //admin mail

                    $mail = view('mail.admin.createsubagencymail', $data);

                    $adminemailid = '';

                    $adminemail = DB::select('select * from adminemail where id=1');

                    if (isset($adminemail[0]->EmailName) && !empty($adminemail[0]->EmailName)) {
                        $adminemailid = $adminemail[0]->EmailName;
                    } else {
                        $adminemailid = 'vasistcompany@gmail.com';
                    }

                    $to = $adminemailid;
                    $subject = 'Sub Agency Agency Created';
                    $message = $mail;
                    $headers = "From: B2B project<admin@livebeds.com>\r\n";
                    $headers .= "MIME-Version: 1.0\r\n";
                    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                    mail($to,$subject,$message,$headers);
                }
                $lastInsertedID = DB::table('agency')->where('id', $decrypted_id)->update(['userid' => $UserId, 'parentagencyid' => $parentid]);
                $users = DB::table('users')->where('id', $decrypted_loginid)->update(['user_type' => $Manger]);
            }
        }

        return redirect()->route('agency', ['id' => $id, 'tab' => '2', 'datas1' => 'update']);
    }

    /**
     * Ageny viewagency module. View agency list. in this function we can get the list of agencies informations and create agency credit limit.
     *
     *@param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function viewagency(Request $request)
    {  // View agency list. in this function we can get the list of agencies informations

        $getname = Route::getCurrentRoute()->getActionName();

        $data['pagename'] = 'viewagency';

        if (Auth::user()->user_type == 'AgencyManger') {
            if (isset($_GET['id']) && !empty($_GET['id'])) {
                $id = $_GET['id'];

                try {
                    $decrypted_id = Crypt::decrypt($id);
                    $decrypted_id = base64_decode($decrypted_id);
                } catch (DecryptException $e) {
                    return redirect('/home');
                }
                $agencyinfo = DB::table('agency')->where('id', '=', ''.$decrypted_id.'')->get();

                if (isset($agencyinfo[0])) {
                    if ($agencyinfo[0]->parentagencyid != 0) {
                        $magency = DB::table('agency')->where('id', '=', ''.$agencyinfo[0]->parentagencyid.'')->get();

                        if (isset($magency[0])) {
                            if ($magency[0]->loginid != Auth::user()->id) {
                                return redirect('/home');
                            }
                        }
                    } else {
                        return redirect('/home');
                    }
                } else {
                    return redirect('/home');
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

        $id = controller::decryptid($request->input('id'));
        $role_type = Auth::user()->user_type;
        $products = DB::table('agency')->where('id', '=', ''.$id.'')->get();

        //data parent details

        $data['agency_parent_details'] = array();
        if ($products[0]->parentagencyid != 0) {
            $parentagencyid = DB::table('agency')->where('id', '=', ''.$products[0]->parentagencyid.'')->get();

            if (!empty($parentagencyid)) {
                $data['agency_parent_details'] = $parentagencyid[0];
            }
        }

        $count = $products->count();

        $RoleIdPremissions = controller::Role_Permissions();
        $data['Premissions'] = $RoleIdPremissions;
        //print_r($RoleIdPremissions['type']);
        $data['Premissionsview'] = '';
        if ($RoleIdPremissions['type'] == 'UserInfo') {
            $data['Premissionsview'] = $RoleIdPremissions['premission'][0];
        }

        $data['agency'] = $products[0];
        $data['role_type'] = $role_type;

        return view('agency.viewagency', $data);
    }

    /**
     * Ageny updateagency module. Update agency information from user.
     *
     *@param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function updateagency(Request $request)
    {      //Update agency information from user
        //UserInfo

        $getname = Route::getCurrentRoute()->getActionName();

        $data['pagename'] = 'updateagency';

        $agency_update_id = controller::decryptid($request->input('id'));
        $currentprice = DB::table('agency')->where('id', '=', ''.$agency_update_id.'')->get();
        if (Auth::user()->user_type == 'UserInfo') {
            $activestatus = 0;
            if ($request->input('activestatus')) {
                if ($request->input('activestatus') == 'on') {
                    $activestatus = 1;
                }
                $subagencylist = DB::table('agency')->where('parentagencyid', '=', $agency_update_id)->get();

                if (isset($subagencylist[0]->id)) {
                    foreach ($subagencylist as $subagencydetails) {
                        $lastInsertedID = DB::table('agency')->where('id', $subagencydetails->id)->update(['activestatus' => $activestatus]);
                        $lastInsertedID = DB::table('users')->where('id', $subagencydetails->loginid)->update(['activestatus' => $activestatus]);
                    }
                }
            }

            $lastInsertedID = DB::table('users')->where('id', $currentprice[0]->loginid)->update(['activestatus' => $activestatus]);
            $userval = 1;
            if ($request->input('credit_type') == 1) {
                $update['newcreditlimit'] = $request->input('newcreditlimit');
                $update['requested_by'] = Auth::user()->id;
                $update['id'] = $agency_update_id;
                //insert credit key
                $insert['AgencyID'] = $agency_update_id;
                $insert['assigned_amount'] = $request->input('newcreditlimit');
                $insert['transaction_type'] = 'type';
                $insert['assigned_by'] = Auth::user()->id;
                $insert['assigned_user_type'] = 'UserInfo';
                $insert['approved_by'] = '';
                $insert['approved_user_type'] = '';
                $insert['assigned_date'] = date('Y-m-d');
                $insert['approved_date'] = date('Y-m-d');

                $lastInsertedID = DB::table('agency_credit_limit_transactions')->insertGetId($insert);

                $lastInsertedIDs = DB::table('agency')->where('id', $update['id'])->update(['requested_amount' => $update['newcreditlimit'], 'requested_by' => $update['requested_by'], 'requestid' => $lastInsertedID]);

                return redirect()->route('agency.viewagency', ['id' => $request->input('id')]);
            }
            //2 nad 3
            if ($request->input('credit_type') == 2 || $request->input('credit_type') == 3) {
                $update['newcreditlimit'] = $request->input('newcreditlimit');
                $update['requestedstatus'] = $request->input('requestedstatus');
                $update['id'] = $agency_update_id;

                $update['newmarkup'] = $request->input('newmarkup');

                $currentprice = DB::table('agency')->where('id', '=', ''.$update['id'].'')->get();

                $newcreditlimit = $currentprice[0]->current_credit_limit + $update['newcreditlimit'];

                $creditlimitUpdate = $currentprice[0]->creditLimit + $update['newcreditlimit'];

                if ($request->input('activestatus') && $request->input('activestatus') == 'on') {
                    $activestatus = 1;
                } else {
                    $activestatus = 0;
                }

                $lastInsertedID = DB::table('agency')->where('id', $update['id'])->update(['requested_amount' => '0', 'requested_by' => '0', 'current_credit_limit' => $newcreditlimit, 'creditLimit' => $creditlimitUpdate, 'activestatus' => $activestatus]);

                if ($update['newmarkup'] > 0) {
                    $lastInsertedID = DB::table('agency')->where('id', $update['id'])->update(['current_markup' => $update['newmarkup']]);
                }

                $lastInsertedID = DB::table('users')->where('id', $currentprice[0]->loginid)->update(['activestatus' => $activestatus]);

                //insert credit key
                if ($request->input('requestedstatus')) {
                    $requestedid = controller::decryptid($request->input('requestedid'));
                    if ($request->input('requestedstatus') == 'declined') {
                        $updateva = DB::table('agency_credit_limit_transactions')->where('id', $requestedid)->update(['declinestaus' => '1']);
                    } else {
                        $updateva = DB::table('agency_credit_limit_transactions')->where('id', $requestedid)->update(['assigned_amount' => $request->input('newcreditlimit'), 'approved_by' => Auth::user()->id, 'approved_user_type' => 'UserInfo', 'approved_date' => date('Y-m-d')]);
                    }
                } else {
                    $insert['AgencyID'] = $agency_update_id;
                    $insert['assigned_amount'] = $request->input('newcreditlimit');
                    $insert['transaction_type'] = 'type';
                    $insert['assigned_by'] = Auth::user()->id;
                    $insert['assigned_user_type'] = 'UserInfo';
                    $insert['approved_by'] = Auth::user()->id;
                    $insert['approved_user_type'] = 'UserInfo';
                    $insert['assigned_date'] = date('Y-m-d');
                    $insert['approved_date'] = date('Y-m-d');
                    $lastInsertedID = DB::table('agency_credit_limit_transactions')->insertGetId($insert);
                }

                if ($request->input('agencyparentid')) {
                    $agencycredit_update = DB::table('agency')->where('id', '=', ''.$request->input('agencyparentid').'')->get();

                    $updatecreditlimit = $agencycredit_update[0]->current_credit_limit - $update['newcreditlimit'];

                    $updateagaency = DB::table('agency')->where('id', $request->input('agencyparentid'))->update(['current_credit_limit' => $updatecreditlimit]);
                }

                return redirect()->route('agency.viewagency', ['id' => $request->input('id'), 'datas' => 1]);
            }
        }

        //AgencyManger

        if (Auth::user()->user_type == 'AgencyManger') {
            $update['newcreditlimit'] = $request->input('newcreditlimit');
            $update['requested_by'] = Auth::user()->id;
            $update['id'] = $agency_update_id;

            //insert credit key
            $insert['AgencyID'] = $agency_update_id;
            $insert['assigned_amount'] = $request->input('newcreditlimit');
            $insert['transaction_type'] = 'type';
            $insert['assigned_by'] = Auth::user()->id;
            $insert['assigned_user_type'] = 'AgencyManger';
            $insert['approved_by'] = '';
            $insert['approved_user_type'] = '';
            $insert['assigned_date'] = date('Y-m-d');
            $insert['approved_date'] = date('Y-m-d');
            $lastInsertedID = DB::table('agency_credit_limit_transactions')->insertGetId($insert);

            $lastInsertedIDs = DB::table('agency')->where('id', $update['id'])->update(['requested_amount' => $update['newcreditlimit'], 'requested_by' => $update['requested_by'], 'requestid' => $lastInsertedID]);

            return redirect()->route('agency.viewagency', ['id' => $request->input('id')]);
        }

        if (Auth::user()->user_type == 'SuperAdmin') {
            $update['newcreditlimit'] = $request->input('newcreditlimit');
            $update['requestedstatus'] = $request->input('requestedstatus');
            $update['id'] = $agency_update_id;
            //$subagencylist=DB::table('agency')->where('parentagencyid','=',$agency_update_id)->get();

            $update['newmarkup'] = $request->input('newmarkup');

            $currentprice = DB::table('agency')->where('id', '=', ''.$update['id'].'')->get();

            $newcreditlimit = $currentprice[0]->current_credit_limit + $update['newcreditlimit'];

            $creditlimitUpdate = $currentprice[0]->creditLimit + $update['newcreditlimit'];

            if ($request->input('activestatus') && $request->input('activestatus') == 'on') {
                //agency aprroval for Active
                $data = array('name' => $currentprice[0]->name, 'email' => $currentprice[0]->email);

                $activestatus = 1;
            } else {
                $activestatus = 0;
            }

            //check mail condition approval mail

            if ($request->input('newcreditlimit')) {
                $data = array('name' => $currentprice[0]->name, 'username' => 'mani', 'email' => $currentprice[0]->email, 'creditlimit' => $request->input('newcreditlimit'));
                //user mail

                $mail = view('mail.agencycreditlimitmail', $data);

                $to = $data['email'];
                $subject = 'Agency Credit Limit';
                $message = $mail;
                $headers = "From: B2B project<admin@livebeds.com>\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                mail($to, $subject, $message, $headers);

                //admin mail

                $mail = view('mail.admin.agencycreditlimitmail', $data);

                $adminemailid = '';

                $adminemail = DB::select('select * from adminemail where id=1');

                if (isset($adminemail[0]->EmailName) && !empty($adminemail[0]->EmailName)) {
                    $adminemailid = $adminemail[0]->EmailName;
                } else {
                    $adminemailid = 'vasistcompany@gmail.com';
                }

                $to = $adminemailid;
                $subject = 'Agency Credit Limit';
                $message = $mail;
                $headers = "From: B2B project<admin@livebeds.com>\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                mail($to, $subject, $message, $headers);
            }

            if ($activestatus == 1) {
                $approval_check = DB::table('agency')->where('activestatus', '=', '1')->where('id', '=', $update['id'])->get();

                if (isset($currentprice[0]->id)) {
                    $usersList = DB::table('users')->where('id', $currentprice[0]->loginid)->get();

                    $username = '';
                    $password = '';
                    $username = $usersList[0]->email;
                    if (!empty($usersList[0]->email)) {
                        $username = $usersList[0]->email;
                        if (!empty($usersList[0]->crybtPassword) && isset($usersList[0]->crybtPassword)) {
                            $password_id = Crypt::decrypt($usersList[0]->crybtPassword);
                            $password_user = base64_decode($password_id);
                        } else {
                            $password_user = '';
                        }
                        $password = $password_user;
                    }

                    $data = array('name' => $currentprice[0]->name, 'username' => 'mani', 'email' => $currentprice[0]->email, 'username' => $username, 'password' => $password);

                    $mail = view('mail.agencyapprovalmail', $data);
                    $to = $data['email'];
                    $subject = 'Agency Approved Sucessfully';
                    $message = $mail;
                    $headers = "From: B2B project<admin@livebeds.com>\r\n";
                    $headers .= "MIME-Version: 1.0\r\n";
                    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                    mail($to, $subject, $message, $headers);

                    //admin mail

                    $mail = view('mail.admin.agencyapprovalmail', $data);
                    $adminemailid = '';

                    $adminemail = DB::select('select * from adminemail where id=1');
                    if (isset($adminemail[0]->EmailName) && !empty($adminemail[0]->EmailName)) {
                        $adminemailid = $adminemail[0]->EmailName;
                    } else {
                        $adminemailid = 'vasistcompany@gmail.com';
                    }

                    $to = $adminemailid;
                    $subject = 'Agency Approved Sucessfully';
                    $message = $mail;
                    $headers = "From: B2B project<admin@livebeds.com>\r\n";
                    $headers .= "MIME-Version: 1.0\r\n";
                    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                    mail($to, $subject, $message, $headers);
                }
            }
            if ($activestatus == 0) {
                $approval_check = DB::table('agency')->where('activestatus', '=', '0')->where('id', '=', $update['id'])->get();
                if (!isset($approval_check[0]->id)) {
                    $data = array('name' => $currentprice[0]->name, 'username' => 'mani', 'email' => $currentprice[0]->email);
                    $mail = view('mail.agencycancelmail', $data);
                    $to = $data['email'];
                    $subject = 'Agency Cancelled';
                    $message = $mail;
                    $headers = "From: B2B project<admin@livebeds.com>\r\n";
                    $headers .= "MIME-Version: 1.0\r\n";
                    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                    mail($to, $subject, $message, $headers);

                    //admin mail

                    $mail = view('mail.admin.agencycancelmail', $data);

                    $adminemailid = '';
                    $adminemail = DB::select('select * from adminemail where id=1');
                    if (isset($adminemail[0]->EmailName) && !empty($adminemail[0]->EmailName)) {
                        $adminemailid = $adminemail[0]->EmailName;
                    } else {
                        $adminemailid = 'vasistcompany@gmail.com';
                    }

                    $to = $adminemailid;
                    $subject = 'Agency Cancelled';
                    $message = $mail;
                    $headers = "From: B2B project<admin@livebeds.com>\r\n";
                    $headers .= "MIME-Version: 1.0\r\n";
                    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                    mail($to, $subject, $message, $headers);
                }
            }

            $lastInsertedID = DB::table('agency')->where('id', $update['id'])->update(['requested_amount' => '0', 'requested_by' => '0', 'current_credit_limit' => $newcreditlimit, 'creditLimit' => $creditlimitUpdate, 'activestatus' => $activestatus]);

            if ($update['newmarkup'] > 0) {
                $lastInsertedID = DB::table('agency')->where('id', $update['id'])->update(['current_markup' => $update['newmarkup']]);
            }

            $lastInsertedID = DB::table('users')->where('id', $currentprice[0]->loginid)->update(['activestatus' => $activestatus]);
            if ($request->input('parentagecncy')) {

                //disable sub agency

                $subagencylist = DB::table('agency')->where('parentagencyid', '=', $agency_update_id)->get();

                if (isset($subagencylist[0]->id)) {
                    foreach ($subagencylist as $subagencydetails) {
                        $lastInsertedID = DB::table('agency')->where('id', $subagencydetails->id)->update(['activestatus' => $activestatus]);
                        $lastInsertedID = DB::table('users')->where('id', $subagencydetails->loginid)->update(['activestatus' => $activestatus]);
                    }
                }
            }

            //insert credit key
            if ($request->input('requestedstatus')) {
                $requestedid = controller::decryptid($request->input('requestedid'));
                if ($request->input('requestedstatus') == 'declined') {
                    $updateva = DB::table('agency_credit_limit_transactions')->where('id', $requestedid)->update(['declinestaus' => '1']);
                } else {
                    $updateva = DB::table('agency_credit_limit_transactions')->where('id', $requestedid)->update(['assigned_amount' => $request->input('newcreditlimit'), 'approved_by' => Auth::user()->id, 'approved_user_type' => 'SuperAdmin', 'approved_date' => date('Y-m-d')]);
                }
            } else {
                $insert['AgencyID'] = $agency_update_id;
                $insert['assigned_amount'] = $request->input('newcreditlimit');
                $insert['transaction_type'] = 'type';
                $insert['assigned_by'] = Auth::user()->id;
                $insert['assigned_user_type'] = 'SuperAdmin';
                $insert['approved_by'] = Auth::user()->id;
                $insert['approved_user_type'] = 'SuperAdmin';
                $insert['assigned_date'] = date('Y-m-d');
                $insert['approved_date'] = date('Y-m-d');
                $lastInsertedID = DB::table('agency_credit_limit_transactions')->insertGetId($insert);
            }

            //if( $request->input('agencyparentid')){}

            return redirect()->route('agency.viewagency', ['id' => $request->input('id'), 'datas' => 1]);
        }
    }

    /**
     * Ageny agencymanager module. //Create Agency Manager.
     *
     *@param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function agencymanager(Request $request) //Create Agency Manager
    {

        /*$validator = $this->validate($request,[
            'aname' => 'required|string|max:255',
            'aemail' => 'required|email',
            'address1' => 'required',
            'address2' => 'required',
            'country' => 'required',
            'city' => 'required',
            'zip' => 'required',
            'amobile' => 'required',
            'aphone' => 'required',
            'awhatsapp' => 'required',
            'skype' => 'required',
            'website' => 'required',
            'register_number' =>'required',

        ]);*/

        $decrypted_id = controller::decryptid($request->input('agency_id'));

        $select_table = DB::table('agency')->where('id', '=', ''.$decrypted_id.'')->get();

        $update_array = array();

        if (isset($select_table[0]) && !empty($select_table[0])) {
            if ($select_table[0]->aname != $request->input('aname')) {
                $update_array['AgencyName']['from'] = $select_table[0]->aname;
                $update_array['AgencyName']['to'] = $request->input('aname');
            }
            if ($select_table[0]->aemail != $request->input('aemail')) {
                $update_array['AgencyEmail']['from'] = $select_table[0]->aemail;
                $update_array['AgencyEmail']['to'] = $request->input('aemail');
            }
            if ($select_table[0]->address1 != $request->input('address1')) {
                $update_array['Address']['from'] = $select_table[0]->address1;
                $update_array['Address']['to'] = $request->input('address1');
            }

            if ($select_table[0]->address2 != $request->input('address2')) {
                $update_array['Address2']['from'] = $select_table[0]->address2;
                $update_array['Address2']['to'] = $request->input('address2');
            }
            if ($select_table[0]->country != $request->input('country')) {
                $update_array['Country']['from'] = $select_table[0]->country;
                $update_array['Country']['to'] = $request->input('country');
            }
            if ($select_table[0]->city != $request->input('city')) {
                $update_array['City']['from'] = $select_table[0]->city;
                $update_array['City']['to'] = $request->input('city');
            }

            if ($select_table[0]->pcode != $request->input('zip')) {
                $update_array['PostalCode']['form'] = $select_table[0]->pcode;
                $update_array['PostalCode']['to'] = $request->input('zip');
            }
            /*if($select_table[0]->amobile != $request->input('amobile')){

                 $update_array['Mobile']['form'] = $select_table[0]->amobile;
                 $update_array['Mobile']['to'] = $request->input('amobile');
            }*/
            if ($select_table[0]->aphone != $request->input('aphone')) {
                $update_array['Phone']['form'] = $select_table[0]->aphone;
                $update_array['Phone']['to'] = $request->input('aphone');
            }

            /*if($select_table[0]->awhatsapp != $request->input('awhatsapp')){

                 $update_array['Whatsapp']['form'] = $select_table[0]->awhatsapp;
                 $update_array['Whatsapp']['to'] = $request->input('awhatsapp');
            }*/
            /*if($select_table[0]->skype != $request->input('skype')){

                 $update_array['Skype']['form'] = $select_table[0]->skype;
                 $update_array['Skype']['to'] = $request->input('skype');
            }*/
            if ($select_table[0]->website != $request->input('website')) {
                $update_array['Website']['form'] = $select_table[0]->website;
                $update_array['Website']['to'] = $request->input('website');
            }
            if ($select_table[0]->rnumber != $request->input('register_number')) {
                $update_array['RegisterNumber']['form'] = $select_table[0]->rnumber;
                $update_array['RegisterNumber']['to'] = $request->input('register_number');
            }

            $update_array_data = array();

            if (isset($update_array) && !empty($update_array)) {
                $update_array_data['UserRole'] = 'Agency';
                $update_array_data['Rid'] = $decrypted_id;
                $update_array_new = serialize($update_array);
                $update_array_data['Updatedetail'] = $update_array_new;
                $UpdateDetail = DB::table('UpdateDetail')->insertGetId($update_array_data);
            }
        }

        $aphone = '';
        $skype = '';
        $website = '';

        if ($request->input('aphone')) {
            $aphone = $request->input('aphone');
        }
        if ($request->input('skype')) {
            $skype = $request->input('skype');
        }
        if ($request->input('website')) {
            $website = $request->input('website');
        }

        if ($decrypted_id) {
            $lastInsertedID = DB::table('agency')->where('id', $decrypted_id)->update(['aname' => $request->input('aname'), 'aemail' => $request->input('aemail'), 'address1' => $request->input('address1'), 'address2' => $request->input('address2'), 'country' => $request->input('country'), 'city' => $request->input('city'), 'pcode' => $request->input('zip'), 'aphone' => $aphone, 'website' => $website, 'rnumber' => $request->input('register_number'), 'notification_staus_new' => '0', 'notification_staus_read' => '0']);
        }

        return redirect()->route('agency', ['id' => $request->input('agency_id'), 'tab' => '2', 'datas' => 'update']);
    }
}
