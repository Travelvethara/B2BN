<?php



namespace App\Http\Controllers\Auth;



use App\User;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Validator;

use Illuminate\Foundation\Auth\RegistersUsers;

use Illuminate\Http\Request;

use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\URL;

use Crypt;

use Illuminate\Contracts\Encryption\DecryptException;

use Mail;





class RegisterController extends Controller

{

    /*

    |--------------------------------------------------------------------------

    | Register Controller

    |--------------------------------------------------------------------------

    |

    | This controller handles the registration of new users as well as their

    | validation and creation. By default this controller uses a trait to

    | provide this functionality without requiring any additional code.

    |

    */



    use RegistersUsers;



    /**

     * Where to redirect users after registration.

     *

     * @var string

     */

    



    /**

     * Create a new controller instance.

     *

     * @return void

     */





    /**

     * Get a validator for an incoming registration request.

     *

     * @param  array  $data

     * @return \Illuminate\Contracts\Validation\Validator

     */







    public function index()

    { 

	

	

	   // Agency Signup Frontpage

    	

    	

    	

		

		/*$to = 'maniprakash@travelinsert.com';

    	$subject = "Agency Register" ;

    	$message = 'Test';

    	$headers  = 'MIME-Version: 1.0' . "\r\n";

    	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

    	$headers .= 'From: B2B project <travelinsertinfo@gmail.com>' . "\r\n";

    	$maildf = mail($to,$subject,$message,$headers);

		if(isset($maildf)){

			echo 'Welcome';

		}else{

			echo 'Not Ok';

		}*/

		

		

		

		

		/*$data = array('name'=>'mani','email' => 'maniprakashpalani@gmail.com');

		

		// $data = array('name'=>'Admin','username'=>$agency_products[0]->email);



		

		

		$mail = view('mail.createagencymail',$data);

		$to = 'maniprakashpalani@gmail.com';

		$subject = "Agency Register" ;

		$message = 'Welcome';

	   $headers = "From: B2B project<admin@livebeds.com>\r\n";

       $headers .= "MIME-Version: 1.0\r\n";

       $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

		mail($to,$subject,$mail,$headers);*/

		

    	

    	$data['agency'] = array();

    	

    	$CountryName = controller::CountryName();

    	

    	$data['CountryName'] = $CountryName;

		

		$PakCities =DB::table('PakCities')->get();

		$data['PakCities'] = $PakCities;

		

		/*echo '<pre>';

		print_r($PakCities);

		echo '</pre>';

		exit;*/

    	if(isset($_GET['id']) && !empty($_GET['id']))

    	{

		 //we are taking data from databse and sending to registersignup page 

		 //using this data we can edit

    		

    		$id = $_GET['id'];

    		$decrypted_id = base64_decode($id);

    		

    		$products=DB::table('agency')->where('id','=',''.$decrypted_id.'')->get();

    		

    		

    		if(empty($products[0])){

			  //the data empty means redirect the register page

    			return redirect('/registersignup');

    		}

		  //check agency

    		$data['agency'] = $products[0];

			

    	}	

		

		//the view page for register

    	return view('auth.register',$data);

    }

    

    

    public function signupagencyregister(Request $request)  //Signup New Agency for enduser

