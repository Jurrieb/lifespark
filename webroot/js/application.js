$(function() {

	$('body,html').bind('scroll mousedown DOMMouseScroll mousewheel keyup', function(e){
		if ( e.which > 0 || e.type == "mousedown" || e.type == "mousewheel"){
			$("html,body").stop();
		}
	});

	function calculateMetrics() {
		$( ".metrics .metric" ).each( function( index, element ){
			var unit = $( this ).find('.unit');
			var inc = parseInt($(this).attr('data-inc'));
			var unitdata = parseInt(unit.text());

			unit.text(  unitdata + Math.floor(Math.random()*((inc)-(inc*0.8)+1)+(inc*0.8)) );

		});
		setTimeout(calculateMetrics,2000);
	}

	calculateMetrics();

	$( ".menu a" ).on( "click", function(e) {

		$('html,body').stop().animate({
			scrollTop: ($($(this).attr("href")).offset().top - $('.topbar-wrapper').height())
		}, 400);

		e.preventDefault();
	});

    var windowHeight = $(window).height();
    var docHeight = $(document).height();

	$(window).scroll(function(){

        var windowPos = $(window).scrollTop();

		if (windowPos + $('.topbar-wrapper').height() > 100) {
			if(!$('.topbar-wrapper').hasClass('stick')){
				$('.topbar-wrapper').animate({
					padding: 0,
				}, { duration: 500, queue: false }).children('topbar').css({"border-bottom" : "1px solid #ddd"});
				$('.topbar-wrapper').addClass('stick');
			}
		}else if($('.topbar-wrapper').hasClass('stick')){
			$('.topbar-wrapper').animate({
				padding: "20px",
			}, { duration: 500, queue: false });
			$('.topbar-wrapper').removeClass('stick');
		}

		$.each( $(".menu li a"), function( key, value ) {
			if($(value).length) {
				var obj = $($(value).attr("href"));

				if( windowPos+ $('.topbar-wrapper').height() >=  $(obj).offset().top && windowPos+ $('.topbar-wrapper').height() < ($(obj).outerHeight()+$(obj).offset().top)) {
					$(this).addClass('active');
				} else {
					$(this).removeClass('active');
				}
			}
		});

		if( windowPos + windowHeight == docHeight ) {
			if (!$(".menu li:last-child a").hasClass("active")) {
                $(".menu li a").removeClass("active");
                $(".menu li:last-child a").addClass("active");
            }
		}

    }).trigger('scroll');

});