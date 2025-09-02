<?php
$block_name = basename( __FILE__, '.php' );
$prefix     = $block_name . '-';

$tiles       = ! empty( get_sub_field( $prefix . 'tiles' ) ) ? get_sub_field( $prefix . 'tiles' ) : array();
$tiles_width = ! empty( get_sub_field( $prefix . 'tiles_width' ) ) ? get_sub_field( $prefix . 'tiles_width' ) : '25';
$tiles_count = count( $tiles );

switch ( $tiles_width ) {
	case '50':
		$column_size = 'medium-up-2 large-up-2';
		break;
	case '33':
		$column_size = 'medium-up-2 large-up-3';
		break;
	default:
		$column_size = 'medium-up-2 large-up-4';
		break;
}
?>
<!-- <?php echo $block_name; ?> -->
<section class="<?php echo $block_name; ?>">
	<div class="grid-x grid-margin-x grid-margin-y text-left <?php echo $column_size; ?>">
	<?php
	if ( ! empty( $tiles ) ) {
		foreach ( $tiles as $tile ) {
			get_template_part(
				'blocks/_global/tiles-card',
				null,
				array(
					'text'  => ! empty( $tile['text'] ) ? $tile['text'] : '',
					'link'  => ! empty( $tile['link'] ) ? $tile['link'] : '',
					'image' => ! empty( $tile['image'] ) ? $tile['image'] : '',
				),
			);
		}
	}
	?>
	</div>
</section>
<!-- end:<?php echo $block_name; ?> -->
