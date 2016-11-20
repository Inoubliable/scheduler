@extends('layouts.app')

@section('header')

<link rel="stylesheet" href="/css/profile.css">
	
@endsection

@section('content')

<div class="container">
	<div class="row">
	
		<div class="col-md-4 text-xs-center">
			<a href="/profileImage">
				@if ( Auth::user()->image )
					<img src='images/{{ Auth::user()->image }}' id='myImage'>
				@else
					<i class='fa fa-user-secret mt-1' id='myIcon'></i>
				@endif
			</a>
		</div>
	
		<div class="col-md-4 mt-1">
			<div class="card">
				<h4 class="card-header">Friends</h4>
				<ul class="list-group my-friends-list">
					@foreach ($friends as $friend)
						<a href="/profile/{{ $friend->id }}" class="list-group-item list-group-item-action">{{ $friend->name }}</a>
					@endforeach
				</ul>
			</div>
		</div>
		
	</div>
</div>
	
@endsection

@section('scripts')



@endsection
