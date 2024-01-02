/**
 * main.js
 * http://www.codrops.com
 *
 * Licensed under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
 * 
 * Copyright 2016, Codrops
 * http://www.codrops.com
 */
;(function(window) {

	'use strict';

	// Helper vars and functions.
	function extend(a, b) {
		for( var key in b ) { 
			if( b.hasOwnProperty( key ) ) {
				a[key] = b[key];
			}
		}
		return a;
	}

	/**
	 * Hides the Point.
	 */
	Point.prototype.hide = function() {
		lunar.addClass(this.el, 'point--hide');
	};

	/**
	 * 
	 */
	Point.prototype.show = function() {
		lunar.removeClass(this.el, 'point--hide')
	};

	/**
	 * 
	 */
	Point.prototype.pause = function() {
		this.wrapper.removeEventListener('mousemove', this._throttleMousemove);
	};

	/**
	 * 
	 */
	Point.prototype.resume = function() {
		this.wrapper.addEventListener('mousemove', this._throttleMousemove);
	};



});