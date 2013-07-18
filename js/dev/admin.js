(function($) {
	"use strict";
	
	$(function() {
		
		var $domain, $linker, $analytics;
		$domain = $('.form-table tr').eq(0);
		$analytics = $('.form-table tr').eq(3);
		
		// If we're on the Global Options tabs...
		if( 0 < $('.nav-tab-active').attr('href').indexOf('global_options') ) {
			
			// ...then lets move the Google Analytics below the original analytics option
			$domain.insertAfter( $analytics );
			
			// ...update the position of the domain amd the linker
			$domain = $('.form-table tr').eq(3);
			$linker = $('.form-table tr').eq(0);
			
			// ...now lets move the linker field
			$linker.insertAfter( $domain );
			
		} // end if
		
	});
	
}(jQuery));