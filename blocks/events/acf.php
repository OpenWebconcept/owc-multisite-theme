<?php

if ( ! class_exists( 'facetwp' ) ) {
	return;
} 

$blockname = 'events';

$layouts[ $blockname ] = array(
	'order'      => 3,
	'key'        => 'layout_' . $blockname,
	'name'       => $blockname,
	'label'      => __( 'Events', 'strl' ),
	'display'    => 'block',
	'sub_fields' => array(
		array(
			'key'       => 'field_' . $blockname . '_content',
			'label'     => 'Content',
			'type'      => 'tab',
			'placement' => 'top',
		),
		array(
			'key'           => 'field_' . $blockname . '_type',
			'label'         => __( 'I want to...', 'strl' ),
			'name'          => $blockname . '-type',
			'type'          => 'radio',
			'default_value' => 'newest',
			'layout'        => 'horizontal',
			'choices'       => array(
				'upcoming' => __( 'Display the upcoming events', 'strl' ),
				'featured' => __( 'Only show featured events', 'strl' ),
			),
		),
		array(
			'key'           => 'field_' . $blockname . '_link',
			'label'         => __( 'Link', 'strl' ),
			'name'          => $blockname . '-link',
			'type'          => 'link',
			'return_format' => 'array',
		),
		array(
			'key'               => 'field_' . $blockname . '_max',
			'label'             => __( 'Maximum amount of events', 'strl' ),
			'name'              => $blockname . '-max',
			'type'              => 'number',
			'instructions'      => __( 'Empty equals default', 'strl' ),
			'required'          => 1,
			'conditional_logic' => array(
				array(
					array(
						'field'    => 'field_' . $blockname . '_type',
						'operator' => '==',
						'value'    => 'upcoming',
					),
				),
			),
		),
	),
	'min'        => 'fas fa-cube',
);
