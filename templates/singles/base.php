<?php get_header(); ?>


<?php

$template = get_post( 291 );
$content = $template->post_content;


// If there are blocks in this content, we shouldn't run wpautop() on it later.
$priority = has_filter( 'the_content', 'wpautop' );
if ( false !== $priority && doing_filter( 'the_content' ) && has_blocks( $content ) ) {
	remove_filter( 'the_content', 'wpautop', $priority );
	add_filter( 'the_content', '_restore_wpautop_hook', $priority + 1 );
}

$blocks = parse_blocks( $content );
$output = '';

foreach ( $blocks as $block ) {
  $output .= render_block( $block );
}

print $output;

?>




<?php get_footer(); ?>
