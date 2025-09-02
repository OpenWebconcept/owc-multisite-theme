<?php
$blockname = 'header-image-simple';

$layouts[ $blockname ] = array(
	'order'      => 1,
	'key'        => 'layout_' . $blockname,
	'name'       => $blockname,
	'label'      => __( 'Header image', 'strl' ),
	'display'    => 'block',
	'sub_fields' => array(
		array(
			'key'          => 'field_' . $blockname . '_title',
			'label'        => __( 'Title', 'strl' ),
			'name'         => $blockname . '-title',
			'type'         => 'text',
			'instructions' => __( 'This is the H1 of the page, it can only be used once.', 'strl' ),
			'required'     => 0,
		),
		array(
			'key'           => 'field_' . $blockname . '_image',
			'label'         => __( 'Image', 'strl' ),
			'name'          => $blockname . '-image',
			'type'          => 'image',
			'instructions'  => __( 'Ideal minimal size is 1200x400px.', 'strl' ),
			'return_format' => 'id',
			'preview_size'  => 'thumbnail',
			'library'       => 'all',
		),
	),
	'min'        => 'fas fa-cube',
);
