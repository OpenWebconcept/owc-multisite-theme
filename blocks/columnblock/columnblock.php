<?php
$blockname = basename( __FILE__, '.php' );
$prefix    = $blockname . '-';
$columns   = get_sub_field( $prefix . 'columns' );
if ( ! $columns ) {
	return;
}
?>
<!-- <?php echo $blockname; ?> -->
<section class="<?php echo $blockname; ?>">
	<div class="grid-x grid-margin-x large-up-<?php echo count( (array)$columns ); ?> small-up-1">
		<?php
		foreach ( $columns as $column ) {
			$text = ! empty( $column['columns-text'] ) ? apply_filters( 'the_content', $column['columns-text'] ) : '';
			if ( $text  ) {
				?>
				<div class="cell">
					<div class="text">
						<?php echo $text; ?>
					</div>
				</div>
				<?php
			}
		}
		?>
	</div>
</section>
<!-- end:<?php echo $blockname; ?> -->
