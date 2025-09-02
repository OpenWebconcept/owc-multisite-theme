<?php
if ( ! class_exists( 'facetwp' ) ) {
	echo __( 'FacetWP plugin is required for this block to function.', 'strl' );
	return;
} 
$blockname = basename( __FILE__, '.php' );
$prefix    = $blockname . '-';

$pagination        = do_shortcode( '[facetwp facet="pagination"]' );
$filter_search     = do_shortcode( '[facetwp facet="search_publications"]' );
$filter_categories = do_shortcode( '[facetwp facet="publication_category"]' );
$counter           = do_shortcode( '[facetwp facet="resultsamount"]' );
$filter_selections = do_shortcode( '[facetwp selections="true"]' );

$args = array(
	'post_type'      => 'publication',
	'post_status'    => array( 'publish' ),
	'posts_per_page' => 10,
	'facetwp'        => true,
	'orderby'        => 'date',
	'order'          => 'DESC',
);

$query = new WP_Query( $args );
?>
<!-- <?php echo $blockname; ?> -->
<section class="<?php echo $blockname; ?>">
	<div class="grid-container">
		<div class="grid-x grid-margin-x grid-margin-y">
			<div class="cell large-4">
				<div class="filters bg-white show-for-large">
					<h2 class="h3"><?php _e( 'Filter', 'strl' ); ?></h2>
					<div class="search-wrapper">
						<?php echo $filter_search; ?>
						<button class="btn primary" onclick="FWP.refresh();">
							<i class="fa-solid fa-magnifying-glass"></i>
							<span class="screen-reader-text">
								<?php _e( 'Search within publications', 'strl' ); ?>
							</span>
						</button>
					</div>
					<details class="filter-accordion" open>
						<summary class="filter-title">
							<h3 class="h4"><?php _e( 'Category', 'strl' ); ?></h3>
						</summary>
						<div class="filter-content">
							<?php echo $filter_categories; ?>
						</div>
					</details>
					<button class="reset-filters btn primary show-for-large" onclick="FWP.reset()"><?php _e( 'Clear all filters', 'strl' ); ?>
						<i class="fa-regular fa-xmark"></i>
					</button>
				</div>
				<button class="btn filters-trigger primary offcanvas-toggler hide-for-large filter-open" data-toggle="filters-offcanvas"><?php _e( 'Filter', 'strl' ); ?> <i class="fa-solid fa-sliders-up"></i></button>
				<div class="offcanvas custom-filters closed hide-for-large" data-toggler="filters-offcanvas">
					<div class="top">
						<h2 class="h3"><?php _e( 'Filters', 'strl' ); ?></h2>
						<button class="filters-close btn primary offcanvas-toggler offcanvas-closer" data-toggle="filters-offcanvas">
							<i class="fa-regular fa-xmark"></i>
							<span class="screen-reader-text">
								<?php _e( 'Show results', 'strl' ); ?>
							</span>
						</button>
					</div>
					<div class="inner">
						<div class="filters">
							<div class="search-wrapper">
								<?php echo $filter_search; ?>
								<button class="btn" onclick="FWP.refresh();">
									<i class="fa-solid fa-magnifying-glass"></i>
									<span class="screen-reader-text">
										<?php _e( 'Search within publications', 'strl' ); ?>
									</span>
								</button>
							</div>
							<details class="filter-accordion" open>
								<summary class="filter-title">
									<h3 class="h4"><?php _e( 'Category', 'strl' ); ?></h3>
								</summary>
								<div class="filter-content">
									<?php echo $filter_categories; ?>
								</div>
							</details>
							<button class="reset-filters btn ghost show-for-large" onclick="FWP.reset()"><?php _e( 'Clear all filters', 'strl' ); ?>
								<i class="fa-regular fa-xmark"></i>
							</button>
						</div>
					</div>
					<button class="btn primary offcanvas-toggler filters-close show-results" aria-live="polite" data-toggle="filters-offcanvas" type="button" tabindex="0"><?php echo __( 'Show', 'strl' ) . ' ' . $counter; ?></button>
				</div>
			</div>
			<div class="cell large-8">
				<div class="grid-x grid-margin-y">
					<div class="cell resultsamount" aria-live="polite" role="region">
						<div class="filter-current"><?php echo ! empty( $filter_selections ) ? ' ' . '<span class="selected-filters" data-value="' . __( 'Selected filters:', 'strl' ) . '">' . __( 'Selected filters:', 'strl' ) . '</span>' . $filter_selections : ''; ?></div>
						<?php echo $counter; ?>
					</div>
				</div>
				<div class="grid-x grid-margin-y facetwp-template" data-per-page="<?php echo FWP()->facet->pager_args['per_page']; ?>">
					<?php
					if ( $query->have_posts() ) {
						while ( $query->have_posts() ) {
							$query->the_post();
							get_template_part(
								'blocks/_global/publications-card',
								null,
								array(
									'post_id' => get_the_ID(),
								)
							);
						}
						wp_reset_query();
					} else {
						?>
						<div class="cell">
							<div class="text">
								<p><?php _e( 'Unfortunately, no results have been found.', 'strl' ); ?></p>
							</div>
						</div>
						<?php
					}
					?>
				</div>
				<div class="pagination">
					<?php echo $pagination; ?>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- end:<?php echo $blockname; ?> -->
