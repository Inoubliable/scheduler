<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App;
use Auth;
use DB;

class ChatController extends Controller {
	
	public function index () {	

		return view('chat');
		
	}
	
	public function store () {
		
		$currentUser = request('currentUser');
		$currentUserId = request('currentUserId');
		$chatWith = request('chatWith');
		$chatWithId = App\User::where('name', '=', $chatWith)->first()->id;
		$reply = request('reply');
	
		// get users in alphabetical order (case insensitive)
		$users = array($currentUser, $chatWith);
		sort($users, SORT_NATURAL | SORT_FLAG_CASE);
		$user_one = $users[0];
		$user_two = $users[1];
		
		if($user_one == $currentUser) {
			$user_seen = 'user_one_seen';
			$user_not_seen = 'user_two_seen';
		} else {
			$user_seen = 'user_two_seen';
			$user_not_seen = 'user_one_seen';			
		}
		
		// pusher
		$pusher = App::make('pusher');

		$pusher->trigger('privat-' . $chatWithId, 
					 'new-reply', 
					 ['reply' => $reply, 'author' => $currentUser]);
		
		// save chat or reply
		$chat_id = DB::table('chat')->where([['user_one', '=', $user_one], ['user_two', '=', $user_two]])->first();
		
		if($chat_id) {
			
			DB::table('chat')->update(['user_one'=>$user_one, 'user_two'=>$user_two, $user_seen=>true, $user_not_seen=>false]);
			DB::table('chat_replies')->insert(['chat_id'=>($chat_id->id), 'username'=>$currentUser, 'reply'=>$reply]);
			
		} else {
			
			$chat_id = DB::table('chat')->insertGetId(['user_one'=>$user_one, 'user_two'=>$user_two, $user_seen=>true, $user_not_seen=>false]);
			DB::table('chat_replies')->insert(['chat_id'=>$chat_id, 'username'=>$currentUser, 'reply'=>$reply]);
			
		}
		
		// count unseen chats and save the number in users table
		$unseenChats1 = DB::table('chat')->whereRaw("(user_one = '" . $chatWith . "' AND user_one_seen = 0) OR (user_two = '" . $chatWith . "' AND user_two_seen = 0)")->count();
		
		$chatWith = App\User::where('id', '=', $chatWithId)->first();
		$chatWith->unseen_chats = $unseenChats1;
		$chatWith->save();
		
		$unseenChats2 = DB::table('chat')->whereRaw("(user_one = '" . $currentUser . "' AND user_one_seen = 0) OR (user_two = '" . $currentUser . "' AND user_two_seen = 0)")->count();
		
		$currentUser = App\User::where('id', '=', $currentUserId)->first();
		$currentUser->unseen_chats = $unseenChats2;
		$currentUser->save();
		
	}
	
}
