<?php

namespace App\Http\Controllers;

use App\Notice;
use Illuminate\Http\Request;
use Mews\Purifier\Facades\Purifier;
use Response;

class NoticeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }
    
    public function showNotice(Request $request, $id)
    {
        $notice = Notice::find($id);
        return Response::json($notice);
    }

    public function storeNotice(Request $request)
    {
        request()->validate(
            [
                'color' => 'required|string',
                'date' => 'required|date',
                'topic' => 'required|string|max:10',
                'title' => 'required|string|max:30',
                'body' => 'required',
            ]
        );

        if ($request->has('id') && $request['id'] !== null) {
            $notice = Notice::find($request['id']);
            $msg  = "Notice updated successfully.";
        } else {
            $notice = new Notice;
            $msg = "Notice created successfully.";
        }

        $notice->color = $request['color'];
        $notice->date = $request['date'];
        $notice->topic = $request['topic'];
        $notice->title = $request['title'];
        $notice->body = Purifier::clean($request['body']);
        $notice->save();

        $response = ['msg' => $msg, 'status' => true, 'data'  => $notice];

        return Response::json($response);
    }

    public function destroyNotice(Request $request, $id)
    {
        $notice = Notice::find($id);
        $notice->delete();

        return Response::json(['msg' => "Notice deleted successfully.", 'status' => true]);
    }
}