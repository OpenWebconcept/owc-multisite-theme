<?php
$blockname = basename( __FILE__, '.php' );
$prefix    = $blockname . '-';
$title     = get_sub_field( $prefix . 'title' );
$image_id  = get_sub_field( $prefix . 'image' ) ? get_sub_field( $prefix . 'image' ) : false;
$image     = ! empty( $image_id ) ? wp_get_attachment_image_src( $image_id, 'strl-large' )[0] : '';
// get image alt
$image_alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
?>
<!-- <?php echo $blockname; ?> -->
<section class="<?php echo $blockname; ?> has-background">
	<div class="grid-x grid-margin-x">
		<div class="cell">
			<div class="image-background">
				<img class="image" alt="<?php echo$image_alt; ?>" src="<?php echo $image; ?>"/>
				<?php
				if ( ! empty( $title ) ) {
					?>
					<h1><?php echo $title; ?></h1>
					<?php
				}
				?>
			</div>
		</div>
	</div>
	<?php get_template_part( 'blocks/_global/readspeaker-partial' ); ?>
</section>
<!-- end:<?php echo $blockname; ?> -->
