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
$logo              = ! empty( get_field( 'global-logo-options_logo', 'option' ) ) ? wp_get_attachment_image_url( get_field( 'global-logo-options_logo', 'option' ) ) : '';
$mobile_logo       = ! empty( get_field( 'global-logo-options_logo-mobile', 'option' ) ) ? wp_get_attachment_image_url( get_field( 'global-logo-options_logo-mobile', 'option' ) ) : $logo;
$logo_height       = ! empty( get_field( 'global-logo-options_logo-height', 'option' ) ) ? get_field( 'global-logo-options_logo-height', 'option' ) : '';
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
	<?php wp_body_open(); ?>

	<?php echo strl_alert_bar(); ?>
	<header id="site-header" class="site-header">
		<a href="#main" class="skiplink"><?php _e( 'To main content', 'strl-frontend' ); ?></a>
		<a href="#menu" class="skiplink"><?php _e( 'To navigation', 'strl-frontend' ); ?></a>
		<div class="grid-x grid-margin-x">
			<div class="cell">
				<div class="header-wrapper">
					<?php
					if ( ! empty( $logo ) ) {
						?>
						<div class="site-branding">
							<a id="logo" style="background-image:url('<?php echo $logo; ?>'); <?php echo ! empty( $logo_height ) ? 'height:' . $logo_height . 'px;' : ''; ?> " class="<?php echo "site-$site_id"; ?>" href="<?php bloginfo( 'wpurl' ); ?>"><?php bloginfo( 'sitename' ); ?></a>
						</div>
						<?php
					}
					?>

					<div id="menus">
						<nav id="menu" aria-label="Main menu">
							<?php strl_menu_main( 'main' ); ?>
						</nav>
						<nav id="submenu" aria-label="Submenu">
							<form id="headersearch" action="<?php echo get_permalink( strl_get_default_page_for( 'search' ) ); ?>" method="get" aria-haspopup="true">
								<label for="s" style="position: absolute; left: -9999px;"><?php _e( 'Fill in your search terms', 'strl-frontend' ); ?></label>
								<input placeholder="<?php _e( 'Fill in your search terms', 'strl-frontend' ); ?>" type="text" name="_search_search" value="" data-swpengine="default" data-aria-label="<?php _e( 'Fill in your search terms', 'strl-frontend' ); ?>" data-swplive="true" />
								<button type="submit">
									<i class="fa-regular fa-magnifying-glass"></i>
									<span class="screen-reader-text"><?php _e( 'search', 'strl-frontend' ); ?></span>
								</button>
							</form>
						</nav>
					</div>

					<div class="mobile-menu">
						<div class="searchtoggle">
							<button class="search-icon" type="button" onclick="location.href='<?php echo get_permalink( strl_get_default_page_for( 'search' ) ); ?>'">
								<i class="fa-solid fa-magnifying-glass"></i>
								<span class="screen-reader-text"><?php _e( 'Search', 'strl-frontend' ); ?></span>
							</button>
						</div>

						<button class="menutoggle" data-toggle="offCanvas" tabindex="0">
							<span class="menu-icon" data-toggle="menus">
								<i class="far fa-bars"></i>
								<i class="far fa-times"></i>
								<span class="screen-reader-text"><?php _e( 'Menu', 'strl-frontend' ); ?></span>
							</span>
						</button>
					</div>
				</div>
				<?php
				if ( ! is_singular( 'article' ) && ! is_singular( 'councillor' ) && ! is_singular( 'event' ) && ! is_page_template( 'search-template.php' ) ) {
					$has_offset = 'show' === $breadcrumbs_toggle ? true : false;
					echo strl_add_read_speaker( $breadcrumbs_toggle );
				}
				?>
			</div>
		</div>
	</header>

	<div class="off-canvas bg-primary position-right" id="offCanvas" data-auto-focus="true" data-off-canvas>
		<div class="canvas-header">
			<?php
			if ( ! empty( $mobile_logo ) ) {
				?>
				<div class="site-branding">
					<a class="logo" href="<?php bloginfo( 'wpurl' ); ?>" style="background-image:url('<?php echo $mobile_logo; ?>');"><?php bloginfo( 'sitename' ); ?></a>
				</div>
				<?php
			}
			?>
			<div class="menutoggle-container">
				<div class="menutoggle menu-open">
					<button class="menu-icon close-menu" aria-label="<?php _e( 'Close menu', 'strl' ); ?>" type="button" tabindex="0">
						<span class="screen-reader-text">
							<?php _e( 'Close Menu', 'strl-frontend' ); ?>
						</span>
						<i class="fa-regular fa-close"></i>
					</button>
				</div>
			</div>
		</div>

		<nav id="offcanvas-main" aria-label="Main navigation">
			<?php strl_menu_main( 'main' ); ?>
		</nav>
	</div>

	<main id="main" class="<?php echo true === $show_read_speaker ? 'extra-margin' : ''; ?>">
		<?php
		strl_include_breadcrumbs( $post_id, $breadcrumbs_toggle );
		?>
