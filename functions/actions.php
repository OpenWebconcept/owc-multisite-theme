<?php
add_action( 'init', 'strl_buttons' );
add_action( 'init', 'strl_clean_header' );
add_action( 'init', 'strl_remove_excerpt_thumbnail_support' );
add_action( 'init', 'strl_remove_default_image_sizes_2' );
add_action( 'init', 'strl_remove_comment_support', 100 );
add_action( 'template_redirect', 'strl_return_404' );
add_action( 'admin_menu', 'strl_remove_menus' );
// add_action( 'admin_head', 'strl_backend_styling' );
add_action( 'admin_head', 'strl_custom_favicon' );
add_action( 'wp_enqueue_scripts', 'strl_enqueue_scripts', 999 );
add_action( 'admin_enqueue_scripts', 'strl_admin_enqueue_scripts', 999 );
add_action( 'wp_trash_post', 'strl_restrict_post_deletion', 10, 1 );
add_action( 'before_delete_post', 'strl_restrict_post_deletion', 10, 1 );
add_action( 'wp_dashboard_setup', 'strl_remove_dashboard_widgets' );
add_action( 'after_setup_theme', 'strl_remove_image_sizes', 999 );
add_action( 'after_setup_theme', 'strl_add_image_sizes' );
add_action( 'after_setup_theme', 'strl_load_textdomain' );
add_action( 'after_setup_theme', 'strl_register_menus' );
add_action( 'after_setup_theme', 'strl_add_theme_support' );
add_action( 'widgets_init', 'strl_register_sidebars' );
add_action( 'load-options-permalink.php', 'strl_cpt_load_permalinks' );
add_action( 'wp_ajax_strl_facetwp_reindex', 'strl_facetwp_reindex' );
add_action( 'widgets_init', 'strl_remove_unused_widgets' );
add_action( 'wp_dashboard_setup', 'strl_dashboard_widget_info' );
add_action( 'admin_init', 'strl_check_fa_api' );
add_action( 'admin_bar_menu', 'strl_remove_default_post_type_menu_bar', 999 );
add_action( 'acf/save_post', 'strl_sanitize_acf_video_input', 10 );
add_action( 'save_post', 'strl_update_featured_image', 10, 2 );
remove_all_actions( 'wp_ajax_acf/validate_save_post', 10 );
remove_all_actions( 'wp_ajax_nopriv_acf/validate_save_post', 10 );
add_action( 'manage_page_posts_columns', 'strl_breadcrumbs_column', 5 );
add_action( 'manage_article_posts_columns', 'strl_breadcrumbs_column', 5 );
add_action( 'manage_event_posts_columns', 'strl_breadcrumbs_column', 5 );
add_action( 'manage_councillor_posts_columns', 'strl_breadcrumbs_column', 5 );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
add_action( 'pre_get_posts', 'strl_exclude_posts_from_main_queries' );
add_action( 'acf/init', 'strl_acf_add_google_maps_api_key' );
add_action( 'after_switch_theme', 'strl_create_default_pages' );

/**
 * Set Google Maps API key for ACF
 *
 * @return void
 */
function strl_acf_add_google_maps_api_key() {
	$api_key = get_field( 'maps-api-key', 'option' );
	if ( ! empty( $api_key ) ) {
		acf_update_setting( 'google_api_key', $api_key );
	}
}

function strl_breadcrumbs_column( $columns ) {
	$id['breadcrumbs'] = __( 'Breadcrumbs', 'strl-frontend' );
	$columns           = array_merge( $columns, $id );
	return $columns;
}

/**
 * Sets featured image ID of ACF featured image so YOAST will display this image.
 *
 * @package strl
 */
function strl_update_featured_image( $post_id, $post ) {
	$featured_image_id = get_field( 'settings-group_post-featured-image', $post_id ) ? get_field( 'settings-group_post-featured-image', $post_id )['ID'] : '';

	if ( $featured_image_id ) {
		set_post_thumbnail( $post_id, $featured_image_id );
	}
}

