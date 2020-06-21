<?php

namespace App\Http\Controllers;

use App\ClassDay;
use App\Department;
use App\Message;
use App\Notice;
use App\Period;
use App\Session;
use App\Subject;
use App\Teacher;
use App\User;
use Illuminate\Support\Facades\Auth;
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
        $messages = Message::orderBy('is_opened', 'ASC')->orderBy('created_at', 'DESC')->paginate(10);

        if (request()->ajax()) {
            return Response::json(View::make(
                'admin.inbox.messages',
                [
                    'from_search' => false,
                    'unseen_messages_count' => $unseen_messages_count,
                    'messages' => $messages
                ]
            )->render());
        }

        $user = User::find(Auth::user()->id);
        
        $notices = Notice::orderBy('date')->get();

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
        $periods = Period::orderBy('start_time', 'ASC')->get();
        $classDays = ClassDay::get();
        $sessions = Session::orderBy('session')->get();

        $admins = DB::table('users as u1')
            ->select('u1.id as id', 'u1.name as name', 'u1.email as email', 'u1.mobile_no', 'u1.photo', 'u1.email_verified_at', 'u1.created_at', 'u2.name as inviter')
            ->leftJoin('invitations as i', 'i.email', '=', 'u1.email')
            ->leftJoin('users as u2', 'u2.id', '=', 'i.inviter_id')
            ->orderBy('u1.id')
            ->get();

        return view(
            'admin.dashboard',
            [
                'from_search' => false,
                'unseen_messages_count' => $unseen_messages_count,
                'messages' => $messages,
                'user' => $user,
                'notices' => $notices,
                'departments' => $departments,
                'batches' => $batches,
                'sections' => $sections,
                'subjects' => $subjects,
                'teachers' => $teachers,
                'periods' => $periods,
                'classDays' => $classDays,
                'sessions' => $sessions,
                'admins' => $admins
            ]
        );
    }
}