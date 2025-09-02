<?php
if ( ! class_exists( 'acf' ) ) {
	return;
}
$basic_colors_group = get_field( 'global-basic-colors', 'option' );
$theme_colors_group = get_field( 'global-theme-colors', 'option' );

if ( ! $basic_colors_group || ! $theme_colors_group ) {
	return;
}

// Theme colors
$prefix_primary           = 'global-primary-group';
$primary                  = ! empty( $theme_colors_group[ $prefix_primary ]['primary'] ) ? $theme_colors_group[ $prefix_primary ]['primary'] : '#000000';
$primary_contrast         = ! empty( $theme_colors_group[ $prefix_primary ]['primary-contrast'] ) ? $theme_colors_group[ $prefix_primary ]['primary-contrast'] : '#000000';
$primary_link             = ! empty( $theme_colors_group[ $prefix_primary ]['primary-link'] ) ? $theme_colors_group[ $prefix_primary ]['primary-link'] : '#000000';
$primary_button           = ! empty( $theme_colors_group[ $prefix_primary ]['primary-button'] ) ? $theme_colors_group[ $prefix_primary ]['primary-button'] : '#000000';
$primary_button_bg        = ! empty( $theme_colors_group[ $prefix_primary ]['primary-button-background'] ) ? $theme_colors_group[ $prefix_primary ]['primary-button-background'] : '#000000';
$primary_button_text      = ! empty( $theme_colors_group[ $prefix_primary ]['primary-button-text'] ) ? $theme_colors_group[ $prefix_primary ]['primary-button-text'] : '#000000';
$primary_buttton_bg_hover = ! empty( $theme_colors_group[ $prefix_primary ]['primary-button-background-hover'] ) ? $theme_colors_group[ $prefix_primary ]['primary-button-background-hover'] : '#000000';

$prefix_secondary           = 'global-secondary-group';
$secondary                  = ! empty( $theme_colors_group[ $prefix_secondary ]['secondary'] ) ? $theme_colors_group[ $prefix_secondary ]['secondary'] : '#000000';
$secondary_contrast         = ! empty( $theme_colors_group[ $prefix_secondary ]['secondary-contrast'] ) ? $theme_colors_group[ $prefix_secondary ]['secondary-contrast'] : '#000000';
$secondary_link             = ! empty( $theme_colors_group[ $prefix_secondary ]['secondary-link'] ) ? $theme_colors_group[ $prefix_secondary ]['secondary-link'] : '#000000';
$secondary_button           = ! empty( $theme_colors_group[ $prefix_secondary ]['secondary-button'] ) ? $theme_colors_group[ $prefix_secondary ]['secondary-button'] : '#000000';
$secondary_button_bg        = ! empty( $theme_colors_group[ $prefix_secondary ]['secondary-button-background'] ) ? $theme_colors_group[ $prefix_secondary ]['secondary-button-background'] : '#000000';
$secondary_button_text      = ! empty( $theme_colors_group[ $prefix_secondary ]['secondary-button-text'] ) ? $theme_colors_group[ $prefix_secondary ]['secondary-button-text'] : '#000000';
$secondary_buttton_bg_hover = ! empty( $theme_colors_group[ $prefix_secondary ]['secondary-button-background-hover'] ) ? $theme_colors_group[ $prefix_secondary ]['secondary-button-background-hover'] : '#000000';

$prefix_tertiary           = 'global-tertiary-group';
$tertiary                  = ! empty( $theme_colors_group[ $prefix_tertiary ]['tertiary'] ) ? $theme_colors_group[ $prefix_tertiary ]['tertiary'] : '#000000';
$tertiary_contrast         = ! empty( $theme_colors_group[ $prefix_tertiary ]['tertiary-contrast'] ) ? $theme_colors_group[ $prefix_tertiary ]['tertiary-contrast'] : '#000000';
$tertiary_link             = ! empty( $theme_colors_group[ $prefix_tertiary ]['tertiary-link'] ) ? $theme_colors_group[ $prefix_tertiary ]['tertiary-link'] : '#000000';
$tertiary_button           = ! empty( $theme_colors_group[ $prefix_tertiary ]['tertiary-button'] ) ? $theme_colors_group[ $prefix_tertiary ]['tertiary-button'] : '#000000';
$tertiary_button_bg        = ! empty( $theme_colors_group[ $prefix_tertiary ]['tertiary-button-background'] ) ? $theme_colors_group[ $prefix_tertiary ]['tertiary-button-background'] : '#000000';
$tertiary_button_text      = ! empty( $theme_colors_group[ $prefix_tertiary ]['tertiary-button-text'] ) ? $theme_colors_group[ $prefix_tertiary ]['tertiary-button-text'] : '#000000';
$tertiary_buttton_bg_hover = ! empty( $theme_colors_group[ $prefix_tertiary ]['tertiary-button-background-hover'] ) ? $theme_colors_group[ $prefix_tertiary ]['tertiary-button-background-hover'] : '#000000';

