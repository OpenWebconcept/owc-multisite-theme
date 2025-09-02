<?php

if ( ! class_exists( 'facetwp' ) ) {
	return;
} 

$blockname = 'publications-overview';

$layouts[ $blockname ] = array(
	'order'      => 1,
	'key'        => 'layout_' . $blockname,
	'name'       => $blockname,
	'label'      => __( 'Publications overview', 'strl' ),
	'display'    => 'block',
	'sub_fields' => array(
		array(
			'key'     => 'field_' . $blockname . '_message',
			'message' => '<span class="dashicons dashicons-info"></span> ' . __( 'Shows publication overview. Block has no other options.', 'strl' ),
			'name'    => $blockname . '-message',
			'type'    => 'message',
		),
	),
	'min'        => 'fas fa-cube',
);
