<?php
function strl_add_read_speaker( $has_offset = false ) {
	$show_read_speaker = ! empty( get_field( 'strl-global-read-speaker-toggle', 'options' ) ) ? get_field( 'strl-global-read-speaker-toggle', 'options' ) : false;
	if ( ! $show_read_speaker ) {
		return;
	}
	?>
	<!-- ReadSpeaker -->
	<div id="readspeaker_button1" class="strl-rs-btn rs_skip rsbtn rs_preserve bg-white <?php echo $has_offset ? 'has-offset' : ''; ?>">
		<a class="rsbtn_play" rel="nofollow" onclick="readpage(this.href, 'xp1'); return false;" title="<?php _e( 'Let ReadSpeaker Webreader read this text for you', 'strl' ); ?>" href="//app-eu.readspeaker.com/cgi-bin/rsent?customerid=4912&amp;lang=nl_nl&amp;readid=main&amp;url=<?php echo get_the_permalink(); ?>">
			<span class="rsbtn_left rsimg rspart"><span class="rsbtn_text"><span><?php echo __( 'Read aloud', 'strl' ); ?></span></span></span>
			<span class="rsbtn_right rsimg rsplay rspart"></span>
			<span class="screen-reader-text"><?php echo __( 'Read aloud', 'strl' ); ?></span>
		</a>
	</div>
	<!-- END ReadSpeaker -->
	<?php
}

function strl_limit_text( $text, $limit, $ellipsis = '...' ) {
	$text = strip_tags( $text );
	if ( str_word_count( $text, 0 ) > $limit ) {
		$words = str_word_count( $text, 2 );
		$pos   = array_keys( $words );
		$text  = substr( $text, 0, $pos[ $limit ] ) . $ellipsis;
	}
	return strip_tags( $text );
}

// Add the ID of the post to a prepended column.
$all_post_types = get_post_types( array( 'public' => true ), 'names' );
foreach ( $all_post_types as $post_type ) {
	add_action( 'manage_' . $post_type . 's_columns', 'strl_add_custom_columns', 5 );
	add_filter( 'manage_' . $post_type . 's_custom_column', 'strl_add_custom_columns_content', 5, 2 );
}

/**
 * Configures the main menu and assigns the Walker class for Foundation to it
 *
 * @package strl
 */
function strl_menu_main( $menuname ) {
	wp_nav_menu(
		array(
			'container'      => false,
			'menu'           => $menuname,
			'menu_class'     => 'vertical large-horizontal menu',
			'theme_location' => 'primary',
			'items_wrap'     => '<ul id="%1$s" class="%2$s" data-responsive-menu="accordion xlarge-dropdown" data-parent-link="false" data-submenu-toggle="true" data-back-button=\'<li class="js-drilldown-back"><a href="javascript:void(0);">Terug</a></li>\'>%3$s</ul>',
			'fallback_cb'    => false,
			'link_after'     => '<i class="fa-solid fa-chevron-down show-for-large"></i>',
			'walker'         => new STRL_DRILL_MENU_WALKER(),
		)
	);
}

/**
 * Adds pagination to WP Query's
 *
 * @package strl
 */
function pagination() {
	global $wp_query;
	$big            = 999999999;
	$paginate_links = paginate_links(
		array(
			'base'      => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
			'current'   => max( 1, get_query_var( 'paged' ) ),
			'total'     => $wp_query->max_num_pages,
			'mid_size'  => 5,
			'prev_next' => true,
			'prev_text' => __( '&laquo;', '' ),
			'next_text' => __( '&raquo;', '' ),
			'type'      => 'list',
		)
	);

	$paginate_links = str_replace( "<ul class='page-numbers'>", "<ul class='pagination'>", $paginate_links );

	// Display the pagination if more than one page is found
	if ( $paginate_links ) {
		echo '<div class="pagination-centered">';
		echo $paginate_links;
		echo '</div>';
	}
}

/**
 * Add custom column to show Post ID
 *
 * @package strl
 *
 * @param  array:<string> $columns An associative array of column headings.
 * @return array:<string> $columns The updated associative array.
 */
function strl_add_custom_columns( $columns ) {
	$checkbox      = array_slice( $columns, 0, 1 );
	$columns       = array_slice( $columns, 1 );
	$id['post_id'] = 'ID';
	$columns       = array_merge( $checkbox, $id, $columns );
	return $columns;
}

/**
 * Returns a default img markup.
 *
 * @package strl
 *
 * @param mixed $image The image array, ID or string returned by an ACF image field
 * @param string $classes The classes to add to the link
 * @param array  $attributes Attributes added to the <img> tag, key = attribute name, value = attribute value
 * @param string $desktop_size The desktop image size used by wp_get_attachment_image_src()
 * @param string $mobile_size The mobile image size used by wp_get_attachment_image_src()
 * @param string $img_alt Whether or not to enable an alt text to the image
 * @param string $img_title The title text for the title attribute of the image
 * @return mixed
 *
 * @example echo strl_image( $image, 'strl-large', 'strl-small', 'image extra-class', array( 'loading' => 'eager' ), false, 'image title' );
 */
function strl_image( mixed $image, string $desktop_size = 'strl-medium', string $mobile_size = 'strl-small', string $classes = '', array $attributes = array(), bool $img_alt = true, string $img_title = '', string $tablet_size = 'strl-tablet' ): mixed {
	if ( empty( $image ) ) {
		return '';
	}

	switch ( $image ) {
		case is_array( $image ) && ! empty( $image['ID'] ):
			$image_id = $image['ID'];
			break;
		case is_numeric( $image ):
			$image_id = $image;
			break;
		default:
			$image_id = attachment_url_to_postid( $image );
	}

	if ( empty( wp_get_attachment_image( $image_id ) ) ) {
		return '';
	}

	$desktop_src = wp_get_attachment_image_src( $image_id, $desktop_size )[0];
	$tablet_src  = wp_get_attachment_image_src( $image_id, $tablet_size )[0];
	$mobile_src  = wp_get_attachment_image_src( $image_id, $mobile_size )[0];

	if ( ! empty( $img_alt ) ) {
		$img_alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
	} else {
		$img_alt = '';
	}

	$attr = array();

	if ( ! empty( $attributes ) ) {
		foreach ( $attributes as $key => $value ) {
			$attr[] = $key . '="' . $value . '"';
		}
	}

	ob_start();
	?>
	<picture>
		<source srcset="<?php echo $desktop_src; ?>" media="(min-width: 1025px)"/>
		<source srcset="<?php echo $tablet_src; ?>" media="(min-width: 680px)"/>
		<img
			src="<?php echo $mobile_src; ?>"
			<?php
			echo ! empty( $img_alt ) ? ' alt="' . $img_alt . '"' : ' alt=""';
			echo ! empty( $classes ) ? ' class="' . $classes . '"' : '';
			echo ! empty( $img_title ) ? ' title="' . $img_title . '"' : '';
			echo ! empty( $attr ) ? ' ' . implode( ' ', $attr ) : '';
			?>
		>
	</picture>
	<?php
	return ob_get_clean();
}

/**
 * Does all the breadcrumbs checks
 *
 * @package strl
 *
 * @param  string $breadcrumbs The value of the breadcrumbs option ('show' or not)
 */
