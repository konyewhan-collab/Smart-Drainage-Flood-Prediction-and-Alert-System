<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; // Required to talk to Telegram
use App\Models\SensorData;
use App\Models\PredictTable;
use App\Models\AlertData; // Your new model!

class SensorDataController extends Controller
{
    public function store(Request $request)
    {
        $deviceID = $request->device_id ?? 1;
        $currentStatus = $request->status;

        // 1. Get the PREVIOUS status to prevent spamming Telegram every 5 seconds
        $lastPredict = PredictTable::where('device_id', $deviceID)->latest('created_at')->first();
        $previousStatus = $lastPredict ? $lastPredict->risk_level : 'SAFE';

        // 2. Save raw sensor readings
        SensorData::create([
            'device_id'   => $deviceID,
            'water_level' => $request->water_level,
            'water_flow'  => $request->water_flow,
        ]);

        // 3. Save the algorithm's prediction
        $predict = PredictTable::create([
            'device_id'  => $deviceID,
            'risk_level' => $currentStatus,
        ]);

        // --- 4. TELEGRAM ALERT LOGIC ---
        $botToken = "/*the bot token put here*/";
        $chatId = "/*chat id put here*/";

        // Only trigger if it is a dangerous status AND the status just changed
        if (in_array($currentStatus, ['FLOOD ALERT', 'CRITICAL ALERT', 'BLOCKAGE ALERT']) && $currentStatus !== $previousStatus) {

            // Dynamically find the first user in the database to link the alert to
        $systemUser = \App\Models\UserData::first();
        $safeUserId = $systemUser ? $systemUser->user_id : 1;

        // Save the official record to the alert_data table (Matching your ERD!)
        AlertData::create([
            'predict_id' => $predict->predict_id,
            'user_id'    => $safeUserId, // Dynamically links to a real user!
            'alert_type' => $currentStatus,
        ]);

            // Construct the Telegram Message
            $message = "⚠️ *FLOODGUARD ALERT* ⚠️\n\n";
            $message .= "Location: *Device #{$deviceID}*\n";
            $message .= "Status: *{$currentStatus}*\n";
            $message .= "Water Level: {$request->water_level}%\n";
            $message .= "Flow Rate: {$request->water_flow} L/min\n\n";
            $message .= "Please check the dashboard immediately!";

            // Send to Telegram
            Http::get("https://api.telegram.org/bot{$botToken}/sendMessage", [
                'chat_id' => $chatId,
                'text' => $message,
                'parse_mode' => 'Markdown'
            ]);
        }

        // Optional: Send an "All Clear" message when the water goes back down
        if ($currentStatus == 'SAFE' && in_array($previousStatus, ['FLOOD ALERT', 'CRITICAL ALERT', 'BLOCKAGE ALERT'])) {
             $message = "✅ *ALL CLEAR* ✅\nDevice #{$deviceID} has returned to normal SAFE conditions.";
             Http::get("https://api.telegram.org/bot{$botToken}/sendMessage", [
                'chat_id' => $chatId,
                'text' => $message,
                'parse_mode' => 'Markdown'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data saved and alerts processed!',
        ], 201);
    }
    // --- PROCESS GPS LOCATION UPDATE ---
    public function updateLocation(Request $request)
    {
        // Require latitude and longitude in the JSON payload
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $deviceID = $request->device_id ?? 1;

        // Directly update the 'device' table in your database
        \Illuminate\Support\Facades\DB::table('device')
            ->where('device_id', $deviceID)
            ->update([
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'updated_at' => now(), // Updates the timestamp
            ]);

        return response()->json([
            'success' => true,
            'message' => 'Device location updated successfully!'
        ], 200);
    }
}
