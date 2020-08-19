<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use App\Mail\TestMail;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UsersController extends Controller
{
    public function sendMail() 
    {
       $emails = User::select('email')->get();
       foreach($emails as $email){
           Mail::to($email)->send(new TestMail);
       }
       return "Success";
    }
}
