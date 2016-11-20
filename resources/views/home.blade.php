@extends('layouts.app')

@section('header')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css">
<link rel="stylesheet" href="/css/myStyles.css">
	
@endsection

@section('content')

<div class="container-fluid">
	<div class="row">
		<section id="left-section" class="col-md-2 text-xs-center mt-1">
			<button id="btn-new-schedule" class="btn btn-primary"><i class='fa fa-plus'></i> New schedule</button>
			<div class="card card-outline-secondary">
				<div class="row mt-1">
					<input id="title-input" class="offset-md-2 col-md-8" type="text" placeholder="Title">
				</div>
				<div class="row">
					<input id="datepicker" class="offset-md-2 col-md-8" type="text" placeholder="Date">
				</div>
				<div class="row">
					<div id="all-users-dropdown" class="dropdown col-md-12">
						<button id="all-users-dropdown-btn" class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Users
						</button>
						<div class="dropdown-menu" aria-labelledby="all-users-dropdown-btn">
							<ul class="all-users-list list-group">
								@if ($friends == [])
									<li class='list-group-item'>You don't have any friends.</li>
								@else
									@foreach ($friends as $friend)
										<li class='list-group-item'>
											@if ($friend->image)
												<img src='images/{{ $friend->image }}'>{{ $friend->name }}
											@else
												<i class='fa fa-user-secret'></i>{{ $friend->name }}
											@endif
										</li>
									@endforeach
								@endif
							</ul>
						</div>
					</div>
				</div>
				<button id="btn-send-date" class="btn btn-primary mb-1">Create</button>
			</div>
		</section>
		<section id="main-section" class="col-md-10 text-xs-center">
					
				@foreach ($schedules as $schedule)
		
				<div class="row">
					<div class="col-md-9 text-xs-center">
						<div class="card mt-1 schedule-card">
							<div class="card-header">
								<h4>{{ $schedule->schedule->title }} <small class="text-muted"> by {{ App\User::where('id', '=', ($schedule->schedule->creator_id))->first()->name }}</small></h4>
								@if ($schedule->schedule->creator_id == Auth::user()->id)
									<div class="btn btn-danger remove-schedule">Remove</div>
								@endif
							</div>
							<table id={{ $schedule->schedule_id }} data-bits={{ $schedule->bits }} data-day={{ $schedule->day }} data-month={{ $schedule->month }} class="table table-striped table-bordered table-hover main-tables">
								<thead class="thead-inverse">
									<tr>
										<th></th>
										<th class="days-headers"><span class="days"></span>
											<br><span class="dates"></span></th>
										<th class="days-headers"><span class="days"></span>
											<br><span class="dates"></span></th>
										<th class="days-headers"><span class="days"></span>
											<br><span class="dates"></span></th>
										<th class="days-headers"><span class="days"></span>
											<br><span class="dates"></span></th>
										<th class="days-headers"><span class="days"></span>
											<br><span class="dates"></span></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<th>8:00</th>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
									</tr>
									<tr>
										<th>9:00</th>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
									</tr>
									<tr>
										<th>10:00</th>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
									</tr>
									<tr>
										<th>11:00</th>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
									</tr>
									<tr>
										<th>12:00</th>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
									</tr>
									<tr>
										<th>13:00</th>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
									</tr>
									<tr>
										<th>14:00</th>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
									</tr>
									<tr>
										<th>15:00</th>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
									</tr>
									<tr>
										<th>16:00</th>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
									</tr>
									<tr>
										<th>17:00</th>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
									</tr>
									<tr>
										<th>18:00</th>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
									</tr>
									<tr>
										<th>19:00</th>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
									</tr>
								</tbody>
							</table>
						</div>
		
						<button class="btn btn-success confirm">Confirm</button>
		
					</div>
		
					<div class="col-md-3 mt-1 names-container" data-schedule-id={{ $schedule->schedule_id }}>
						<div class="card">
							<div class="card-header"><i class="fa fa-users fa-lg"></i></div>
							<ul class="names list-group">
								@foreach ($schedule->usersDone as $user)
								
									@if ($user->image) 
										<li class='list-group-item list-group-item-action'><img src='images/{{ $user->image }}'>{{ $user->name }}</li>
									@else 
										<li class='list-group-item list-group-item-action'><i class='fa fa-user-secret'></i>{{ $user->name }}</li>
									@endif
									
								@endforeach
								
								@foreach ($schedule->usersUndone as $user)
								
									@if ($user->image) 
										<li class='list-group-item list-group-item-action undone'><img src='images/{{ $user->image }}'>{{ $user->name }}</li>
									@else 
										<li class='list-group-item list-group-item-action undone'><i class='fa fa-user-secret'></i>{{ $user->name }}</li>
									@endif
									
								@endforeach
							</ul>
							@if ($schedule->schedule->creator_id == Auth::user()->id)
								<div class="btn-group add-name-btn-group">
									<button type="button" class="btn btn-success btn-block" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<i class="fa fa-plus fa-lg"></i>
									</button>
									<div class="dropdown-menu">
										@if ($schedule->addList != [])
											@foreach ($schedule->addList as $addUser)
												<div class="dropdown-item add-name" data-id="{{ $addUser->id }}">{{ $addUser->name }}</div>
											@endforeach
										@else
											<div class="dropdown-item">All friends already added.</div>
										@endif
									</div>
								</div>
							@endif
						</div>
					</div>
				</div>
				
				@endforeach
		
		</section>
	</div>

</div>
	
@endsection

@section('scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.js"></script>
<script src="/js/home.js"></script>

@endsection
