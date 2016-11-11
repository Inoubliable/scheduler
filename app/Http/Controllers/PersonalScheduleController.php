<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App;
use DB;

class PersonalScheduleController extends Controller
{
	
	public function update () {

		$personal_bits = request('personalSchedule');
		$current_user = request('currentUser');
		$schedule_id = request('scheduleId');
		
		$user_id = DB::table('users')->where('name', '=', $current_user)->get(['id'])->first()->id;
		
		$personal_schedule = App\PersonalSchedule::where([['user_id', '=', $user_id], ['schedule_id', '=', $schedule_id]])->first();
		$personal_schedule->bits = $personal_bits;
		$personal_schedule->save();
		
		$bitsArray = App\PersonalSchedule::where('schedule_id', '=', $schedule_id)->get(['bits']);

		$freeTime = str_repeat ( "0", strlen($bitsArray[0]->bits) );
		for ($i = 0; $i < count($bitsArray); $i++) {
			for ($j = 0; $j < strlen($freeTime); $j++) {
				if ($freeTime[$j] == "0" && $bitsArray[$i]->bits[$j] == "0" ) {
					$freeTime[$j] = "0";
				} else {
					$freeTime[$j] = "1";
				}
			} 
		}
		
		// get users who have already given their personal schedules
		$user_ids = App\PersonalSchedule::where([['schedule_id', '=', $schedule_id], ['created_at', '!=', 'updated_at']])->get(['user_id']);
		$users = [];
		foreach ($user_ids as $user_id) {
			$users[] = App\User::where('id', '=', $user_id->user_id)->get(['name', 'image'])->first();
		}
		
		return ['freeTime'=>$freeTime, 'users'=>$users];
		
	}
	
}