function strl_include_breadcrumbs( $post_id, $breadcrumbs_toggle = '0' ) {
	if ( '1' !== $breadcrumbs_toggle ) {
		return;
	}

	$breadcrumbs   = get_field( 'breadcrumbs-group_breadcrumbs', $post_id );
	$home_url      = get_home_url();
	$current_title = get_the_title( $post_id );
	?>
		<div class="breadcrumbs-bar">
			<div class="grid-x grid-margin-x">
				<div class="cell">
					<div class="breadcrumbs">
						<a href="<?php echo $home_url; ?>" class="home-url"><?php _e( 'Home', 'strl' ); ?></a>
						<span class="divider"><i class="fa-regular fa-chevron-right"></i></span>
						<?php
						if ( ! empty( $breadcrumbs ) ) {
							foreach ( $breadcrumbs as $breadcrumb ) {
								$title = get_the_title( $breadcrumb['page'][0] );
								$link  = get_the_permalink( $breadcrumb['page'][0] );
								?>
								<a href="<?php echo $link; ?>" class="breadcrumb-item"><?php echo $title; ?></a>
								<span class="divider"><i class="fa-regular fa-chevron-right"></i></span>
								<?php
							}
						}
						?>
						<span class="current-item"><?php echo $current_title; ?></span>
					</div>
				</div>
			</div>
		</div>
	<?php
}

/**
 * Adds the Post ID to the custom Post ID column
 *
 * @package strl
 *
 * @param string $column  The name of the column to edit.
 * @param int    $id      The current post ID.
 */
function strl_add_custom_columns_content( $column, $id ) {
	if ( 'post_id' === $column ) {
		echo $id;
	}
}


/**
 * Returns an array with ACF fields for Search Settings
 *
 * @package strl
 *
 * @return array:<string> $search_settings_fields All Search Settings fields
 */
function strl_get_search_settings_fields() {
	$post_id = isset( $_GET['post'] ) ? $_GET['post'] : '';
	if ( is_array( $post_id ) ) {
		return;
	}
	$nonce = wp_create_nonce( 'facetwp_reindex_nonce' );
	$link  = admin_url( 'admin-ajax.php?action=strl_facetwp_reindex&post_id=' . $post_id . '&nonce=' . $nonce );

	$search_settings_fields = array(
		array(
			'key'   => 'field_search_content',
			'label' => __( 'Search Content', 'strl' ),
			'name'  => 'search-content',
			'type'  => 'textarea',
		),
		array(
			'key'          => 'field_search_tags',
			'label'        => __( 'Search words', 'strl' ),
			'name'         => 'search-tags',
			'type'         => 'text',
			'instructions' => __( 'Give words extra weight in the internal search engine. Seperate by comma\'s.', 'strl' ),
		),
		array(
			'key'      => 'field_search_exclude',
			'label'    => __( 'Exclude this page from searchresults', 'strl' ),
			'name'     => 'search-exclude',
			'type'     => 'radio',
			'required' => 1,
			'default'  => false,
			'choices'  => array(
				false => __( 'Show', 'strl' ),
				true  => __( 'Don\t show', 'strl' ),
			),
		),
		array(
			'key'          => 'field_search_reindex',
			'label'        => __( 'Re-index all pages', 'strl' ),
			'name'         => 'search-re-index',
			'type'         => 'message',
			'instructions' => __( 'After you have made changes in this tab, hit re-index.', 'strl' ),
			'message'      => '<a class="button button-primary button-large" id="re-index" data-nonce="' . $nonce . '" data-post_id="' . $post_id . '" href="' . $link . '">Re-index</a>',
		),
	);

	return $search_settings_fields;
}

/**
 * Returns an array with all images sizes as strings
 *
 * @package strl
 *
 * @return array<string> $image_sizes All registered image sizes
 */
function strl_get_all_image_sizes() {
	global $_wp_additional_image_sizes;
	$default_image_sizes = get_intermediate_image_sizes();

	foreach ( $default_image_sizes as $size ) {
		$image_sizes[ $size ]['width']  = intval( get_option( "{$size}_size_w" ) );
		$image_sizes[ $size ]['height'] = intval( get_option( "{$size}_size_h" ) );
		$image_sizes[ $size ]['crop']   = get_option( "{$size}_crop" ) ? get_option( "{$size}_crop" ) : false;
	}

	if ( isset( $_wp_additional_image_sizes ) && count( $_wp_additional_image_sizes ) ) {
		$image_sizes = array_merge( $image_sizes, $_wp_additional_image_sizes );
	}

	return $image_sizes;
}

/**
 * Returns the ID of the primary category or false if none found
 *
 * @package strl
 *
 * @param  integer  $post_id       The ID of the post for which you want the primary category
 * @param  string   $taxonomy_name The taxonomy for which you want the primary one, defaults to 'category'
 * @return mixed $category      Returns the ID of the primary category or false if none found
 */
function strl_get_primary_category( $post_id = 0, $taxonomy_name = 'category' ) {
	if ( class_exists( 'WPSEO_Primary_Term' ) ) {
		$category = new WPSEO_Primary_Term( $taxonomy_name, $post_id );
		$cat_id   = $category->get_primary_term();
		if ( false !== $cat_id ) {
			$category = get_term( $cat_id, $taxonomy_name );
			if ( ! empty( $category ) ) {
				return $category;
			}
		}
	}

	$categories = get_the_terms( $post_id, $taxonomy_name );
	if ( ! empty( $categories ) ) {
		return current( $categories );
	}

	return false;
}

/**
 * Gets the order value of a single block
 *
 * @package strl
 *
 * @param  string  $blockname    The name of the block for which you want the order value
 * @param  integer $post_id      The ID of the post where the block you want to target is on
 * @return int     $field_order  The value of the block's order
 */
function strl_get_block_order_value( $block_name = '', $post_id = 0 ) {
	if ( empty( $post_id ) ) {
		$post_id = get_the_ID();
	}

	$blocks = get_post_meta( $post_id, 'blocks', true );

	if ( empty( $blocks ) ) {
		return;
	}

	$field_order = array_search( $block_name, $blocks, true );

	return $field_order;
}

/**
 * Gets the ID of the standard page for e.g. 404, search, etc.
 *
 * @package strl
 *
 * @param  string $page  The page you want to get the default page for (e.g. 404, search)
 * @return int    $page  Returns the ID of the default page
 */
function strl_get_default_page_for( $page = '' ) {
	$page = get_option( 'options_page-' . $page ) ? get_option( 'options_page-' . $page ) : 0;
	return $page;
}

/**
 * A more readable var_dump
 *
 * @package strl
 *
 * @param mixed $param The thing you'd like to dump
 */
function strl_dump( $param = '' ) {
	echo '<pre>';
	var_dump( $param );
	echo '</pre>';
}
function strl_print( $param = '' ) {
	echo '<pre>';
	print_r( $param );
	echo '</pre>';
}

/**
 * Registers a new CPT
 *
 * @package strl
 *
 * @param string         $name     A name (singular) for the post type you want to register
 * @param array<mixed>   $options  Options for the post type (e.g. slug, labels, args)
 */
