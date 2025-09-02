<?php
$blockname = 'pages-sidebar';

$layouts[ $blockname ] = array(
	'order'      => 1,
	'key'        => 'layout_' . $blockname,
	'name'       => $blockname,
	'label'      => __( 'Pages with sidebar', 'strl' ),
	'display'    => 'block',
	'sub_fields' => array(
		array(
			'key'       => 'field_' . $blockname . '_content',
			'label'     => 'Content',
			'type'      => 'tab',
			'placement' => 'top',
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
					'key'        => 'field_' . $blockname . '_link',
					'label'      => __( 'Link', 'strl' ),
					'name'       => $blockname . '-link',
					'aria-label'    => 'contact-button-link',
					'type'          => 'link',
					'return_format' => 'array',
				),
			),
		),
		array(
			'key'       => 'field_' . $blockname . '_sidebar',
			'label'     => 'Sidebar',
			'type'      => 'tab',
			'placement' => 'top',
		),
		array(
			'key'          => 'field_' . $blockname . '_sidebar_title',
			'label'        => __( 'Title', 'strl' ),
			'name'         => $blockname . '-sidebar-title',
			'type'         => 'text',
			'required'     => 1,
		),
		array(
			'key'        => 'field_' . $blockname . '_sidebaritems',
			'label'      => __( 'Sidebar items', 'strl' ),
			'name'       => $blockname . '-sidebar-items',
			'type'       => 'repeater',
			'layout'     => 'table',
			'required'   => 1,
			'sub_fields' => array(
				array(
					'key'        => 'field_' . $blockname . '_sidebar_link',
					'label'      => __( 'Link', 'strl' ),
					'name'       => $blockname . '-sidebar-link',
					'type'          => 'link',
					'return_format' => 'array',
				),
			),
		),
	),
	'min'        => 'fas fa-cube',
);
