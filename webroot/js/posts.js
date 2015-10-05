//function createComment(comment){
//	var buttons = "";
//	if(getUserId() == comment.user.id) {
//  		buttons = "<div class='actions'>\
//  					<button class='destroy destroyComment'><span class='icon-trash'></span></button>\
//				</div>";
//	}
//
//	return "<div class='comment' data-id='" + comment.id + "'>\
//	<a href='/" + comment.user.slug + "' class='avatar'><img src='/files/avatars/small/" + comment.user.avatar + "'></a>\
//				<div class='commentContent'>\
//			<a href='/" + comment.user.slug + "' class='name'>" + comment.user.name + "</a>: " + comment.content +"\
//			<small class='date'>" +  timeAgo(comment.created_at) + "</small>\
//			" + buttons + "\
//		</div> \
//		</div>";
//}
//
//function createPost(post){
//	var comments = "";
//	var buttons = "";
//
//	$.each( post.comments, function( key , val ) {
//		comments += createComment(val);
//  	});
//
//  	if(getUserId() == post.user.id) {
//  		buttons = "<div class='actions'>\
//					<button class='change'><span class='icon-pencil'></span></button>\
//					<button class='destroy destroyPost'><span class='icon-trash'></span></button>\
//				</div>";
//	}
//
//	return "<div class='postWrapper'><div class='post' data-id='" + post.id + "'>\
//				<div class='postHead'>\
//					<a href='/" + post.user.slug + "' class='avatar'><img src='/files/avatars/small/" + post.user.avatar + "'></a>\
//					<div class='poster'>\
//						<div class='name'><a href='/" + post.user.slug + "'>" + post.user.name + "</a></div>\
//						<small>" + timeAgo(post.created_at) + "</small>\
//					</div>\
//				</div>\
//				<div class='postContent'>" + post.content + "\
//				</div>\
//				" + buttons + "\
//				<div class='comments'>\
//					" + comments + "\
//				</div>\
//				<div  class='addComment'><form method='post' accept-charset='utf-8' action='overview'><div style='display:none;'><input type='hidden' name='_method' value='POST'></div><textarea name='content' placeholder='Jouw reactie' rows='5'></textarea><input type='hidden' name='post_id' value='" + post.id +"'><button class='button green'>Plaatsen</button></form></div>\
//			</div></div>";
//}
//
//function timeAgo(date) {
//	var date = new Date(date).getTime()/1000;
//	var now = new Date(Date.now()).getTime()/1000;
//    var a = {
//    	'jaar' 	: 31536000,
//    	'maand'	: 2592000,
//    	'dag'	: 86400,
//    	'uur'	: 3600,
//    	'minuut': 60,
//    	'seconde': 1
//  	}
//	var a_plural = {
//		'jaar'   : 'jaren',
//		'maand'  : 'maanden',
//		'dag'    : 'dagen',
//		'uur'   : 'uren',
//		'minuut' : 'minuten',
//		'seconde' : 'seconden'
//	}
//
//    var difference = now-date;
//    var timeAgo;
//
//	if (difference < 1)
//	{
//	  return 'Op dit moment';
//	}
//
//    $.each( a, function( key, val ) {
//    	  d = difference / val;
//          if (d >= 1) {
//          	  var r = (d > 1 ? a_plural[key] : key);
//              timeAgo =  Math.round(d) + ' ' + r + ' geleden';
//    	  	  return false;
//          }
//  	});
//
//    return timeAgo;
//}
//
//function smileysToText(content){
//
//	   var smileys = [
//	   		["<span class=\"smiley-1\"></span>", ":)"],
//	   		["<span class=\"smiley-2\"></span>", ":("],
//	   		["<span class=\"smiley-3\"></span>", ":D"],
//	   		["<span class=\"smiley-4\"></span>", ":P"],
//	   		["<span class=\"smiley-5\"></span>", ":'("],
//	   		["<span class=\"smiley-6\"></span>", ":8)"],
//	   		["<span class=\"smiley-7\"></span>", "<3"],
//	   		["<span class=\"smiley-8\"></span>", ":@"],
//	   		["<span class=\"smiley-9\"></span>", "(K)"],
//	   		["<span class=\"smiley-10\"></span>", ":S"],
//	   	];
//
//		$.each(smileys, function( key, val ) {
//			content = content.replace(new RegExp(val[0], 'g'), val[1]);
//		});
//
//
//		return content;
//
//}
//
//function textToSmileys(content){
//
//	   var smileys = [
//	   		["<span class=\"smiley-1\"></span>", "\\:\\)"],
//	   		["<span class=\"smiley-2\"></span>", "\\:\\("],
//	   		["<span class=\"smiley-3\"></span>", "\\:D"],
//	   		["<span class=\"smiley-4\"></span>", "\\:P"],
//	   		["<span class=\"smiley-5\"></span>", "\\:\\'\\("],
//	   		["<span class=\"smiley-6\"></span>", "\\:8"],
//	   		["<span class=\"smiley-7\"></span>", "\\<3"],
//	   		["<span class=\"smiley-8\"></span>", "\\:\\@"],
//	   		["<span class=\"smiley-9\"></span>", "\\(K\\)"],
//	   		["<span class=\"smiley-10\"></span>", "\\:S"],
//	   	];
//
//		$.each(smileys, function( key, val ) {
//			content = content.replace(new RegExp(val[1], 'gi'), val[0]);
//		});
//
//		return content;
//}
//
//$(function() {
//
//
//	$('.posts').on('click', '.change', function(e){
//		$(this).parent().hide();
//		var contentDiv = $(this).closest('.post').find('.postContent');
//		var content = smileysToText(contentDiv.html().replace(/^\s+|\s+$/g,""));
//
//		var changePost = $("<div  class='changePost'><form method='post' action='#'> \
//							<textarea name='content'>" + content + "</textarea> \
//							<button class='button green' type='submit'>Aanpassen</button> \
//							</form></div>");
//		contentDiv.hide();
//		contentDiv.after(changePost);
//		e.preventDefault();
//	});
//
//
//	$('.posts').on('click', '.destroyComment', function(e){
//		var obj = $(this);
//		var comment = obj.closest('.comment');
//		var id = comment.attr('data-id');
//		createLoader(obj.parent(),'');
//		$.ajax({
//		    url: "/comment/delete/" + id + ".json",
//		    success: function(response){
//				comment.slideUp(500);
//		    },
//		    error: function(xhr,err){
//		        alert("readyState: "+xhr.readyState+"\nstatus: "+xhr.status);
//		        alert("responseText: "+xhr.responseText);
//		    }
//		}).done(function( data ) {
//			removeLoader(obj.parent());
//	  	});
//	});
//
//	$('.posts').on('click', '.destroyPost', function(e){
//
//		var obj = $(this);
//		var post = $(this).closest('.post');
//		var id = post.attr('data-id');
//		var deleted = $("<button class='deleted'><a href=''>Post verwijderen ongedaan maken</a></button>");
//		createLoader(obj.parent(), '');
//		$.ajax({
//		    url: "/post/delete/" + id + ".json",
//		    success: function(response){
//		    	console.log(response);
//				post.parent('.postWrapper').append(deleted);
//				post.slideUp(500);
//			},
//		    error: function(xhr,err){
//		        alert("readyState: "+xhr.readyState+"\nstatus: "+xhr.status);
//		        alert("responseText: "+xhr.responseText);
//		    }
//		}).done(function( data ) {
//			removeLoader(obj.parent());
//	  	});
//
//	});
//
//	$('.posts').on('click', '.deleted', function(e){
//		var post = $(this).siblings('.post');
//		var id = post.attr('data-id');
//		var deleted = $(this);
//		createLoader(deleted, 'Post terug halen...');
//		$.ajax({
//		    url: "/post/undelete/" + id + ".json",
//		    success: function(response){
//				removeLoader(deleted);
//		    	deleted.remove();
//			 	post.slideDown(500);
//		    },
//		    error: function(xhr,err){
//		        alert("readyState: "+xhr.readyState+"\nstatus: "+xhr.status);
//		        alert("responseText: "+xhr.responseText);
//		    }
//		}).done(function( data ) {
//			removeLoader(deleted);
//	  	});
//		e.preventDefault();
//	});
//
//	$('.posts').on('submit', '.changePost form', function(e){
//		var obj = $(this);
//		var id = obj.closest('.post').attr('data-id');
//		var content = obj.closest('.post').find('.postContent');
//		createLoader(obj, 'Saving post...');
//		$.ajax({
//		    type: "POST",
//		    url: "/post/edit/" + id + ".json",
//		    data: $(this).serialize(),
//		    success: function(response){
//		    	content.html(textToSmileys(obj.find('textarea').val().replace(/(<([^>]+)>)/ig,"")));
//		    },
//		    error: function(xhr,err){
//		        alert("readyState: "+xhr.readyState+"\nstatus: "+xhr.status);
//		        alert("responseText: "+xhr.responseText);
//		    }
//		}).done(function( data ) {
//			removeLoader(obj);
//			obj.closest('.post').find('.actions').show();
//	    	content.show();
//	    	obj.remove();
//	  	});
//		e.preventDefault();
//	});
//
//	$('.createPost form').on('submit', function(e){
//			var obj = $(this);
//			createLoader(obj, 'Saving post...');
//			$.ajax({
//			    type: "POST",
//			    url: "post/create.json",
//			    data: $(this).serialize(),
//			    success: function(response){
//			    	$('.posts').prepend(createPost(response['post']));
//	    			obj.find('textarea').val('');
//			    },
//			    error: function(xhr,err){
//			        alert("readyState: "+xhr.readyState+"\nstatus: "+xhr.status);
//			        alert("responseText: "+xhr.responseText);
//			    }
//			}).done(function( data ) {
//				removeLoader(obj);
//		  	});
//		e.preventDefault();
//	});
//
//	$('.posts').on('submit', '.addComment form', function(e){
//		var obj = $(this);
//		var comments = obj.parent().parent().find('.comments');
//		createLoader(obj, 'Saving comment...');
//		$.ajax({
//		    type: "POST",
//		    url: "/comment/create.json",
//		    data: $(this).serialize(),
//		    success: function(response){
//    			comments.append(createComment(response));
//    			obj.find('textarea').val('');
//		    },
//		    error: function(xhr,err){
//		        alert("readyState: "+xhr.readyState+"\nstatus: "+xhr.status);
//		        alert("responseText: "+xhr.responseText);
//		    }
//		}).done(function( data ) {
//			removeLoader(obj);
//	  	});
//		e.preventDefault();
//	});
//
//	$('.createPost, .addComment').on( 'change keyup keydown paste cut', 'textarea', function (){
//		$(this).height(0).height(this.scrollHeight - 20);
//	});
//
//	$('.createPost textarea').blur(function(){
//		var form = $(this).closest('.createPost');
//		if(!form.find('textarea').val()) {
//			form.removeClass("focus");
//			form.find('.button').hide();
//		}
//	}).focus(function() {
//		$('.createPost').addClass("focus")
//		$(".createPost .button").show();
//	});
//
//	$('.posts').on('blur', 'textarea', function() {
//		var form = $(this).closest('.addComment');
//		if(!form.find('textarea').val()) {
//			form.removeClass("focus");
//			form.find('.button').hide();
//		}
//	});
//
//	$('.posts').on('focus', 'textarea', function() {
//		var form = $(this).closest('.addComment');
//		form.addClass("focus");
//		form.find('.button').show();
//	});
//
//	$(".createPost .button").hide();
//	$(".addComment .button").hide();
//
//	if($('.posts').length) {
//		var currently = false;
//		$(window).scroll(function(){
//			if ($(window).scrollTop() >= $(document).height() - $(window).height() - 1000 && currently == false){
//				currently = true;
//				var user = $('.posts').attr('data-profile');
//				var data = {offset: $('.posts .postWrapper').length}
//				if (typeof user !== typeof undefined && user !== false) {
//				    data.user_id = user;
//				}
//				$('.posts').append('<div class="loader"><img src="/img/ajax-loader.gif">Meer posts worden geladen.</div>');
//				$.ajax({
//				    type: "POST",
//				    url: "/posts.json",
//				    data: data,
//				    success: function(response){
//						$.each( response.posts, function( key, val ) {
//	            			$('.posts').append(createPost(val));
//							$(".addComment .button").hide();
//					  	});
//					},
//				    error: function(xhr,err){
//				        alert("readyState: "+xhr.readyState+"\nstatus: "+xhr.status);
//				        alert("responseText: "+xhr.responseText);
//				    }
//				}).done(function( data ) {
//					$('.posts .loader').remove();
//				  	currently = false;
//	  			});
//	  		}
//		});
//	}
//
//});
function createPost(data)
{
    comments = '';

    if(data.comments.length > 0) {
    	comments += "<div class='comments'>";
        $.each( data.comments, function( value ) {
            comments += createComment(value);
        });
        comments += "</div>";
    }

    post = "<div class='postWrapper'>\
                <div class='post'>\
                    <div class='postHead'><a href='/" + data.user.slug + ">" + data.user.name + "</a></div>\
                    <div class='postContent'>" + data.content + "</div>\
                </div>\
                <div class='comments'>" + comments + "</div>\
            </div>";

    return post;
}

