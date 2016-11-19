<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App;

class SearchController extends Controller
{
    
	public function index () {
		
		$keyword = request('keyword');
		
		if ($keyword != '') {

			$results = App\User::where("name", "LIKE","%$keyword%")->orWhere("email", "LIKE", "%$keyword%")->get();

			return $results;
			
		}
		
	}
	
}