function strl_sanitize_acf_video_input( $post_id ) {
	$postmeta = get_post_meta( $post_id );
	if ( ! empty( $postmeta ) ) {
		foreach ( $postmeta as $key => $value ) {
			if ( '_' !== substr( $key, 0, 1 ) ) {
				// Check if field key ends with either video, vimeo or youtube
				if ( substr( $key, - 5 ) === 'video' || substr( $key, - 5 ) === 'vimeo' || substr( $key, - 7 ) === 'youtube' ) {
					$videourl = $value[0];
					// Regex to strip all valid youtube URL's
					preg_match( "/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user|shorts)\/))([^\?&\"'>]+)/", $videourl, $matches );
					if ( ! empty( $matches ) ) {
						$video_id = $matches[1];
					} else {
						// Regex to strip all valid vimeo URL's
						preg_match( '/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/', $videourl, $matches );
						if ( ! empty( $matches ) ) {
							foreach ( $matches as $url ) {
								if ( 9 === strlen( $url ) && is_numeric( $url ) ) {
									$video_id = $url;
									break;
								}
							}
						}
					}

					if ( ! empty( $video_id ) ) {
						update_post_meta( $post_id, $key, $video_id, $value[0] );
					}
				}
			}
		}
	}
}


/**
 * Removes the "Add Post" in the admin bar.
 *
 * @param $wp_admin_bar
 * @return void
 */
function strl_remove_default_post_type_menu_bar( $wp_admin_bar ) {
	$wp_admin_bar->remove_node( 'new-post' );
}

/**
 * Removes Duotone SVGs from WP 5.9 onwards.
 *
 * @package strl
 */
remove_action( 'wp_body_open', 'wp_global_styles_render_svg_filters' );

/**
 * Checks if the ACF Font Awesome extension has an API key filled in
 *
 * @package strl
 */
function strl_check_fa_api() {
	if ( is_plugin_active( 'advanced-custom-fields-font-awesome/acf-font-awesome.php' ) ) {
		if ( ! isset( get_option( 'acffa_settings' )['acffa_api_key'] ) || ! get_option( 'acffa_settings' )['acffa_api_key'] ) {
			add_action( 'admin_notices', 'strl_fa_api_notice' );
		}
	}
}

/**
 * The notice callback for strl_check_fa_api
 *
 * @package strl
 */
function strl_fa_api_notice() {
	?>
	<div class="error notice">
		<p><?php _e( 'The ACF Font Awesome extension still needs an API key', 'strl' ); ?>. <a href="<?php echo get_bloginfo( 'wpurl' ); ?>/wp-admin/edit.php?post_type=acf-field-group&page=fontawesome-settings"><?php echo __( 'Provide one here.', 'strl' ); ?></a></p>
	</div>
	<?php
}

/**
 * Function to filter out the unwanted attributes on styles and JavaScript includes
 *
 * @package strl
 * @param  string:<string> $buffer The ouput buffer
 * @return string:<string> $buffer The ouput buffer
 */
function output_callback( $buffer ) {
	return preg_replace( "%[ ]type=[\'\"]text\/(javascript|css)[\'\"]%", '', $buffer );
}

/**
 * Remove unwanted SVG filter injection WP
 */
remove_action( 'wp_enqueue_scripts', 'wp_enqueue_global_styles' );
remove_action( 'wp_body_open', 'wp_global_styles_render_svg_filters' );

/**
 * Removes the excerpt and thumbnail
 *
 * @package strl
 */
function strl_remove_excerpt_thumbnail_support() {
	$posttypes = get_post_types();
	foreach ( $posttypes as $posttype ) {
		remove_post_type_support( $posttype, 'excerpt' );
	}
}

/**
 * Registers navigation menus
 *
 * @package strl
 */
function strl_register_menus() {
	register_nav_menus(
		array(
			'main' => __( 'Main menu', 'strl' ),
		)
	);
}

/**
 * Adds our custom STRL Info Widget
 *
 * @package strl
 */
function strl_dashboard_widget_info() {
	global $wp_meta_boxes;
	wp_add_dashboard_widget( 'info_widget', 'STUURLUI Info', 'strl_info_widget_content' );
}

/**
 * Adds content to our STRL Info Widget
 *
 * @package strl
 */
function strl_info_widget_content() {
	echo get_field( 'info', 'options' );
}

/**
 * Adds theme support for STRL
 *
 * @package strl
 */
function strl_add_theme_support() {
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'html5', array( 'script', 'style' ) );
}

/**
 * Load theme textdomain
 *
 * @package strl
 */
