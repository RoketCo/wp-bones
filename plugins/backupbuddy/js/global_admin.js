jQuery(document).ready(function() {
	// Hide a dismissable alert and send AJAX call so it won't be shown in the future.
	jQuery( '.pb_backupbuddy_disalert' ).click( function(e) {
		e.preventDefault();
		var this_unique_id = jQuery(this).parents('.pb_backupbuddy_alert').attr('rel');
		if ( ( '' === this_unique_id ) || ( 'undefined' == typeof this_unique_id ) ) { // Don't save dismissing as this is just a one-time dismissable alert.
			jQuery(this).parents('.pb_backupbuddy_alert').slideUp();
			return;
		}
		var this_disalert_url = jQuery(this).attr('alt');
		//alert( unique_id );
		
		jQuery.post( this_disalert_url,
			{ unique_id: this_unique_id },
			function(data) {
				data = jQuery.trim( data );
				if ( data != '1' ) {
					alert( 'Error saving dismissal. Error: ' + data );
				}
				if ( e.currentTarget.href ) {
					window.location.href = e.currentTarget.href;
				}
			}
		);
		
		jQuery(this).parents('.pb_backupbuddy_alert').slideUp();
		
	});
});