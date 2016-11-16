@extends('layouts.app')

@section('header')

<link rel="stylesheet" href="/css/myStyles.css">
	
@endsection	

@section('content')
		
		<div id="all-chats"></div>
		
		<div id="users-chat-container" class="card">
			<div class="card-header bg-primary text-white">
				Users
			</div>
			<ul id="users-list" class="list-group text-xs-left">
				@foreach (App\User::where('name', '!=', Auth::user()->name)->get() as $user)
					<li class='list-group-item'>
						@if ($user->image)
							<img src='images/{{ $user->image }}'>{{ $user->name }}
						@else
							<i class='fa fa-user-secret'></i>{{ $user->name }}
						@endif
					</li>
				@endforeach
			</ul>
		</div>
	
@endsection

@section('scripts')

	<script src="//js.pusher.com/3.0/pusher.min.js"></script>
	<script src="/js/chat.js"></script>
	
@endsection
