/*-----------------------------------------------------------------------------------

 	Custom JS - All front-end jQuery
 
-----------------------------------------------------------------------------------*/
 
 
/*-----------------------------------------------------------------------------------*/
/*	Superfish Settings - http://users.tpg.com.au/j_birch/plugins/superfish/
/*-----------------------------------------------------------------------------------*/

jQuery(document).ready(function() {
    
    
	
	/* Home Page Slider ----------------------------*/
	if( jQuery().slides) {
	    var slider = jQuery('#home-slider');
	    
	    slider.slides({
	        preload: true,
			preloadImage: slider.attr('data-loader'), 
			generatePagination: false,
			generateNextPrev: false,
			next: 'slides_next',
			prev: 'slides_prev',
			effect: 'fade',
			crossfade: true,
			autoHeight: true,
			bigTarget: false,
			play: slider.attr('data-speed')
	    });
	}
	
	

});