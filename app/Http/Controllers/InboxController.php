<?php

namespace App\Http\Controllers;

use App\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Mews\Purifier\Facades\Purifier;
use Response;

class InboxController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
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
        $message->is_opened = !$message->is_opened;
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

    public function destroyAllMessage(Request $request)
    {
        $ids = explode(",", $request->ids);
        Message::find($ids)->each(function ($message, $key) {
            $message->delete();
        });

        $unseen_messages_count = Message::where('is_opened', '0')->count();

        $response = ['unseen_messages_count' => $unseen_messages_count, 'msg' => "Selected " . count($ids) . " messages deleted successfully."];
        return Response::json($response);
    }

    public function searchMessage(Request $request)
    {
        $query = Purifier::clean($request['query']);
        $messages = Message::where('name', 'LIKE', '%' . $query . '%')
            ->orWhere('email', 'LIKE', '%' . $query . '%')
            ->orWhere('message', 'LIKE', '%' . $query . '%')
            ->orderBy('is_opened', 'ASC')
            ->orderBy('created_at', 'DESC')
            ->paginate(10);

        $unseen_messages_count = Message::where('is_opened', '0')->count();

        return Response::json(View::make(
            'admin.inbox.messages',
            [
                'from_search' => true,
                'unseen_messages_count' => $unseen_messages_count,
                'messages' => $messages
            ]
        )->render());
    }

    public function resetSearchMessage(Request $request)
    {
        $messages = Message::orderBy('is_opened', 'ASC')->orderBy('created_at', 'DESC')->paginate(10);

        $unseen_messages_count = Message::where('is_opened', '0')->count();

        return Response::json(View::make(
            'admin.inbox.messages',
            [
                'from_search' => false,
                'unseen_messages_count' => $unseen_messages_count,
                'messages' => $messages
            ]
        )->render());
    }
}