<?php
$link_url   = ! empty( $args['link_url'] ) ? $args['link_url'] : '';
$link_title = ! empty( $args['link_title'] ) ? $args['link_title'] : '';
$link_type  = ! empty( $args['link_type'] ) ? $args['link_type'] : '';

if ( ! empty( $link_url ) ) {
	?>
	<li class="download">
		<div class="inner">
			<?php
			if ( ! empty( $link_title ) ) {
				?>
				<span class="strong">
					<?php
					echo $link_title;

					if ( 'download' === $link_type ) {
						$download_type = explode( '.', $link_url );
						$file_type     = is_array( $download_type ) ? end( $download_type ) : '';

						if ( ! empty( $file_type ) ) {
							?>
							<span><?php echo $file_type; ?></span>
							<?php
						}
					}
					?>
				</span>
				<?php
			}
			?>
			<i class="fa-regular <?php echo 'download' === $link_type ? 'fa-arrow-down-to-line' : 'fa-arrow-up-right-from-square'; ?>" aria-hidden="true"></i>
			<a href="<?php echo $link_url; ?>" class="overlay-link">
				<?php
				if ( 'download' === $link_type ) {
					?>
					<span class="screen-reader-text"><?php echo sprintf( __( 'Download: %s', 'strl-frontend' ), $link_title ); ?></span>
					<?php
				} else {
					?>
					<span class="screen-reader-text"><?php echo sprintf( __( 'Read more about %s', 'strl-frontend' ), $link_title ); ?></span>
					<?php
				}
				?>
			</a>
		</div>
	</li>
	<?php
}
?>
