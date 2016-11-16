<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Auth;
use DB;

class MyProfileController extends Controller
{
    
	public function index () {
		
		$friends = [];
		$user_id = Auth::user()->id;
		
		$friends1 = DB::table('friends')->where('id_one', '=', $user_id)->get(['id_two']);
		foreach($friends1 as $friend) {
			$user = DB::table('users')->where('id', '=', $friend->id_two)->first();
			array_push($friends, $user);
		}
		
		$friends2 = DB::table('friends')->where('id_two', '=', $user_id)->get(['id_one']);
		foreach($friends2 as $friend) {
			$user = DB::table('users')->where('id', '=', $friend->id_one)->first();
			array_push($friends, $user);
		}
		
		return view('myProfile', ['friends' => $friends]);
		
	}
	
}
