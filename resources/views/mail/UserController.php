<?php



namespace App\Http\Controllers\User;



use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\URL;

use Crypt;

use Illuminate\Contracts\Encryption\DecryptException;



class UserController extends Controller

{

    //



   use AuthenticatesUsers;



    /**

     * Where to redirect users after login.

     *

     * @var string

     */

   

	public function index()

    {

		if (Auth::check()){

			

		$RoleIdPremissions = controller::Role_Permissions();

		$data['Premissions'] = $RoleIdPremissions;

		//exit;	

		//check data

		$data['user'] = '';

		$role = DB::table('role_list')->orderBy('role_list.updated_at', 'DESC')->get();

		

	   if($data['Premissions']['type'] == 'AgencyManger'){

		   $role = $role->where('agency_create_user','=','1')->where('id','!=','2')->where('id','!=','1');

		   }

		

		$agency=DB::table('agency')->orderBy('agency.updated_at', 'DESC')->get();

		

		if(isset($_GET['id']) && !empty($_GET['id']))

		{

		 $id = $_GET['id'];

		 $userid = controller::decryptid($id);

		

		  $products=DB::table('userinformation')->where('id','=',''.$userid.'')->get();

		  $data['user'] = $products[0];

		}

		 if($RoleIdPremissions['type'] == 'UserInfo'){

		    if($RoleIdPremissions['premission'][0]->user_create == 1)

		      {

		     // $data['type'] = 'UserInfo';

		      return view('user.user',$data,compact('role', 'agency'));

		      } else{ 

			  return redirect('/home'); 

			  }

		    } else{

        return view('user.user',$data,compact('role', 'agency'));

			}

		}

		else

		{

		return redirect('/');

		}

    }



	//Users details Insert

	public function userinsert(Request $request)

	{

        $RoleIdPremissions = controller::Role_Permissions();

		$data['Premissions'] = $RoleIdPremissions;	



		$validator = $this->validate($request,[

		   'name' => 'required|string|max:255',

		   'email' => 'required|email|unique:users',

		   'password' => 'required|string|min:6|confirmed',

		   'phone' => 'required',

		   'mobile' => 'required',

		   'roleid' => 'required|not_in:0',

		   'roleid' => 'required|not_in:0',

		]);

	

		

		if($request->input('activestatus') == 'on'){

			$insert['activestatus'] = 1;

			} else {

				$insert['activestatus'] = 0;

			}

		

		

	    $insert['name'] = $request->input('name');

		$insert['email'] = $request->input('email');

		$insert['password'] = Hash::make($request->input('password'));

		$insert['RoleID'] = $request->input('roleid');

		$insert['user_type'] = 'UserInfo';

		$insert['created_at'] = date('Y-m-d H:i:s');

        $insert['updated_at'] = date('Y-m-d H:i:s');

		$lastInsertedID = DB::table('users')->insertGetId( $insert );
//$lastInsertedID = 1;
		

			if($request->input('activestatus') == 'on'){

			$userdata['activestatus'] = 1;

			} else {

				$userdata['activestatus'] = 0;

				}

		
          $role_type = 'Admin';
		  
		  
		if($request->input('agent_level') == 'on'){

			$userdata['agent_level'] = 1;
           
			$userdata['agentid'] =  $request->input('agentid');
			
			$role_type = 'Agent';

			

			} else {

				$userdata['agent_level'] = 0;

				$userdata['agentid'] =0;

				}

	

		if($data['Premissions']['type'] == 'AgencyManger'){

			$userdata['agent_level'] = 1;

			$id = Auth::user()->id;

			$dat = DB::table('agency')->where('loginid', '=', $id)->get();

			$agencyid = '';

			if(isset($dat[0])) {

				$agencyid = $dat[0]->id;

				}

			$userdata['agentid'] = $agencyid;

		   }		

		//User details 

		$userdata['name'] = $request->input('name');

		$userdata['loginid'] = $lastInsertedID;

        $userdata['userid'] = 'USER1000'.$lastInsertedID;

		$userdata['email'] = $request->input('email');

		$userdata['phone'] = $request->input('phone');

		$userdata['mobile'] = $request->input('mobile');

		$userdata['roleid'] = $request->input('roleid');

		//$userdata['agentid'] =  $request->input('agentid');

		$userdata['created_at'] = date('Y-m-d H:i:s');

        $userdata['updated_at'] = date('Y-m-d H:i:s');

		
       $password = '';
	   if($request->input('password')){
		   
		   $password = $request->input('password');
	   }
		 

		

		$userInsertID = DB::table('userinformation')->insertGetId( $userdata );

	    //return redirect()->route('user', ['id' => $userInsertID,'datas' => 'insert']);
		
		$data = array('name'=>$request->input('name'), 'email'=>$request->input('email'), 'password'=>$password, 'role_name'=>$role_type);
		
		//user
    	
    	$mail = view('mail.Usercreate',$data);
    	
		
    	$to = $request->input('email');
    	$subject = "User Register" ;
    	$message = $mail;
    	$headers  = 'MIME-Version: 1.0' . "\r\n";
    	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    	$headers .= 'From: B2B project <travelinsertinfo@gmail.com>' . "\r\n";
    	mail($to,$subject,$message,$headers);
    	
    	$data = array('name'=>'Admin', 'email'=>$request->input('email'), 'password'=>$password, 'role_name'=>$role_type);
    	$mail = view('mail.admin.Usercreate',$data);
    	$to = 'vasistcompany@gmail.com';
    	$subject = "Agency Register" ;
    	$message = $mail;
    	$headers  = 'MIME-Version: 1.0' . "\r\n";
    	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    	$headers .= 'From: B2B project <travelinsertinfo@gmail.com>' . "\r\n";
    	mail($to,$subject,$message,$headers);

		

		return redirect()->route('userlist',['datas' => 'insert']);

	

		

		

	}



