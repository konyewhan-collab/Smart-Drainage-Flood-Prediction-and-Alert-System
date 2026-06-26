<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\UserData;

class AuthController extends Controller
{
    // --- SHOW HTML FORMS ---
    public function showLoginForm() {
        return view('login');
    }

    public function showRegisterForm() {
        return view('register');
    }

    // --- PROCESS REGISTRATION ---
    public function register(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255|unique:user_data',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Create the user and Hash the password for security!
        $user = UserData::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'userlevel' => 'User', // Default user level
            'password' => Hash::make($request->password), 
        ]);

        // Log them in immediately after signing up
        Auth::login($user);

        return redirect('/userpage')->with('success', 'Registration successful!');
    }

    // --- PROCESS LOGIN ---
    public function login(Request $request) {
        $credentials = $request->validate([
            'name' => 'required|string',
            'password' => 'required|string',
        ]);

        // Attempt to log in using the 'name' column instead of email
        if (Auth::attempt(['name' => $request->name, 'password' => $request->password])) {
            $request->session()->regenerate();
            return redirect('/userpage')->with('success', 'Logged in successfully!');
        }

        return back()->withErrors([
            'name' => 'The provided credentials do not match our records.',
        ]);
    }

    // --- PROCESS LOGOUT ---
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
    
    // --- 1. PROCESS PROFILE UPDATE ---
    public function saveProfile(Request $request) {
        $user = Auth::user();

        $request->validate([
            'phone' => 'required|string|max:20',
            'password' => 'nullable|string|min:6',
        ]);

        $user->phone = $request->phone;
        
        // Save the selected Profile Picture!
        $user->profile_pic = $request->profile_pic;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    // --- 2. PROCESS IMAGE UPLOAD ---
    public function uploadPicture(Request $request) {
        $request->validate([
            'picture' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = Auth::user();
        $file = $request->file('picture');
        $filename = time() . '_' . $file->getClientOriginalName();
        
        // Save file to public/pictures/{username}/ folder
        $destinationPath = public_path('pictures/' . $user->name);
        $file->move($destinationPath, $filename);

        // Save to Database
        \Illuminate\Support\Facades\DB::table('picture')->insert([
            'username' => $user->name,
            'picture_name' => $filename,
        ]);

        return redirect()->back()->with('success', 'Image uploaded successfully!');
    }

    // --- 3. PROCESS IMAGE DELETE ---
    public function deletePicture($id) {
        $user = Auth::user();
        $picture = \Illuminate\Support\Facades\DB::table('picture')->where('id', $id)->first();

        if($picture && $picture->username == $user->name) {
            // Delete file from server
            $image_path = public_path('pictures/' . $user->name . '/' . $picture->picture_name);
            if (file_exists($image_path)) {
                unlink($image_path);
            }
            // Delete from Database
            \Illuminate\Support\Facades\DB::table('picture')->where('id', $id)->delete();
            
            // If they deleted their active profile pic, reset it!
            if($user->profile_pic == $picture->picture_name) {
                $user->profile_pic = null;
                $user->save();
            }
        }

        return redirect()->back()->with('success', 'Image deleted!');
    }
}