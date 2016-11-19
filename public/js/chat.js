$(document).ready(function () {

	var currentUser = $('.username').text();
	var currentUserId = $('.username').attr('id');
	var currentChatters = [];

	// open chat with clicked user
	$('#users-list li').click(function () {
		var chatWith = $(this).text();
		chatWith = $.trim(chatWith);

		// prevent multiple chat windows with same person
		if ($.inArray(chatWith, currentChatters) == -1) {
			currentChatters.push(chatWith);

			$('#all-chats').append('<div class="chat-container text-xs-center"><div class="chat-header">' + chatWith + '<span class="close-chat float-xs-right">&times;</span></div><ul class="replies list-group text-xs-left"></ul><div class="chat-form-container"><form action="/chat" method="post" class="chat-form"><div class="input-group"><input type="text" class="myReply form-control" placeholder="Your message..."><span class="input-group-btn"><button class="btn btn-success" type="submit">Send</button></span></div></form></div></div>');
			
			$('.myReply').last().focus(function() {
				
				var data = { chatWith: chatWith };
				
				$.get('/chatFocus', data, function(data) {
					
					if(data.unseenChats != 0) {
						
						$html = '<a href="/chat">Chat</a>' +					
								'<span id="chatTag" class="tag tag-pill tag-danger">' +
									data.unseenChats +
								'</span>';
						
					} else {
						$html = '<a href="/chat">Chat</a>';
					}
					
					$('#nav-chat').html( $html );
					
				});
				
			});
			
			$('.myReply').last().focus();
			
			$('.close-chat').last().click(function() {
				var name = $(this).parents('.chat-header').text().slice(0, -1); // get corresponding name without x
				var index = currentChatters.indexOf(name);
				currentChatters.splice(index, 1);
				$(this).parents('.chat-container').remove();
			});

			// get chat history
			var users = {
				chatWith: chatWith
			};
			$.get('/chatHistory', users).done(function (data) {

				if (!data[0]) {
					$('.replies').last().append('<div class="no-messages">There were no messages.</div>');
				} else {
					$.each(data, function (index, reply) {
						$('.replies').last().append('<li class="list-group-item"><b>' + reply.username + ':</b> ' + reply.reply + '</li>');
						$('.replies').last().scrollTop($('.replies').last()[0].scrollHeight);
					});
				}
				
			});

			$('.chat-form').last().submit(function (e) {
				e.preventDefault();

				var thisForm = $(this);

				var reply = thisForm.find('.myReply').val();
				thisForm.parent().siblings('.replies').append('<li class="list-group-item"><b>' + currentUser + ':</b> ' + reply + '</li>');
				thisForm.parent().siblings('.replies').scrollTop(thisForm.parent().siblings('.replies')[0].scrollHeight);
				var chatWith = thisForm.parent().siblings('.chat-header').text().slice(0, -1); // get username without x

				// Build POST data and make AJAX request
				var data = {
					currentUser: currentUser,
					currentUserId: currentUserId,
					chatWith: chatWith,
					reply: reply
				};
				$.post('/chat', data);

				// clear input
				$('.myReply').val('');
			});
		}

	});

	// log pusher information in chromeDevTools
	Pusher.log = function (msg) {
		console.log(msg);
	};

	var pusher = new Pusher("b070815da8de3077aa89", {
		cluster: 'eu'
	});
	var channel = pusher.subscribe('privat-' + currentUserId);
	channel.bind('new-reply', function (data) {

		$('.replies').append('<li class="list-group-item"><b>' + data.author + ':</b> ' + data.reply + '</li>');

		$('.replies').scrollTop($('.replies')[0].scrollHeight);

	});

	// Ensure CSRF token is sent with AJAX requests
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

});