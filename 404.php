<?php
/**
 * We need to use the 404.php template instead of page.php for 404's because
 * WordPress doesn't check the page.php for this status code.
 */
$page_id = strl_get_default_page_for( 'not-found' );

if ( 16 === get_current_blog_id() ) {
	get_header( 'no-nav' );
} else {
	get_header();
}

$args = array(
	'post_type'     => 'page',
	'post__in'      => array( $page_id ),
	'no_found_rows' => true,
);
query_posts( $args );

while ( have_posts() ) {
	the_post();
	if ( class_exists( 'acf' ) ) {
		?>
		<section class="header-search bg-secondary has-background">
			<div class="grid-x grid-margin-x">
				<div class="cell large-6">
					<h1><?php _e( 'The requested page does not exist (anymore).', 'strl-frontend' ); ?></h1>
					<form class="headersearch" action="<?php echo get_permalink( strl_get_default_page_for( 'search' ) ); ?>" method="get" aria-haspopup="true">
						<label for="s" style="display: none;"><?php _e( 'Search', 'strl-frontend' ); ?></label>
						<input placeholder="<?php _e( 'Fill in your search terms', 'strl-frontend' ); ?>" type="text" name="_search_search" value="" data-swplive="false" />
						<button type="submit">
							<i class="fa-regular fa-magnifying-glass"></i>
							<span class="screen-reader-text"><?php _e( 'search', 'strl-frontend' ); ?></span>
						</button>
					</form>
				</div>
			</div>
		</section>
		<?php
		if ( have_rows( 'blocks' ) ) {
			while ( have_rows( 'blocks' ) ) {
				the_row();
				get_template_part( 'blocks/' . get_row_layout() . '/' . get_row_layout() );
			}
		}
	}
}

get_footer();
