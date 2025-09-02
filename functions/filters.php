<?php
add_filter( 'facetwp_load_a11y', '__return_true' );
add_filter( 'use_block_editor_for_post', '__return_false', 10 );
add_filter( 'use_block_editor_for_post_type', '__return_false', 10 );
add_filter( 'use_widgets_block_editor', '__return_false' );
add_filter( 'upload_mimes', 'strl_allow_svg' );
add_filter( 'style_loader_src', 'strl_remove_ver_css_js', 9999 );
add_filter( 'script_loader_src', 'strl_remove_ver_css_js', 9999 );
add_filter( 'gform_enable_field_label_visibility_settings', '__return_true' );
add_filter( 'gform_disable_auto_update', '__return_true' );
add_filter( 'acf/fields/flexible_content/layout_title/name=blocks', 'strl_acf_blocks_add_title', 10, 4 );
add_filter( 'big_image_size_threshold', '__return_false' );
add_filter( 'max_srcset_image_width', '__return_false' );
// add_filter( 'option_active_plugins', 'strl_disable_acf_on_frontend' );
add_filter( 'script_loader_tag', 'strl_add_extra_atts', 999, 3 );
add_filter( 'plugin_auto_update_setting_html', 'strl_auto_update_setting_html', 10, 3 );
add_filter( 'attachment_fields_to_edit', 'strl_add_id_to_media', 10, 2 );
add_filter( 'display_post_states', 'strl_add_standard_post_states', 10, 2 );
add_filter( 'robots_txt', 'strl_add_xml_sitemap_to_robots', 10, 1 );
add_filter( 'tiny_mce_before_init', 'strl_disable_mce_buttons' );
add_filter( 'facetwp_pre_filtered_post_ids', 'strl_exclude_posts_from_facets', 10, 2 );
// add_filter( 'facetwp_pre_filtered_post_ids', 'strl_sort_search', 10, 2 );
add_filter( 'facetwp_preload_force_query', '__return_false' );

add_filter( 'searchwp_exclude', 'strl_exclude_posts_from_searchwp', 10, 3 );
add_filter( 'nav_menu_item_id', 'strl_clear_nav_menu_item_id', 10, 3 );
add_filter( 'http_request_args', 'strl_http_request_args', 10, 2 ); // https://facetwp.com/help-center/indexing/
add_filter( 'searchwp_live_search_base_styles', '__return_false' );
add_filter( 'acf/format_value/type=link', 'strl_add_default_target', 10, 3 );
remove_filter( 'render_block', 'wp_render_duotone_support', 10 );
add_filter( 'searchwp_live_search_query_args', 'strl_exclude_posts_from_livesearch', 10, 2 );
add_filter( 'searchwp\query\partial_matches', '__return_true' );
add_filter( 'searchwp\query\partial_matches\force', '__return_true' );
add_filter( 'searchwp\query\partial_matches\fuzzy', '__return_true' );
add_filter( 'searchwp\query\partial_matches\fuzzy\force', '__return_true' );
add_filter( 'wpseo_metadesc', 'strl_yoast_add_metadesc', 10, 1 );
add_filter( 'gform_field_content', 'strl_add_fontawesome_to_gfields', 10, 6 );
add_filter( 'gform_field_choice_markup_pre_render', 'strl_add_fontawesome_to_gchoices', 10, 6 );
add_filter( 'duplicate_post_enabled_post_types', 'strl_enable_duplicate_all', 10, 1 );
add_filter( 'wp_get_attachment_image_src', 'strl_maybe_replace_src_with_webp', 10, 4 );
add_filter( 'acf/update_value/key=field_strl_global_domain', 'strl_strip_security_urls', 10, 4 );
add_filter( 'rt_edit_postfix', 'strl_reading_time_postfix', 10, 4 );
add_filter( 'facetwp_facets', 'strl_get_facets' );
add_filter( 'facetwp_index_row', 'strl_date_as_year', 10, 2 );
add_filter( 'facetwp_facet_orderby', 'strl_order_year_desc', 10, 2 );
add_filter( 'facetwp_facet_dropdown_show_counts', 'strl_hide_dropdown_count', 10, 2 );
add_filter( 'rest_authentication_errors', 'strl_disable_rest_api' );
add_filter( 'manage_page_posts_custom_column', 'strl_breadcrumbs_column_content', 5, 2 );
add_filter( 'manage_product_posts_custom_column', 'strl_breadcrumbs_column_content', 5, 2 );
add_filter( 'manage_article_posts_custom_column', 'strl_breadcrumbs_column_content', 5, 2 );
add_filter( 'manage_event_posts_custom_column', 'strl_breadcrumbs_column_content', 5, 2 );
add_filter( 'manage_councillor_posts_custom_column', 'strl_breadcrumbs_column_content', 5, 2 );
add_filter( 'request', 'strl_set_default_post_type_rss_feed' );
add_filter( 'the_excerpt_rss', 'strl_set_rss_excerpt_content' );
add_filter( 'the_author', 'strl_rss_feed_change_author', 10, 1 );
add_filter( 'wpseo_schema_needs_author', '__return_false' );
add_filter( 'oembed_response_data', 'filter_oembed_response_data_author', 10, 4 );
add_filter( 'searchwp\query\mods', 'strl_sort_search_results_by_date', 30, 2 );
add_filter( 'login_errors', 'strl_custom_wordpress_errors' );
add_filter( 'facetwp_preload_url_vars', 'strl_prefill_general' );
add_filter( 'acf/load_field/key=field_navigation-block_blocks_site', 'strl_acf_load_color_field_choices' );
add_filter( 'facetwp_gmaps_api_key', 'strl_facetwp_add_google_maps_api_key' );

