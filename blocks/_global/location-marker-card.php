<?php
$post_id       = get_the_ID();
$title         = get_the_title( $post_id );
$address       = get_field( 'location-address', $post_id );
$description   = get_field( 'location-description', $post_id );
$street        = ! empty( $address['street_name'] ) ? $address['street_name'] . ( ! empty( $address['street_number'] ) ? ' ' . $address['street_number'] : '' ) : '';
$city          = ! empty( $address['city'] ) ? $address['city'] : '';
$zipcode       = ! empty( $address['post_code'] ) ? $address['post_code'] : '';
$location_name = ! empty( $address['name'] ) ? str_replace( ' ', ' +', $address['name'] ) : '';
$lat           = ! empty( $address['lat'] ) ? $address['lat'] : '';
$lng           = ! empty( $address['lng'] ) ? $address['lng'] : '';
$route         = '';

if ( ! empty( $location_name ) && ! empty( $lat ) && ! empty( $lng ) ) {
	$route = 'https://www.google.nl/maps/dir//' . $location_name . '/@' . $lat . ',' . $lng . ',7z/data=!4m2!4m1!3e0';
}

$address_nice_name = '';

if ( ! empty( $street ) ) {
	$address_nice_name .= $street;
}

if ( ! empty( $zipcode ) ) {
	$address_nice_name .= ! empty( $address_nice_name ) ? ', ' . $zipcode : $zipcode;
}

if ( ! empty( $city ) ) {
	$address_nice_name .= ! empty( $address_nice_name ) ? ' ' . $city : $city;
}

?>
<div class="location-marker-card" data-id="<?php echo $post_id; ?>">
	<div class="wrapper">
		<div>
			<h3 class="h4"><?php echo $title; ?></h3>
			<?php echo ! empty( $description ) ? '<div class="description text">' . $description . '</div>' : ''; ?>
			<?php echo ! empty( $address_nice_name ) ? '<span>' . $address_nice_name . '</span>' : ''; ?>
		</div>
		<?php echo ! empty( $route ) ? '<a href="' . $route . '" target="_blank" rel="noopener noreferrer">' . __( 'Show route', 'strl' ) . '</a>' : ''; ?>
	</div>
</div>