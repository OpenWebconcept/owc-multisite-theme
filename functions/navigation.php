<?php // phpcs:ignore

class STRL_DRILL_MENU_WALKER extends Walker_Nav_Menu {
	function start_lvl( &$output, $depth = 0, $args = array() ) {
		$indent  = str_repeat( "\t", $depth );
		$output .= "\n$indent<ul class=\"vertical menu\">\n<li class=\"no-arrow\">\n<div class=\"submenu-items-wrap\">\n<ul class=\"vertical menu\">\n";
	}

	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$after = property_exists( $args, 'link_after' ) ? $args->link_after : '';

		if ( $depth > 0 || ! $this->has_children ) {
			$args->link_after = '';
		}

		parent::start_el( $output, $item, $depth, $args, $id );

		$args->link_after = $after;
	}

	function end_lvl( &$output, $depth = 0, $args = array() ) {
		$indent  = str_repeat( "\t", $depth );
		$output .= "\n$indent</ul>\n</div>\n</li>\n</ul>\n";
	}
}

if ( ! function_exists( 'active_nav_class' ) ) {
	/**
	 * Adds the active class to an active menu item
	 *
	 * @package strl
	 */
	function active_nav_class( $classes, $item ) {
		if ( 1 === $item->current || true === $item->current_item_ancestor ) {
			$classes[] = 'active';
		}
		return $classes;
	}
	add_filter( 'nav_menu_css_class', 'active_nav_class', 10, 2 );
}

if ( ! function_exists( 'active_list_pages_class' ) ) {
	/**
	 * Adds the active class to an active page
	 *
	 * @package strl
	 */
	function active_list_pages_class( $input ) {
		$pattern = '/current_page_item/';
		$replace = 'current_page_item active';
		$output  = preg_replace( $pattern, $replace, $input );
		return $output;
	}
	add_filter( 'wp_list_pages', 'active_list_pages_class', 10, 2 );
}
