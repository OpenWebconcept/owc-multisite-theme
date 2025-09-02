<?php // phpcs:ignore

add_filter( 'facetwp_shortcode_html', 'strl_replace_facetwptemplate_class', 10, 2 );
add_filter( 'facetwp_facet_types', 'strl_add_facet' );
add_filter( 'facetwp_facet_display_value', 'strl_change_facet_label', 20, 4 );
add_action( 'wp_head', 'strl_add_srt_to_selection_value', 100 );
add_filter( 'facetwp_map_marker_args', 'strl_custom_map_markers', 10, 2 );
add_filter( 'facetwp_map_init_args', 'strl_map_args', 10, 1 );

add_filter( 'facetwp_index_row', function( $params, $class ) {
     if ( isset($params['facet_value']) && is_bool( $params['facet_value'] ) ) {
        $params['facet_value'] = ''; 
    }
    return $params;
}, 5, 2 );

function strl_map_args( $args ) {
	$args['init']['styles']           = json_decode( '[{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]}]' );
	$args['init']['disableDefaultUI'] = true;
	return $args;
}

function strl_custom_map_markers( $args, $post_id ) {
	$primary_category = ! empty( strl_get_primary_category( $post_id, 'location_category' ) ) ? strl_get_primary_category( $post_id, 'location_category' )->term_id : '';
	$marker           = ! empty( get_field( 'location_category-marker-icon', 'term_' . $primary_category ) ) ? get_field( 'location_category-marker-icon', 'term_' . $primary_category ) : '';
	if ( ! empty( $marker ) ) {
		$args['icon'] = array(
			'url' => $marker,
		);
	}
	return $args;
}

function strl_add_srt_to_selection_value() {
	// TODO: replace with a better solution. Bob will take a look
	$translation   = esc_js( __( 'Remove filter', 'strl' ) );
	$clear_filters = esc_js( __( 'Clear filters', 'strl' ) );
	$filtered_on   = esc_js( __( 'Filtered on:', 'strl' ) );
	?>
	<script>
	document.addEventListener('DOMContentLoaded', () => {
		const overviewSection = document.querySelector('section.publications-overview');
		if (overviewSection) {
			if (window.innerWidth < 1024) {
				const resultCountContainer = document.querySelector(".result-count");
				if (resultCountContainer) {
					const filterdOnText = document.createElement("span");
					filterdOnText.classList.add("filtered-on-text");
					filterdOnText.textContent = "<?php echo $filtered_on; ?>";
					resultCountContainer.appendChild(filterdOnText);
					filterdOnText.style.display = "none";
				}

				const filterSelectionText = document.querySelector(".filter-current");
				if (filterSelectionText) {
					const filterSelectionTextContent = filterSelectionText.childNodes[0];
					filterSelectionText.removeChild(filterSelectionTextContent);
				}
			}

			FWP.hooks.addAction('facetwp/loaded', () => {
				const filterSelections = document.querySelectorAll('.facetwp-selection-value');
				if (filterSelections.length > 0) {
					filterSelections.forEach((elem) => {

						// add icon to button
						const i = document.createElement('i');
						i.setAttribute('aria-hidden', 'true');
						i.classList.add('fa-regular', 'fa-close');
						elem.appendChild(i);

						// add screen reader text
						const srt = document.createElement('span');
						srt.classList.add('screen-reader-text');
						srt.textContent = " <?php echo $translation; ?>" + ' ' + elem.textContent;
						elem.appendChild(srt);
					});
				}
			}, 100);
		}
	});
	</script>
	<?php
}


function strl_change_facet_label( $label, $params ) {
	switch ( $label ) {
		case 'Publications':
			$label = __( 'News', 'strl-frontend' );
			break;
		case 'Events':
			$label = __( 'Events', 'strl-frontend' );
			break;
		case 'Type':
			$label = __( 'Neighborhoods', 'strl-frontend' );
			break;
	}
	return $label;
};

/**
 * Replace default checkboxes with FA checkboxes
 *
 * @param string $output HTML output of facet
 * @param array $params  facet parameters
 * @return string $output
 */
function strl_add_fa_icon( $output, $params ) {
	if ( 'checkboxes' === $params['facet']['type'] ) {
		$output = str_replace( '<span class="facetwp-display-value">', '<span class="input-replace"><i class="check-icon fa-solid fa-check"></i></span><span class="facetwp-display-value">', $output );
	}
	return $output;
}