function strl_register_post_type( $name = '', $options = array() ) {
	if ( empty( $name ) && ! is_array( $options ) ) {
		return '';
	}

	$slug          = isset( $options['slug'] ) ? $options['slug'] : $name;
	$slug          = ! empty( get_option( $name . '_cpt_base' ) ) ? get_option( $name . '_cpt_base' ) : $slug;
	$singular      = isset( $options['singular'] ) ? $options['singular'] : '';
	$plural        = isset( $options['plural'] ) ? $options['plural'] : '';
	$custom_labels = isset( $options['labels'] ) && is_array( $options['labels'] ) ? $options['labels'] : array();
	$custom_args   = isset( $options['args'] ) && is_array( $options['args'] ) ? $options['args'] : array();

	$labels = array(
		'name'               => $plural,
		'singular_name'      => $singular,
		'menu_name'          => $plural,
		'name_admin_bar'     => $singular,
		// translators: %s post type singular label
		'add_new'            => sprintf( __( 'Add %s', 'strl' ), $singular ),
		// translators: %s post type singular label
		'add_new_item'       => sprintf( __( 'Add New %s', 'strl' ), $singular ),
		// translators: %s post type singular label
		'new_item'           => sprintf( __( 'New %s', 'strl' ), $singular ),
		// translators: %s post type singular label
		'edit_item'          => sprintf( __( 'Edit %s', 'strl' ), $singular ),
		// translators: %s post type singular label
		'view_item'          => sprintf( __( 'View %s', 'strl' ), $singular ),
		// translators: %s post type plural label
		'all_items'          => sprintf( __( 'All %s', 'strl' ), $plural ),
		// translators: %s post type plural label
		'search_items'       => sprintf( __( 'Search %s', 'strl' ), $plural ),
		// translators: %s post type plural label
		'parent_item_colon'  => sprintf( __( 'Parent %s:', 'strl' ), $plural ),
		// translators: %s post type plural label
		'not_found'          => sprintf( __( 'No %s found.', 'strl' ), $plural ),
		// translators: %s post type plural label
		'not_found_in_trash' => sprintf( __( 'No %s found in Trash.', 'strl' ), $plural ),
	);

	if ( is_array( $custom_labels ) ) {
		$labels = array_merge( $labels, $custom_labels );
	}

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'show_in_nav_menus'  => true,
		'show_in_admin_bar'  => true,
		'query_var'          => true,
		'show_in_rest'       => true,
		'rewrite'            => array( 'slug' => $slug ),
		'has_archive'        => false,
		'hierarchical'       => false,
		'menu_icon'          => 'dashicons-welcome-widgets-menus',
		'taxonomies'         => array(),
		'supports'           => array( 'title', 'author', 'thumbnail', 'revisions', 'excerpt' ),
	);

	if ( is_array( $custom_args ) ) {
		$args = array_merge( $args, $custom_args );
	}

	return register_post_type( $name, $args );
}

/**
 * Returns all CPTs as an array with strings
 *
 * @package strl
 *
 * @param  array<string> $excluded_post_types Post types you want to exclude
 * @return array<string> All post types (except for the excluded ones)
 */
function strl_get_all_cpts( $excluded_post_types = array() ) {
	$post_types = get_post_types(
		array(
			'public' => true,
		),
		'names'
	);

	// Excludes default post types
	$exclude_post_types = array(
		'post',
		'page',
		'attachment',
	);

	foreach ( $exclude_post_types as $exclude_post_type ) {
		unset( $post_types[ $exclude_post_type ] );
	}

	if ( $excluded_post_types ) {
		foreach ( $excluded_post_types as $excluded_post_type ) {
			unset( $post_types[ $excluded_post_type ] );
		}
	}

	return $post_types;
}

/**
 * Adds setting fields for CTP slugs so you can translate them
 *
 * @package strl
 */
function strl_cpt_load_permalinks() {
	$custom_post_types = strl_get_all_cpts();

	foreach ( $custom_post_types as $post_type ) {
		if ( isset( $_POST[ $post_type . '_cpt_base' ] ) ) {
			update_option( $post_type . '_cpt_base', sanitize_title_with_dashes( $_POST[ $post_type . '_cpt_base' ] ) );
		}

		// translators: %s = custom post type base name
		add_settings_field( $post_type . '_cpt_base', sprintf( __( '%s base', 'strl' ), ucfirst( $post_type ) ), 'strl_cpt_field_callback', 'permalink', 'optional', $post_type );
	}
}

/**
 * Creates the setting field for the permalink setting for CPTs
 *
 * @package strl
 */
function strl_cpt_field_callback( $post_type ) {
	${ $post_type . '_cpt_base'} = get_option( $post_type . '_cpt_base' );
	echo '<input type="text" value="' . esc_attr( ${$post_type . '_cpt_base'} ) . '" name="' . $post_type . '_cpt_base" id="' . $post_type . '_cpt_base" class="regular-text" />';
}

/**
 * Registers a new taxonomy
 *
 * @package strl
 *
 * @param string        $name     A name (singular) for the taxonomy you want to register
 * @param array<mixed>  $options  Options for the taxonomy (e.g. capabilities, labels, args)
 */
function strl_register_taxonomy( $slug = '', $post_type = array(), $options = array() ) {
	if ( empty( $slug ) && empty( $post_type ) && ! is_array( $options ) ) {
		return '';
	}

	$singular            = isset( $options['singular'] ) ? $options['singular'] : '';
	$plural              = isset( $options['plural'] ) ? $options['plural'] : '';
	$custom_labels       = isset( $options['labels'] ) && is_array( $options['labels'] ) ? $options['labels'] : array();
	$custom_capabilities = isset( $options['capabilities'] ) && is_array( $options['capabilities'] ) ? $options['capabilities'] : array();
	$custom_args         = isset( $options['args'] ) && is_array( $options['args'] ) ? $options['args'] : array();
	$rewrite             = isset( $options['rewrite'] ) && is_array( $options['rewrite'] ) ? $options['rewrite'] : array( 'slug' => $slug );

	$labels = array(
		'name'              => $plural,
		'singular_name'     => $singular,
		// translators: %s taxonomy plural label
		'search_items'      => sprintf( __( 'Search %s', 'strl' ), $plural ),
		// translators: %s taxonomy plural label
		'all_items'         => sprintf( __( 'All %s', 'strl' ), $plural ),
		// translators: %s taxonomy plural label
		'parent_item'       => sprintf( __( 'Parent %s', 'strl' ), $plural ),
		// translators: %s taxonomy plural label
		'parent_item_colon' => sprintf( __( 'Parent %s:', 'strl' ), $plural ),
		// translators: %s taxonomy singular label
		'edit_item'         => sprintf( __( 'Edit %s', 'strl' ), $singular ),
		// translators: %s taxonomy singular label
		'add_new_item'      => sprintf( __( 'Add New %s', 'strl' ), $singular ),
		// translators: %s taxonomy singular label
		'update_item'       => sprintf( __( 'Update %s', 'strl' ), $singular ),
		// translators: %s taxonomy singular label
		'new_item_name'     => sprintf( __( 'New %s name', 'strl' ), $singular ),
		'menu_name'         => $plural,
	);

	if ( is_array( $custom_labels ) ) {
		$labels = array_merge( $labels, $custom_labels );
	}

	$args = array(
		'labels'            => $labels,
		'description'       => '',
		'hierarchical'      => true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'show_in_rest'      => true,
		'rewrite'           => $rewrite,
	);

	if ( is_array( $custom_args ) ) {
		$args = array_merge( $args, $custom_args );
	}

	if ( is_array( $custom_capabilities ) ) {
		$args = array_merge( $args, $custom_capabilities );
	}

	add_action( $slug . '_pre_add_form', 'strl_add_tax_description_to_admin' );

	return register_taxonomy( $slug, $post_type, $args );
}

