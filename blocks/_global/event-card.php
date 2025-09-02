<?php
$post_id    = ! empty( $args['post_id'] ) ? $args['post_id'] : get_the_ID();
$title      = get_the_title();
$excerpt    = get_field( 'settings-group_post-excerpt-content' );             // use "get_field( 'search-content' )" for search results if available
$link       = get_permalink();
$start_date = get_field( 'event-start-date' );
$end_date   = get_field( 'event-end-date' );

// Format ACF times to what we need
$starting_time = end( explode( ' ', $start_date ) );
$ending_time   = end( explode( ' ', $end_date ) );
$start_date    = explode( ' ', $start_date );
array_pop( $start_date );
$start_date = implode( ' ', $start_date );

// Format for datecard
$startdata     = ! empty( $start_date ) ? explode( ' ', $start_date ) : '';
$startdatacard = ( ! empty( $startdata[0] ) && ! empty( $startdata[1] ) ) ? $startdata[1] . ' ' . $startdata[2] : '';

$enddata    = ! empty( $end_date ) ? explode( ' ', $end_date ) : '';
$endatacard = ( ! empty( $enddata[0] ) && ! empty( $enddata[1] ) ) ? $enddata[1] . ' ' . $enddata[2] : '';
?>
<div class="cell">
	<article class="<?php echo basename( __FILE__, '.php' ); ?>">
		<div class="content">
			<h3><?php echo $title; ?></h3>
			<?php
			if ( ! empty( $starting_time ) && ! empty( $ending_time ) ) {
				?>
			<span class="time"><?php echo $starting_time . ' - ' . $ending_time; ?></span>
				<?php
			} else {
				?>
				<span class="time"><?php echo $starting_time; ?></span>
				<?php
			}
			?>
			<?php
			if ( $excerpt ) {
				?>
				<p class="excerpt"><?php echo $excerpt; ?></p>
				<?php
			}
			?>
		</div>
		<header class="card-header">
			<div class="date bg-tertiary">
				<?php
				if ( $startdatacard === $endatacard ) {
					?>
					<div class="start">
						<span class="day"><?php echo $startdata[1]; ?></span>
						<span class="month"><?php echo strl_get_short_month_name( $startdata[2] ); ?></span>
					</div>
					<?php
				} else {
					?>
					<div class="start">
						<span class="day"><?php echo $startdata[1]; ?></span>
						<span class="month"><?php echo strl_get_short_month_name( $startdata[2] ); ?></span>
					</div>
					<?php
					if ( ! empty( $end_date ) ) {
						?>
						<div class="end">
							<span class="day"><?php echo $enddata[1]; ?></span>
							<span class="month"><?php echo strl_get_short_month_name( $enddata[2] ); ?></span>
						</div>
						<?php
					}
				}
				?>
			</div>
		</header>
		<?php
		if ( $link ) {
			?>
			<a href="<?php echo $link; ?>" class="overlay-link">
				<span class="screen-reader-text"><?php echo __( 'Read more about', 'strl-frontend' ) . ' ' . $title; ?></span>
			</a>
			<?php
		}
		?>
	</article>
</div>
