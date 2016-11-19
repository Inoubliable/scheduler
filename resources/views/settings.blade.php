@extends('layouts.app')

@section('header')

<link rel="stylesheet" href="/css/myStyles.css">
	
@endsection

@section('content')

<div class="container">
	<div class="row">

		<div class="offset-md-2 col-md-8">
			<ul class="nav nav-tabs" id="account-tabs">
				<li class="nav-item">
					<a href="#account-user" class="nav-link active" data-toggle="tab">User info</a>
				</li>
				<li class="nav-item">
					<a href="#account-password" class="nav-link" data-toggle="tab">Change password</a>
				</li>
				<li class="nav-item">
					<a href="#account-language" class="nav-link" data-toggle="tab">Language</a>
				</li>
			</ul>
			<div class="tab-content card">
				<div class="tab-pane active" id="account-user">
					<form action="/changeEmail" method="post">
						{{ csrf_field() }}
						<div class="form-group row">
							<label class="col-sm-3 col-form-label text-xs-right">Name</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" value="{{ Auth::user()->name }}" disabled>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-3 col-form-label text-xs-right">E-mail</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" name="email" value="{{ Auth::user()->email }}">
							</div>
						</div>
						<div class="form-group row">
							<div class="col-sm-12 text-xs-center">
								<button class="btn btn-primary">Save changes</button>
							</div>
						</div>
					</form>
				</div>
				<div class="tab-pane" id="account-password">
					<form action="/changePassword" method="post">
						{{ csrf_field() }}
						<div class="form-group row">
							<label class="col-sm-4 col-form-label text-xs-right">Old password</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" name="oldPassword" required>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-4 col-form-label text-xs-right">New password</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" name="newPassword1" required>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-4 col-form-label text-xs-right">Repeat new password</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" name="newPassword2" required>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-sm-12 text-xs-center">
								<button class="btn btn-primary">Save changes</button>
							</div>
						</div>
					</form>
				</div>
				<div class="tab-pane" id="account-language">
					<div class="form-group">
						<select class="form-control" id="languageSelect">
							<option>English</option>
						</select>
					</div>
						<div class="form-group row">
							<div class="col-sm-12 text-xs-center">
								<button class="btn btn-primary">Save changes</button>
							</div>
						</div>
				</div>
			</div>
		</div>

	</div>
</div>
	
@endsection

@section('scripts')

<script src="/js/home.js"></script>

@endsection
