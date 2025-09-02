<?php
$blockname = 'galleryblock';

$layouts[ $blockname ] = array(
	'order'      => 8,
	'key'        => 'layout_' . $blockname,
	'name'       => $blockname,
	'label'      => __( 'Gallery Block', 'strl' ),
	'display'    => 'block',
	'sub_fields' => array(
		array(
			'key'          => 'field_' . $blockname . '_title',
			'label'        => __( 'Title', 'strl' ),
			'name'         => $blockname . '-title',
			'type'         => 'text',
			'instructions' => __( 'This title is optional, is place before the content', 'strl' ),
			'required'     => 0,
		),
		array(
			'key'          => 'field_' . $blockname . '_images',
			'label'        => __( 'Images', 'strl' ),
			'name'         => $blockname . '-images',
			'type'         => 'gallery',
			'instructions' => __( 'Upload your images here, these are presented as a gallery on the website. You can modify the order by drag and drop.', 'strl' ),
			'required'     => 1,
		),
	),
	'min'        => 'fas fa-cube',
	'max'        => 'media',
);
