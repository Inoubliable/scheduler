<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App;
use Auth;
use DB;
use DateTime;

use App\PersonalSchedule;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index () {
		
		// get user's friends
		$friends = [];
		$all_friends_ids = [];
		$user_id = Auth::user()->id;
		
		$friends1 = DB::table('friends')->where('id_one', '=', $user_id)->get(['id_two']);
		foreach($friends1 as $friend) {
			$user = DB::table('users')->where('id', '=', $friend->id_two)->first();
			array_push($friends, $user);
				
			$all_friends_ids[] = $friend->id_two;
		}
		
		$friends2 = DB::table('friends')->where('id_two', '=', $user_id)->get(['id_one']);
		foreach($friends2 as $friend) {
			$user = DB::table('users')->where('id', '=', $friend->id_one)->first();
			array_push($friends, $user);
				
			$all_friends_ids[] = $friend->id_one;
		}
		
		// get schedules from newest to oldest
		$schedules = PersonalSchedule::where('user_id', '=', Auth::user()->id)->get()->reverse();
		
		foreach ($schedules as $schedule) {
			
			$dateString = $schedule->schedule->startDate;
			$date = DateTime::createFromFormat("Y-m-d", $dateString);
			$schedule->day = $date->format("d");
			$schedule->month = $date->format("m");
			
			$all_schedule_users_ids = [];
		
			// get users who have already given their personal schedules
			$user_ids = PersonalSchedule::whereRaw('schedule_id = ' . $schedule->schedule_id . ' AND created_at != updated_at')->get(['user_id']);
			$usersDone = [];
			foreach ($user_ids as $user_id) {
				$usersDone[] = User::where('id', '=', $user_id->user_id)->get(['name', 'image'])->first();
				
				$all_schedule_users_ids[] = $user_id->user_id;
			}
		
			// get users who have not given their personal schedules yet
			$user_ids = PersonalSchedule::whereRaw('schedule_id = ' . $schedule->schedule_id . ' AND created_at = updated_at')->get(['user_id']);
			$usersUndone = [];
			foreach ($user_ids as $user_id) {
				$usersUndone[] = User::where('id', '=', $user_id->user_id)->get(['name', 'image'])->first();
				
				$all_schedule_users_ids[] = $user_id->user_id;
			}
			
			$schedule->usersDone = $usersDone;
			$schedule->usersUndone = $usersUndone;
			
			$add_list_ids = array_diff($all_friends_ids, $all_schedule_users_ids);
			$add_list_users = [];
			
			foreach ($add_list_ids as $add_id) {
				$add_list_users[] = App\User::where('id', '=', $add_id)->first();
			}
		
			$schedule->addList = $add_list_users;
			
		}
		
		return view('home', ['schedules' => $schedules, 'friends' => $friends]);
		
	}
    
	public function store () {
		
		$title = request('title');	
		$startDate = request('startDate');
		$creator_id = Auth::user()->id;
		$users = request('users');
		
		$schedule = new App\Schedule;
		$schedule->title = $title;
		$schedule->creator_id = $creator_id;
		$schedule->startDate = $startDate;
		$schedule->save();
		
		foreach ($users as $user) {
			$user_id = DB::table('users')->where('name', '=', $user)->first();
			
			$personal_schedule = new PersonalSchedule;
			$personal_schedule->user_id = $user_id->id;
			$personal_schedule->bits = str_repeat( "0", 60 );
			$schedule->personalSchedules()->save($personal_schedule);
		}
		
		// get schedules for ajax
		$schedules = PersonalSchedule::where('user_id', '=', $creator_id)->get();
		
		foreach ($schedules as $schedule) {
			
			$dateString = $schedule->schedule->startDate;
			$date = DateTime::createFromFormat("Y-m-d", $dateString);
			$schedule->day = $date->format("d");
			$schedule->month = $date->format("m");
			
		}
		
		return $schedules;
		
	}
}
