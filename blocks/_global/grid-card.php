<?php
$post_id   = ! empty( $args['post_id'] ) ? $args['post_id'] : get_the_ID();
$title     = get_the_title();
$excerpt   = get_field( 'settings-group_post-excerpt-content' ); // use "get_field( 'search-content' )" for search results if available
$link      = get_permalink();
$post_type = get_post_type();
$image     = get_field( 'settings-group_post-featured-image', $post_id );
?>
<div class="cell <?php echo $args['data']['columns']; ?>">
	<article class="<?php echo basename( __FILE__, '.php' ); ?>">
		<header class="card-header">
			<?php
			if ( ! empty( $image['sizes'] ) ) {
				?>
				<span class="posttype"><?php echo 'taxonomy'; ?></span>
				<img class="image" src="<?php echo $image['sizes']['strl-medium']; ?>" data-src="<?php echo $image['sizes']['strl-small']; ?>" data-srcset="<?php echo $image['sizes']['strl-small']; ?>, <?php echo $image['sizes']['strl-medium']; ?>" data-sizes="xs, s">
				<?php
			}
			?>
		</header>
		<div class="content">
		<h3><?php echo $title; ?></h3>
		</div>
		<?php
		if ( $link ) {
			?>
			<a href="<?php echo $link; ?>" class="overlay-link">
				<span class="screen-reader-text"><?php _e( 'Read more about', 'strl-frontend' ) . ' ' . $title; ?></span>
			</a>
			<?php
		}
		?>
	</article>
</div>