  //User details Update

  

public function Role_List(){

	

	$role= DB::table('role_list')->orderBy('role_list.updated_at', 'DESC')->get();

	

	return $role;	

	}  

	

  

public function userupdate(Request $request)

	{




    if(Auth::user()->user_type == 'AgencyManger'){
		
				
		if(isset($_GET['id']) && !empty($_GET['id'])){
				$id = $_GET['id'];
				 try {
    				$decrypted_id = Crypt::decrypt($id);
    				$decrypted_id = base64_decode($decrypted_id);
    			 } catch (DecryptException $e) {
			
    				return redirect('/home');
    	        }
		}
	
	   $userinformation = DB::table('userinformation')->where('id','=',''.$decrypted_id.'')->get();
	   
	  

	    
		//agecny check 
		
		if(isset($userinformation[0])){
			
			
			if($userinformation[0]->agentid !=0){
				
				$magency =DB::table('agency')->where('id','=',''.$userinformation[0]->agentid.'')->get();
				
				if(isset($magency[0])){
					
					if($magency[0]->loginid !=Auth::user()->id){
						
				            return redirect('/home');
				     }
					
				}
			
			}else{
			
			 return redirect('/home');
			
			}
		}
		
	
	
     }

		$id = $request->input('id');

		

		//$encrypted_id = base64_encode($id);

		$decrypted_id = base64_decode($id);

		//echo $encrypted_id;

	        //$id = $_GET['id'];

		 $decrypted_id = controller::decryptid($id);

		

		$RoleIdPremissions = controller::Role_Permissions();



		$data['Premissions'] = $RoleIdPremissions;

	

		

		$role_details = '';

		

		$role = self::Role_List();

		

		$agency=DB::table('agency')->orderBy('agency.updated_at', 'DESC')->get();

		

		$role_details = DB::table('userinformation')->where('id', '=', $decrypted_id)->get();
		
		if($data['Premissions']['type'] == 'AgencyManger'){
		       $AgencyMangerrole = $role->where('agency_create_user','=','1')->where('id','!=','2')->where('id','!=','1');
			   $data['AgencyMangerrole'] = $AgencyMangerrole;
		   
		   }

		

		if(!empty($role_details[0])){

		}else{

			return redirect('/home');

		}

	    

		$data['user'] = $role_details[0];

		$data['role'] = $role;

		$data['agency'] = $agency;

		

		return view('user.userupdate', $data);

		

	

	}

	

public function userupdatemodify(Request $request)

