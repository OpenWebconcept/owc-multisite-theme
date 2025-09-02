<?php
$blockname = basename( __FILE__, '.php' );
$prefix    = $blockname . '-';
$title     = get_sub_field( $prefix . 'title' );
$items     = get_sub_field( $prefix . 'items' );
?>
<!-- <?php echo $blockname; ?> -->
<section class="<?php echo $blockname; ?> has-background bg-secondary">
	<div class="grid-x grid-margin-x">
		<div class="cell">
			<h2><?php echo $title; ?></h2>
		</div>
	</div>
	<div class="grid-x grid-margin-x grid-margin-y large-up-3 medium-up-2 small-up-1">
		<?php
		if ( $items ) {
			foreach ( $items as $item ) {
				$icon = ! empty( wp_get_attachment_image_src( $item['information-icon'], 'thumbnail' )[0] ) ? wp_get_attachment_image_src( $item['information-icon'], 'thumbnail' )[0] : '';
				$link = $item['information-link'];
				if ( $link ) {
					$link_url    = ! empty( $link['url'] ) ? $link['url'] : '';
					$link_title  = ! empty( $link['title'] ) ? $link['title'] : '';
					$link_target = ! empty( $link['target'] ) ? $link['target'] : '_self';
					?>
					<div class="cell">
						<div class="item bg-white">
							<?php
							if ( ! empty( $icon ) ) {
								?>
								<span class="icon" style="background-image: url('<?php echo $icon; ?>');"></span>
								<?php
							}
							if ( ! empty( $link_title ) ) {
								?>
								<span class="content">
									<?php echo $link_title; ?>
								</span>
								<?php
							}
							if ( ! empty( $link_url ) ) {
								?>
								<a class="overlay-link" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>">
									<span class="screen-reader-text">
										<?php
										echo
										sprintf(
											__( 'Read more about: %s', 'strl-frontend' ),
											$link_title
										);
										?>
									</span>
								</a>
								<?php
							}
							?>
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
