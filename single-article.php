<?php
get_header();

$post_id           = get_the_ID();
$title             = get_the_title();
$pub_date          = get_the_date( 'd-m-Y', $post_id );
$article_content   = ! empty( get_field( 'article-content', $post_id ) ) ? apply_filters( 'the_content', get_field( 'article-content', $post_id ) ) : '';
$article_downloads = get_field( 'article-downloads', $post_id );
$article_links     = get_field( 'article-links', $post_id );
$header_image      = get_field( 'article-image', $post_id );

$modified_date = get_the_modified_date( 'd-m-Y H:i:s' );

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

		get_template_part(
			'blocks/_global/single-header-image',
			'',
			array(
				'header_image' => $header_image,
			),
		);
		?>

		<section class="single-article-content">
			<div class="grid-x grid-margin-x">
				<div class="cell large-8">
					<div class="article-intro">
						<?php
						echo strl_add_read_speaker();
						if ( ! empty( $title ) ) {
							?>
							<h1><?php echo $title; ?></h1>
							<?php
						}
						if ( ! empty( $pub_date ) ) {
							?>
							<span class="created pub-date">
								<?php
								echo sprintf(
									// translators: %s is publish date
									__( 'Created on: %s', 'strl-frontend' ),
									$pub_date
								);
								?>
							</span>
							<br>
							<?php
						}
						if ( ! empty( $modified_date ) ) {
							?>
							<span class="modified pub-date">
								<?php
								echo sprintf(
									// translators: %s is last modifed date
									__( 'Last modified on: %s', 'strl-frontend' ),
									$modified_date
								);
								?>
							</span>
							<?php
						}
						?>
					</div>
				</div>
				<div class="cell large-3 large-offset-1 large-order-2 small-order-1 sidebar">
					<?php
					if ( $article_links ) {
						?>
						<div class="widget">
							<div class="bg-quaternary">
								<p class="widget-title"><?php _e( 'Links', 'strl-frontend' ); ?></p>
							</div>
							<div class="widget-content">
								<ul>
									<?php
									foreach ( $article_links as $link ) {
										?>
										<li>
											<?php
											echo strl_link(
												$link['link'],
												array(),
												array(),
												'fa-regular fa-arrow-up-right-from-square',
											);
											?>
										</li>
										<?php
									}
									?>
								</ul>
							</div>
						</div>
						<?php
					}
					?>
				</div>
			</div>
			<div class="grid-x grid-margin-x grid-margin-y">
				<div class="cell large-8 large-order-1 small-order-2">
					<div class="article-inner">
						<?php
						if ( ! empty( $article_content ) ) {
							get_template_part(
								'blocks/textonly/textonly',
								'',
								array(
									'content' => $article_content,
								),
							);
						}
						?>
					</div>
				</div>
			</div>
		</section>

		<?php
		if ( ! empty( $article_downloads ) ) {
			?>
			<section class="downloads">
				<div class="grid-x grid-margin-x">
					<div class="cell large-8 small-12">
						<h2><?php _e( 'Downloads', 'strl' ); ?></h2>
						<ul class="downloads-list">
							<?php
							foreach ( $article_downloads as $download ) {
								$download = $download['download'];

								if ( ! empty( $download ) ) {
									get_template_part(
										'blocks/_global/download-link',
										'',
										array(
											'link_url'   => $download['url'],
											'link_title' => $download['title'],
											'link_type'  => 'download',
										),
									);
								}
							}
							?>
						</ul>
					</div>
				</div>
			</section>
			<?php
		}
		?>
		<?php
	}
}

get_footer();
