<?php
$blockname = 'menu-blocks';

$layouts[ $blockname ] = array(
	'order'      => 1,
	'key'        => 'layout_' . $blockname,
	'name'       => $blockname,
	'label'      => __( 'Menus', 'strl' ),
	'display'    => 'block',
	'sub_fields' => array(
		array(
			'key'          => 'field_' . $blockname . '_menus',
			'label'        => __( 'Menus', 'strl' ),
			'name'         => $blockname . '-menus',
			'type'         => 'repeater',
			'layout'       => 'table',
			'button_label' => 'Kolom toevoegen',
			'required'     => 1,
			'max'          => '3',
			'sub_fields' => array(
				array(
					'key'          => 'field_' . $blockname . '_sidebar_title',
					'label'        => __( 'Column title', 'strl' ),
					'name'         => $blockname . '-menu-title',
					'type'         => 'text',
					'required'     => 1,
				),
				array(
					'key'        => 'field_' . $blockname . '_items',
					'label'      => __( 'Menu items', 'strl' ),
					'name'       => $blockname . '-items',
					'type'       => 'repeater',
					'layout'     => 'table',
					'required'   => 1,
					'button_label'  => 'Link toevoegen',
					'sub_fields' => array(
						array(
							'key'        => 'field_' . $blockname . '_menur_link',
							'label'      => __( 'Link', 'strl' ),
							'name'       => $blockname . '-menu-link',
							'type'          => 'link',
							'return_format' => 'array',
						),
					),
				),
			),
		),

	),
	'min'        => 'fas fa-cube',
);