	{




$validator = $this->validate($request,[

     'name' => 'required|string|max:255',

     'email' => 'required|email',

	 'phone' => 'required',

     'mobile' => 'required',

     'roleid' => 'required',

     'agentid' => 'required',

  ]);

  

  if($request->input('changepassword')){

		$validator1 = $this->validate($request,[

		   'password' => 'required|string|min:6|confirmed',

		]);

	}

		

		

		$decrypted_id1 = controller::decryptid($request->input('userid'));

		

		//exit;

  if($decrypted_id1) {

	

	if($request->input('activestatus')){

			$userdata['activestatus'] = 1;

			} else {

				$userdata['activestatus'] = 0;

				}

    
	    $role_type = 'Admin';

		if($request->input('agent_level')){

			$userdata['agent_level'] = 1;

			$userdata['agentid'] =  $request->input('agentid');

            $role_type = 'Agent';
        
			} else {

				$userdata['agent_level'] = 0;

				$userdata['agentid'] =0;

				}

				

  // $encrypted_id = base64_encode('update');

   //$encrypted_id = base64_encode($request->input('userid'));

  // echo $encrypted_id;

	

   	$lastInsertedID = DB::table('userinformation')->where('id', $decrypted_id1)->update([

   'name'=>$request->input('name'),'email'=>$request->input('email'),'phone'=>$request->input('phone'),'mobile'=>$request->input('mobile'),'activestatus'=>$userdata['activestatus'],'roleid'=>$request->input('roleid'),'agent_level'=>$userdata['agent_level'],'agentid'=>$userdata['agentid']]);

  

   				$password = Hash::make($request->input('password'));

   

   $loginid = DB::table('userinformation')->where('id', '=', $decrypted_id1)->get();



   

				$users = DB::table('users')->where('id', $loginid[0]->loginid)->update(['name'=>$request->input('name'),'email' => $request->input('email'),'activestatus'=>$userdata['activestatus']]);

				

				if($request->input('changepassword')){

					$users = DB::table('users')->where('id', $loginid[0]->loginid)->update(['password' => $password]);
					
					//User password
					
					
					
					
					$data = array('name'=>$request->input('name'), 'email'=>$request->input('email'), 'password'=>$password, 'role_name'=>$role_type);
		
		//user
    	
					$mail = view('mail.Userapssword',$data);
					
					
					$to = $request->input('email');
					$subject = "User Password Updated" ;
					$message = $mail;
					$headers  = 'MIME-Version: 1.0' . "\r\n";
					$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
					$headers .= 'From: B2B project <travelinsertinfo@gmail.com>' . "\r\n";
					mail($to,$subject,$message,$headers);
					
					$data = array('name'=>'Admin', 'email'=>$request->input('email'), 'password'=>$password, 'role_name'=>$role_type);
					$mail = view('mail.admin.Userapssword',$data);
					$to = 'vasistcompany@gmail.com';
					$subject = "User Password Updated" ;
					$message = $mail;
					$headers  = 'MIME-Version: 1.0' . "\r\n";
					$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
					$headers .= 'From: B2B project <travelinsertinfo@gmail.com>' . "\r\n";
					mail($to,$subject,$message,$headers);
					
					
					
					
					

				}

  }

  

  
  
  
  
  

	 return redirect()->route('userupdate', ['id' =>$request->input('userid'),'datas' =>'update']);

	

	}	

	

	

	 

	 

	 

	 

	 

