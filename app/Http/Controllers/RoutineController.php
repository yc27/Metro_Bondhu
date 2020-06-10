<?php

namespace App\Http\Controllers;

use App\Batch;
use App\ClassDay;
use App\Department;
use App\Period;
use App\Routine;
use App\Section;
use App\Session;
use App\Subject;
use App\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;
use Response;

class RoutineController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    // Departmets
    public function getDepartments()
    {
        $departments = Department::orderBy('name')->get();
        return Response::json($departments);
    }

    public function storeDepartment(Request $request)
    {
        request()->validate(
            [
                'name' => 'required|string',
                'short-name' => 'required|string'
            ],
            [
                'name.required' => 'Name field can\'t be empty',
                'name.string' => 'Name field should be a string',
                'short-name.required' => 'Short Name field can\'t be empty',
                'short-name.string' => 'Short Name field should be a string'
            ]
        );

        $department = new Department();

        $department->name = $request['name'];
        $department->short_name = $request['short-name'];
        $department->save();

        $data = new Department();
        $data->id = $department->id;
        $data->name = $department->name;
        $data->short_name = $department->short_name;

        $response = ['msg' => 'Something went wrong. Please try again later', 'status' => false];
        if ($department->id) {
            $response = ['msg' => 'Department Added Successfully.', 'status' => true, 'data' => $data];
        }

        return Response::json($response);
    }

    public function destroyDepartment(Request $request, $id)
    {
        $department = Department::find($id);
        $department->delete();

        $response = ['msg' => 'Department Deleted Successfully.', 'status' => true];

        return Response::json($response);
    }

    // Batches
    public function getBatchesId($dept_id)
    {
        $batches = Batch::where('dept_id', $dept_id)->orderBy('batch_no')->get('id');
        return Response::json($batches);
    }
    
    public function getBatches($dept_id)
    {
        $batches = Batch::where('dept_id', $dept_id)->orderBy('batch_no')->get();
        return Response::json($batches);
    }

    public function storeBatch(Request $request)
    {
        request()->validate(
            [
                'dept-id' => 'required|integer|exists:App\Department,id',
                'batch-no' => 'required|integer'
            ],
            [
                'dept-id.required' => 'Department field can\'t be empty',
                'dept-id.integer' => 'Value of Department field must be an integer',
                'dept-id.exists' => 'Department Name does not exists',
                'batch-no.required' => 'Batch No field can\'t be empty',
                'batch-no.integer' => 'Value of Batch No field must be an integer'
            ]
        );

        $batch = new Batch();
        $batch->dept_id = $request['dept-id'];
        $batch->batch_no = $request['batch-no'];
        $batch->save();

        $data = DB::table('batches')
            ->join('departments', 'departments.id', 'batches.dept_id')
            ->where('batches.id', $batch->id)
            ->first(['batches.id', 'name', 'batch_no']);

        $response = ['msg' => 'Something went wrong. Please try again later', 'status' => false];
        if ($batch->id) {
            $response = ['msg' => 'Batch Added Successfully.', 'status' => true, 'data' => $data];
        }

        return Response::json($response);
    }

    public function destroyBatch(Request $request, $id)
    {
        $batch = Batch::find($id);
        $batch->delete();

        $response = ['msg' => 'Batch Deleted Successfully.', 'status' => true];

        return Response::json($response);
    }

    // Sections
    public function getSectionsId($batch_id)
    {
        $sections = Section::where('batch_id', $batch_id)->orderBy('section_no')->get('id');
        return Response::json($sections);
    }

    public function getSections($batch_id)
    {
        $sections = Section::where('batch_id', $batch_id)->orderBy('section_no')->get();
        return Response::json($sections);
    }

    public function storeSection(Request $request)
    {
        request()->validate(
            [
                'dept-id' => 'required|integer|exists:App\Department,id',
                'batch-id' => 'required|integer|exists:App\Batch,id',
                'section-no' => 'required'
            ],
            [
                'dept-id.required' => 'Department field can\'t be empty',
                'dept-id.integer' => 'Value of Department field must be an integer',
                'dept-id.exists' => 'Department Name does not exists',
                'batch-id.required' => 'Batch No field can\'t be empty',
                'batch-id.integer' => 'Value Batch No field must be an integer',
                'batch-id.exists' => 'Batch No does not exists',
                'section-no.required' => 'Section No can\'t be empty'
            ]
        );

        $section = new Section();
        $section->batch_id = $request['batch-id'];
        $section->section_no = $request['section-no'];
        $section->save();

        $data = DB::table('sections')
            ->join('batches', 'batches.id', 'sections.batch_id')
            ->join('departments', 'departments.id', 'batches.dept_id')
            ->where('sections.id', $section->id)
            ->first(['sections.id', 'name', 'batch_no', 'section_no']);

        $response = ['msg' => 'Something went wrong. Please try again later', 'status' => false];
        if ($section->id) {
            $response = ['msg' => 'Section Added Successfully.', 'status' => true, 'data' => $data];
        }

        return Response::json($response);
    }

    public function destroySection(Request $request, $id)
    {
        $section = Section::find($id);
        $section->delete();

        $response = ['msg' => 'Section Deleted Successfully.', 'status' => true];

        return Response::json($response);
    }

    // Teachers
    public function getTeachers()
    {
        $teachers = Teacher::orderBy('name')->get();
        return Response::json($teachers);
    }

    public function storeTeacher(Request $request)
    {
        request()->validate(
            [
                'name' => 'required|string',
                'short-name' => 'required|string'
            ],
            [
                'name.required' => 'Teachers Name field can\'t be empty',
                'name.string' => 'Value of Teachers Name field must be a string',
                'short-name.required' => 'Code Name field can\'t be empty',
                'short-name.string' => 'Value of Code Name field must be a string'
            ]
        );

        $teacher = new Teacher();
        $teacher->name = $request['name'];
        $teacher->short_name = $request['short-name'];
        $teacher->save();

        $data = new Teacher();
        $data->id = $teacher->id;
        $data->name = $teacher->name;
        $data->short_name = $teacher->short_name;

        $response = ['msg' => 'Something went wrong. Please try again later', 'status' => false];
        if ($teacher->id) {
            $response = ['msg' => 'Teacher Added Successfully.', 'status' => true, 'data' => $data];
        }

        return Response::json($response);
    }

    public function destroyTeacher(Request $request, $id)
    {
        $teacher = Teacher::find($id);
        $teacher->delete();

        $response = ['msg' => 'Teacher Deleted Successfully.', 'status' => true];

        return Response::json($response);
    }

    // Subjects
    public function getSubjects()
    {
        $subjects = Subject::orderBy('name')->get();
        return Response::json($subjects);
    }

    public function storeSubject(Request $request)
    {
        request()->validate(
            [
                'name' => 'required|string',
                'short-name' => 'required|string',
                'code' => 'required|string'
            ],
            [
                'name.required' => 'Subject Name field can\'t be empty',
                'name.string' => 'Value of Subject Name field must be a string',
                'short-name.required' => 'Short Name field can\'t be empty',
                'short-name.string' => 'Value of Short Name field must be a string',
                'code.required' => 'Subject Code field can\'t be empty',
                'code.string' => 'Value of Subject Code field must be a string'
            ]
        );

        $subject = new Subject();
        $subject->name = $request['name'];
        $subject->short_name = $request['short-name'];
        $subject->code = $request['code'];
        $subject->save();

        $data = new Subject();
        $data->id = $subject->id;
        $data->code = $subject->code;
        $data->name = $subject->name;
        $data->short_name = $subject->short_name;

        $response = ['msg' => 'Something went wrong. Please try again later', 'status' => false];
        if ($subject->id) {
            $response = ['msg' => 'Subject Added Successfully.', 'status' => true, 'data' => $data];
        }

        return Response::json($response);
    }

    public function destroySubject(Request $request, $id)
    {
        $subject = Subject::find($id);
        $subject->delete();

        $response = ['msg' => 'Subject Deleted Successfully.', 'status' => true];

        return Response::json($response);
    }

    // Periods
    public function storePeriod(Request $request)
    {
        request()->validate(
            [
                'start-time' => 'required|date_format:H:i',
                'end-time' => 'required|date_format:H:i|after:start-time',
            ],
            [
                'start-time.required' => 'Start Time is required',
                'start-time.date' => 'Start Time must be a valid time',
                'start-time.date_format' => 'Start Time does not match the format "hh:mm A"',
                'end-time.required' => 'End Time is required',
                'end-time.date' => 'End Time must be a valid time',
                'end-time.date_format' => 'End Time does not match the format "hh:mm A"',
                'end-time.after' => 'End Time must be after Start Time'
            ]
        );
        $period = new Period();
        $period->start_time = $request['start-time'];
        $period->end_time = $request['end-time'];
        $period->save();

        $data = new Period();
        $data->id = $period->id;
        $data->start_time = \Carbon\Carbon::parse($period->start_time)->format('h:i A');
        $data->end_time = \Carbon\Carbon::parse($period->end_time)->format('h:i A');

        $response = ['msg' => 'Something went wrong. Please try again later', 'status' => false];
        if ($period->id) {
            $response = ['msg' => 'Period Added Successfully.', 'status' => true, 'data' => $data];
        }

        return Response::json($response);
    }

    public function destroyPeriod(Request $request, $id)
    {
        $period = Period::find($id);
        $period->delete();

        $response = ['msg' => 'Period Deleted Successfully.', 'status' => true];

        return Response::json($response);
    }

    // Class Days
    public function storeClassDays(Request $request)
    {
        $classDays = ClassDay::get();
        foreach ($classDays as $classDay) {
            $flag = false;
            foreach ($request->input('class-days') as $setDay) {
                if ($setDay === $classDay->day) {
                    $flag = true;
                    break;
                }
            }
            if ($flag === true) {
                if ($classDay->is_open === 0) {
                    $updateClassDay = ClassDay::find($classDay->id);
                    $updateClassDay->is_open = true;
                    $updateClassDay->save();
                }
            } else {
                if ($classDay->is_open === 1) {
                    $updateClassDay = ClassDay::find($classDay->id);
                    $updateClassDay->is_open = false;
                    $updateClassDay->save();
                }
            }
        }

        $response = ['msg' => 'Class Days Set Successfully.'];
        return Response::json($response);
    }

    // Session
    public function getSessions()
    {
        $sessions = Session::orderBy('session')->get();
        return Response::json($sessions);
    }

    public function storeSession(Request $request)
    {
        request()->validate(
            [
                'year' => 'required',
                'term' => 'required',
            ]
        );

        $session = new Session();
        $session->session = $request['year'] . '-' . $request['term'];
        $session->save();

        $data = new Session();
        $data->id = $session->id;
        $data->session = $session->session;

        $response = ['msg' => 'Something went wrong. Please try again later', 'status' => false];
        if ($session->id) {
            $response = ['msg' => 'Session Added Successfully.', 'status' => true, 'data' => $data];
        }

        return Response::json($response);
    }

    public function destroySession(Request $request, $id)
    {
        $session = Session::find($id);
        $session->delete();

        $response = ['msg' => 'Session Deleted Successfully.', 'status' => true];

        return Response::json($response);
    }

    // Routines
    public function searchRoutine(Request $request)
    {
        request()->validate(
            [
                'session' => 'required|integer|exists:App\Session,id',
                'department' => 'required|integer|exists:App\Department,id',
                'batch' => 'required|integer|exists:App\Batch,id',
                'section' => 'required|integer|exists:App\Section,id',
            ]
        );

        $sessionId = $request["session"];
        $departmentId = $request["department"];
        $batchId = $request["batch"];
        $sectionId = $request["section"];

        $classDays = ClassDay::where('is_open', 1)->get();
        $periods = Period::select(DB::raw('id, TIME_FORMAT(start_time, "%h:%i %p") start_time, TIME_FORMAT(end_time, "%h:%i %p") end_time'))->orderBy('start_time', 'ASC')->get();

        $session = Session::where('id', $sessionId)->first('session');
        $departmentName = Department::where('id', $departmentId)->first('short_name');
        $batchNo = Batch::where('id', $batchId)->first('batch_no');
        $sectionNo = Section::where('id', $sectionId)->first('section_no');

        $rotines = DB::table('routines')
            ->join('sessions', 'sessions.id', 'routines.session_id')
            ->join('class_days', 'class_days.id', 'routines.day_id')
            ->join('sections', 'sections.id', 'routines.section_id')
            ->join('periods', 'periods.id', 'routines.period_id')
            ->join('subjects', 'subjects.id', 'routines.subject_id')
            ->join('teachers', 'teachers.id', 'routines.teacher_id')
            ->join('batches', 'batches.id', 'sections.batch_id')
            ->join('departments', 'departments.id', 'batches.dept_id')
            ->where([
                ['sessions.id', $sessionId],
                ['departments.id', $departmentId],
                ['batches.id', $batchId],
                ['sections.id', $sectionId]
            ])
            ->get(['routines.id as id', 'class_days.id as day', 'periods.id as period', 'subjects.name as subject', 'teachers.name as teacher', 'room']);

        $response = [
            'sessionId' => $sessionId,
            'departmentId' => $departmentId,
            'batchId' => $batchId,
            'sectionId' => $sectionId,
            'session' => $session,
            'departmentName' => $departmentName,
            'batchNo' => $batchNo,
            'sectionNo' => $sectionNo,
            'classDays' => $classDays,
            'periods' => $periods,
            'routines' => $rotines
        ];

        return Response::json($response);
    }

    public function storeRoutine(Request $request)
    {
        request()->validate(
            [
                'session' => 'required|integer|exists:App\Session,id',
                'period' => 'required|integer|exists:App\Period,id',
                'day' => 'required|integer|exists:App\ClassDay,id',
                'section' => 'required|integer|exists:App\Section,id',
                'subject' => 'required|integer|exists:App\Subject,id',
                'teacher' => 'required|integer|exists:App\Teacher,id',
                'room' => 'required|string'
            ]
        );

        $routine = new Routine();
        $routine->session_id = $request["session"];
        $routine->period_id = $request["period"];
        $routine->day_id = $request["day"];
        $routine->section_id = $request["section"];
        $routine->subject_id = $request["subject"];
        $routine->teacher_id = $request["teacher"];
        $routine->room = $request["room"];
        $routine->save();

        $data = DB::table('routines')
            ->join('class_days', 'class_days.id', 'routines.day_id')
            ->join('periods', 'periods.id', 'routines.period_id')
            ->join('subjects', 'subjects.id', 'routines.subject_id')
            ->join('teachers', 'teachers.id', 'routines.teacher_id')
            ->where('routines.id', $routine->id)
            ->first(['routines.id as id', 'routines.session_id as session', 'routines.section_id as section', 'class_days.id as day', 'periods.id as period', 'subjects.name as subject', 'teachers.name as teacher', 'room']);

        $response = ['msg' => 'Something went wrong. Please try again later', 'status' => false];
        if ($routine->id) {
            $response = ['msg' => 'Routine Set Successfully.', 'status' => true, 'data' => $data];
        }

        return Response::json($response);
    }

    public function destroyRoutine(Request $request, $id)
    {
        $routine = Routine::find($id);
        $routine->delete();

        $response = ['msg' => 'Routine Deleted Successfully.', 'status' => true];

        return Response::json($response);
    }

    public function resetRoutine(Request $request, $sessionId, $departmentId, $batchId, $sectionId)
    {
        Routine::where([
            ['session_id', $sessionId],
            ['section_id', $sectionId]
        ])->delete();

        $classDays = ClassDay::where('is_open', 1)->get();
        $periods = Period::select(DB::raw('id, TIME_FORMAT(start_time, "%h:%i %p") start_time, TIME_FORMAT(end_time, "%h:%i %p") end_time'))->orderBy('start_time', 'ASC')->get();

        $session = Session::where('id', $sessionId)->first('session');
        $departmentName = Department::where('id', $departmentId)->first('short_name');
        $batchNo = Batch::where('id', $batchId)->first('batch_no');
        $sectionNo = Section::where('id', $sectionId)->first('section_no');

        $rotines = DB::table('routines')
            ->join('sessions', 'sessions.id', 'routines.session_id')
            ->join('class_days', 'class_days.id', 'routines.day_id')
            ->join('sections', 'sections.id', 'routines.section_id')
            ->join('periods', 'periods.id', 'routines.period_id')
            ->join('subjects', 'subjects.id', 'routines.subject_id')
            ->join('teachers', 'teachers.id', 'routines.teacher_id')
            ->join('batches', 'batches.id', 'sections.batch_id')
            ->join('departments', 'departments.id', 'batches.dept_id')
            ->where([
                ['sessions.id', $sessionId],
                ['departments.id', $departmentId],
                ['batches.id', $batchId],
                ['sections.id', $sectionId]
            ])
            ->get(['routines.id as id', 'class_days.id as day', 'periods.id as period', 'subjects.name as subject', 'teachers.name as teacher', 'room']);

        $response = [
            'sessionId' => $sessionId,
            'departmentId' => $departmentId,
            'batchId' => $batchId,
            'sectionId' => $sectionId,
            'session' => $session,
            'departmentName' => $departmentName,
            'batchNo' => $batchNo,
            'sectionNo' => $sectionNo,
            'classDays' => $classDays,
            'periods' => $periods,
            'routines' => $rotines
        ];

        return Response::json($response);
    }

    public function downloadRoutinePDF(Request $request, $sessionId, $departmentId, $batchId, $sectionId)
    {
        $classDays = ClassDay::where('is_open', 1)->get();
        $periods = Period::orderBy('start_time', 'ASC')->get();

        $session = Session::where('id', $sessionId)->first('session');
        $departmentName = Department::where('id', $departmentId)->first('short_name');
        $batchNo = Batch::where('id', $batchId)->first('batch_no');
        $sectionNo = Section::where('id', $sectionId)->first('section_no');

        $rotines = DB::table('routines')
            ->join('sessions', 'sessions.id', 'routines.session_id')
            ->join('class_days', 'class_days.id', 'routines.day_id')
            ->join('sections', 'sections.id', 'routines.section_id')
            ->join('periods', 'periods.id', 'routines.period_id')
            ->join('subjects', 'subjects.id', 'routines.subject_id')
            ->join('teachers', 'teachers.id', 'routines.teacher_id')
            ->join('batches', 'batches.id', 'sections.batch_id')
            ->join('departments', 'departments.id', 'batches.dept_id')
            ->where([
                ['sessions.id', $sessionId],
                ['departments.id', $departmentId],
                ['batches.id', $batchId],
                ['sections.id', $sectionId]
            ])
            ->get(['routines.id as id', 'class_days.id as day', 'periods.id as period', 'subjects.name as subject', 'teachers.name as teacher', 'room']);

        $response = [
            'sessionId' => $sessionId,
            'departmentId' => $departmentId,
            'batchId' => $batchId,
            'sectionId' => $sectionId,
            'session' => $session,
            'departmentName' => $departmentName,
            'batchNo' => $batchNo,
            'sectionNo' => $sectionNo,
            'classDays' => $classDays,
            'periods' => $periods,
            'routines' => $rotines
        ];

        $pdf = PDF::loadView('admin.routine.pdf', $response);
        return $pdf->download('routine.pdf');

        // return Response::json("PDF of Routine Downloading...");
    }
}