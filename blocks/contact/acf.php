<?php
$blockname = 'contact';

$layouts[ $blockname ] = array(
	'order'      => 1,
	'key'        => 'layout_' . $blockname,
	'name'       => $blockname,
	'label'      => __( 'Contact', 'strl' ),
	'display'    => 'block',
	'sub_fields' => array(
		array(
			'key'      => 'field_' . $blockname . '_title',
			'label'    => __( 'Title', 'strl' ),
			'name'     => $blockname . '-title',
			'type'     => 'text',
			'required' => 0,
		),
		array(
			'key'       => 'field_' . $blockname . '_message',
			'type'      => 'message',
			'message'   => '<span style="color:#FF0000">' . __( 'All the contact possibillities are coming from the STRL Global', 'strl' ) . '</span>',
			'new_lines' => 'wpautop',
			'esc_html'  => 0,
		),
	),
	'min'        => 'fas fa-cube',
);
