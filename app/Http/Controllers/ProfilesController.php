<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\User;
use Auth;
use Carbon\Carbon;
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
		
		$user = User::where('id', '=', $id)->first();
		
		$friends_count = 0;
		$friends_count += DB::table('friends')->whereRaw('id_one = ' . $id . ' OR id_two = ' . $id)->count();
		
		return view('profile', ['user' => $user, 'friends_count' => $friends_count, 'areFriends' => $areFriends, 'friendship' => $friendship]);
		
	}
    
	public function store () {
		
		$username = request('currentUsername');
		$friend = request('friend');
		
		$user_id = User::where('name', '=', $username)->first()->id;
		$friend_id = User::where('name', '=', $friend)->first()->id;
		
		$friends = [$user_id, $friend_id];
		
		sort($friends, SORT_NUMERIC);
			
		DB::table('friends')->insert(['id_one' => $friends[0], 'id_two' => $friends[1], 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
		
		return $friends;
		
	}
	
}
