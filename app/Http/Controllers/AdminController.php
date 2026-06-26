<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    // --- 1. VIEW ALL DEVICES ---
    public function manageDevices() {
        // Fetch all devices from the database
        $devices = DB::table('device')->get();
        
        return view('admin.manage-devices', compact('devices'));
    }

    // --- 2. ADD A NEW DEVICE ---
    public function addDevice(Request $request) {
        // Validate the form input
        $request->validate([
            'device_name' => 'required|string|max:255',
        ]);

        // Insert into the database
        DB::table('device')->insert([
            'device_name' => $request->device_name,
            'latitude'    => $request->latitude ?? null, // Optional
            'longitude'   => $request->longitude ?? null, // Optional
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        return redirect()->back()->with('success', 'New IoT Device added successfully!');
    }

    // --- 3. DELETE A DEVICE ---
    public function deleteDevice($id) {
        // Warning: In a real system, you'd want to delete the sensor data first 
        // to prevent Foreign Key constraint errors. For this FYP, we will safely delete it!
        
        DB::table('sensor_data')->where('device_id', $id)->delete();
        DB::table('predict_table')->where('device_id', $id)->delete();
        DB::table('device')->where('device_id', $id)->delete();

        return redirect()->back()->with('success', 'Device and its history deleted successfully!');
    }
    
    // ==========================================
    // MANAGE USERS MODULE
    // ==========================================

    // --- 1. VIEW ALL USERS ---
    public function manageUsers() {
        // Fetch all users from the database
        $users = DB::table('user_data')->get();
        
        return view('admin.manage-users', compact('users'));
    }

    // --- 2. UPDATE USER ROLE ---
    public function updateUserRole(Request $request, $id) {
        // Prevent the Admin from accidentally downgrading themselves!
        if (auth()->user()->user_id == $id) {
            return redirect()->back()->withErrors(['error' => 'You cannot change your own role!']);
        }

        DB::table('user_data')->where('user_id', $id)->update([
            'userlevel' => $request->userlevel
        ]);

        return redirect()->back()->with('success', 'User role updated successfully!');
    }

    // --- 3. DELETE A USER ---
    public function deleteUser($id) {
        // Prevent the Admin from deleting themselves!
        if (auth()->user()->user_id == $id) {
            return redirect()->back()->withErrors(['error' => 'You cannot delete yourself!']);
        }

        // 1. Delete any alerts linked to this user so the database doesn't crash
        DB::table('alert_data')->where('user_id', $id)->delete();
        
        // 2. Delete the user
        DB::table('user_data')->where('user_id', $id)->delete();

        return redirect()->back()->with('success', 'User account deleted successfully!');
    }
    
    // --- 4. VIEW IOT DATA LOG ---
    public function iotDataLog() {
        // Fetch sensor data, join with device table for the name, 
        // AND join with predict_table to get the risk_level!
        $sensorLogs = DB::table('sensor_data')
            ->join('device', 'sensor_data.device_id', '=', 'device.device_id')
            ->leftJoin('predict_table', function($join) {
                $join->on('sensor_data.device_id', '=', 'predict_table.device_id')
                     ->on('sensor_data.created_at', '=', 'predict_table.created_at');
            })
            ->select('sensor_data.*', 'device.device_name', 'predict_table.risk_level')
            ->orderBy('sensor_data.created_at', 'desc')
            ->paginate(50);

        return view('admin.iot-data', compact('sensorLogs'));
    }
    
    // ==========================================
    // SYSTEM REPORTS MODULE
    // ==========================================

    public function systemReports() {
        // 1. TOP CARDS: General System Statistics
        $totalUsers = DB::table('user_data')->count();
        
        $totalDevices = DB::table('device')->count();
        
        // Count how many times the system detected something other than 'SAFE'
        $totalAlerts = DB::table('predict_table')
                        ->where('risk_level', '!=', 'SAFE')
                        ->where('risk_level', '!=', 'SAFE (Dry Drain)')
                        ->count();

        // 2. BOTTOM CARD: Recent Alert History
        // Joins with the device table to show exactly which sensor triggered the alert
        $recentAlerts = DB::table('predict_table')
            ->join('device', 'predict_table.device_id', '=', 'device.device_id')
            ->where('predict_table.risk_level', '!=', 'SAFE')
            ->where('predict_table.risk_level', '!=', 'SAFE (Dry Drain)')
            ->select('predict_table.*', 'device.device_name')
            ->orderBy('predict_table.created_at', 'desc')
            ->paginate(15);

        return view('admin.reports', compact('totalUsers', 'totalDevices', 'totalAlerts', 'recentAlerts'));
    }
}