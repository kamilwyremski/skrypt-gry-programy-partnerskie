(function($) {
    $(function() {
        var jcarousel = $('.jcarousel');

        jcarousel.jcarousel({
                wrap: 'circular'
            })
			.jcarouselAutoscroll({
				interval: 118000,
				target: '+=1'
			});

        $('.jcarousel-control-prev')
            .jcarouselControl({
                target: '-=1'
            });

        $('.jcarousel-control-next')
            .jcarouselControl({
                target: '+=1'
            });

    });
})(jQuery);
