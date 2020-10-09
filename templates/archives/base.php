<?php get_header(); ?>

<?php

function acf_engine_get_archive_loop_content( $postId ) {

  $templateId = 296;
  $template = get_post( $templateId );
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

}


while ( have_posts() ) {

  the_post();
  $postType = get_post_type();
  $postID = get_the_ID();
  acf_engine_get_archive_loop_content( $postID );

}

?>

<?php get_footer(); ?>
