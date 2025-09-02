<?php
$blockname = 'information';

$layouts[ $blockname ] = array(
	'order'      => 1,
	'key'        => 'layout_' . $blockname,
	'name'       => $blockname,
	'label'      => __( 'Information', 'strl' ),
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
			'key'        => 'field_' . $blockname . '_items',
			'label'      => __( 'Items', 'strl' ),
			'name'       => $blockname . '-items',
			'type'       => 'repeater',
			'layout'     => 'table',
			'required'   => 1,
			'sub_fields' => array(
				array(
					'key'        => 'field_' . $blockname . '_icon',
					'label'      => __( 'Icon', 'strl' ),
					'name'       => $blockname . '-icon',
					'type'          => 'image',
					'return_format' => 'id',
					'preview_size'  => 'thumbnail',
					'library'       => 'all',
				),
				array(
					'key'        => 'field_' . $blockname . '_link',
					'label'      => __( 'Link', 'strl' ),
					'name'       => $blockname . '-link',
					'aria-label'    => 'contact-button-link',
					'type'          => 'link',
					'return_format' => 'array',
				),
			),
		),
	),
	'min'        => 'fas fa-cube',
);
