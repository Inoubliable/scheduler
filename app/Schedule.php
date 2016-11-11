<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    
	public function personalSchedules() {
		
		return $this->hasMany(PersonalSchedule::class);
		
	}
	
}
