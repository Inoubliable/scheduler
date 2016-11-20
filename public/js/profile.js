$(document).ready(function() {
	
	$('#add-friend').click(function() {
		
		$currentUser = $('.username').text();
		$friend = $('h4').text();
		
		$.post('/addFriend', {currentUsername: $currentUser, friend: $friend}, function(data) {
			
			$('#add-friend').hide();
			$('#left-section').append('<button class="btn btn-success"><i class="fa fa-check"></i> Friend</button>');
			
		});
		
	});

	// Ensure CSRF token is sent with AJAX requests
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	
});