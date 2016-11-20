<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\PersonalSchedule;
use App\User;

class ScheduleUserController extends Controller
{
    
	public function store () {
		
		$schedule_id = request('scheduleId');
		$user_id = request('userId');
		
		$personal_schedule = new PersonalSchedule;
		$personal_schedule->user_id = $user_id;
		$personal_schedule->bits = str_repeat( "0", 60 );
		$personal_schedule->schedule_id = $schedule_id;
		$personal_schedule->save();
		
		$user = User::where('id', '=', $user_id)->first();
		
		return $user;
		
	}
	
}
