<?php
$text  = ! empty( $args['text'] ) ? $args['text'] : '';
$link  = ! empty( $args['link'] ) ? $args['link'] : '';
$image = ! empty( $args['image'] ) ? $args['image'] : '';
?>
<div class="cell">
	<article class="<?php echo basename( __FILE__, '.php' ); ?>">
		<header class="card-header">
			<?php
			if ( ! empty( $image ) && ! empty( $text ) ) {
				?>
				<div class="post-meta">
					<h2 class="h3"><?php echo $text; ?></h2>
				</div>
				<img class="image" src="<?php echo $image['sizes']['strl-medium']; ?>" data-src="<?php echo $image['sizes']['strl-small']; ?>" data-srcset="<?php echo $image['sizes']['strl-small']; ?>, <?php echo $image['sizes']['strl-medium']; ?>" data-sizes="xs, s" alt="<?php echo $image['alt']; ?>">
				<?php
			}
			?>
		</header>
		<?php
		if ( ! empty( $link ) ) {
			$title  = ! empty( $link['title'] ) ? $link['title'] : '';
			$url    = ! empty( $link['url'] ) ? $link['url'] : '';
			$target = ! empty( $link['target'] ) ? $link['target'] : '_self';
			?>
			<a href="<?php echo $url; ?>" class="overlay-link" target="<?php echo $target; ?>">
				<span class="screen-reader-text"><?php echo sprintf( __( 'Read more about %s', 'strl-frontend' ), $title ); ?></span>
			</a>
			<?php
		}
		?>
	</article>
</div>
