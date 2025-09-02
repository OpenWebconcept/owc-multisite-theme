<?php
$blockname = basename( __FILE__, '.php' );
$prefix    = $blockname . '-';
$text      = ! empty( $args['content'] ) ? $args['content'] : get_sub_field( $prefix . 'text' );
$centered  = get_sub_field( $prefix . 'centered' );
$centered  = ( $centered ? ' align-center' : '' );

if ( empty( $text ) ) {
	return;
}
?>
<!-- <?php echo $blockname; ?> -->
<section class="<?php echo $blockname; ?>">
	<div class="grid-x grid-margin-x <?php echo $centered; ?>">
		<div class="cell">
			<div class="text">
				<?php echo apply_filters( 'the_content', $text ); ?>
			</div>
		</div>
	</div>
</section>
<!-- end:<?php echo $blockname; ?> -->
