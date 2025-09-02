<?php
strl_register_taxonomy(
	'article_audience',
	'article',
	array(
		'singular' => __( 'Audience', 'strl' ),
		'plural'   => __( 'Audiences', 'strl' ),
		'labels'   => array(),
		'args'     => array(
			'rewrite'     => array( 'slug' => _x( 'audience', 'slug', 'strl' ) ),
			'description' => _x( 'Optional description', 'taxonomy description', 'strl' ),
		),
	)
);

strl_register_taxonomy(
	'article_type',
	'article',
	array(
		'singular' => __( 'Type', 'strl' ),
		'plural'   => __( 'Type', 'strl' ),
		'labels'   => array(),
		'args'     => array(
			'rewrite'     => array( 'slug' => _x( 'type', 'slug', 'strl' ) ),
			'description' => _x( 'Optional description', 'taxonomy description', 'strl' ),
		),
	)
);

strl_register_taxonomy(
	'article_usage',
	'article',
	array(
		'singular' => __( 'Usage', 'strl' ),
		'plural'   => __( 'Usage', 'strl' ),
		'labels'   => array(),
		'args'     => array(
			'rewrite'     => array( 'slug' => _x( 'usage', 'slug', 'strl' ) ),
			'description' => _x( 'Optional description', 'taxonomy description', 'strl' ),
		),
	)
);

strl_register_taxonomy(
	'article_highlight',
	'article',
	array(
		'singular' => __( 'Highlight', 'strl' ),
		'plural'   => __( 'Highlights', 'strl' ),
		'labels'   => array(),
		'args'     => array(
			'rewrite'     => array( 'slug' => _x( 'highlight', 'slug', 'strl' ) ),
			'description' => _x( 'Optional description', 'taxonomy description', 'strl' ),
		),
	)
);

strl_register_taxonomy(
	'faq_category',
	'faq',
	array(
		'singular' => __( 'Category', 'strl' ),
		'plural'   => __( 'Categories', 'strl' ),
		'labels'   => array(),
		'args'     => array(
			'rewrite' => array( 'slug' => _x( 'category', 'slug', 'strl' ) ),
		),
	)
);

strl_register_taxonomy(
	'event_highlight',
	'event',
	array(
		'singular' => __( 'Highlight', 'strl' ),
		'plural'   => __( 'Highlights', 'strl' ),
		'labels'   => array(),
		'args'     => array(
			'rewrite'     => array( 'slug' => _x( 'event-highlight', 'slug', 'strl' ) ),
			'description' => _x( 'Optional description', 'taxonomy description', 'strl' ),
		),
	)
);

strl_register_taxonomy(
	'product_aspect',
	array( 'page', 'article' ),
	array(
		'singular' => __( 'Aspect', 'strl' ),
		'plural'   => __( 'Aspects', 'strl' ),
		'labels'   => array(),
		'args'     => array(
			'rewrite'     => array( 'slug' => _x( 'Aspect', 'slug', 'strl' ) ),
			'description' => _x( 'Optional description', 'taxonomy description', 'strl' ),
		),
	)
);

strl_register_taxonomy(
	'product_owner',
	array( 'page', 'article' ),
	array(
		'singular' => __( 'Owner', 'strl' ),
		'plural'   => __( 'Owners', 'strl' ),
		'labels'   => array(),
		'args'     => array(
			'rewrite'     => array( 'slug' => _x( 'Owner', 'slug', 'strl' ) ),
			'description' => _x( 'Optional description', 'taxonomy description', 'strl' ),
		),
	)
);

strl_register_taxonomy(
	'publication_category',
	'publication',
	array(
		'singular' => __( 'Category', 'strl' ),
		'plural'   => __( 'Categories', 'strl' ),
		'labels'   => array(),
		'args'     => array(),
	)
);

strl_register_taxonomy(
	'location_category',
	'location',
	array(
		'singular' => __( 'Category', 'strl' ),
		'plural'   => __( 'Categories', 'strl' ),
		'labels'   => array(),
		'args'     => array(),
	)
);

strl_register_taxonomy(
	'location_neighborhood',
	'location',
	array(
		'singular' => __( 'Neighborhood', 'strl' ),
		'plural'   => __( 'Neighborhoods', 'strl' ),
		'labels'   => array(),
		'args'     => array(),
	)
);
