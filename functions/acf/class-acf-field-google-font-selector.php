<?php
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

add_action(
	'acf/init',
	function() {
		$api_key = get_field( 'global-typography-options_font-api', 'option' );

		define( 'GFONT_API_KEY', $api_key );
	}
);

require 'google-font-functions.php';

/**
* Class Acf_Field_Google_Fonts
* Based off: https://github.com/mujahidi/acf-typography
* Original author: https://github.com/mujahidi
*/
class Acf_Field_Google_Fonts extends acf_field {

	/*
	*  __construct
	*
	*  This function will setup the field type data
	*
	*  @type	function
	*  @date	5/03/2014
	*  @since	5.0.0
	*
	*  @param	n/a
	*  @return	n/a
	*/

	function __construct() {
		$this->name     = 'google_font_selector';
		$this->label    = __( 'Google Font Selector', 'strl' );
		$this->category = __( 'STRL Custom', 'strl' );
		$this->defaults = array( 'font_family' => 'Arial, Helvetica, sans-serif' );

		$this->font_family = array(
			'Arial, Helvetica, sans-serif'          => 'Arial, Helvetica, sans-serif',
			'"Arial Black", Gadget, sans-serif'     => '"Arial Black", Gadget, sans-serif',
			'"Bookman Old Style", serif'            => '"Bookman Old Style", serif',
			'"Comic Sans MS", cursive'              => '"Comic Sans MS", cursive',
			'Courier, monospace'                    => 'Courier, monospace',
			'Garamond, serif'                       => 'Garamond, serif',
			'Georgia, serif'                        => 'Georgia, serif',
			'Impact, Charcoal, sans-serif'          => 'Impact, Charcoal, sans-serif',
			'"Lucida Console", Monaco, monospace'   => '"Lucida Console", Monaco, monospace',
			'"Lucida Sans Unicode", "Lucida Grande", sans-serif' => '"Lucida Sans Unicode", "Lucida Grande", sans-serif',
			'"MS Sans Serif", Geneva, sans-serif'   => '"MS Sans Serif", Geneva, sans-serif',
			'"MS Serif", "New York", sans-serif'    => '"MS Serif", "New York", sans-serif',
			'"Palatino Linotype", "Book Antiqua", Palatino, serif' => '"Palatino Linotype", "Book Antiqua", Palatino, serif',
			'Tahoma,Geneva, sans-serif'             => 'Tahoma, Geneva, sans-serif',
			'"Times New Roman", Times,serif'        => '"Times New Roman", Times, serif',
			'"Trebuchet MS", Helvetica, sans-serif' => '"Trebuchet MS", Helvetica, sans-serif',
			'Verdana, Geneva, sans-serif'           => 'Verdana, Geneva, sans-serif',
		);

		$google_font_family = strl_get_google_font_family(); // get google fonts from json file

		// merge web-safe-fonts and google fonts arrays
		if ( is_array( $google_font_family ) ) {
			$this->font_family = array_merge( $this->font_family, array_column( $google_font_family, 'family', 'family' ) );
		}

		// sort array by array key
		ksort( $this->font_family );
		
		// do not delete!
		parent::__construct();
	}

	/*
	*  render_field()
	*
	*  Create the HTML interface for your field
	*
	*  @param	$field (array) the $field being rendered
	*
	*  @param	$field (array) the $field being edited
	*  @return	n/a
	*/

	function render_field( $field ) {

		$field   = array_merge( $this->defaults, $field );
		$choices = array();

		if ( ! empty( $this->font_family ) ) {
			foreach ( $this->font_family as $key => $value ) {
				$choices[ $key ] = $value;
			}
		}

		// create Field HTML
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

	/*
	*  load_value()
	*
	*  This filter is applied to the $value after it is loaded from the db
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$value (mixed) the value found in the database
	*  @param	$post_id (mixed) the $post_id from which the value was loaded
	*  @param	$field (array) the field array holding all the field options
	*  @return	$value
	*/

	function load_value( $value, $post_id, $field ) {
		return $value;
	}

	/*
	*  update_value()
	*
	*  This filter is applied to the $value before it is saved in the db
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$value (mixed) the value found in the database
	*  @param	$post_id (mixed) the $post_id from which the value was loaded
	*  @param	$field (array) the field array holding all the field options
	*  @return	$value
	*/

	function update_value( $value, $post_id, $field ) {
		return $value;
	}

	/*
	*  format_value()
	*
	*  This filter is applied to the $value after it is loaded from the db and before it is returned to the template
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$value (mixed) the value which was loaded from the database
	*  @param	$post_id (mixed) the $post_id from which the value was loaded
	*  @param	$field (array) the field array holding all the field options
	*
	*  @return	$value (mixed) the modified value
	*/

	function format_value( $value, $post_id, $field ) {
		// bail early if no value
		if ( empty( $value ) ) {
			return false;
		}

		// return
		return $value;
	}

	/*
	*  load_field()
	*
	*  This filter is applied to the $field after it is loaded from the database
	*
	*  @type	filter
	*  @date	23/01/2013
	*  @since	3.6.0
	*
	*  @param	$field (array) the field array holding all the field options
	*  @return	$field
	*/

	function load_field( $field ) {
		return $field;
	}

	/*
	*  update_field()
	*
	*  This filter is applied to the $field before it is saved to the database
	*
	*  @type	filter
	*  @date	23/01/2013
	*  @since	3.6.0
	*
	*  @param	$field (array) the field array holding all the field options
	*  @return	$field
	*/

	function update_field( $field ) {
		return $field;
	}

}

// initialize
new Acf_Field_Google_Fonts();

?>
