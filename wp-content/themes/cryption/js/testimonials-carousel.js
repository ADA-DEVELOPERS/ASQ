(function($) {'use strict';
	$(function() {

		$('.ct-testimonials').each(function() {

			var $testimonialsElement = $(this);

			var $testimonials = $('.ct-testimonial-item', $testimonialsElement);

			var $testimonialsWrap = $('<div class="ct-testimonials-carousel-wrap"/>')
				.appendTo($testimonialsElement);
			var $testimonialsCarousel = $('<div class="ct-testimonials-carousel"/>')
				.appendTo($testimonialsWrap);
			if($testimonialsElement.hasClass('fullwidth-block')) {
				$testimonialsCarousel.wrap('<div class="container" />');
			}
			var $testimonialsNavigation = $('<div class="ct-testimonials-navigation"/>')
				.appendTo($testimonialsWrap);
			var $testimonialsPrev = $('<a href="#" class="ct-prev ct-testimonials-prev"/></a>')
				.appendTo($testimonialsNavigation);
			var $testimonialsNext = $('<a href="#" class="ct-next ct-testimonials-next"/></a>')
				.appendTo($testimonialsNavigation);
			var $testimonialsPagination = $('<div class="testimonials_paginantion"/></div>')
				.appendTo($testimonialsNavigation);

			$testimonials.appendTo($testimonialsCarousel);

		});

		$('body').updateTestimonialsCarousel();
		$('.fullwidth-block').each(function() {
			$(this).on('updateTestimonialsCarousel', function() {
				$(this).updateTestimonialsCarousel();
			});
		});
		$('.ct_tab').on('tab-update', function() {
			$(this).updateTestimonialsCarousel();
		});
		$('.ct_accordion_content').on('accordion-update', function() {
			$(this).updateTestimonialsCarousel();
		});

	});

	$.fn.updateTestimonialsCarousel = function() {
		$('.ct-testimonials', this).add($(this).filter('.ct-testimonials')).each(function() {
			var $testimonialsElement = $(this);

			var $testimonialsCarousel = $('.ct-testimonials-carousel', $testimonialsElement);
			var $testimonials = $('.ct-testimonial-item', $testimonialsCarousel);
			var $testimonialsPrev = $('.ct-testimonials-prev', $testimonialsElement);
			var $testimonialsNext = $('.ct-testimonials-next', $testimonialsElement);
			var $testimonialsPagination = $('.testimonials_paginantion', $testimonialsElement);
			$testimonialsElement.ctPreloader(function() {
			console.log($testimonialsPagination);
				var $testimonialsView = $testimonialsCarousel.carouFredSel({
					auto: ($testimonialsElement.data('autoscroll') > 0 ? $testimonialsElement.data('autoscroll') : false),
					circular: true,
					infinite: true,
					width: '100%',
					height: 'auto',
					items: 1,
					align: 'center',
					pagination: false,
					responsive: true,
					swipe: true,
					prev: $testimonialsPrev,
					next: $testimonialsNext,
					scroll: {
						pauseOnHover: true,
						fx: 'scroll',
						easing: 'easeInOutCubic',
						duration: 1000,
						onBefore: function(data) {
							data.items.old.css({
								opacity: 1
							}).animate({
								opacity: 0
							}, 500, 'linear');

							data.items.visible.css({
								opacity: 0
							}).animate({
								opacity: 1
							}, 1000, 'linear');
						}
					}
				});

			});
		});
	}

})(jQuery);