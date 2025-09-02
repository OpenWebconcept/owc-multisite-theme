<?php
$blockname = 'textmedia';

$layouts[ $blockname ] = array(
	'order'      => 3,
	'key'        => 'layout_' . $blockname,
	'name'       => $blockname,
	'label'      => __( 'Text Media', 'strl' ),
	'display'    => 'block',
	'sub_fields' => array(
		array(
			'key'       => 'field_' . $blockname . '_content',
			'label'     => 'Content',
			'type'      => 'tab',
			'placement' => 'top',
		),
		array(
			'key'      => 'field_' . $blockname . '_type',
			'label'    => __( 'Which kind of media would you like to add?', 'strl' ),
			'name'     => $blockname . '-type',
			'type'     => 'radio',
			'required' => 1,
			'choices'  => array(
				'image' => __( 'Image', 'strl' ),
				'video' => __( 'Video', 'strl' ),
			),
		),
		array(
			'key'               => 'field_' . $blockname . '_video',
			'label'             => __( 'Video', 'strl' ),
			'name'              => $blockname . '-video',
			'type'              => 'text',
			'instructions'      => __( 'Please fill in the piece of code in which you can find here: https://www.youtube.com/watch?v=<strong style="color: blue;">Kl5jKGX1YqE</strong>.<br/> When adding Vimeo, https://vimeo.com/<strong style="color: blue;">242795174</strong>', 'strl' ),
			'conditional_logic' => array(
				array(
					array(
						'field'    => 'field_' . $blockname . '_type',
						'operator' => '==',
						'value'    => 'video',
					),
				),
			),
		),

		array(
			'key'           => 'field_' . $blockname . '_image',
			'label'         => __( 'Image', 'strl' ),
			'name'          => $blockname . '-image',
			'type'          => 'image',
			'instructions'  => __( 'Ideal minimal size is 640x640px. <br/> If you have chosen video, this will be the placeholder.', 'strl' ),
			'return_format' => 'id',
			'preview_size'  => 'thumbnail',
			'library'       => 'all',
		),
		array(
			'key'          => 'field_' . $blockname . '_text',
			'label'        => __( 'Text', 'strl' ),
			'name'         => $blockname . '-text',
			'type'         => 'wysiwyg',
			'required'     => 1,
			'tabs'         => 'all',
			'toolbar'      => 'modern',
			'media_upload' => 1,
			'delay'        => 1,
		),
		array(
			'key'       => 'field_' . $blockname . '_settings',
			'label'     => 'Instellingen',
			'type'      => 'tab',
			'placement' => 'top',
		),
		array(
			'key'           => 'field_' . $blockname . '_imagefirst',
			'label'         => __( 'On which side should the media show?', 'strl' ),
			'name'          => $blockname . '-imagefirst',
			'type'          => 'radio',
			'choices'       => array(
				'leftside'  => __( 'Left', 'strl' ),
				'rightside' => __( 'Right', 'strl' ),
			),
			'default_value' => 'leftside',
			'ui'            => 0,
		),
		array(
			'key'     => 'field_' . $blockname . '_textaligntop',
			'label'   => __( 'How do you want to align the text?', 'strl' ),
			'name'    => $blockname . '-textaligntop',
			'type'    => 'radio',
			'choices' => array(
				'topside'  => __( 'Topside', 'strl' ),
				'leftside' => __( 'Centered', 'strl' ),
			),
		),
	),
	'min'        => 'fas fa-cube',
);
