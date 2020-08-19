<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use App\Jobs\UserExpiration;
use App\Mail\TestMail;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class TestController extends Controller
{
    public function sendMail() 
    {
       $emails = User::chunk(50,function($data){
        dispatch(new UserExpiration($data));
       });
       return "Success";
    }
}