    {

      //laravel validation start

  /*    $validator = $this->validate($request,[

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

		//end

		

	

		

		$id = $request->input('agency_id'); 

		    try {

    				$decrypted_id = Crypt::decrypt($id);

    				$decrypted_id = base64_decode($decrypted_id);

    			} 

				catch (DecryptException $e) {

			

    			return redirect('/registersignup');

    			}

		

		

	if ($request->input('agency_id')) {

			

			$lastInsertedID = DB::table('agency')->where('id', $decrypted_id)->update(['aname' => $request->input('aname'),'aemail' => $request->input('aemail'),'address1' => $request->input('address1'),'address2' => $request->input('address2'),'country' => $request->input('country'),'city' => $request->input('city'),'pcode' => $request->input('zip'),'amobile' => $request->input('amobile'),'aphone' => $request->input('aphone'),'awhatsapp' => $request->input('awhatsapp'),'skype' => $request->input('skype'),'website' => $request->input('website'),'rnumber' => $request->input('register_number')]);

		}

		//$encrypted_id = base64_encode($request->input('agency_id'));

		$agency_products= '';

		 $agency_products=DB::table('agency')->where('id','=',''.$decrypted_id.'')->get();

		 $useremail = $agency_products[0]->email;

	//print_r($agency_products);

	    //echo $useremail;

		$data = array('name'=>$agency_products[0]->name,'email' => $agency_products[0]->email);

		$encrypted_id = base64_encode($decrypted_id);

		return redirect()->route('registersignup', ['id' => $encrypted_id,'tab' => '2','datas' => 'insert']);

		//end

		

	

		

		

		

		

		

     

	 

	 

	 }

    

    

    public function signupagencyupdate(Request $request) //Update Agency Informations during signup

    {

		

		

    	

		//laravel validation start

  /*  	$validator = $this->validate($request,[

    		'name' => 'required|string|max:255',

    		'email' => 'required|email',

			'password' => 'required|string|min:6|confirmed',

			 'mphone' => 'required',

    	

    	]);*/

    	

    	

		//laravel validation end

    	//$id = $request->input('agency_id');

		

		   $id1 = $_POST['agency_id'];

		   

		 //we have update the data edit data from register form

		 //start

		 $decrypted_id1 = Crypt::decrypt($id1);

    	 $id = base64_decode($decrypted_id1);



    	if ($request->input('agency_id')) {

			

		$insertdata['name'] = $request->input('name');

    	$insertdata['email'] = $request->input('email');

    	$insertdata['password'] = Hash::make($request->input('password'));

		$insertdata['crybtPassword'] = Crypt::encrypt(base64_encode($request->input('password')));

		///$insertdata['mobile'] = $request->input('mobile');

    	$insertdata['RoleID'] = '2';

    	$Manger = 'AgencyManger';

    	$insertdata['user_type'] = $Manger;

    	$insertdata['activestatus'] = '0';



    	$lastInsertedID = DB::table('users')->insertGetId( $insertdata );

		//user agency add 

		//$lastInsertedID = 1;

    	$agencyInsert['loginid'] = $lastInsertedID;

    	$UserId = 'AGN100'.$lastInsertedID;

		

		

		$aphone = '';

		   $skype = '';

		   $website = '';



             if($request->input('mphone')){

				 

				 $aphone = $request->input('mphone');

				 

				 

			 }

			 

			 

			 if($request->input('skype')){

				 

				 $skype = $request->input('skype');

				 

				 

			 }

	

    		$lastInsertedIDfhfghfghf = DB::table('agency')->where('id', $id)->update(['name' => $request->input('name'),'email' => $request->input('email'),'phone' => $aphone,'mobile' => $request->input('mobile'),'whatapp' => '65756756','mskype' => $skype,'userid' => $UserId,'notification_staus' => '1', 'loginid'=>$lastInsertedID]);

			



			

    	

    		

    	}



        

		$decrypted_id = Crypt::encrypt(base64_encode($id));

		$agen = Crypt::encrypt(base64_encode('agen'));



		$data = array('name'=>$request->input('name'),'email' => $request->input('email'),'id' => $decrypted_id,'us' => $agen);

		

		

		// $data = array('name'=>'Admin','username'=>$agency_products[0]->email);

		

		$mail = view('mail.createagencymail',$data);

		$to = $request->input('email');

		$subject = "Agency Register" ;

		$message = $mail;

	    $headers = "From: B2B project<admin@livebeds.com>\r\n";

       $headers .= "MIME-Version: 1.0\r\n";

       $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

		mail($to,$subject,$message,$headers);

		

		

		//admin

		

		

		//$data = array('name'=>$request->input('name'),'email' => $request->input('email'));



		$data = array('name'=>'Admin','username'=>$request->input('email'));

		

		$mail = view('mail.admin.createagencymail',$data);

		$to = 'maniprakashpalani@gmail.com';

		$subject = "Agency Register" ;

		$message = $mail;

		$headers = "From: B2B project<admin@livebeds.com>\r\n";

       $headers .= "MIME-Version: 1.0\r\n";

       $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

		mail($to,$subject,$message,$headers);

		//end

    	//$encrypted_id = base64_encode($id);

    	return redirect()->route('thankspage');





    	

    }

    

    

    public function signupagencymanager(Request $request)

    {



		$agencyInsert['name'] = '';

    	$agencyInsert['loginid'] = '0';

    	$agencyInsert['userid'] = '';

    	$agencyInsert['email'] = '';

    	$agencyInsert['phone'] = '';

    	$agencyInsert['mobile'] = '';

    	$agencyInsert['whatapp'] = '';

    	$parentid = 0; 

		if($request->input('parentid')){ $parentid = $request->input('parentid');   }

    	if($request->input('isagency')){$parentid = $request->input('agencylevel');  }

    	$agencyInsert['parentagencyid'] = $parentid;

		//empty value insert because we are useing condition at the front end

		//start

		

		

	$aphone = '';

		   $skype = '';

		   $website = '';



             if($request->input('aphone')){

				 

				 $aphone = $request->input('aphone');

				 

				 

			 }

			 if($request->input('skype')){

				 

				 $skype = $request->input('skype');

			 }

			 if($request->input('website')){

				 

				 $website = $request->input('website');

			 }	

		

		

		

		

		

		$agencyInsert['aname'] = $request->input('aname');

		$agencyInsert['aemail'] = $request->input('aemail'); 

    	$agencyInsert['address1'] = $request->input('address1');

    	$agencyInsert['address2'] = $request->input('address2');

    	$agencyInsert['country'] = $request->input('country');

    	$agencyInsert['city'] = $request->input('city');

    	$agencyInsert['pcode'] = $request->input('zip');

    	$agencyInsert['skype'] = $skype;

    	$agencyInsert['website'] = $website;

    	$agencyInsert['rnumber'] = $request->input('register_number');

    	//$agencyInsert['aname'] = $request->input('parentid');

    	//$agencyInsert['aemail'] = $request->input('parentid');

    	$agencyInsert['amobile'] = '';

    	$agencyInsert['aphone'] = $aphone;

    	$agencyInsert['awhatsapp'] = $request->input('awhatsapp');

    	//$agencyInsert['created_at'] = date('Y-m-d H:i:s');

    	//$agencyInsert['updated_at'] = date('Y-m-d H:i:s');

		

		//insert data

		//start

    	$agencyInsertID = DB::table('agency')->insertGetId( $agencyInsert );

    	//$encrypted_id = base64_encode($agencyInsertID);

		//end

		

		echo Crypt::encrypt(base64_encode($agencyInsertID));

		exit;

		

	//return redirect()->route('registersignup', ['id' => $encrypted_id,'tab' => '2','datas' => 'insert']);

    

		//end

    	

    }

    

    

    

}

