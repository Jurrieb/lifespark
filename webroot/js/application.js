$(function () {
    $(document).on('click', '.dropdown', function() {
        var $self = $(this);
        if($self.parent().find('.dropdown-menu').length > 0){
        $self.parent().find('.dropdown-menu').slideUp( "fast", function() {
            $(this).remove();
        });
        } else {
            var actions = $self.data("actions").split(" ");
            var $buttons = '';

            $.each(actions, function( key, action ) {
                $buttons += '<li><button class="' + action + '">' + action + '</button></li>';
            });

            var $dropdown = $('<ul class="dropdown-menu">' + $buttons + '</ul>').hide();
            $self.parent().append($dropdown);
            $dropdown.slideDown( "fast");
        }
    });

    $(document).on('click', '.dropdown-menu button', function() {
        $self = $(this);
        $self.closest('.dropdown-menu').slideUp( "fast", function() {
            $(this).remove();
        });
    });


});

function timeAgo(date) {
    var date = new Date(date).getTime() / 1000;
    var now = new Date(Date.now()).getTime() / 1000;

    var a = {
        'jaar': 31536000,
        'maand': 2592000,
        'dag': 86400,
        'uur': 3600,
        'minuut': 60,
        'seconde': 1
    };

    var a_plural = {
        'jaar': 'jaren',
        'maand': 'maanden',
        'dag': 'dagen',
        'uur': 'uren',
        'minuut': 'minuten',
        'seconde': 'seconden'
    };

    var difference = now - date;
    var timeAgo;

    if (difference < 1)
    {
        return 'Op dit moment';
    }

    $.each(a, function (key, val) {
        d = difference / val;
        if (d >= 1) {
            var r = (d > 1 ? a_plural[key] : key);
            timeAgo = Math.round(d) + ' ' + r + ' geleden';
            return false;
        }
    });

    return timeAgo;
}

function createFlashMessage(type, message)
{
    message = "<div class='message " + type + "'>" + message + "</div>";
    $(".content").prepend(message);
}


function createLoader()
{

}

function removeLoader()
{

}

function checkAuthenticationStatus(code)
{
    if(code == 401) {
        window.location.replace(location.protocol + "//" + location.host + "/users/login");
        return;
    }

}

function smileyToText(content) {

    var smileys = [
        ["<span class=\"smiley-1\"></span>", ":)"],
        ["<span class=\"smiley-2\"></span>", ":("],
        ["<span class=\"smiley-3\"></span>", ":D"],
        ["<span class=\"smiley-4\"></span>", ":P"],
        ["<span class=\"smiley-5\"></span>", ":'("],
        ["<span class=\"smiley-6\"></span>", ":8)"],
        ["<span class=\"smiley-7\"></span>", "<3"],
        ["<span class=\"smiley-8\"></span>", ":@"],
        ["<span class=\"smiley-9\"></span>", "(K)"],
        ["<span class=\"smiley-10\"></span>", ":S"]
    ];

    $.each(smileys, function (key, val) {
        content = content.replace(new RegExp(val[0], 'g'), val[1]);
    });

    return content;

}

function textToSmiley(content) {

    var smileys = [
        ["<span class=\"smiley-1\"></span>", "\\:\\)"],
        ["<span class=\"smiley-2\"></span>", "\\:\\("],
        ["<span class=\"smiley-3\"></span>", "\\:D"],
        ["<span class=\"smiley-4\"></span>", "\\:P"],
        ["<span class=\"smiley-5\"></span>", "\\:\\'\\("],
        ["<span class=\"smiley-6\"></span>", "\\:8"],
        ["<span class=\"smiley-7\"></span>", "\\<3"],
        ["<span class=\"smiley-8\"></span>", "\\:\\@"],
        ["<span class=\"smiley-9\"></span>", "\\(K\\)"],
        ["<span class=\"smiley-10\"></span>", "\\:S"]
    ];

    $.each(smileys, function (key, val) {
        content = content.replace(new RegExp(val[1], 'gi'), val[0]);
    });

    return content;
}