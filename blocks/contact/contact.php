<?php
$blockname   = basename( __FILE__, '.php' );
$prefix      = $blockname . '-';
$title       = ! empty( get_sub_field( $prefix . 'title' ) ) ? get_sub_field( $prefix . 'title' ) : get_field( 'strl-global-contact-title', 'option' );
$text        = get_field( 'strl-global-contact-content', 'option' );
$buttons     = get_field( 'strl-global-contact-buttons', 'option' );
$is_eng_lang = ! empty( get_field( 'article-is-english' ) ) ? get_field( 'article-is-english' )[0] : '';
?>
<!-- <?php echo $blockname; ?> -->
<section class="<?php echo $blockname; ?> has-background bg-quaternary large-spacing" <?php echo $is_eng_lang ? 'lang="nl"' : ''; ?>>
	<div class="grid-x grid-margin-x">
		<div class="cell">
			<div class="text">
				<h2><?php echo $title; ?></h2>
				<?php echo $text; ?>
			</div>
			<div class="btn-group">
				<?php
				if ( $buttons ) {
					echo '<ul>';
					foreach ( $buttons as $button ) {
						$icon = ! empty( wp_get_attachment_image_src( $button['strl-global-button-icon'], 'thumbnail' )[0] ) ? wp_get_attachment_image_src( $button['strl-global-button-icon'], 'thumbnail' )[0] : '';
						$link = $button['strl-global-button-link'];
						if ( $link ) {
							$link_url    = ! empty( $link['url'] ) ? $link['url'] : '';
							$link_title  = ! empty( $link['title'] ) ? $link['title'] : '';
							$link_target = $link['target'] ? $link['target'] : '_self';
							?>
							<li>
								<a class="btn quaternary contrast <?php echo strpos( $link_title, 'afspraak' ) !== false ? 'appointment' : ''; ?>" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>">
									<?php
									if ( ! empty( $icon ) ) {
										?>
										<span class="icon" style="background-image: url('<?php echo $icon; ?>');"></span>
										<?php
									}
									?>
									<?php echo esc_html( $link_title ); ?>
								</a>
							</li>
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
