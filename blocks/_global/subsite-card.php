<?php
$part_name = basename( __FILE__, '.php' );
$content   = ! empty( $args['content'] ) ? $args['content'] : '';
$has_title = ! empty( $args['has-title'] ) ? $args['has-title'] : false;

if ( empty( $content ) ) {
	return;
}

$subsite     = ! empty( $content['subsite'] ) ? (int) $content['subsite'] : '';
$icon        = ! empty( $content['icon'] ) ? $content['icon'] : '';
$links       = ! empty( $content['links'] ) ? $content['links'] : '';
$button_type = ! empty( $content['type'] ) ? $content['type'] : '';

$title    = '';
$site_url = '';
if ( ! empty( $subsite ) ) {
	$blog_details = get_blog_details( $subsite );
	$title        = ! empty( $blog_details->blogname ) ? $blog_details->blogname : '';
	$site_url     = ! empty( $blog_details->siteurl ) ? $blog_details->siteurl : '';
}
?>

<div class="cell">
	<article class="<?php echo $part_name; ?>">
		<header class="card-header">
			<?php
			if ( ! empty( $title ) ) {
				switch ( $has_title ) {
					case false:
						echo '<h1 class="card-title">' . $title . '</h1>';
						break;
					default:
						echo '<h2 class="card-title">' . $title . '</h2>';
						break;
				}
			}
			if ( ! empty( $icon ) ) {
				?>
				<div class="icon-wrapper">
					<?php
					echo strl_image(
						$icon,
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
		</header>
		<div class="content">
			<?php
			if ( ! empty( $site_url ) ) {
				switch_to_blog( $subsite );
				$color       = get_field( 'global-theme-colors_' . $button_type, 'option' );
				$text_color  = get_field( 'global-theme-colors_' . $button_type . '-contrast', 'option' );
				$hover_color = get_field( 'global-theme-colors_' . $button_type . '-button', 'option' );
				restore_current_blog();

				$button_array = array(
					'url'    => $site_url,
					'title'  => $title,
					'target' => '_blank',
				);

				echo strl_link(
					$button_array,
					array(
						'btn',
						'custom',
					),
					array(
						'bg-color'    => $color,
						'color'       => $text_color,
						'hover-color' => $hover_color,
					),
					'fa-solid fa-arrow-up-right-from-square',
					'right',
				);
			}
			?>
			<?php
			if ( ! empty( $links ) ) {
				?>
				<div class="links-wrapper">
					<ul class="links-list">
						<?php
						foreach ( $links as $link ) {
							$link_title  = ! empty( $link['link']['title'] ) ? $link['link']['title'] : '';
							$link_url    = ! empty( $link['link']['url'] ) ? $link['link']['url'] : '';
							$link_target = ! empty( $link['link']['target'] ) ? $link['link']['target'] : '_parent';
							?>
							<li>
								<a target="<?php echo $link_target; ?>" class="link-tag" href="<?php echo $link_url; ?>">
									<?php echo $link_title; ?>
									<span class="screen-reader-text">
										<?php
										if ( '_blank' === $link_target ) {
											echo sprintf(
												// translators: %s is the page title for quicklinks in header large.
												__( 'Go to page %s, link opens in new tab', 'strl' ),
												$link_title
											);
										} elseif ( '_blank' === $link_target && true === strl_is_url_external( $link_url ) ) {
											echo sprintf(
												// translators: %s is the page title for quicklinks in header large.
												__( 'Go to page %s, link opens in new tab and is external', 'strl' ),
												$link_title
											);
										} else {
											echo sprintf(
												// translators: %s is the page title for quicklinks in header large.
												__( 'Go to page %s', 'strl' ),
												$link_title
											);
										}
										?>
									</span>
								</a>
							</li>
							<?php
						}
						?>
					</ul>
				</div>
				<?php
			}
			?>
		</div>
	</article>
</div>
