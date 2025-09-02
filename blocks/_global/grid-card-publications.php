<?php
$post_id = ! empty( $args['post_id'] ) ? $args['post_id'] : get_the_ID();
$title   = get_the_title( $post_id );
$link    = get_the_permalink();
$image   = ! empty( get_field( 'article-image', $post_id ) ) ? get_field( 'article-image', $post_id ) : '';
$type    = ! empty( strl_get_primary_category( get_the_ID(), 'article_type' ) ) ? strl_get_primary_category( get_the_ID(), 'article_type' )->name : '';
?>
<div class="cell <?php echo $args['data']['columns']; ?>">
	<article class="<?php echo basename( __FILE__, '.php' ); ?> grid-card">
		<div class="content">
			<h3 class="h6"><?php echo $title; ?></h3>
		</div>
		<header class="card-header">
				<?php
				if ( ! empty( $image ) ) {
					echo strl_image(
						$image,
						'strl-medium',
						'strl-medium',
						'image',
					);
				}
				?>
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
