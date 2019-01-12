<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
   if (Auth::check()){
	   return redirect('/home');
   }else{
	   
	return view('auth.login');
   }
});







Auth::routes();

//Forget Page







Route::post('/whologin', 'Auth\LoginController@whologin')->name('whologin');
Route::get('/forgetpage', 'Auth\LoginController@forgetpage')->name('forgetpage');


Route::get('/login', 'Auth\LoginController@loginpage')->name('login');


Route::get('/currenyconverter', 'HomeController@currenyconverter')->name('currenyconverter');
Route::get('/currenyconvertercheck', 'HomeController@currenyconvertercheck')->name('currenyconvertercheck');


Route::post('/forgetpage', 'Auth\LoginController@forgetpagePost')->name('forgetpage');

Route::get('/handlelogin', 'Auth\LoginController@credentials')->name('handlelogin');

//reset password
Route::get('/forgetpassowrds', 'Auth\LoginController@forgetpassowrds')->name('forgetpassowrds');

Route::get('/forgetpassowrdlogin', 'Auth\LoginController@forgetpassowrdlogin')->name('forgetpassowrdlogin');



Route::get('/resetpassword', 'Auth\LoginController@reset_password')->name('resetpassword');

Route::get('/thankspage', 'Auth\LoginController@thankspage')->name('thankspage');

Route::post('/agency', 'Agency\AgencyController@agencystore')->name('agency.agencystore');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/hotelsearch', 'HomeController@homeSearch')->name('hotelsearch');


Route::get('/hotelsearchn', 'Hotel\HotelController@hotelsearchn')->name('hotelsearchn');


Route::get('/dashboardcharturl', 'HomeController@dashboardCharturl')->name('dashboardcharturl');

Route::post('/agency', 'Agency\AgencyController@agencystore')->name('agency.agencystore');

Route::post('/agencyupdate', 'Agency\AgencyController@agencyupdate')->name('agency.agencyupdate');

Route::get('/viewagency', 'Agency\AgencyController@viewagency')->name('agency.viewagency');

Route::post('/updateagency', 'Agency\AgencyController@updateagency')->name('agency.updateagency');

Route::get('/sendmail', 'Agency\AgencyController@sendmail')->name('sendmail');

Route::post('/agencymanager', 'Agency\AgencyController@agencymanager')->name('agency.agencymanager');

Route::post('/agencyregister', 'Auth\RegisterController@agencyregister')->name('agency.agencyregister');

Route::get('/agency', 'Agency\AgencyController@index')->name('agency');

Route::get('/agencylist','Agency\AgencylistController@index')->name('agencylist');

Route::get('/subagencylist','Agency\AgencylistController@subagencylist')->name('subagencylist');

Route::get('/agencylistLoadMoreAjax','Agency\AgencylistController@agencyListLoadMore');

Route::post('/agencydelete','Agency\AgencylistController@agencyDelete')->name('agency.agencyDelete');

Route::post('/singnupagencyregister', 'Auth\RegisterController@signupagencyregister')->name('signupagencyregister');

Route::post('/singnupupdateagency', 'Auth\RegisterController@signupagencyupdate')->name('signupagencyupdate');

Route::post('/signupagencymanager', 'Auth\RegisterController@signupagencymanager')->name('signupagencymanager');

//Agency Booking details


Route::get('/agencyBookingdetails','Agency\AgencylistController@agency_bookdetails')->name('agencyBookingdetails');

Route::get('/agencyUnBookingdetails','Agency\AgencylistController@agency_Unbookdetails')->name('agencyUnBookingdetails');

Route::get('/agencyCancellaedBookdetails','Agency\AgencylistController@agency_Cancelleddetails')->name('agencyCancellaedBookdetails');


//role
Route::get('/role', 'Role\RoleController@index')->name('role');

Route::get('/rolelist', 'Role\RoleController@rolelist')->name('rolelist');

Route::post('/rolei', 'Role\RoleController@roleinsert')->name('role.roleinsert');

Route::post('/roleu', 'Role\RoleController@roleupdate')->name('role.roleupdate');

Route::post('/roled', 'Role\RoleController@RoleDelete')->name('role.RoleDelete');

Route::get('/getuserRoleforAgency', 'Role\RoleController@getuserRoleforAgency')->name('role.getuserRoleforAgency');

//profile
Route::get('/profile', 'Profile\ProfileController@index')->name('profile');

Route::post('/profileupdate', 'Profile\ProfileController@profileupdate')->name('profile.profileupdate');

//User
Route::get('/user', 'User\UserController@index')->name('user');

Route::post('/user', 'User\UserController@userinsert')->name('userinsert');

Route::get('/userupdate', 'User\UserController@userupdate')->name('userupdate');

Route::post('/userupdate', 'User\UserController@userupdatemodify')->name('userupdate');

Route::get('/userlist','User\UserController@userlist')->name('userlist');

Route::post('/userdelete', 'User\UserController@userdelete')->name('userdelete');

Route::get('/agencyuserlist', 'User\UserController@agencyuserlistDetails')->name('agencyuserlistDetails');

Route::get('/agencyuserlistAjax','Agency\AgencylistController@agencyuserlistAjax');

Route::get('/get_forgot_password_value','Auth\LoginController@get_forgot_password_value');

//notification

Route::get('/notification', 'Notification\NotificationController@index')->name('notification');



Route::get('/loginnotification', 'Notification\NotificationController@loginnotification')->name('loginnotification');

//signup
Route::get('/registersignup', 'Auth\RegisterController@index')->name('registersignup');

Route::post('/notificationagencttrash', 'Notification\NotificationController@notificationagencytrash')->name('notificationagencytrash');

