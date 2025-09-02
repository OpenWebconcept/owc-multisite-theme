<?php
$blockname = 'header-home';

$layouts[ $blockname ] = array(
	'order'      => 1,
	'key'        => 'layout_' . $blockname,
	'name'       => $blockname,
	'label'      => __( 'Search', 'strl' ),
	'display'    => 'block',
	'sub_fields' => array(
		array(
			'key'          => 'field_' . $blockname . '_title',
			'label'        => __( 'Title', 'strl' ),
			'name'         => $blockname . '-title',
			'type'         => 'text',
			'instructions' => __( 'This is the H1 of the page, it can only be used once.', 'strl' ),
			'required'     => 1,
		),
		array(
			'key'        => 'field_' . $blockname . '_searchterms',
			'label'      => __( 'Columns', 'strl' ),
			'name'       => $blockname . '-searchterms',
			'type'       => 'repeater',
			'layout'     => 'table',
			'sub_fields' => array(
				array(
					'key'   => 'field_searchterm_text',
					'label' => __( 'Searchterm', 'strl' ),
					'name'  => 'search-term',
					'type'  => 'text',
				),
				array(
					'key'          => 'field_searchterm_link',
					'label'        => __( 'Link', 'strl' ),
					'instructions' => __( 'On click on this tag user will land on the chosen page, if empty user will land on search page', 'strl' ),
					'name'         => 'search-term-link',
					'type'         => 'link',
				),
			),
		),
	),
	'min'        => 'fas fa-cube',
);
