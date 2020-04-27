<?php

namespace App\Http\Controllers;

use App\Message;
use Illuminate\Http\Request;
use Mews\Purifier\Facades\Purifier;
use Response;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['guest']);
    }

    public function index()
    {
        return view('home');
    }

    public function storeMessage(Request $request)
    {
        request()->validate(
            [
                'name' => 'required|string',
                'email' => 'required|email',
                'message' => 'required'
            ],
            [
                'name.required' => 'Name field can\'t be empty',
                'name.string' => 'Name field should be a string',
                'email.required' => 'Email field can\'t be empty',
                'email.email' => 'Enter a valid email address.',
                'message.required' => 'Message field can\'t be empty',
            ]
        );
        
        $message = new Message();
        $message->name = $request['name'];
        $message->email = $request['email'];
        $message->message = Purifier::clean($request['message']);
        $message->is_opened = false;
        $message->save();
        
        $arr = array('msg' => 'Your message sent to admins.', 'status' => true);
        return Response::json($arr);
    }
}