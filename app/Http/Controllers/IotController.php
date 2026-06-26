<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IotController extends Controller
{
    // This function receives data from your Java Simulator
    public function receiveData(Request $request)
    {
        // 1. Get the data (Added 'service_id')
        $sensorId   = $request->input('sensor_id');
        $serviceId  = $request->input('service_id'); // <--- NEW LINE: Catch the Service ID
        
        // Safety: If Java sends no ID, default to 1 (Rawang)
        if(!$serviceId) { $serviceId = 1; } 

        $waterLevel = $request->input('water_level');
        $flowSpeed  = $request->input('flow_speed');

        // 2. Logic: Flood Risk (Water Level)
        $floodStatus = "Safe";
        if ($waterLevel > 5.0 && $waterLevel <= 8.0) {
            $floodStatus = "Warning";
        } elseif ($waterLevel > 8.0) {
            $floodStatus = "Danger";
        }

        // 3. Logic: Blockage Detection (Flow Speed)
        $flowStatus = "Flowing";
        if ($flowSpeed < 1.0) {
            $flowStatus = "Blocked / Slow";
        }

        // 4. Save to Database (Added 'service_id')
        DB::table('drainage_data')->insert([
            'sensor_id'   => $sensorId,
            'service_id'  => $serviceId, // <--- NEW LINE: Save it to DB
            'water_level' => $waterLevel,
            'flow_speed'  => $flowSpeed,
            'status'      => $floodStatus,
            'flow_status' => $flowStatus,
            'created_at'  => now(),
            'updated_at'  => now()
        ]);

        return response()->json(['message' => 'Data received successfully']);
    }
}