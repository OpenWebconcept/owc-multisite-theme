<?php
$block_name = 'navigation-block';

$layouts[ $block_name ] = array(
	'order'      => 3,
	'key'        => 'layout_' . $block_name,
	'name'       => $block_name,
	'label'      => __( 'Navigation block', 'strl' ),
	'display'    => 'block',
	'sub_fields' => array(
		array(
			'key'           => 'field_' . $block_name . '_background_image',
			'label'         => __( 'Background image', 'strl' ),
			'name'          => $block_name . '-background-image',
			'type'          => 'image',
			'return_format' => 'id',
		),
		array(
			'key'   => 'field_' . $block_name . '_title',
			'label' => __( 'Title', 'strl' ),
			'name'  => $block_name . '-title',
			'type'  => 'text',
		),
		array(
			'key'          => 'field_' . $block_name . '_blocks',
			'label'        => __( 'Blocks', 'strl' ),
			'name'         => $block_name . '-blocks',
			'type'         => 'repeater',
			'layout'       => 'block',
			'required'     => 1,
			'min'          => 1,
			'max'          => 4,
			'button_label' => __( 'Add block', 'strl' ),
			'sub_fields'   => array(
				array(
					'key'         => 'field_' . $block_name . '_blocks_site',
					'label'       => __( 'Site', 'strl' ),
					'instruction' => __( 'Select for which subsite this block will be used for.', 'strl' ),
					'name'        => 'subsite',
					'type'        => 'select',
					'choices'     => array(),
					'required'    => 1,
					'wrapper'     => array(
						'width' => '50',
					),
				),
				array(
					'key'     => 'field_' . $block_name . '_blocks_button_type',
					'label'   => __( 'Button type', 'strl' ),
					'name'    => 'type',
					'type'    => 'select',
					'choices' => array(
						'primary'    => __( 'Primary', 'strl' ),
						'secondary'  => __( 'Secondary', 'strl' ),
						'tertiary'   => __( 'Tertiary', 'strl' ),
						'quaternary' => __( 'Quaternary', 'strl' ),
					),
					'wrapper' => array(
						'width' => '50',
					),
				),
				array(
					'key'           => 'field_' . $block_name . '_blocks_icon',
					'label'         => __( 'Icon/logo', 'strl' ),
					'name'          => 'icon',
					'type'          => 'image',
					'return_format' => 'id',
					'instructions'  => __( 'Ideal icon size: 136x136', 'strl' ),
				),
				array(
					'key'          => 'field_' . $block_name . '_links',
					'label'        => __( 'Links', 'strl' ),
					'name'         => 'links',
					'type'         => 'repeater',
					'layout'       => 'block',
					'button_label' => __( 'Add link', 'strl' ),
					'sub_fields'   => array(
						array(
							'key'      => 'field_' . $block_name . '_link_url',
							'label'    => __( 'URL', 'strl' ),
							'name'     => 'link',
							'type'     => 'link',
							'required' => 1,
						),
					),
				),
			),
		),
	),
	'min'        => 'fas fa-cube',
);
