(function ($) {'use strict';
	var Shortcodes = vc.shortcodes;
	var VcCTClass = vc.shortcode_view.extend({
		events:{
			'click > .vc_controls .column_delete': 'deleteShortcode',
			'click > .vc_controls .column_edit': 'editElement',
			'click > .vc_controls .column_clone': 'clone',
			'click > .vc_controls .column_prepend': 'prependElement',
			'click > .vc_controls .column_add': 'addElement',
			'click > .vc_empty-element': 'appendElement',
		}
	})

	window.VcCTAlertBoxView = VcCTClass.extend({});
	window.VcCTCounterBoxView = VcCTClass.extend({});
	window.VcCTFullwidthView = VcCTClass.extend({});
	window.VcCTIconWithTextView = VcCTClass.extend({});
	window.VcCTMapWithTextView = VcCTClass.extend({});
	window.VcCTPricingColumnView = VcCTClass.extend({});
	window.VcCTPricingTableView = VcCTClass.extend({});
	window.VcCTTextboxView = VcCTClass.extend({});
})(window.jQuery);
