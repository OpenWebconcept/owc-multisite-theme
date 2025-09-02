<?php
if ( ! class_exists( 'facetwp' ) ) {
	return;
} 

$blockname = 'counsillors';

$layouts[ $blockname ] = array(
	'order'      => 5,
	'key'        => 'layout_' . $blockname,
	'name'       => $blockname,
	'label'      => __( 'Counsillors', 'strl' ),
	'display'    => 'block',
	'sub_fields' => array(
		array(
			'key'          => 'field_' . $blockname . '_title',
			'label'        => __( 'Title', 'strl' ),
			'name'         => $blockname . '-title',
			'type'         => 'text',
			'instructions' => __( 'This title is optional, is place before the content', 'strl' ),
		),
		array(
			'key'           => 'field_' . $blockname . '_type',
			'label'         => __( 'I want to show?', 'strl' ),
			'name'          => $blockname . '-type',
			'type'          => 'radio',
			'required'      => 0,
			'choices'       => array(
				'all'    => __( 'All persons', 'strl' ),
				'manual' => __( 'Manually select persons', 'strl' ),
			),
			'default_value' => 'all',
		),
		array(
			'key'               => 'field_' . $blockname . '_selected_persons',
			'label'             => __( 'Add persons', 'strl' ),
			'name'              => $blockname . '-selected-persons',
			'type'              => 'relationship',
			'conditional_logic' => array(
				array(
					array(
						'field'    => 'field_' . $blockname . '_type',
						'operator' => '==',
						'value'    => 'manual',
					),
				),
			),
			'post_type'         => array(
				0 => 'councillor',
			),
			'filters'           => array(
				0 => 'search',
			),
			'elements'          => array(),
			'return_format'     => 'id',
		),
	),
	'min'        => 'fas fa-cube',
);
