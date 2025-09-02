<?php
$post_id      = ! empty( $args['post_id'] ) ? $args['post_id'] : get_the_ID();
$title        = get_the_title();
$region       = get_field( 'counsillor-region' );
$excerpt      = get_field( 'settings-group_post-excerpt-content' );               // use "get_field( 'search-content' )" for search results if available
$link         = get_permalink();
$post_type    = get_post_type();
$image        = get_field( 'settings-group_post-featured-image', $post_id );
$heading_size = ! empty( $args['heading_size'] ) ? $args['heading_size'] : 'h2';
?>
<div class="cell">
	<article class="<?php echo basename( __FILE__, '.php' ); ?>">
		<header class="card-header">
			<?php
			if ( ! empty( $image['sizes'] ) ) {
				?>
				<!-- <span class="logo"><?php echo $post_type; ?></span> -->
				<img alt="" class="image" src="<?php echo $image['sizes']['strl-medium']; ?>" data-src="<?php echo $image['sizes']['strl-small']; ?>" data-srcset="<?php echo $image['sizes']['strl-small']; ?>, <?php echo $image['sizes']['strl-medium']; ?>" data-sizes="xs, s">
				<?php
			}
			?>
		</header>
		<div class="content">
			<<?php echo $heading_size; ?> class="h4"><?php echo $title; ?></<?php echo $heading_size; ?>>
			<?php echo ! empty( $region ) ? '<p class="region">' . $region . '</p>' : ''; ?>
		</div>
		<?php
		if ( $excerpt ) {
			?>
			<div class="content">
				<p><?php echo $excerpt; ?></p>
			</div>
			<?php
		}
		?>
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
