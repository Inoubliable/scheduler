<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>{{ config('app.name') }}</title>

	<!-- Font Awesome -->
	<link rel="stylesheet" href="css/font-awesome.min.css">

	<!-- Styles -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.5/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/myStyles.css">

	<!-- Scripts -->
	<script>
		window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
	</script>
	
	<link rel="stylesheet" href="cropper/dist/cropper.css">
	
</head>

<body>
	<div id="app">
		<nav class="navbar navbar-default bg-faded">
			<a class="navbar-brand" href="{{ url('/home') }}">{{ config('app.name') }}</a>

			<!-- Right Side Of Navbar -->
			<div class="user float-xs-right mr-2">
				<!-- Authentication Links -->
				@if (Auth::guest())
				<a href="{{ url('/login') }}">Login</a>
				<a href="{{ url('/register') }}">Register</a>
				
				@else
				<div id="nav-chat">
					<a href="/chat">Chat</a>
					@if ( Auth::user()->unseen_chats != 0 )
						<span id="chatTag" class="tag tag-pill tag-danger">
							{{ Auth::user()->unseen_chats }}
						</span>
					@endif
				</div>
				<div class="dropdown">
					<button class="btn btn-secondary dropdown-toggle" type="button" id="userDropdownBtn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<div class="user-img-container float-xs-left">
							@if ( !Auth::user()->image )
								<i class='fa fa-user-secret'></i>
							@else
								<div class="user-img-preview"></div>
							@endif
						</div>
						<div class="username float-xs-left">{{ Auth::user()->name }}</div>
					</button>
					<div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdownBtn">
						<a class="dropdown-item" href="/myProfile">Profile</a>
						<a class="dropdown-item" href="/settings">Settings</a>
						<div class="dropdown-divider"></div>
						<a href="{{ url('/logout') }}" class="dropdown-item" onclick="event.preventDefault();
																			 document.getElementById('logout-form').submit();">
																		Logout
																	</a>
						<form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
							{{ csrf_field() }}
						</form>
					</div>
				</div>
				@endif
			</div>
		</nav>

		<div class="container-fluid">
			<form id="profilePictureForm" action="/profileImage" method="post" enctype="multipart/form-data">
				{{ csrf_field() }}
				<label for="profilePictureTemp">Choose an image</label>
				<input type="file" name="profilePictureTemp" id="profilePictureTemp">
				<input type="submit" value="Submit" name="submit" class="btn btn-success btn-sm">
			</form>

			<div class="text-xs-center">

				@if(file_exists('images/' . Auth::user()->name . 'Temp.jpg'))

				<img id="image" src='images/{{ Auth::user()->name }}Temp.jpg'></img>
				<div class="btn-crop-area text-xs-center">					
					<button id="btn-crop" class="btn btn-primary">Crop</button>
					<div class="alert alert-success crop-alert" role="alert">
						<i class="fa fa-check"></i> Successfully cropped!
					</div>
				</div>

				@else
					You don't have any images yet.
				@endif

			</div>
		</div>
		
	</div>

	<!-- Scripts -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.3.7/js/tether.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.5/js/bootstrap.min.js"></script>
	
	<script src="cropper/dist/cropper.js"></script>
	<script src="js/profileImage.js"></script>
	
</body>

</html>