/**
 * Adds taxonomy description to admin
 *
 * @package strl
 *
 * @param string $taxonomy_slug  The slug for the taxonomy (e.g. 'category', 'region')
 */
function strl_add_tax_description_to_admin( $taxonomy_slug ) {
	$taxonomy_object    = get_taxonomy( $taxonomy_slug );
	$description_exists = property_exists( $taxonomy_object, 'description' );

	if ( $description_exists ) {
		echo '<h2>' . __( 'Description', 'strl' ) . '</h2>';
		echo apply_filters( 'the_content', $taxonomy_object->description );
	}
}

/**
 * Returns an array with all Social Media ACF Fields
 *
 * @package strl
 *
 * @param array<mixed>  $acf_fields_array   The field group you want to add the fields to
 * @param array<string> $social_media_names E.g. array( 'facebook', 'twitter' )
 * @return array<mixed> $acf_fields_array   The input array with the Socials Fields added onto it
 */
function strl_add_socials_acf_fields( $acf_fields_array, $social_media_names ) {
	$strl_global_social_tab = array(
		'key'       => 'field_social_media_links',
		'label'     => __( 'Social Media Links', 'strl' ),
		'type'      => 'tab',
		'placement' => 'left',
	);
	array_push( $acf_fields_array, $strl_global_social_tab );

	foreach ( $social_media_names as $social_media_name ) {
		$pretty_name = ucwords( $social_media_name );

		switch ( $pretty_name ) {
			case 'Youtube':
				$pretty_name = 'YouTube';
				break;
			case 'Linkedin':
				$pretty_name = 'LinkedIn';
				break;
			case 'Rss':
				$pretty_name = 'RSS';
				break;
		}

		$social_media_field = array(
			'key'          => 'field_' . $social_media_name,
			'label'        => $pretty_name,
			'name'         => 'social-' . $social_media_name,
			'type'         => 'link',
			// translators: %1$s: socialname capitalized, %2$s: socialname lowercase
			'instructions' => sprintf( __( 'Enter the link to your %1$s page.<br />You can retrieve this link by using the shortcode: <strong>[sociallink social="%2$s"]</strong>', 'strl' ), $pretty_name, $social_media_name ),
			'placeholder'  => 'https://www.' . $social_media_name . '.com/XXXXXX',
		);

		array_push( $acf_fields_array, $social_media_field );
	}

	array_push(
		$acf_fields_array,
		array(
			'key'          => 'field_phone',
			'label'        => __( 'Phone', 'strl' ),
			'name'         => 'social-phone',
			'type'         => 'text',
			// translators: %1$s: socialname capitalized, %2$s: socialname lowercase
			'instructions' => __( 'You can retrieve this value by using the shortcode: <strong>[sociallink social="phone"]</strong>', 'strl' ),
			'placeholder'  => '+31200000000',
		)
	);

	array_push(
		$acf_fields_array,
		array(
			'key'          => 'field_email',
			'label'        => __( 'Email', 'strl' ),
			'name'         => 'social-email',
			'type'         => 'text',
			// translators: %1$s: socialname capitalized, %2$s: socialname lowercase
			'instructions' => __( 'You can retrieve this value by using the shortcode: <strong>[sociallink social="email"]</strong>', 'strl' ),
			'placeholder'  => 'info@email.com',
		)
	);

	return $acf_fields_array;
}

/**
 * Adds the Standard Pages tab to STRL Global
 *
 * @package strl
 *
 * @param array<mixed>  $acf_fields_array  The field group you want to add the fields to
 * @param array<string> $cpt_names         E.g. array( 'example', 'testimonial' )
 * @return array<mixed> $acf_fields_array  The input array with the CPT Archive Fields added onto it
 */
function strl_add_cpt_archive_acf_fields( $acf_fields_array, $cpt_names ) {
	$strl_global_standard_pages_tab = array(
		'key'       => 'field_strl_global_standard',
		'label'     => __( 'Standard pages', 'strl' ),
		'type'      => 'tab',
		'placement' => 'left',
	);

	array_push( $acf_fields_array, $strl_global_standard_pages_tab );

	$strl_global_standard_404 = array(
		'key'           => 'field_strl_global_404',
		'label'         => __( '404 page', 'strl' ),
		'name'          => 'page-not-found',
		'type'          => 'post_object',
		'post_type'     => array(
			0 => 'page',
		),
		'return_format' => 'id',
		'ui'            => 1,
	);

	array_push( $acf_fields_array, $strl_global_standard_404 );

	$strl_global_standard_search = array(
		'key'           => 'field_strl_global_search',
		'label'         => __( 'Search page', 'strl' ),
		'name'          => 'page-search',
		'type'          => 'post_object',
		'post_type'     => array(
			0 => 'page',
		),
		'return_format' => 'id',
		'ui'            => 1,
	);

	array_push( $acf_fields_array, $strl_global_standard_search );

	foreach ( $cpt_names as $cpt_name ) {
		$pretty_name = ucwords( $cpt_name );

		$cpt_archive_field = array(
			'key'           => 'field_' . $cpt_name,
			'label'         => $pretty_name . ' ' . __( 'Archive', 'strl' ),
			'name'          => 'page-' . $cpt_name,
			'type'          => 'post_object',
			'instructions'  => __( 'Choose the default archive page for', 'strl' ) . ' ' . $pretty_name,
			'post_type'     => array(
				0 => 'page',
			),
			'return_format' => 'id',
			'ui'            => 1,
		);

		array_push( $acf_fields_array, $cpt_archive_field );
	}
	return $acf_fields_array;
}

/**
 * Used for sorting blocks
 *
 * @param array $a Block to sort
 * @param array $b Block to sort
 * @return void
 */
function strl_sort( $a, $b ) {
	if ( key_exists( 'order', $a ) && key_exists( 'order', $b ) ) {
		return $a['order'] - $b['order'];
	} else {
		return;
	}
}

/**
 * Returns an array with standard fields for CPTs
 *
 * @package strl
 *
 * @return array<mixed> $acf_fields_array The array with the CPT Fields
 */
