<?php
$header_image = ! empty( $args['header_image'] ) ? $args['header_image'] : '';

if ( ! empty( $header_image ) ) {
	?>
	<section class="article-header-image">
		<?php
		echo strl_image(
			$header_image,
			$desktop_size = 'strl-large',
			$mobile_size  = 'strl-medium',
			$classes      = 'object-cover size-full',
		);
		?>
	</section>
	<?php
}