    public function userlist(){

		

		$RoleIdPremissions = controller::Role_Permissions();

	   //print_r($RoleIdPremissions);

	     $data['Premissions'] = $RoleIdPremissions;

		

$products = DB::table('userinformation')

			->select('userinformation.id','userinformation.name','userinformation.roleid','userinformation.agentid','userinformation.userid','userinformation.activestatus','role_list.role_name')

			->join('role_list','role_list.id','=','userinformation.roleid')

			->where('userinformation.delete_status','=', 1)

			->orderBy('userinformation.updated_at', 'DESC');

			

		if($data['Premissions']['type'] == 'AgencyManger'){

			$id = Auth::user()->id;

			$dat = DB::table('agency')->where('loginid', '=', $id)->get();

			$agencyid = '';

				if(isset($dat[0])) {

					$agencyid = $dat[0]->id;

				}

			$products = $products->where('agentid', '=', $agencyid)->get();

		   } else {

			  $products = $products->get(); 

			   }	

			$data['products'] = $products;

			

			if($RoleIdPremissions['type'] == 'UserInfo'){

		    if($RoleIdPremissions['premission'][0]->user_list == 1)

		      {

		     // $data['type'] = 'UserInfo';

		      return view('user.userlist',$data);

		      } else{ 

			  return redirect('/home'); 

			  }

		    } else{

        	

			return view('user.userlist',$data);	

			}

	}

   

 

   public function userdelete(Request $request)

    {

		$activestatus = 0;

		$id = $request->input('id');

		

		$agencyID = DB::table('userinformation')->where('id', $request->input('id'))->update(['activestatus' => $activestatus,'delete_status' => $activestatus]);

		

		$getloginid = DB::table('userinformation')->where('id', '=', $id)->get();

		$loginid = $getloginid[0]->loginid;

		$userID = DB::table('users')->where('id', $loginid)->update(['activestatus' => $activestatus]);

		

		

		

		//$getloginid = DB::table('userinformation')->where('id', '=', $id)->get();



		//$del = DB::table('userinformation')->where('id', '=', $id)->delete();

		

		//if($del > 0 ) {

			//if(isset($getloginid[0]) && !empty($getloginid[0]->loginid)) {

					//$del = DB::table('users')->where('id', '=', $getloginid[0]->loginid)->delete();

				//}

			//}

			//$userInsertID = DB::table('userinformation')->insertGetId( $userdata );

			//return redirect()->route('user', ['id' => $userInsertID,'datas' => 'delete']);

		return redirect()->route('userlist', ['datas1' => 'delete']);

	}

	

	

	

	

	 public function agencyuserlistDetails(Request $request)

    {   

	

	

	

		$agencyid = $id = $request->input('agencyid');

		if($agencyid)

		{

			$products = DB::table('role_list')

			->leftJoin('userinformation', 'role_list.id', '=', 'userinformation.roleid')

			->where('userinformation.agentid','=',$agencyid)

            ->get();

	

	 $count = $products->count();



	 $agency = DB::table('agency')->orderBy('agency.updated_at', 'DESC')->get();



	  if($count > 0 ) {

			$products = $products;

		} else {

			$products = 'No_Users_Found';

			}

		

	 return view('user.agencyuserlist',['agency'=>$agency,'products'=>$products]);	

		

		}else{

			

			

				

				$products = DB::table('role_list')

				->leftJoin('userinformation', 'role_list.id', '=', 'userinformation.roleid')

				->where('userinformation.agent_level','=', 1)

				->offset(0)->limit(10)

				->get();

			

		

	$agency=DB::table('agency')->orderBy('agency.updated_at', 'DESC')->get();

	return view('user.agencyuserlist',['agency'=>$agency,'products'=>$products]);

		}

		

	}

   



   







public function agencyuserlistAjax()

{

	

	

	

	echo "test";

	

}







}





