(function($) {
$(function(){

	WC_Product_Slider_Frontend = {

		clickPauseResumEvent: function () {
			$(document).on( 'cycle-paused', '.wc-product-slider-container', function( event, opts ) {
				$(this).find( '.cycle-pause' ).hide();
				$(this).find( '.cycle-play' ).show();
			});
			$(document).on( 'cycle-resumed', '.wc-product-slider-container', function( event, opts ) {
				$(this).find( '.cycle-pause' ).show();
				$(this).find( '.cycle-play' ).hide();
			});
		}
	}


	WC_Product_Slider_Frontend.clickPauseResumEvent();

});
})(jQuery);
