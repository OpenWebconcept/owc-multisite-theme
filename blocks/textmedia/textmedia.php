<?php
$blockname = basename( __FILE__, '.php' );
$prefix    = $blockname . '-';

$text          = apply_filters( 'the_content', get_sub_field( $prefix . 'text' ) );
$type          = get_sub_field( $prefix . 'type' );
$video         = get_sub_field( $prefix . 'video' );
$videotype     = ( 11 === strlen( $video ) && ! is_numeric( $video ) ) ? 'youtube' : 'vimeo';
$imageid       = get_post( get_sub_field( $prefix . 'image' ) );                                                                                           // Get post by ID
$image         = ! empty( get_sub_field( $prefix . 'image' ) ) ? wp_get_attachment_image_src( get_sub_field( $prefix . 'image' ), 'strl-large' )[0] : '';
$imagefirst    = get_sub_field( $prefix . 'imagefirst' );
$textalignment = get_sub_field( $prefix . 'textaligntop' );

if ( 'youtube' === $videotype ) {
	$video_attr = 'class="play-button popup-youtube" href="https://www.youtube-nocookie.com/embed/' . $video . '?disablekb=1"';
} else {
	$video_attr = 'class="play-button popup-vimeo" href="https://www.vimeo.com/' . $video . '"';
}

switch ( $imagefirst ) {
	case 'rightside':
		$media_column = 'medium-6 large-order-2 small-order-1';
		$text_column  = 'medium-6 large-order-1 small-order-2';
		break;
	default:
		$media_column = 'medium-6 large-order-1 medium-order-1 small-order-1';
		$text_column  = 'medium-6 large-order-2 medium-order-2 small-order-2';
		break;
}

?>
<!-- <?php echo $blockname; ?> -->
<section class="<?php echo $blockname; ?>">
	<div class="grid-x grid-margin-x <?php echo $blockname; ?>-section<?php echo ( 'topside' !== $textalignment ? ' center-vertically' : '' ); ?>">
		<div class="cell <?php echo $text_column; ?>">
			<div class="text-column<?php echo ( 'leftside' === $imagefirst ? ' imagefirst' : '' ); ?>">
				<?php echo $text; ?>
			</div>
		</div>
		<div class="cell <?php echo $media_column; ?>">
			<div class="media-column<?php echo ( 'leftside' === $imagefirst ? ' imagefirst' : '' ); ?>">
			<?php
			if ( 'image' === $type ) {
				?>
				<div class="image-background" style="background-image: url('<?php echo $image; ?>')"></div>
				<span class="imagedesc"><?php echo $imageid->post_content; // Display Description; ?></span>
				<?php
			} elseif ( 'video' === $type ) {
				?>
				<div class="video-wrapper<?php echo ( 'vimeo' === $videotype ? ' vimeo' : ' youtube' ); ?>">
					<div class="image-background video-thumbnail" style="background-image: url(<?php echo $image; ?>)">
						<a <?php echo $video_attr; ?>>
							<i class="fa-duotone fa-play"></i>
							<span class="screen-reader-text"><?php _e( 'Play video', 'strl-frontend' ); ?></span>
						</a>
					</div>
				</div>
				<?php
			}
			?>
			</div>
		</div>
	</div>
</section>
<!-- <?php echo 'end:' . $blockname; ?> -->
