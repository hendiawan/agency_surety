<?php

namespace App\Http\Controllers;

use PDF;
use Mail;
use App\Mail\Reminder;
use Illuminate\Http\Request;

class SendmailController extends Controller
{
    //
    public function index()
    {
    	return view('kirimemail');
    }
    public function send(Request $request)
    {
    	$data = $request->all();
    	/*\Mail::send('mail.sendtest', ['title' => $data['subject'], 'content' => $data['pesan']], function ($message) use ($data)
        {

            $message->from($data['from'], 'testing email');

            $message->to($data['to']);

        });*/
        Mail::to($data['to'])->send(new Reminder($data));
        
        return back()->with('success','Send Email successfully.');
    }
}
