<?php


namespace App\Http\Controllers\Mail;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

class MailController extends Controller
{
	

	public function forgotpassword()
		{
			Mail::send(['text' => 'mail'],['name','Cittrarasu'], function($message){
				$message->to('cirarasugk@gmail.com','To Cittrarasu')->subject('B2B Agency');
				$message->from('cittrarasugk@gmail.com','Cittrarasu');
			});
		}
}