$prefix_quaternary           = 'global-quaternary-group';
$quaternary                  = ! empty( $theme_colors_group[ $prefix_quaternary ]['quaternary'] ) ? $theme_colors_group[ $prefix_quaternary ]['quaternary'] : '#000000';
$quaternary_contrast         = ! empty( $theme_colors_group[ $prefix_quaternary ]['quaternary-contrast'] ) ? $theme_colors_group[ $prefix_quaternary ]['quaternary-contrast'] : '#000000';
$quaternary_link             = ! empty( $theme_colors_group[ $prefix_quaternary ]['quaternary-link'] ) ? $theme_colors_group[ $prefix_quaternary ]['quaternary-link'] : '#000000';
$quaternary_button           = ! empty( $theme_colors_group[ $prefix_quaternary ]['quaternary-button'] ) ? $theme_colors_group[ $prefix_quaternary ]['quaternary-button'] : '#000000';
$quaternary_button_bg        = ! empty( $theme_colors_group[ $prefix_quaternary ]['quaternary-button-background'] ) ? $theme_colors_group[ $prefix_quaternary ]['quaternary-button-background'] : '#000000';
$quaternary_button_text      = ! empty( $theme_colors_group[ $prefix_quaternary ]['quaternary-button-text'] ) ? $theme_colors_group[ $prefix_quaternary ]['quaternary-button-text'] : '#000000';
$quaternary_buttton_bg_hover = ! empty( $theme_colors_group[ $prefix_quaternary ]['quaternary-button-background-hover'] ) ? $theme_colors_group[ $prefix_quaternary ]['quaternary-button-background-hover'] : '#000000';

// Basic colors
$black      = ! empty( $basic_colors_group['black'] ) ? $basic_colors_group['black'] : '#000000';
$white      = ! empty( $basic_colors_group['white'] ) ? $basic_colors_group['white'] : '#ffffff';
$gray       = ! empty( $basic_colors_group['grey'] ) ? $basic_colors_group['grey'] : '#cccccc';
$website_bg = ! empty( $basic_colors_group['website-background'] ) ? $basic_colors_group['website-background'] : '#000000';
$text_color = ! empty( $basic_colors_group['text-color'] ) ? $basic_colors_group['text-color'] : '#000000';
$link_color = ! empty( $basic_colors_group['link-color'] ) ? $basic_colors_group['link-color'] : '#000000';

$styling_group = get_field( 'global-typography-options', 'option' );

$basefont      = $styling_group['base-font-family'] ? $styling_group['base-font-family'] : 'Lato, sans-serif';
$headings_font = $styling_group['headings-font-family'] ? $styling_group['headings-font-family'] : 'Lato, sans-serif';

// Trakade
if ( 12 === get_current_blog_id() ) {
	$headings_font = 'Nohemi';
}

// Slim Samenleven
if ( 13 === get_current_blog_id() ) {
	$headings_font = 'DBK';
}
?>

<style>
	:root {
		--strl-color-primary: <?php echo $primary; ?>;
		--strl-color-primary-contrast: <?php echo $primary_contrast; ?>;
		--strl-color-primary-link: <?php echo $primary_link; ?>;
		--strl-color-primary-button: <?php echo $primary_button; ?>;
		--strl-color-primary-button-bg: <?php echo $primary_button_bg; ?>;
		--strl-color-primary-button-text: <?php echo $primary_button_text; ?>;
		--strl-color-primary-button-bg-hover: <?php echo $primary_buttton_bg_hover; ?>;

		--strl-color-secondary: <?php echo $secondary; ?>;
		--strl-color-secondary-contrast: <?php echo $secondary_contrast; ?>;
		--strl-color-secondary-link: <?php echo $secondary_link; ?>;
		--strl-color-secondary-button: <?php echo $secondary_button; ?>;
		--strl-color-secondary-button-bg: <?php echo $secondary_button_bg; ?>;
		--strl-color-secondary-button-text: <?php echo $secondary_button_text; ?>;
		--strl-color-secondary-button-bg-hover: <?php echo $secondary_buttton_bg_hover; ?>;

		--strl-color-tertiary: <?php echo $tertiary; ?>;
		--strl-color-tertiary-contrast: <?php echo $tertiary_contrast; ?>;
		--strl-color-tertiary-link: <?php echo $tertiary_link; ?>;
		--strl-color-tertiary-button: <?php echo $tertiary_button; ?>;
		--strl-color-tertiary-button-bg: <?php echo $tertiary_button_bg; ?>;
		--strl-color-tertiary-button-text: <?php echo $tertiary_button_text; ?>;
		--strl-color-tertiary-button-bg-hover: <?php echo $tertiary_buttton_bg_hover; ?>;

		--strl-color-quaternary: <?php echo $quaternary; ?>;
		--strl-color-quaternary-contrast: <?php echo $quaternary_contrast; ?>;
		--strl-color-quaternary-link: <?php echo $quaternary_link; ?>;
		--strl-color-quaternary-button: <?php echo $quaternary_button; ?>;
		--strl-color-quaternary-button-bg: <?php echo $quaternary_button_bg; ?>;
		--strl-color-quaternary-button-text: <?php echo $quaternary_button_text; ?>;
		--strl-color-quaternary-button-bg-hover: <?php echo $quaternary_buttton_bg_hover; ?>;
		
		--strl-color-black: <?php echo $black; ?>;
		--strl-color-white: <?php echo $white; ?>;
		--strl-color-gray: <?php echo $gray; ?>;
		--strl-base-font: "<?php echo $basefont; ?>";
		--strl-headings-font: "<?php echo $headings_font; ?>";
		--strl-text-color: <?php echo $text_color; ?>;
		--strl-website-bg: <?php echo $website_bg; ?>;
		--strl-link-color: <?php echo $link_color; ?>;
	}
</style>
