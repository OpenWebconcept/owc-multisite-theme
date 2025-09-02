<?php
if ( ! class_exists( 'facetwp' ) ) {
	echo __( 'FacetWP plugin is required for this block to function.', 'strl' );
	return;
} 

$blockname  = basename( __FILE__, '.php' );
$prefix     = $blockname . '-';
$title      = get_sub_field( $prefix . 'title' );
$pagination = do_shortcode( '[facetwp facet="example_pagination"]' );
$selected   = get_sub_field( $prefix . 'type' );
$args       = array(
	'post_type'      => 'councillor',
	'posts_per_page' => '-1',
	'facetwp'        => true,
);

if ( 'manual' === $selected ) {
	$persons          = ! empty( get_sub_field( $prefix . 'selected-persons' ) ) ? get_sub_field( $prefix . 'selected-persons' ) : '';
	$args['post__in'] = $persons;
}

$wp_query = new WP_Query( $args );
?>
<!-- <?php echo $blockname; ?> -->
<section class="<?php echo $blockname; ?>">
	<?php
	if ( $title ) {
		?>
		<div class="grid-x grid-margin-x">
			<div class="cell">
				<h2><?php echo $title; ?></h2>
			</div>
		</div>
		<?php
	}
	?>
	<div class="grid-x grid-margin-x grid-margin-y">
		<div class="cell medium-8 medium-order-1 small-order-2">
			<div class="grid-x grid-margin-x grid-margin-y large-up-3 medium-up-2 small-up-2 facetwp-template stretch">
				<?php
				if ( 'manual' !== $selected && $wp_query->have_posts() ) {
					while ( $wp_query->have_posts() ) {
						$wp_query->the_post();
						get_template_part(
							'blocks/_global/councillor-card',
							null,
							array(
								'post_id'      => get_the_ID(),
								'heading_size' => ! empty( $title ) ? 'h3' : 'h2',
							)
						);
					}
				} elseif ( 'manual' === $selected && ! empty( $persons ) ) {
					foreach ( $persons as $post ) {
						setup_postdata( $post );
						get_template_part(
							'blocks/_global/councillor-card',
							null,
							array(
								'post_id'      => $post,
								'heading_size' => ! empty( $title ) ? 'h3' : 'h2',
							)
						);
					}
				} else {
					?>
					<div class="cell small-12">
						<p class="no-results h6"><?php _e( 'There are no events found', 'strl-frontend' ); ?></p>
					</div>
					<?php
				}
				wp_reset_postdata();
				?>
			</div>
			<div class="pagination">
				<?php echo $pagination; ?>
			</div>
		</div>
	</div>
	<?php wp_reset_query(); ?>
</section>
<!-- end:<?php echo $blockname; ?> -->
