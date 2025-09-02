<?php
if ( ! class_exists( 'facetwp' ) ) {
	echo __( 'FacetWP plugin is required for this block to function.', 'strl' );
	return;
} 
$blockname     = basename( __FILE__, '.php' );
$prefix        = $blockname . '-';
$title         = get_sub_field( $prefix . 'title' );
$current_month = '';

$filter = do_shortcode( '[facetwp facet="events_datefilter"]' );
?>
<!-- <?php echo $blockname; ?> -->
<section class="<?php echo $blockname; ?>">
	<div class="grid-x grid-margin-x grid-margin-y">
		<div class="cell">
			<h1><?php echo $title; ?></h1>
		</div>
	</div>
	<div class="grid-x grid-margin-x grid-margin-y">
		<div class="cell medium-3">
			<div class="filter-group">
				<div class="filter-title bg-quaternary">
					<h2><?php _e( 'Date', 'strl-frontend' ); ?></h2>
				</div>
				<form class="bg-white">
					<?php echo $filter; ?>
					<button class="reset-filter" onclick="FWP.reset()"><?php _e( 'Reset filters', 'strl-frontend' ); ?></button>
				</form>
			</div>
		</div>
		<div class="cell medium-9">
			<div class="facet-results" data-per-page="<?php echo FWP()->facet->pager_args['per_page']; ?>">
				<div class="grid-x grid-margin-x small-up-1 stretch">
					<?php
					$args = array(
						'post_type'      => 'event',
						'posts_per_page' => -1,
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

					$i = 1;
					if ( $query->have_posts() ) {
						echo '<span class="sr-only" style="opacity: 0">' . __( 'Events', 'strl-frontend' ) . '</span>';
						while ( $query->have_posts() ) {
							$query->the_post();
							$postid     = get_the_ID();
							$date       = get_field( 'event-start-date', $postid );
							$date       = explode( ' ', $date );
							$item_month = $date[2] . ' ' . $date[3];
							// Cache item month/year

							// Open new group if new month
							if ( $current_month !== $item_month ) {

								if ( 1 !== $i ) {
									echo '</div>';
									echo '</div>';
								}
								echo '<div class="month-wrapper cell">';
								echo '<p class="month h3">' . ucfirst( $item_month ) . '</p>';
								echo '<div class="grid-x grid-margin-y">';
							}

							get_template_part( 'blocks/_global/event-card' );

							// Cache $curret_month
							$current_month = $item_month;
							$i++;
						}
						echo '</div>';
						echo '</div>';
					}
					wp_reset_postdata();
					?>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- end:<?php echo $blockname; ?> -->
