<?php
$blockname    = basename( __FILE__, '.php' );
$prefix       = $blockname . '-';
$items        = get_sub_field( $prefix . 'items' );
$sidebartitle = get_sub_field( $prefix . 'sidebar-title' );
$sidebaritems = get_sub_field( $prefix . 'sidebar-items' );
?>
<!-- <?php echo $blockname; ?> -->
<section class="<?php echo $blockname; ?> bg-tertiary has-background">
	<div class="grid-x grid-margin-x grid-margin-y">
		<div class="cell large-8">
			<div class="grid-x grid-margin-x grid-margin-y stretch medium-up-2 small-up-1">
				<?php
				if ( $items ) {
					foreach ( $items as $item ) {
						$link = $item['pages-sidebar-link'];
						if ( $link ) {
							$link_url = $link['url'];
							$link_title = $link['title'];
							$link_target = $link['target'] ? $link['target'] : '_self';
							?>
							<div class="cell">
								<div class="item bg-white">
									<span class="content">
										<?php echo $link_title; ?>
									</span>
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
		</div>
		<div class="cell large-4">
			<div class="sidebar-menu">
				<span class="sidebar-title bg-secondary"><?php echo $sidebartitle; ?></span>
				<?php
				if ( $sidebaritems ) {
					echo '<ul class="bg-white">';
					foreach ( $sidebaritems as $sidebaritem ) {
						$link = $sidebaritem['pages-sidebar-sidebar-link'];
						if ( $link ) {
							$link_url = $link['url'];
							$link_title = $link['title'];
							$link_target = $link['target'] ? $link['target'] : '_self';
							?>
								<li> <a href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><span><?php echo esc_html( $link_title ); ?></span></a></li>
							<?php
						}
					}
					echo '</ul>';
				}
				?>
			</div>
		</div>
	</div>
</section>
<!-- end:<?php echo $blockname; ?> -->
