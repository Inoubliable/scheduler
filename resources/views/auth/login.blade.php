@extends('layouts.app')

@section('header')

<link rel="stylesheet" href="/css/myStyles.css">
	
@endsection	

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">Login</div>
                <div class="card-block">
                    <form role="form" method="POST" action="{{ url('/login') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }} row">
                            <label for="email" class="col-md-3 offset-md-1 control-label">E-Mail Address</label>

                            <div class="col-md-7">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }} row">
                            <label for="password" class="col-md-3 offset-md-1 control-label">Password</label>

                            <div class="col-md-7">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
						<div class="form-check row">
                            <div class="col-md-8 offset-md-4">
								<label class="form-check-label">
									<input type="checkbox" class="form-check-input" name="remember"> Remember Me
								</label>
							</div>
						</div>

                        <div class="row">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Login
                                </button>

                                <a class="btn btn-link" href="{{ url('/password/reset') }}">
                                    Forgot Your Password?
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