function strl_get_cpt_acf_fields( $post_type = '' ) {

	$search_settings_fields = strl_get_search_settings_fields();
	$layouts                = array();
	$blocksdir              = THEME_DIR . '/blocks';
	$blocks                 = array_diff( scandir( $blocksdir ), array( '..', '.' ) );

	foreach ( $blocks as $block ) {
		if ( is_dir( "$blocksdir/$block" ) ) {
			$acffile = "$blocksdir/$block/acf.php";
			if ( file_exists( $acffile ) ) {
				include $acffile;
			}
		}
	}

	usort( $layouts, 'strl_sort' );

	$strl_block_fields = array(
		array(
			'key'       => 'field_blocks_tab',
			'label'     => __( 'Content', 'strl' ),
			'type'      => 'tab',
			'placement' => 'top',
		),
		array(
			'key'          => 'field_blocks',
			'label'        => __( 'Blocks', 'strl' ),
			'name'         => 'blocks',
			'type'         => 'flexible_content',
			'layouts'      => $layouts,
			'button_label' => __( 'Add new block', 'strl' ),
		),
		array(
			'key'       => 'field_settings_tab',
			'label'     => __( 'Search Engine Settings', 'strl' ),
			'type'      => 'tab',
			'placement' => 'top',
		),
		array(
			'key'        => 'field_search_group',
			'label'      => __( 'Search Engine Settings', 'strl' ),
			'name'       => 'search-group',
			'type'       => 'group',
			'sub_fields' => $search_settings_fields,
		),
		array(
			'key'       => 'field_general_settings_tab',
			'label'     => __( 'Settings', 'strl' ),
			'type'      => 'tab',
			'placement' => 'top',
		),
		array(
			'key'        => 'field_general_settings',
			'label'      => __( 'Settings', 'strl' ),
			'name'       => 'settings-group',
			'type'       => 'group',
			'placement'  => 'top',
			'sub_fields' => array(
				array(
					'key'           => 'field_page_footer_cta',
					'label'         => __( 'Show footer CTA?', 'strl' ),
					'name'          => 'cpt-footer-cta',
					'type'          => 'radio',
					'instructions'  => __( 'You can edit the content of each CTA in STRL Global > CTA', 'strl' ),
					'required'      => 1,
					'default_value' => '1',
					'choices'       => array(
						'false' => __( 'Hide CTA', 'strl' ),
						'1'     => __( get_field( 'strl-global-cta-content-1', 'option' ), 'strl' ),
						'2'     => __( get_field( 'strl-global-cta-content-2', 'option' ), 'strl' ),
						'3'     => __( get_field( 'strl-global-cta-content-3', 'option' ), 'strl' ),
					),
				),
				array(
					'key'   => 'field_page_excerpt_content',
					'label' => __( 'Excerpt', 'strl' ),
					'name'  => 'post-excerpt-content',
					'type'  => 'textarea',
				),
				array(
					'key'   => 'field_page_notes_content',
					'label' => __( 'Notes', 'strl' ),
					'name'  => 'post-notes-content',
					'type'  => 'textarea',
				),
				array(
					'key'          => 'field_page_feature_image',
					'label'        => __( 'Featured Image', 'strl' ),
					'name'         => 'post-featured-image',
					'type'         => 'image',
					'instructions' => __( 'Ideal minimal size is 1600x800', 'strl' ),
				),
			),
		),
		array(
			'key'       => 'field_breadcrumbs_tab',
			'label'     => __( 'Breadcrumbs settings', 'strl' ),
			'type'      => 'tab',
			'placement' => 'top',
		),
		array(
			'key'        => 'field_breadcrumbs_group',
			'label'      => __( 'Breadcrumbs Settings', 'strl' ),
			'name'       => 'breadcrumbs-group',
			'type'       => 'group',
			'sub_fields' => array(
				array(
					'key'           => 'field_breadcrumbs_toggle',
					'label'         => __( 'Do you want to show breadcrumbs?', 'strl' ),
					'name'          => 'breadcrumbs-toggle',
					'type'          => 'radio',
					'required'      => 1,
					'choices'       => array(
						'0' => __( 'No', 'strl' ),
						'1' => __( 'Yes', 'strl' ),
					),
					'default_value' => 'hide',
					'layout'        => 'horizontal',
					'return_format' => 'value',
				),
				array(
					'key'               => 'field_breadcrumbs_repeater',
					'label'             => __( 'Breadcrumbs', 'strl' ),
					'name'              => 'breadcrumbs',
					'type'              => 'repeater',
					'layout'            => 'table',
					'instructions'      => __( 'You don\'t need to select the homepage and the current item. These will be included via code.', 'strl' ),
					'button_label'      => __( 'Add breadcrumb', 'strl' ),
					'conditional_logic' => array(
						array(
							array(
								'field'    => 'field_breadcrumbs_toggle',
								'operator' => '==',
								'value'    => '1',
							),
						),
					),
					'sub_fields'        => array(
						array(
							'key'           => 'field_breadcrumbs_page',
							'label'         => __( 'Select page', 'strl' ),
							'name'          => 'page',
							'type'          => 'relationship',
							'max'           => 1,
							'required'      => 1,
							'post_type'     => array(
								0 => 'page',
								1 => 'article',
								2 => 'event',
								3 => 'councillor',
							),
							'filters'       => array(
								0 => 'search',
								1 => 'post_type',
							),
							'elements'      => array(),
							'return_format' => 'id',
						),
					),
				),
			),
		),
	);

	$contact_content_fields = array(
		array(
			'key'       => 'field_blocks_tab',
			'label'     => __( 'Content', 'strl' ),
			'type'      => 'tab',
			'placement' => 'top',
		),
		array(
			'key'               => 'field_60f6cbf6708bc',
			'label'             => 'Tekst',
			'name'              => 'alert-text',
			'aria-label'        => '',
			'type'              => 'textarea',
			'instructions'      => '',
			'required'          => 0,
			'conditional_logic' => 0,
			'default_value'     => '',
			'placeholder'       => '',
			'maxlength'         => '',
			'new_lines'         => '',
		),
		array(
			'key'               => 'field_60f6cc18708bd',
			'label'             => 'Paginalink',
			'name'              => 'alert-link',
			'aria-label'        => '',
			'type'              => 'link',
			'instructions'      => '',
			'required'          => 0,
			'conditional_logic' => 0,
			'wrapper'           => array(
				'width' => '',
				'class' => '',
				'id'    => '',
			),
			'return_format'     => 'array',
		),
	);

	$counsillor_content_fields = array(
		array(
			'key'       => 'field_blocks_tab',
			'label'     => __( 'Content', 'strl' ),
			'type'      => 'tab',
			'placement' => 'top',
		),
		array(
			'key'   => 'field_counsillor_function_title',
			'label' => __( 'Function title', 'strl' ),
			'name'  => 'counsillor-function-title',
			'type'  => 'text',
		),
		array(
			'key'      => 'field_counsillor_region',
			'label'    => __( 'Region', 'strl' ),
			'name'     => 'counsillor-region',
			'type'     => 'text',
			'required' => 0,
		),
		array(
			'key'   => 'field_counsillor_phone',
			'label' => __( 'Phone', 'strl' ),
			'name'  => 'counsillor-phone',
			'type'  => 'text',
		),
		array(
			'key'          => 'field_counsillor_functions_title',
			'label'        => __( 'Functions title', 'strl' ),
			'name'         => 'counsillor-functions-title',
			'type'         => 'text',
			'instructions' => __( 'For example functions or portfolio ', 'strl' ),
		),
		array(
			'key'        => 'field_councillor_functions',
			'label'      => __( 'Functions', 'strl' ),
			'name'       => 'councillor-functions',
			'type'       => 'repeater',
			'layout'     => 'table',
			'required'   => 0,
			'sub_fields' => array(
				array(
					'key'   => 'field_function_text',
					'label' => __( 'Function', 'strl' ),
					'name'  => 'councillor-function',
					'type'  => 'text',
				),
			),
		),
		// array(
		//  'key'        => 'field_councillor_portfolio',
		//  'label'      => __( 'Portfolio', 'strl' ),
		//  'name'       => 'councillor-portfolio',
		//  'type'       => 'repeater',
		//  'layout'     => 'table',
		//  'required'   => 0,
		//  'sub_fields' => array(
		//      array(
		//          'key'   => 'field_portfolio_text',
		//          'label' => __( 'Portfolio item', 'strl' ),
		//          'name'  => 'councillor-portfolio',
		//          'type'  => 'text',
		//      ),
		//  ),
		// ),
		array(
			'key'          => 'field_counsillor_description',
			'label'        => __( 'Description (optional)', 'strl' ),
			'name'         => 'counsillor-description',
			'type'         => 'wysiwyg',
			'tabs'         => 'all',
			'toolbar'      => 'modern',
			'media_upload' => 1,
			'delay'        => 1,
		),
		array(
			'key'   => 'field_counsillor_email',
			'label' => __( 'Email', 'strl' ),
			'name'  => 'counsillor-email',
			'type'  => 'text',
		),
		array(
			'key'   => 'field_counsillor_twitter',
			'label' => __( 'Twitter', 'strl' ),
			'name'  => 'counsillor-twitter',
			'type'  => 'text',
		),
		array(
			'key'   => 'field_counsillor_linkedin',
			'label' => __( 'LinkedIn', 'strl' ),
			'name'  => 'counsillor-linkedin',
			'type'  => 'text',
		),
		array(
			'key'   => 'field_counsillor_facebook',
			'label' => __( 'Facebook', 'strl' ),
			'name'  => 'counsillor-facebook',
			'type'  => 'text',
		),
		array(
			'key'   => 'field_counsillor_instagram',
			'label' => __( 'Instagram', 'strl' ),
			'name'  => 'counsillor-instagram',
			'type'  => 'text',
		),
		array(
			'key'          => 'field_blocks',
			'label'        => __( 'Blocks', 'strl' ),
			'name'         => 'blocks',
			'type'         => 'flexible_content',
			'layouts'      => $layouts,
			'button_label' => __( 'Add new block', 'strl' ),
		),
	);

	$faq_content_fields = array(
		array(
			'key'       => 'field_cpt_content_tab',
			'label'     => __( 'CPT Content', 'strl' ),
			'type'      => 'tab',
			'placement' => 'top',
		),
		array(
			'key'          => 'field_faq_text',
			'label'        => __( 'Text', 'strl' ),
			'name'         => 'faq-text',
			'type'         => 'wysiwyg',
			'required'     => 1,
			'tabs'         => 'all',
			'toolbar'      => 'modern',
			'media_upload' => 1,
			'delay'        => 1,
		),
	);

	$article_fields = array(
		array(
			'key'       => 'field_cpt_article_tab',
			'label'     => __( 'Article', 'strl' ),
			'type'      => 'tab',
			'placement' => 'top',
		),
		array(
			'key'           => 'field_article_image',
			'label'         => __( 'Header image', 'strl' ),
			'name'          => 'article-image',
			'type'          => 'image',
			'return_format' => 'ID',
			'required'      => 1,
		),
		array(
			'key'     => 'field_article_content',
			'label'   => __( 'Content', 'strl' ),
			'name'    => 'article-content',
			'type'    => 'wysiwyg',
			'toolbar' => 'modern',
		),
		array(
			'key'          => 'field_article_downloads',
			'label'        => __( 'Add downloads', 'strl' ),
			'name'         => 'article-downloads',
			'type'         => 'repeater',
			'layout'       => 'block',
			'button_label' => __( 'Add download', 'strl' ),
			'sub_fields'   => array(
				array(
					'key'   => 'field_article_downloads_download',
					'label' => __( 'Download', 'strl' ),
					'name'  => 'download',
					'type'  => 'file',
				),
			),
		),
		array(
			'key'          => 'field_article_links',
			'label'        => __( 'Add links', 'strl' ),
			'name'         => 'article-links',
			'type'         => 'repeater',
			'layout'       => 'block',
			'button_label' => __( 'Add links', 'strl' ),
			'sub_fields'   => array(
				array(
					'key'   => 'field_article_links_link',
					'label' => __( 'Link', 'strl' ),
					'name'  => 'link',
					'type'  => 'link',
				),
			),
		),
	);

	$event_content_fields = array(
		array(
			'key'       => 'field_event_settings_tab',
			'label'     => __( 'Event Settings', 'strl' ),
			'type'      => 'tab',
			'placement' => 'top',
		),
		array(
			'key'            => 'field_event_start_date',
			'label'          => __( 'Starting Date', 'strl' ),
			'name'           => 'event-start-date',
			'type'           => 'date_time_picker',
			'required'       => 1,
			'display_format' => 'l d F Y H:i',
			'return_format'  => 'l d F Y H:i',
			'first_day'      => 1,
		),
		array(
			'key'            => 'field_event_end_date',
			'label'          => __( 'Ending Date', 'strl' ),
			'name'           => 'event-end-date',
			'type'           => 'date_time_picker',
			'required'       => 0,
			'display_format' => 'l d F Y H:i',
			'return_format'  => 'l d F Y H:i',
			'first_day'      => 1,
		),
	);

	$strl_publication_fields = array(
		array(
			'key'       => 'field_publication_content_tab',
			'label'     => __( 'Publication content', 'strl' ),
			'type'      => 'tab',
			'placement' => 'top',
		),
		array(
			'key'            => 'field_publication_date',
			'label'          => __( 'Publication date', 'strl' ),
			'name'           => 'publication-date',
			'type'           => 'date_time_picker',
			'required'       => 1,
			'display_format' => 'd-m-Y',
			'return_format'  => 'd-m-Y',
			'first_day'      => 1,
			'instructions'   => __( 'The date the publication was published. May differ from the publication date of this post. Will be used for the filters on the overview page.', 'strl' ),
			'wrapper'        => array(
				'width' => '60',
			),
		),
		array(
			'key'           => 'field_publication_single',
			'label'         => __( 'Does this publication have an single?', 'strl' ),
			'name'          => 'publication-single',
			'type'          => 'true_false',
			'message'       => __( 'Yes, this publication has a single page.', 'strl' ),
			'instructions'  => __( 'To make sure this page has no single, uncheck this option and only select one download!', 'strl' ),
			'default_value' => 1,
			'ui'            => 0,
			'wrapper'       => array(
				'width' => '40',
			),
		),
		array(
			'key'               => 'field_publication_external_url_singular',
			'label'             => __( 'External url', 'strl' ),
			'name'              => 'download-external-url',
			'type'              => 'url',
			'conditional_logic' => array(
				array(
					array(
						'field'    => 'field_publication_single',
						'operator' => '==',
						'value'    => '0',
					),
				),
			),
		),
		array(
			'key'          => 'field_publication_intro',
			'label'        => __( 'Intro', 'strl' ),
			'name'         => 'publication-intro',
			'type'         => 'textarea',
			'instructions' => __( 'This text will show in the header. To change/add text in the cards on the overview page go to "Page settings" tab and edit the "Excerpt" field.', 'strl' ),
		),
		array(
			'key'     => 'field_publication_content',
			'label'   => __( 'Content', 'strl' ),
			'name'    => 'publication-content',
			'type'    => 'wysiwyg',
			'toolbar' => 'modern',
		),
		array(
			'key'           => 'field_publication_contact_person',
			'label'         => __( 'Contact person', 'strl' ),
			'name'          => 'publication-contact-person',
			'instructions'  => __( 'Select the contact person for this publication. (Optional)', 'strl' ),
			'type'          => 'relationship',
			'post_type'     => array(
				0 => 'councillor',
			),
			'filters'       => array(
				0 => 'search',
			),
			'return_format' => 'id',
			'max'           => 1,
		),
		array(
			'key'               => 'fields_publication_downloads',
			'label'             => __( 'Downloads', 'strl' ),
			'name'              => 'publication-downloads',
			'type'              => 'repeater',
			'conditional_logic' => array(
				array(
					array(
						'field'    => 'field_publication_single',
						'operator' => '==',
						'value'    => '1',
					),
				),
			),
			'sub_fields'        => array(
				array(
					'key'           => 'field_publication_download_label',
					'label'         => __( 'Button label', 'strl' ),
					'name'          => 'label',
					'type'          => 'text',
					'return_format' => 'value',
				),
				array(
					'key'   => 'field_publication_download',
					'label' => __( 'Download', 'strl' ),
					'name'  => 'download',
					'type'  => 'file',
				),
			),
		),
		array(
			'key'               => 'field_publication_download_singular',
			'label'             => __( 'Download', 'strl' ),
			'name'              => 'download-singular',
			'type'              => 'file',
			'conditional_logic' => array(
				array(
					array(
						'field'    => 'field_publication_single',
						'operator' => '==',
						'value'    => '0',
					),
				),
			),
		),
	);

	$location_fields = array(
		array(
			'key'       => 'field_cpt_location_tab',
			'label'     => __( 'Location', 'strl' ),
			'type'      => 'tab',
			'placement' => 'top',
		),
		array(
			'key'   => 'field_location_address',
			'label' => __( 'Address', 'strl' ),
			'name'  => 'location-address',
			'type'  => 'google_map',
		),
		array(
			'key'          => 'field_location_description',
			'label'        => __( 'Description', 'strl' ),
			'name'         => 'location-description',
			'type'         => 'wysiwyg',
			'tabs'         => 'all',
			'toolbar'      => 'modern',
			'media_upload' => 0,
		),
	);

	$postid = ! empty( $_GET['post'] ) ? $_GET['post'] : '';
	// Removed flexible content for search template, current ID is 303
	if ( $postid === strl_get_default_page_for( 'search' ) ) {
		unset( $strl_block_fields[0] );
		unset( $strl_block_fields[1] );
	}

	switch ( $post_type ) {
		case 'alert':
			unset( $strl_block_fields[0] );
			unset( $strl_block_fields[1] );
			return array_merge( $contact_content_fields, $strl_block_fields );
			break;
		case 'event':
			return array_merge( $event_content_fields, $strl_block_fields );
			break;
		case 'councillor':
			unset( $strl_block_fields[0] );
			unset( $strl_block_fields[1] );
			return array_merge( $counsillor_content_fields, $strl_block_fields );
			break;
		case 'faq':
			return array_merge( $faq_content_fields );
			break;
		case 'article':
			unset( $strl_block_fields[0] );
			unset( $strl_block_fields[1] );
			$strl_block_fields = array_merge( $article_fields, $strl_block_fields );
			return $strl_block_fields;
			break;
		case 'publication':
			unset( $strl_block_fields[0] );
			unset( $strl_block_fields[1] );
			return array_merge( $strl_publication_fields, $strl_block_fields );
			break;
		case 'location':
			unset( $strl_block_fields[0] );
			unset( $strl_block_fields[1] );
			return array_merge( $location_fields, $strl_block_fields );
			break;
		default:
			return $strl_block_fields;
			break;
	}
}

