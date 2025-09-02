<?php
$blockname = basename( __FILE__, '.php' );
$prefix    = $blockname . '-';
$title     = ! empty( $args['title'] ) ? $args['title'] : get_sub_field( $prefix . 'title' );
$content   = ! empty( $args['intro'] ) ? $args['intro'] : get_sub_field( $prefix . 'content' );
$image     = ! empty( $args['featured-image'] ) ? $args['featured-image'] : get_sub_field( $prefix . 'image' );

$title_sidebar_1 = get_sub_field( $prefix . 'sidebar-1-title' );
$text_sidebar_1  = get_sub_field( $prefix . 'sidebar-1-text' );
$link_sidebars   = get_sub_field( $prefix . 'link-sidebars' );
$class           = 'medium-6';
if ( ! empty( $title_sidebar_1 ) || ! empty( $text_sidebar_1 ) || ! empty( $link_sidebars ) ) {
	$class = 'medium-8 large-9';
}
?>
<!-- <?php echo $blockname; ?> -->
<section class="<?php echo $blockname; ?> <?php echo ! empty( $image ) ? 'has-image' : ''; ?>">
	<div class="header-image-grid <?php echo ! empty( $image ) ? 'has-image' : 'no-image'; ?>">
		<?php
		if ( ! empty( $image ) ) {
			?>
			<div class="background-wrapper">
				<?php
				echo strl_image(
					$image,
					'strl-large',
					'strl-large',
					'',
					array(),
					false,
				);
				?>
			</div>
			<?php
		}
		?>
		<div class="header-image-content">
			<div class="grid-container">
				<div class="grid-x grid-margin-x grid-margin-y">
					<?php
					if ( ! empty( $title ) || ! empty( $content ) ) {
						?>
						<div class="cell small-12 <?php echo $class; ?>">
							<div class="content-wrapper">
							<?php
							if ( ! empty( $title ) ) {
								?>
								<h1><?php echo $title; ?></h1>
								<?php
							}

							if ( ! empty( $content ) ) {
								?>
								<div class="text">
									<?php echo apply_filters( 'the_content', $content ); ?>
								</div>
								<?php
							}
							?>
							</div>
						</div>
						<?php
					}
					if ( ! empty( $title_sidebar_1 ) || ! empty( $text_sidebar_1 ) || ! empty( $link_sidebars ) ) {
						?>
						<div class="cell small-12 medium-4 large-3">
							<div class="sidebar-1 bg-white">
								<?php
								if ( ! empty( $title_sidebar_1 ) ) {
									?>
									<h2 class="h6"><?php echo $title_sidebar_1; ?></h2>
									<?php
								}

								if ( ! empty( $text_sidebar_1 ) ) {
									?>
									<div class="text">
										<?php echo apply_filters( 'the_content', $text_sidebar_1 ); ?>
									</div>
									<?php
								}
								?>
							</div>
								<?php

								if ( ! empty( $link_sidebars ) ) {
									?>
									<div class="links">
										<?php
										foreach ( $link_sidebars as $link ) {
											$link = ! empty( $link['links-sidebar'] ) ? $link['links-sidebar'] : array();
											if ( empty( $link ) ) {
												continue;
											}

											$title  = ! empty( $link['title'] ) ? $link['title'] : '';
											$url    = ! empty( $link['url'] ) ? $link['url'] : '';
											$target = ! empty( $link['target'] ) ? $link['target'] : '_self';
											$srt    = '_blank' === $target ? '<span class="screen-reader-text">' . __( 'This link opens in a new tab', 'strl' ) . '</span>' : '';
											?>
											<a class="link" href="<?php echo $url; ?>" target="<?php echo $target; ?>"><?php echo $title . ' ' . $srt; ?></a>
											<?php
										}
										?>
									</div>
									<?php
								}
								?>
						</div>
						<?php
					}
					?>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- end:<?php echo $blockname; ?> -->
