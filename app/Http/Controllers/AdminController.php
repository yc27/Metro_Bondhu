<?php

namespace App\Http\Controllers;

use App\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{    
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function index(Request $request)
    {
        $unseen_message_count = Message::where('is_opened', '0')->count();
        $seen_messages = Message::where('is_opened', '1')->orderBy('created_at', 'ASC')->paginate(5);
        $unseen_messages = Message::where('is_opened', '0')->orderBy('created_at', 'DESC')->paginate(5);
        
        DB::table('messages')->where('is_opened', '0')->orderBy('created_at', 'DESC')->limit(5)->update(['is_opened' => '1']);
        
        return view('admin.dashboard', ['unseen_message_count' => $unseen_message_count, 'seen_messages' => $seen_messages, 'unseen_messages' => $unseen_messages]);
    }

    public function destroySeenMessage(Request $request, $id)
    {
        $message = Message::find($id);
        $message->delete();

        $unread_message_count = Message::where('is_opened', '0')->count();
        $message_read = Message::where('is_opened', '1')->orderBy('created_at', 'ASC')->paginate(5);
        $message_unread = Message::where('is_opened', '0')->orderBy('created_at', 'DESC')->paginate(5);
        
        DB::table('messages')->where('is_opened', '0')->orderBy('created_at', 'DESC')->limit(5)->update(['is_opened' => '1']);
        
        return view('admin.inbox.unreadMessages', ['unread_message_count' => $unread_message_count, 'message_read' => $message_read, 'message_unread' => $message_unread]);
    }
}