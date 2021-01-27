(function($) {'use strict';
	$(function() {

		$('.ct-clients-type-carousel-grid:not(.carousel-disabled)').each(function() {

			var $clientsCarouselElement = $(this);

			var $clientsItems = $('.ct-clients-slide', $clientsCarouselElement);

			var $clientsItemsWrap = $('<div class="ct-clients-grid-carousel-wrap"/>')
				.appendTo($clientsCarouselElement);
			var $clientsItemsCarousel = $('<div class="ct-clients-grid-carousel"/>')
				.appendTo($clientsItemsWrap);
			var $clientsItemsPagination = $('<div class="ct-clients-grid-pagination ct-mini-pagination"/>')
				.appendTo($clientsItemsWrap);
			$clientsItems.appendTo($clientsItemsCarousel);

		});


		$('.ct_client_carousel-items').each(function () {

			var $clientsElement = $(this);

			var $clients = $('.ct-client-item', $clientsElement);

			var $clientsWrap = $('<div class="ct-client-carousel-item-wrap"/>')
				.appendTo($clientsElement);
			var $clientsCarousel = $('<div class="ct-client-carousel"/>')
				.appendTo($clientsWrap);
			var $clientsNavigation = $('<div class="ct-client-carousel-navigation"/>')
				.appendTo($clientsWrap);
			var $clientsPrev = $('<a href="#" class="ct-prev ct-client-prev"/></a>')
				.appendTo($clientsNavigation);
			var $clientsNext = $('<a href="#" class="ct-next ct-client-next"/></a>')
				.appendTo($clientsNavigation);
			$clients.appendTo($clientsCarousel);

		});

		$('body').updateClientsGrid();
		$('body').updateClientsCarousel();
		$('.fullwidth-block').each(function() {
			$(this).on('updateClientsCarousel', function() {
				$(this).updateClientsCarousel();
			});
		});
		$('.ct_tab').on('tab-update', function() {
			$(this).updateClientsGrid();
		});
		$('.ct_accordion_content').on('accordion-update', function() {
			$(this).updateClientsGrid();
		});
		$(document).on('ct.show.vc.tabs', '[data-vc-accordion]', function() {
			$(this).data('vc.accordion').getTarget().updateClientsGrid();
		});
		$(document).on('ct.show.vc.accordion', '[data-vc-accordion]', function() {
			$(this).data('vc.accordion').getTarget().updateClientsGrid();
		});

	});

	$.fn.updateClientsGrid = function() {
		$('.ct-clients-type-carousel-grid:not(.carousel-disabled)', this).each(function() {
			var $clientsCarouselElement = $(this);

			var $clientsItemsCarousel = $('.ct-clients-grid-carousel', $clientsCarouselElement);
			var $clientsItemsPagination = $('.ct-mini-pagination', $clientsCarouselElement);

			var autoscroll = $clientsCarouselElement.data('autoscroll') > 0 ? $clientsCarouselElement.data('autoscroll') : false;

			$clientsCarouselElement.ctPreloader(function() {

				var $clientsGridCarousel = $clientsItemsCarousel.carouFredSel({
					auto: autoscroll,
					circular: false,
					infinite: true,
					width: '100%',
					items: 1,
					responsive: true,
					height: 'auto',
					align: 'center',
					pagination: $clientsItemsPagination,
					scroll: {
						pauseOnHover: true
					}
				});

			});
		});
	}

	$.fn.updateClientsCarousel = function() {
		$('.ct_client_carousel-items:not(.carousel-disabled)', this).each(function() {
			var $clientsElement = $(this);

			var $clientsCarousel = $('.ct-client-carousel', $clientsElement);
			var $clientsPrev = $('.ct-client-prev', $clientsElement);
			var $clientsNext = $('.ct-client-next', $clientsElement);

			var autoscroll = $clientsElement.data('autoscroll') > 0 ? $clientsElement.data('autoscroll') : false;

			$clientsElement.ctPreloader(function() {

				var $clientsView = $clientsCarousel.carouFredSel({
					auto: autoscroll,
					circular: true,
					infinite: false,
					scroll: {
						items: 1
					},
					width: '100%',
					responsive: false,
					height: 'auto',
					align: 'center',
					prev: $clientsPrev,
					next: $clientsNext
				});

			});
		});
	}

})(jQuery);