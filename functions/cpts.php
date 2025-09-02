<?php
strl_register_post_type(
	'article',
	array(
		'slug'     => 'publication',
		'singular' => __( 'News', 'strl' ),
		'plural'   => __( 'News', 'strl' ),
		'labels'   => array(),
		'args'     => array(
			'menu_icon' => 'dashicons-welcome-widgets-menus',
		),
	)
);

strl_register_post_type(
	'alert',
	array(
		'slug'     => 'alert',
		'singular' => __( 'Alert', 'strl' ),
		'plural'   => __( 'Alerts', 'strl' ),
		'labels'   => array(),
		'args'     => array(
			'publicly_queryable' => false,
			'menu_icon'          => 'dashicons-welcome-widgets-menus',
		),
	)
);

strl_register_post_type(
	'councillor',
	array(
		'slug'     => 'person',
		'singular' => __( 'Person', 'strl' ),
		'plural'   => __( 'Persons', 'strl' ),
		'labels'   => array(),
		'args'     => array(
			'menu_icon' => 'dashicons-welcome-widgets-menus',
		),
	)
);

strl_register_post_type(
	'faq',
	array(
		'slug'     => 'faq',
		'singular' => __( 'FAQ', 'strl' ),
		'plural'   => __( 'FAQS', 'strl' ),
		'labels'   => array(),
		'args'     => array(
			'publicly_queryable' => false,
			'menu_icon'          => 'dashicons-welcome-widgets-menus',
		),
	)
);

strl_register_post_type(
	'event',
	array(
		'slug'     => 'event',
		'singular' => __( 'Event', 'strl' ),
		'plural'   => __( 'Events', 'strl' ),
		'labels'   => array(),
		'args'     => array(
			'menu_icon' => 'dashicons-welcome-widgets-menus',
		),
	)
);

strl_register_post_type(
	'publication',
	array(
		'slug'     => 'publication',
		'singular' => __( 'Publication', 'strl' ),
		'plural'   => __( 'Publications', 'strl' ),
		'labels'   => array(),
		'args'     => array(
			'menu_icon' => 'dashicons-welcome-widgets-menus',
		),
	)
);

strl_register_post_type(
	'location',
	array(
		'slug'     => 'location',
		'singular' => __( 'Location', 'strl' ),
		'plural'   => __( 'Locations', 'strl' ),
		'labels'   => array(),
		'args'     => array(
			'menu_icon'          => 'dashicons-welcome-widgets-menus',
			'publicly_queryable' => false,
		),
	)
);
