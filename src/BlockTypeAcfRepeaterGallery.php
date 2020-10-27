<?php

namespace AcfEngine\Core;

if (!defined('ABSPATH')) {
	exit;
}

class BlockTypeAcfRepeaterGallery extends BlockType {

  public function key() {
		return 'acf_repeater_gallery';
	}

  public function title() {
    return 'ACF Repeater Gallery';
  }

  public function description() {
    return 'Use an ACF repeater field to power a gallery.';
  }

  public function renderCallback() {
    return [$this, 'callback'];
  }

  public function callback( $block, $content, $isPreview, $postId ) {
		if( $isPreview ) {
      $this->renderPreview( $block, $content, $postId );
		} else {
      $this->render( $block, $content, $postId );
    }
  }

	protected function renderPreview( $block, $content, $postId ) {
		print '<InnerBlocks />';
	}

	protected function render( $block, $content, $postId ) {

		$templateId = $GLOBALS['acfg_template_loop'];
		$templatePost = get_post( $templateId );
		$templateContent = $templatePost->post_content;
		$templateBlocks = parse_blocks( $templateContent );

		// here we need to loop over all templateBlocks
		// and find "this one" by matching the ID found in $block

		$innerBlocks = $templateBlocks[0]['innerBlocks']; // temporary presume first block is this one
		$imageBlock = $innerBlocks[0];

		$repeaterFieldKey = get_field( 'meta_key' );
		$repeaterFieldObject = get_field_object( $repeaterFieldKey, $postId );

		$subfields = $repeaterFieldObject['sub_fields'];
		while ( have_rows( $repeaterFieldObject['key'], $postId )) :

			the_row();

			foreach( $subfields as $index => $subfield ) {

				if( $subfield['type'] != 'image' ) { continue; }

				$subfieldValue = get_sub_field( $subfield['key'] );

				$GLOBALS['acfg_dynamic_image_id'] = $subfieldValue;
				print render_block( $imageBlock );


			}

		endwhile;

	}

}
