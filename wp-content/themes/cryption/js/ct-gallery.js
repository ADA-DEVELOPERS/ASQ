(function($) {'use strict';
	$(function() {

		function init_circular_overlay($gallery, $set) {
			if (!$gallery.hasClass('hover-circular')) {
				return;
			}

			$('.gallery-item', $set).on('mouseenter', function() {
				var overlayWidth = $('.overlay', this).width(),
					overlayHeight = $('.overlay', this).height(),
					$overlayCircle = $('.overlay-circle', this),
					maxSize = 0;

				if (overlayWidth > overlayHeight) {
					maxSize = overlayWidth;
					$overlayCircle.height(overlayWidth)
				} else {
					maxSize = overlayHeight;
					$overlayCircle.width(overlayHeight);
				}
				maxSize += overlayWidth * 0.3;

				$overlayCircle.css({
					marginLeft: -maxSize / 2,
					marginTop: -maxSize / 2
				});
			});
		}

		$('.ct-gallery-grid').not('.gallery-slider').each(function() {
			var $gallery = $(this);
			var $set = $('.gallery-set', this);
			if (!$gallery.hasClass('metro')) {
				$set.imagesLoaded( function() {
					$gallery.closest('.gallery-preloader-wrapper').prev('.preloader').remove();

					init_circular_overlay($gallery, $set);

					var itemsAnimations = $gallery.itemsAnimations({
						itemSelector: '.gallery-item',
						scrollMonitor: true
					});
					var init_gallery = true;

					$set
						.on( 'arrangeComplete', function( event, filteredItems ) {
							if (init_gallery) {
								init_gallery = false;

								var items = [];
								filteredItems.forEach(function(item) {
									items.push(item.element);
								});
								setTimeout(function() {
									itemsAnimations.show($(items));
								});
							}
						})
						.isotope({
							itemSelector: '.gallery-item',
							itemImageWrapperSelector: '.image-wrap',
							fixHeightDoubleItems: $gallery.hasClass('gallery-style-justified'),
							layoutMode: 'masonry-custom',
							'masonry-custom': {
								columnWidth: '.gallery-item:not(.double-item)'
							}
						});
				});

				if ($set.closest('.ct_tab').size() > 0) {
					$set.closest('.ct_tab').bind('tab-update', function() {
						$set.isotope('layout');
					});
				}
				$(document).on('show.vc.tab', '[data-vc-tabs]', function() {
					var $tab = $(this).data('vc.tabs').getTarget();
					if($tab.find($set).length) {
						$set.isotope('layout');
					}
				});
				if ($set.closest('.ct_accordion_content').size() > 0) {
					$set.closest('.ct_accordion_content').bind('accordion-update', function() {
						$set.isotope('layout');
					});
				}
			}
		});

		var resizeTimer = null;
		$('.ct-gallery-grid.metro').not('.gallery-slider').each(function() {
			var $gallery = $(this);
			var $set = $('.gallery-set', this);
			$set.imagesLoaded( function() {
				$gallery.closest('.gallery-preloader-wrapper').prev('.preloader').remove();

				var itemsAnimations = $gallery.itemsAnimations({
					itemSelector: '.gallery-item',
					scrollMonitor: true
				});
				var init_gallery = true;

				init_circular_overlay($gallery, $set);

				$set
					.on( 'arrangeComplete', function( event, filteredItems ) {
						if (init_gallery) {
							init_gallery = false;

							var items = [];
							filteredItems.forEach(function(item) {
								items.push(item.element);
							});
							setTimeout(function() {
								itemsAnimations.show($(items));
							});
						}
					})
					.isotope({
						itemSelector: '.gallery-item',
						itemImageWrapperSelector: '.image-wrap',
						fixHeightDoubleItems: $gallery.hasClass('gallery-style-justified'),
						layoutMode: 'metro',
						'masonry-custom': {
							columnWidth: '.gallery-item:not(.double-item)'
						},
						transitionDuration: 0
					});

				if ($set.closest('.ct_tab').size() > 0) {
					$set.closest('.ct_tab').bind('tab-update', function() {
						$set.isotope('layout');
					});
				}
				$(document).on('ct.show.vc.tabs', '[data-vc-accordion]', function() {
					var $tab = $(this).data('vc.accordion').getTarget();
					if($tab.find($set).length) {
						$set.isotope('layout');
					}
				});
				$(document).on('ct.show.vc.accordion', '[data-vc-accordion]', function() {
					var $tab = $(this).data('vc.accordion').getTarget();
					if($tab.find($set).length) {
						$set.isotope('layout');
					}
				});
				if ($set.closest('.ct_accordion_content').size() > 0) {
					$set.closest('.ct_accordion_content').bind('accordion-update', function() {
						$set.isotope('layout');
					});
				}
			});
		});

		$('.gallery-slider').each(function() {
			var $gallery = $(this);
			var $set = $('.gallery-set', this);
			var $items = $('.gallery-item', $set);

			init_circular_overlay($gallery, $set);

			// update images list
			$set.wrap('<div class="ct-gallery-preview-carousel-wrap clearfix"/>');
			var $galleryPreviewWrap = $('.ct-gallery-preview-carousel-wrap', this);
			$galleryPreviewWrap.wrap('<div class="ct-gallery-preview-carousel-padding clearfix"/>');
			var $galleryPreviewNavigation = $('<div class="ct-gallery-preview-navigation"/>')
				.appendTo($galleryPreviewWrap);
			var $galleryPreviewPrev = $('<a href="#" class="ct-prev ct-gallery-preview-prev"></a>')
				.appendTo($galleryPreviewNavigation);
			var $galleryPreviewNext = $('<a href="#" class="ct-next ct-gallery-preview-next"></a>')
				.appendTo($galleryPreviewNavigation);

			// create thumbs list
			var $galleryThumbsWrap = $('<div class="ct-gallery-thumbs-carousel-wrap col-lg-12 col-md-12 col-sm-12 clearfix" style="opacity: 0"/>')
				.appendTo($gallery);
			var $galleryThumbsCarousel = $('<ul class="ct-gallery-thumbs-carousel"/>')
				.appendTo($galleryThumbsWrap);
			var $galleryThumbsNavigation = $('<div class="ct-gallery-thumbs-navigation"/>')
				.appendTo($galleryThumbsWrap);
			var $galleryThumbsPrev = $('<a href="#" class="ct-prev ct-gallery-thumbs-prev"></a>')
				.appendTo($galleryThumbsNavigation);
			var $galleryThumbsNext = $('<a href="#" class="ct-next ct-gallery-thumbs-next"></a>')
				.appendTo($galleryThumbsNavigation);
			var thumbItems = '';
			$items.each(function() {
				thumbItems += '<li><span><img src="' + $('.image-wrap img', this).data('thumb-url') + '" alt="" /></span></li>';
			});
			var $thumbItems = $(thumbItems);
			$thumbItems.appendTo($galleryThumbsCarousel);
			$thumbItems.each(function(index) {
				$(this).data('gallery-item-num', index);
			});

			var $galleryPreview = $set.carouFredSel({
				auto: false,
				circular: false,
				infinite: false,
				responsive: true,
				width: '100%',
				height: '100%',
				items: 1,
				align: 'center',
				prev: $galleryPreviewPrev,
				next: $galleryPreviewNext,
				swipe: true,
				scroll: {
					items: 1,
					onBefore: function(data) {
						var current = $(this).triggerHandler('currentPage');
						var thumbCurrent = $galleryThumbs.triggerHandler('slice', [current, current+1]);
						var thumbsVisible = $galleryThumbs.triggerHandler('currentVisible');
						$thumbItems.filter('.active').removeClass('active');
						if(thumbsVisible.index(thumbCurrent) === -1) {
							$galleryThumbs.trigger('slideTo', current);
						}
						$('span', thumbCurrent).trigger('click');
					}
				}
			});

			var $galleryThumbs = null;
			$galleryThumbsCarousel.imagesLoaded( function() {
				$galleryThumbs = $galleryThumbsCarousel.carouFredSel({
					auto: false,
					circular: false,
					infinite: false,
					width: '100%',
					height: 'variable',
					align: 'center',
					prev: $galleryThumbsPrev,
					next: $galleryThumbsNext,
					swipe: true,
					onCreate: function(data) {
						$('span', $thumbItems).click(function(e) {
							e.preventDefault();
							$thumbItems.filter('.active').removeClass('active');
							$(this).closest('li').addClass('active');
							$galleryPreview.trigger('slideTo', $(this).closest('li').data('gallery-item-num'));
						});
						$thumbItems.eq(0).addClass('active');
					}
				});
				$galleryThumbsWrap.animate({opacity: 1}, 400);
				if($thumbItems.length < 2) {
					$galleryThumbsWrap.hide();
				}
			});
		});

		$('.ct-gallery').each(function() {

			var $galleryElement = $(this);


			var $thumbItems = $('.ct-gallery-item', $galleryElement);

			var $galleryPreviewWrap = $('<div class="ct-gallery-preview-carousel-wrap"/>')
				.appendTo($galleryElement);
			var $galleryPreviewCarousel = $('<div class="ct-gallery-preview-carousel "/>')
				.appendTo($galleryPreviewWrap);
			var $galleryPreviewNavigation = $('<div class="ct-gallery-preview-navigation"/>')
				.appendTo($galleryPreviewWrap);
			var $galleryPreviewPrev = $('<a href="#" class="ct-prev ct-gallery-preview-prev"></a>')
				.appendTo($galleryPreviewNavigation);
			var $galleryPreviewNext = $('<a href="#" class="ct-next ct-gallery-preview-next"></a>')
				.appendTo($galleryPreviewNavigation);
			if($galleryElement.hasClass('with-pagination')) {
				var $galleryPreviewPagination = $('<div class="ct-gallery-preview-pagination ct-mini-pagination"/>')
					.appendTo($galleryPreviewWrap);
			}
			var $previewItems = $thumbItems.clone(true, true);
			$previewItems.appendTo($galleryPreviewCarousel);
			$previewItems.each(function() {
				$('img', this).attr('src', $('a', this).attr('href'));
				$('a', this).attr('href', $('a', this).data('full-image-url'));
			});
			$('a', $galleryPreviewCarousel).click(function(e) {
				e.preventDefault();
				var $obj = $(this);
				$.fancybox({
					href: $obj.attr('href'),
					helpers : {
						title: {
							type: 'over'
						}
					},
					wrapCSS: 'slideinfo',
					beforeLoad: function() {
						var clone = $obj.children('.slide-info').clone();
						if (clone.length) {
							this.title = clone.html();
						}
					}
				});

			});

			var $galleryThumbsWrap = $('<div class="ct-gallery-thumbs-carousel-wrap"/>')
				.appendTo($galleryElement);
			var $galleryThumbsCarousel = $('<div class="ct-gallery-thumbs-carousel"/>')
				.appendTo($galleryThumbsWrap);
			var $galleryThumbsNavigation = $('<div class="ct-gallery-thumbs-navigation"/>')
				.appendTo($galleryThumbsWrap);
			var $galleryThumbsPrev = $('<a href="#" class="ct-prev ct-gallery-thumbs-prev"></a>')
				.appendTo($galleryThumbsNavigation);
			var $galleryThumbsNext = $('<a href="#" class="ct-next ct-gallery-thumbs-next"></a>')
				.appendTo($galleryThumbsNavigation);
			$thumbItems.appendTo($galleryThumbsCarousel);
			$thumbItems.each(function(index) {
				$(this).data('gallery-item-num', index);
			});

		});

		$('body').updateGalleries();
		$('body').buildSimpleGalleries();
		$('body').updateSimpleGalleries();
		$('.ct_tab').on('tab-update', function() {
			$(this).updateGalleries();
		});
		$(document).on('ct.show.vc.tabs', '[data-vc-accordion]', function() {
			$(this).data('vc.accordion').getTarget().updateGalleries();
		});
		$(document).on('ct.show.vc.accordion', '[data-vc-accordion]', function() {
			$(this).data('vc.accordion').getTarget().updateGalleries();
		});
		$('.ct_accordion_content').on('accordion-update', function() {
			$(this).updateGalleries();
		});

	});

	$.fn.buildSimpleGalleries = function() {
		$('.ct-simple-gallery:not(.activated)', this).each(function() {

			var $galleryElement = $(this);
			$galleryElement.addClass('activated');

			var $thumbItems = $('.ct-gallery-item', $galleryElement);

			var $galleryItemsWrap = $('<div class="ct-gallery-items-carousel-wrap"/>')
				.appendTo($galleryElement);
			var $galleryItemsCarousel = $('<div class="ct-gallery-items-carousel"/>')
				.appendTo($galleryItemsWrap);
			var $galleryItemsNavigation = $('<div class="ct-gallery-items-navigation"/>')
				.appendTo($galleryItemsWrap);
			var $galleryItemsPrev = $('<a href="#" class="ct-prev ct-gallery-items-prev"></a>')
				.appendTo($galleryItemsNavigation);
			var $galleryItemsNext = $('<a href="#" class="ct-next ct-gallery-items-next"></a>')
				.appendTo($galleryItemsNavigation);
			$thumbItems.appendTo($galleryItemsCarousel);
			$('a', $galleryItemsCarousel).click(function(e) {
				e.preventDefault();
				$.fancybox($(this));
			});

		});
	}

	$.fn.updateGalleries = function() {
		$('.ct-gallery', this).each(function() {
			var $galleryElement = $(this);

			var $galleryPreviewCarousel = $('.ct-gallery-preview-carousel', $galleryElement);
			var $galleryThumbsWrap = $('.ct-gallery-thumbs-carousel-wrap', $galleryElement);
			var $galleryThumbsCarousel = $('.ct-gallery-thumbs-carousel', $galleryElement);
			var $thumbItems = $('.ct-gallery-item', $galleryThumbsCarousel);
			var $galleryPreviewPrev = $('.ct-gallery-preview-prev', $galleryElement);
			var $galleryPreviewNext = $('.ct-gallery-preview-next', $galleryElement);
			var $galleryPreviewPagination = $('.ct-gallery-preview-pagination', $galleryElement);
			var $galleryThumbsPrev = $('.ct-gallery-thumbs-prev', $galleryElement);
			var $galleryThumbsNext = $('.ct-gallery-thumbs-next', $galleryElement);

			$galleryElement.ctPreloader(function() {

				var $galleryPreview = $galleryPreviewCarousel.carouFredSel({
					auto: $galleryElement.data('autoscroll') ? $galleryElement.data('autoscroll') : false,
					circular: true,
					infinite: true,
					responsive: true,
					width: '100%',
					height: 'auto',
					items: 1,
					align: 'center',
					prev: $galleryPreviewPrev,
					next: $galleryPreviewNext,
					pagination: $galleryElement.hasClass('with-pagination') ? $galleryPreviewPagination : false,
					swipe: true,
					scroll: {
						pauseOnHover: true,
						items: 1,
						onBefore: function(data) {
							var current = $(this).triggerHandler('currentPage');
							var thumbCurrent = $galleryThumbs.triggerHandler('slice', [current, current+1]);
							var thumbsVisible = $galleryThumbs.triggerHandler('currentVisible');
							$thumbItems.filter('.active').removeClass('active');
							if(thumbsVisible.index(thumbCurrent) === -1) {
								$galleryThumbs.trigger('slideTo', current);
							}
							$('a', thumbCurrent).trigger('click');
						}
					},
					onCreate: function () {
						$(window).on('resize', function () {
							$galleryPreviewCarousel.parent().add($galleryPreviewCarousel).height($galleryPreviewCarousel.children().first().height());
						}).trigger('resize');
					}
				});

				var $galleryThumbs = $galleryThumbsCarousel.carouFredSel({
					auto: false,
					circular: true,
					infinite: true,
					width: '100%',
					height: 'variable',
					align: 'center',
					prev: $galleryThumbsPrev,
					next: $galleryThumbsNext,
					swipe: true,
					onCreate: function(data) {
						$('a', $thumbItems).click(function(e) {
							e.preventDefault();
							$thumbItems.filter('.active').removeClass('active');
							$(this).closest('.ct-gallery-item').addClass('active');
							$galleryPreview.trigger('slideTo', $(this).closest('.ct-gallery-item').data('gallery-item-num'));
						});
					}
				});

				if($thumbItems.filter('.active').length) {
					$thumbItems.filter('.active').eq(0).find('a').trigger('click');
				} else {
					$thumbItems.eq(0).find('a').trigger('click');
				}

				if($thumbItems.length < 2) {
					$galleryThumbsWrap.hide();
				}

			});
		});
	}

	$.fn.updateSimpleGalleries = function() {
		$('.ct-simple-gallery', this).each(function() {
			var $galleryElement = $(this);

			var $galleryItemsCarousel = $('.ct-gallery-items-carousel', $galleryElement);
			var $thumbItems = $('.ct-gallery-item', $galleryItemsCarousel);
			var $galleryItemsPrev = $('.ct-gallery-items-prev', $galleryElement);
			var $galleryItemsNext = $('.ct-gallery-items-next', $galleryElement);

			$galleryElement.ctPreloader(function() {
				var $galleryItems = $galleryItemsCarousel.carouFredSel({
					auto: ($galleryElement.data('autoscroll') > 0 ? $galleryElement.data('autoscroll') : false),
					circular: true,
					infinite: true,
					responsive: $galleryElement.hasClass('responsive'),
					width: '100%',
					height: 'variable',
					align: 'center',
					prev: $galleryItemsPrev,
					next: $galleryItemsNext,
					swipe: true,
					scroll: {
						pauseOnHover: true
					}
				});

			});
		});
	}

})(jQuery);
