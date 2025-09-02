<?php

add_shortcode( 'tooltip', 'strl_tooltip_shortcode' );
add_shortcode( 'accordion', 'strl_accordion_shortcode' );
add_shortcode( 'btn', 'strl_button_primary_shortcode' );
add_shortcode( 'socialshare', 'strl_social_share' );
add_shortcode( 'sitename', 'strl_sitename' );
add_shortcode( 'sociallink', 'strl_sociallink' );
add_shortcode( 'show_social_profile_links', 'strl_social_profile_links' );
add_shortcode( 'part_of_day', 'strl_part_of_day' );
add_shortcode( 'featured', 'strl_featured' );

function strl_featured( $atts, $content = null ) {
	return '<div class="featured"><p>' . $content . '</p></div>';
}

/**
 * Adds current day part before string added as parameter
 *
 * @package strl
 *
 * @param array  $atts    The attributes on the shortcode
 */
function strl_part_of_day( $atts ) {
	ob_start();

	$args = shortcode_atts(
		array(),
		$atts,
	);

	$data = array(
		'morning'   => __( 'Goodmorning', 'strl-frontend' ) . ',',
		'afternoon' => __( 'Good afternoon', 'strl-frontend' ) . ',',
		'evening'   => __( 'Good evening', 'strl-frontend' ) . ',',
	);

	$message = '<span class="part-of-day" data-localization=\'' . json_encode( $data ) . '\'>&nbsp;</span>';

	return  $message . ob_get_clean();
}

/**
 * Shows the social profile links, used in Widgets
 *
 * @package strl
 *
 */
function strl_social_profile_links() {
	ob_start();
	$socials = array( 'facebook', 'twitter', 'instagram', 'linkedin', 'youtube', 'pinterest', 'rss' );
	foreach ( $socials as $social ) {
		${$social} = get_field( "social-$social", 'option' );
	}
	?>
	<div class="socialswidget">
		<?php
		echo ! empty( $facebook ) ? '<a class="sociallink" href="' . $facebook['url'] . '" rel="noreferrer"><i class="fa-brands fa-facebook-f"></i><span class="screen-reader-text">' . __( 'Go to Facebook', 'strl-frontend' ) . '</span></a>' : '';
		echo ! empty( $youtube ) ? '<a class="sociallink" href="' . $youtube['url'] . '" rel="noreferrer"><i class="fab fa-youtube"></i><span class="screen-reader-text">' . __( 'Go to YouTube', 'strl-frontend' ) . '</span></a>' : '';
		echo ! empty( $pinterest ) ? '<a class="sociallink" href="' . $pinterest['url'] . '" rel="noreferrer"><i class="fab fa-pinterest"></i><span class="screen-reader-text">' . __( 'Go to pinterest', 'strl-frontend' ) . '</span></a>' : '';
		echo ! empty( $twitter ) ? '<a class="sociallink" href="' . $twitter['url'] . '" rel="noreferrer"><i class="fa-brands fa-x-twitter"></i><span class="screen-reader-text">' . __( 'Go to Twitter', 'strl-frontend' ) . '</span></a>' : '';
		echo ! empty( $linkedin ) ? '<a class="sociallink" href="' . $linkedin['url'] . '" rel="noreferrer"><i class="fab fa-linkedin-in"></i><span class="screen-reader-text">' . __( 'Go to LinkedIn', 'strl-frontend' ) . '</span></a>' : '';
		echo ! empty( $instagram ) ? '<a class="sociallink" href="' . $instagram['url'] . '" rel="noreferrer"><i class="fab fa-instagram"></i><span class="screen-reader-text">' . __( 'Go to Instagram', 'strl-frontend' ) . '</span></a>' : '';
		echo ! empty( $rss ) ? '<a class="sociallink" href="' . $rss['url'] . '" rel="noreferrer"><i class="fa-solid fa-rss"></i><span class="screen-reader-text">' . __( 'Go to rss', 'strl-frontend' ) . '</span></a>' : '';
		?>
	</div>
	<?php
	return ob_get_clean();
}

/**
 * Adds the Social Links shortcode
 *
 * @package strl
 *
 * @param array  $atts    The attributes on the shortcode
 */
function strl_sociallink( $atts ) {
	$args = shortcode_atts(
		array(
			'social' => '',
		),
		$atts,
	);

	$social = $args['social'];

	if ( isset( get_field( "social-$social", 'option' )['url'] ) ) {
		return get_field( "social-$social", 'option' )['url'];
	} elseif ( get_field( "social-$social", 'option' ) !== '' ) {
		return get_field( "social-$social", 'option' );
	} else {
		return "Geen $social ingevuld";
	}
}

/**
 * Adds the Social Share shortcode
 *
 * @package strl
 *
 * @param array  $atts    The attributes on the shortcode
 */
