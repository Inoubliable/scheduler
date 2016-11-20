$(document).ready(function() {
	
	var day;
	var month;
	var year;
	var startDate;
	
	var currentUser = $(".username").text();
	
	function usersToArray() {
		var allUsers = $(".all-users-list li").toArray();
		var chosen = [currentUser];
		
		for (var i = 0; i < allUsers.length; i++) {
			
			if(allUsers[i].className.includes("list-group-item-success")){
				chosen.push($.trim(allUsers[i].innerText));
			}
		}
		
		return chosen;
	}
	
	function arrayToString(id) {
		var arr = $("#" + id + " td").toArray();
		var arrstring = "";
		
		for (var i = 0; i < arr.length; i++) {
			if(arr[i].className.includes("red")){
				arrstring += 1;
			} else {
				arrstring += 0;
			}
		}
		
		return arrstring;

	}
	
	function stringToArray(bits, id, colour) {
		var arr = $("#" + id + " td").toArray();
		
		for (var i = 0; i < arr.length; i++) {
			if(bits[i] == 1){
				arr[i].className = colour;
			}
		}
	}
	
	function setDays(day, month, scheduleId) {
		
		day = parseInt(day, 10);
		month = parseInt(month, 10);
		
		var d = new Date();
		d.setMonth(month - 1, day);
		var week = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
		var weekdayNum = d.getDay();
		var weekday;
		
		if(scheduleId != "none") {
			$("#" + scheduleId + " .days-headers").each( function (index) {
				$(this).find(".dates").text(day + "." + month + ".");
				weekday = week[weekdayNum];
				$(this).find(".days").text(weekday);
				day += 1;
				weekdayNum += 1;
				if (day == 29 && month == 2) {
					day = 1;
					month += 1;	
				} else if (day == 32 && month == 12) {
					day = 1;
					month = 1;	
				} else if (day == 31) {
					if (month == 4 || month == 6 || month == 9 || month == 11) {
						day = 1;
						month += 1;	
					}
				} else if (day == 32) {
					if (month == 1 || month == 3 || month == 5 || month == 7 || month == 8 || month == 10) {
						day = 1;
						month += 1;	
					}
				} 
			});
		}
		
	}
	
	// mark hours
	var mousedown = false;
	
	$("td").on("mousedown", function (e) {
		mousedown = true;
		e.preventDefault();
		$(this).toggleClass("red");
	})
	.on("mouseover", function() {
		if(mousedown){
			$(this).toggleClass("red");
		}
	});
  
  	$(document).on("mouseup", function () {
      	mousedown = false;
    });
	
	// convert and post data 
	$(".confirm").on("click", function () {
		
		$(this).hide();
		
		var scheduleId = $(this).siblings('.card').find('.table').attr('id');
		var arrstring = arrayToString(scheduleId);
		
		$.post( "/personalSchedules", { personalSchedule: arrstring, currentUser: currentUser, scheduleId: scheduleId } )
			.done(function( data ) {
			
				$("#" + scheduleId + " td").each( function() {
					$(this).removeClass("rose");
				});
			
				stringToArray(data.freeTime, scheduleId, "red");
			
				$("#" + scheduleId).closest('.row').find('.names').html(''); // empty names list
			
				$.each( data.usersDone, function (index, user) {
					if (user['image']) {
						$img = "<img src='images/" + user['image'] + "'>";
					} else {
						$img = "<i class='fa fa-user-secret'></i>";
					}
					$("#" + scheduleId).closest('.row').find('.names').prepend("<li class='list-group-item list-group-item-action'>" + $img + user['name'] + "</li>");
				});
			
				$.each( data.usersUndone, function (index, user) {
					if (user['image']) {
						$img = "<img src='images/" + user['image'] + "'>";
					} else {
						$img = "<i class='fa fa-user-secret'></i>";
					}
					$("#" + scheduleId).closest('.row').find('.names').append("<li class='list-group-item list-group-item-action undone'>" + $img + user['name'] + "</li>");
				});
			
			});
		
	});
	
	$(".main-tables").each( function () {
		var id = $(this).attr("id");
		var day = $(this).data("day");
		var month = $(this).data("month");
		setDays(day, month, id);
	
		var bits = $(this).data("bits");
		stringToArray(bits, id, "rose");
	});
	
	$(".all-users-list li").click(function(e) {
		e.stopPropagation();
		$(this).toggleClass("list-group-item-success");
	});
	
	$("#btn-new-schedule").click(function() {
		
		$(this).hide();
		$("#left-section .card").slideDown(200);
	
		$("#datepicker").datepicker({ minDate: 0, maxDate: "+6M" }); // restrict datepicker range
		$("#datepicker").datepicker( "option", "dateFormat", "d'.'mm'.'yy" );
		
	});
	
	$("#btn-send-date").click(function() {
		
		var date = $("#datepicker").val();
		var parsedDate = $.datepicker.parseDate( "d'.'mm'.'yy", date );
		day = parsedDate.getDate();
		month = parsedDate.getMonth() + 1;
		year = parsedDate.getFullYear();
		
		startDate = year + "-" + month + "-" + day;
		
		$(this).hide();
		$("#left-section .card").hide();
		
		var users = usersToArray();
		var title = $("#title-input").val();
		
		$.post( "/home", { title: title, startDate: startDate, users: users } )
			.done(function(schedules) {
			
				location.reload(); // for now just reload page
			
			});
		
	});
	
	$('.remove-schedule').click(function() {
		
		// maybe ask for confirmation
		var removeBtn = $(this);
		
		var scheduleId = removeBtn.closest('.schedule-card').find('table').attr('id');
		
		$.post('/removeSchedule', {scheduleId: scheduleId}, function() {
			
			// remove schedule on client side
			removeBtn.closest('.row').remove();
			
		});
		
	});
	
	$('.add-name').click(function() {
		
		var addName = $(this);
		var addNameParent = addName.closest('.dropdown-menu');
		
		var scheduleId = addName.closest('.names-container').data('schedule-id');
		var userId = addName.data('id');
		
		$.post('/scheduleUser', {scheduleId: scheduleId, userId: userId}, function(newUser) {
			
			if (newUser.image) {
				$img = "<img src='images/" + newUserimage + "'>";
			} else {
				$img = "<i class='fa fa-user-secret'></i>";
			}
			addName.closest('.add-name-btn-group').siblings('.names').append("<li class='list-group-item list-group-item-action undone'>" + $img + newUser.name + "</li>");
			
			addName.remove();
			
			if ($.trim(addNameParent.text()) == '' ) {
				addNameParent.html('<div class="dropdown-item">All friends already added.</div>');
			}
			
		});
		
	});
	
	// Ensure CSRF token is sent with AJAX requests
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	
});