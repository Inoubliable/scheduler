<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

class ScheduleController extends Controller
{
    
	public function store () {
		
		$schedule_id = request('scheduleId');
		
		// remove schedule and corresponding personal schedules
		DB::table('schedules')->where('id', '=', $schedule_id)->delete();
		DB::table('personal_schedules')->where('schedule_id', '=', $schedule_id)->delete();
		
	}
	
}
