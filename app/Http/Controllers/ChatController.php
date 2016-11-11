<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App;
use Illuminate\Support\Facades\Auth;
use DB;

class ChatController extends Controller {
	
	public function index () {	

		return view('chat');
		
	}
	
	public function store () {
		
		$currentUser = request('currentUser');
		$chatWith = request('chatWith');
		$reply = request('reply');
	
		// get users in alphabetical order (case insensitive)
		$users = array($currentUser, $chatWith);
		sort($users, SORT_NATURAL | SORT_FLAG_CASE);
		$user_one = $users[0];
		$user_two = $users[1];
		
		$pusher = App::make('pusher');

		$pusher->trigger('privat-' . $chatWith, 
					 'new-reply', 
					 ['reply' => $reply, 'author' => $currentUser]);
		
		$chat_id = DB::table('chat')->where([['user_one', '=', $user_one], ['user_two', '=', $user_two]])->first();
		
		if($chat_id) {
			
			DB::table('chat_replies')->insert(['chat_id'=>($chat_id->id), 'username'=>$currentUser, 'reply'=>$reply]);
			
		} else {
			
			$chat_id = DB::table('chat')->insertGetId(['user_one'=>$user_one, 'user_two'=>$user_two]);
			DB::table('chat_replies')->insert(['chat_id'=>$chat_id, 'username'=>$currentUser, 'reply'=>$reply]);
			
		}
		
	}
	
}
