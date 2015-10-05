$(function()
{
    $('.connection').on('submit', 'form', function(e){
        $.ajax({
            type: "POST",
            url: "/friends/relation.json",
            data: $(this).serialize()
        }).done(function( response ) {
            console.log( response );
        }).fail(function( ) {

        }).always(function( ) {

        });
        e.preventDefault();
    });
});