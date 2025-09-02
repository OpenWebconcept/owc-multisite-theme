<?php
$post_id        = ! empty( $args['post_id'] ) ? $args['post_id'] : get_the_ID();
$title          = get_the_title();
$excerpt        = get_field( 'settings-group_post-excerpt-content' );
$published_date = get_the_date( 'd-m-Y' );
$link           = get_permalink();
$has_single     = get_field( 'publication-single', $post_id );
$download       = get_field( 'download-singular', $post_id );
$external_url   = get_field( 'download-external-url', $post_id );
?>
<div class="cell">
	<article class="<?php echo basename( __FILE__, '.php' ); ?> bg-white">
		<header class="card-header">
			<?php
			if ( ! empty( $title ) ) {
				?>
				<h3><?php echo $title; ?></h3>
				<?php
			}
			if ( ! empty( $published_date ) ) {
				?>
				<span class="publish-date">
					<?php
					echo sprintf(
						// translators: %s is the publication date
						__( 'Published on: %s', 'strl-frontend' ),
						wp_date( 'd-m-Y', strtotime( $published_date ) )
					);
					?>
				</span>
				<?php
			}
			?>
		</header>
		<div class="card-inner">
			<div class="content">
				<?php
				if ( ! empty( $excerpt ) ) {
					?>
					<p><?php echo strl_excerpt( $excerpt, 208 ); ?></p>
					<?php
				}
				?>
			</div>
			<?php

			if ( ! empty( $link ) || ! empty( $download ) ) {
				switch ( $has_single ) {
					case false:
						$download_url = ! empty( $download['url'] ) ? $download['url'] : '';
						if ( ! empty( $download_url ) ) {
							?>
							<div class="btn primary">
								<?php _e( 'Download', 'strl' ); ?>
								<i class="fa-regular fa-arrow-down-to-line"></i>
							</div>
							<?php
						} else {
							?>
							<div class="btn primary">
								<?php _e( 'Read more', 'strl' ); ?>
								<i class="fa-solid fa-chevron-right"></i>
							</div>
							<?php
						}
						?>
						<?php
						break;
					default:
						?>
						<a class="btn primary">
							<?php _e( 'Read more', 'strl' ); ?>
							<i class="fa-solid fa-chevron-right"></i>
						</a>
						<?php
						break;
				}
			}
			?>
		</div>
		<?php
		if ( ! empty( $link ) || ! empty( $download ) || ! empty( $external_url ) ) {
			switch ( $has_single ) {
				case false:
					$download_url = ! empty( $download['url'] ) ? $download['url'] : '';
					// translators: %s is the title of the download
					$srt = sprintf( __( 'Download file: %s', 'strl-frontend' ), $title );
					if ( ! empty( $download_url ) ) {
						?>
						<a class="overlay-link" href="<?php echo $download_url; ?>" download>
							<span class="screen-reader-text">
								<?php echo $srt; ?>
							</span>
						</a>
						<?php
					} else {
						?>
						<a class="overlay-link" href="<?php echo $external_url; ?>">
							<span class="screen-reader-text">
								<?php
								echo // translators: %s is the external url
								sprintf( __( 'This is an external link to: %s', 'strl-frontend' ), $external_url );
								?>
							</span>
						</a>
						<?php
					}
					?>

					<?php
					break;
				default:
					// translators: %s is the title of the publication
					$srt = sprintf( __( 'Read more about %s', 'strl-frontend' ), $title );
					?>
					<a class="overlay-link" href="<?php echo $link; ?>">
						<span class="screen-reader-text">
							<?php echo $srt; ?>
						</span>
					</a>
					<?php
					break;
			}
		}
		?>
	</article>
</div>
