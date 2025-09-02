<?php
$blockname = 'feedback-form';

$layouts[ $blockname ] = array(
	'order'      => 1,
	'key'        => 'layout_' . $blockname,
	'name'       => $blockname,
	'label'      => __( 'Feedback form', 'strl' ),
	'display'    => 'block',
	'sub_fields' => array(
	),
	'min'        => 'fas fa-cube',
);
