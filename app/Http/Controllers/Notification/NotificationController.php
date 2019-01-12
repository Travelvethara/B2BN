<?php

namespace App\Http\Controllers\Notification;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

class NotificationController extends Controller
{
    //
	public function index()
	{
		
		
		
		
		
		if (Auth::check()){
			
			$RoleIdPremissions = controller::Role_Permissions();
	   //print_r($RoleIdPremissions);
			$data['Premissions'] = $RoleIdPremissions;
			
			//notification update
			
			$notification_badge = DB::table('agency')->where('notification_badge', 1)->update(['notification_badge' => 0]);
           
		   if(isset($_GET['mani'])){
			echo '<pre>';
			print_r($AgencyDetails);
			echo '</pre>';
			}

                
		//Agency
			$Agencyname_array = array(); 
			$AgencyDate_array = array(); 
			$AgencyDetailsDetails =DB::table('agency')->get();
			foreach($AgencyDetailsDetails as $AgencyDetails_Details_List){
				$Agencyname_array[$AgencyDetails_Details_List->id] = $AgencyDetails_Details_List->name; 	
			}
			$data['AgencyName'] = $Agencyname_array; 

                 if($RoleIdPremissions['type'] == 'SuperAdmin'){
			$AgencyDetails =DB::table('agency')->where('notification_staus','=','1')->where('delete_status','!=','0')->get();
				 }
				 
				 if($RoleIdPremissions['type'] == 'AgencyManger'){
					 $agencylistm =DB::table('agency')->where('loginid','=',Auth::user()->id)->get();
			$AgencyDetails =DB::table('agency')->where('notification_staus','=','1')->where('delete_status','!=','0')->where('parentagencyid','!=',$agencylistm[0]->id)->get();
				 }
				 
			foreach($AgencyDetails as $AgencyDetails_List){

				$agency_credit_limit_transactions =DB::table('agency_credit_limit_transactions')->where('AgencyID','=',$AgencyDetails_List->id)->get();

				foreach($agency_credit_limit_transactions as $agency_credit_limit_transactions_list){
					$AgencyDate_array[$agency_credit_limit_transactions_list->AgencyID] = $agency_credit_limit_transactions_list->assigned_date;
				}

				$Agencyname_array[$AgencyDetails_Details_List->id] = $AgencyDetails_Details_List->name; 	
			}

	        $data['AgencyDate']  = $AgencyDate_array;
			$data['AgencyDetails']  = $AgencyDetails;
		
			if($RoleIdPremissions['type'] == 'SuperAdmin' || $RoleIdPremissions['type'] == 'AgencyManger'){
			//echo 'hi';
				return view('notification.notification',$data);
			} else{
				return redirect('/home');
			}

		}
		else
		{
			return redirect('/');
		}
	}
	
	
	
	
	public function loginnotification()
	{
		

		
		if (Auth::check()){
			
			$RoleIdPremissions = controller::Role_Permissions();
	   //print_r($RoleIdPremissions);
			$data['Premissions'] = $RoleIdPremissions;
			
			//notification update
			
			$notification_badge = DB::table('agency')->where('notification_badge', 1)->update(['notification_badge' => 0]);

		//Agency
			$Agencyname_array = array(); 
			$AgencyDate_array = array(); 
			$AgencyDetailsDetails =DB::table('agency')->get();
			foreach($AgencyDetailsDetails as $AgencyDetails_Details_List){
				$Agencyname_array[$AgencyDetails_Details_List->id] = $AgencyDetails_Details_List->name; 	
			}
			$data['AgencyName'] = $Agencyname_array; 


			$AgencyDetails =DB::table('agency')->where('notification_staus','=','1')->get();
			
			
			foreach($AgencyDetails as $AgencyDetails_List){

				$agency_credit_limit_transactions =DB::table('agency_credit_limit_transactions')->where('AgencyID','=',$AgencyDetails_List->id)->get();

				foreach($agency_credit_limit_transactions as $agency_credit_limit_transactions_list){
					$AgencyDate_array[$agency_credit_limit_transactions_list->AgencyID] = $agency_credit_limit_transactions_list->assigned_date;
				}

				$Agencyname_array[$AgencyDetails_Details_List->id] = $AgencyDetails_Details_List->name; 	
			}
/*
echo '<pre>';
print_r($AgencyDate_array);
echo '</pre>';

exit;*/
			$data['AgencyDate']  = $AgencyDate_array;
			$data['AgencyDetails']  = $AgencyDetails;
			
			
			
			
			
			
			
			$agency_array  = array();
		$agency_content =DB::table('users')->get();

		foreach($agency_content as $agency_content_v){
		$agency_array[$agency_content_v->id]['name']  = $agency_content_v->name;
			
		}
		
		$whologin =DB::table('whologin')->where('staus','=',1)->get();

            $data['agencyarray']  = $agency_array;
			$data['whologin']  = $whologin;
			

			if($RoleIdPremissions['type'] == 'SuperAdmin'){
			//echo 'hi';
				return view('notification.loginnotification',$data);
			} else{
				return redirect('/home');
			}

		}
		
		
		
	}
	
	
	public function notificationagencytrash(Request $request){
		
		$agencyID = DB::table('agency')->where('id', $request->input('id'))->update(['notification_staus' => 2]);
		
		return redirect()->route('notification', ['datas1' => 'delete']);
	}
}
