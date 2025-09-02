<?php
$blockname     = 'faq-select';
$blocknicename = ucfirst( __( 'FAQ Select', 'strl' ) );

$layouts[ $blockname ] = array(
	'order'      => 14,
	'key'        => 'layout_' . $blockname,
	'name'       => $blockname,
	'label'      => $blocknicename,
	'display'    => 'block',
	'sub_fields' => array(
		array(
			'key'   => 'field_' . $blockname . '_title',
			'label' => __( 'Title', 'strl' ),
			'name'  => $blockname . '-title',
			'type'  => 'text',
		),
		array(
			'key'          => 'field_' . $blockname . '_text',
			'label'        => __( 'Intro', 'strl' ),
			'name'         => $blockname . '-text',
			'type'         => 'wysiwyg',
			'tabs'         => 'all',
			'toolbar'      => 'modern',
			'media_upload' => 1,
			'delay'        => 1,
		),
		array(
			'key'               => 'field_' . $blockname . '_items',
			'label'             => __( 'Add FAQ\'s', 'strl' ),
			'name'              => $blockname . '-items',
			'type'              => 'relationship',
			'instructions'      => '',
			'required'          => 0,
			'conditional_logic' => 0,
			'post_type'         => array(
				0 => 'faq',
			),
			'taxonomy'          => '',
			'filters'           => array(
				0 => 'search',
				1 => 'taxonomy',
			),
			'elements'          => array(),
			'min'               => '',
			'max'               => '',
			'return_format'     => 'object',
		),
	),
	'min'        => 'far fa-question-circle',
	'max'        => '',
);
