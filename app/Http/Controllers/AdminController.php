<?php

namespace App\Http\Controllers;

use App\ClassDay;
use App\Department;
use App\Message;
use App\Period;
use App\Session;
use App\Subject;
use App\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Response;

class AdminController extends Controller
{    
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function index()
    {
        $unseen_messages_count = Message::where('is_opened', '0')->count();
        $messages = Message::orderBy('is_opened', 'ASC')->orderBy('created_at', 'DESC')->paginate(5);

        $departments = Department::orderBY('name')->get();
        $batches = DB::table('batches')
                    ->join('departments', 'departments.id', 'batches.dept_id')
                    ->orderBy('name')
                    ->orderBy('batch_no')
                    ->get(['batches.id', 'name', 'batch_no']);
        $sections = DB::table('sections')
                    ->join('batches', 'batches.id', 'sections.batch_id')
                    ->join('departments', 'departments.id', 'batches.dept_id')
                    ->orderBy('name')
                    ->orderBy('batch_no')
                    ->orderBy('section_no')
                    ->get(['sections.id', 'name', 'batch_no', 'section_no']);;
        $subjects = Subject::orderBy('name')->get();
        $teachers = Teacher::orderBy('name')->get();
        $periods = Period::select(
                DB::raw('id, TIME_FORMAT(start_time, "%h:%i %p") start_time, TIME_FORMAT(end_time, "%h:%i %p") end_time')
            )->orderBy('start_time')->get();
        $classDays = ClassDay::get();
        $sessions = Session::orderBy('session')->get();

        if(request()->ajax()) {
            return Response::json(View::make(
                'admin.inbox.messages',
                [
                    'unseen_messages_count' => $unseen_messages_count,
                    'messages' => $messages
                ]
            )->render());
        }
        
        return view(
            'admin.dashboard',
            [
                'unseen_messages_count' => $unseen_messages_count,
                'messages' => $messages,
                'departments' => $departments,
                'batches' => $batches,
                'sections' => $sections,
                'subjects' => $subjects,
                'teachers' => $teachers,
                'periods' => $periods,
                'classDays' => $classDays,
                'sessions' => $sessions
            ]
        );
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