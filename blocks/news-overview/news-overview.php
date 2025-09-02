<?php
$blockname = basename( __FILE__, '.php' );
$prefix    = $blockname . '-';
$type      = get_sub_field( $prefix . 'type' );
$items     = get_sub_field( $prefix . 'items' );
$link      = get_sub_field( $prefix . 'link' );

if ( 'newest' === $type ) {
	$args = array(
		'post_type'      => 'article',
		'posts_per_page' => 5,
		'orderby'        => 'date',
		'order'          => 'DESC',
	);

	$wp_query = new WP_Query( $args );
}

if ( 'featured' === $type ) {
	$args = array(
		'post_type'      => 'article',
		'posts_per_page' => 5,
		'orderby'        => 'date',
		'order'          => 'DESC',
		'tax_query'      => array(
			array(
				'taxonomy' => 'article_highlight',
				'field'    => 'slug',
				'terms'    => 'uitgelicht',
			),
		),
	);

	$wp_query = new WP_Query( $args );

	$amount      = $wp_query->found_posts;
	$featuredids = array();

	if ( $amount < 5 ) {
		if ( $wp_query->have_posts() ) {
			while ( $wp_query->have_posts() ) {
				$wp_query->the_post();
				$featuredids[] = get_the_ID();
			}
		}
		wp_reset_query();

		$args = array(
			'post_type'      => 'article',
			'posts_per_page' => 5 - $amount,
			'orderby'        => 'date',
			'order'          => 'DESC',
			'post__not_in'   => $featuredids,
		);

		$wp_query = new WP_Query( $args );

		if ( $wp_query->have_posts() ) {
			while ( $wp_query->have_posts() ) {
				$wp_query->the_post();
				$featuredids[] = get_the_ID();
			}
		}
		wp_reset_query();
	}
}

?>
<!-- <?php echo $blockname; ?> -->
<section class="<?php echo $blockname; ?> bg-quaternary has-background">
	<div class="grid-x grid-margin-x grid-margin-y large-up-3 medium-up-2 small-up-1">
		<?php
		if ( 'manual' === $type ) {
			if ( $items ) {
				$i = 0;
				foreach ( $items as $item ) {
					$post = $item;
					setup_postdata( $post );
					if ( $i < 2 ) {
						get_template_part( 'blocks/_global/grid-card-publications-featured' );
					} else {
						get_template_part( 'blocks/_global/grid-card-publications' );
					}
					$i++;
				}
				wp_reset_postdata();
			}
		} else {
			if ( 'featured' == $type && $amount < 5 ) {
				if ( $featuredids ) {
					$i = 0;
					foreach ( $featuredids as $item ) {
						$post = $item;
						setup_postdata( $post );
						if ( $i < 2 ) {
							get_template_part( 'blocks/_global/grid-card-publications-featured' );
						} else {
							get_template_part( 'blocks/_global/grid-card-publications' );
						}
						$i++;
					}
					wp_reset_postdata();
				}
			} else {
				$i = 0;
				if ( $wp_query->have_posts() ) {
					while ( $wp_query->have_posts() ) {
						$wp_query->the_post();
						if ( $i < 2 ) {
							get_template_part( 'blocks/_global/grid-card-publications-featured' );
						} else {
							get_template_part( 'blocks/_global/grid-card-publications' );
						}
						$i++;
					}
				}
			}
		}
		?>
	</div>
	<div class="grid-x grid-margin-x grid-margin-y">
		<div class="cell">
			<div class="text text-right">
				<?php
				if ( $link ) {
					$link_url    = $link['url'];
					$link_title  = $link['title'];
					$link_target = $link['target'] ? $link['target'] : '_self';
					?>
					<a class="btn quaternary contrast icon" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>">
					<?php echo esc_html( $link_title ); ?>
					<span class="screen-reader-text"><?php _e( 'Go to news overview', 'strl-frontend' ); ?></span>
					</a>
					<?php
				}
				?>
			</div>
		</div>
	</div>
</section>
<?php wp_reset_query(); ?>
<!-- end:<?php echo $blockname; ?> -->
