<?php get_header(); ?>

<?php

function acf_engine_get_archive_loop_content( $postId, $templateId ) {

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

print '<div class="acfg-grid acfg-grid-boxed">';

$archiveTemplates = $GLOBALS['acfg_archive_templates'];
$archiveTemplate = end( $archiveTemplates ); // take last one for now
$archiveTemplateId = $archiveTemplate['id'];

while ( have_posts() ) {

  print '<div class="acfg-grid-item">';

  the_post();
  $postType = get_post_type();
  $postID = get_the_ID();
  acf_engine_get_archive_loop_content( $postID, $archiveTemplateId );

  print '</div>';

}

print '</div>';

?>

<style>
.acfg-grid-boxed {
  max-width: 960px;
  margin: 0 auto;
}
.acfg-grid {
  display: flex;
  flex-wrap: wrap;
}
.acfg-grid-item {
  max-width: 50%;
}
</style>

<?php get_footer(); ?>
