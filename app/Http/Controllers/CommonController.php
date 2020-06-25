<?php

namespace App\Http\Controllers;

use App\Batch;
use App\Department;
use App\Section;
use App\Session;
use App\Traits\GetRoutineTable;
use Illuminate\Http\Request;
use PDF;
use Response;

class CommonController extends Controller
{
    use GetRoutineTable;
    
    public function getDepartments()
    {
        $departments = Department::orderBy('name')->get();
        return Response::json($departments);
    }
    
    public function getBatches($dept_id)
    {
        $batches = Batch::where('dept_id', $dept_id)->orderBy('batch_no')->get();
        return Response::json($batches);
    }

    public function getSections($batch_id)
    {
        $sections = Section::where('batch_id', $batch_id)->orderBy('section_no')->get();
        return Response::json($sections);
    }

    public function getSessions()
    {
        $sessions = Session::orderBy('session')->get();
        return Response::json($sessions);
    }

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

        return Response::json($this->getRoutineTable($sessionId, $departmentId, $batchId, $sectionId));
    }

    public function downloadRoutinePDF(Request $request, $sessionId, $departmentId, $batchId, $sectionId)
    {
        $pdf = PDF::loadView('admin.routine.pdf', $this->getRoutineTable($sessionId, $departmentId, $batchId, $sectionId));

        return $pdf->download('routine.pdf');
    }
}