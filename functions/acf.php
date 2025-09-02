<?php
global $current_user;
add_action( 'init', 'strl_add_global', 20 );

/**
 * Adds STUURLUI Global Options page
 */
if ( function_exists( 'acf_add_options_page' ) ) {
	$strl_icon_svg = file_get_contents( get_template_directory() . '/assets/img/icon-strl-white.svg' );

	acf_add_options_page(
		array(
			'page_title' => __( 'STUURLUI Global Settings', 'strl' ),
			'menu_title' => __( 'STUURLUI Global', 'strl' ),
			'menu_slug'  => 'strl-global',
			'capability' => 'edit_posts',
			'icon_url'   => 'data:image/svg+xml;base64,' . base64_encode( $strl_icon_svg ), // phpcs:disable
			'redirect'   => false,
		),
	);

	acf_add_options_page(
			array(
				'page_title'  => __( 'Style', 'strl' ),
				'menu_title'  => __( 'Website style', 'strl' ) . ' ',
				'menu_slug'   => 'strl-theme-style',
				'parent_slug' => 'strl-global',
				'capability'  => 'edit_posts',
				'redirect'    => false,
			),
		);

		acf_add_options_sub_page(
		array(
			'page_title' => __( 'STUURLUI Info', 'strl' ),
			'menu_title' => __( 'Info', 'strl' ),
			'menu_slug'  => 'acf-options-strl-info',
			'parent_slug' => 'strl-global',
			'capability' => 'edit_posts',
			'icon_url'   => 'data:image/svg+xml;base64,' . base64_encode( $strl_icon_svg ), // phpcs:disable
			'redirect'   => false,
		)
	);
}

/**
 * Adds STUURLUI Global
 *
 * @package strl
 */
