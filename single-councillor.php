<?php
$post_id         = get_the_ID();
$image           = ! empty( get_field( 'settings-group_post-featured-image', $post_id ) ) ? get_field( 'settings-group_post-featured-image', $post_id ) : '';
$title           = get_the_title();
$function_title  = get_field( 'counsillor-function-title' );
$phone           = get_field( 'counsillor-phone' );
$functions_title = get_field( 'counsillor-functions-title' );
$functions       = get_field( 'councillor-functions' );
$email           = get_field( 'counsillor-email' );
$twitter         = get_field( 'counsillor-twitter' );
$linkedin        = get_field( 'counsillor-linkedin' );
$facebook        = get_field( 'counsillor-facebook' );
$instagram       = get_field( 'counsillor-instagram' );
$desc            = get_field( 'counsillor-description' );

get_header();

if ( post_password_required() ) {
	?>
	<div class="grid-container">
		<div class="grid-x grid-margin-x">
			<div class="cell medium-8">
				<?php echo get_the_password_form( $post->ID ); ?>
			</div>
		</div>
	</div>
	<?php
} else {
	while ( have_posts() ) {
		the_post();
		if ( class_exists( 'acf' ) ) {
			?>
			<section class="single-councillor-content">
				<div class="grid-x grid-margin-x">
					<div class="cell medium-9">
						<div class="councillor-inner bg-white">
							<?php
							if ( ! empty( $image['sizes'] ) ) {
								?>
								<div class="imagewrap">
									<img alt="<?php echo $image['title']; ?>" class="image" src="<?php echo $image['sizes']['strl-medium']; ?>" data-src="<?php echo $image['sizes']['strl-small']; ?>" data-srcset="<?php echo $image['sizes']['strl-small']; ?>, <?php echo $image['sizes']['strl-medium']; ?>" data-sizes="xs, s">
								</div>
								<?php
							}
							?>
							<div class="content">
								<?php echo strl_add_read_speaker(); ?>
								<h1 class="h2"><?php echo $title; ?></h1>
								<?php
								if ( ! empty( $function_title ) ) {
									?>
									<span class="function-title"><?php echo $function_title; ?></span>
									<?php
								}

								if ( ! empty( $phone ) ) {
									?>
									<span class="phone">
										<a href="tel:<?php echo $phone; ?>">
											<i class="fa-solid fa-phone"></i>
											<?php echo $phone; ?>
										</a>
									</span>
									<?php
								}
								if ( $functions ) {
									if ( $functions_title ) {
										?>
										<span class="functions-title"><?php echo $functions_title; ?></span>
										<?php
									} else {
										?>
										<span class="functions-title"><?php _e( 'Ancillary functions', 'strl-frontend' ); ?></span>
										<?php
									}
									echo '<ul>';
									foreach ( $functions as $function ) {
										$text = ! empty( $function['councillor-function'] ) ? $function['councillor-function'] : '';
										if ( $function ) {
											?>
												<li><?php echo $text; ?></li>
											<?php
										}
									}
									echo '</ul>';
								}

								if ( ! empty( $desc ) ) {
									echo apply_filters( 'the_content', $desc );
								}
								?>
								<ul class="button-group">
									<?php
									if ( ! empty( $email ) ) {
										?>
										<li><a class="btn quaternary contrast" href="<?php echo esc_url( $email ); ?>"><i class="fa-solid fa-envelope"></i><?php _e( 'Send an email', 'strl-frontend' ); ?></a></li>
										<?php
									}

									if ( ! empty( $twitter ) ) {
										?>
										<li><a class="btn quaternary contrast" href="<?php echo esc_url( $twitter ); ?>"><i class="fa-brands fa-x-twitter"></i><?php _e( 'Twitter', 'strl' ); ?></a></li>
										<?php
									}

									if ( ! empty( $linkedin ) ) {
										?>
										<li><a class="btn quaternary contrast" href="<?php echo esc_url( $linkedin ); ?>"><i class="fa-brands fa-linkedin-in"></i><?php _e( 'LinkedIn', 'strl' ); ?></a></li>
										<?php
									}

									if ( ! empty( $facebook ) ) {
										?>
										<li><a class="btn quaternary contrast" href="<?php echo esc_url( $facebook ); ?>"><i class="fa-brands fa-facebook-f"></i><?php _e( 'Facebook', 'strl' ); ?></a></li>
										<?php
									}

									if ( ! empty( $instagram ) ) {
										?>
										<li><a class="btn quaternary contrast" href="<?php echo esc_url( $instagram ); ?>"><i class="fa-brands fa-instagram"></i><?php _e( 'Instagram', 'strl' ); ?></a></li>
										<?php
									}
									?>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</section>

			<?php
			// Additional blocks
			if ( class_exists( 'acf' ) ) {
				if ( have_rows( 'blocks' ) ) {
					while ( have_rows( 'blocks' ) ) {
						the_row();
						get_template_part( 'blocks/' . get_row_layout() . '/' . get_row_layout() );
					}
				}
			}
		}
	}
}

get_footer();
