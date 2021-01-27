(function($) {'use strict';
	$(document).ready(function() {

		$('.ct-nivoslider').each(function() {
			var $slider = $(this);
			$slider.ctPreloader(function() {

				$slider.nivoSlider({
					effect: ct_nivoslider_options.effect,
					slices: parseInt(ct_nivoslider_options.slices),
					boxCols: parseInt(ct_nivoslider_options.boxCols),
					boxRows: parseInt(ct_nivoslider_options.boxRows),
					animSpeed: parseInt(ct_nivoslider_options.animSpeed),
					pauseTime: parseInt(ct_nivoslider_options.pauseTime),
					directionNav: ct_nivoslider_options.directionNav,
					controlNav: ct_nivoslider_options.controlNav,
					beforeChange: function(){
						$('.nivo-caption', $slider).animate({ opacity: 'hide' }, 500);
					},
					afterChange: function(){
						var data = $slider.data('nivo:vars');
						var index = data.currentSlide;
						if($('.ct-nivoslider-slide:eq('+index+') .ct-nivoslider-caption', $slider).length) {
							$('.nivo-caption', $slider).html($('.ct-nivoslider-slide:eq('+index+') .ct-nivoslider-caption', $slider).html());
							$('.nivo-caption', $slider).animate({ opacity: 'show' }, 500);
						} else {
							$('.nivo-caption', $slider).html('');
						}
					},
					afterLoad: function(){
						$slider.next('.nivo-controlNav').appendTo($slider).addClass('ct-mini-pagination');
						$('.nivo-directionNav .nivo-prevNav', $slider).addClass('ct-prev');
						$('.nivo-directionNav .nivo-nextNav', $slider).addClass('ct-next');
						if($('.ct-nivoslider-slide:eq(0) .ct-nivoslider-caption', $slider).length) {
							$('.nivo-caption', $slider).html($('.ct-nivoslider-slide:eq(0) .ct-nivoslider-caption', $slider).html());
							$('.nivo-caption', $slider).show();
						}
					}
				});

			});
		});

	});
})(jQuery);