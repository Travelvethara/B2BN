<?php

namespace App\Http\Controllers\Role;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

class RoleController extends Controller
{
    //
	
	public function index()
    {
		if (Auth::check()){
			
		 $notification_Controller = controller::notification_Controller();

	   //print_r($RoleIdPremissions);
	   
	   $data['whologin']  = $notification_Controller['whologin'];
	   
	   $data['activeDetails']  = $notification_Controller['agency_array'];
	   
	   $data['agecnyresultsnotification'] = $notification_Controller['agecnyresults_notification'];
	   
	   $data['agecnyresultsnotificationread'] = $notification_Controller['agecnyresults_notification_read'];
	   
	   $data['userresultsnotification'] = $notification_Controller['user_results_notification'];
	   
	   $data['userresultsnotificationread'] = $notification_Controller['user_results_notification_read'];	
			
			$data['pagename'] = 'role';
		 
		  $RoleIdPremissions = controller::Role_Permissions();
	   //print_r($RoleIdPremissions);
	     $data['Premissions'] = $RoleIdPremissions;
			
		$data['rolelist'] = '';
		
	 	
		if(isset($_GET['id']) && !empty($_GET['id']))
		{
		  $id = $_GET['id'];
	      //$decrypted_id = base64_decode($id);
		  $decrypted_id = controller::decryptid($id);
		  
		 
		  $products=DB::table('role_list')->where('id','=',''.$decrypted_id.'')->get();
		  $data['rolelist'] = $products[0];
		}	
		
		if($RoleIdPremissions['type'] == 'SuperAdmin'){
           return view('role.role',$data);
		} else{
			return redirect('/home');
		}
		
           
		}
		else
		{
		   return redirect('/');
		}
    }
	
	
	public function rolelist()
    {
		
		
		$data['pagename'] = 'rolelist';
		
		if (Auth::check()){
			
		 $notification_Controller = controller::notification_Controller();

	   //print_r($RoleIdPremissions);
	   
	   $data['whologin']  = $notification_Controller['whologin'];
	   
	   $data['activeDetails']  = $notification_Controller['agency_array'];
	   
	   $data['agecnyresultsnotification'] = $notification_Controller['agecnyresults_notification'];
	   
	   $data['agecnyresultsnotificationread'] = $notification_Controller['agecnyresults_notification_read'];
	   
	   $data['userresultsnotification'] = $notification_Controller['user_results_notification'];
	   
	   $data['userresultsnotificationread'] = $notification_Controller['user_results_notification_read'];	
			
		$RoleIdPremissions = controller::Role_Permissions();
	   //print_r($RoleIdPremissions);
	     $data['Premissions'] = $RoleIdPremissions;
			
		$data['rolelist'] = '';
		
		  $products=DB::table('role_list')->where('delete_status','=','1')->where('checkstatus','=','0')->get();
		  
		  
		 $UserList = array();
		  $i=1;
		  $Userid=DB::table('users')->where('activestatus','=','1')->get();
		  foreach($Userid as $products_val){
			  
			  if($products_val->user_type == 'UserInfo') {

			  $pid = 2;
      		  $UserList[$products_val->RoleID][$i] = $Userid[0]->RoleID;
		   
		  ++$i;
			  }
		  }
		  
		 
		  $data['rolelist'] = $products;
		  $data['rolelistcount'] = $UserList;
		  
		 
		if($RoleIdPremissions['type'] == 'SuperAdmin'){
             return view('role.rolelist',$data);
		} else{
			return redirect('/home');
		}
           
		}
		else
		{
		   return redirect('/');
		}
    }
	
	public function getuserRoleforAgency(Request $request) {
		$type = $request->input('type');
		if($type == 'agencyuserrolesoly'){ 
			$result = DB::table('role_list')->where('agency_create_user','=','1')->get();	
		}
		if($type == 'allroles'){ 
			$result = DB::table('role_list')->get();	
		}
		echo json_encode($result);
		exit;
	}
	
