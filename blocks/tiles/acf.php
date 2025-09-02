<?php
$block_name = 'tiles';

$layouts[ $block_name ] = array(
	'order'      => 1,
	'key'        => 'layout_' . $block_name,
	'name'       => $block_name,
	'label'      => __( 'Tiles', 'strl' ),
	'display'    => 'block',
	'sub_fields' => array(
		array(
			'key'          => 'field_' . $block_name . '_tiles',
			'label'        => __( 'Tiles', 'strl' ),
			'name'         => $block_name . '-tiles',
			'type'         => 'repeater',
			'min'          => 1,
			'layout'       => 'block',
			'button_label' => __( 'Add tile', 'strl' ),
			'sub_fields'   => array(
				array(
					'key'           => 'field_' . $block_name . '_tiles_image',
					'label'         => __( 'Image', 'strl' ),
					'name'          => 'image',
					'type'          => 'image',
					'instructions'  => __( 'Ideal minimal size is 640x360px.', 'strl' ),
					'return_format' => 'array',
					'min_width'     => 640,
					'min_height'    => 360,
					'preview_size'  => 'thumbnail',
					'library'       => 'all',
				),
				array(
					'key'   => 'field_' . $block_name . '_tiles_text',
					'label' => __( 'Text', 'strl' ),
					'name'  => 'text',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_' . $block_name . '_tiles_link',
					'label' => __( 'Link', 'strl' ),
					'name'  => 'link',
					'type'  => 'link',
				),
			),
		),
		array(
			'key'           => 'field_' . $block_name . '_tiles_width',
			'label'         => __( 'Width of a tile', 'strl' ),
			'name'          => $block_name . '-tiles_width',
			'type'          => 'radio',
			'default_value' => 'small',
			'choices'       => array(
				'25' => '25%',
				'33' => '33%',
				'50' => '50%',
			),
		),
	),
	'min'        => 'fas fa-cube',
);