function strl_social_share( $atts ) {
	$atts = shortcode_atts(
		array(
			'facebook'    => 1,
			'facebookmsg' => 1,
			'twitter'     => 1,
			'linkedin'    => 1,
			'mail'        => 1,
			'whatsapp'    => 1,
			'pinterest'   => 1,
		),
		$atts,
	);

	foreach ( $atts as $$key => $value ) {
		if ( isset( $value ) ) {
			$key = filter_var( $value, FILTER_VALIDATE_BOOLEAN );
		}
	}

	ob_start();
	?>
	<div class="socialshare">
		<?php
		if ( $atts['facebook'] ) {
			?>
			<a rel="noreferrer noopener" aria-label="<?php echo __( 'Share on', 'strl-frontend' ) . ' Facebook'; ?>" href="http://www.facebook.com/sharer/sharer.php?u=<?php echo ( ( $_SERVER['HTTPS'] ? 'https://' : 'http://' ) . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] ); ?>" onClick="__gaTracker('send', 'social', 'facebook', 'share', '<?php echo ( ( $_SERVER['HTTPS'] ? 'https://' : 'http://' ) . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] ); ?>' );" target="_blank">
				<i data-tooltip title="<?php echo __( 'Share on', 'strl-frontend' ) . ' Facebook'; ?>" data-position="top" data-alignment="center" class="fab fa-facebook-f"></i>
				<span class="screen-reader-text"><?php echo __( 'Share on', 'strl-frontend' ) . ' Facebook'; ?></span>
			</a>
			<?php
		}

		if ( $atts['facebookmsg'] ) {
			?>
			<a rel="noreferrer noopener" aria-label="<?php echo __( 'Share via', 'strl-frontend' ) . ' Facebook Messenger'; ?>" class="show-for-small-only" href="fb-messenger://share/?link=<?php echo ( ( $_SERVER['HTTPS'] ? 'https://' : 'http://' ) . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] ); ?>?send-dialog&app_id=XXXXXXXXXX">
				<i data-tooltip title="<?php echo __( 'Share via', 'strl-frontend' ) . ' Facebook Messenger'; ?>" data-position="top" data-alignment="center" class="fab fa-facebook-messenger"></i>
				<span class="screen-reader-text"><?php echo __( 'Share via', 'strl-frontend' ) . ' Facebook Messenger'; ?></span>
			</a>
			<?php
		}

		if ( $atts['twitter'] ) {
			?>
			<a rel="noreferrer noopener" aria-label="<?php echo __( 'Share on', 'strl-frontend' ) . ' Twitter'; ?>" href="http://twitter.com/intent/tweet?url=<?php echo ( ( $_SERVER['HTTPS'] ? 'https://' : 'http://' ) . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] ); ?>" onClick="__gaTracker('send', 'social', 'twitter', 'share', '<?php echo ( ( $_SERVER['HTTPS'] ? 'https://' : 'http://' ) . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] ); ?>' );" target="_blank">
				<i data-tooltip title="<?php echo __( 'Share on', 'strl-frontend' ) . ' Twitter'; ?>" data-position="top" data-alignment="center" class="fab fa-twitter"></i>
				<span class="screen-reader-text"><?php echo __( 'Share on', 'strl-frontend' ) . ' Twitter'; ?></span>
			</a>
			<?php
		}

		if ( $atts['linkedin'] ) {
			?>
			<a rel="noreferrer noopener" aria-label="<?php echo __( 'Share on', 'strl-frontend' ) . ' LinkedIn'; ?>" href="http://www.linkedin.com/shareArticle?url=<?php echo ( ( $_SERVER['HTTPS'] ? 'https://' : 'http://' ) . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] ); ?>" onClick="__gaTracker('send', 'social', 'linkedin', 'share', '<?php echo ( ( $_SERVER['HTTPS'] ? 'https://' : 'http://' ) . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] ); ?>' );" target="_blank">
				<i data-tooltip title="<?php echo __( 'Share on', 'strl-frontend' ) . ' LinkedIn'; ?>" data-position="top" data-alignment="center" class="fab fa-linkedin-in"></i>
				<span class="screen-reader-text"><?php echo __( 'Share on', 'strl-frontend' ) . ' LinkedIn'; ?></span>
			</a>
			<?php
		}

		if ( $atts['pinterest'] ) {
			?>
			<a rel="noreferrer noopener" aria-label="<?php echo __( 'Share on', 'strl-frontend' ) . ' Pinterest'; ?>" href="http://www.pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&media=<?php echo ( function_exists( 'the_post_thumbnail' ) ) ? wp_get_attachment_url( get_post_thumbnail_id() ) : ''; ?>&description=<?php echo get_the_title(); ?> – <?php echo get_permalink(); ?>" id="pinterest" target="_blank" onClick="__gaTracker('send', 'social', 'pinterest', 'share', '<?php echo ( ( $_SERVER['HTTPS'] ? 'https://' : 'http://' ) . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] ); ?>' );" >
				<i data-tooltip title="<?php echo __( 'Share on', 'strl-frontend' ) . ' Pinterest'; ?>" data-position="top" data-alignment="center" class="fab fa-pinterest"></i>
				<span class="screen-reader-text"><?php echo __( 'Share on', 'strl-frontend' ) . ' Pinterest'; ?></span>
			</a>
			<?php
		}

		if ( $atts['mail'] ) {
			?>
			<a rel="noreferrer noopener" aria-label="<?php echo __( 'Share via', 'strl-frontend' ) . ' e-mail'; ?>" href="mailto:?subject=Kijk%20deze%20website!&body=<?php the_permalink(); ?>" onClick="__gaTracker('send', 'social', 'email-share', 'share', '<?php echo ( ( $_SERVER['HTTPS'] ? 'https://' : 'http://' ) . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] ); ?>');">
				<i data-tooltip title="<?php echo __( 'Share via', 'strl-frontend' ) . ' e-mail'; ?>" data-position="top" data-alignment="center" class="far fa-envelope"></i>
				<span class="screen-reader-text"><?php echo __( 'Share via', 'strl-frontend' ) . ' e-mail'; ?></span>
			</a>
			<?php
		}

		if ( $atts['whatsapp'] ) {
			?>
			<a rel="noreferrer noopener" target="_blank" aria-label="<?php echo __( 'Share via', 'strl-frontend' ) . ' WhatsApp'; ?>" href="https://wa.me/?text=<?php echo ( ( $_SERVER['HTTPS'] ? 'https://' : 'http://' ) . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] ); ?>" data-action="share/whatsapp/share" onClick="__gaTracker('send', 'social', 'whatsapp', 'share', '<?php echo ( ( $_SERVER['HTTPS'] ? 'https://' : 'http://' ) . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] ); ?>');">
				<i data-tooltip title="<?php echo __( 'Share via', 'strl-frontend' ) . ' WhatsApp'; ?>" data-position="top" data-alignment="center" class="fab fa-whatsapp"></i>
				<span class="screen-reader-text"><?php echo __( 'Share via', 'strl-frontend' ) . ' WhatsApp'; ?></span>
			</a>
			<?php
		}
		?>
	</div>
	<?php
	return ob_get_clean();
}

