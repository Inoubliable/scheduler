$(document).ready(function() {
	
	var username = $(".username").text();
	
	$("#profilePictureTemp").on("change", function() {
		var imgName = this.files[0].name;
		$("#profilePictureForm label").text(imgName);
	});
	
	var x;
	var y;
	var w;
	var h;
	
	$("#image").cropper({
		aspectRatio: 1 / 1,
		crop: function (e) {
			x = e.x;
			y = e.y;
			w = e.width;
			h = e.height;
		},
		viewMode: 1,
		center: false,
		guides: false,
		background: false,
		modal: true,
		movable: false,
		rotatable: false,
		scalable: false,
		zoomable: false,
		preview: ".user-img-preview"
	});

	$("#btn-crop").click(function() {
		
		$.post( "/profileImage", { x: x, y: y, width: w, height: h } )
			.done(function(data) {
				$(".crop-alert").fadeTo(100, 1).delay(2000).fadeOut(500);
			});
						 
	});

	// Ensure CSRF token is sent with AJAX requests
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	
});