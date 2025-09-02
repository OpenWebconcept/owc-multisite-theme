<?php

if ( ! class_exists( 'facetwp' ) ) {
	return;
} 

$blockname = 'overview-events';

$layouts[ $blockname ] = array(
	'key'        => 'layout_' . $blockname,
	'name'       => $blockname,
	'label'      => __( 'Overview Events', 'strl' ),
	'display'    => 'block',
	'sub_fields' => array(
		array(
			'key'          => 'field_' . $blockname . '_title',
			'label'        => __( 'Title', 'strl' ),
			'name'         => $blockname . '-title',
			'type'         => 'text',
			'required'     => 1,
		),
		array(
			'key'               => 'field_' . $blockname . '_message',
			'type'              => 'message',
			'message'           => '<span style="color:#FF0000">' . __( 'This block will fetch all the upcoming events', 'strl' ) . '</span>',
			'new_lines'         => 'wpautop',
			'esc_html'          => 0,
		),
	),
	'min'        => 'fas fa-cube',
);
