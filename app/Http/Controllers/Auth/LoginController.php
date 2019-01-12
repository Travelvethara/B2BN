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

		

		

        return view('dashBoard');

		

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

		 

		 exit;	

		//view for home page	

        return view('home');

		

	 }

	else

	{

		//view for redirect the page

	   return redirect('/');

		}

    }

	

	

	public function homeSearch()

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

	

	

	

	public function verficationemail()

    {

		

		

			if(isset($_GET['id']) && !empty($_GET['id']) && !empty($_GET['us']))

		       {

				   

				   $emailV = '';

			       $id = $_GET['id'];

			       $us_id = '';

				 try {

    				$decrypted_id = Crypt::decrypt($id);

    				$id = base64_decode($decrypted_id);

    			} catch (DecryptException $e) {

			

    				return redirect('/');

    			}

				

				

				$us = $_GET['us'];

				 try {

    				$us_id_id = Crypt::decrypt($us);

    				$us_id = base64_decode($us_id_id);

    			} catch (DecryptException $e) {

			

    				return redirect('/');

    			}

				

			if($us_id == 'agen'){	

					

					$agency = DB::table('agency')->where('id','=',$id)->where('verificationId','=',0)->get();

				    

					if(!empty($agency[0])){

						

						$emailV =$agency[0]->email;

						

					   DB::table('agency')->where('id', $agency[0]->id)->update(['verificationId' => '1']);

					   //mail sent admin

							$adminemail = DB::select('select * from adminemail where id=1');

							$adminemailid = '';

							if(isset($adminemail[0]->EmailName) && !empty($adminemail[0]->EmailName)){

							

							$adminemailid = $adminemail[0]->EmailName;

							}else{

							$adminemailid = 'vasistcompany@gmail.com';

							}

							$data = array('name'=>'Admin','username'=>$emailV);

							$mail = view('mail.admin.createagencymail',$data);

							$to = $adminemailid;

							$subject = "Agency Register" ;

							$message = $mail;

							$headers = "From: B2B project<admin@livebeds.com>\r\n";

							$headers .= "MIME-Version: 1.0\r\n";

							$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

							mail($to,$subject,$message,$headers);

							

					}

			}

		

		if($us_id == 'user'){

		

		   $userinformation = DB::table('userinformation')->where('loginid','=',$id)->where('verificationId','=',0)->get();

		   

		   





		if(!empty($userinformation[0])){

			

			            $emailV =$userinformation[0]->email;

						

					    DB::table('userinformation')->where('id', $userinformation[0]->id)->update(['verificationId' => '1']);

			            

						    $adminemail = DB::select('select * from adminemail where id=1');

							$adminemailid = '';

							if(isset($adminemail[0]->EmailName) && !empty($adminemail[0]->EmailName)){

							

							$adminemailid = $adminemail[0]->EmailName;

							}else{

							$adminemailid = 'vasistcompany@gmail.com';

							}

							$data = array('name'=>'Admin','username'=>$emailV);

							$mail = view('mail.admin.createagencymail',$data);

							$to = $adminemailid;

							$subject = "User Register" ;

							$message = $mail;

							$headers = "From: B2B project<admin@livebeds.com>\r\n";

							$headers .= "MIME-Version: 1.0\r\n";

							$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

							mail($to,$subject,$message,$headers);

			

			}else{

			 return redirect('/thankspage');

			}

		

		

		}

		if(isset($emailV)){



  $mail ='

<div style="padding:0px" align="center" style="">

      <div style="width:100%;background-color:#282a3c;padding:0px;border-bottom:1px solid #ddd">

        <div style="max-width:580px;padding:0px">

          <table width="100%" style="border-spacing:0">

            <tbody>

              <tr>

                <td style="padding:15px 0px 15px 20px" align="left">

                  <div>

                    <a href=""><img src="'.asset('img/white_logo_default_dark.png').'" alt="" width="130" style="outline:none;display:block" class="CToWUd"></a>

                  </div>

                </td>

                

              </tr>

            </tbody>

          </table>

        </div>

      </div>    <div style="width:100%;background-color:#f2f3f8;padding:50px 0 50px 0;">

      <div style="max-width:578px;padding:0;border-radius:5px;border:1px solid #d6d6d6;box-shadow: 0 1px 15px 1px rgba(69,65,78,.08);">

        

        <table align="center" style="border-spacing:0;font-family:Arial,Helvetica;color:#333333;Margin:0 auto;width:100%;max-width:578px">

          <tbody>

            <tr>

              <td style="padding:0px;border-radius:5px 5px 5px 5px;background-color:#ffffff;" align="center">  

                <table width="100%" style="border-spacing:0">

                  <tbody>

                    <tr>

                      <td align="left" style="padding:20px 20px 20px 20px">

                        <div style="font-family:Arial Black,Arial,Helvetica;font-size:18px;line-height:30px;font-weight:700">Hi ,</div>

                      </td>

                    </tr>

                   

                    <tr>

                      <td align="left" style="padding:0px 20px 20px 20px">

                         

                      </td>

                    </tr>

                    <tr>

                      <td align="left" style="padding:0px 20px 20px 20px">

                        <div style="font-family:Arial,Helvetica;font-size:15px;line-height:22px">Your email verification sucessfully. You will contact Administrator.</div>

                      </td>

                    </tr>             

                     <tr>

                      <td></td>

                    </tr>

                           <tr>

                      <td align="left" style="padding:0px 20px 10px 20px">

                        <div style="font-family:Arial,Helvetica;font-size:15px;line-height:22px">In case of any queries, please <a href="">contact us</a>.</div>

                      </td>

                    </tr>

                    <tr>

                      <td style="padding:0px 20px 20px 20px">

                        <div style="font-family:Arial,Helvetica;font-size:15px;color:#555">B2B project</div>

                      </td>

                    </tr>

                    

                    

                    

                  </tbody>

                </table>

              </td>

            </tr>

          </tbody>

        </table>

        

      </div>

    </div>

    </div>';



		$to = $userinformation[0]->email;

		$subject = "B2B Email Verification Sucessfully" ;

		$message = $mail;

		$headers = "From: B2B project<admin@livebeds.com>\r\n";

        $headers .= "MIME-Version: 1.0\r\n";

        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

		mail($to,$subject,$message,$headers);

		

		}

        return redirect('/thankspage');

		exit;



		}

		

		

		

		return redirect('/');

		

		

		

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





public function forgetpassowrdlogin()

    {

		

		$useremail = $_GET['useremail'];

	

		

		

		$agencycredit_update = DB::table('users')->where('activestatus','=',1)->where('email','=',$useremail)->get();



		

		if(empty($agencycredit_update[0])){

		echo 'faild';	

		}else{

		$route_url = route('forgetpage');

		$id_url  = Crypt::encrypt(base64_encode($agencycredit_update[0]->id));

		$url = $route_url.'?id='.$id_url;

	    $url;

	    $id = $id_url;

		$name = $agencycredit_update[0]->name;

		$url = $url;

		//$mail = view('mail.password.forgetpassword_mail',$data);

		

		$mail ='

<div style="padding:0px" align="center" style="">

      <div style="width:100%;background-color:#282a3c;padding:0px;border-bottom:1px solid #ddd">

        <div style="max-width:580px;padding:0px">

          <table width="100%" style="border-spacing:0">

            <tbody>

              <tr>

                <td style="padding:15px 0px 15px 20px" align="left">

                  <div>

                    <a href=""><img src="http://23.229.195.196/test/public/img/white_logo_default_dark.png" alt="" width="130" style="outline:none;display:block" class="CToWUd"></a>

                  </div>

                </td>

                

              </tr>

            </tbody>

          </table>

        </div>

      </div>    <div style="width:100%;background-color:#f2f3f8;padding:50px 0 50px 0;">

      <div style="max-width:578px;padding:0;border-radius:5px;border:1px solid #d6d6d6;box-shadow: 0 1px 15px 1px rgba(69,65,78,.08);">

        

        <table align="center" style="border-spacing:0;font-family:Arial,Helvetica;color:#333333;Margin:0 auto;width:100%;max-width:578px">

          <tbody>

            <tr>

              <td style="padding:0px;border-radius:5px 5px 5px 5px;background-color:#ffffff;" align="center">  

                <table width="100%" style="border-spacing:0">

                  <tbody>

                    <tr>

                      <td align="left" style="padding:20px 20px 20px 20px">

                        <div style="font-family:Arial Black,Arial,Helvetica;font-size:18px;line-height:30px;font-weight:700">Hi ,</div>

                      </td>

                    </tr>

                   

                    <tr>

                      <td align="left" style="padding:0px 20px 20px 20px">

                         

                      </td>

                    </tr>

                    <tr>

                      <td align="left" style="padding:0px 20px 20px 20px">

                        <div style="font-family:Arial,Helvetica;font-size:15px;line-height:22px">You recently requested to reset password for your account click the button below to reset it.</div>

                      </td>

                    </tr>             

                     <tr>

                      <td><a href="'.$url.'"><button id="" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn m-login__btn--primary loginhome">

											Click

										</button></a></td>

                    </tr>

                           <tr>

                      <td align="left" style="padding:0px 20px 10px 20px">

                        <div style="font-family:Arial,Helvetica;font-size:15px;line-height:22px">In case of any queries, please <a href="">contact us</a>.</div>

                      </td>

                    </tr>

                    <tr>

                      <td style="padding:0px 20px 20px 20px">

                        <div style="font-family:Arial,Helvetica;font-size:15px;color:#555">B2B project</div>

                      </td>

                    </tr>

                    

                    

                    

                  </tbody>

                </table>

              </td>

            </tr>

          </tbody>

        </table>

        

      </div>

    </div>

    </div>';

		

		

		

		

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











	

	

	

	

}

