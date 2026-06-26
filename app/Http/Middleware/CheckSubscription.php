<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CheckSubscription
{
  
    public function handle(Request $request, Closure $next)
    {
    // 1. Get the Service ID the user is trying to access
    $service_id = $request->input('service_id');

    // If no specific service is requested, let them pass
    if (!$service_id) {
        return $next($request);
    }

    // 2. Get the Current User
    $username = Session::get('username');
    if (!$username) {
        return redirect('/login');
    }
    
    $user = DB::table('pengguna')->where('katanama', $username)->first();

    // 3. Check Database Approve subscription
    $hasAccess = DB::table('subscriptions')
        ->where('user_id', $user->id)
        ->where('service_id', $service_id)
        ->where('status', 'Approved')
        ->exists();

    // 4. If not Approved, block
    if (!$hasAccess) {
        return redirect('/services')->with('error', 'Access Denied: You must have an Approved subscription to view this data.');
    }

    // 5. If Approved, let them proceed
    return $next($request);
    }
}
