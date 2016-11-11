<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PersonalSchedule extends Model
{
    
	public function schedule() {
		
		return $this->belongsTo(Schedule::class);
		
	}
	
}