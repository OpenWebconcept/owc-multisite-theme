<?php
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

/**
* Class acf_field_gravity_forms
* https://gist.github.com/tomazzaman/526741508756922c47c4
*/
class Acf_Field_Gravity_Forms extends acf_field {
	/**
	* This function will setup the field type data
	* acf_field_gravity_forms constructor.
	*/
	public function __construct() {
		$this->name     = 'gravity_forms_field';
		$this->label    = __( 'Gravity Forms', 'strl' );
		$this->category = __( 'STRL Custom', 'strl' ); // Basic, Content, Choice, etc
		$this->defaults = array(
			'allow_multiple' => 0,
			'allow_null'     => 1,
			'return_format'  => 'default',
		);
		// do not delete!
		parent::__construct();
	}

	/**
	* Create extra settings for your field.
	* These are visible when editing a field.
	*
	* @param array $field
	*/
	public function render_field_settings( $field = array() ) {
		/*
		*  acf_render_field_setting
		*
		*  This function will create a setting for your field. Simply pass the $field parameter and an array of field settings.
		*  The array of settings does not require a `value` or `prefix`; These settings are found from the $field array.
		*
		*  More than one setting can be added by copy/paste the above code.
		*  Please note that you must also have a matching $defaults value for the field name (font_size)
		*/
		acf_render_field_setting(
			$field,
			array(
				'label'   => 'Allow Null?',
				'type'    => 'radio',
				'name'    => 'allow_null',
				'choices' => array(
					1 => __( 'Yes', 'strl' ),
					0 => __( 'No', 'strl' ),
				),
				'layout'  => 'horizontal',
			)
		);

		acf_render_field_setting(
			$field,
			array(
				'label'   => 'Allow Multiple?',
				'type'    => 'radio',
				'name'    => 'allow_multiple',
				'choices' => array(
					1 => __( 'Yes', 'strl' ),
					0 => __( 'No', 'strl' ),
				),
				'layout'  => 'horizontal',
			)
		);

		acf_render_field_setting(
			$field,
			array(
				'label'   => 'Return Format?',
				'type'    => 'radio',
				'name'    => 'return_format',
				'choices' => array(
					'id'      => __( 'ID', 'strl' ),
					'default' => __( 'All', 'strl' ),
				),
				'layout'  => 'horizontal',
			)
		);
	}

	/**
	* Create the HTML interface for your field
	*
	* @param array $field
	*/
	public function render_field( $field ) {
		/*
		*  Review the data of $field.
		*  This will show what data is available
		*/

		// vars
		$field   = array_merge( $this->defaults, $field );
		$choices = array();
		//Show notice if Gravity Forms is not activated
		if ( class_exists( 'RGFormsModel' ) ) {
			$forms = RGFormsModel::get_forms( 1 );
		} else {
			echo "<font style='color:red;font-weight:bold;'>Warning: Gravity Forms is not installed or activated. This field does not function without Gravity Forms!</font>";
		}

		//Prevent undefined variable notice
		if ( isset( $forms ) ) {
			foreach ( $forms as $form ) {
				$choices[ intval( $form->id ) ] = ucfirst( $form->title );
			}
		}
		// override field settings and render
		$field['choices'] = $choices;
		$field['type']    = 'select';
		if ( $field['allow_multiple'] ) {
			$multiple = 'multiple="multiple" data-multiple="1"';
			echo "<input type=\"hidden\" name=\"{$field['name']}\">";
		} else {
			$multiple = '';
		}
		?>
		<select id="<?php echo str_replace( array( '[', ']' ), array( '-', '' ), $field['name'] ); ?>" name="<?php echo ( $field['allow_multiple'] ) ? $field['name'] . '[]' : $field['name']; ?>" <?php echo $multiple; ?>>
			<?php
			if ( $field['allow_null'] ) {
				echo '<option value="">- Select -</option>';
			}
			foreach ( $field['choices'] as $key => $value ) :
				$selected = '';
				if ( ( is_array( $field['value'] ) && in_array( $key, $field['value'], true ) ) || $key == $field['value'] ) {
					$selected = ' selected="selected"';
				}
				?>
				<option value="<?php echo $key; ?>"<?php echo $selected; ?>><?php echo $value; ?></option>
				<?php
			endforeach;
			?>
		</select>
		<?php
	}

	/**
	* This filter is applied to the $value after it is loaded
	* from the db and before it is returned to the template.
	*
	* @param $value
	* @param int $post_id
	* @param array $field
	* @return array|bool|mixed
	*/
	public function format_value( $value, $post_id = 0, $field = array() ) {
		//Return false if value is false, null or empty
		if ( ! $value || empty( $value ) ) {
			return false;
		}

		//If there are multiple forms, construct and return an array of form objects
		if ( is_array( $value ) && ! empty( $value ) ) {
			$form_objects = array();
			foreach ( $value as $k => $v ) {
				$form = GFAPI::get_form( $v );
				//Add it if it's not an error object
				if ( ! is_wp_error( $form ) ) {
					if ( 'id' === $field['return_format'] ) {
						$form_objects[ $k ] = $v;
					} else {
						$form_objects[ $k ] = $form;
					}
				}
			}
			//Return false if the array is empty
			if ( ! empty( $form_objects ) ) {
				return $form_objects;
			} else {
				return false;
			}

			//Else return single form object
		} else {
			$form = GFAPI::get_form( intval( $value ) );
			//Return the form object if it's not an error object. Otherwise return false.
			if ( ! is_wp_error( $form ) ) {
				if ( 'id' === $field['return_format'] ) {
					return $value;
				} else {
					return $form;
				}
			} else {
				return false;
			}
		}
	}
}

// create field
new Acf_Field_Gravity_Forms();
