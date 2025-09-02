<?php
$blockname = basename( __FILE__, '.php' );
$prefix    = $blockname . '-';
$title     = get_sub_field( $prefix . 'title' );
$images    = get_sub_field( $prefix . 'images' );
if ( empty( $images ) ) {
	return;
}
$imagescount = count( $images );
?>
<!-- <?php echo $blockname; ?> -->
<section class="<?php echo $blockname; ?>">
	<?php
	if ( $title ) {
		?>
		<div class="grid-x grid-margin-x">
			<div class="column large-12 medium-12 small-12">
				<h2><?php echo $title; ?></h2>
			</div>
		</div>
		<?php
	}
	?>
	<div class="grid-x grid-margin-x image-gallery">

			<?php
			foreach ( $images as $count => $image ) {
				$img    = $image['sizes']['strl-large'];
				$imgtag = $img ? 'style="background-image:url(' . $img . ')"' : '';
				$alt    = ! empty( $image['alt'] ) ? $image['alt'] : '';
				?>
				<div class="cell impression-item">
					<div class="image image-container-large" <?php echo $imgtag; ?>>
						<?php // Translators: %s is the alt text of the image. ?>
						<a href="<?php echo $img; ?>"><span class="screen-reader-text"><?php echo ! empty( $alt ) ? sprintf( __( 'View photo about %s', 'strl' ), $alt ) : __( 'View photo', 'strl' ); ?></span></a>
						<span class="maximize bg-primary">
							<i class="fa-light fa-arrows-up-down-left-right"></i>
						</span>
					</div>
				</div>
				<?php
			}
			?>

	</div>
	<div class="grid-x grid-margin-x">
		<div class="cell">
			<div class="slider-information">
				<div class="slides-numbers bg-primary" style="display: block;">
					<span class="active">1</span> / <span class="total"></span>
				</div>
				<div class="slider-pagination"></div>
			</div>
		</div>
	</div>
</section>
<!-- end:<?php echo $blockname; ?> -->
