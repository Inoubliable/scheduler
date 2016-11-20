@extends('layouts.app')

@section('header')

<link rel="stylesheet" href="/css/profile.css">
	
@endsection

@section('content')

<div class="container-fluid">
	<div class="row">
	
		<section id="left-section" class="col-md-3 text-xs-center">
			@if ( $user->image )
				<img src='/images/{{ $user->image }}' id='profileImage'>
			@else
				<i class='fa fa-user-secret fa-5x'></i>
			@endif
			
			<br>
			<h4>{{ $user->name }}</h4>
			<p class="text-muted">{{ $user->email }}</p>
			<p><i class="fa fa-clock-o"></i> Joined on {{ date('d F, Y', strtotime($user->created_at)) }}</p>
			<br>
			<h5>Friends &nbsp&nbsp<span class="tag tag-default friends-count">{{ $friends_count }}</span></h5>
			
			<br>
			<br>			
			@if(Auth::user()->name != $user->name)
				@if($areFriends)
					<button class="btn btn-success"><i class='fa fa-check'></i> Friend</button>
					<p class="text-muted mt-1">Since {{ date('d F, Y', strtotime($friendship->created_at)) }}</p>
				@else
					<button id="add-friend" class="btn btn-primary"><i class='fa fa-user-plus'></i> Add Friend</button>
				@endif
			@endif
			
		</section>
		
		<section id="main-section" class="col-md-9 text-xs-center">
			
		</section>
		
	</div>
</div>
	
@endsection

@section('scripts')

<script src="/js/profile.js"></script>

@endsection
