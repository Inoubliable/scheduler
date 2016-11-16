@extends('layouts.app')

@section('header')

<link rel="stylesheet" href="/css/profile.css">
	
@endsection

@section('content')

<div class="container">
	<div class="row">
	
		<div class="col-md-4">
			@if ( Auth::user()->image )
				<img src='images/{{ $user->image }}' id='myImage'>
			@else
				<i class='fa fa-user-secret' id='myIcon'></i>
			@endif
		</div>
	
		<div class="col-md-4">
			<h3>Friends</h3>
			<ul class="list-group">
				@foreach ($friends as $friend)
					<a href="/profile/{{ $friend->id }}" class="list-group-item">{{ $friend->name }}</a>
				@endforeach
			</ul>
		</div>
		
	</div>
</div>
	
@endsection

@section('scripts')



@endsection
