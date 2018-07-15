<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Station;
use Request as val_request;
use DB;

class StationController extends Controller
{
    public function index() {
        $station = Station::all();
        return view('station.index')->withStations($station);
    }

    public function timeUpdate()
    {
        $new_id = val_request::input("id");
        $minutes = val_request::input("minutes");
        



        // DB::table('stations')
        //             ->where('station', '=', $station_name)
        //             ->update(['time' => $minutes . ' Minutes']);

        $station = Station::where('id', '=', $new_id)->first();
        $station->time = $minutes . " Minutes";
        $station->save();

        return response("true");
    }
}
