<?php
header( 'Cache-Control: no-store, no-cache, must-revalidate, max-age=0' );
header( 'Cache-Control: post-check=0, pre-check=0', false );
header( 'Pragma: no-cache' );
define( 'WP_USE_THEMES', false );
require $_SERVER['DOCUMENT_ROOT'] . '/wp-load.php';

expire_posts_function();

function expire_posts_function() {
	$args  = array(
		'post_type'      => 'event',
		'posts_per_page' => -1,
		'post_status'    => 'publish',
	);
	$posts = get_posts( $args );

	foreach ( $posts as $post ) {
		$expire_date = get_field( 'event-end-date', $post->ID );

		// Bail if no expire date set.
		if ( ! $expire_date ) {
			$expire_date = get_field( 'event-start-date', $post->ID );
		}

		$actual_date = time();

		// CHANGED cause you do want to show when exp-date = 05-12 and current-date = 05-12 (?)
		if ( $expire_date < $actual_date ) {
			wp_update_post(
				array(
					'ID'          => $post->ID,
					'post_status' => 'draft',
				)
			);
		}
	}
}
