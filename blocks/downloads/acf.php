<?php
$blockname = 'downloads';

$layouts[ $blockname ] = array(
	'order'      => 3,
	'key'        => 'layout_' . $blockname,
	'name'       => $blockname,
	'label'      => __( 'Downloads', 'strl' ),
	'display'    => 'block',
	'sub_fields' => array(
		array(
			'key'          => 'field_' . $blockname . '_downloads',
			'label'        => __( 'Link or download', 'strl' ),
			'name'         => $blockname . '-items',
			'type'         => 'repeater',
			'layout'       => 'table',
			'button_label' => __( 'Add link or download', 'strl' ),
			'sub_fields'   => array(
				array(
					'key'     => 'field_' . $blockname . '_type',
					'label'   => __( 'Is it an external link or dowload', 'strl' ),
					'name'    => $blockname . '-type',
					'type'    => 'radio',
					'choices' => array(
						'link'  => __( 'Link', 'strl' ),
						'download' => __( 'Download', 'strl' ),
					),
				),
				array(
					'key'   => 'field_' . $blockname . '_download_title',
					'label' => __( 'Title', 'strl' ),
					'name'  => 'title',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_' . $blockname . '_download_text',
					'label' => __( 'text', 'strl' ),
					'name'  => 'text',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_' . $blockname . '_download_link',
					'label' => __( 'link', 'strl' ),
					'name'  => 'link',
					'type'  => 'link',
				),
			),
		),
	),
	'min'        => 'fas fa-cube',
);
