<?php get_header(); ?>

<div class="acfg-single-content">

<?php

$singleTemplates = $GLOBALS['acfg_template_singles'];
$singleTemplate = $singleTemplates[0]; // use first template for now

$templateId = $singleTemplate['id'];
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

/* set global that blocks will be checking for if they need the template */
$GLOBALS['acfg_loop_template'] = $templateId;

foreach ( $blocks as $block ) {

	if( 'acf/acfg-acf-repeater-gallery' == $block['blockName'] ) {
		/* set inner blocks global var so they are available in the block render method */
		$GLOBALS['acfg_loop_inner_blocks'] = $block['innerBlocks'];
	}

  $output .= render_block( $block );
}

print $output;

?>

</div><!-- .acfg-single-content -->

<!-- custom css -->
<?php

$css = get_field('css', $templateId);

print '<style>';
print $css;
print '</style>';

?>

<?php get_footer(); ?>
