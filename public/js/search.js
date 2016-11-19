$(document).ready(function() {
	
	// implement "instant" search
	$('#search').keyup(function() {
		
		$.get('/search', { keyword: $(this).val() }, function(results) {
			$('#search-list').html('');
			
			$.each(results, function(index, result) {
				$('#search-list').append('<a href="/profile/' + result.id + '" class="list-group-item">' + result.name + '<br><small class="text-muted">' + result.email + '</small></a>');
			});
			
		});
		
	});
	
});