/**
 * Overwrites the standard classes for a FacetWP template wrapper
 *
 * @package strl
 */
function strl_replace_facetwptemplate_class( $output, $atts ) {
	if ( array_key_exists( 'template', $atts ) ) {
		switch ( $atts['template'] ) {
			case 'your_template_shortcode_name':
				$output = str_replace( 'class="facetwp-template"', 'class="facetwp-template grid-x grid-margin-x grid-margin-y large-up-2 medium-up-2 small-up-1"', $output );
				break;
			default:
				$output = str_replace( 'class="facetwp-template"', 'class="facetwp-template grid-x grid-margin-x grid-margin-y large-up-2 medium-up-2 small-up-1"', $output );
				break;
		}
	}

	return $output;
}

/**
 * Adds custom Facet types
 *
 * @package strl
 */
function strl_add_facet( $facet_types ) {
	$facet_types['strl_taxonomy_checkbox'] = new FacetWP_Facet_Taxonomy_checkbox();
	$facet_types['strl_taxonomy_radio']    = new FacetWP_Facet_Taxonomy_radio();
	return $facet_types;
}

class FacetWP_Facet_Taxonomy_Checkbox {
	function __construct() {
		$this->label = __( 'STRL Taxonomy Checkbox', 'fwp' );
	}

	// Load the available choices
	function load_values( $params ) {
		global $wpdb;

		$facet        = $params['facet'];
		$from_clause  = $wpdb->prefix . 'facetwp_index f';
		$where_clause = $params['where_clause'];

		// Count setting
		$limit        = ctype_digit( $facet['count'] ) ? $facet['count'] : 10;
		$from_clause  = apply_filters( 'facetwp_facet_from', $from_clause, $facet );
		$where_clause = apply_filters( 'facetwp_facet_where', $where_clause, $facet );
		$sql          = "
		SELECT f.facet_value, f.facet_display_value, f.term_id, f.parent_id, f.depth, COUNT(DISTINCT f.post_id) AS counter
		FROM $from_clause
		WHERE f.facet_name = '{$facet['name']}' $where_clause
		GROUP BY f.facet_value
		ORDER BY f.depth, counter DESC, f.facet_display_value ASC
		LIMIT $limit";

		return $wpdb->get_results( $sql, ARRAY_A ); // phpcs:ignore
	}


	// Generate the output HTML
	function render( $params ) {

		$output          = '';
		$facet           = $params['facet'];
		$values          = (array) $params['values'];
		$selected_values = (array) $params['selected_values'];
		$key             = 0;
		$showcount       = $params['facet']['showcount'];
		$source          = str_replace( 'tax/', '', $params['facet']['source'] );
		$values          = get_terms( $source, array( 'hide_empty' => false ) );
		$selected        = in_array( $params['facet']['label_any'], $selected_values, true ) ? ' checked ' : ' ';
		if ( ! empty( $params['facet']['label_any'] ) ) {
			$output .= '<div class="facetwp-checkbox' . $selected . '" data-value="">';
			$output .= esc_html( $params['facet']['label_any'] );
			$output .= '</div>';
		}

		foreach ( $values as $key => $result ) {
			$selected  = in_array( $result->slug, $selected_values, true ) ? ' checked' : '';
			$selected .= ( 0 === $result->count && '' === $selected ) ? ' disabled' : '';
			$output   .= '<div class="facetwp-checkbox' . $selected . '" data-value="' . esc_attr( $result->slug ) . '">';
			$output   .= esc_html( $result->name );
			if ( $showcount ) {
				$output .= ' <span class="facetwp-counter">(' . $result->count . ')</span>';
			}
			$output .= '</div>';
		}

		return $output;
	}

	/**
	 * Return array of post IDs matching the selected values
	 * using the wp_facetwp_index table
	 */
	function filter_posts( $params ) {
		global $wpdb;

		$output          = array();
		$facet           = $params['facet'];
		$selected_values = $params['selected_values'];
		$sql             = $wpdb->prepare(
			"SELECT DISTINCT post_id
			FROM {$wpdb->prefix}facetwp_index
			WHERE facet_name = %s",
			$facet['name']
		);

		foreach ( $selected_values as $key => $value ) {
			$results = facetwp_sql( $sql . " AND facet_value IN ('$value')", $facet );
			$output  = ( $key > 0 ) ? array_intersect( $output, $results ) : $results;

			if ( empty( $output ) ) {
				break;
			}
		}

		return $output;
	}

