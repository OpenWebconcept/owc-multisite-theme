<?php
$blockname = 'news-overview';

$layouts[ $blockname ] = array(
	'order'      => 5,
	'key'        => 'layout_' . $blockname,
	'name'       => $blockname,
	'label'      => __( 'News homepage', 'strl' ),
	'display'    => 'block',
	'sub_fields' => array(
		array(
			'key'           => 'field_' . $blockname . '_type',
			'label'         => __( 'I want to...', 'strl' ),
			'name'          => $blockname . '-type',
			'type'          => 'radio',
			'default_value' => 'newest',
			'layout'        => 'horizontal',
			'choices'       => array(
				'newest'   => __( 'Display the newest articles', 'strl' ),
				'manual'   => __( 'Manually select articles', 'strl' ),
				'featured' => __( 'Only show featured articles', 'strl' ),
			),
		),
		array(
			'key'               => 'field_' . $blockname . '_items',
			'label'             => __( 'Select products', 'strl' ),
			'name'              => $blockname . '-items',
			'type'              => 'relationship',
			'max'               => '5',
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
				0 => 'article',
			),
			'taxonomy'          => '',
			'filters'           => array(
				0 => 'search',
			),
		),
		array(
			'key'           => 'field_' . $blockname . '_link',
			'label'         => __( 'Link', 'strl' ),
			'name'          => $blockname . '-link',
			'type'          => 'link',
			'return_format' => 'array',
		),
	),
	'min'        => 'fas fa-cube',
);
