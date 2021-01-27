(function($) {'use strict';
	$(function() {

		$('.related-posts-carousel').each(function() {

			var $relatedPostsElement = $(this);

			var $relatedPosts = $('.related-element', $relatedPostsElement);

			var $relatedPostsWrap = $('<div class="related-posts-carousel-wrap"/>')
				.appendTo($relatedPostsElement);
			var $relatedPostsCarousel = $('<div class="related-posts-carousel-carousel"/>')
				.appendTo($relatedPostsWrap);
			var $relatedPostsNavigation = $('<div class="related-posts-navigation ct-button-position-right"/>')
				.appendTo($relatedPostsWrap);
			var $relatedPostsPrev = $('<a href="#" class="ct-button ct-button-style-outline ct-button-size-tiny related-posts-prev"><i class="ct-print-icon ct-icon-pack-ct-icons ct-icon-prev"></i></a>')
				.appendTo($relatedPostsNavigation);
			var $relatedPostsNext = $('<a href="#" class="ct-button ct-button-style-outline ct-button-size-tiny related-posts-next"><i class="ct-print-icon ct-icon-pack-ct-icons ct-icon-next"></i></a>')
				.appendTo($relatedPostsNavigation);
			$relatedPosts.appendTo($relatedPostsCarousel);

		});

		$('body').updateRelatedPostCarousel();

	});

	$.fn.updateRelatedPostCarousel = function() {
		$('.related-posts-carousel', this).add($(this).filter('.related-posts-carousel')).each(function() {
			var $relatedPostsElement = $(this);

			var $relatedPostsCarousel = $('.related-posts-carousel-carousel', $relatedPostsElement);
			var $relatedPosts = $('.product', $relatedPostsCarousel);
			var $relatedPostsPrev = $('.related-posts-prev');
			var $relatedPostsNext = $('.related-posts-next');

			$relatedPostsElement.ctPreloader(function() {

				var $relatedPostsView = $relatedPostsCarousel.carouFredSel({
					auto: false,
					circular: true,
					infinite: true,
					width: '100%',
					height: 'variable',
					align: 'center',
					prev: $relatedPostsPrev,
					next: $relatedPostsNext
				});

			});
		});
	}

})(jQuery);