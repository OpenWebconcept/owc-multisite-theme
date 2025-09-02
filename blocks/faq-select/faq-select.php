<?php
$rowlayout = basename( __FILE__, '.php' );
$prefix    = $rowlayout . '-';

$title = get_sub_field( $prefix . 'title' );
$intro = get_sub_field( $prefix . 'text' );
$items = get_sub_field( $prefix . 'items' );
?>
<!-- <?php echo $prefix; ?> -->
<section class="<?php echo $rowlayout; ?>" id="blockindex_<?php echo get_row_index(); ?>">
	<?php
	if ( ! empty( $title ) || ! empty( $intro ) ) {
		?>
		<div class="grid-x grid-margin-x">
			<div class="cell large-8">
				<?php
				echo ! empty( $title ) ? '<h2>' . $title . '</h2>' : '';
				echo ! empty( $intro ) ? '<div class="text">' . $intro . '</div>' : '';
				?>
			</div>
		</div>
		<?php
	}
	?>
	<div class="grid-x grid-padding-x">
		<div class="cell large-8">
			<div class="inner">
				<?php
				foreach ( $items as $post ) {
					setup_postdata( $post );
					$question = get_the_title();
					$answer   = get_field( 'faq-text' );
					if ( ! empty( $question ) && 'publish' === $post->post_status ) {
						?>
						<details aria-expanded="false">
							<summary class="bg-tertiary">
								<?php
								// ! this title is the main title if its empty than accordion title is H2
								if ( ! empty( $title ) ) {
									?>
									<h3 class="h6"><?php echo $question; ?></h3>
									<?php
								} else {
									?>
									<h2 class="h6"><?php echo $question; ?></h2>
									<?php
								}
								?>
								<i class="fa-solid fa-chevron-down"></i>
							</summary>
							<div class="bg-white">
								<?php
								echo $answer;
								?>
							</div>
						</details>
						<?php $answer_strip = str_replace( '"', "'", $answer ); ?>
						<script type="application/ld+json">
						{
							"@context": "https://schema.org",
							"@type": "Question",
							"name": "<?php echo $question; ?>",
							"acceptedAnswer": {
								"@type": "Answer",
								"text": "<?php echo $answer_strip; ?>"
							}
						}
						</script>
						<?php
					}
				}
				wp_reset_postdata();
				?>
			</div>
		</div>
	</div>
</section>
<!-- end:<?php echo $prefix; ?> -->
