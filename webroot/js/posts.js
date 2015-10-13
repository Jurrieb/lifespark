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

    var post = "<div class='post-wrapper'>\
                    <div class='post'>\
                        <div class='post-head'>\
                             <div class='avatar'><img src='/'" + data.user.avatar + "></div>\
                             <div class='post-information'>\
                                 <a href='/'" + data.user.slug + " class='name'>" + data.user.name + "</a>\
                                 <div class='date'>" + timeAgo(data.created_at) + "</div>\
                             </div>\
                             <button class='dropup'><span class='icon-more_vert'></span></button>\
                         </div>\
                        <div class='post-content'>" + data.content + "</div>\
                    </div>\
                    <div class='comments'>" + comments + "</div>\
                </div>";

    return post;
}

function createComment(data)
{
    var comment = "<div class='comment'>\
                    <div class='avatar'><img src='/'" + data.user.avatar + "></div>\
                    <div class='comment-information'>\
                        <div class='name'><a href='/'" + data.user.slug + ">" + data.user.name + "</a></div>\
                        <div class='date'>" + timeAgo(data.created_at) + "</div>\
                    </div>\
                    <div class='comment-content'>" + data.content + "</div>\
                    <button class='dropup'><span class='icon-more_vert'></span></button>\
                </div>";
    return comment;
}

$(function()
{

    if($('.create-post').length) {
        $('.create-post').on('focus', 'textarea', function() {
            var form = $(this).closest('form');
            form.addClass("focus");
            form.find('.button').show();
        });

        $('.create-post').on('blur', 'textarea', function() {
            var form = $(this).closest('form');
            if(!form.find('textarea').val()) {
                form.removeClass("focus");
                form.find('.button').hide();
            }
        });
    }

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

	$('.create-post form').on('submit', function(e){
        $.ajax({
            type: "POST",
            url: "/posts/create.json",
            data: $(this).serialize()
        }).done(function( data ) {
            $('.posts').prepend(createPost(data['post']));
        }).fail(function( ) {

        }).always(function( ) {

        });
        e.preventDefault();
    });

    $('.posts').on('submit', '.create-comment form', function(e){
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