/**
 * Sanitize phone number.
 * Allows only numbers and "+" (plus sign).
 *
 * @package strl
 * @param string $phone Phone number.
 * @return string
 */
function strl_sanitize_phone_number( $phone ) {
	return preg_replace( '/[^\d+]/', '', $phone );
}

/**
 * Check if webp file exists and swap original for webp
*/
function strl_do_webp_magic( $image ) {
	$smushurlpath = './wp-content/smush-webp/';
	$smushurl     = get_bloginfo( 'wpurl' ) . '/wp-content/smush-webp/';
	$imagepath    = str_replace( get_bloginfo( 'wpurl' ) . '/wp-content/uploads/', '', $image );
	$imagepath    = str_replace( basename( $imagepath ), '', $imagepath );
	$imagename    = basename( $image );
	$imageurl     = $smushurlpath . $imagepath . $imagename;
	$imageurlfull = $smushurl . $imagepath . $imagename;

	if ( file_exists( $imageurl . '.webp' ) ) {
		if ( strpos( $imageurl, '.webp' ) === false ) {
			if ( array_key_exists( 'HTTP_ACCEPT', $_SERVER ) !== false ) {
				if ( strpos( $_SERVER['HTTP_ACCEPT'], 'image/webp' ) !== false ) {
					$image = $imageurlfull . '.webp';
				}
			}
		}
	}

	return $image;
}

