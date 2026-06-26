<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyMiddleware
{
    public function handle(Request $request, Closure $next, ...$level)
    {
        // 1. Check if the user is logged in
        if (!Auth::check()) {
            return redirect('/login')->withErrors(['name' => 'You are not allowed here. Please login first.']);
        }

        // 2. Convert both the user's actual level and the allowed levels to lowercase! 
        // This fixes the "User" vs "user" mismatch bug.
        $userLevel = strtolower(Auth::user()->userlevel);
        $allowedLevels = array_map('strtolower', $level);
        
        // 3. Check if they have permission
        if (!empty($allowedLevels) && !in_array($userLevel, $allowedLevels)) {
            
            // THE FIX: Send them to the safe Home Page ('/'), NOT '/userpage'!
            // This prevents the infinite redirect loop.
            return redirect('/')->withErrors(['name' => 'You do not have permission to use this module.']);
        }

        // 4. If everything is good, let them through!
        return $next($request);
    }
}