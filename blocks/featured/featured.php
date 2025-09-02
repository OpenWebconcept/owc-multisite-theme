<?php
$blockname   = basename( __FILE__, '.php' );
$prefix      = $blockname . '-';
$title       = get_sub_field( $prefix . 'title' );
$items       = get_sub_field( $prefix . 'items' );
?>
<!-- <?php echo $blockname; ?> -->
<section class="<?php echo $blockname; ?>">
	<div class="grid-x grid-margin-x">
		<div class="cell">
			<h2><?php echo $title; ?></h2>
		</div>
	</div>
	<div class="grid-x grid-margin-x grid-margin-y medium-up-2 small-up-1">
		<?php
		if ( $items ) {
			foreach ( $items as $item ) {
				$title = $item['featured-title'];
				$text  = $item['featured-text'];
				$link  = $item['featured-link'];
				if ( $link ) {
					$link_url = $link['url'];
					$link_title = $link['title'];
					$link_target = $link['target'] ? $link['target'] : '_self';
					?>
					<div class="cell">
						<div class="item bg-quaternary">
							<div class="inner">
								<h3><?php echo $title; ?></h3>
								<p><?php echo $text; ?></p>
							</div>
							<a class="overlay-link" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>">
								<span class="screen-reader-text"><?php _e( 'Read more about', 'strl-frontend' ) . ' ' . $link_title; ?></span>
							</a>
						</div>
					</div>
					<?php
				}
			}
		}
		?>
	</div>
</section>
<!-- end:<?php echo $blockname; ?> -->
