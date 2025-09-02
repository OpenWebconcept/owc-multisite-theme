<?php
$post_id          = get_the_ID();
$content          = get_field( 'publication-content', $post_id );
$publication_date = get_field( 'publication-date', $post_id );
$primary_cat      = strl_get_primary_category( $post_id, 'publication_category' );
$downloads        = get_field( 'publication-downloads', $post_id );
$header_content   = array(
	'title'          => ! empty( get_the_title( $post_id ) ) ? get_the_title( $post_id ) : '',
	'intro'          => ! empty( get_field( 'publication-intro', $post_id ) ) ? get_field( 'publication-intro', $post_id ) : '',
	'featured-image' => ! empty( get_field( 'settings-group_post-featured-image', $post_id ) ) ? get_field( 'settings-group_post-featured-image', $post_id ) : '',
);
$header_content   = array_filter( $header_content, fn ( $value) => ! empty( $value ) );
$contact_person   = ! empty( get_field( 'publication-contact-person', $post_id )[0] ) ? get_field( 'publication-contact-person', $post_id )[0] : '';

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
	if ( ! empty( $header_content ) ) {
		get_template_part(
			'blocks/header-image/header-image',
			null,
			$header_content
		);
	}
	?>
	<section class="single-publication-content">
		<div class="grid-container">
			<div class="grid-x grid-margin-x">
				<div class="cell large-8">
					<div class="publication-meta">
						<div class="categories-wrapper">
							<?php
							if ( ! empty( $primary_cat ) ) {
								$cat_name = ! empty( $primary_cat->name ) ? $primary_cat->name : '';
								if ( ! empty( $cat_name ) ) {
									?>
									<span class="category bg-tertiary">
										<?php echo $cat_name; ?>
									</span>
									<?php
								}
							}
							?>
						</div>
						<?php
						if ( ! empty( $publication_date ) ) {
							?>
							<span class="date">
								<?php
								echo sprintf(
									// translators: %s is the publication date
									__( 'Published on: %s', 'strl-frontend' ),
									wp_date( 'd-m-Y', strtotime( $publication_date ) )
								);
								?>
							</span>
							<?php
						}
						?>
					</div>
				</div>
			</div>
		</div>
		<?php
		if ( ! empty( $content ) ) {
			?>
			<div class="grid-container single-content-container">
				<div class="grid-x grid-margin-x grid-margin-y">
					<div class="cell small-12 large-8">
						<div class="text">
							<?php echo apply_filters( 'the_content', $content ); ?>
						</div>
					</div>
					<?php
					if ( ! empty( $contact_person ) ) {
						?>
						<div class="cell small-12 large-4">
							<?php
							get_template_part(
								'blocks/_global/contact-card',
								null,
								array(
									'post_id' => $contact_person,
								),
							);
							?>
						</div>
						<?php
					}
					?>
				</div>
			</div>
			<?php
		}
		if ( ! empty( $downloads ) ) {
			?>
			<div class="grid-container single-downloads-container">
				<div class="grid-x grid-margin-x">
					<div class="cell">
						<h2><?php _e( 'Downloads', 'strl' ); ?></h2>
					</div>
					<div class="cell">
						<div class="downloads-wrapper">
							<?php
							foreach ( $downloads as $download ) {
								$label        = ! empty( $download['label'] ) ? $download['label'] : __( 'Download document', 'strl' );
								$download_url = ! empty( $download['download']['url'] ) ? $download['download']['url'] : '';
								$file_name    = ! empty( $download['download']['filename'] ) ? $download['download']['filename'] : '';
								?>
								<a class="btn primary" href="<?php echo $download_url; ?>" download>
									<?php echo $label; ?>
									<i aria-hidden="true" class="fa-solid fa-arrow-down-to-line"></i>
									<span class="screen-reader-text">
										<?php
										// translators: %s is the filename of the download
										echo printf( __( 'Download file: %s', 'strl' ), $file_name );
										?>
									</span>
								</a>
								<?php
							}
							?>
						</div>
					</div>
				</div>
			</div>
			<?php
		}
		?>
	</section>
	<?php
}
get_footer();