function strl_add_global() {
	global $current_user;
	$social_media_platforms = array( 'facebook', 'twitter', 'instagram', 'linkedin', 'youtube', 'pinterest', 'rss' );
	$cpt_names              = strl_get_all_cpts();
	$strl_global_fields     = array();
	$strl_global_fields     = strl_add_cpt_archive_acf_fields( $strl_global_fields, $cpt_names );
	$strl_global_fields     = strl_add_socials_acf_fields( $strl_global_fields, $social_media_platforms );
	$strl_style_fields      = array();
	$classlist              = 'strl-admin';
	$default_info           = __( '<p><strong>OWC Multisite Theme</strong><br>This theme is created by <a href="https://www.stuurlui.nl" target="_blank">Stuurlui</a> for the OWC. If you have any questions or need support, please contact us at <a href="mailto:support@stuurlui.nl" target="_blank">support@stuurlui.nl</a> or call 
+31 (0)30 227 4000 </p>', 'strl');

	$strl_basic_colors_tab = array(
		'key'       => 'field_strl_global_basic_colors',
		'label'     => __( 'Basic colors', 'strl' ),
		'type'      => 'tab',
		'placement' => 'left',
		'wrapper'   => array(
			'class' => $classlist,
		),
	);

	$strl_basic_colors_fields = array(
		'key'        => 'field_strl_global_basic_colors_fields',
		'label'      => __( 'Basic colors', 'strl' ),
		'name'       => 'global-basic-colors',
		'type'       => 'group',
		'sub_fields' => array(
			array(
				'key'           => 'field_strl_global_basic_colors_website_background',
				'label'         => __( 'Website background color', 'strl' ),
				'name'          => 'website-background',
				'type'          => 'color_picker',
				'default_value' => '#ffffff',
				'wrapper'       => array(
					'width' => '33%',
				),
			),
			array(
				'key'           => 'field_strl_global_basic_colors_text_color',
				'label'         => __( 'Text color', 'strl' ),
				'name'          => 'text-color',
				'type'          => 'color_picker',
				'default_value' => '#1a1a1a',
				'wrapper' => array(
					'width' => '33%',
				),
			),
			array(
				'key'           => 'field_strl_global_basic_colors_link_color',
				'label'         => __( 'Link color', 'strl' ),
				'name'          => 'link-color',
				'type'          => 'color_picker',
				'default_value' => '#1a1a1a',
				'wrapper' => array(
					'width' =>  '34%',
				),
			),
			array(
				'key'           => 'field_strl_global_basic_colors_black',
				'label'         => __( 'Black', 'strl' ),
				'name'          => 'black',
				'type'          => 'color_picker',
				'default_value' => '#000000',
				'wrapper'       => array(
					'width' => '33%',
				),
			),
			array(
				'key'           => 'field_strl_global_basic_colors_white',
				'label'         => __( 'White / variant', 'strl' ),
				'name'          => 'white',
				'type'          => 'color_picker',
				'default_value' => '#ffffff',
				'wrapper'       => array(
					'width' => '33%',
				),
			),
			array(
				'key'           => 'field_strl_global_basic_colors_grey',
				'label'         => __( 'Grey', 'strl' ),
				'name'          => 'grey',
				'type'          => 'color_picker',
				'default_value' => '#757575',
				'wrapper'       => array(
					'width' => '34%',
				),
			),
		),
		'wrapper'    => array(
			'class' => $classlist,
		),
	);

	$strl_theme_colors_tab = array(
		'key'       => 'field_strl_global_theme_colors',
		'label'     => __( 'Theme colors', 'strl' ),
		'type'      => 'tab',
		'placement' => 'left',
		'wrapper'   => array(
			'class' => $classlist,
		),
	);

	$strl_theme_colors_fields = array(
		'key'        => 'field_strl_global_theme_colors_fields',
		'label'      => __( 'Select colors', 'strl' ),
		'name'       => 'global-theme-colors',
		'type'       => 'group',
		'sub_fields' => array(
			array(
				'key'        => 'field_strl_global_primary_group',
				'label'      => __( 'Primary color combinations', 'strl' ),
				'name'       => 'global-primary-group',
				'instructions' => __( 'This color is used as color in blocks & for primary buttons on a white background', 'strl' ),
				'type'       => 'group',
				'wrapper'    => array(
					'class' => 'strl-color-group',
					'id'    => 'strl-color-group',
				),
				'sub_fields' => array(
					array(
						'key'           => 'field_strl_global_theme_colors_primary',
						'label'         => __( 'Main', 'strl' ),
						'name'          => 'primary',
						'type'          => 'color_picker',
						'default_value' => '#4C6E83',
						'instructions'  => __( 'Background color of blocks/buttons', 'strl' ),
						'wrapper'       => array(
							'width' => '25%',
						),
					),
					array(
						'key'           => 'field_strl_global_theme_colors_primary_contrast',
						'label'         => __( 'Text / icons', 'strl' ),
						'name'          => 'primary-contrast',
						'type'          => 'color_picker',
						'instructions'  => __( 'Must contrast with the main color', 'strl' ),
						'default_value' => '#4C6E83',
						'wrapper'       => array(
							'width' => '25%',
						),
					),
					array(
						'key'           => 'field_strl_global_theme_colors_primary_link',
						'label'         => __( 'Hyperlinks', 'strl' ),
						'name'          => 'primary-link',
						'type'          => 'color_picker',
						'instructions'  => __( 'Color of hyperlinks in running texts', 'strl' ),
						'default_value' => '#4C6E83',
						'wrapper'       => array(
							'width' => '25%',
						),
					),
					array(
						'key'           => 'field_strl_global_theme_colors_primary_button',
						'label'         => __( 'Button hover', 'strl' ),
						'name'          => 'primary-button',
						'instructions'  => __( 'On hover, main and hover color switch', 'strl' ),
						'type'          => 'color_picker',
						'default_value' => '#4C6E83',
						'wrapper'       => array(
							'width' => '25%',
						),
					),
					array(
						'key'		 => 'field_primary_button_message',
						'type'		=> 'message',
						'message'	=> '<span><strong>' . __( 'Buttons on colored background (note the contrast of the colored background)', 'strl' ) . '</strong></span>',
						'new_lines' => 'wpautop',
						'esc_html'  => 0,
					),
					array(
						'key'           => 'field_strl_global_theme_colors_primary_button_background',
						'label'         => __( 'Button background', 'strl' ),
						'name'          => 'primary-button-background',
						'type'          => 'color_picker',
						'default_value' => '#4C6E83',
						'wrapper'       => array(
							'width' => '25%',
						),
					),
					array(
						'key'           => 'field_strl_global_theme_colors_primary_button_text',
						'label'         => __( 'Button text / icons', 'strl' ),
						'name'          => 'primary-button-text',
						'type'          => 'color_picker',
						'default_value' => '#4C6E83',
						'wrapper'       => array(
							'width' => '25%',
						),
					),
					array(
						'key'           => 'field_strl_global_theme_colors_primary_button_background_hover',
						'label'         => __( 'Button background hover', 'strl' ),
						'name'          => 'primary-button-background-hover',
						'type'          => 'color_picker',
						'default_value' => '#4C6E83',
						'wrapper'       => array(
							'width' => '25%',
						),
					),
				),
			),
			array(
				'key'        => 'field_strl_global_secondary_group',
				'label'      => __( 'Secondary color combinations', 'strl' ),
				'name'       => 'global-secondary-group',
				'instructions' => __( 'This color is used as color in blocks & for secondary buttons on a white background', 'strl' ),
				'type'       => 'group',
				'wrapper'    => array(
					'class' => 'strl-color-group',
					'id'    => 'strl-color-group',
				),
				'sub_fields' => array(
					array(
						'key'           => 'field_strl_global_theme_colors_secondary',
						'label'         => __( 'Main', 'strl' ),
						'name'          => 'secondary',
						'type'          => 'color_picker',
						'default_value' => '#4C6E83',
						'instructions'  => __( 'Background color of blocks/buttons', 'strl' ),
						'wrapper'       => array(
							'width' => '25%',
						),
					),
					array(
						'key'           => 'field_strl_global_theme_colors_secondary_contrast',
						'label'         => __( 'Text / icons', 'strl' ),
						'name'          => 'secondary-contrast',
						'type'          => 'color_picker',
						'instructions'  => __( 'Must contrast with the main color', 'strl' ),
						'default_value' => '#4C6E83',
						'wrapper'       => array(
							'width' => '25%',
						),
					),
					array(
						'key'           => 'field_strl_global_theme_colors_secondary_link',
						'label'         => __( 'Hyperlinks', 'strl' ),
						'name'          => 'secondary-link',
						'type'          => 'color_picker',
						'instructions'  => __( 'Color of hyperlinks in running texts', 'strl' ),
						'default_value' => '#4C6E83',
						'wrapper'       => array(
							'width' => '25%',
						),
					),
					array(
						'key'           => 'field_strl_global_theme_colors_secondary_button',
						'label'         => __( 'Button hover', 'strl' ),
						'name'          => 'secondary-button',
						'instructions'  => __( 'On hover, main and hover color switch', 'strl' ),
						'type'          => 'color_picker',
						'default_value' => '#4C6E83',
						'wrapper'       => array(
							'width' => '25%',
						),
					),
					array(
						'key'		 => 'field_secondary_button_message',
						'type'		=> 'message',
						'message'	=> '<span><strong>' . __( 'Buttons on colored background (note the contrast of the colored background)', 'strl' ) . '</strong></span>',
						'new_lines' => 'wpautop',
						'esc_html'  => 0,
					),
					array(
						'key'           => 'field_strl_global_theme_colors_secondary_button_background',
						'label'         => __( 'Button background', 'strl' ),
						'name'          => 'secondary-button-background',
						'type'          => 'color_picker',
						'default_value' => '#4C6E83',
						'wrapper'       => array(
							'width' => '25%',
						),
					),
					array(
						'key'           => 'field_strl_global_theme_colors_secondary_button_text',
						'label'         => __( 'Button text / icons', 'strl' ),
						'name'          => 'secondary-button-text',
						'type'          => 'color_picker',
						'default_value' => '#4C6E83',
						'wrapper'       => array(
							'width' => '25%',
						),
					),
					array(
						'key'           => 'field_strl_global_theme_colors_secondary_button_background_hover',
						'label'         => __( 'Button background hover', 'strl' ),
						'name'          => 'secondary-button-background-hover',
						'type'          => 'color_picker',
						'default_value' => '#4C6E83',
						'wrapper'       => array(
							'width' => '25%',
						),
					),
				),
			),
			array(
				'key'        => 'field_strl_global_tertiary_group',
				'label'      => __( 'Tertiary color combinations', 'strl' ),
				'name'       => 'global-tertiary-group',
				'instructions' => __( 'This color is used as color in blocks & for tertiary buttons on a white background', 'strl' ),
				'type'       => 'group',
				'wrapper'    => array(
					'class' => 'strl-color-group',
					'id'    => 'strl-color-group',
				),
				'sub_fields' => array(
					array(
						'key'           => 'field_strl_global_theme_colors_tertiary',
						'label'         => __( 'Main', 'strl' ),
						'name'          => 'tertiary',
						'type'          => 'color_picker',
						'default_value' => '#4C6E83',
						'instructions'  => __( 'Background color of blocks/buttons', 'strl' ),
						'wrapper'       => array(
							'width' => '25%',
						),
					),
					array(
						'key'           => 'field_strl_global_theme_colors_tertiary_contrast',
						'label'         => __( 'Text / icons', 'strl' ),
						'name'          => 'tertiary-contrast',
						'type'          => 'color_picker',
						'instructions'  => __( 'Must contrast with the main color', 'strl' ),
						'default_value' => '#4C6E83',
						'wrapper'       => array(
							'width' => '25%',
						),
					),
					array(
						'key'           => 'field_strl_global_theme_colors_tertiary_link',
						'label'         => __( 'Hyperlinks', 'strl' ),
						'name'          => 'tertiary-link',
						'type'          => 'color_picker',
						'instructions'  => __( 'Color of hyperlinks in running texts', 'strl' ),
						'default_value' => '#4C6E83',
						'wrapper'       => array(
							'width' => '25%',
						),
					),
					array(
						'key'           => 'field_strl_global_theme_colors_tertiary_button',
						'label'         => __( 'Button hover', 'strl' ),
						'name'          => 'tertiary-button',
						'instructions'  => __( 'On hover, main and hover color switch', 'strl' ),
						'type'          => 'color_picker',
						'default_value' => '#4C6E83',
						'wrapper'       => array(
							'width' => '25%',
						),
					),
					array(
						'key'		 => 'field_tertiary_button_message',
						'type'		=> 'message',
						'message'	=> '<span><strong>' . __( 'Buttons on colored background (note the contrast of the colored background)', 'strl' ) . '</strong></span>',
						'new_lines' => 'wpautop',
						'esc_html'  => 0,
					),
					array(
						'key'           => 'field_strl_global_theme_colors_tertiary_button_background',
						'label'         => __( 'Button background', 'strl' ),
						'name'          => 'tertiary-button-background',
						'type'          => 'color_picker',
						'default_value' => '#4C6E83',
						'wrapper'       => array(
							'width' => '25%',
						),
					),
					array(
						'key'           => 'field_strl_global_theme_colors_tertiary_button_text',
						'label'         => __( 'Button text / icons', 'strl' ),
						'name'          => 'tertiary-button-text',
						'type'          => 'color_picker',
						'default_value' => '#4C6E83',
						'wrapper'       => array(
							'width' => '25%',
						),
					),
					array(
						'key'           => 'field_strl_global_theme_colors_tertiary_button_background_hover',
						'label'         => __( 'Button background hover', 'strl' ),
						'name'          => 'tertiary-button-background-hover',
						'type'          => 'color_picker',
						'default_value' => '#4C6E83',
						'wrapper'       => array(
							'width' => '25%',
						),
					),
				),
			),
			array(
				'key'        => 'field_strl_global_quaternary_group',
				'label'      => __( 'Quaternary color combinations', 'strl' ),
				'name'       => 'global-quaternary-group',
				'instructions' => __( 'This color is used as color in blocks & for quaternary buttons on a white background', 'strl' ),
				'type'       => 'group',
				'wrapper'    => array(
					'class' => 'strl-color-group',
					'id'    => 'strl-color-group',
				),
				'sub_fields' => array(
					array(
						'key'           => 'field_strl_global_theme_colors_quaternary',
						'label'         => __( 'Main', 'strl' ),
						'name'          => 'quaternary',
						'type'          => 'color_picker',
						'default_value' => '#4C6E83',
						'instructions'  => __( 'Background color of blocks/buttons', 'strl' ),
						'wrapper'       => array(
							'width' => '25%',
						),
					),
					array(
						'key'           => 'field_strl_global_theme_colors_quaternary_contrast',
						'label'         => __( 'Text / icons', 'strl' ),
						'name'          => 'quaternary-contrast',
						'type'          => 'color_picker',
						'instructions'  => __( 'Must contrast with the main color', 'strl' ),
						'default_value' => '#4C6E83',
						'wrapper'       => array(
							'width' => '25%',
						),
					),
					array(
						'key'           => 'field_strl_global_theme_colors_quaternary_link',
						'label'         => __( 'Hyperlinks', 'strl' ),
						'name'          => 'quaternary-link',
						'type'          => 'color_picker',
						'instructions'  => __( 'Color of hyperlinks in running texts', 'strl' ),
						'default_value' => '#4C6E83',
						'wrapper'       => array(
							'width' => '25%',
						),
					),
					array(
						'key'           => 'field_strl_global_theme_colors_quaternary_button',
						'label'         => __( 'Button hover', 'strl' ),
						'name'          => 'quaternary-button',
						'instructions'  => __( 'On hover, main and hover color switch', 'strl' ),
						'type'          => 'color_picker',
						'default_value' => '#4C6E83',
						'wrapper'       => array(
							'width' => '25%',
						),
					),
					array(
						'key'		 => 'field_quaternary_button_message',
						'type'		=> 'message',
						'message'	=> '<span><strong>' . __( 'Buttons on colored background (note the contrast of the colored background)', 'strl' ) . '</strong></span>',
						'new_lines' => 'wpautop',
						'esc_html'  => 0,
					),
					array(
						'key'           => 'field_strl_global_theme_colors_quaternary_button_background',
						'label'         => __( 'Button background', 'strl' ),
						'name'          => 'quaternary-button-background',
						'type'          => 'color_picker',
						'default_value' => '#4C6E83',
						'wrapper'       => array(
							'width' => '25%',
						),
					),
					array(
						'key'           => 'field_strl_global_theme_colors_quaternary_button_text',
						'label'         => __( 'Button text / icons', 'strl' ),
						'name'          => 'quaternary-button-text',
						'type'          => 'color_picker',
						'default_value' => '#4C6E83',
						'wrapper'       => array(
							'width' => '25%',
						),
					),
					array(
						'key'           => 'field_strl_global_theme_colors_quaternary_button_background_hover',
						'label'         => __( 'Button background hover', 'strl' ),
						'name'          => 'quaternary-button-background-hover',
						'type'          => 'color_picker',
						'default_value' => '#4C6E83',
						'wrapper'       => array(
							'width' => '25%',
						),
					),
				),
			),
		),
		'wrapper'    => array(
			'class' => $classlist,
		),
	);
	

	$strl_typography_tab = array(
		'key'       => 'field_strl_global_typography',
		'label'     => __( 'Theme typography', 'strl' ),
		'type'      => 'tab',
		'placement' => 'left',
		'wrapper'   => array(
			'class' => $classlist,
		),
	);

	$strl_typography_fields = array(
		'key'        => 'field_strl_global_typography_options',
		'label'      => __( 'Typography options', 'strl' ),
		'name'       => 'global-typography-options',
		'type'       => 'group',
		'sub_fields' => array(
			array(
				'key'      => 'field_styling_font_api',
				'label'    => __( 'Google Fonts API key', 'strl' ),
				'name'     => 'font-api',
				'type'     => 'text',
				'required' => 1,
			),
			array(
				'key'   => 'field_styling_base_font_family',
				'label' => __( 'Base font family', 'strl' ),
				'name'  => 'base-font-family',
				'type'  => 'google_font_selector',
			),
			array(
				'key'   => 'field_styling_headings_font_family',
				'label' => __( 'Headings font family', 'strl' ),
				'name'  => 'headings-font-family',
				'type'  => 'google_font_selector',
			),
		),
	);

	$strl_logo_tab = array(
		'key'       => 'field_strl_global_logo',
		'label'     => __( 'Theme logo', 'strl' ),
		'type'      => 'tab',
		'placement' => 'left',
		'wrapper'   => array(
			'class' => $classlist,
		),
	);

	$strl_logo_fields = array(
		'key'        => 'field_strl_global_logo_options',
		'label'      => __( 'Logo options', 'strl' ),
		'name'       => 'global-logo-options',
		'type'       => 'group',
		'sub_fields' => array(
			array(
				'key'      => 'field_logo_height',
				'label'    => __( 'Logo height', 'strl' ),
				'name'     => 'logo-height',
				'type'     => 'text',
				'instructions' => __( 'This height will be used for the logo in the header. The height is in pixels.', 'strl' ),
			),
			array(
				'key'           => 'field_strl_global_logo_logo',
				'label'         => __( 'Logo', 'strl' ),
				'name'          => 'logo',
				'type'          => 'image',
				'return_format' => 'id',
				'preview_size'  => 'thumbnail',
				'library'       => 'all',
			),
			array(
				'key'           => 'field_strl_global_logo_mobile',
				'label'         => __( 'Mobile logo', 'strl' ),
				'name'          => 'logo-mobile',
				'type'          => 'image',
				'return_format' => 'id',
				'preview_size'  => 'thumbnail',
				'library'       => 'all',
			),
		),
	);

	$strl_read_speaker_tab = array(
		'key'       => 'strl_global_read_speaker_tab',
		'label'     => __( 'ReadSpeaker', 'strl' ),
		'name'      => '',
		'type'      => 'tab',
		'placement' => 'left',
	);

	$strl_read_speaker_fields = array(
		'key'           => 'strl_global_read_speaker_image',
		'label'         => __( 'Enable ReadSpeaker for this site?', 'strl' ),
		'name'          => 'strl-global-read-speaker-toggle',
		'message'       => __( 'Yes, enable ReadSpeaker for this site', 'strl' ),
		'type'          => 'true_false',
		'default_value' => 0,
	);

	$strl_cta_tab = array(
		'key'       => 'strl-global-cta-tab',
		'label'     => __( 'Footer CTA', 'strl' ),
		'name'      => '',
		'type'      => 'tab',
		'placement' => 'left',
	);

	$strl_cta_content_one = array(
		'key'          => 'strl_global_cta_content_1',
		'label'        => __( 'CTA Content', 'strl' ) . ' 1',
		'name'         => 'strl-global-cta-content-1',
		'instructions' => __( 'Default', 'strl' ),
		'type'         => 'text',
	);

	$strl_cta_content_one_button = array(
		'key'          => 'strl_global_cta_content_button_1',
		'label'        => __( 'CTA button', 'strl' ) . ' 1',
		'name'         => 'strl-global-cta-content-button-1',
		'aria-label' => 'cta-button',
		'type' => 'link',
		'return_format' => 'array',
	);

	$strl_cta_content_two = array(
		'key'      => 'strl_global_cta_content_2',
		'label'    => __( 'CTA Content', 'strl' ) . ' 2',
		'name'     => 'strl-global-cta-content-2',
		'type'     => 'text',
	);
	
	$strl_cta_content_two_button = array(
		'key'          => 'strl_global_cta_content_button_2',
		'label'        => __( 'CTA button', 'strl' ) . ' 2',
		'name'         => 'strl-global-cta-content-button-2',
		'aria-label' => 'cta-button',
		'type' => 'link',
		'return_format' => 'array',
	);

	$strl_cta_content_three = array(
		'key'      => 'strl_global_cta_content_3',
		'label'    => __( 'CTA Content', 'strl' ) . ' 3',
		'name'     => 'strl-global-cta-content-3',
		'type'     => 'text',
	);

	$strl_cta_content_three_button = array(
		'key'          => 'strl_global_cta_content_button_3',
		'label'        => __( 'CTA button', 'strl' ) . ' 3',
		'name'         => 'strl-global-cta-content-button-3',
		'aria-label' => 'cta-button',
		'type' => 'link',
		'return_format' => 'array',
	);

	array_push( $strl_global_fields, $strl_cta_tab );
	array_push( $strl_global_fields, $strl_cta_content_one, $strl_cta_content_one_button, $strl_cta_content_two, $strl_cta_content_two_button, $strl_cta_content_three, $strl_cta_content_three_button );

	$strl_contact_tab = array(
		'key'       => 'strl_global_contact_tab',
		'label'     => __( 'Contact buttons', 'strl' ),
		'name'      => '',
		'type'      => 'tab',
		'placement' => 'left',
	);


	$strl_contact_title = array(
		'key'      => 'strl_global_contact_title',
		'label'    => __( 'Title', 'strl' ),
		'name'     => 'strl-global-contact-title',
		'type'     => 'text',
	);

	$strl_contact_text = array(
		'key'     => 'strl_global_contact_text',
		'label'   => __( 'Text', 'strl' ),
		'name'    => 'strl-global-contact-content',
		'type'    => 'wysiwyg',
		'toolbar' => 'modern',
	);

	$strl_contact_buttons = array(
		'key'        => 'strl_global_contact_buttons',
		'label'      => __( 'Buttons', 'strl' ),
		'name'       => 'strl-global-contact-buttons',
		'type'       => 'repeater',
		'layout'     => 'table',
		'required'   => 0,
		'sub_fields' => array(
			array(
				'key'           => 'strl_global_button_icon',
				'label'         => __( 'Button icon', 'strl' ),
				'name'          => 'strl-global-button-icon',
				'type'          => 'image',
				'return_format' => 'id',
				'preview_size'  => 'thumbnail',
				'library'       => 'all',
			),
			array(
				'key'           => 'strl_global_button_link',
				'label'         => __( 'Link', 'strl' ),
				'name'          => 'strl-global-button-link',
				'aria-label'    => 'contact-button-link',
				'type'          => 'link',
				'return_format' => 'array',
			),
		),
	);

	array_push( $strl_global_fields, $strl_contact_tab );
	array_push( $strl_global_fields,  $strl_contact_title, $strl_contact_text, $strl_contact_buttons );

	$strl_footer_tab = array(
		'key'       => 'strl_global_footer_tab',
		'label'     => __( 'Footer widgets', 'strl' ),
		'name'      => '',
		'type'      => 'tab',
		'placement' => 'left',
	);


	$strl_footer_toggle = array(
		'key'      => 'strl_global_footer_toggle',
		'type'          => 'radio',
		'name'          => 'strl-global-footer-toggle',
		'required'      => 0,
		'choices'       => array(
			'true'    => __( 'Show', 'strl' ),
			'false' => __( 'Hide', 'strl' ),
		),
		'default_value' => 'show',
	);

	$strl_fallback_tab = array(
		'key'       => 'strl_global_fallback_tab',
		'label'     => __( 'Fallback', 'strl' ),
		'name'      => '',
		'type'      => 'tab',
		'placement' => 'left',
	);

	$strl_fallback_fields = array(
		'key'           => 'strl_global_fallback_image',
		'label'         => __( 'Fallback image', 'strl' ),
		'name'          => 'strl-global-fallback-image',
		'instructions'  => __( 'This image will be used for on blocks where an image is required but none is set.', 'strl' ),
		'type'          => 'image',
		'required'      => 0,
		'return_format' => 'id',
	);

	$strl_footer_icon_tab = array(
		'key'       => 'strl_global_footer_icon_tab',
		'label'     => __( 'Footer icon', 'strl' ),
		'name'      => '',
		'type'      => 'tab',
		'placement' => 'left',
	);

	$strl_footer_icon_fields = array(
		'key'        => 'strl_global_footer_icon_fields',
		'label'      => __( 'Footer icon', 'strl' ),
		'name'       => 'strl-global-footer-icon',
		'type'       => 'group',
		'sub_fields' => array(
			array(
				'key'           => 'strl_global_footer_icon_toggle',
				'label'         => __( 'Do you want to show the icon in the footer?', 'strl' ),
				'name'          => 'strl-global-footer-icon-toggle',
				'message'       => __( 'Yes, show icon', 'strl' ),
				'type'          => 'true_false',
			),
			array(
				'key'           => 'strl_global_footer_icon_text',
				'label'         => __( 'Icon copyright text', 'strl' ),
				'name'          => 'strl-global-footer-icon-text',
				'type'          => 'text',
			),
		),
	);

	

	$strl_complaintform_tab = array(
		'key'       => 'strl_global_complaintform_tab',
		'label'     => __( 'Complaintform', 'strl' ),
		'name'      => '',
		'type'      => 'tab',
		'placement' => 'left',
	);

	$strl_complaintform_fields = array(
		'key'        => 'strl_global_complaintform_url',
		'label'      => __( 'Complaintform URL', 'strl' ),
		'name'       => 'strl-global-complaintform-url',
		'type'       => 'url',
		'instructions' => __( 'This URL is used as target for the complaint form buttons', 'strl' ),
	);

	$strl_google_maps_tab = array(
		'key'       => 'field_strl_global_google_maps_tab',
		'label'     => __( 'Google Maps', 'strl' ),
		'type'      => 'tab',
		'placement' => 'top',
	);

	$strl_google_maps_fields = 	array(
		'key'   => 'field_strl_global_google_maps_api',
		'label' => __( 'Google Maps API key', 'strl' ),
		'name'  => 'maps-api-key',
		'type'  => 'password',
	);


	array_push( $strl_global_fields, $strl_footer_tab );
	array_push( $strl_global_fields,  $strl_footer_toggle );
	array_push( $strl_global_fields, $strl_fallback_tab );
	array_push( $strl_global_fields, $strl_fallback_fields );
	array_push( $strl_global_fields, $strl_footer_icon_tab );
	array_push( $strl_global_fields, $strl_footer_icon_fields );
	array_push( $strl_global_fields, $strl_complaintform_tab );
	array_push( $strl_global_fields, $strl_complaintform_fields );
	array_push( $strl_global_fields, $strl_google_maps_tab );
	array_push( $strl_global_fields, $strl_google_maps_fields );

	$strl_stuurlui_only = array(
		$strl_basic_colors_tab,
		$strl_basic_colors_fields,
		$strl_theme_colors_tab,
		$strl_theme_colors_fields,
		$strl_typography_tab,
		$strl_typography_fields,
		$strl_logo_tab,
		$strl_logo_fields,
		$strl_read_speaker_tab,
		$strl_read_speaker_fields,
	);

	foreach ( $strl_stuurlui_only as $fields ) {
		array_push( $strl_style_fields, $fields );
	}

	acf_add_local_field_group(
		array(
			'key'                   => 'field_strl_global',
			'title'                 => __( 'STUURLUI Global', 'strl' ),
			'fields'                => $strl_global_fields,
			'location'              => array(
				array(
					array(
						'param'    => 'options_page',
						'operator' => '==',
						'value'    => 'strl-global',
					),
				),
			),
			'menu_order'            => 0,
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'active'                => true,
		)
	);

	acf_add_local_field_group(
		array(
			'key'                   => 'field_strl_style',
			'title'                 => __( 'Website style', 'strl' ),
			'fields'                => $strl_style_fields,
			'location'              => array(
				array(
					array(
						'param'    => 'options_page',
						'operator' => '==',
						'value'    => 'strl-theme-style',
					),
				),
			),
			'menu_order'            => 0,
			'position'              => 'normal',
			'style'                 => 'default',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'active'                => true,
		)
	);

	
	acf_add_local_field_group(
		array(
			'key'                   => 'field_strl_info',
			'title'                 => __( 'STUURLUI Info', 'strl' ),
			'fields'                => array(
				array(
					'key'     => 'field_strl_info_text',
					'label'   => __( 'Info', 'strl' ),
					'name'    => 'info',
					'type'    => 'wysiwyg',
					'layout'  => 'table',
					'toolbar' => 'modern',
					'default_value' => 	$default_info,
				),
			),
			'location'              => array(
				array(
					array(
						'param'    => 'options_page',
						'operator' => '==',
						'value'    => 'acf-options-strl-info',
					),
				),
			),
			'menu_order'            => 0,
			'position'              => 'normal',
			'style'                 => 'default',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'active'                => true,
		)
	);
}

acf_add_local_field_group(
	array(
		'key'                   => 'group_location_category_fields',
		'title'                 => __( 'Location catgegory fields', 'strl' ),
		'fields'                => array(
			array(
				'key'           => 'field_location_category_marker_icon',
				'label'         => __( 'Marker icon', 'strl' ),
				'name'          => 'location_category-marker-icon',
				'type'          => 'image',
				'return_format' => 'url',
				'preview_size'  => 'thumbnail',
			),
		),
		'location'              => array(
			array(
				array(
					'param'    => 'taxonomy',
					'operator' => '==',
					'value'    => 'location_category',
				),
			),
		),
		'position'              => 'acf_after_title',
		'label_placement'       => 'top',
		'instruction_placement' => 'label',
		'active'                => true,
		'hide_on_screen'        => array(
			0 => 'the_content',
		),
	),
);
