<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App;
use Auth;
use DB;

class ChatFocusController extends Controller
{
    
	public function index () {
		
		$currentUser = Auth::user()->name;
		$currentUserId = Auth::user()->id;
		$chatWith = request('chatWith');
		$chatWithId = App\User::where('name', '=', $chatWith)->first()->id;
	
		// get users in alphabetical order (case insensitive)
		$users = array($currentUser, $chatWith);
		sort($users, SORT_NATURAL | SORT_FLAG_CASE);
		$user_one = $users[0];
		$user_two = $users[1];
			
		DB::table('chat')->update(['user_one'=>$user_one, 'user_two'=>$user_two, 'user_one_seen'=>true, 'user_two_seen'=>true]);
		
		// count unseen chats and save the number in users table
		$unseenChats1 = DB::table('chat')->whereRaw("(user_one = '" . $chatWith . "' AND user_one_seen = 0) OR (user_two = '" . $chatWith . "' AND user_two_seen = 0)")->count();
		
		$chatWith = App\User::where('id', '=', $chatWithId)->first();
		$chatWith->unseen_chats = $unseenChats1;
		$chatWith->save();
		
		$unseenChats2 = DB::table('chat')->whereRaw("(user_one = '" . $currentUser . "' AND user_one_seen = 0) OR (user_two = '" . $currentUser . "' AND user_two_seen = 0)")->count();
		
		$currentUser = App\User::where('id', '=', $currentUserId)->first();
		$currentUser->unseen_chats = $unseenChats2;
		$currentUser->save();
		
		$data = ['unseenChats' => $unseenChats2];
		
		return $data;
		
	}
	
}