	// Load and save facet settings
	function admin_scripts() {
		?>
		<script>
		(function($){
			FWP.hooks.addAction('facetwp/load/strl_taxonomy_checkbox', function($this, obj){
				$this.find('.facet-source').val(obj.source);
				$this.find('.facet-count').val(obj.count);
			});

			FWP.hooks.addFilter('facetwp/save/strl_taxonomy_checkbox', function(obj, $this){
				obj['source'] = $this.find('.facet-source').val();
				obj['count'] = $this.find('.facet-count').val();
				return obj;
			});
		})(jQuery);
		</script>
		<?php
	}


	/**
	 * Parse the facet selections + other front-facing handlers
	 */
	function front_scripts() {
		?>
		<script>
			(function($){
				FWP.hooks.addAction('facetwp/refresh/strl_taxonomy_checkbox', function($this, facet_name){
					var selected_values = [];
					$this.find('.facetwp-checkbox.checked').each (function(){
						selected_values.push($(this).attr('data-value'));
					});
					FWP.facets[facet_name] = selected_values;
				});

				FWP.hooks.addFilter('facetwp/selections/strl_taxonomy_checkbox', function(output, params){
					var choices = [];
					$.each (params.selected_values, function(idx, val){
						var choice = params.el.find('.facetwp-checkbox[data-value="' + val + '"]').clone();
						choice.find('.facetwp-counter').remove();
						choices.push({
							value: val,
							label: choice.text()
						});
					});
					return choices;
				});

				$(document).on('click', '.facetwp-type-strl_taxonomy_checkbox .facetwp-checkbox:not(.disabled)', function(){
					$(this).toggleClass('checked');
					FWP.autoload();
				});
			})(jQuery);
		</script>
		<?php
	}


	/**
	 * Admin settings HTML
	 */
	function settings_html() {
		?>
		<tr>
			<td>
				<?php _e( 'Default label', 'fwp' ); ?>:
				<div class="facetwp-tooltip">
					<span class="icon-question">?</span>
					<div class="facetwp-tooltip-content"><?php _e( 'Customize the \'Any\' label ', 'fwp' ); ?></div>
				</div>
			</td>
			<td><input type="text" class="facet-label-any"  /></td>
		</tr>
		<tr>
			<td>
				<?php _e( 'Show count label', 'fwp' ); ?>:
				<div class="facetwp-tooltip">
					<span class="icon-question">?</span>
					<div class="facetwp-tooltip-content"><?php _e( 'Show the amount of items per term', 'fwp' ); ?></div>
				</div>
			</td>
			<td><input type="checkbox" class="facet-showcount" /></td>
		</tr>
		<?php
	}
}


class FacetWP_Facet_Taxonomy_Radio {
	function __construct() {
		$this->label = __( 'STRL Taxonomy Radio', 'fwp' );
	}


	// Load the available choices

	function load_values( $params ) {
		global $wpdb;

		$facet        = $params['facet'];
		$from_clause  = $wpdb->prefix . 'facetwp_index f';
		$where_clause = $params['where_clause'];

		// Count setting
		$limit        = ctype_digit( $facet['count'] ) ? $facet['count'] : 10;
		$from_clause  = apply_filters( 'facetwp_facet_from', $from_clause, $facet );
		$where_clause = apply_filters( 'facetwp_facet_where', $where_clause, $facet );

		$sql = "
		SELECT f.facet_value, f.facet_display_value, f.term_id, f.parent_id, f.depth, COUNT(DISTINCT f.post_id) AS counter
		FROM $from_clause
		WHERE f.facet_name = '{$facet['name']}' $where_clause
		GROUP BY f.facet_value
		ORDER BY f.depth, counter DESC, f.facet_display_value ASC
		LIMIT $limit";

		return $wpdb->get_results( $sql, ARRAY_A ); // phpcs:ignore
	}


	// Generate the output HTML

