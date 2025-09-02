<?php

/**
 *  Update Google Fonts JSON file
 *
 *  strl_update_gf_json_file()
 */
add_action( 'init', 'strl_update_gf_json_file' );
function strl_update_gf_json_file() {
	if ( ! defined( 'GFONT_API_KEY' ) ) {
		return;
	}

	$filename = __DIR__ . '/google_fonts.json';

	if ( file_exists( $filename ) ) {

		$file_date = gmdate( 'Ymd', filemtime( $filename ) );
		$now       = gmdate( 'Ymd', time() );
		$time      = $now - $file_date;

		if ( ! filesize( $filename ) || $time > 1 ) {
			$json = file_get_contents( 'https://webfonts.googleapis.com/v1/webfonts?key=' . GFONT_API_KEY );

			$gf_file = fopen( $filename, 'wb' );
			fwrite( $gf_file, $json );
			fclose( $gf_file );
		}
	}
}

/**
 *  Get google fonts for Font-Family drop-down subfield
 *
 *  strl_get_google_font_family()
 */
function strl_get_google_font_family() {
	// Load json file for extra setting
	$json        = file_get_contents( __DIR__ . '/google_fonts.json' );
	$font_array  = json_decode( $json );
	$font_family = array();

	if ( $font_array ) {
		foreach ( $font_array as $k => $v ) {
			if ( is_array( $v ) ) {
				foreach ( $v as $value ) {
					$font_family[ $value->family ] = array(
						'family'  => $value->family,
						'weights' => $value->variants,
					);
				}
			}
		}
	}

	return $font_family;
}

/**
 *  Enqueue Google Fonts file
 *
 *  strl_enqueue_google_fonts_file()
 */
add_action( 'wp_enqueue_scripts', 'strl_enqueue_google_fonts_file' );
function strl_enqueue_google_fonts_file() {
	$google_fonts  = strl_get_google_font_family();
	$basefont      = get_field( 'global-typography-options_base-font-family', 'option' );
	$headings_font = get_field( 'global-typography-options_headings-font-family', 'option' );

	foreach ( $google_fonts as $family => $font ) {
		$new_weights                           = array();
		$google_fonts[ $family ]['has_italic'] = false;
		foreach ( $font['weights'] as $key => $weight ) {
			$new_weight = str_replace( 'regular', '400', $weight );
			if ( strpos( $weight, 'italic' ) !== false ) {
				$google_fonts[ $family ]['has_italic'] = true;
			}
			if ( ! is_numeric( $new_weight ) ) {
				continue;
			}
			$new_weights[] = $new_weight;
		}
		$google_fonts[ $family ]['weights'] = $new_weights;
	}

	$google_font_base          = 'https://fonts.googleapis.com/css2';
	$google_font_basefont      = '';
	$google_font_headings_font = '';

	if ( is_array( $google_fonts ) && isset( $google_fonts[ $basefont ] ) ) {
		if ( true === $google_fonts[ $basefont ]['has_italic'] ) {
			$weights = array();
			foreach ( $google_fonts[ $basefont ]['weights'] as $key => $weight ) {
				$weights[] = '0,' . $weight;
			}
			foreach ( $google_fonts[ $basefont ]['weights'] as $key => $weight ) {
				$weights[] = '1,' . $weight;
			}
			$basefont_url = ':ital,wght@' . implode( ';', $weights );
		} else {
			$basefont_url = ':wght@' . implode( ';', $google_fonts[ $basefont ]['weights'] );
		}

		$basefont             = str_replace( ' ', '+', $basefont );
		$google_font_basefont = $google_font_base . '?family=' . $basefont . $basefont_url;
	}

	if ( is_array( $google_fonts ) && isset( $google_fonts[ $headings_font ] ) ) {
		if ( true === $google_fonts[ $headings_font ]['has_italic'] ) {
			$weights = array();
			foreach ( $google_fonts[ $headings_font ]['weights'] as $key => $weight ) {
				$weights[] = '0,' . $weight;
			}
			foreach ( $google_fonts[ $headings_font ]['weights'] as $key => $weight ) {
				$weights[] = '1,' . $weight;
			}
			$headings_font_url = ':ital,wght@' . implode( ';', $weights );
		} else {
			$headings_font_url = ':wght@' . implode( ';', $google_fonts[ $headings_font ]['weights'] );
		}

		$headings_font             = str_replace( ' ', '+', $headings_font );
		$google_font_headings_font = $google_font_base . '?family=' . $headings_font . $headings_font_url;
	}

	wp_enqueue_style( 'strl-google-fonts-base', $google_font_basefont );
	wp_enqueue_style( 'strl-google-fonts-headings', $google_font_headings_font );
}
