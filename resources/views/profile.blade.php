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
				<i class='fa fa-user-secret'></i>
			@endif
			
			<br>
			<h4>{{ $user->name }}</h4>
		</section>
		
		<section id="main-section" class="col-md-9 text-xs-center">
			@if($areFriends)
				<button class="btn btn-success"><i class='fa fa-check'></i> Friend</button>
			@else
				<button id="add-friend" class="btn btn-primary"><i class='fa fa-user-plus'></i> Add Friend</button>
			@endif
		</section>
		
	</div>
</div>
	
@endsection

@section('scripts')

<script src="/js/profile.js"></script>

@endsection
