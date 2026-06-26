<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\SensorData;
use App\Models\PredictTable;

class DashboardController extends Controller
{
    // 1. Load the initial web page
    public function index(Request $request)
    {
        // Get the requested device, or default to Device #1
        $deviceId = $request->device_id;
        if (empty($deviceId)) {
            $deviceId = 1;
        }

        // Fetch all devices for the dropdown menu
        $myDevices = DB::table('device')->get();
        $currentDevice = DB::table('device')->where('device_id', $deviceId)->first();

        // Fetch latest readings safely
        $latestSensor = SensorData::where('device_id', $deviceId)->latest('created_at')->first();
        $latestPredict = PredictTable::where('device_id', $deviceId)->latest('created_at')->first();

        // Safe fallback if the database is currently empty
        $latest = (object) [
            'device_id'   => $deviceId,
            'water_level' => $latestSensor ? $latestSensor->water_level : 0,
            'water_flow'  => $latestSensor ? $latestSensor->water_flow : 0,
            'risk_level'  => $latestPredict ? $latestPredict->risk_level : 'No Data',
            'created_at'  => $latestSensor ? $latestSensor->created_at : now()
        ];

        // Get the last 20 readings for the chart
        $chartData = SensorData::where('device_id', $deviceId)
                        ->orderBy('created_at', 'desc')
                        ->take(20)
                        ->get()
                        ->reverse()
                        ->values();

        return view('user.index', compact('myDevices', 'currentDevice', 'latest', 'chartData'));
    }

    // 2. The AJAX endpoint for the 5-second live updates
    public function liveData(Request $request)
    {
        try {
            $deviceId = $request->device_id;
            if (empty($deviceId)) {
                $deviceId = 1;
            }

            $latestSensor = SensorData::where('device_id', $deviceId)->latest('created_at')->first();
            $latestPredict = PredictTable::where('device_id', $deviceId)->latest('created_at')->first();

            // Safely check if data exists before trying to read it
            $latest = [
                'water_level' => $latestSensor ? $latestSensor->water_level : 0,
                'water_flow'  => $latestSensor ? $latestSensor->water_flow : 0,
                'risk_level'  => $latestPredict ? $latestPredict->risk_level : 'No Data',
                'created_at'  => $latestSensor ? $latestSensor->created_at : date('Y-m-d H:i:s')
            ];

            $chartData = SensorData::where('device_id', $deviceId)
                            ->orderBy('created_at', 'desc')
                            ->take(20)
                            ->get()
                            ->reverse()
                            ->values();

            return response()->json([
                'latest'    => $latest,
                'chartData' => $chartData
            ]);
            
            // NEW: Fetch the GPS location from the device table
            $device = DB::table('device')->where('device_id', $deviceId)->first();

            // NEW: Include the 'device' data in the JSON response
            return response()->json([
                'latest'    => $latest,
                'chartData' => $chartData,
                'device'    => $device 
            ]);

        } catch (\Exception $e) {
            // If it crashes, send the exact error back to the console!
            return response()->json(['error' => $e->getMessage(), 'line' => $e->getLine()], 500);
        }
    }
    
   // ==========================================
    // USER HISTORY MODULE
    // ==========================================
    public function historyLog(Request $request)
    {
        $deviceId = $request->device_id;
        if (empty($deviceId)) {
            $deviceId = 1;
        }

        $myDevices = \Illuminate\Support\Facades\DB::table('device')->get();
        $currentDevice = \Illuminate\Support\Facades\DB::table('device')->where('device_id', $deviceId)->first();

        // --- OPTIMIZED QUERY ---
        $historyLogs = \Illuminate\Support\Facades\DB::table('sensor_data')
            ->where('sensor_data.device_id', $deviceId)
            // FIX 1: Only fetch data from the last 7 days! Ignore old data.
            ->where('sensor_data.created_at', '>=', now()->subDays(7))
            ->leftJoin('predict_table', function($join) {
                $join->on('sensor_data.device_id', '=', 'predict_table.device_id')
                     ->on('sensor_data.created_at', '=', 'predict_table.created_at');
            })
            ->select('sensor_data.*', 'predict_table.risk_level')
            ->orderBy('sensor_data.created_at', 'desc')
            // FIX 2: simplePaginate() stops Laravel from counting all 100,000+ rows!
            ->simplePaginate(30); 

        return view('user.history', compact('myDevices', 'currentDevice', 'historyLogs'));
    }
}