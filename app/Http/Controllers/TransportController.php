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
                ->groupBy('starts_at', 'source', 'destination')
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

        $busSchedule = new BusSchedule();
        $busSchedule->source = $request['source'];
        $busSchedule->destination = $request['destination'];
        $busSchedule->starts_at = $request['starts_at'];
        $busSchedule->save();

        if ($request->has('stoppages'))
        {
            $scheduleId = $busSchedule->id;
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
            $arr = array('msg' => 'Successfully created new bus schedule.', 'status' => true);
        }

        return Response()->json($arr);
    }
}