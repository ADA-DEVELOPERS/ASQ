(function($) {'use strict';
	$(function() {

		$('.ct-news-type-carousel').each(function() {

			var $newsCarouselElement = $(this);

			var $newsItems = $('.ct-news-item', $newsCarouselElement);

			var $newsItemsWrap = $('<div class="ct-news-carousel-wrap"/>')
				.appendTo($newsCarouselElement);
			var $newsItemsCarousel = $('<div class="ct-news-carousel"/>')
				.appendTo($newsItemsWrap);
			var $newsItemsPagination = $('<div class="ct-news-pagination ct-mini-pagination"/>')
				.appendTo($newsItemsWrap);
			$newsItems.appendTo($newsItemsCarousel);

		});

		$('.ct-blog-slider').each(function() {

			var $newsCarouselElement = $(this);

			var $newsItems = $('article', $newsCarouselElement);

			var $newsItemsWrap = $('<div class="ct-blog-slider-carousel-wrap"/>')
				.appendTo($newsCarouselElement);
			var $newsItemsCarousel = $('<div class="ct-blog-slider-carousel"/>')
				.appendTo($newsItemsWrap);
			var $newsItemsNavigation = $('<div class="ct-blog-slider-navigation"/>')
				.appendTo($newsItemsWrap);
			var $newsItemsPrev = $('<a href="#" class="ct-blog-slider-prev ct-button ct-button-size-tiny"><i class="ct-print-icon ct-icon-pack-ct-icons ct-icon-prev"></i></a>')
				.appendTo($newsItemsNavigation);
			var $newsItemsNext = $('<a href="#" class="ct-blog-slider-next ct-button ct-button-size-tiny"><i class="ct-print-icon ct-icon-pack-ct-icons ct-icon-next"></i></a>')
				.appendTo($newsItemsNavigation);
			$newsItems.appendTo($newsItemsCarousel);
			$newsItemsNavigation.appendTo($newsItems.find('.ct-slider-item-overlay'));

		});

		$('body').updateNews();
		$('body').updateNewsSlider();

	});

	$.fn.updateNews = function() {
		$('.ct-news-type-carousel', this).each(function() {
			var $newsCarouselElement = $(this);

			var $newsItemsCarousel = $('.ct-news-carousel', $newsCarouselElement);
			var $newsItems = $('.ct-news-item', $newsItemsCarousel);
			var $newsItemsPagination = $('.ct-mini-pagination', $newsCarouselElement);

			$newsCarouselElement.ctPreloader(function() {

				var $newsCarousel = $newsItemsCarousel.carouFredSel({
					auto: 10000,
					circular: false,
					infinite: true,
					width: '100%',
					height: 'variable',
					align: 'center',
					pagination: $newsItemsPagination
				});

			});
		});
	}

	$.fn.updateNewsSlider = function() {
		$('.ct-blog-slider', this).each(function() {
			var $newsCarouselElement = $(this);
			var $newsItemsCarousel = $('.ct-blog-slider-carousel', $newsCarouselElement);
			var $newsItems = $('article', $newsItemsCarousel);
			var $newsItemsNavigation = $('.ct-blog-slider-navigation', $newsCarouselElement);
			var $newsItemsPrev = $('.ct-blog-slider-prev', $newsCarouselElement);
			var $newsItemsNext = $('.ct-blog-slider-next', $newsCarouselElement);

			$newsCarouselElement.ctPreloader(function() {

				var $newsCarousel = $newsItemsCarousel.carouFredSel({
					auto: ($newsCarouselElement.data('autoscroll') > 0 ? $newsCarouselElement.data('autoscroll') : false),
					circular: true,
					infinite: true,
					responsive: true,
					width: '100%',
					height: 'auto',
					align: 'center',
					items: 1,
					swipe: true,
					prev: $newsItemsPrev,
					next: $newsItemsNext,
					scroll: {
						pauseOnHover: true,
						items: 1
					},
					onCreate: function() {
						$(window).on('resize', function() {
							var heights = $newsItems.map(function() { return $(this).height(); });
							$newsCarousel.parent().add($newsCarousel).height(Math.max.apply(null, heights));
						});
					}
				});

			});
		});
	}

})(jQuery);