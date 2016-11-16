<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Auth;
use App;

class ProfileImageController extends Controller
{
    
	public function index () {
		
		return view('profileImage');
		
	}
    
	public function store (Request $request) {
		
		$username = Auth::user()->name;
			
		if( $request->hasFile('profilePictureTemp') ) {
			
			$image = $request->file('profilePictureTemp');
			$extension = $image->getClientOriginalExtension();
			$newImage = $username . 'Temp.' . $extension;

			$image->move('images', $newImage);

			return back();
			
		} else {
			
			$crop = $request->input();
			
			$img = imagecreatefromjpeg("images/" . $username . "Temp.jpg");
			$img2 = imagecrop($img, $crop);
			if ($img2) {
				imagejpeg($img2, "images/" . $username . ".jpg");
			}

			// save image name to users table
			$user = App\User::where('name', '=', $username)->first();
			$user->image = $username . ".jpg";
			$user->save();
			
		}
		
	}
	
}