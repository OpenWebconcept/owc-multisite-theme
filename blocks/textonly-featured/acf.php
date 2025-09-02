<?php
$blockname     = 'textonly-featured';

$layouts[ $blockname ] = array(
	'order'      => 60,
	'key'        => 'layout_' . $blockname,
	'name'       => $blockname,
	'label'      => __( 'Content featured', 'strl' ),
	'display'    => 'block',
	'sub_fields' => array(
		array(
			'key'       => 'field_' . $blockname . '_content',
			'label'     => 'Content',
			'type'      => 'tab',
			'placement' => 'top',
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
	'max'        => '',
);
?>
