<?php
$blockname = 'featured';

$layouts[ $blockname ] = array(
	'order'      => 1,
	'key'        => 'layout_' . $blockname,
	'name'       => $blockname,
	'label'      => __( 'Featured', 'strl' ),
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
					'key'        => 'field_' . $blockname . '_title',
					'label'      => __( 'Title', 'strl' ),
					'name'       => $blockname . '-title',
					'type'       => 'text',
				),
				array(
					'key'        => 'field_' . $blockname . '_text',
					'label'      => __( 'Text', 'strl' ),
					'name'       => $blockname . '-text',
					'type'       => 'text',
				),
				array(
					'key'        => 'field_' . $blockname . '_link',
					'label'      => __( 'Link', 'strl' ),
					'name'       => $blockname . '-link',
					'type'          => 'link',
					'return_format' => 'array',
				),
			),
		),
	),
	'min'        => 'fas fa-cube',
);
