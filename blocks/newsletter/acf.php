<?php
$blockname = 'newsletter';

$layouts[ $blockname ] = array(
	'order'      => 1,
	'key'        => 'layout_' . $blockname,
	'name'       => $blockname,
	'label'      => __( 'CTA block', 'strl' ),
	'display'    => 'block',
	'sub_fields' => array(
	),
	'min'        => 'fas fa-cube',
);
