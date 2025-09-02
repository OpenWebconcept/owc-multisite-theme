<?php

$custom_cpts = strl_get_all_cpts();
array_push( $custom_cpts, 'page' ); // Add page for this loop

if ( $custom_cpts ) {
	foreach ( $custom_cpts as $cpt ) {
		$acf_fields = strl_get_cpt_acf_fields( $cpt );

		acf_add_local_field_group(
			array(
				'key'                   => 'group_' . $cpt,
				'title'                 => __( ucfirst( $cpt ), 'strl' ),
				'fields'                => $acf_fields,
				'location'              => array(
					array(
						array(
							'param'    => 'post_type',
							'operator' => '==',
							'value'    => $cpt,
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
	}
}
