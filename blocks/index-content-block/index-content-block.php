<?php
$blockname = basename( __FILE__, '.php' );
$prefix    = $blockname . '-';

$text              = get_sub_field( $prefix . 'text' );
$news_archive      = strl_get_default_page_for( 'article' );
$complaintform_url = ! empty( get_field( 'strl-global-complaintform-url', 'option' ) ) ? get_field( 'strl-global-complaintform-url', 'option' ) : '';
?>
<!-- <?php echo $blockname; ?> -->
<section class="<?php echo $blockname; ?>">
	<div class="grid-container">
		<div class="grid-x grid-margin-x">
			<div class="cell large-3 submenu">
			<?php
			// Get the current page ID
			$current_page_id = get_the_ID();
			// Check if the current page has child pages
			$child_pages = get_pages( array( 'child_of' => $current_page_id ) );
			if ( ! empty( $child_pages ) ) {
				// If we're on a parent page, display its child pages
				$args            = array(
					'child_of' => $current_page_id,
					'title_li' => '',
					'depth'    => 1, // Limit to direct child pages only
					'echo'     => 0, // Return the output instead of echoing it
				);
				$child_page_list = wp_list_pages( $args );

				if ( $child_page_list ) {
					echo '<ul>' . $child_page_list . '</ul>';
				}
			} else {
				// If we're on a child page, display the parent page's child pages
				$parent_page_id = wp_get_post_parent_id( $current_page_id );
				if ( $parent_page_id ) {
					$args            = array(
						'child_of' => $parent_page_id,
						'title_li' => '',
						'depth'    => 1, // Limit to direct child pages only
						'echo'     => 0, // Return the output instead of echoing it
					);
					$child_page_list = wp_list_pages( $args );

					if ( $child_page_list ) {
						echo '<ul>' . $child_page_list . '</ul>';
					}
				}
			}
			?>
			</div>
			<div class="cell large-6">
				<div class="text">
					<?php echo apply_filters( 'the_content', $text ); ?>
				</div>
			</div>
			<div class="cell large-3">
				<div class="button-group">
					<?php
					if ( ! empty( $complaintform_url ) ) {
						?>
						<a class="btn icon primary" target="_blank" href="<?php echo $complaintform_url; ?>"><?php _e( 'Complaintform', 'strl' ); ?></a>
						<?php
					}
					if ( ! empty( $news_archive ) ) {
						?>
						<a class="btn icon quaternary" href="<?php echo get_permalink( $news_archive ); ?>"><?php _e( 'News', 'strl' ); ?></a>
						<?php
					}
					?>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- end: <?php echo $blockname; ?> -->
