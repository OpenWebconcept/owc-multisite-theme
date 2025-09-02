<?php
get_header();

if ( post_password_required() ) {
	?>
	<div class="grid-container">
		<div class="grid-x grid-x-margin">
			<div class="cell medium-8">
				<?php echo get_the_password_form( $post->ID ); ?>
			</div>
		</div>
	</div>
	<?php
} else {
	while ( have_posts() ) {
		the_post();
		if ( class_exists( 'acf' ) ) {
			if ( have_rows( 'blocks' ) ) {
				while ( have_rows( 'blocks' ) ) {
					the_row();
					get_template_part( 'blocks/' . get_row_layout() . '/' . get_row_layout() );
				}
			}
		}
	}
}

get_footer();
