<?php



namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Hotel\HotelApiController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use app;

use Crypt;
use Illuminate\Contracts\Encryption\DecryptException;



class HomeController extends Controller

{

    /**

     * Create a new controller instance.

     *

     * @return void

     */

    public function __construct()

    {

        $this->middleware('auth');

    }



    /**

     * Show the application dashboard.

     *

     * @return \Illuminate\Http\Response

     */

  
  
    
  
  
    public function index()

    {    
	
	  
	  $getname = Route::getCurrentRoute()->getActionName();
	
	  $data['pagename'] = strstr($getname, '@');
	
	  $Cdate = date('Y-m-d');
	
	  DB::table('whologin')->where('create_date', '<', $Cdate)->delete();
	//login co
	
	 $Loginid = Auth::user()->id;
	 
	 if(isset(Auth::user()->id)){
	 
	 $whologindetails =DB::table('whologin')->where('loginid','=',''.$Loginid.'')->get();
	 
	 $results = DB::select('select * from whologin');
	 
	 $Cdate = date('Y-m-d');
	 //echo $Cdate;
	 

	 if(!isset($whologindetails[0]->loginid))
	 {
		$agencyInsert['loginid'] = Auth::user()->id;
    	$agencyInsert['type'] = Auth::user()->user_type;
    	$agencyInsert['staus'] = '1';
    	$agencyInsert['statusc'] = '0';
		$agencyInsertID = DB::table('whologin')->insertGetId( $agencyInsert );
	 }
	 
	 }



    if(Auth::user()->user_type == 'SuperAdmin'){
     
     $current = strtotime(date('Y-m-d'));
	 $date = date('Y-m-d', strtotime('-10 day', $current));
	
	 //$userinformation =DB::table('userinformation')->where('activestatus','=',1)->where('created_at','>',$date)->limit(3)->get();
	 
	 
	  $userinformation = DB::select( DB::raw("SELECT * FROM userinformation ORDER BY id DESC LIMIT 0, 3"));
	 
	 
	 
	 //$agency =DB::table('agency')->where('created_at','>',$date)->where('activestatus','=',1)->limit(3)->get();
	 
	 
	 
	 $agency = DB::select( DB::raw("SELECT * FROM agency ORDER BY id DESC LIMIT 0, 3"));

	 
	
	 
	 if(isset($agency[0])){
	 
	    $data['agency'] = $agency;
	 }
	 if(isset($userinformation[0])){
	 
	    $data['userinformation'] = $userinformation;
	 }
	 
	 
	
	 
	 
	 
	}
	
	
	if(Auth::user()->user_type == 'AgencyManger'){
     
     $current = strtotime(date('Y-m-d'));
	 $date = date('Y-m-d', strtotime('-10 day', $current));
	
	 //agecy id 
     $agencylistm =DB::table('agency')->where('loginid','=',Auth::user()->id)->get();
	 
	 $userinformation =DB::table('userinformation')->where('activestatus','=',1)->where('agentid','=',$agencylistm[0]->id)->where('created_at','>',$date)->get();
	 
	 
	 
	 
	 
	 

	 $agency =DB::table('agency')->where('created_at','>',$date)->where('parentagencyid','=',$agencylistm[0]->id)->get();
	 
	
	 
	
	 
	 if(isset($agency[0])){
	 
	    $data['agency'] = $agency;
	 }
	 if(isset($userinformation[0])){
	 
	    $data['userinformation'] = $userinformation;
	 }
	 
	 
	
	 
	 
	 
	}


	   $RoleIdPremissions = controller::Role_Permissions();
	   
	   $notification_Controller = controller::notification_Controller();
	   

	   
	   
	   
	   
	   
	   
	    if(isset($_GET['mani'])){
	     echo '<pre>';
	      print_r($whologin);
	      echo '</pre>';
	 
	 }
	   
	   
	   
	   
	   
	   

	   //print_r($RoleIdPremissions);
	   
	   $data['whologin']  = $notification_Controller['whologin'];
	   
	   $data['activeDetails']  = $notification_Controller['agency_array'];

	   $data['Premissions'] = $RoleIdPremissions;
	   
	   $data['agecnyresultsnotification'] = $notification_Controller['agecnyresults_notification'];
	   
	   $data['agecnyresultsnotificationread'] = $notification_Controller['agecnyresults_notification_read'];
	   
	   $data['userresultsnotification'] = $notification_Controller['user_results_notification'];
	   
	   $data['userresultsnotificationread'] = $notification_Controller['user_results_notification_read'];

        return view('dashBoard',$data);

    }
	
	
	
	
	
