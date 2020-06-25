<?php
 
namespace App\Traits;

use App\Batch;
use App\ClassDay;
use App\Department;
use App\Period;
use App\Section;
use App\Session;
use Illuminate\Support\Facades\DB;
 
trait GetRoutineTable {
 
    public function getRoutineTable($sessionId, $departmentId, $batchId, $sectionId)
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

        return $response;
    } 
}