function strl_load_textdomain() {
	load_theme_textdomain( 'strl', get_stylesheet_directory() . '/languages/strl' );
	load_theme_textdomain( 'strl-frontend', get_stylesheet_directory() . '/languages/strl-frontend' );
}

/**
 * Removes unwanted standard widgets so clients can't use them
 *
 * @package strl
 */
function strl_remove_unused_widgets() {
	$widgets_to_unregister = array(
		'WP_Widget_Pages',
		'WP_Widget_Calendar',
		'WP_Widget_Archives',
		'WP_Widget_Media_Audio',
		'WP_Widget_Media_Image',
		'WP_Widget_Media_Video',
		'WP_Widget_Media_Gallery',
		'WP_Widget_Meta',
		'WP_Widget_Search',
		'WP_Widget_Categories',
		'WP_Widget_Recent_Posts',
		'WP_Widget_Recent_Comments',
		'WP_Widget_RSS',
		'WP_Widget_Tag_Cloud',
		'WP_Widget_Block',
		'GFWidget',
		'bcn_widget',
	);
	foreach ( $widgets_to_unregister as $widget ) {
		unregister_widget( $widget );
	}
}

/**
 * Removes the comment functionality
 *
 * @package strl
 */
function strl_remove_comment_support() {
	remove_post_type_support( 'page', 'comments' );
}

/**
 * Reindexes FacetWP's table
 *
 * @package strl
 */
function strl_facetwp_reindex() {
	if ( ! wp_verify_nonce( $_REQUEST['nonce'], 'facetwp_reindex_nonce' ) ) {
		exit();
	}

	$post_id = $_REQUEST['post_id'];
	FWP()->indexer->index( $post_id );

	die( 'DONE' );
}

if ( class_exists( 'acf' ) ) {
	add_action( 'pre_get_posts', 'strl_set_postsperpage', 1 );
	add_action( 'admin_enqueue_scripts', 'strl_acf_enqueue', 999 );
}


function strl_set_postsperpage( $query ) {
	$postsperpage = ! empty( get_sub_field( get_row_layout() . '-postsperpage' ) ) ? get_sub_field( get_row_layout() . '-postsperpage' ) : null;
	if ( ! empty( $postsperpage ) ) {
		$query->set( 'posts_per_page', $postsperpage );
	}
	return $query;
}

/**
 * Removes unwanted standard WP thumbnail sizes
 *
 * @package strl
 */
function strl_remove_image_sizes() {
	remove_image_size( '1536x1536' );
	remove_image_size( '2048x2048' );
	remove_image_size( 'featured-xlarge' );
	remove_image_size( 'featured-large' );
	remove_image_size( 'featured-small' );
	remove_image_size( 'featured-medium' );
	remove_image_size( 'fp-small' );
	remove_image_size( 'fp-medium' );
	remove_image_size( 'fp-large' );
	remove_image_size( 'fp-xlarge' );
}

/**
 * Adds custom thumbnail sizes
 *
 * @package strl
 */
function strl_add_image_sizes() {
	add_image_size( 'strl-small', 300, 300, false );
	add_image_size( 'strl-medium', 600, 600, false );
	add_image_size( 'strl-large', 1600, 800, false );
}

/**
 * Removes unwanted standard WooCommerce thumbnail sizes
 *
 * @package strl
 */
function strl_remove_default_image_sizes_2() {
	remove_image_size( 'woocommerce_single' );
	remove_image_size( 'woocommerce_thumbnail' );
	remove_image_size( 'woocommerce_gallery_thumbnail' );
	remove_image_size( 'shop_catalog' );
	remove_image_size( 'shop_single' );
	remove_image_size( 'shop_thumbnail' );
}

/**
 * Enqueues backend JavaScript
 *
 * @package strl
 */
function strl_acf_enqueue( $hook ) {
	wp_enqueue_script( 'strl_backend_scripts', get_bloginfo( 'stylesheet_directory' ) . '/assets/js/backend.min.js' );
}

/**
 * Enqueues FontAwesome to the backend
 *
 * @package strl
 */
function strl_backend_styling() {
	?>
	<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-rqn26AG5Pj86AF4SO72RK5fyefcQ/x32DNQfChxWvbXIyXFePlEktwD18fEz+kQU" crossorigin="anonymous">
	<?php
}

