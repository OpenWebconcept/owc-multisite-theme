<?php
/** Template Name: Search template */
get_header();

if ( ! class_exists( 'facetwp' ) ) {
	echo __( 'FacetWP plugin is required for this block to function.', 'strl' );
	return;
} 

if ( class_exists( 'acf' ) ) {
	$searchterm        = isset( $_GET['_search_search'] ) ? preg_replace( '/("|\')/i', '', html_entity_decode( strip_tags( $_GET['_search_search'] ) ) ) : ' ';
	$cptfilter         = do_shortcode( '[facetwp facet="search_cpt"]' );
	$amount            = do_shortcode( '[facetwp facet="search_resultsamount"]' );
	$loadmore          = do_shortcode( '[facetwp facet="search_pagination"]' );
	$facetwpselections = do_shortcode( '[facetwp selections="true"]' );
	$search_filter     = do_shortcode( '[facetwp facet="search_search"]' );
	$post_types        = array( 'article', 'page', 'event', 'person' );
	$items             = array();

	$args = array(
		'post_type'      => $post_types,
		'posts_per_page' => 10,
		'post_status'    => 'publish',
		'facetwp'        => true,
	);

	$wp_query = new WP_Query( $args );

	?>
	<section class="header-search has-background bg-secondary">
		<div class="grid-x grid-margin-x">
			<div class="cell large-6">
				<?php echo strl_add_read_speaker(); ?>
				<h1><?php _e( 'I am looking for', 'strl-frontend' ); ?></h1>
				<form class="headersearch" action="<?php echo get_permalink( strl_get_default_page_for( 'search' ) ); ?>" method="get" aria-haspopup="true">
					<label for="s" style="position: absolute; left: -9999px;"><?php _e( 'Fill in your search terms', 'strl-frontend' ); ?></label>
					<input placeholder="<?php _e( 'Fill in your search terms', 'strl-frontend' ); ?>" type="text" name="_search_search" value="<?php echo $searchterm; ?>" data-aria-label="<?php _e( 'Fill in your search terms', 'strl-frontend' ); ?>" data-swplive="false" />
					<button type="submit">
						<i class="fa-regular fa-magnifying-glass"></i>
						<span class="screen-reader-text"><?php _e( 'search', 'strl-frontend' ); ?></span>
					</button>
				</form>
			</div>
		</div>
	</section>
	<section class="search has-background bg-white" style="display: none">
		<div class="grid-x grid-margin-x">
			<div class="cell">
				<h2>Zoekresultaten voor '<?php echo $searchterm; ?>'</h2>
				<?php echo $amount; ?>
			</div>
		</div>
		<div class="grid-x grid-margin-x">
			<div class="large-4 cell">
				<div class="filter-wrapper">
					<div class="wrapper">
						<form class="bg-white">
							<fieldset>
								<div class="filter-title bg-secondary">
									<legend><?php _e( 'Type', 'strl-frontend' ); ?></legend>
								</div>
								<?php echo $cptfilter; ?>
							</fieldset>
							<div class="searchterm-placeholder">
								<?php echo do_shortcode( '[facetwp facet="search_search"]' ); ?>
							</div>
						</form>
						<button class="reset-filter btn primary" onclick="FWP.reset()"><?php _e( 'Reset filters', 'strl-frontend' ); ?></button>
					</div>
				</div>
			</div>
			<div class="large-8 cell">
				<div class="grid-x grid-margin-x grid-margin-y facetwp-template stretch">
					<?php
					if ( $wp_query->have_posts() ) {
						while ( $wp_query->have_posts() ) {
							$wp_query->the_post();
							$cpt = get_post_type( $post->ID );
							if ( 'event' === $cpt ) {
								include ABSPATH . 'wp-content/themes/owc-multisite-theme/blocks/_global/event-card.php';
							} else {
								include ABSPATH . 'wp-content/themes/owc-multisite-theme/blocks/_global/search-card.php';
							}
						}
					}
					?>
				</div>
				<div class="grid-x grid-margin-x">
					<div class="cell">
						<div class="pagination">
							<?php echo $loadmore; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<?php wp_reset_query(); ?>
	<?php
}

get_footer();
