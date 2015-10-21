$(function()
{
    if($('.profile').length) {
        $('.connection').on('submit', 'form', function(e){
            createLoader();
            $.ajax({
                type: "POST",
                url: "/friends/relation.json",
                data: $(this).serialize()
            }).done(function( response ) {
                console.log( response );
            }).fail(function( response ) {
                checkAuthenticationStatus(response.status);
            }).always(function( ) {
                removeLoader();
            });
            e.preventDefault();
        });

        $(window).scroll(function(){

            if ($(window).scrollTop() > $('.topbar').height()) {
                if(!$('.profile').hasClass('stick')){
                    $('.profile').addClass('stick');
                }
            } else if($('.profile').hasClass('stick')){
                $('.profile').removeClass('stick');
            }

        });
    }
});