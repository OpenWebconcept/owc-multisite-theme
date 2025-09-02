<?php
$blockname = 'header-image';

$layouts[ $blockname ] = array(
	'order'      => 1,
	'key'        => 'layout_' . $blockname,
	'name'       => $blockname,
	'label'      => __( 'Header image with options', 'strl' ),
	'display'    => 'block',
	'sub_fields' => array(
		array(
			'key'          => 'field_' . $blockname . '_title',
			'label'        => __( 'Title', 'strl' ),
			'name'         => $blockname . '-title',
			'type'         => 'text',
			'instructions' => __( 'This is the H1 of the page, it can only be used once.', 'strl' ),
		),
		array(
			'key'          => 'field_' . $blockname . '_content',
			'label'        => __( 'Content', 'strl' ),
			'name'         => $blockname . '-content',
			'type'         => 'wysiwyg',
			'media_upload' => 0,
			'toolbar'      => 'modern',
		),
		array(
			'key'           => 'field_' . $blockname . '_image',
			'label'         => __( 'Image', 'strl' ),
			'name'          => $blockname . '-image',
			'type'          => 'image',
			'instructions'  => __( 'Ideal minimal size is 1200x400px.', 'strl' ),
			'return_format' => 'id',
			'required'      => 1,
		),
		array(
			'key'   => 'field_' . $blockname . '_sidebar_1_title',
			'label' => __( 'Sidebar 1 title', 'strl' ),
			'name'  => $blockname . '-sidebar-1-title',
			'type'  => 'text',
		),
		array(
			'key'   => 'field_' . $blockname . '_sidebar_1_text',
			'label' => __( 'Sidebar 1 text', 'strl' ),
			'name'  => $blockname . '-sidebar-1-text',
			'type'  => 'textarea',
		),
		array(
			'key'          => 'field_' . $blockname . '_link_sidebars',
			'label'        => __( 'Link sidebars', 'strl' ),
			'name'         => $blockname . '-link-sidebars',
			'type'         => 'repeater',
			'instructions' => __( 'Add links to the sidebars.', 'strl' ),
			'button_label' => __( 'Add link', 'strl' ),
			'layout'       => 'block',
			'sub_fields'   => array(
				array(
					'key'      => 'field_' . $blockname . '_link_sidebars_url',
					'label'    => __( 'URL', 'strl' ),
					'name'     => 'links-sidebar',
					'type'     => 'link',
					'required' => 1,
				),
			),
		),
	),
	'min'        => 'fas fa-cube',
);
