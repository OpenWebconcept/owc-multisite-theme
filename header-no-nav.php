<?php
$site_id = get_current_blog_id();
if ( is_404() ) {
	$page_id = strl_get_default_page_for( 'not-found' );
	$general = get_field( 'settings-group', $page_id );
} else {
	$general = get_field( 'settings-group' );
}
$post_id            = get_the_ID();
$breadcrumbs_toggle = get_field( 'breadcrumbs-group_breadcrumbs-toggle', $post_id );
$link_preload       = preload_header_image();

$post_type     = get_post_type();
$nofollow_meta = '';
$has_single    = get_field( 'publication-single', $post_id );
if ( 'publication' === $post_type && false === $has_single ) {
	$nofollow_meta = '<meta name="robots" content="noindex, nofollow">';
}
$show_read_speaker = ! empty( get_field( 'strl-global-read-speaker-toggle', 'options' ) ) ? get_field( 'strl-global-read-speaker-toggle', 'options' ) : false;
?>
<!doctype html>
<html class="no-js" <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<?php
	echo $nofollow_meta;
	wp_head();
	echo $link_preload;
	require_once 'styling.php';
	?>
</head>

<body <?php body_class( "site-$site_id" ); ?>>
	<?php
	wp_body_open();
	echo strl_alert_bar();
	?>
	<main id="main" class="<?php echo true === $show_read_speaker ? 'extra-margin' : ''; ?>">
		<?php
		strl_include_breadcrumbs( $post_id, $breadcrumbs_toggle );
		?>
