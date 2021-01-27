(function($) {'use strict';

    var animations = {

        'move-up': {
            timeout: 200
        },

        bounce: {
            timeout: 0
        },

        'fade-in': {
            timeout: 100
        },

        scale: {
            timeout: 100
        },

        flip: {
            timeout: 100
        },

        'fall-perspective': {
            timeout: 100
        },

    };

    var prefixes = 'Webkit Moz ms Ms O'.split(' ');
    var docElemStyle = document.documentElement.style;

    function getStyleProperty( propName ) {
        if ( !propName ) {
            return;
        }

        // test standard property first
        if ( typeof docElemStyle[ propName ] === 'string' ) {
            return propName;
        }

        // capitalize
        propName = propName.charAt(0).toUpperCase() + propName.slice(1);

        // test vendor specific properties
        var prefixed;
        for ( var i=0, len = prefixes.length; i < len; i++ ) {
            prefixed = prefixes[i] + propName;
            if ( typeof docElemStyle[ prefixed ] === 'string' ) {
                return prefixed;
            }
        }
    }

    var transitionProperty = getStyleProperty('transition');
    var transitionEndEvent = {
        WebkitTransition: 'webkitTransitionEnd',
        MozTransition: 'transitionend',
        OTransition: 'otransitionend',
        transition: 'transitionend'
    }[ transitionProperty ];


    function ItemsAnimations(el, options) {
		var self = this;
		this.el = el;
		this.$el = $(el);

		this.options = {
            itemSelector: '',
            scrollMonitor: false,
            firstItemStatic: false
		};
		$.extend(this.options, options);

        this.$el.data('itemsAnimations', this);

        self.initialize();
	}

	$.fn.itemsAnimations = function(options) {
        if ( typeof options === 'string' ) {
            var instance = $(this.get(0)).data('itemsAnimations');
            if (!instance) {
                return false;
            }
            if (options === 'instance') {
                return instance;
            }
        } else {
            return new ItemsAnimations(this.get(0), options);
        }
	}

    ItemsAnimations.prototype = {

        initialize: function() {
            var self = this;

            this.queue = [];
            this.queue_is_run = false;
            this.watchers = {};

            this.animation = this.getAnimation();
            if (!this.animation || $(window).width() < 767) {
                this.animationName = 'disabled';
                this.animation = this.getAnimationByName('disabled');
            }

            if (this.options.firstItemStatic) {
                this.firstStatisItem = $(this.options.itemSelector + ':first', this.$el);
                this.firstStatisItem.removeClass('item-animations-not-inited');
            }

            if (this.animationName == 'disabled') {
                $(this.options.itemSelector, this.$el).removeClass('item-animations-not-inited');
            }
        },

        show: function($items) {
            var self = this;

            if (this.animationName == 'disabled') {
                $(this.options.itemSelector, this.$el).removeClass('item-animations-not-inited');
                return false;
            }

            if ($items == undefined) {
                $items = $(this.options.itemSelector, this.$el);
            }

            $items.not('.item-animations-inited').each(function(index) {
    			var $this = $(this);

    			$this.addClass('item-animations-inited');

                if (self.options.firstItemStatic && self.firstStatisItem && self.firstStatisItem.get(0) == this) {
                    return;
                }

                if (self.options.scrollMonitor && this.animationName != 'disabled') {
                    var watcher = scrollMonitor.create(this, -50);
        			watcher.enterViewport(function() {
        				var watcher = this;
                        self.showItem($this, watcher);
        			});
                    self.watchers[ watcher.uid ] = watcher;
                } else {
                    self.showItem($this);
                }
    		});

            $(this.options.itemSelector, this.$el).not('.item-animations-inited').removeClass('item-animations-not-inited');

        },

        reinitItems: function($items) {
            $items.removeClass('start-animation item-animations-inited item-animations-loading before-start').addClass('item-animations-not-inited');
            this.clear();
        },

        getAnimationName: function() {
            var m = this.$el[0].className.match(/item-animation-(\S+)/);
            if (!m) {
                return '';
            }
            return m[1];
        },

        getAnimation: function() {
            this.animationName = this.getAnimationName();
            return this.getAnimationByName(this.animationName);
        },

        getAnimationByName: function(name) {
            if (!name || animations[name] == undefined) {
                return false;
            }
            return animations[name];
        },

        showItem: function($item, watcher) {
            var self = this;

            if ($item.hasClass('item-animations-loading')) {
                return false;
            }

            function showItemCallback() {
                if ($item.length == 0) {
                    return false;
                }

                self.animate($item);

                if (watcher != undefined) {
                    self.destroyWatcher(watcher);
                }
            }

            $item.addClass('item-animations-loading before-start');
            if (this.animation.timeout > 0) {
                this.queueAdd(showItemCallback, this.animation.timeout);
            } else {
                showItemCallback();
            }
        },

        destroyWatcher: function(watcher) {
            if (this.watchers[ watcher.uid ] != undefined) {
                delete this.watchers[ watcher.uid ];
            }

            watcher.destroy();
        },

        animate: function($item, animation) {
            function transEnd() {
            }


            setTimeout(function() {
                $item.removeClass('item-animations-loading item-animations-not-inited before-start').addClass('start-animation');
            }, 0);
        },

        queueAdd: function(callback, timeout) {
    		this.queue.push({
    			callback: callback,
                timeout: timeout
    		});

    		if (this.queue.length == 1 && !this.queue_is_run) {
                this.queueNext();
    		}
    	},

        queueNext: function() {
            var self = this;

    		if (this.queue.length == 0) {
    			return false;
    		}

    		var next_action = this.queue.shift();

    		if (next_action == undefined) {
    			return false;
    		}

    		this.queue_is_run = true;
    		next_action.callback();

    		setTimeout(function() {
    				self.queue_is_run = false;
                    self.queueNext();
    			},
    			next_action.timeout);
    	},

        clear: function() {
            this.queue = [];
            this.queue_is_run = false;

            for (var watcher_uid in this.watchers) {
                if (this.watchers.hasOwnProperty(watcher_uid)) {
                    this.destroyWatcher(this.watchers[watcher_uid]);
                }
            }

            this.watchers = [];
        }

    };

})(jQuery);
