<?php
if ( ! class_exists( 'facetwp' ) ) {
	echo __( 'FacetWP plugin is required for this block to function.', 'strl' );
	return;
} 
$blockname = basename( __FILE__, '.php' );
$prefix    = $blockname . '-';
$link      = get_sub_field( $prefix . 'link' );
$type      = get_sub_field( $prefix . 'type' );
$max       = ! empty( get_sub_field( $prefix . 'max' ) ) ? get_sub_field( $prefix . 'max' ) : '-1';

if ( 'upcoming' === $type ) {
	$args  = array(
		'post_type'      => 'event',
		'posts_per_page' => $max,
		'facetwp'        => true,
		'meta_key'       => 'event-start-date',
		'orderby'        => 'meta_value',
		'order'          => 'ASC',
		'meta_query'     => array(
			'relation' => 'OR',
			array(
				'key'     => 'event-end-date',
				'value'   => wp_date( 'Y-m-d' ),
				'compare' => '>=',
				'type'    => 'DATE',
			),
			array(
				'key'     => 'event-start-date',
				'value'   => wp_date( 'Y-m-d' ),
				'compare' => '>=',
				'type'    => 'DATE',
			),
		),
	);
	$query = new WP_Query( $args );
}
if ( 'featured' === $type ) {
	$args  = array(
		'post_type'      => 'event',
		'posts_per_page' => -1,
		'facetwp'        => true,
		'orderby'        => 'meta_value',
		'order'          => 'ASC',
		'tax_query'      => array(
			array(
				'taxonomy' => 'event_highlight',
				'field'    => 'slug',
				'terms'    => 'uitgelicht',
			),
		),
		'meta_query'     => array(
			'relation' => 'OR',
			array(
				'key'     => 'event-end-date',
				'value'   => wp_date( 'Y/m/d' ),
				'compare' => '>=',
				'type'    => 'DATE',
			),
			array(
				'key'     => 'event-start-date',
				'value'   => wp_date( 'Y/m/d' ),
				'compare' => '>=',
				'type'    => 'DATE',
			),
		),
	);
	$query = new WP_Query( $args );
}

if ( ! isset( $query ) || ! $query->have_posts() ) {
	return;
}
?>
<!-- <?php echo $blockname; ?> -->
<section class="<?php echo $blockname; ?> bg-quaternary has-background">
	<div class="grid-x grid-margin-x large-up-3 medium-up-2 small-up-1 grid-margin-y">
		<?php
		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();
				$postid = get_the_ID();
				$date   = get_field( 'event-start-date', $postid );
				$date   = explode( ' ', $date );
				get_template_part( 'blocks/_global/event-card' );
			}
		}
		wp_reset_postdata();
		?>
	</div>
	<div class="grid-x grid-margin-x grid-margin-y">
		<div class="cell">
			<div class="text text-right">
				<?php
				if ( $link ) {
					$link_url    = $link['url'];
					$link_title  = $link['title'];
					$link_target = $link['target'] ? $link['target'] : '_self';
					?>
					<a class="btn quaternary contrast icon" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>">
						<?php echo esc_html( $link_title ); ?>
						<span class="screen-reader-text"><?php _e( 'Go to events overview', 'strl-frontend' ); ?></span>
					</a>
					<?php
				}
				?>
			</div>
		</div>
	</div>
</section>
<!-- end:<?php echo $blockname; ?> -->