/**
 * Set Google Maps key for FacetWP through
 *
 * @param string $api_key  The Google Maps API key from STRL Global
 * @return void
 */
function strl_facetwp_add_google_maps_api_key( $api_key ) {
	$api_key = get_field( 'maps-api-key', 'option' );
	if ( ! empty( $api_key ) ) {
		return $api_key;
	}
}

function strl_acf_load_color_field_choices( $field ) {
	$field['choices'] = array();

	$sites = get_sites( array() );

	if ( ! empty( $sites ) && is_array( $sites ) ) {

		foreach ( $sites as $site ) {
			$site_name = ! empty( get_blog_details( $site->blog_id )->blogname ) ? get_blog_details( $site->blog_id )->blogname : $site->domain;
			$blog_id   = ! empty( $site->blog_id ) ? $site->blog_id : '';

			if ( empty( $blog_id ) ) {
				return $field;
			}

			$field['choices'][ $blog_id ] = $site_name;
		}
	}

	return $field;
}


function strl_prefill_general( $url_vars ) {
	if ( 'actueel/nieuws' == FWP()->helper->get_uri() ) {
		if ( empty( $url_vars['news_type'] ) ) {
			$url_vars['news_type'] = array( 'algemeen' );
		}
	}
	return $url_vars;
}

function strl_custom_wordpress_errors() {
	return __( 'Please enter a valid email address and password to login', 'strl-frontend' );
}

/**
 * Remove author information from the oembed repsonse
 *
 * @param [type] $data
 * @param [type] $post
 * @param [type] $width
 * @param [type] $height
 * @return void
 */
function filter_oembed_response_data_author( $data, $post, $width, $height ) {
	unset( $data['author_name'] );
	unset( $data['author_url'] );
	return $data;
}

function strl_set_default_post_type_rss_feed( $query ) {
	if ( isset( $query['feed'] ) && ! isset( $query['post_type'] ) ) {
		$query['post_type'] = array( 'article' );
	}
	return $query;
}

function strl_set_rss_excerpt_content( $content ) {
	if ( is_feed() ) {
		if ( 'article' === get_post_type() ) {
			$post_id = get_the_ID();
			$content = ! empty( get_field( 'article-openpub-description', $post_id ) ) ? get_field( 'article-openpub-description', $post_id ) : '';
		}
	}
	return $content;
}

function strl_rss_feed_change_author( $display_name ) {

	if ( is_feed() ) {
			return '\'s-Hertogenbosch - ' . __( 'Latest news', 'strl' );
	}

	return $display_name;
}


function strl_breadcrumbs_column_content( $column, $id ) {
	if ( 'breadcrumbs' === $column ) {
		$breadcrumbs_toggle = get_field( 'breadcrumbs-group_breadcrumbs-toggle', $id );
		if ( '1' === $breadcrumbs_toggle ) {
			echo '<strong>' . __( 'On', 'strl-frontend' ) . '</strong>';
		} else {
			echo '<strong>' . __( 'Off', 'strl-frontend' ) . '</strong>';
		}
	}
}
/**
 * Fix $postfix for < 1 minute, WP Reading Time
 */
function strl_reading_time_postfix( $postfix, $time, $singular, $multiple ) {
	if ( 1 === $time || '< 1' === $time ) {
		$postfix = $singular;
	} else {
		$postfix = $multiple;
	}

	return $postfix;
}

