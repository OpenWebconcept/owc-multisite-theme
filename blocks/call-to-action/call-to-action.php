<?php
$blockname = basename( __FILE__, '.php' );
$prefix    = $blockname . '-';

$text     = get_sub_field( $prefix . 'text' );
$centered = get_sub_field( $prefix . 'centered' );
$centered = ( $centered ? ' align-center' : '' );
?>
<!-- <?php echo $blockname; ?> -->
<section class="<?php echo $blockname; ?> bg-secondary">
	<div class="grid-x grid-margin-x <?php echo $centered; ?>">
		<div class="cell">
			<div class="text">
				<?php echo $text; ?>
			</div>
		</div>
	</div>
</section>
<!-- end:<?php echo $blockname; ?> -->
