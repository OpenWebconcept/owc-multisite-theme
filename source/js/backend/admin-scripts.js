/* globals jQuery, icon, ajaxurl */


jQuery(document).on( 'wplink-open', function() {

	if( jQuery('#wp-link-title').length < 1 ) {
		jQuery('.wp-link-text-field').after( `<div>
		<label for="wp-link-title"><span>Link titel</span> <input id="wp-link-title" type="text">
		</div>`);
	}

	editor = window.tinymce.get( window.wpActiveEditor );
	var title = '';

	if ( editor && ! editor.isHidden() ) {
		title = editor.dom.getParent( editor.selection.getNode(), 'a[href]' );
	}

	title = jQuery( title ).attr( 'title' );

	if( title ) {
		jQuery( '#wp-link-title' ).val( title );
	}  

	wpLink.getAttrs = function() {
		wpLink.correctURL();        
		return {
			title:  jQuery( '#wp-link-title' ).val(),
			href:   jQuery.trim( jQuery( '#wp-link-url' ).val() ),
			target: jQuery( '#wp-link-target' ).prop( 'checked' ) ? '_blank' : ''
		};
	}
});

jQuery(document).ready(function( $ ){

	$(document).on('click', '#re-index', function( e ){
		e.preventDefault();
		var post_id = jQuery(this).attr('data-post_id'),
				nonce = jQuery(this).attr('data-nonce');

		$.ajax({
			type : 'post',
			dataType : 'json',
			url : ajaxurl,
			data : {
				action: 'strl_facetwp_reindex',
				post_id : post_id,
				nonce: nonce
			},
			success: function( response ) {
				console.log( response );
			}
		})
	});

	$(document).on('click', '[data-name="add-layout"]', function(){
		$('.acf-fc-popup ul li a').each(function(){
			icon = $(this).data('min');
			$(this).prepend('<i class="'+icon+'"></i> ');
		});
	});
});
