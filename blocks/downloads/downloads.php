<?php
$blockname = basename( __FILE__, '.php' );
$prefix    = $blockname . '-';
$downloads = get_sub_field( $prefix . 'items' );
$title     = get_sub_field( $prefix . 'title' );
$text      = get_sub_field( $prefix . 'text' );
if ( empty( $downloads ) ) {
	return;
}
?>
<!-- <?php echo $blockname; ?> -->
<section class="<?php echo $blockname; ?>">
	<div class="grid-x grid-margin-x">
		<div class="cell large-12">
			<?php
			if ( ! empty( $downloads ) ) {
				?>
				<ul class="downloads-list">
					<?php
					foreach ( $downloads as $download ) {
						get_template_part(
							'blocks/_global/download-link',
							'',
							array(
								'link_url'   => $download['link']['url'],
								'link_title' => $download['title'],
								'link_type'  => $download['downloads-type'],
							),
						);
					}
					?>
				</ul>
				<?php
			}
			?>
		</div>
	</div>
</section>
<!-- end:<?php echo $blockname; ?> -->
