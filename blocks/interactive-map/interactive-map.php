<?php
if ( ! class_exists( 'facetwp' ) ) {
	echo __( 'FacetWP plugin is required for this block to function.', 'strl' );
	return;
} 
$blockname     = basename( __FILE__, '.php' );
$prefix        = $blockname . '-';
$map           = do_shortcode( '[facetwp facet="location_map"]' );
$proximity     = do_shortcode( '[facetwp facet="location_proximity"]' );
$categories    = do_shortcode( '[facetwp facet="location_category"]' );
$neighborhoods = do_shortcode( '[facetwp facet="location_neighborhood"]' );

if ( ! is_plugin_active( 'facetwp-map-facet/facetwp-map-facet.php' ) ) {
	if ( is_user_logged_in() ) {
		echo __( 'The map isn\'t configured for this subsite. Please contact Stuurlui', 'strl' );
	}
	return;
}

$args = array(
	'post_type'      => 'location',
	'posts_per_page' => -1,
	'no_found_rows'  => true,
	'fields'         => 'ids',
	'order'          => 'ASC',
	'orderby'        => 'date',
	'facetwp'        => true,
);

$query = new WP_Query( $args );

?>
<!-- <?php echo $blockname; ?> -->
<section class="<?php echo $blockname; ?>">
	<div class="grid-container wide">
		<div class="grid-x grid-margin-x">
			<div class="cell">
				<div class="map-wrapper">
					<div class="proximity-wrapper">
						<?php echo $proximity; ?>
						<div class="icon-wrapper">
							<i class="fa-solid fa-caret-down"></i>
						</div>
					</div>
					<div class="category-wrapper">
						<h2 class="h4 filter-title"><?php _e( 'Filter', 'strl' ); ?></h2>
						<div>
							<h3 class="h6 filter-subtitle"><?php _e( 'Course type', 'strl' ); ?></h3>
							<?php echo $categories; ?>
						</div>
						<div>
							<h3 class="h6 filter-subtitle"><?php _e( 'Location', 'strl' ); ?></h3>
							<?php echo $neighborhoods; ?>
						</div>
					</div>
					<?php echo $map; ?>
				</div>
			</div>
		</div>
	</div>
	<div class="facetwp-template">
	</div>
</section>
<!-- end:<?php echo $blockname; ?> -->
