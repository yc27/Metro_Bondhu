<?php

namespace App\Http\Controllers;

use App\BusSchedule;
use App\WayPoints;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Response;

class TransportController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function showSchedules()
    {
        return Datatables::of(
            DB::table('bus_schedules')
                ->leftJoin('way_points', 'bus_schedules.id', '=', 'way_points.schedule_id')
                ->groupBy('bus_schedules.id')
                ->select(
                    DB::raw('min(bus_schedules.id) as id'),
                    DB::raw('min(starts_at) as starts_at'),
                    'source',
                    'destination',
                    DB::raw('GROUP_CONCAT(stoppage separator ", ") AS stoppages')
                )
                ->get()
        )->make(true);
    }

    public function storeSchedule(Request $request)
    {
        request()->validate(
            [
                'source' => 'required|string',
                'destination' => 'required|string',
                'starts_at' => 'required'
            ],
            [
                'source.required' => 'Source field can\'t be empty',
                'source.string' => 'Source field should be a string',
                'destination.required' => 'Destination field can\'t be empty',
                'destination.string' => 'Destination field should be a string',
                'starts_at.required' => 'Start Time can\'t be empty',
            ]
        );

        if ($request->has('schedule-id') && $request['schedule-id'] !== null)
        {
            $busSchedule = BusSchedule::find($request['schedule-id']);
        }
        else
        {
            $busSchedule = new BusSchedule();
        }
        
        $busSchedule->source = $request['source'];
        $busSchedule->destination = $request['destination'];
        $busSchedule->starts_at = $request['starts_at'];
        $busSchedule->save();

        $scheduleId = $busSchedule->id;
        WayPoints::where('schedule_id', $scheduleId)->delete();

        if ($request->has('stoppages'))
        {
            foreach ($request['stoppages'] as $stoppage)
            {
                if($stoppage !== null && !empty($stoppage))
                {
                    $way_point = new WayPoints();
                    $way_point->schedule_id = $scheduleId;
                    $way_point->stoppage = $stoppage;
                    $way_point->save();
                }
            }
        }

        $arr = array('msg' => 'Something went wrong. Please try again later', 'status' => false);
        if ($busSchedule->id) {
            $arr = array('msg' => 'Bus Schedule Set Successfully.', 'status' => true);
        }

        return Response::json($arr);
    }

    public function getSchedule($id)
    {
        $schedule = BusSchedule::find($id);
        return Response::json($schedule);
    }

    public function getStoppages($id)
    {
        $stoppages = WayPoints::where('schedule_id', $id)->get('stoppage');
        return Response::json($stoppages);
    }

    public function destroySchedule($id)
    {
        $schedules = BusSchedule::where('id', $id)->delete();

        return Response::json($schedules);
    }
}