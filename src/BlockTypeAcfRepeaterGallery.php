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

		print '

		<div class="splide">
			<div class="splide__track">
				<ul class="splide__list">
					<li class="splide__slide">Slide 01</li>
					<li class="splide__slide">Slide 02</li>
					<li class="splide__slide">Slide 03</li>
				</ul>
			</div>
		</div>

		';

		// set inner blocks that were parsed from block already before calling render_block()
		$innerBlocks = $GLOBALS['acfg_loop_inner_blocks'];

		// get the field key and load field object
		$repeaterFieldKey = get_field( 'meta_key' );
		$repeaterFieldObject = get_field_object( $repeaterFieldKey, $postId );

		// arrange subfields by name so they can be referenced
		$subfieldsOriginal = $repeaterFieldObject['sub_fields'];
		$subfieldsKeyed = [];
		foreach( $subfieldsOriginal as $subfield ) {
			$subfieldsKeyed[ $subfield['name'] ] = $subfield;
		}

		while ( have_rows( $repeaterFieldObject['key'], $postId )) :

			the_row();

			foreach( $innerBlocks as $block ) {

				$metaKey = $block['attrs']['data']['meta_key'];
				$subfieldValue = get_sub_field( $subfieldsKeyed[$metaKey]['key'] );
				$GLOBALS['acfg_loop_field_value'] = $subfieldValue;
				print render_block( $block );

			}

		endwhile;

	}

}
