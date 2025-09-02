<?php
$image      = get_field( 'settings-group_post-featured-image', $post_id );
$title      = get_the_title();
$start_date = get_field( 'event-start-date' );
$end_date   = get_field( 'event-end-date' );

// Format ACF times to what we need
$starting_time = end( explode( ' ', $start_date ) );
$ending_time   = end( explode( ' ', $end_date ) );

// Format for datecard
$startdata     = explode( ' ', $start_date );
$startdatacard = $startdata[1] . ' ' . $startdata[2];

$enddata    = explode( ' ', $end_date );
$endatacard = $enddata[1] . ' ' . $enddata[2];

$publicationndate = get_the_date( 'd-m-Y' );
get_header();

if ( post_password_required() ) {
	?>
	<div class="grid-container">
		<div class="grid-x grid-margin-x">
			<div class="cell medium-8">
				<?php echo get_the_password_form( $post->ID ); ?>
			</div>
		</div>
	</div>
	<?php
} else {
	while ( have_posts() ) {
		the_post();
		if ( class_exists( 'acf' ) ) {
			if ( ! empty( $image['sizes'] ) ) {
				?>
				<section class="event-header-image">
					<div class="grid-x grid-margin-x">
						<div class="cell">
							<img alt="<?php echo $image['title']; ?>" class="image" src="<?php echo $image['sizes']['strl-large']; ?>" data-src="<?php echo $image['sizes']['strl-small']; ?>" data-srcset="<?php echo $image['sizes']['strl-small']; ?>, <?php echo $image['sizes']['strl-medium']; ?>" data-sizes="xs, s">
							<?php echo strl_add_read_speaker(); ?>
						</div>
					</div>
				</section>
				<?php
			}
			?>
			<section class="single-event-content">
				<div class="grid-x grid-margin-x">
					<div class="cell large-8 large-order-1 small-order-2" tabindex="1">
						<div class="event-inner">
							<div class="event-intro">
								<div class="flex-wrap">
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
									<div class="title">
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
										<h1><?php echo $title; ?></h1>
									</div>
								</div>
								<span class="created"><?php echo __( 'Created on: ', 'strl-frontend' ) . $publicationndate; ?></span><br>
								<span class="modified"><?php echo __( 'Last modified on: ', 'strl-frontend' ) . get_the_modified_date( 'd-m-Y H:i:s' ); ?></span>
							</div>
							<?php
							if ( have_rows( 'blocks' ) ) {
								while ( have_rows( 'blocks' ) ) {
									the_row();
									get_template_part( 'blocks/' . get_row_layout() . '/' . get_row_layout() );
								}
							}
							?>
						</div>
					</div>
				</div>
			</section>
			<?php
		}
	}
}

get_footer();
