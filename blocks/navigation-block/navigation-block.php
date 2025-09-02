<?php
$blockname = basename( __FILE__, '.php' );
$prefix    = $blockname . '-';
$blocks    = get_sub_field( $prefix . 'blocks' );

if ( empty( $blocks ) ) {
	return;
}

$background_image = get_sub_field( $prefix . 'background-image' );
$title            = get_sub_field( $prefix . 'title' );

if ( empty( $background_image ) ) {
	$background_image = get_field( 'strl-global-fallback-image', 'option' );
}
?>
<!-- <?php echo $blockname; ?> -->
<section class="<?php echo $blockname; ?> has-background-wrapper">
	<?php
	if ( ! empty( $background_image ) ) {
		?>
		<div class="background-wrapper">
			<?php
			echo strl_image(
				$background_image,
				'strl-large',
				'strl-medium',
				'',
				array(),
				false,
			);
			?>
		</div>
		<?php
	}
	?>
	<div class="grid-container container-large">
		<?php
		if ( ! empty( $title ) ) {
			?>
			<div class="grid-x">
				<div class="cell small-12 medium-8 medium-offset-2 large-6 large-offset-3">
					<h2 class="h1 text-center"><?php echo $title; ?></h2>
				</div>
			</div>
			<?php
		}
		?>

		<div class="grid-x grid-margin-x grid-margin-y small-up-1 medium-up-2 large-up-4 justify-center">
			<?php
			foreach ( $blocks as $block ) {
				echo get_template_part(
					'blocks/_global/subsite-card',
					null,
					array(
						'content'   => $block,
						'has-title' => ! empty( $title ) ? true : false,
					),
				);
			}
			?>
		</div>
	</div>
</section>
<!-- end:<?php echo $blockname; ?> -->
