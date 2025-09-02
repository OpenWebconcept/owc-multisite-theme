<?php
$post_id  = ! empty( $args['post_id'] ) ? $args['post_id'] : get_the_ID();
$name     = get_the_title( $post_id );
$function = get_field( 'counsillor-function-title', $post_id );
$phone    = get_field( 'counsillor-phone', $post_id );
$email    = get_field( 'counsillor-email', $post_id );
$image    = get_field( 'settings-group_post-featured-image', $post_id );
?>
<article class="<?php echo basename( __FILE__, '.php' ); ?>">
	<div class="title-wrapper">
		<h3><?php _e( 'For more information', 'strl' ); ?></h3>
	</div>
	<div class="card-inner">
		<div class="content-wrapper">
			<?php
			if ( ! empty( $name ) || ! empty( $function ) ) {
				?>
				<div class="contact-info">
					<?php
					if ( ! empty( $name ) ) {
						?>
						<h4><?php echo $name; ?></h4>
						<?php
					}
					if ( ! empty( $function ) ) {
						?>
						<p><?php echo $function; ?></p>
						<?php
					}
					?>
				</div>
				<?php
			}

			if ( ! empty( $email ) || ! empty( $phone ) ) {
				?>
				<div class="contact-details">
					<?php
					if ( ! empty( $email ) ) {
						?>
						<a href="mailto:<?php echo $email; ?>">
							<?php echo $email; ?>
							<span class="screen-reader-text">
								<?php
								echo sprintf(
								// translators: %s: name of the person
									__( 'Email %s', 'strl' ),
									$name,
								);
								?>
							</span>
						</a>
						<?php
					}
					if ( ! empty( $phone ) ) {
						?>
						<a href="tel:<?php echo strl_sanitize_phone_number( $phone ); ?>">
							<?php echo $phone; ?>
							<span class="screen-reader-text">
								<?php
								echo sprintf(
								// translators: %s: name of the person
									__( 'Call %s', 'strl' ),
									$name,
								);
								?>
							</span>
						</a>
						<?php
					}
					?>
				</div>
				<?php
			}
			if ( ! empty( $image ) ) {
				?>
				<header class="card-header">
					<?php
					echo strl_image(
						$image
					);
					?>
				</header>
				<?php
			}
			?>
		</div>
	</div>
</article>