function strl_is_url_external( $url ) {
	$site_host = parse_url( home_url(), PHP_URL_HOST );
	$url_host  = parse_url( $url, PHP_URL_HOST );

	if ( empty( $url ) ) {
		return false;
	}

	if ( str_starts_with( $url, 'tel:' ) || str_starts_with( $url, 'mailto:' ) || '/' === $url[0] || '#' === $url || $site_host === $url_host ) {
		return false;
	}

	return true;
}

/**
 * Returns our default formatted link markup.
 *
 * @package strl
 *
 * @param array $link_array The array returned by an ACF link field
 * @param array $classes The classes to add to the link
 * @param string $icon The icon to add to the link (optional)
 * @return mixed
 *
 * Example use:
 * echo strl_link( get_field( 'link' ), array( 'btn', 'primary' ) );
 */
function strl_link( array $link_array = array(), array $classes = array(), array $inline_style = array(), string $icon = '', string $icon_pos = 'right' ): mixed {
	if ( empty( $link_array ) ) {
		return null;
	}

	if ( is_string( $link_array ) ) {
		$link_array['url'] = $link_array;
	}

	$link_url      = ! empty( $link_array['url'] ) ? esc_url( $link_array['url'] ) : '#';
	$link_title    = ! empty( $link_array['title'] ) ? strip_tags( $link_array['title'] ) : $link_url;
	$link_target   = ! empty( $link_array['target'] ) ? $link_array['target'] : '_self';
	$link_referrer = '_blank' === $link_target ? 'rel="noreferrer"' : '';
	$classes       = implode( ' ', $classes );
	$icon          = ! empty( $icon ) ? '<i class="' . $icon . '"></i>' : '';
	$srt           = '';
	$style_string  = '';
	$icon_pos      = 'left' === $icon_pos ? $icon . $link_title : $link_title . $icon;

	if ( ! empty( $inline_style ) ) {
		foreach ( $inline_style as $key => $style ) {
			if ( empty( $style ) ) {
				continue;
			}

			$style_string .= '--' . $key . ': ' . $style . ';';
		}
	}

	if ( '_blank' === $link_target ) {
		$srt = '<span class="screen-reader-text">' . __( 'This links opens in a new tab', 'strl' ) . '</span>';
	}

	if ( '_blank' === $link_target && true === strl_is_url_external( $link_url ) ) {
		$srt = '<span class="screen-reader-text">' . __( 'This links opens in a new tab and is external', 'strl' ) . '</span>';
	}

	ob_start();
	?>
	<a <?php echo ! empty( $style_string ) ? 'style="' . $style_string . '"' : ''; ?> class="<?php echo $classes; ?>" href="<?php echo $link_url; ?>" target="<?php echo $link_target; ?>" <?php echo $link_referrer; ?>><?php echo $icon_pos . ' ' . $srt; ?></a>
	<?php
	return ob_get_clean();
}


