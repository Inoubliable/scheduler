<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App;
use Auth;

class ChangeEmailController extends Controller
{
    
	public function store () {
		
		$newEmail = request('email');
		
		$id = Auth::user()->id;
		$user = App\User::where('id', '=', $id)->first();
		$user->email = $newEmail;
		$user->save();
		
		return redirect('home');
		
	}
	
}