/**
 * Removes unwanted standard WP settings from the Dashboard (defaults to Comments and Posts)
 *
 * @package strl
 */
function strl_remove_menus() {
	remove_menu_page( 'edit.php' );
	remove_menu_page( 'edit-comments.php' );
}

/**
 * Enqueues styles and scripts to the frontend
 *
 * @package strl
 */
function strl_enqueue_scripts() {
	wp_dequeue_style( 'wp-block-library' );
	wp_dequeue_style( 'wp-block-library-theme' );
	wp_dequeue_style( 'wc-block-style' );
	wp_deregister_script( 'jquery' );
	wp_deregister_script( 'jquery-core' );
	wp_deregister_script( 'jquery-migrate' );

	wp_enqueue_script( 'jquery', get_bloginfo( 'stylesheet_directory' ) . '/assets/js/jquery.min.js', 'jquery', '', false );
	wp_enqueue_script( 'vendor', get_bloginfo( 'stylesheet_directory' ) . '/assets/js/vendor.min.js', array(), '', true );
	wp_enqueue_script( 'nocache', get_bloginfo( 'stylesheet_directory' ) . '/assets/js/nocache/nocache.min.js', array(), '', true );

	$strlscript = glob( get_stylesheet_directory() . '/assets/js/scripts-*.js' );
	$strlscript = basename( $strlscript[ count( $strlscript ) - 1 ] );

	if ( file_exists( get_stylesheet_directory() . '/assets/js/' . $strlscript ) ) {
		wp_enqueue_script( 'scripts', get_bloginfo( 'stylesheet_directory' ) . '/assets/js/' . $strlscript, array( 'nocache', 'vendor' ), '', true );
	} else {
		wp_enqueue_script( 'scripts', get_bloginfo( 'stylesheet_directory' ) . '/assets/js/scripts.min.js', array( 'nocache', 'vendor' ), '', true );
	}

	$style = glob( get_stylesheet_directory() . '/assets/css/style-*.css' );
	$style = basename( $style[ count( $style ) - 1 ] );
	if ( file_exists( get_stylesheet_directory() . '/assets/css/' . $style ) ) {
		wp_enqueue_style( 'strl-theme', get_bloginfo( 'stylesheet_directory' ) . '/assets/css/' . $style );
	} else {
		wp_enqueue_style( 'strl-theme', get_bloginfo( 'stylesheet_directory' ) . '/assets/css/style.min.css' );
	}

	wp_localize_script(
		'scripts',
		'strl_vars',
		array(
			'wpurl'                => get_bloginfo( 'wpurl' ),
			'ajaxurl'              => admin_url( 'admin-ajax.php' ),
			'stylesheet_directory' => get_bloginfo( 'stylesheet_directory' ),
			'currentpage'          => get_permalink(),
			'translate_page'       => __( 'Page', 'strl' ),
		)
	);
}



/**
 * Cleans the <head> by removing scripts for e.g. emoji support
 *
 * @package strl
 */
function strl_clean_header() {
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
}

/**
 * Removes unwanted standard WP dashboard widgets
 *
 * @package strl
 */