	public function homeSearch()
    {


     $getname = Route::getCurrentRoute()->getActionName();
	 
	 $getcountries =DB::table('getcountries')->get();
	
	 $data['pagename'] = strstr($getname, '@');
    
	 $Cdate = date('Y-m-d');
	
	  DB::table('whologin')->where('create_date', '<', $Cdate)->delete();
	//login co
	
	 $Loginid = Auth::user()->id;
	 
	 if(isset(Auth::user()->id)){
	 
	 $whologindetails =DB::table('whologin')->where('loginid','=',''.$Loginid.'')->get();
	 
	 $results = DB::select('select * from whologin');
	 
	 $Cdate = date('Y-m-d');
	 //echo $Cdate;
	 

	 if(!isset($whologindetails[0]->loginid))
	 {
		$agencyInsert['loginid'] = Auth::user()->id;
    	$agencyInsert['type'] = Auth::user()->user_type;
    	$agencyInsert['staus'] = '1';
    	$agencyInsert['statusc'] = '0';
		$agencyInsertID = DB::table('whologin')->insertGetId( $agencyInsert );
	  }
	 
	 }

	   $RoleIdPremissions = controller::Role_Permissions();

	   //print_r($RoleIdPremissions);
	   
	   $data['getcountries'] = $getcountries;

	   $data['Premissions'] = $RoleIdPremissions;

        return view('home',$data);

    }
	
	
	public function emailupdate(Request $request)  // Update Agency infromations - In this function we can update the agency, sub agency informations
    {
    	$validator = $this->validate($request,[
    		'email' => 'required|email',
    	]);

		
		$decrypted_loginid = 1;
		$users = DB::table('adminemail')->where('id', $decrypted_loginid)->update(['EmailName' => $request->input('email')]);
		
		return redirect()->route('adminemail', ['datas' => 'update']);
	}
	
	
	public function adminemailc()
    {
		


     $getname = Route::getCurrentRoute()->getActionName();
	 
	 $adminemail =DB::table('adminemail')->get();
	 
	 
	 
	 $getcountries =DB::table('getcountries')->get();
	
	 $data['pagename'] = strstr($getname, '@');
    
	 $Cdate = date('Y-m-d');
	

	   $RoleIdPremissions = controller::Role_Permissions();

	   //print_r($RoleIdPremissions);
	   
	   $data['getcountries'] = $getcountries;
	   $data['adminemail'] = $adminemail;

	   $data['Premissions'] = $RoleIdPremissions;
	 

        return view('profile.adminemail',$data);

    
		
	}
	
	
	public function updateajx()
    {
		
		//ajax
		
		$id = $_GET['id'];
		$role = $_GET['role'];
		
		
			
			//$UpdateDetail =DB::table('UpdateDetail')->where('Rid','=',$id)->get();
			
			$UpdateDetail = DB::select('select * from UpdateDetail where Rid = '.$id.' AND UserRole ="'.$role.'"  ORDER BY `UpdateDetail`.`id` DESC');
			
			
			$updated_row_content ='';
			$so_no = 1;
			foreach($UpdateDetail as $UpdateDetailvalue) {
				
				
				$Updatedetail_value = unserialize($UpdateDetailvalue->Updatedetail);
				 $time =  date("h:i A",strtotime($UpdateDetailvalue->datetime));
				 $date =  date("m/d/Y",strtotime($UpdateDetailvalue->datetime));
				 
				 
				 
				foreach($Updatedetail_value as $key => $value) {
				
			
				if(!empty($value['from'])){
				 
				 $updated_row_content .= '<tr><td>'.$so_no.'</td><td>'.$key.'</td><td>'.$value['from'].'</td><td>'.$value['to'].'</td><td>'.$date.' '.$time.'</td></tr>';
				}
				
				++$so_no;
				
				}
				
			}
			
			
				echo '<table class="table m-table table-bordered tabletitwidth m-table--border-brand m-table--head-bg-success">
											<thead>
												<tr>
								<th title="">
									S no
								</th>
								
                                <th title="">
									Field Name
								</th>
                                <th title="">
									From
								</th>
                                <th title="">
									To
								</th>
                                <th title="">
									Date and Time
								</th>
							
											</tr></thead>
											<tbody> '.$updated_row_content.'</body></table>';
	

		
	
		
		
		
	}
	
	
	