/**
 * Add default meta description when not filled in
 *
 * @package strl
 *
 * @param  string:<string> $args Meta description of current page in backend
 * @return string:<string> $args Meta description
 */
function strl_yoast_add_metadesc( $args ) {
	global $post;
	if ( empty( $args ) ) {
		if ( isset( $post ) ) {
			return $post->post_title;
		}
	} else {
		return $args;
	}
}


function strl_exclude_posts_from_livesearch( $args ) {
	// Retrieve the ID from excluded posts
	$excluded = array(
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

	$exclude_pages = get_posts( $excluded );

	// If the post ID is excluded, remove it from the post__in array
	foreach ( $exclude_pages as $excluded_page ) {
		$key = array_search( $excluded_page, $args['post__in'], true );
		if ( false !== $key ) {
			unset( $args['post__in'][ $key ] );
		}
	}

	// If it's not empty, it will show all posts
	if ( empty( $args['post__in'] ) ) {
		$args['post__in'] = array( 0 );
	}
	return $args;
}

function strl_http_request_args( $args, $url ) {
	if ( ! empty( $_SERVER['WARPDRIVE_SYSTEM_NAME'] ) && 0 === strpos( $url, get_site_url() ) ) {
		$args['headers'] = array(
			'Authorization' => 'Basic ' . base64_encode( $_SERVER['WARPDRIVE_SYSTEM_NAME'] . ':nomorewordstress' ),
		);
	}
	return $args;
}

/**
 * Add custom column to show Post ID
 *
 * @package strl
 *
 * @param  array:<string> $columns An associative array of column headings.
 * @return array:<string> $columns The updated associative array.
 */
function strl_clear_nav_menu_item_id( $id, $item, $args ) {
	return '';
}


function strl_exclude_posts_from_facets( $post_ids ) {
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

	foreach ( $exclude_pages as $exclude ) {
		$key = array_search( $exclude, $post_ids, true );
		if ( false !== $key ) {
			unset( $post_ids[ $key ] );
		}
	}

	return $post_ids;
}

function strl_exclude_posts_from_searchwp( $post_ids ) {
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

	$post_ids = array_merge( $post_ids, $exclude_pages );

	return $post_ids;
}

add_filter( 'facetwp_facet_html', 'strl_facetwp_facet_html', 10, 2 );
add_filter( 'facetwp_sort_html', 'strl_facetwp_sort_html', 10, 2 );
add_filter( 'facetwp_assets', 'strl_facetwp_assets' );

/**
 * Fix custom post types rest api display format
 */
function strl_cpt_api_format() {
	return 'standard';
}
add_filter( 'acf/settings/rest_api_format', 'strl_cpt_api_format' );

/**
 * Cleans the MCE toolbar by removing unused buttons
 *
 * @package strl
 *
 * @param  array $opt The toolbar options.
 * @return array $opt The updated toolbar options.
 */
function strl_disable_mce_buttons( $opt ) {
	$opt['toolbar1']      = 'formatselect,bold,italic,bullist,numlist,blockquote,link,table,shortcodes,pastetext';
	$opt['paste_as_text'] = true;
	unset( $opt['toolbar2'] );
	return $opt;
}

/**
 * Adds a spinner for Gravity Forms
 *
 * @package strl
 *
 * @return string The spinner
 */
function strl_spinner_url() {
	return 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';
}


function strl_add_xml_sitemap_to_robots( $robotext ) {
	if ( false === strpos( $robotext, 'sitemap_index' ) ) {
		$additions = 'Sitemap: ' . get_bloginfo( 'wpurl' ) . '/sitemap_index.xml';
		$robotext  = $robotext . $additions;
	}
	return $robotext;
}

/**
 * Adds a label to the FacetWP Sort filter
 *
 * @package strl
 *
 * @param  string $html The HTML for the FacetWP Sort filter.
 * @return string $html The updated HTML for the FacetWP Sort filter.
 */
function strl_facetwp_sort_html( $html ) {
	$html = str_replace( '<select class=', '<label for="sorter">' . __( 'Sort', 'strl-frontend' ) . '</label><select id="sorter" class=', $html );
	return $html;
}

/**
 * Unset FacetWP assets for the frontend
 *
 * @package strl
 *
 * @param  array $assets The assets for FacetWP
 * @return array $assets The assets for FacetWP
 */
function strl_facetwp_assets( $assets ) {
	unset( $assets['front.css'] );
	return $assets;
}

/**
 * Adds a label for the Facet Searchbox
 *
 * @package strl
 *
 * @param  string $html The HTML for the FacetWP Sort filter.
 * @param  array  $params The Facet parameters.
 * @return string $html The updated HTML for the FacetWP Sort filter.
 */
function strl_facetwp_facet_html( $html, $params ) {
	if ( 'search' === $params['facet']['type'] ) {
		$html = str_replace( '<i class="facetwp-icon"></i><input', '<i class="facetwp-icon fa-solid fa-magnifying-glass"></i><label for="searchbox">' . __( 'Search', 'strl-frontend' ) . '</label><input id="searchbox"', $html );
	}
	return $html;
}

/**
 * Returns a notice that STRL takes care of updates
 *
 * @package strl
 *
 * @return string A notice that Stuurlui takes care of updates.
 */
function strl_auto_update_setting_html() {
	return __( 'Plugin updates are managed by STUURLUI.', 'strl' );
}

/**
 * Disables ACF functions and fields on frontend.
 *
 * @package strl
 *
 * @param  array $plugins All active plugins.
 * @return array $plugins All active plugins.
 */
function strl_disable_acf_on_frontend( $plugins ) {
	if ( is_admin() ) {
		return $plugins;
	}

	foreach ( $plugins as $i => $plugin ) {
		if ( 'advanced-custom-fields-pro/acf.php' === $plugin ) {
			unset( $plugins[ $i ] );
		}
	}
	return $plugins;
}

if ( 0 !== get_option( 'medium_size_h' ) ) {
	update_option( 'medium_size_h', 0 );
	update_option( 'medium_size_w', 0 );
	update_option( 'large_size_h', 0 );
	update_option( 'large_size_w', 0 );
	update_option( 'medium_large_size_w', 0 );
	update_option( 'medium_large_size_h', 0 );
}

/**
 * Adds the title with icon to ACF Flexible Layouts (blocks)
 *
 * @package strl
 *
 * @param  string $title  The title of the Flexible Layout/Block
 * @param  string $field  The fieldname
 * @param  array  $layout The entire Flexible Layout/Block array
 * @param  int    $i      The index of the Flexible Layout
 * @return string $title  The title of the Flexible Layout/Block with the icon prepended
 */
function strl_acf_blocks_add_title( $title, $field, $layout, $i ) {
	$blockname = $layout['name'] . '-';
	$title     = '<i class="' . $layout['min'] . '"></i> ' . $title;

	if ( ! empty( get_sub_field( $blockname . 'title' ) ) ) {
		$cleantitle = preg_replace( '/\[.*\]/', '', strip_tags( get_sub_field( $blockname . 'title' ) ) );
		$title      = $title . '<span>' . $cleantitle . '</span>';
	}

	return $title;
}

/**
 * Removes the version from the asset files
 *
 * @package strl
 *
 * @param  string $src The source of the asset
 * @return string $src The source of the asset without the version
 */
function strl_remove_ver_css_js( $src ) {
	if ( strpos( $src, 'ver=' ) ) {
		$src = remove_query_arg( 'ver', $src );
	}
	return $src;
}

/**
 * Allows the use of SVG
 *
 * @package strl
 *
 * @param  array $mimes The accepted MIME types
 * @return array $mimes The accepted MIME types
 */
function strl_allow_svg( $mimes ) {
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}

/**
 * Adds the JavaScript for the TinyMCE buttons
 *
 * @package strl
 *
 * @param  array $plugins An array of TinyMCE plugins
 * @return array $plugins An array of TinyMCE plugins
 */
function strl_add_buttons( $plugins ) {
	$plugins['table']        = get_bloginfo( 'stylesheet_directory' ) . '/assets/js/table.min.js';
	$plugins['strl_buttons'] = get_bloginfo( 'stylesheet_directory' ) . '/assets/js/strl-buttons.min.js';
	return $plugins;
}

/**
 * Registers the TinyMCE buttons
 *
 * @package strl
 *
 * @param  array $buttons An array of TinyMCE buttons
 * @return array $buttons An array of TinyMCE buttons
 */
function strl_register_buttons( $buttons ) {
	array_push( $buttons, 'table', 'shortcodes' );
	return $buttons;
}

/**
 * Add our scripts to the Cookiebot
 *
 * @package strl
 *
 * @param  string $tag The src tag
 * @param  array  $handle An array of Cookiebot's handles
 * @return string $tag The src tag
 */
function strl_add_extra_atts( $tag, $handle ) {
	$scripts = array(
		'foundation',
		'jquery',
		'vendor',
		'plugin',
		'plugin',
		'facetwp-front',
		'scripts',
	);
	if ( in_array( $handle, $scripts, true ) ) {
		$tag = str_replace( 'src', 'data-cookieconsent="ignore" src', $tag );
	}
	return $tag;
}

/**
 * Adds the ID in the Media Library
 *
 * @package strl
 *
 * @param  array   $form_fields The fields
 * @param  WP_Post $post        The media item
 * @return array   $form_fields The fields
 */
function strl_add_id_to_media( $form_fields, $post ) {
	$form_fields['upload-id'] = array(
		'label' => __( 'Media ID', 'strl' ),
		'input' => 'text',
		'value' => $post->ID,
	);

	return $form_fields;
}

/**
 * Adds post states to standard pages
 *
 * @package strl
 *
 * @param  array   $post_states The post states of a post
 * @param  WP_Post $post        The post for which to add a post state
 * @return array   $post_states The post states of a post
 */
function strl_add_standard_post_states( $post_states, $post ) {

 	$notfoundpage = get_field( 'page-not-found', 'option' );
	$searchpage   = get_field( 'page-search', 'option' );

	if ( $notfoundpage === $post->ID ) {
		$post_states[] = __( 'Standard 404 Page', 'strl' );
	} elseif ( $searchpage === $post->ID ) {
		$post_states[] = __( 'Standard Search Page', 'strl' );
	}

	$cpts = strl_get_all_cpts();

	foreach ( $cpts as $cpt ) {
		$standardarchive = get_field( 'standard-page-' . $cpt, 'option' );
		$pretty_name     = ucwords( $cpt );
		if ( $post->ID === $standardarchive ) {
			// translators: %s = Custom Post Type
			$post_states[] = sprintf( __( '%s Archive Page', 'strl' ), $pretty_name );
		}
	}

	return $post_states;
}

/**
 * Sets target to _self on Link fields if empty for W3C purposes
 */
function strl_add_default_target( $value, $post_id, $field ) {
	if ( empty( $value['target'] ) && ! empty( $value['url'] ) ) {
		$value['target'] = '_self';
	}
	return $value;
}

/**
 * Adds fontawesome icon the right way to GF fields
 *
 * @param string $content
 * @param object $field
 * @param string $value
 * @param int $lead_id
 * @param int $form_id
 * @return void
 */
function strl_add_fontawesome_to_gfields( $content, $field, $value, $lead_id, $form_id ) {
	if ( ! is_admin() && in_array( $field->type, array( 'select', 'time', 'address' ), true ) ) {
		$content = str_replace( '</select>', '</select><i class="dropdown-icon fa-solid fa-chevron-down"></i>', $content );
	}
	if ( ! is_admin() && in_array( $field->type, array( 'consent' ), true ) ) {
		$content = str_replace( ">{$field->checkboxLabel}<", "><span class='input-replace'><i class='check-icon fa-solid fa-check'></i></span><span class='label-text'>{$field->checkboxLabel}</span><", $content );
	}
	return $content;
}

/**
 * Adds fontawesome icon the right way to GF choice fields
 *
 * @param string $choice_markup
 * @param array $choice
 * @param object $field
 * @param string $value
 * @return void
 */
function strl_add_fontawesome_to_gchoices( $choice_markup, $choice, $field, $value ) {
	if ( ! is_admin() && in_array( $field->type, array( 'checkbox', 'radio' ), true ) ) {
		$choice_markup = str_replace( ">{$choice['text']}<", "><span class='input-replace'><i class='check-icon fa-solid fa-check'></i></span><span class='label-text'>{$choice['text']}</span><", $choice_markup );
	}
	return $choice_markup;
}

/**
 * Enable Yoast Duplicate Post for all Post Types
 *
 * @param array $enabled_post_types
 * @return array $enabled_post_types
 */
function strl_enable_duplicate_all( $enabled_post_types ) {
	$enabled_post_types = get_post_types();
	return $enabled_post_types;
}

/**
 * Replace images with webp if available
 *
 * @param array $image
 * @param int $attachment_id
 * @param string $size
 * @param bool $icon
 * @return void
 */
function strl_maybe_replace_src_with_webp( $image, $attachment_id, $size, $icon ) {
	if ( ! empty( $image[0] ) ) {
		$image[0] = strl_do_webp_magic( $image[0] );
	}

	return $image;
}

/**
 * Strip security URL's so security header doesn't break when inputting full URL's
 *
 * @param mixed $value
 * @param int $post_id
 * @param array $field
 * @param mixed $original
 * @return void
 */
function strl_strip_security_urls( $value, $post_id, $field, $original ) {
	// Check if value is an URL
	if ( filter_var( $value, FILTER_VALIDATE_URL ) ) {
		$value = parse_url( $value, PHP_URL_HOST );
	}

	return $value;
}

function strl_get_facets( $facets ) {

	$facets[] = array(
		'name'            => 'publication_category',
		'label'           => __( '[publication] categories', ),
		'type'            => 'checkboxes',
		'source'          => 'tax/publication_category',
		'parent_term'     => '',
		'modifier_type'   => 'off',
		'modifier_values' => '',
		'hierarchical'    => 'no',
		'show_expanded'   => 'no',
		'ghosts'          => 'yes',
		'preserve_ghosts' => 'yes',
		'operator'        => 'or',
		'orderby'         => 'count',
		'count'           => '10',
		'soft_limit'      => '5',
	);

	$facets[] = array(
		'name'          => 'search_publications',
		'label'         => __( 'Search publications', 'strl' ),
		'type'          => 'search',
		'source'        => '',
		'search_engine' => 'swp_publications',
		'placeholder'   => __( 'Enter your searchterm', 'strl' ),
		'auto_refresh'  => 'no',
	);

	$facets[] = array(
		'name'       => 'pagination',
		'label'      => __( 'Pagination', 'strl' ),
		'type'       => 'pager',
		'pager_type' => 'numbers',
		'inner_size' => '0',
		'dots_label' => '...',
		'prev_label' => '<i aria-hidden="true" class="fa-solid fa-chevron-left"></i> <span class="screen-reader-text">' . __( 'Go to previous page', 'strl' ) . '</span>',
		'next_label' => ' <span class="screen-reader-text">' . __( 'Go to next page', 'strl' ) . '</span> <i aria-hidden="true" class="fa-solid fa-chevron-right"></i>',
	);

	$facets[] = array(
		'name'                => 'search_pagination',
		'label'               => '[search] pagination',
		'type'                => 'pager',
		'source'              => '',
		'pager_type'          => 'numbers',
		'inner_size'          => '2',
		'dots_label'          => '…',
		'prev_label'          => '<i class="fa-solid fa-chevron-left"></i>',
		'next_label'          => '<i class="fa-solid fa-chevron-right"></i>',
		'count_text_plural'   => '[lower] - [upper] of [total] results',
		'count_text_singular' => '1 result',
		'count_text_none'     => 'No results',
		'load_more_text'      => 'Load more',
		'loading_text'        => 'Loading...',
		'default_label'       => 'Per page',
		'per_page_options'    => '10, 25, 50, 100',
	);

	$facets[] = array(
		'name'                => 'search_pagination_mobile',
		'label'               => '[search] pagination mobile',
		'type'                => 'pager',
		'source'              => '',
		'pager_type'          => 'numbers',
		'inner_size'          => '2',
		'dots_label'          => '…',
		'prev_label'          => '<i class="fa-solid fa-chevron-left"></i>',
		'next_label'          => '<i class="fa-solid fa-chevron-right"></i>',
		'count_text_plural'   => '[lower] - [upper] of [total] results',
		'count_text_singular' => '1 result',
		'count_text_none'     => 'No results',
		'load_more_text'      => 'Load more',
		'loading_text'        => 'Loading...',
		'default_label'       => 'Per page',
		'per_page_options'    => '10, 25, 50, 100',
	);

	$facets[] = array(
		'name'                => 'search_resultsamount',
		'label'               => '[search] resultsamount',
		'type'                => 'pager',
		'source'              => '',
		'source_other'        => '',
		'pager_type'          => 'counts',
		'inner_size'          => '2',
		'dots_label'          => '…',
		'prev_label'          => '« Prev',
		'next_label'          => 'Next »',
		'count_text_plural'   => '[lower] - [upper] van [total] resultaten',
		'count_text_singular' => '1 resultaat',
		'count_text_none'     => 'Geen resultaten',
		'load_more_text'      => 'Load more',
		'loading_text'        => 'Loading...',
		'default_label'       => 'Per page',
		'per_page_options'    => '10, 25, 50, 100',
	);

	$facets[] = array(
		'name'                => 'resultsamount',
		'label'               => __( '[publications] resultsamount' ),
		'type'                => 'pager',
		'source'              => '',
		'source_other'        => '',
		'pager_type'          => 'counts',
		'inner_size'          => '2',
		'dots_label'          => '…',
		'prev_label'          => '« Prev',
		'next_label'          => 'Next »',
		'count_text_plural'   => '[total] resultaten',
		'count_text_singular' => '1 resultaat',
		'count_text_none'     => 'Geen resultaten',
		'load_more_text'      => 'Load more',
		'loading_text'        => 'Loading...',
		'default_label'       => 'Per page',
		'per_page_options'    => '10, 25, 50, 100',
	);

	$facets[] = array(
		'name'          => 'search_search',
		'label'         => '[search] search',
		'type'          => 'search',
		'source'        => '',
		'search_engine' => '',
		'placeholder'   => '',
		'auto_refresh'  => 'yes',
	);

	$facets[] = array(
		'name'            => 'examples_categories',
		'label'           => '[counsillor] categories',
		'type'            => 'checkboxes',
		'source'          => 'tax/counsillor_fraction',
		'parent_term'     => '',
		'modifier_type'   => 'off',
		'modifier_values' => '',
		'hierarchical'    => 'no',
		'show_expanded'   => 'no',
		'ghosts'          => 'yes',
		'preserve_ghosts' => 'yes',
		'operator'        => 'or',
		'orderby'         => 'count',
		'count'           => '10',
		'soft_limit'      => '5',
	);

	$facets[] = array(
		'name'            => 'events_datefilter',
		'label'           => 'events_datefilter',
		'type'            => 'checkboxes',
		'source'          => 'acf/event-start-date',
		'parent_term'     => '',
		'modifier_type'   => 'off',
		'modifier_values' => '',
		'hierarchical'    => 'no',
		'show_expanded'   => 'no',
		'ghosts'          => 'yes',
		'preserve_ghosts' => 'yes',
		'operator'        => 'or',
		'orderby'         => 'count',
		'count'           => '10',
		'soft_limit'      => '5',
	);

	$facets[] = array(
		'name'            => 'search_cpt',
		'label'           => 'search cpt',
		'type'            => 'checkboxes',
		'source'          => 'post_type',
		'parent_term'     => '',
		'modifier_type'   => 'off',
		'modifier_values' => '',
		'hierarchical'    => 'no',
		'show_expanded'   => 'no',
		'ghosts'          => 'yes',
		'preserve_ghosts' => 'yes',
		'operator'        => 'or',
		'orderby'         => 'display_value',
		'count'           => '-1',
		'soft_limit'      => '5',
	);

	$facets[] = array(
		'name'            => 'news_audience',
		'label'           => '[News] audience',
		'type'            => 'checkboxes',
		'source'          => 'tax/article_audience',
		'parent_term'     => '',
		'modifier_type'   => 'off',
		'modifier_values' => '',
		'hierarchical'    => 'no',
		'show_expanded'   => 'no',
		'ghosts'          => 'yes',
		'preserve_ghosts' => 'yes',
		'operator'        => 'or',
		'orderby'         => 'count',
		'count'           => '10',
		'soft_limit'      => '5',
	);

	$facets[] = array(
		'name'            => 'news_type',
		'label'           => '[News] type',
		'type'            => 'checkboxes',
		'source'          => 'tax/article_type',
		'parent_term'     => '',
		'modifier_type'   => 'off',
		'modifier_values' => '',
		'hierarchical'    => 'yes',
		'show_expanded'   => 'yes',
		'ghosts'          => 'yes',
		'preserve_ghosts' => 'yes',
		'operator'        => 'or',
		'orderby'         => 'count',
		'count'           => '40',
		'soft_limit'      => '5',
	);

	$facets[] = array(
		'name'            => 'news_usage',
		'label'           => '[News] usage',
		'type'            => 'checkboxes',
		'source'          => 'tax/article_usage',
		'parent_term'     => '',
		'modifier_type'   => 'off',
		'modifier_values' => '',
		'hierarchical'    => 'no',
		'show_expanded'   => 'no',
		'ghosts'          => 'yes',
		'preserve_ghosts' => 'yes',
		'operator'        => 'or',
		'orderby'         => 'count',
		'count'           => '10',
		'soft_limit'      => '5',
	);
if ( class_exists( 'FacetWP_Facet_Map_Addon' ) ) {
	$facets[] = array(
		'name'           => 'location_map',
		'label'          => '[Location]' . __( 'Map', 'strl' ),
		'type'           => 'map',
		'source'         => 'acf/location-address',
		'source_other'   => '',
		'map_design'     => 'default',
		'cluster'        => 'yes',
		'ajax_markers'   => 'no',
		'limit'          => 'all',
		'map_width'      => '100%',
		'map_height'     => '100%',
		'min_zoom'       => '1',
		'max_zoom'       => '18',
		'default_lat'    => '51.699269',
		'default_lng'    => '5.301752',
		'default_zoom'   => '7',
		'marker_content' => file_get_contents( ABSPATH . 'wp-content/themes/owc-multisite-theme/blocks/_global/location-marker-card.php' ),
	);
}
	$facets[] = array(
		'name'           => 'location_proximity',
		'label'          => '[Location] proximity',
		'type'           => 'proximity',
		'source'         => 'acf/location-address',
		'unit'           => 'km',
		'radius_ui'      => 'dropdown',
		'radius_options' => '5, 10, 15, 25, 50',
		'radius_min'     => '5',
		'radius_max'     => '50',
		'radius_default' => '5',
		'placeholder'    => __( 'Search location', 'strl' ),
	);

	$facets[] = array(
		'name'            => 'location_category',
		'label'           => '[Location] category',
		'type'            => 'checkboxes',
		'source'          => 'tax/location_category',
		'parent_term'     => '',
		'modifier_type'   => 'off',
		'modifier_values' => '',
		'hierarchical'    => 'yes',
		'show_expanded'   => 'no',
		'ghosts'          => 'yes',
		'preserve_ghosts' => 'yes',
		'operator'        => 'or',
		'orderby'         => 'count',
		'count'           => '-1',
		'soft_limit'      => '-1',
	);

	$facets[] = array(
		'name'            => 'location_neighborhood',
		'label'           => '[Location] neighborhood',
		'type'            => 'checkboxes',
		'source'          => 'tax/location_neighborhood',
		'parent_term'     => '',
		'modifier_type'   => 'off',
		'modifier_values' => '',
		'hierarchical'    => 'yes',
		'show_expanded'   => 'no',
		'ghosts'          => 'yes',
		'preserve_ghosts' => 'yes',
		'operator'        => 'or',
		'orderby'         => 'count',
		'count'           => '-1',
		'soft_limit'      => '-1',
	);

	return $facets;
}

function strl_hide_dropdown_count( $return, $params ) {
	if ( 'events_datefilter' == $params['facet']['name'] ) {
		$return = false;
	}
	return $return;
}

function strl_order_year_desc( $orderby, $facet ) {
	if ( 'events_datefilter' == $facet['name'] ) {
		$orderby = 'f.facet_value+0 DESC';
	}
	return $orderby;
}

function strl_date_as_year( $params, $class ) {
	if ( 'events_datefilter' === $params['facet_name'] ) { // change date_as_year to name of your facet
		$raw_value                     = $params['facet_value'];
		$params['facet_value']         = wp_date( '%Y %B', strtotime( $raw_value ) );
		$params['facet_display_value'] = wp_date( '%Y %B', strtotime( $raw_value ) );
		$params['facet_value']         = wp_date( 'Y m', strtotime( $raw_value ) );
		$params['facet_display_value'] = wp_date( 'F Y', strtotime( $raw_value ) );
	}
	return $params;
}

/**
 * Disable REST API for non-logged in users
 *
 * @param string $result
 * @return void
 */

function strl_disable_rest_api( $result ) {

	if ( true === $result || is_wp_error( $result ) ) {
		return $result;
	}

	if ( ! is_user_logged_in() ) {
		return new WP_Error(
			'rest_not_logged_in',
			__( 'You are not currently logged in.', 'strl' ),
			array( 'status' => 401 )
		);
	}

	return $result;
}

function strl_sort_search_results_by_date( $mods, $query ) {

		global $wpdb;

		$meta_key   = 'event-start-date';
		$post_types = array( 'event' );

	foreach ( $post_types as $post_type ) {
			$mod        = new \SearchWP\Mod();
			$alias      = \SearchWP::$index->get_alias();
			$meta_alias = 'my_searchwp_sort_' . $post_type;

			$mod->column_as(
				$wpdb->prepare(
					"(
			SELECT unix_timestamp(meta_value)
			FROM {$wpdb->postmeta}
			WHERE {$wpdb->postmeta}.post_id = {$alias}.id
				AND {$wpdb->postmeta}.meta_key = %s
			)",
					$meta_key
				),
				$meta_alias
			);
			$mod->order_by( "{$meta_alias} + 0", 'ASC', 2 );

			$mods[] = $mod;
	}

		return $mods;
}
