function createPost(object)
{
    comments = '';

    if(object.comments.length > 0) {
    	comments += "<div class='comments'>";
        $.each( object.comments, function( value ) {
            comments += createComment(value);
        });
        comments += "</div>";
    }

    if(object.profile) {
        profile = " >> <a href='/'" + object.profile.slug + " class='name'>" + object.profile.name + "</a>";
    } else {
        profile = '';
    }

    var post = "<div class='post-wrapper'>\
                    <div class='post' data-id='" + object.id + "'>\
                        <div class='post-head'>\
                             <div class='avatar'><img src='/'" + object.user.avatar + "></div>\
                             <div class='post-information'>\
                                <a href='/'" + object.user.slug + " class='name'>" + object.user.name + "</a>\
                                " + profile + "\
                             </div>\
                             <button  type='button' class='dropdown' data-actions='update delete'><span class='icon-more_vert'></span></button>\
                         </div>\
                        <div class='post-content'>" + object.content + "</div>\
                        <div class='comments'>" + comments + "</div>\
                        <div class='create-comment'>" + createCommentForm(object.id) + "</div>\
                    </div>\
                </div>";
    return post;
}

function createComment( object )
{
    var comment = "<div class='comment' data-id='" + object.id + "'>\
                    <div class='avatar'><img src='/'" + object.user.avatar + "></div>\
                    <div class='comment-information'>\
                        <div class='name'><a href='/'" + object.user.slug + ">" + object.user.name + "</a></div>\
                        <div class='date'>" + timeAgo(object.created_at) + "</div>\
                    </div>\
                    <div class='comment-content'>" + object.content + "</div>\
                    <button  type='button' class='dropdown' data-actions='delete'><span class='icon-more_vert'></span></button>\
                </div>";
    return comment;
}

function createCommentForm(id){
    var form = "<form method='post'>\
                    <input type='hidden' name='post_id' value='" + id +"'>\
                    <textarea name='content' placeholder='Plaats een reactie' rows='5'></textarea>\
                    <button class='button green' type='submit'>Plaatsen</button>\
                </form>";
    return form;
}

function updatePostForm(id, content) {
    var form = "<form class='update-post'>\
                    <input type='hidden' name='id' value='" + id + "'>\
                    <textarea name='content'>" + content + "</textarea>\
                    <button type='submit' class='button green'>Veranderen</button>\
                </form>";
    return form;
}

function loadMorePosts() {

    var offset = $('.posts .post').length;
    var userId = $('.posts').attr('data-user-id');
    var data = {offset: offset, user_id : userId};

    createLoader();
    $.ajax({
        type: "POST",
        url: "/posts.json",
        data: data
    }).done(function( response ) {
        console.log(response);
    }).fail(function( response ) {
        checkAuthenticationStatus(response.status);
    }).always(function( ) {
        removeLoader();
    });
}

$(function()
{
    $('.block').on('focus', '.create-post textarea', function() {
        var form = $(this).closest('form');
        form.addClass("focus");
        form.find('.button').show();
    });

    $('.block').on('blur', '.create-post textarea', function() {
        var form = $(this).closest('form');
        if(!form.find('textarea').val()) {
            form.removeClass("focus");
            form.find('.button').hide();
        }
    });

    $('.block').on('focus', '.create-comment textarea', function() {
        var form = $(this).closest('form');
        form.addClass("focus");
        form.find('.button').show();
    });

    $('.block').on('blur', '.create-comment textarea', function() {
        var form = $(this).closest('form');
        if(!form.find('textarea').val()) {
            form.removeClass("focus");
            form.find('.button').hide();
        }
    });

    if ($('.posts').length) {

//        if ($(window).scrollTop() + $(window).height() > $(document).height() - 400) {
//            loadMorePosts();
//        }

        $('.create-post form').on('submit', function(e){
            $self = $(this);
            $posts = $('.posts');
            createLoader();
            $.ajax({
                type: "POST",
                url: "/posts/create.json",
                data: $(this).serialize()
            }).done(function( response ) {
                var $post = $(createPost(response.post)).hide();
                $posts.prepend($post);
                $post.slideDown( "fast");
                $self.find('textarea').val('');
            }).fail(function( response ) {
                checkAuthenticationStatus(response.status);
            }).always(function( ) {
                removeLoader();
            });
            e.preventDefault();
        });

        $('.posts').on('submit', '.create-comment form', function(e){
            $self = $(this);
            $post = $self.closest('.post');
            $comments = $post.find('.comments');
            createLoader();
            $.ajax({
                type: "POST",
                url: "/comments/create.json",
                data: $(this).serialize()
            }).done(function( response ) {
                var $comment = $(createComment(response.comment)).hide();
                $comments.prepend($comment);
                $comment.slideDown( "fast");
                $self.find('textarea').val('');
            }).fail(function( response ) {
                checkAuthenticationStatus(response.status);
            }).always(function( ) {
                removeLoader();
            });
            e.preventDefault();
        });

        $('.posts').on('click', '.post-head .update', function(e){
            var $self = $(this);
            var $post = $self.closest('.post');
            var $content = $post.find('.post-content');
            var id = $post.attr('data-id');

            createLoader();
            $.ajax({
                type: "POST",
                url: '/posts/view/'+ id +'.json'
            }).done(function( response ) {
                $content.html(updatePostForm(response.post.id, response.post.content));
            }).fail(function( response ) {
                checkAuthenticationStatus(response.status);
            }).always(function( ) {
                removeLoader();
            });

            e.preventDefault();
        });

        $('.posts').on('submit', '.post .update-post',  function(e){
            var $self = $(this);
            var $post = $self.closest('.post');
            var $content = $post.find('.post-content');
            var id = $post.attr('data-id');

            createLoader();
            $.ajax({
                type: 'POST',
                url: '/posts/update/' + id + ' .json',
                data: $(this).serialize()
            }).done(function( response ) {
                $content.text(response.post.content);
                $self.slideUp( "fast", function() {
                    $(this).remove();
                });
            }).fail(function( response ) {
                checkAuthenticationStatus(response.status);
            }).always(function( ) {
                removeLoader();
            });

            e.preventDefault();
        });

        $('.posts').on('click', '.post-head .delete', function(e){
            var $self = $(this);
            var $post = $self.closest('.post');
            var id = $post.attr('data-id');

            createLoader();
            $.ajax({
                type: "POST",
                url: '/posts/delete/' + id + '.json'
            }).done(function( response ) {
                $post.closest('.post-wrapper').slideUp( "fast", function() {
                    $(this).remove();
                });
            }).fail(function( response ) {
                checkAuthenticationStatus(response.status);
            }).always(function( ) {
                removeLoader();
            });

            e.preventDefault();
        });


        $('.posts').on('click', '.comment .delete', function(e){
            var $self = $(this);
            var $comment = $self.closest('.comment');
            var id = $comment.attr('data-id');

            createLoader();
            $.ajax({
                type: "POST",
                url: '/comments/delete/' + id + '.json'
            }).done(function( response ) {
                $comment.slideUp( "fast", function() {
                    $(this).remove();
                });
            }).fail(function( response ) {
                checkAuthenticationStatus(response.status);
            }).always(function( ) {
                removeLoader();
            });

            e.preventDefault();
        });

    }
});
