
/**
 * @component core/core
 * @author Champa
 */

'use strict';

let buttonProperties = {};

(function( $, window, document, undefined ){

	$.fn._init = $.fn.init;

	$.fn.init = function( selector, context, root ) {
		return (typeof selector === 'string') ? new $.fn._init(selector, context, root).data('selector', selector) : new $.fn._init( selector, context, root );
	};

	$.fn.getSelector = function() {
		return $(this).data('selector');
	};

	$.fn.enableLoader = function(loader) {
		
		if(loader === undefined)
			loader = true;

		let selector = $(this).getSelector();

		if(loader) {

			buttonProperties[selector] = {
				width: this.css('width'),
				html: this.html()
			}

			this.addClass('loading');
			this.html('<i class="fas fa-spinner fa-pulse"></i>');
		} else {

			this.removeClass('loading');
			this.css('width', buttonProperties[selector].width);
			this.html(buttonProperties[selector].html);
		}
		
		return this;
	};

	$.fn.extend({
		animateCss: function(animationName, callback) {
			var animationEnd = (function(el) {
				var animations = {
					animation: 'animationend',
					OAnimation: 'oAnimationEnd',
					MozAnimation: 'mozAnimationEnd',
					WebkitAnimation: 'webkitAnimationEnd',
				};
	  
				for (var t in animations) {
					if (el.style[t] !== undefined) {
						return animations[t];
					}
				}
			})(document.createElement('div'));
	  
			this.addClass('animated ' + animationName).one(animationEnd, function() {
				$(this).removeClass('animated ' + animationName);
	  
				if (typeof callback === 'function') callback();
			});
	  
			return this;
		},
	});
})( jQuery, window, document );

var debugResponse = function(res) {

	$("body").append(res);
}

var redirect = function(link) {

	window.location.href = link;
}