function strl_get_short_month_name( $month ) {
	switch ( $month ) {
		case 'januari':
			$month = 'jan';
			break;
		case 'februari':
			$month = 'feb';
			break;
		case 'maart':
			$month = 'mrt';
			break;
		case 'apil':
			$month = 'apr';
			break;
		case 'mei':
			$month = 'mei';
			break;
		case 'juni':
			$month = 'jun';
			break;
		case 'juli':
			$month = 'jul';
			break;
		case 'augustus':
			$month = 'aug';
			break;
		case 'september':
			$month = 'sep';
			break;
		case 'oktober':
			$month = 'okt';
			break;
		case 'november':
			$month = 'nov';
			break;
		case 'december':
			$month = 'dec';
			break;
	}

	return $month;
}

/**
 * Preload the header image url if it exists
 *
 * @return string
 */
function preload_header_image() {
	$blocks   = get_field( 'blocks' );
	$post_id  = get_the_ID();
	$image_id = null;

	if ( is_singular( 'news' ) ) {
		$image = ! empty( get_field( 'settings-group_post-featured-image', $post_id ) ) ? get_field( 'settings-group_post-featured-image', $post_id ) : null;
	} else {
		if ( empty( $blocks ) ) {
			return;
		}

		$block_names = array_column( $blocks, 'acf_fc_layout' );
		if ( 'header-home' === $block_names[0] ) {
			$blocks[0];
			// $image = $blocks[0]['header-home-image'];
		}

		if ( 'news-overview' === $block_names[0] ) {
			$image = get_field( 'settings-group_post-featured-image' );
		}

		if ( 'header' === $block_names[0] ) {
			$blocks[0];
			$image = $blocks[0]['header-image'];
		}
	}

	if ( empty( $image ) ) {
		return;
	}
	$image_id = ( is_int( $image ) ) ? $image : $image['ID'];

	$image_url        = wp_get_attachment_image_url( $image_id, 'strl-large' );
	$image_url_mobile = wp_get_attachment_image_url( $image_id, 'strl-medium' );

	if ( empty( $image_url ) && empty( $image_url_mobile ) ) {
		return;
	}
	$mime_type = get_post_mime_type( $image_id );
	echo ! empty( $image_url ) ? '<link rel="preload" fetchpriority="high" as="image" href="' . $image_url . '" type="' . $mime_type . '">' : '';
}


/**
 * Add cache bust by checking file timestamp and add that as version in an enqueue function
 *
 * @param string $filename      Filename with extension to enqueue
 * @param array  $dependencies  Enqueue needs these files to work properly
 * @param string $location      Defaults to theme /assets/js/ folders, only use when location differs from that
 * @param bool   $in_footer     Enqueue script in footer, default true
 * @return void
 */
function strl_enqueue_script( $filename = '', $dependencies = array(), $location = '', $in_footer = true ) {
	if ( empty( $filename ) ) {
		return;
	}

	$theme_path = get_stylesheet_directory();
	$theme_uri  = get_bloginfo( 'stylesheet_directory' );

	$folder = ! empty( $location ) ? $theme_uri . $location : $theme_uri . '/assets/js/';
	$path   = ! empty( $location ) ? $theme_path . $location : $theme_path . '/assets/js/';

	if ( file_exists( $path . $filename ) ) {
		$version = filemtime( $path . $filename ) ? (string) filemtime( $path . $filename ) : '';
		$handle  = str_replace( array( '.min', '.js' ), '', $filename );
		wp_enqueue_script( $handle, $folder . $filename, $dependencies, $version, true );
	}
}

/**
 * Add cache bust by checking file timestamp and add that as version in an enqueue function
 *
 * @param string $filename      Filename with extension to enqueue
 * @param array  $dependencies  Enqueue needs these files to work properly
 * @param string $location      Defaults to theme /assets/js/ folders, only use when location differs from that
 * @param bool   $in_footer     Enqueue script in footer, default true
 * @return void
 */
function strl_enqueue_style( $filename = '', $dependencies = array(), $location = '' ) {
	if ( empty( $filename ) ) {
		return;
	}

	$theme_path = get_stylesheet_directory();
	$theme_uri  = get_bloginfo( 'stylesheet_directory' );

	$folder = ! empty( $location ) ? $theme_uri . $location : $theme_uri . '/assets/css/';
	$path   = ! empty( $location ) ? $theme_path . $location : $theme_path . '/assets/css/';

	if ( file_exists( $path . $filename ) ) {
		$version = filemtime( $path . $filename ) ? (string) filemtime( $path . $filename ) : '';
		$handle  = str_replace( array( '.min', '.css' ), '', $filename );
		wp_enqueue_style( $handle, $folder . $filename, $dependencies, $version );
	}
}


/**
 * Returns excerpt with full words by char count
 * example use strl_excerpt( $content, 180 );
 *
 * @param string $string the string you want to shorten
 * @param integer $length the amount of characters the string can have at a maximum
 * @param string $ellipsis how you want to close your new excerpt (this might take it over the length limit)
 * @return string
 */
function strl_excerpt( string $string, int $length = 180, string $ellipsis = '...' ): string {
	$string = strip_shortcodes( $string );
	$string = wp_strip_all_tags( $string );
	$string = html_entity_decode( $string, ENT_QUOTES, 'utf-8' );
	$length = abs( $length );
	if ( strlen( $string ) > $length ) {
		$string = preg_replace( "/^(.{1,$length})(\s.*|$)/s", '\\1' . $ellipsis, $string );
	}
	return $string;
}


/**
 * Helper function to dump all of the posts where the given block is used.
 *
 * @return void
 */
function strl_get_posts_with_block( $block_name = '' ) {
	$post_types = strl_get_all_cpts();
	if ( ! empty( $block_name ) ) {
		$block_name              = sanitize_text_field( $block_name );
		$posts_with_blocks_query = new WP_Query(
			array(
				'post_type'      => $post_types,
				'posts_per_page' => -1,
				'no_found_rows'  => true,
				'meta_query'     => array(
					array(
						'key'     => 'blocks',
						'value'   => '"' . $block_name . '"',
						'compare' => 'LIKE',
					),
				),
			),
		);

		if ( $posts_with_blocks_query->have_posts() ) {
			while ( $posts_with_blocks_query->have_posts() ) {
				$posts_with_blocks_query->the_post();
				echo '<pre>';
				echo '--------------------------<br>';
				var_dump( get_the_title(), get_the_ID() );
				echo '<a href="' . get_permalink() . '">' . __( 'Go to post', 'strl' ) . '</a>';
				echo '<br>--------------------------';
				echo '</pre>';
			}

			wp_reset_postdata();
			exit;
		}
	}
	return;
}

if ( function_exists( 'strl_get_posts_with_block' ) && ! empty( $_GET['strl_block'] ) ) {
	strl_get_posts_with_block( $_GET['strl_block'] );
}

function strl_acf_notice() {
	echo '<div class="notice notice-error"><p>' . esc_html( __( 'This theme requires the Advanced Custom Fields plugin. ', 'strl' ) ) . '</p></div>';
	if (  false === strpos( $_SERVER['REQUEST_URI'], 'plugins.php' )  ) {
			exit;
	}

}