function createComment(data)
{
    comment = "<div class='comment'><a href='/" + comment.user.slug + ">" + comment.user.name + "</a>: " + comment.content + "</div>";
    return comment;
}

$(function()
{
    if($('.posts').length) {
        if ($(window).scrollTop() >= $(document).height() - $(window).height() - 1000) {

            var user = $('.posts').attr('data-user');
            var offset =  $('.posts .post').length;
            var data = {offset: offset, user : user};

            $.ajax({
                type: "POST",
                url: "/posts.json",
                data: data
            }).done(function( data ) {

            }).fail(function( ) {

            }).always(function( ) {
                // remove loader
            });
        }
    }

	$('.createPost form').on('submit', function(e){
        $.ajax({
            type: "POST",
            url: "/posts/add.json",
            data: $(this).serialize()
        }).done(function( data ) {
            $('.posts').prepend(createPost(data['post']));
        }).fail(function( ) {

        }).always(function( ) {

        });
        e.preventDefault();
    });

    $('.posts').on('submit', '.createComment form', function(e){
        var comments = $(this).parent().parent().find('.comments');
        $.ajax({
            type: "POST",
            url: "/comments/add.json",
            data: $(this).serialize()
        }).done(function( data ) {
            comments.append(createPost(data['comment']));
        }).fail(function( ) {

        }).always(function( ) {

        });
        e.preventDefault();
    });

    $('.posts').on('submit', '.karma form', function(e){

        $.ajax({
            type: "POST",
            url: "/posts/karma.json",
            data: $(this).serialize()
        }).done(function( data ) {

        }).fail(function( ) {

        }).always(function( ) {

        });
        e.preventDefault();
    });

});
