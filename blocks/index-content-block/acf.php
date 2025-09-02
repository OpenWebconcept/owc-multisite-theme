<?php
$blockname = 'index-content-block';

$layouts[ $blockname ] = array(
	'order'      => 3,
	'key'        => 'layout_' . $blockname,
	'name'       => $blockname,
	'label'      => __( 'Index block', 'strl' ),
	'display'    => 'block',
	'sub_fields' => array(
		array(
			'key'   => 'field_' . $blockname . '_content',
			'label' => __( 'Content', 'strl' ),
			'name'  => $blockname . '-content',
			'type'  => 'tab',
		),
		array(
			'key'               => 'field_' . $blockname . '_text',
			'label'             => __( 'Text', 'strl' ),
			'name'              => $blockname . '-text',
			'type'              => 'wysiwyg',
			'instructions'      => '',
			'required'          => 1,
			'conditional_logic' => 0,
			'default_value'     => '',
			'tabs'              => 'all',
			'toolbar'           => 'modern',
			'media_upload'      => 1,
			'delay'             => 0,
		),
	),
	'min'        => 'fas fa-cube',
);
