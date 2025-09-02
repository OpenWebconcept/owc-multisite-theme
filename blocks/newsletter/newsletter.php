<?php
$blockname = basename( __FILE__, '.php' );
$prefix    = $blockname . '-';
$post_id   = get_the_ID();

if ( get_field( 'settings-group_cpt-footer-cta', $post_id ) ) {
	$choice = get_field( 'settings-group_cpt-footer-cta', $post_id );
} elseif ( $args['type'] ) {
	$choice = $args['type'];
} else {
	$choice = '1';
}

if ( 'false' === $choice ) {
	return;
}

$content = get_field( 'strl-global-cta-content-' . $choice, 'option' );
$link    = get_field( 'strl-global-cta-content-button-' . $choice, 'option' );
?>
<!-- <?php echo $blockname; ?> -->
<section class="<?php echo $blockname; ?> bg-tertiary">
	<div class="grid-x grid-margin-x">
		<div class="cell">
			<div class="text">
				<?php
				echo '<p>' . $content . '</p>';
				if ( $link ) {
					$link_url    = $link['url'];
					$link_title  = $link['title'];
					$link_target = $link['target'] ? $link['target'] : '_self';
					?>
					<a class="btn tertiary contrast icon" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
					<?php
				}
				?>
			</div>
		</div>
	</div>
</section>
<!-- end:<?php echo $blockname; ?> -->
