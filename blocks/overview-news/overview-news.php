<?php
if ( ! class_exists( 'facetwp' ) ) {
	echo __( 'FacetWP plugin is required for this block to function.', 'strl' );
	return;
} 
$blockname = basename( __FILE__, '.php' );
$prefix    = $blockname . '-';

$header_image = get_sub_field( $prefix . 'image' );
$title        = get_sub_field( $prefix . 'title' );
$description  = ! empty( get_sub_field( $prefix . 'description' ) ) ? apply_filters( 'the_content', get_sub_field( $prefix . 'description' ) ) : '';
$pagination   = do_shortcode( '[facetwp facet="search_pagination"]' );
$heading_size = ! empty( $title ) ? 'h2' : 'h1';
$args         = array(
	'post_type'      => 'article',
	'posts_per_page' => 6,
	'orderby'        => 'date',
	'order'          => 'DESC',
	'facetwp'        => true,
);

$wp_query = new WP_Query( $args );
?>
<!-- <?php echo $blockname; ?> -->
<section class="<?php echo $blockname; ?> <?php echo ! empty( $image ) ? 'has-image' : ''; ?>">
	<?php
	if ( ! empty( $header_image ) ) {
		?>
		<div class="background-wrapper">
			<?php
			echo strl_image(
				$header_image,
				'strl-large',
				'strl-large',
				'',
				array(),
				false,
			);
			?>
		</div>
		<?php
	}
	?>
	<div class="grid-x grid-margin-x grid-margin-y title-row">
		<div class="cell large-6 small-12">
			<div class="title-card">
				<h1><?php echo $title; ?></h1>
				<?php echo $description; ?>
			</div>
		</div>
	</div>
	<div class="grid-x">
		<div class="cell medium-12">
			<div class="grid-x grid-margin-x grid-margin-y large-up-3 small-up-1">
				<?php
				if ( $wp_query->have_posts() ) {
					while ( $wp_query->have_posts() ) {
						$wp_query->the_post();

						get_template_part(
							'blocks/_global/news-card',
							'',
							array(
								'post_id'      => $post->ID,
								'heading_size' => $heading_size,
							),
						);
					}
				}
				wp_reset_query();
				?>
			</div>
			<div class="pagination">
				<?php echo $pagination; ?>
			</div>
		</div>
	</div>
</section>
<!-- end:<?php echo $blockname; ?> -->
