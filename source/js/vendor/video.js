/* globals $ */
$(document).ready(function() {
	$('.popup-youtube, .popup-vimeo, .popup-gmaps').magnificPopup({
		disableOn: 700,
		type: 'iframe',
		mainClass: 'mfp-fade',
		removalDelay: 160,
		preloader: false,
		fixedContentPos: false,
		callbacks: {
			open: function() {
				document.querySelector( '.mfp-close' ).setAttribute( 'title', 'Sluiten (esc)' );
			},
		}
	});
});