	public function currenyconverter()
    {
		
		
		echo $this->currenyconvertercheck("USD","USD",1);
		
		
	}
	
	public function currenyconvertercheck($from,$to,$amount,$sign=true,$sensitivity=5)
    {

		//Load live conversion rates and set as an array
		$XMLContent= "http://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml";
	
		
		$cur=curl_init();
		
		
		curl_setopt($cur,CURLOPT_URL,$XMLContent);
		curl_setopt($cur, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
		curl_setopt($cur,CURLOPT_HTTPHEADER,array('Accept:application/xml'));
		curl_setopt($cur, CURLOPT_HTTPHEADER, array('Content-Type: text/xml,charset=UTF-8'));
		curl_setopt($cur, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($cur, CURLOPT_RETURNTRANSFER,1);
		
		$retValue = curl_exec($cur);
		if(curl_errno($cur))
		curl_error($cur).'<br />';
		curl_close($cur);
		if($retValue){
		$result=new \SimpleXMLElement($retValue);
		}
		$tboarray = json_decode(json_encode((array)$tboxml), TRUE);
		
		 echo '<pre>';
				print_r($retValue);
				echo '</pre>';
		
		
		
	}
	
	
    public function dashboardCharturl()
    {

		//super admin
		$id = $_GET['id'];
		$role = $_GET['role'];
		
		
		
		
		if($_GET['role'] == 'SuperAdmin'){
		    $id = 0;
		
		}
		
		$year_array = array('1' => '2018','2' => '2019','3' => '2020','4' => '2021');
		
		//json array
		$json_array = array();
		
		
		
		
		//toatal agent
		if($_GET['role'] == 'SuperAdmin'){
			
			$agecntcount =DB::table('agency')->where('activestatus','=','1')->get();
			
			$json_array['agent'] = count($agecntcount);
			
			$totalpayment =DB::table('payment')->get();
			
			$json_array['totalpayment'] = count($totalpayment);
			
			$userinformation =DB::table('userinformation')->where('activestatus','=','1')->get();
			
			$json_array['userinformation'] = count($userinformation);
			
			   
		}
		
		
		//toatal agent
		if($_GET['role'] == 'AgencyManger'){
			
			//agecy id 
			$agencylistm =DB::table('agency')->where('loginid','=',Auth::user()->id)->get();
			
			
			
			
			
		
			$json_array['CurrentCreditLimit'] = round($agencylistm[0]->current_credit_limit, 2);
			
			$agenctlistcount = 0;
			if(isset($agencylistm[0])){
				
				foreach($agencylistm as $agencylistm_v){
			
			         $agecntcount =DB::table('agency')->where('parentagencyid','=',$agencylistm_v->id)->get();
			         $agenctlistcount += count($agecntcount);
			         $json_array['agent'] = $agenctlistcount;
			    
				}
			}
			
			
			///
			

			$agecnyresults = DB::select( DB::raw("SELECT * FROM payment WHERE login_id = ".Auth::user()->id." AND user_type='AgencyManger'"));
			
			//subagency payment
			
			$sub_agency_count = 0;
			if(isset($agecntcount[0])){
		
				foreach($agecntcount as $agecntcount_v){
				
			
			$subagency_result = DB::select( DB::raw("SELECT * FROM payment WHERE login_id =".$agecntcount_v->loginid."  AND user_type='SubAgencyManger'"));
			
			$sub_agency_count += count($subagency_result);
			
			
				}
			}
			
			$userinformation =DB::table('userinformation')->where('agentid','=',$agencylistm[0]->id)->where('activestatus','=','1')->get();
			
			$json_array['userinformation'] = count($userinformation);
			
			$user_agency_count = 0;
			if(isset($userinformation[0])){
			
				foreach($userinformation as $userinformation_v){
				
			
			$user_result = DB::select( DB::raw("SELECT * FROM payment WHERE login_id =".$userinformation_v->loginid."  AND user_type='UserInfo'"));
			
			$user_agency_count += count($user_result);
			
			
				}
			}
			//user payment

			$json_array['totalpayment'] = count($agecnyresults) + $sub_agency_count + $user_agency_count;
			
		}
		
		if($_GET['role'] == 'SubAgencyManger'){

			$agecnyresults = DB::select( DB::raw("SELECT * FROM payment WHERE login_id = ".Auth::user()->id." AND user_type='SubAgencyManger'"));
			
			$json_array['totalpayment'] = count($agecnyresults);
			
		
		}
		
		//user info
		
		
		if($_GET['role'] == 'UserInfo'){

			$agecnyresults = DB::select( DB::raw("SELECT * FROM payment WHERE login_id = ".Auth::user()->id." AND user_type='UserInfo'"));
			
			$json_array['totalpayment'] = count($agecnyresults);
			
		
		}
		
		
		

		$json_values = '';
		if($_GET['role'] == 'SuperAdmin'){
		
		foreach($year_array as $key => $values){
		
		$payment =DB::table('payment')->where('Bookdate','LIKE','%'.$values.'%')->get();
		
		   foreach ($payment as $payment_v){
			   
			   $json_values += $payment_v->totalprice;
				
			   $json_array[$key] = $json_values;
			
		   }
		}
		
		}
		
		if($_GET['role'] == 'AgencyManger'){
			
			
			$json_array[1] = 0;
		
		foreach($year_array as $key => $values){
		
		$payment =DB::table('payment')->where('login_id','=',$id)->where('user_type','=',''.$role.'')->where('booking_confirm','=',1)->where('Bookdate','LIKE','%'.$values.'%')->get();
		if(isset($payment[0])){
		   foreach ($payment as $payment_v){
			   
			   $json_values += $payment_v->totalprice;
			   $json_array[$key] = $json_values;
		   }
		   
		}
		   
		   
		   
		
		   
		   
		  //subagncy include
		
		$json_subvalues = '';
		
		
		$subagency =DB::table('agency')->where('parentagencyid','=',$agencylistm[0]->id)->get();
	
		
		if(isset($subagency[0])){
		    foreach($year_array as $key => $values){
		        foreach($subagency as $subagency_v){
				
		   $Subpayment =DB::table('payment')->where('login_id','=',$subagency_v->loginid)->where('user_type','=','SubAgencyManger')->where('booking_confirm','=',1)->where('Bookdate','LIKE','%'.$values.'%')->get();   
		   
		   foreach ($Subpayment as $payment_v){
			   
			   $json_subvalues += $payment_v->totalprice;
			   $json_array[$key] = $json_values + $json_subvalues;
				
			   
			
		   }
				}
		   
		   }
		}
		}
	
		}
		
		
		if($_GET['role'] == 'SubAgencyManger'){
		$json_values = '';
		foreach($year_array as $key => $values){
		
		$payment =DB::table('payment')->where('login_id','=',$id)->where('user_type','=',''.$role.'')->where('booking_confirm','=',1)->where('Bookdate','LIKE','%'.$values.'%')->get();
		
		   foreach ($payment as $payment_v){
			   
			   $json_values += $payment_v->totalprice;
			   $json_array[$key] = $json_values;
		   }
		   
		}
		
		
		}
		
		
		
		if($_GET['role'] == 'Userinfo'){
		$json_values = '';
		foreach($year_array as $key => $values){
		
		$payment =DB::table('payment')->where('login_id','=',$id)->where('user_type','=',''.$role.'')->where('booking_confirm','=',1)->where('Bookdate','LIKE','%'.$values.'%')->get();
		
		   foreach ($payment as $payment_v){
			   
			   $json_values += $payment_v->totalprice;
			   $json_array[$key] = $json_values;
		   }
		   
		}
		
		
		}
		

		
		
		echo json_encode($json_array);
		
		
		   

	}

	

}

