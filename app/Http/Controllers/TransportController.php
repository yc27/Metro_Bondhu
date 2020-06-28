<?php

namespace App\Http\Controllers;

use App\BusSchedule;
use App\Route;
use App\Stoppage;
use App\WayPoint;
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
                ->leftJoin('stoppages', 'bus_schedules.id', '=', 'stoppages.schedule_id')
                ->groupBy('bus_schedules.id')
                ->select(
                    DB::raw('min(bus_schedules.id) as id'),
                    DB::raw('min(starts_at) as starts_at'),
                    'source',
                    'destination',
                    DB::raw('GROUP_CONCAT(stoppage separator ", ") AS stoppages')
                )
                ->get()
        )
            ->setRowId(function ($schedule) {
                return "Schedule-Id-" . $schedule->id;
            })
            ->make(true);
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

        if ($request->has('schedule-id') && $request['schedule-id'] !== null) {
            $busSchedule = BusSchedule::find($request['schedule-id']);
        } else {
            $busSchedule = new BusSchedule();
        }

        $busSchedule->source = $request['source'];
        $busSchedule->destination = $request['destination'];
        $busSchedule->starts_at = $request['starts_at'];
        $busSchedule->save();

        $scheduleId = $busSchedule->id;
        Stoppage::where('schedule_id', $scheduleId)->delete();

        if ($request->has('stoppages')) {
            foreach ($request['stoppages'] as $stoppage) {
                if ($stoppage !== null && !empty($stoppage)) {
                    $way_point = new Stoppage();
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
        $stoppages = Stoppage::where('schedule_id', $id)->get('stoppage');
        return Response::json($stoppages);
    }

    public function destroySchedule($id)
    {
        $schedules = BusSchedule::where('id', $id)->delete();

        return Response::json($schedules);
    }

    public function showRoutes()
    {
        return Datatables::of(
            DB::table('routes')
                ->leftJoin('way_points', 'routes.id', '=', 'way_points.route_id')
                ->groupBy('routes.id')
                ->select(
                    DB::raw('min(routes.id) as id'),
                    'source_lat',
                    'source_lng',
                    'destination_lat',
                    'destination_lng',
                    DB::raw('GROUP_CONCAT("(", way_point_lng, ", ", way_point_lat, ")" separator " | ") AS way_points')
                )
                ->get()
        )
            ->setRowId(function ($route) {
                return "Route-Id-" . $route->id;
            })
            ->make(true);
    }

    public function getRoutes()
    {
        $routes = DB::table('routes')
            ->leftJoin('way_points', 'routes.id', '=', 'way_points.route_id')
            ->groupBy('routes.id')
            ->select(
                DB::raw('min(routes.id) as id'),
                'source_lat',
                'source_lng',
                'destination_lat',
                'destination_lng',
                DB::raw('GROUP_CONCAT(way_point_lng, ",", way_point_lat separator ";") AS way_points')
            )
            ->get();

        return Response::json($routes);
    }

    public function storeRoute(Request $request)
    {
        request()->validate(
            [
                'start-lat' => 'required|numeric|min:-90|max:90',
                'start-lng' => 'required|numeric|min:-180|max:180',
                'end-lat' => 'required|numeric|min:-90|max:90',
                'end-lng' => 'required|numeric|min:-180|max:180'
            ],
            [
                'start-lat.min' => 'Lattitude should be between -90 and 90',
                'start-lat.max' => 'Lattitude should be between -90 and 90',
                'start-lng.min' => 'Longitude should be between -180 and 180',
                'start-lng.max' => 'Longitude should be between -180 and 180',
                'end-lat.min' => 'Lattitude should be between -90 and 90',
                'end-lat.max' => 'Lattitude should be between -90 and 90',
                'end-lng.min' => 'Longitude should be between -180 and 180',
                'end-lng.max' => 'Longitude should be between -180 and 180'
            ]
        );

        $route = new Route();

        $route->source_lat = $request["start-lat"];
        $route->source_lng = $request["start-lng"];
        $route->destination_lat = $request["end-lat"];
        $route->destination_lng = $request["end-lng"];
        $route->save();

        if ($request->has('waypoints')) {
            $waypoints = explode(";", $request["waypoints"]);

            foreach ($waypoints as $point) {
                if(strlen($point) > 0) {
                    $latLng = explode(",", $point);

                    $waypoint = new WayPoint();
                    $waypoint->route_id = $route->id;
                    $waypoint->way_point_lng = $latLng[0];
                    $waypoint->way_point_lat = $latLng[1];
                    $waypoint->save();
                }
            }
        }

        $data = DB::table('routes')
            ->leftJoin('way_points', 'routes.id', '=', 'way_points.route_id')
            ->groupBy('routes.id')
            ->select(
                DB::raw('min(routes.id) as id'),
                'source_lat',
                'source_lng',
                'destination_lat',
                'destination_lng',
                DB::raw('GROUP_CONCAT(way_point_lng, ",", way_point_lat separator ";") AS way_points')
            )
            ->where('routes.id', '=', $route->id)
            ->first();

        $response = ['msg' => 'Route saved successfully.', 'status' => true, 'data' => $data];

        return Response::json($response);
    }

    public function destroyRoute($id)
    {
        $routes = Route::where('id', $id)->delete();

        return Response::json($routes);
    }
}