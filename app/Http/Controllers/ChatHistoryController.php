<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App;
use Auth;
use DB;

class ChatHistoryController extends Controller
{
    
	public function index () {
		
		$currentUser = request('currentUser');
		$chatWith = request('chatWith');
	
		// get users in alphabetical order (case insensitive)
		$users = array($currentUser, $chatWith);
		sort($users, SORT_NATURAL | SORT_FLAG_CASE);
		$user_one = $users[0];
		$user_two = $users[1];
		
		$chat = DB::table('chat')->where([['user_one', '=', $user_one], ['user_two', '=', $user_two]])->first();
		
		if($chat) {
			
			$replies = DB::table('chat_replies')->where('chat_id', '=', $chat->id)->get(['reply', 'username']);
			return $replies;
			
		}
		
	}
	
}
