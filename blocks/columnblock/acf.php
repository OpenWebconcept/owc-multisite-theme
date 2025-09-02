<?php
$blockname = 'columnblock';

$layouts[ $blockname ] = array(
	'order'      => 3,
	'key'        => 'layout_' . $blockname,
	'name'       => $blockname,
	'label'      => __( 'Column Block', 'strl' ),
	'display'    => 'block',
	'sub_fields' => array(
		array(
			'key'        => 'field_' . $blockname . '_columns',
			'label'      => __( 'Columns', 'strl' ),
			'name'       => $blockname . '-columns',
			'type'       => 'repeater',
			'layout'     => 'table',
			'required'   => 1,
			'button_label' => 'Kolom toevoegen',
			'sub_fields' => array(
				array(
					'key'          => 'field_columns_text',
					'label'        => __( 'Text', 'strl' ),
					'name'         => 'columns-text',
					'type'         => 'wysiwyg',
					'tabs'         => 'all',
					'toolbar'      => 'modern',
					'media_upload' => 1,
					'delay'        => 0,
				),
			),
		),
	),
	'min'        => 'fas fa-cube',
);