	public function roleinsert(Request $request)
    {
		
		$validator = $this->validate($request,[
		   'role_name' => 'required|string|max:255|unique:role_list',
		]);
		
	     $insertdata['role_name'] = $request->input('role_name');
		 $insertdata['agency_create_user'] = 0; if($request->input('agency_create_user')){ $insertdata['agency_create_user'] = 1;   }
			$insertdata['agency_approve'] = 0; if($request->input('agency_approve')){ $insertdata['agency_approve'] = 1;   }
			$insertdata['agency_open'] = 0; if($request->input('agency_open')){ $insertdata['agency_open'] = 1;   }
			$insertdata['agency_remove'] = 0; if($request->input('agency_remove')){ $insertdata['agency_remove'] = 1;   }
			$insertdata['agency_edit'] = 0; if($request->input('agency_edit')){ $insertdata['agency_edit'] = 1;   }
			$insertdata['agency_list'] = 0; if($request->input('agency_list')){ $insertdata['agency_list'] = 1;   }
			$insertdata['user_create'] = 0; if($request->input('user_create')){ $insertdata['user_create'] = 1;   }
			$insertdata['user_remove'] = 0; if($request->input('user_remove')){ $insertdata['user_remove'] = 1;   }
			
			$insertdata['user_list'] = 0; if($request->input('user_list')){ $insertdata['user_list'] = 1;   }
			$insertdata['user_edit'] = 0; if($request->input('user_edit')){ $insertdata['user_edit'] = 1;   }
			
			$insertdata['user_lock'] = 0; if($request->input('user_lock')){ $insertdata['user_lock'] = 1;   }
			$insertdata['approve_credit_limit'] = 0; if($request->input('approve_credit_limit')){ $insertdata['approve_credit_limit'] = 1;   }
			$insertdata['approve_credit_terms'] = 0; if($request->input('approve_credit_terms')){ $insertdata['approve_credit_terms'] = 1;   }
			$insertdata['approve_credit_assign'] = 0; if($request->input('approve_credit_assign')){ $insertdata['approve_credit_assign'] = 1;   }
			$insertdata['approve_credit_assign_terms'] = 0; if($request->input('approve_credit_assign_terms')){ $insertdata['approve_credit_assign_terms'] = 1;   }
            $insertdata['book'] = 0; if($request->input('book')){ $insertdata['book'] = 1;   }
			$insertdata['offline_booking'] = 0; if($request->input('offline_booking')){ $insertdata['offline_booking'] = 1;   }
			$insertdata['booking_confirm'] = 0; if($request->input('booking_confirm')){ $insertdata['booking_confirm'] = 1;   }
			$insertdata['create_voucher'] = 0; if($request->input('create_voucher')){ $insertdata['create_voucher'] = 1;   }
			$insertdata['issue_receipts'] = 0; if($request->input('issue_receipts')){ $insertdata['issue_receipts'] = 1;   }
			$insertdata['knock_off'] = 0; if($request->input('knock_off')){ $insertdata['knock_off'] = 1;   }
			$insertdata['incentive_slobs'] = 0; if($request->input('incentive_slobs')){ $insertdata['incentive_slobs'] = 1;   }
			$insertdata['partial_refund_cancel'] = 0; if($request->input('partial_refund_cancel')){ $insertdata['partial_refund_cancel'] = 1;   }
			$insertdata['approve_refund_cancel'] = 0; if($request->input('approve_refund_cancel')){ $insertdata['approve_refund_cancel'] = 1;   }
		
			
			$roleId = DB::table('role_list')->insertGetId( $insertdata );
			return redirect()->route('rolelist',['datas' => 'insert']);
		 exit;
		
	}
	
	
	public function roleupdate(Request $request)
    {
	$id = $request->input('roleid');
	$decrypted_id = base64_decode($id);
		
		$validator = $this->validate($request,[
		   'role_name' => 'required|string|max:255',
		]);
		
		    $updatedata['role_name'] = $request->input('role_name');
		    $updatedata['agency_create_user'] = 0; if($request->input('agency_create_user')){ $updatedata['agency_create_user'] = 1;   }
			$updatedata['agency_approve'] = 0; if($request->input('agency_approve')){ $updatedata['agency_approve'] = 1;   }
			$updatedata['agency_open'] = 0; if($request->input('agency_open')){ $updatedata['agency_open'] = 1;   }
			$updatedata['agency_remove'] = 0; if($request->input('agency_remove')){ $updatedata['agency_remove'] = 1;   }
			$updatedata['agency_edit'] = 0; if($request->input('agency_edit')){ $updatedata['agency_edit'] = 1;   }
			$updatedata['agency_list'] = 0; if($request->input('agency_list')){ $updatedata['agency_list'] = 1;   }
			$updatedata['user_create'] = 0; if($request->input('user_create')){ $updatedata['user_create'] = 1;   }
			$updatedata['user_remove'] = 0; if($request->input('user_remove')){ $updatedata['user_remove'] = 1;   }
			$updatedata['user_lock'] = 0; if($request->input('user_lock')){ $updatedata['user_lock'] = 1;   }
			$updatedata['user_list'] = 0; if($request->input('user_list')){ $updatedata['user_list'] = 1;   }
			$updatedata['user_edit'] = 0; if($request->input('user_edit')){ $updatedata['user_edit'] = 1;   }
			
			$updatedata['approve_credit_limit'] = 0; if($request->input('approve_credit_limit')){ $updatedata['approve_credit_limit'] = 1;   }
			$updatedata['approve_credit_terms'] = 0; if($request->input('approve_credit_terms')){ $updatedata['approve_credit_terms'] = 1;   }
			$updatedata['approve_credit_assign'] = 0; if($request->input('approve_credit_assign')){ $updatedata['approve_credit_assign'] = 1;   }
			$updatedata['approve_credit_assign_terms'] = 0; if($request->input('approve_credit_assign_terms')){ $updatedata['approve_credit_assign_terms'] = 1;   }
            $updatedata['book'] = 0; if($request->input('book')){ $updatedata['book'] = 1;   }
			$updatedata['offline_booking'] = 0; if($request->input('offline_booking')){ $updatedata['offline_booking'] = 1;   }
			$updatedata['booking_confirm'] = 0; if($request->input('booking_confirm')){ $updatedata['booking_confirm'] = 1;   }
			$updatedata['create_voucher'] = 0; if($request->input('create_voucher')){ $updatedata['create_voucher'] = 1;   }
			$updatedata['issue_receipts'] = 0; if($request->input('issue_receipts')){ $updatedata['issue_receipts'] = 1;   }
			$updatedata['knock_off'] = 0; if($request->input('knock_off')){ $updatedata['knock_off'] = 1;   }
			$updatedata['incentive_slobs'] = 0; if($request->input('incentive_slobs')){ $updatedata['incentive_slobs'] = 1;   }
			$updatedata['partial_refund_cancel'] = 0; if($request->input('partial_refund_cancel')){ $updatedata['partial_refund_cancel'] = 1;   }
			$updatedata['approve_refund_cancel'] = 0; if($request->input('approve_refund_cancel')){ $updatedata['approve_refund_cancel'] = 1;   }
			
			$lastInsertedID = DB::table('role_list')->where('id',$decrypted_id )->update(['role_name' => $updatedata['role_name'],'agency_create_user' => $updatedata['agency_create_user'],'agency_approve' => $updatedata['agency_approve'],'agency_open' => $updatedata['agency_open'],'agency_remove' => $updatedata['agency_remove'],'agency_edit' => $updatedata['agency_edit'],'agency_list' => $updatedata['agency_list'],'user_create' => $updatedata['user_create'],'user_remove' => $updatedata['user_remove'],'user_lock' => $updatedata['user_lock'],'user_list' => $updatedata['user_list'],'user_edit' => $updatedata['user_edit'],'approve_credit_limit' => $updatedata['approve_credit_limit'],'approve_credit_terms' => $updatedata['approve_credit_terms'],'approve_credit_assign' => $updatedata['approve_credit_assign'],'approve_credit_assign_terms' => $updatedata['approve_credit_assign_terms'],'book' => $updatedata['book'],'offline_booking' => $updatedata['offline_booking'],'booking_confirm' => $updatedata['booking_confirm'],'create_voucher' => $updatedata['create_voucher'],'issue_receipts' => $updatedata['issue_receipts'],
'knock_off' => $updatedata['knock_off'],'incentive_slobs' => $updatedata['incentive_slobs'],'partial_refund_cancel' => $updatedata['partial_refund_cancel'],
'approve_refund_cancel' => $updatedata['approve_refund_cancel']]);


         return redirect()->route('rolelist',['datas' => 'update']);
			

		
		
	}
	
	public function RoleDelete(Request $request)
    {   
	    $delete_status = 0;
		$id = $request->input('id');
		$agencyID = DB::table('role_list')->where('id', $request->input('id'))->update(['delete_status' => $delete_status]);
		
		//$del = DB::table('role_list')->where('id', '=', $id)->delete();
		return redirect()->route('rolelist',['datas1' => 'delete']);
	}
	
	
	
	
}