/**
 * Adds the Button shortcode
 *
 * @package strl
 *
 * @param array  $atts    The attributes on the shortcode
 * @param string $content The content between the shortcode tags
 */
function strl_button_primary_shortcode( $atts, $content ) {
	$args = shortcode_atts(
		array(
			'link'   => '',
			'type'   => '',
			'target' => '',
		),
		$atts,
	);

	$link   = $args['link'];
	$type   = $args['type'];
	$target = ! empty( $args['target'] ) ? $args['target'] : '_self';
	$title  = ! empty( $args['title'] ) ? $args['title'] : '';

	ob_start();
	?>
	<a href="<?php echo $link; ?>" class="btn <?php echo ! empty( $type ) ? $type : ''; ?>" <?php echo ! empty( $target ) ? 'target="' . $target . '"' : ''; ?> <?php echo ! empty( $title ) ? 'title="' . $title . '"' : ''; ?>><?php echo $content; ?></a>
	<?php
	return ob_get_clean();
}

/**
 * Adds the Accordion shortcode
 *
 * @package strl
 *
 * @param array  $atts    The attributes on the shortcode
 * @param string $content The content between the shortcode tags
 */
function strl_accordion_shortcode( $atts, $content ) {
	$args = shortcode_atts(
		array(
			'title'        => '',
			'heading_type' => 'h2',
		),
		$atts,
	);

	$title = $args['title'];

	switch ( $atts['heading_type'] ) {
		case 'h3':
			$title = '<h3 class="h6">' . $title . '</h3>';
			break;
		default:
			$title = '<h2 class="h6">' . $title . '</h2>';
			break;
	}

	/* Do not add enters, causes inline <p>'s */
	ob_start();
	?>
	<details><summary><i class="fa-regular fa-angle-down" aria-hidden="true"></i><?php echo $title; ?></summary><div><?php echo apply_filters( 'the_content', $content ); ?></div></details>
	<?php
	return ob_get_clean();
}


/**
 * Adds the Tooltip shortcode
 *
 * @package strl
 *
 * @param array  $atts    The attributes on the shortcode
 * @param string $content The content between the shortcode tags
 */
function strl_tooltip_shortcode( $atts, $content ) {
	$args = shortcode_atts(
		array(
			'title' => '',
		),
		$atts,
	);

	$title = $args['title'];

	ob_start();
	?>
	<span data-tooltip title="<?php echo $title; ?>"><?php echo $content; ?></span>
	<?php
	return ob_get_clean();
}

/**
 * Adds the Sitename shortcode
 *
 * @package strl
 */
function strl_sitename() {
	return get_bloginfo( 'sitename' );
}