	function render( $params ) {

		$output          = '';
		$facet           = $params['facet'];
		$values          = (array) $params['values'];
		$selected_values = (array) $params['selected_values'];
		$key             = 0;
		$showcount       = $params['facet']['showcount'];
		$source          = str_replace( 'tax/', '', $params['facet']['source'] );
		$values          = get_terms( $source, array( 'hide_empty' => false ) );
		$selected        = in_array( $params['facet']['label_any'], $selected_values, true ) ? ' checked' : '';
		$selected       .= ( 0 === $result->count && '' === $selected ) ? ' ' : ' ';
		if ( ! empty( $params['facet']['label_any'] ) ) {
			$output .= '<div class="facetwp-radio' . $selected . '" data-value="">';
			$output .= esc_html( $params['facet']['label_any'] );
			$output .= '</div>';
		}

		foreach ( $values as $key => $result ) {
			$selected  = in_array( $result->slug, $selected_values, true ) ? ' checked' : '';
			$selected .= ( 0 === $result->count && '' === $selected ) ? ' disabled' : '';
			$output   .= '<div class="facetwp-radio' . $selected . '" data-value="' . esc_attr( $result->slug ) . '">';
			$output   .= esc_html( $result->name );
			if ( $showcount ) {
				$output .= ' <span class="facetwp-counter">(' . $result->count . ')</span>';
			}
			$output .= '</div>';
		}

		return $output;
	}

	/**
	 * Return array of post IDs matching the selected values
	 * using the wp_facetwp_index table
	 */
	function filter_posts( $params ) {
		global $wpdb;

		$output          = array();
		$facet           = $params['facet'];
		$selected_values = $params['selected_values'];

		$sql = $wpdb->prepare(
			"SELECT DISTINCT post_id
			FROM {$wpdb->prefix}facetwp_index
			WHERE facet_name = %s",
			$facet['name']
		);

		foreach ( $selected_values as $key => $value ) {
			$results = facetwp_sql( $sql . " AND facet_value IN ('$value')", $facet );
			$output  = ( $key > 0 ) ? array_intersect( $output, $results ) : $results;

			if ( empty( $output ) ) {
				break;
			}
		}

		return $output;
	}


	// Load and save facet settings

	function admin_scripts() {
		?>
		<script>
		(function($){
			FWP.hooks.addAction('facetwp/load/strl_taxonomy_radio', function($this, obj){
				$this.find('.facet-source').val(obj.source);
				$this.find('.facet-count').val(obj.count);
			});

			FWP.hooks.addFilter('facetwp/save/strl_taxonomy_radio', function(obj, $this){
				obj['source'] = $this.find('.facet-source').val();
				obj['count'] = $this.find('.facet-count').val();
				return obj;
			});
		})(jQuery);
		</script>
		<?php
	}

	function front_scripts() {
		?>
		<script>
			(function($){
				FWP.hooks.addAction('facetwp/refresh/strl_taxonomy_radio', function($this, facet_name){
					var selected_values = [];
					$this.find('.facetwp-radio.checked').each (function(){
						selected_values = $(this).attr('data-value');
					});
					FWP.facets[facet_name] = selected_values;
				});

				FWP.hooks.addFilter('facetwp/selections/strl_taxonomy_radio', function(output, params){
					var choices = [];
					$.each (params.selected_values, function(idx, val){
						var choice = params.el.find('.facetwp-radio[data-value="' + val + '"]').clone();
						choice.find('.facetwp-counter').remove();
						choices.push({
							value: val,
							label: choice.text()
						});
					});
					return choices;
				});

				$(document).on('click', '.facetwp-type-strl_taxonomy_radio .facetwp-radio:not(.disabled)', function(){
					$(this).parent().find('.facetwp-radio:not(.disabled)').removeClass('checked');
					$(this).addClass('checked');
					FWP.autoload();
				});
			})(jQuery);
		</script>
		<?php
	}

	function settings_html() {
		?>
		<tr>
			<td>
				<?php _e( 'Default label', 'fwp' ); ?>:
				<div class="facetwp-tooltip">
					<span class="icon-question">?</span>
					<div class="facetwp-tooltip-content"><?php _e( 'Customize the \'Any\' label ', 'fwp' ); ?></div>
				</div>
			</td>
			<td><input type="text" class="facet-label-any"  /></td>
		</tr>
		<tr>
			<td>
				<?php _e( 'Show count label', 'fwp' ); ?>:
				<div class="facetwp-tooltip">
					<span class="icon-question">?</span>
					<div class="facetwp-tooltip-content"><?php _e( 'Show the amount of items per term', 'fwp' ); ?></div>
				</div>
			</td>
			<td><input type="checkbox" class="facet-showcount" /></td>
		</tr>
		<?php
	}
}
