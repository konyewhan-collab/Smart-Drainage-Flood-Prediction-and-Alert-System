<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GpsController extends Controller
{
    public function showLocationMap(Request $request) {
        $deviceId = $request->device_id ?? 1;
        
        // Get data needed for the dropdown and map
        $myDevices = DB::table('device')->get();
        $currentDevice = DB::table('device')->where('device_id', $deviceId)->first();
        $latest = DB::table('predict_table')->where('device_id', $deviceId)->latest('created_at')->first();

        // CHANGED: We tell Laravel to look inside the "user" folder for "location.blade.php"
        return view('user.location', compact('myDevices', 'currentDevice', 'latest'));
    }
}