<?php
/**
 * We need to use the search.php template instead of page.php for GET requests
 * to the name "s" in search forms. To still use our Search page, we get the
 * page ID and customize the query on this page
 */
get_header();

$page_id = strl_get_default_page_for( 'search' );
$args    = array(
	'post_type'     => 'page',
	'post__in'      => array( $page_id ),
	'no_found_rows' => true,
);
query_posts( $args );

while ( have_posts() ) {
	the_post();
	if ( class_exists( 'acf' ) ) {
		get_template_part( 'search-template' );
	}
}

get_footer();
