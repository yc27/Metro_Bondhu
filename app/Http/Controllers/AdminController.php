<?php

namespace App\Http\Controllers;

use App\Message;
use Illuminate\Http\Request;
use Response;

class AdminController extends Controller
{    
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function index(Request $request)
    {
        $unseen_messages_count = Message::where('is_opened', '0')->count();
        $messages = Message::orderBy('is_opened', 'ASC')->orderBy('created_at', 'DESC')->paginate(5);
        
        return view('admin.dashboard', ['unseen_messages_count' => $unseen_messages_count, 'messages' => $messages]);
    }
    
    public function viewMessage(Request $request, $id)
    {
        $message = Message::find($id);        
        $message->is_opened = 1;
        $message->save();
        
        $unseen_messages_count = Message::where('is_opened', '0')->count();

        $arr = array('unseen_messages_count' => $unseen_messages_count, 'message' => $message);
        
        return Response::json($arr);
    }

    public function markMessage(Request $request, $id)
    {
        $message = Message::find($id);
        $message->is_opened = ! $message->is_opened;
        $message->save();
        
        $unseen_messages_count = Message::where('is_opened', '0')->count();

        $arr = array('unseen_messages_count' => $unseen_messages_count, 'message' => $message);
        
        return Response::json($arr);
    }

    public function destroyMessage(Request $request, $id)
    {
        $message = Message::find($id);
        $message->delete();

        $unseen_messages_count = Message::where('is_opened', '0')->count();
        return Response::json($unseen_messages_count);
    }
}