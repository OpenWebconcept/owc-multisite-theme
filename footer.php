<?php
$general      = get_field( 'settings-group' );
$show_widgets = get_field( 'strl-global-footer-toggle', 'option' );
$show_icon    = ! empty( get_field( 'strl-global-footer-icon_strl-global-footer-icon-toggle', 'option' ) ) ? get_field( 'strl-global-footer-icon_strl-global-footer-icon-toggle', 'option' ) : false;
$icon_text    = ! empty( get_field( 'strl-global-footer-icon_strl-global-footer-icon-text', 'option' ) ) ? get_field( 'strl-global-footer-icon_strl-global-footer-icon-text', 'option' ) : '';
?>
	</main>
	<footer>
		<?php
		if ( 'true' === $show_widgets ) {
			?>
				<div class="widgets">
					<div class="grid-x grid-margin-x">
						<div class="cell large-4">
							<?php dynamic_sidebar( 'footer-1' ); ?>
						</div>
						<div class="cell large-3 large-offset-1">
							<?php dynamic_sidebar( 'footer-2' ); ?>
						</div>
						<div class="cell large-3 large-offset-1">
							<?php dynamic_sidebar( 'footer-3' ); ?>
						</div>
						<!-- <div class="cell large-3">
							<?php dynamic_sidebar( 'footer-4' ); ?>
						</div> -->
					</div>
				</div>
			<?php
		}
		?>

		<div class="copyright">
			<div class="grid-x grid-margin-x">
				<div class="cell">
					<div class="copyright-wrap">
						<?php
						if ( true === $show_icon ) {
							?>
							<div class="logo-icon-wrapper">
								<img src="<?php echo IMAGEPATH . 'kroon-hertogenbosch.png'; ?>" alt="<?php _e( 'Crown icon \'s-HertogenBosch', 'strl' ); ?>">
								<?php
								if ( ! empty( $icon_text ) ) {
									?>
									<span class="icon-text"><?php echo $icon_text; ?></span>
									<?php
								}
								?>
							</div>
							<?php
						}
						?>
						<?php dynamic_sidebar( 'copyright' ); ?>
					</div>
				</div>
			</div>
		</div>
	</footer>

	<button class="scroll-to-top">
		<i class="fas fa-arrow-up"></i>
		<span class="screen-reader-text"><?php _e( 'Scroll to top', 'strl-frontend' ); ?></span>
	</button>

	<?php
	wp_footer();

	if ( strl_get_default_page_for( 'search' ) ) {
		?>
		<script type="application/ld+json">
		{
			"@context": "https://schema.org",
			"@type": "WebSite",
			"url": "<?php bloginfo( 'wpurl' ); ?>",
			"potentialAction": {
				"@type": "SearchAction",
				"target": "<?php echo get_permalink( strl_get_default_page_for( 'search' ) ); ?>?_search_search={search_term_string}",
				"query-input": "required name=search_term_string"
			}
		}
		</script>
		<?php
	}
	?>
</body>
</html>
