<?php
$post_id      = ! empty( $args['post_id'] ) ? $args['post_id'] : get_the_ID();
$title        = get_the_title();
$date         = get_the_date( 'd-m-Y' );
$excerpt      = ! empty( get_field( 'settings-group_post-excerpt-content', $post_id ) ) ? get_field( 'settings-group_post-excerpt-content', $post_id ) : get_field( 'article-openpub-description' );
$excerpt      = strip_tags( $excerpt );                                                                                                                                                               // use "get_field( 'search-content' )" for search results if available
$link         = get_permalink();
$image        = ! empty( get_field( 'settings-group_post-featured-image', $post_id ) ) ? get_field( 'settings-group_post-featured-image', $post_id )['ID'] : '';
$heading_size = ! empty( $args['heading_size'] ) ? $args['heading_size'] : 'h3';
?>
<div class="cell">
	<article class="<?php echo basename( __FILE__, '.php' ); ?>">
		<header class="card-header">
			<div class="titlewrap">
				<<?php echo $heading_size; ?> class="title h3"><?php echo $title; ?></<?php echo $heading_size; ?>>
				<span class="date"><?php echo $date; ?></span>
			</div>
			<?php
			if ( ! empty( $image ) ) {
				echo strl_image(
					$image,
					'strl-large',
					'strl-medium',
					'',
					array(),
					false,
				);
			}
			?>
		</header>
		<div class="content">
			<div>
				<?php
				if ( $excerpt ) {
					?>
					<p><?php echo strl_excerpt( $excerpt, 150 ); ?></p>
					<?php
				}
				?>
				<span class="btn primary rs-skip" aria-hidden="true">
					<?php _e( 'Read more', 'strl-frontend' ); ?>
					<i class="far fa-angle-right" aria-hidden="true"></i>
				</span>
			</div>
		</div>
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
