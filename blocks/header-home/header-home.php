<?php

$blockname   = basename( __FILE__, '.php' );
$prefix      = $blockname . '-';

$title       = get_sub_field( $prefix . 'title' );
$breadcrumbs = get_field( 'settings-group_breadcrumbs' );
$searchterms = get_sub_field( $prefix . 'searchterms' );
?>
<!-- <?php echo $blockname; ?> -->
<section class="<?php echo $blockname; ?> bg-primary has-background">
	<div class="grid-x grid-margin-x">
		<div class="cell large-6">
			<h1><?php echo do_shortcode( $title ); ?></h1>
			<form class="headersearch" action="<?php echo get_permalink( strl_get_default_page_for( 'search' ) ); ?>" method="get" aria-haspopup="true">
				<label for="s" style="position: absolute; left: -9999px;"><?php _e( 'Fill in your search terms', 'strl-frontend' ); ?></label>
				<input placeholder="<?php _e( 'Fill in your search terms', 'strl-frontend' ); ?>" type="text" name="_search_search" id="s" value="" data-aria-label="<?php _e( 'Fill in your search terms', 'strl-frontend' ); ?>" data-swpengine="default" data-swplive="true" />
				<span></span>
				<button type="submit">
					<i class="fa-regular fa-magnifying-glass"></i>
					<span class="screen-reader-text"><?php _e( 'search', 'strl-frontend' ); ?></span>
				</button>
			</form>
			<div class="search-meta">
				<?php
				if ( $searchterms ) {
					echo '<ul>';
					foreach ( $searchterms as $searchterm ) {
						$text = ! empty( $searchterm['search-term'] ) ? $searchterm['search-term'] : '';
						$link = ! empty( $searchterm['search-term-link']['url'] ) ? $searchterm['search-term-link']['url'] : '';
						if ( $searchterm ) {
							if ( ! empty( $link ) ) {
								$target = ! empty( $searchterm['search-term-link']['target'] ) ? $searchterm['search-term-link']['target'] : '_self';
								$title  = ! empty( $searchterm['search-term-link']['title'] ) ? 'title="' . $searchterm['search-term-link']['title'] . '"' : '';
								?>
								<li><a <?php echo $title; ?> target="<?php echo $target; ?>" href="<?php echo $link; ?>"><?php echo $text; ?></a></li>
								<?php
							} else {
								?>
								<li><a href="<?php echo get_permalink( strl_get_default_page_for( 'search' ) ); ?>?_search_search=<?php echo $text; ?>"><?php echo $text; ?></a></li>
								<?php
							}
						}
					}
					echo '</ul>';
				}
				?>
			</div>
		</div>
	</div>
</section>
<!-- end:<?php echo $blockname; ?> -->
