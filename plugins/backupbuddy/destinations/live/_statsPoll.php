<?php
/* BackupBuddy Stash Live Stats Poller (for Live Stash page AND global in wp-admin if admin bar enabled.
 *
 * @author Dustin Bolton
 * @since 7.0
 *
 */
?>
<script>
	if ( 'function' != typeof backupbuddy_live_statsPoll ) { // Only run once.
		backupbuddy_live_statsPoll = function() {
			jQuery.ajax({
				url:	'<?php echo pb_backupbuddy::ajax_url( 'live_stats' ); ?>',
				type:	'post',
				data:	{ },
				context: document.body,
				success: function( stats ) {
					if ( '-1' == stats ) { // Live is disconnected.
						console.log( 'Live reported it is disconnected.' );
						jQuery( '#wp-admin-bar-backupbuddy_stash_live_admin_bar' ).hide(); // Hide admin bar.
						return false;
					}
					try {
						stats = jQuery.parseJSON( stats );
						
						<?php if ( pb_backupbuddy::$options['log_level'] == '3' ) { // Full logging enabled. ?>
							console.log( 'Live Stats (due to log level):' );
							console.dir( stats );
						<?php } ?>
						
					} catch(e) { // NOT json or some error.
						alert( 'Error #937734: Unable to process BackupBuddy Stash Live stats. Invalid JSON. See browser console for details or here: `' + stats + '`.' );
						console.log( 'Live Stats Response (ERROR #4397347934):' );
						console.dir( stats );
						return false;
					}
					
					if ( 'function' == typeof backupbuddy_live_stats ) {
						backupbuddy_live_stats( stats );
					}
					if ( 'function' == typeof backupbuddy_live_admin_bar_stats ) {
						backupbuddy_live_admin_bar_stats( stats );
					}
					if ( 'function' == typeof backupbuddy_live_dashboard_stats ) {
						backupbuddy_live_dashboard_stats( stats );
					}
					
					setTimeout( 'backupbuddy_live_statsPoll()', 5000 );
				}
			});
		};
		
		jQuery(document).ready(function() {
			setTimeout( 'backupbuddy_live_statsPoll()', 5000 );
		});
	}
</script>