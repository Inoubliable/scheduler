<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App;
use Auth;
use Hash;

class ChangePasswordController extends Controller
{
    
	public function store () {
		
		$oldPassword = request('oldPassword');
		$newPassword1 = request('newPassword1');
		$newPassword2 = request('newPassword2');
		
		$password = Auth::user()->password;
		
		if(Hash::check($oldPassword, $password)) {
			
			if($newPassword1 == $newPassword2) {
				
				$id = Auth::user()->id;
				$user = App\User::where('id', '=', $id)->first();
				$user->password = bcrypt($newPassword1);
				$user->save();
				
			}
			
		}
				
		return redirect('home');
		
	}
	
}
