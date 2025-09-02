<?php
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

class Acf_Field_Post_Type_Selector extends acf_field {
	/**
	* This function will setup the field type data
	*
	*/
	function __construct() {
		$this->name     = 'post_type_selector';
		$this->label    = __( 'Post Type Selector', 'strl' );
		$this->category = __( 'STRL Custom', 'strl' ); // Basic, Content, Choice, etc

		// do not delete!
		parent::__construct();
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

		$post_types = strl_get_all_cpts();

		//Prevent undefined variable notice
		if ( isset( $post_types ) ) {
			foreach ( $post_types as $post_type ) {
				$post_type_label = get_post_type_object( $post_type )->labels->name;
				$choices[ $post_type ] = ucfirst( $post_type_label );
			}
		}

		$field['choices'] = $choices;
		?>
	<select id="<?php echo str_replace( array( '[', ']' ), array( '-', '' ), $field['name'] ); ?>" name="<?php echo $field['name']; ?>">
			<?php
			echo '<option value="">- Select -</option>';
			foreach ( $field['choices'] as $key => $value ) :
				$selected = '';
				if ( ( is_array( $field['value'] ) && in_array( $key, $field['value'], true ) ) || $field['value'] === $key ) {
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
	function format_value( $value, $post_id = 0, $field = array() ) {
		//Return false if value is false, null or empty
		if ( ! $value || empty( $value ) ) {
			return false;
		}

		return $value;
	}
}

// create field
new Acf_Field_Post_Type_Selector();
