<?php
$postid  = get_the_ID();
$title   = get_the_title( $postid );
$link    = get_the_permalink( $postid );
$excerpt = get_field( 'settings-group_post-excerpt-content' ); // use "get_field( 'search-content' )" for search results if available
$cptslug = get_post_type( $postid );
$type    = ! empty( get_post_type_object( $cptslug ) ) ? get_post_type_object( $cptslug )->labels->singular_name : '';

switch ( $type ) {
	case 'Publicatie':
		$type = __( 'News', 'strl-frontend' );
		break;
	default:
		$type = $type;
		break;
}
?>
<div class="grid-card-search cell">
	<div class="wrapper bg-white">
		<?php echo ! empty( $date ) ? '<span class="date">' . $date . '</span>' : ''; ?>
		<h3><?php echo $title; ?></h3>
		<?php echo ! empty( $excerpt ) ? '<p class="excerpt">' . strl_limit_text( $excerpt, 40 ) . '</p>' : ''; ?>
		<a class="link" href="<?php echo $link; ?>">
			<span class="screen-reader-text"><?php echo sprintf( __( 'Read more about %s', 'strl-frontend' ), $title ); ?></span>
		</a>
		<span class="posttype"><?php echo $type; ?></span>
	</div>
</div>
