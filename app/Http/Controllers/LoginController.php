<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Crypt;
use Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest')->except('logout');
    }
	
	public function index()
    {
		
	 if (Auth::viaRemember()){
		//view for home page	
        return view('home');
		
	 }
	else
	{
		//view for redirect the page
	   return redirect('/');
		}
    }
	
	
	
	public function loginpage()
    {
		
	 if (Auth::viaRemember()){
		//view for home page	
        return view('home');
		
	 }
	else
	{
		//view for redirect the page
	   return redirect('/');
		}
    }
	
	
	public function whologin(Request $request)
	{
		
		$loginid = $request->input('loginid');
		$re = DB::table('whologin')->where('loginid', '=', $loginid)->delete();
        
		echo '1';	
	
	}
	
	
	public function thankspage()
    {
		
	
		//view for home page	
        return view('auth.thanks');
	}
	
	public function credentials(Request $request)
    {
	//login check 
     //$remember = $request->input('remember');
	 $remember = $request->has('remember') ? true : false;
		return [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
			'activestatus' => '1',
			 //'remember_token' => $remember,
        ];
    }

public function forgetpagePost(Request $request)
	{
		
	
		 $password = Hash::make($request->input('password'));
	     $request->userID;
		 $id = Crypt::decrypt($request->userID);
         $decrypted_id = base64_decode($id);
		 if ($decrypted_id) {
    		
    		$lastInsertedID = DB::table('users')->where('id', $decrypted_id)->update(['password' => $password]);
			return redirect('/home');;
		 }else{
			 echo 'fail';
			 
		 }
		 
		
	}


public function forgetpage()
    {
		
	
		//view for home page	
		
		
		$id = $_GET['id'];
		 try {
    				$decrypted_id = Crypt::decrypt($id);
    				$decrypted_id = base64_decode($decrypted_id);
					 return view('auth.forgetpassword');
    			} catch (DecryptException $e) {
			
    				return redirect('/');
    			}
		
		 
		
      
	}
	
public function forgetpassowrdlogin(){


		
		$useremail = $_POST['useremail'];
		
		
		$agencycredit_update = DB::table('users')->where('activestatus','=',1)->where('email','=',$useremail)->get();

		
		echo $useremail;
		exit;
		
		
		if(empty($agencycredit_update[0])){
		echo 'faild';	
		}else{
		$route_url = route('forgetpage');
		$id_url  = Crypt::encrypt(base64_encode($agencycredit_update[0]->id));
		$url = $route_url.'?id='.$id_url;
	    $url;
	    $data['id'] = $id_url;
		$data['name'] = $agencycredit_update[0]->name;
		$data['url'] = $url;
		$mail = view('mail.password.forgetpassword_mail',$data);
		//$mail = view('mail.admin.agencycancelmail',$data);
		$to = $useremail;
		$subject = "B2B Agency Forget Password " ;
		$message = $mail;
		$headers = "From: B2B project<admin@livebeds.com>\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
		mail($to,$subject,$message,$headers);	
		//echo $mail;	
		
		echo 'active';
		}
		exit;
		
		
	


}


public function forgetpassowrds()
    {
		
		$useremail = $_GET['useremail'];
		
		
		$agencycredit_update = DB::table('users')->where('activestatus','=',1)->where('email','=',$useremail)->get();

		
		echo $useremail;
		exit;
		
		
		if(empty($agencycredit_update[0])){
		echo 'faild';	
		}else{
		$route_url = route('forgetpage');
		$id_url  = Crypt::encrypt(base64_encode($agencycredit_update[0]->id));
		$url = $route_url.'?id='.$id_url;
	    $url;
	    $data['id'] = $id_url;
		$data['name'] = $agencycredit_update[0]->name;
		$data['url'] = $url;
		$mail = view('mail.password.forgetpassword_mail',$data);
		//$mail = view('mail.admin.agencycancelmail',$data);
		$to = $useremail;
		$subject = "B2B Agency Forget Password " ;
		$message = $mail;
		$headers = "From: B2B project<admin@livebeds.com>\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
		mail($to,$subject,$message,$headers);	
		//echo $mail;	
		
		echo 'active';
		}
		exit;
		
		
	}
public function apiportal()
    {
		
		
		
		
		$notification_Controller = controller::notification_Controller();

	   //print_r($RoleIdPremissions);
	   
	   $data['whologin']  = $notification_Controller['whologin'];
	   
	   $data['activeDetails']  = $notification_Controller['agency_array'];
	   
	   $data['agecnyresultsnotification'] = $notification_Controller['agecnyresults_notification'];
	   
	   $data['agecnyresultsnotificationread'] = $notification_Controller['agecnyresults_notification_read'];
	   
	   $data['userresultsnotification'] = $notification_Controller['user_results_notification'];
	   
	   $data['userresultsnotificationread'] = $notification_Controller['user_results_notification_read'];
		
		
		$data['pagename'] = 'profile';
		if (Auth::check()){
		
			$Loginid = Auth::user()->id;
		 $data['CAgencyDetails'] = '';
		 $RoleIdPremissions = controller::Role_Permissions();
	   //print_r($RoleIdPremissions);
	   $data['Premissions'] = $RoleIdPremissions;
	   

	   
	 /*  echo '<pre>';
		   print_r($CAgencydetails);
		   echo '</pre>';*/
		 
		 if(Auth::user()->user_type == 'AgencyManger'){
		   $CAgencydetails =DB::table('agency')->where('loginid','=',''.$Loginid.'')->get();
		   
		   $data['name'] = $CAgencydetails[0]->name;
		   $data['email'] = $CAgencydetails[0]->email;
		   $data['phone'] = $CAgencydetails[0]->phone;
		   $data['userid'] = $CAgencydetails[0]->userid;
		   $data['id'] = $CAgencydetails[0]->id;
		   $data['loginid'] = $Loginid;
		   $data['type'] = 'AgencyManger';
		   
		 }
		 
		 
		  if(Auth::user()->user_type == 'SubAgencyManger'){
		   $CAgencydetails =DB::table('agency')->where('loginid','=',''.$Loginid.'')->get();
		   $data['name'] = $CAgencydetails[0]->name;
		   $data['email'] = $CAgencydetails[0]->email;
		   $data['phone'] = $CAgencydetails[0]->phone;
		   $data['userid'] = $CAgencydetails[0]->userid;
		   $data['id'] = $CAgencydetails[0]->id;
		   $data['loginid'] = $Loginid;
		   $data['type'] = 'AgencyManger';
		   
		 }
		 
		  if(Auth::user()->user_type == 'UserInfo'){
		  $CAgencydetails =DB::table('userinformation')->where('loginid','=',''.$Loginid.'')->get();
		   $data['name'] = $CAgencydetails[0]->name;
		   $data['email'] = $CAgencydetails[0]->email;
		   $data['phone'] = $CAgencydetails[0]->phone;
		   $data['userid'] = $CAgencydetails[0]->userid;
		   $data['id'] = $CAgencydetails[0]->id;
		   $data['loginid'] = $Loginid;
		   $data['type'] = 'UserInfo';
		  
		  }
           return view('profile.profile',$data);
		}
		else
		{
		   return redirect('/');
		}
		
    
		
		
		
		
	}



	
	
	
	
}
