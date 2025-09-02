<?php

if ( ! class_exists( 'facetwp' ) ) {
	return;
} 

$blockname = 'overview-news';

$layouts[ $blockname ] = array(
	'order'      => 5,
	'key'        => 'layout_' . $blockname,
	'name'       => $blockname,
	'label'      => __( 'Overview news', 'strl' ),
	'display'    => 'block',
	'sub_fields' => array(
		array(
			'key'           => 'field_' . $blockname . '_image',
			'label'         => __( 'Image', 'strl' ),
			'name'          => $blockname . '-image',
			'type'          => 'image',
			'instructions'  => __( 'Ideal minimal size is 1200x400px.', 'strl' ),
			'return_format' => 'id',
		),
		array(
			'key'      => 'field_' . $blockname . '_title',
			'label'    => __( 'Title', 'strl' ),
			'name'     => $blockname . '-title',
			'type'     => 'text',
			'required' => 1,
		),
		array(
			'key'   => 'field_' . $blockname . '_description',
			'label' => __( 'Description', 'strl' ),
			'name'  => $blockname . '-description',
			'type'  => 'textarea',
		),
		array(
			'key'       => 'field_' . $blockname . '_message',
			'type'      => 'message',
			'message'   => '<span style="color:#FF0000">' . __( 'This block will fetch all the news articles', 'strl' ) . '</span>',
			'new_lines' => 'wpautop',
			'esc_html'  => 0,
		),
	),
	'min'        => 'fas fa-cube',
);