//forgotpassword 
Route::get('/forgotpassword','MailController@forgotpassword')->name('forgotpassword');

//hotel
Route::get('/homesearch', 'Hotel\HotelController@homesearch')->name('homesearch');

Route::get('/payment', 'Hotel\HotelController@payment')->name('payment');

Route::get('/tboPayment', 'Hotel\HotelController@tboPayment')->name('tboPayment');


Route::get('/errorbooking', 'Hotel\HotelController@errorbooking')->name('errorbooking');

Route::post('/payment', 'Hotel\HotelController@ajaxhotelpayment')->name('payment');



Route::get('/hotellist', 'Hotel\HotelController@hotellist')->name('hotellist');

Route::get('/hoteldetail', 'Hotel\HotelController@hoteldetail')->name('hoteldetail');

//hotel ajax
Route::get('/ajaxhotellist', 'Hotel\HotelController@ajaxhotellist')->name('ajaxhotellist');

Route::post('/invoicepayment', 'Bookingreport\BookingreportController@invoicepayment')->name('invoicepayment');
Route::post('/invoicepaymentemail', 'Bookingreport\BookingreportController@invoicepaymentemail')->name('invoicepaymentemail');

Route::post('/mailsentpayment', 'Bookingreport\BookingreportController@mailsentpayment')->name('mailsentpayment');


Route::get('/ajaxbookingcheck', 'Bookingreport\BookingreportController@ajaxbookingcheck')->name('ajaxbookingcheck');

//booking report
Route::post('/ajaxhotelpayment', 'Hotel\HotelController@ajaxhotelpayment')->name('ajaxhotelpayment');

Route::post('/ajaxhotelpaymenttbo', 'Hotel\HotelController@ajaxhotelpaymenttbo')->name('ajaxhotelpaymenttbo');


Route::get('/vouchecdbooking', 'Bookingreport\BookingreportController@vouchecd_booking')->name('vouchecdbooking');

Route::get('/unvouchecdbooking', 'Bookingreport\BookingreportController@unvouchecd_booking')->name('unvouchecdbooking');

Route::get('/cancelled_booking', 'Bookingreport\BookingreportController@cancelled_booking')->name('cancelledbooking');

Route::get('/agentbooking', 'Bookingreport\BookingreportController@agentbooking')->name('agentbooking');
Route::get('/agentbookingwise', 'Bookingreport\BookingreportController@agentbookingwise')->name('agentbookingwise');

Route::post('/BookingCancellation','Hotel\HotelController@BookingCancellation')->name('cancellation.BookingCancellation');




Route::get('/confirmationpage', 'Hotel\HotelController@confirmationpage')->name('confirmation');


Route::get('/confirmation-pending', 'Hotel\HotelController@confirmation_pending_page')->name('confirmation-pending');

//admin email

Route::get('/adminemail', 'HomeController@adminemailc')->name('adminemail');


Route::post('/emailupdate', 'HomeController@emailupdate')->name('emailupdate');

//ajax

Route::get('/Cancellationpoilcyajax', 'Hotel\HotelController@Cancellationpoilcyajax')->name('Cancellationpoilcyajax');



Route::get('/updateajx', 'HomeController@updateajx')->name('updateajx');
Route::get('/updateDetailajax', 'Hotel\HotelController@updateDetailajax')->name('updateDetailajax');



Route::post('/agencyInsertAjax', 'Agency\AgencyController@agencyInsertAjax')->name('agencyInsertAjax');

Route::post('/agencyInsertAjaxValidate', 'Agency\AgencyController@agencyInsertAjaxValidate')->name('agencyInsertAjaxValidate');
Route::post('/paybookingurl', 'Bookingreport\BookingreportController@paybookingurl')->name('paybookingurl');



Route::post('/voucherpaymentemail', 'Bookingreport\BookingreportController@voucherpaymentemail')->name('voucherpaymentemail');
Route::post('/voucherpayment', 'Bookingreport\BookingreportController@voucherpayment')->name('voucherpayment');
Route::post('/vouchertemplate', 'Bookingreport\BookingreportController@vouchertemplate')->name('vouchertemplate');


//whologin


//invoice generate

Route::get('/admininvoicebooking', 'Bookingreport\BookingreportController@admininvoicebooking')->name('admininvoicebooking');

Route::get('/agentinvoicebooking', 'Bookingreport\BookingreportController@agentinvoicebooking')->name('agentinvoicebooking');
Route::post('/invoicetemplate', 'Bookingreport\BookingreportController@invoicetemplate')->name('invoicetemplate');
Route::post('/sendtemplate', 'Bookingreport\BookingreportController@sendtemplate')->name('sendtemplate');



//admn portal

Route::get('/adminApicontrol', 'Profile\ProfileController@adminApicontrol')->name('adminApicontrol');

Route::post('/adminApicontrolupdate', 'Profile\ProfileController@adminApicontrolupdate')->name('adminApicontrolupdate');

//ApiproFileData

Route::get('/apiprofiledata', 'Profile\ProfileController@apiprofiledata')->name('apiprofiledata');
//update

Route::post('/apiprofiledataupdate', 'Profile\ProfileController@apiprofiledataupdate')->name('apiprofiledataupdate');

//ajax
Route::get('/apiprofiledataajax', 'Profile\ProfileController@apiprofiledataajax')->name('apiprofiledataajax');


Route::get('/agencyddetailbookingreport', 'Bookingreport\BookingreportController@agencyddetailbookingreport')->name('agencyddetailbookingreport');

Route::get('/verficationemail', 'Auth\LoginController@verficationemail')->name('verficationemail');


Route::get('/errorpage', 'Profile\ProfileController@errorpage')->name('errorpage');










