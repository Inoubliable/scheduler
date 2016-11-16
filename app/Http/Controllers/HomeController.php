<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App;
use Auth;
use DB;
use DateTime;

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
		
		// get schedules from newest to oldest
		$schedules = App\PersonalSchedule::where('user_id', '=', Auth::user()->id)->get()->reverse();
		
		foreach ($schedules as $schedule) {
			
			$dateString = $schedule->schedule->startDate;
			$date = DateTime::createFromFormat("Y-m-d", $dateString);
			$schedule->day = $date->format("d");
			$schedule->month = $date->format("m");
			
		}
		
		// get friends
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
		
		return view('home', ['schedules' => $schedules, 'friends' => $friends]);
		
	}
    
	public function store () {
			
		$startDate = request('startDate');
		$creator = request('creator');
		$users = request('users');
		
		$schedule = new App\Schedule;
		$schedule->creator = $creator;
		$schedule->startDate = $startDate;
		$schedule->save();
		
		foreach ($users as $user) {
			$user_id = DB::table('users')->where('name', '=', $user)->first();
			
			$personal_schedule = new App\PersonalSchedule;
			$personal_schedule->user_id = $user_id->id;
			$personal_schedule->bits = str_repeat( "0", 60 );
			$schedule->personalSchedules()->save($personal_schedule);
		}
		
		// get schedules
		$schedules = App\PersonalSchedule::where('user_id', '=', Auth::user()->id)->get();
		
		foreach ($schedules as $schedule) {
			
			$dateString = $schedule->schedule->startDate;
			$date = DateTime::createFromFormat("Y-m-d", $dateString);
			$schedule->day = $date->format("d");
			$schedule->month = $date->format("m");
			
		}
		
		return $schedules;
		
	}
}
