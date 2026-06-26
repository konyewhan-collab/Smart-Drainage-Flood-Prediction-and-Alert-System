<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Request; 
use Session;
use DB;

class MyController extends BaseController
{
	public function uploadPicture() { 
		Request::validate([ 
			'picture' => 'required|image|max:2048' 
			]); 
			$username = Session::get('username'); 
			$folder = "pictures/$username/"; 
			$filename = Request::file('picture')->getClientOriginalName(); 
			// Store file 
			Request::file('picture')->move("$folder", $filename); 
			// Save DB info 
			DB::table("picture")->insert([ 
			'picture_name' => $filename, 
			'username' => $username, 
			]); 
		return back()->with('success', 'Picture uploaded.'); 
	}

	public function deletePicture($id) { 
		$pic = DB::table("picture")->where("id",$id)->first(); 
		$username = Session::get('username'); 
		$path = "../public/pictures/$username/" . $pic->picture_name; 
		unlink($path);  
		DB::table("picture")->where("id",$id)->delete(); 
		return back()->with('success', 'Picture deleted.'); 
	}

	public function SaveProfile(){ 
		if (Request::has("btnSaveProfile")){ 
		DB::table("pengguna") 
		->where("katanama", Session::get("username")) 
		->update([ 
			"nama" => Request::get("nama"), 
			"katanama" => Request::get("katanama"), 
			"katalaluan" => Request::get("katalaluan"), 
			"id_state" => Request::get("id_state"), 
			"id_picture" => Request::get("id_picture") 
			]); 
		return view("user/profile"); 
  		} 
	} 



	public function ProsesAdmin(){
		if (Request::has("btnInsert")){
			return view("admin/new");
		}else if(Request::has("btnInsertConfirm")){
			echo "Saving new data";
			DB::table("pengguna")
			->insert([
				"nama"=> Request::get("nama"),
				"katanama"=> Request::get("katanama"),
				"katalaluan"=> Request::get("katalaluan"),
				"jenispengguna"=> Request::get("jenispengguna")
			]);

		}else if(Request::has("btnEdit")){
			$x=DB::table("pengguna")
			->where("id",Request::get("id"))
			->first();
			return view("admin/edit", ["data"=>$x]);

		}else if(Request::has("btnEditConfirm")){
			DB::table("pengguna")
			->where("id", Request::get("id") )
			->update([
			"nama" => Request::get("nama"),
			"katanama" => Request::get("katanama"),
			"katalaluan" => Request::get("katalaluan"),
			"jenispengguna" => Request::get("jenispengguna")
			]);

		}else if(Request::has("btnDelete")){
			$x=DB::table("pengguna")
			->where("id",Request::get("id"))
			->first();
			return view("admin/delete", ["data"=>$x]);

		}else if(Request::has("btnDeleteConfirm")){
			DB::table("pengguna")
			->where("id", Request::get("id") )
			->delete();
		}


//Search
		if (Request::has("btnSearch")){
			$name = Request::get("searchTxt");
			//echo $name;
			//die();
			$x= DB::table("pengguna")
			->where("nama", "LIKE", "%".$name."%")
			->get();
		}else{
			//$x = DB::table("pengguna")->get();
			$x = DB::table("pengguna")
			->select("pengguna.*","state.state_name","picture.picture_name")
			->leftjoin("state","pengguna.id_state","state.id")
			->leftjoin("picture","pengguna.id_picture","picture.id")
			->get();
		}
		return view("admin/index",["data"=>$x]);
	}



	public function ProsesLogin(){
		Request::validate([
			"username" => "required",
			"pwd" => "required",
		]);
		
		$u = Request::get("username");
		$p = Request::get("pwd");

		$data = DB::table("pengguna")
		->where("katanama",$u)
		->where("katalaluan",$p)
		->first();

		if ($data){
			Session::put("username",$u);
			$userlevel = $data->jenispengguna;

			Session::put("userlevel",$userlevel);

			echo "Welcome $u (userlevel)";
			if($userlevel=="admin"){
				return redirect("/admin/reports");
			}else{
				return redirect("/userpage");
			}
		}else{
			Session::forget("username",$u);
			echo "Invalid login";
		}
	
	}
	
	// ---------------------------------------------------------
    // NEW REGISTRATION FUNCTIONS
    // ---------------------------------------------------------

    // 1. Show the Register View
    public function register() {
        return view('register'); 
    }

    // 2. Process the Registration Form
    public function registerProses() {
        // Validate inputs from the HTML form
        Request::validate([
            'name'     => 'required',
            'username' => 'required|unique:pengguna,katanama', // Checks 'katanama' column in 'pengguna' table
            'pwd'      => 'required|min:6|confirmed' // Matches 'pwd' with 'pwd_confirmation'
        ]);

        // Insert into database
        DB::table("pengguna")->insert([
            "nama"          => Request::get("name"),     // HTML field 'name' -> DB column 'nama'
            "katanama"      => Request::get("username"), // HTML field 'username' -> DB column 'katanama'
            "katalaluan"    => Request::get("pwd"),      // HTML field 'pwd' -> DB column 'katalaluan'
            "jenispengguna" => "user"                    // Default role is 'user'
        ]);

        // Redirect to login page
        return redirect("/login");
    }
    // ... inside MyController class ...
    
    public function logoutConfirm()
    {
        return view('logout'); // Shows logout.blade.php
    }
    
    public function logoutPerform()
    {
        Session::forget('username');
        Session::forget('userlevel');
        // Session::flush(); // Optional: clears everything

        return redirect('/login')->with('success', 'You have been logged out.');
    }
}