function strl_remove_dashboard_widgets() {
	global $wp_meta_boxes;

	unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now'] );
	unset( $wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press'] );
	unset( $wp_meta_boxes['dashboard']['side']['core']['dashboard_primary'] );
	update_user_meta( get_current_user_id(), 'show_welcome_panel', false );
	remove_meta_box( 'dashboard_activity', 'dashboard', 'normal' );
	remove_meta_box( 'rg_forms_dashboard', 'dashboard', 'side' );
}

/**
 * Adds the STRL Shortcodes button to TinyMCE Editors
 *
 * @package strl
 */
function strl_buttons() {
	add_filter( 'mce_external_plugins', 'strl_add_buttons' );
	add_filter( 'mce_buttons', 'strl_register_buttons' );
}

/**
 * Restricts the user to delete pages that are used as standard Search of 404 page
 *
 * @package strl
 */
function strl_restrict_post_deletion( $post_id ) {
	if ( strl_get_default_page_for( 'not-found' ) === $post_id || strl_get_default_page_for( 'search' ) === $post_id ) {
		_e( 'You are not authorized to delete this page.', 'strl' );
		exit;
	}
}

/**
 * Adds a custom favicon
 *
 * @package strl
 */
function strl_custom_favicon() {
	echo '<style> .dashicons-strl { background-image: url("' . get_stylesheet_directory_uri() . '/assets/img/strl-36px.png"); background-repeat: no-repeat; background-position: center; } </style> ';
}

/**
 * Registers widget areas for Footer Areas
 *
 * @package strl
 */
function strl_register_sidebars() {
	$footer_areas = 4;
	$counter      = 1;

	while ( $counter <= $footer_areas ) {
		register_sidebar(
			array(
				'id'            => 'footer-' . $counter,
				'name'          => __( 'Footer' ) . ' ' . $counter,
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h2 class="widget-title">',
				'after_title'   => '</h2>',
			)
		);
		++$counter;
	}

	register_sidebar(
		array(
			'id'            => 'copyright',
			'name'          => __( 'Copyright' ),
			'description'   => __( 'A short description of the sidebar.' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<span class="widget-title">',
			'after_title'   => '</span>',
		)
	);
}

/**
 * Enqueues styles for the backend
 *
 * @package strl
 */
function strl_admin_enqueue_scripts() {
	wp_enqueue_style( 'strl-admin-styles', get_bloginfo( 'stylesheet_directory' ) . '/assets/admin/admin-style.min.css', array(), '1.0.2' );
}

/**
 * Gives 404 status to the default 404 page
 *
 * @package strl
 */
function strl_return_404() {
	$page_id = intval( strl_get_default_page_for( 'not-found' ) );
	if ( get_the_ID() === $page_id ) {
		header( $_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found', true, 404 );
	}
}

function strl_alert_bar() {
	$args = array(
		'post_type'      => 'alert',
		'posts_per_page' => 1,
		'post_status'    => 'publish',
	);

	$items = get_posts( $args );
	ob_start();
	if ( ! empty( $items ) ) {
		foreach ( $items as $item ) {
			$item_id = $item->ID;
			$desc    = get_field( 'alert-text', $item_id );
			$link    = get_field( 'alert-link', $item_id );
			?>
			<div class="alertbar" role="complementary" aria-labelledby="site-header" style="display: none;">
				<div class="grid-x grid-margin-x">
					<div class="cell large-12 medium-11 small-11">
						<div class="inner">
							<?php
							if ( ! empty( $desc ) ) {
								echo '<span>' . $desc . '</span>';
							}

							if ( ! empty( $link ) ) {
								echo '<a class="alertbutton icon" href="' . $link['url'] . '" ' . ( $link['target'] ? 'target="' . $link['target'] . '"' : '' ) . '>' . $link['title'] . '</a>';
							}
							?>
						</div>
					</div>
				</div>
				<button class="closealert" tabindex="0" aria-label="<?php _e( 'Hide this message', 'strl' ); ?>">
					<?php include ABSPATH . 'wp-content/themes/owc-multisite-theme/assets/img/close.svg'; ?>
				</button>
			</div>
			<?php
		}
	}
	return ob_get_clean();
}

/**
 * Add custom column to show Post ID
 *
 * @package strl
 *
 * @param  WP_Query $query The query you're using.
 * @return WP_Query $query The query without the excluded posts.
 */
function strl_exclude_posts_from_main_queries( $query ) {
	if ( is_admin() ) {
		return;
	}

	if ( ! $query->is_main_query() ) {
		return;
	}

	$args          = array(
		'posts_per_page' => -1,
		'post_type'      => 'any',
		'fields'         => 'ids',
		'meta_query'     => array(
			array(
				'key'   => 'search-group_search-exclude',
				'value' => '1',
			),
		),
	);
	$exclude_pages = get_posts( $args );
	$exclude_pages = array_merge( $query->query_vars['post__not_in'], $exclude_pages );

	if ( isset( get_queried_object()->ID ) ) {
		if ( ! in_array( get_queried_object()->ID, $exclude_pages, true ) ) {
			$query->set( 'post__not_in', $exclude_pages );
		}
	}

	return $query;
}


/**
 * Create default pages on theme activation
 */
function strl_create_default_pages() {

	$menu_name = 'main';
	$menu_id = wp_get_nav_menu_object($menu_name);
	
	if (! $menu_id ) {
		$menu_id = wp_create_nav_menu($menu_name);
	} 

	$pages_to_create = array(
		'home'          => array(
			'title'   => 'Home',
			'content' => '',
		),
		'search'        => array(
			'title'   => 'Search',
			'content' => '',
		),
		'404-not-found' => array(
			'title'   => '404 not found',
			'content' => '',
		),
	);

	foreach ( $pages_to_create as $slug => $page ) {
		$existing_page = get_page_by_path( $slug );

		if ( ! $existing_page ) {
			$new_page = wp_insert_post(
				array(
					'post_title'   => $page['title'],
					'post_name'    => $slug,
					'post_content' => $page['content'],
					'post_status'  => 'publish',
					'post_type'    => 'page',
				)
			);

			if ( '404 not found' === $page['title'] ) {
				update_field( 'page-not-found', $new_page, 'option' );
				update_field( 'blocks', array( array( 'acf_fc_layout' => 'textonly' ) ), $new_page );
					update_sub_field(
					array( 'blocks', 1, 'textonly-text' ),
					'<h2>Pagina niet gevonden</h2><p>
					De pagina die u zoekt bestaat niet of niet meer. 
					</p>',
					$new_page
				);
			}
			if ( 'Search' === $page['title'] ) {
				update_field( 'page-search', $new_page, 'option' );
				update_post_meta( $new_page, '_wp_page_template', 'search-template.php' );
			}
			if ( 'Home' === $page['title'] ) {
				update_option( 'show_on_front', 'page' );
				update_option( 'page_on_front', $new_page );
				update_field( 'blocks', array( array( 'acf_fc_layout' => 'header-home' ), array( 'acf_fc_layout' => 'textonly' ) ), $new_page );
				update_sub_field( array( 'blocks', 1, 'header-home-title' ), '<h1>Dit is de homepage</h1>', $new_page );
				update_sub_field(
					array( 'blocks', 2, 'textonly-text' ),
					'<h2>Voeg blokken toe via de WP-admin.</h2>Onder STUURLUI Globaal kan de stijling van de website aangepast worden.<p><strong>OWC Multisite thema</strong><br>Dit thema is ontwikkeld voor het OpenWebconcept in opdracht van Gemeente \'s-Hertogenbosch  door <a href="https://www.stuurlui.nl" target="_blank">Stuurlui</a>.<br>
					Bij vragen en/of ondersteuning bij dit thema neem dan contact op via <a href="mailto:support@stuurlui.nl" target="_blank">support@stuurlui.nl</a> 
					of bel ons supportteam op +31 (0)30 227 4000 </p>',
					$new_page
				);
			}
			
		

			wp_update_nav_menu_item(
				$menu_id,
				0,
				array(
					'menu-item-title'     => $page['title'],
					'menu-item-object'    => 'page',
					'menu-item-object-id' => $new_page,
					'menu-item-type'      => 'post_type',
					'menu-item-status'    => 'publish',
				)
			);
		}
	}

	$logo_filename = 'logo.svg';
	$logo_path     = get_template_directory() . '/assets/img/' . $logo_filename;

	if ( file_exists( $logo_path ) ) {
		$upload_dir = wp_upload_dir();
		$file_type  = wp_check_filetype( basename( $logo_path ), null );
		$dest_path  = trailingslashit( $upload_dir['path'] ) . $logo_filename;

		if ( ! file_exists( $dest_path ) ) {
			copy( $logo_path, $dest_path );
		}

		$existing_attachment = attachment_url_to_postid( $dest_path );
		if ( ! $existing_attachment ) {
			$attachment_id = wp_insert_attachment(
				array(
					'guid'           => $dest_path,
					'post_mime_type' => $file_type['type'],
					'post_title'     => 'Site Logo',
					'post_content'   => '',
					'post_status'    => 'inherit',
				),
				$dest_path
			);

			require_once( ABSPATH . 'wp-admin/includes/image.php' );
			$attach_data = wp_generate_attachment_metadata( $attachment_id, $logo_path );
			wp_update_attachment_metadata( $attachment_id, $attach_data );

			$attachment = $attachment_id;
			update_field( 'global-logo-options_logo', $attachment, 'option' );
			update_field( 'global-logo-options_logo-mobile', $attachment, 'option' );

		}
	}
}
