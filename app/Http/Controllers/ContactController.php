<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Mail\Mailable;
use Mail;
use App\Mail\ContactMail;

class ContactController extends Controller
{
    public function contact(){
        
        return view('contact');
    }
    public function sendMail(){
        $name = request('name');
        $email = request('email');
        $body = request('body');
        Mail::to($email)->send(new ContactMail($name, $email, $body));
        return redirect()->route('contact')->with('success','Da gui mail thanh cong');
    }
}
