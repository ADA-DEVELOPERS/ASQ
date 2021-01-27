function ct_show_digram_line_element(queue, first) {
	var $skill = queue.shift();
	if ($skill == null || $skill == undefined) {
		setTimeout(function() {
			ct_show_digram_line_element(queue, first);
		}, 1000);
		return;
	}

	if (first)
		var delay = 1;
	else
		var delay = 150;

	setTimeout(function() {
		var $progress = $skill.find('.skill-line div');
		var amount = parseFloat($progress.data('amount'));
		jQuery({countNum: 0}).animate({countNum: amount}, {
			duration: 1600,
			easing:'easeOutQuart',
			step: function() {
				var count = parseFloat(this.countNum);
				var pct = Math.ceil(count) + '%';
				$progress.width(count + '%');
				$skill.find('.skill-amount').html(pct);
			}
		});
		ct_show_digram_line_element(queue, false);
	}, delay);
}

function ct_show_diagram_line_mobile($box) {
	jQuery('.skill-element', $box).each(function () {
		jQuery('.skill-line div', this).width(jQuery('.skill-line div', this).data('amount') + '%');
	});
}

function ct_start_line_digram(element) {
	jQuery(element).ct_start_line_digram();
}

jQuery.fn.ct_start_line_digram = function() {
	var $box = jQuery(this.get(0));
	if (!$box.hasClass('digram-line-box'))
		return;
	var diagram_lines_queue = [];
	jQuery('.skill-element', $box).each(function () {
		diagram_lines_queue.push(jQuery(this));
	});
	ct_show_digram_line_element(diagram_lines_queue, true);
}

jQuery('.digram-line-box').each(function () {
	if (!jQuery(this).hasClass('lazy-loading-item') || window.ctSettings.lasyDisabled)
		jQuery(this).ct_start_line_digram();
});
