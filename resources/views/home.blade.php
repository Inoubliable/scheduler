@extends('layouts.app')

@section('header')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css">
<link rel="stylesheet" href="/css/myStyles.css">
	
@endsection

@section('content')

<div class="container-fluid">
	<div class="row">
		<section id="left-section" class="col-md-2 text-xs-center">
			<button id="btn-new-schedule" class="btn btn-primary"><i class='fa fa-plus'></i> New schedule</button>
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
							@foreach (App\User::all() as $user)
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
				</div>
			</div>
			<button id="btn-send-date" class="btn btn-primary">Create</button>
		</section>
		<section id="main-section" class="col-md-10 text-xs-center">
					
				@foreach ($schedules as $schedule)
		
				<div class="row">
					<div class="col-md-9 text-xs-center">
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
		
						<button class="btn btn-success confirm">Confirm</button>
		
					</div>
		
					<div class="names-container col-md-3">
						<ul class="names list-group"></ul>
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
