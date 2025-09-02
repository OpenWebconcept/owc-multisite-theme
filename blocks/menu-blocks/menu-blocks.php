<?php
$blockname    = basename( __FILE__, '.php' );
$prefix       = $blockname . '-';
$menus        = get_sub_field( $prefix . 'menus' );

$sidebaritems = get_sub_field( $prefix . 'sidebar-items' );
?>
<!-- <?php echo $blockname; ?> -->
<section class="<?php echo $blockname; ?> bg-tertiary has-background">
	<div class="grid-x grid-margin-x grid-margin-y medium-up-3 small-up-1">
		<?php
		if ( $menus ) {
			foreach ( $menus as $menu ) {
				$menutitle  = $menu['menu-blocks-menu-title'];
				$menusitems = $menu['menu-blocks-items'];
				?>
				<div class="cell">
					<div class="menu-block">
						<h2 class="h3"><?php echo $menutitle; ?></h2>
						<?php
						if ( $menusitems ) {
							echo '<ul>';
							foreach ( $menusitems as $menusitem ) {
								$link = $menusitem['menu-blocks-menu-link'];
								if ( $link ) {
									$link_url = $link['url'];
									$link_title = $link['title'];
									$link_target = $link['target'] ? $link['target'] : '_self';
									?>
										<li> <a href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a></li>
									<?php
								}
							}
							echo '</ul>';
						}
						?>
					</div>
				</div>
				<?php
			}
		}
		?>
	</div>
</section>
<!-- end:<?php echo $blockname; ?> -->
