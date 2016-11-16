<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App;
use Auth;
use DB;

class ProfilesController extends Controller
{
    
	public function index ($id) {
		
		$username = Auth::user()->name;
		
		$user_id = Auth::user()->id;
		
		$friends = [$user_id, $id];
		
		sort($friends, SORT_NUMERIC);
		
		$friendship = DB::table('friends')->where(['id_one' => $friends[0], 'id_two' => $friends[1]])->first();
		$areFriends = true;
		if( !$friendship ) {
			$areFriends = false;
		}
		
		$user = App\User::where('id', '=', $id)->first();
		
		return view('profile', ['user' => $user, 'areFriends' => $areFriends]);
		
	}
    
	public function store () {
		
		$username = request('currentUsername');
		$friend = request('friend');
		
		$user_id = App\User::where('name', '=', $username)->first()->id;
		$friend_id = App\User::where('name', '=', $friend)->first()->id;
		
		$friends = [$user_id, $friend_id];
		
		sort($friends, SORT_NUMERIC);
			
		DB::table('friends')->insert(['id_one' => $friends[0], 'id_two' => $friends[1]]);
		
		return $friends;
		
	}
	
}
