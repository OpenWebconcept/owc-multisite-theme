<?php

if ( ! class_exists( 'facetwp' ) ) {
	return;
} 

$blockname = 'interactive-map';

$layouts[ $blockname ] = array(
	'order'      => 3,
	'key'        => 'layout_' . $blockname,
	'name'       => $blockname,
	'label'      => __( 'Interactive map', 'strl' ),
	'display'    => 'block',
	'sub_fields' => array(
		array(
			'key'     => 'field_' . $blockname . '_message',
			'message' => '<span class="dashicons dashicons-info"></span> ' . __( 'Shows all locations. Block has no other options.', 'strl' ),
			'name'    => $blockname . '-message',
			'type'    => 'message',
		),
	),
	'min'        => 'fas fa-cube',
);
