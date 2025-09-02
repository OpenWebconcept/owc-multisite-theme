<?php
$post_id = ! empty( $args['post_id'] ) ? $args['post_id'] : get_the_ID();
$title   = get_the_title( $post_id );
$link    = get_the_permalink();
$image   = ! empty( get_field( 'article-image', $post_id ) ) ? get_field( 'article-image', $post_id ) : '';
$type    = ! empty( strl_get_primary_category( get_the_ID(), 'article_type' ) ) ? strl_get_primary_category( get_the_ID(), 'article_type' )->name : '';
$columns = ! empty( $args['data']['columns'] ) ? $args['data']['columns'] : '';
?>
<div class="cell <?php echo $columns; ?>">
	<article class="<?php echo basename( __FILE__, '.php' ); ?>">
		<header class="card-header">
			<div class="post-meta">
				<h2 class="h3"><?php echo $title; ?></h2>
			</div>
			<?php
			if ( ! empty( $image ) ) {
				echo strl_image(
					$image,
					'strl-medium',
					'strl-medium',
					'image',
					( 2 === get_row_index() ? array(
						'decoding' => 'async',
						'loading'  => 'lazy',
					) : array() ),
					false,
				);
			}
			?>
		</header>
		<?php
		if ( $link ) {
			?>
			<a href="<?php echo $link; ?>" class="overlay-link">
			<span class="screen-reader-text"><?php echo sprintf( __( 'Read more about %s', 'strl-frontend' ), $title ); ?></span>
			</a>
			<?php
		}
		?>
	</article>
</div>
