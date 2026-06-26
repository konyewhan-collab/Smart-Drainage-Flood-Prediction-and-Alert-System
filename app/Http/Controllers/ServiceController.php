<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ServiceController extends Controller
{
    // 1. Show Available Services
    public function index()
    {
        // Get user ID from session (assuming you store 'username' in session)
        // We need to fetch the actual ID from the 'pengguna' table first
        $username = Session::get('username');
        $user = DB::table('pengguna')->where('katanama', $username)->first();

        if (!$user) {
            return redirect('/login');
        }

        // Get all services
        $services = DB::table('services')->get();

        // Get this user's existing subscriptions (so we can show "Pending" or "Approved")
        $mySubs = DB::table('subscriptions')
                    ->where('user_id', $user->id)
                    ->pluck('status', 'service_id') // Creates a list like [service_id => status]
                    ->toArray();

        return view('user.service', [
            'services' => $services,
            'mySubs' => $mySubs
        ]);
    }

    // 2. Handle Subscription Request
    public function subscribe()
    {
        $username = Session::get('username');
        $user = DB::table('pengguna')->where('katanama', $username)->first();
        
        // Get the Service ID from the Form (Hidden Input)
        $service_id = request()->get('service_id'); 

        // Check if a record exists (Active, Pending, or Rejected)
        $exists = DB::table('subscriptions')
                    ->where('user_id', $user->id)
                    ->where('service_id', $service_id)
                    ->first();

        if ($exists) {
            // If it exists but was Rejected, let them try again!
            if($exists->status == 'Rejected'){
                DB::table('subscriptions')
                    ->where('id', $exists->id)
                    ->update([
                        'status' => 'Pending',
                        'created_at' => now() // Reset the time
                    ]);
                return back()->with('success', 'Request re-submitted successfully.');
            }
            
            // If it is already Active or Pending, show error
            return back()->with('error', 'You have already requested this service.');
        } 
        else {
            // If no record exists, Create New
            DB::table('subscriptions')->insert([
                'user_id' => $user->id,
                'service_id' => $service_id,
                'status' => 'Pending',
                'created_at' => now()
            ]);
            return back()->with('success', 'Request sent! Waiting for Admin approval.');
        }
    }
    
    //function for the Cancel button:
    public function cancelService() 
    {
        $username = Session::get('username');
        $user = DB::table('pengguna')->where('katanama', $username)->first();
        $service_id = request()->get('service_id');

        // Delete the subscription record
        // This removes "Active", "Pending", or "Rejected" status completely.
        DB::table('subscriptions')
            ->where('user_id', $user->id)
            ->where('service_id', $service_id)
            ->delete();

        return back()->with('success', 'Subscription cancelled successfully.');
    }
}