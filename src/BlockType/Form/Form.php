<?php

namespace AcfEngine\Core\BlockType;

if (!defined('ABSPATH')) {
	exit;
}

class Form extends BlockType {

  public function key() {
		return 'form';
	}

  public function title() {
    return 'Form';
  }

  public function description() {
    return 'A single form.';
  }

  public function renderCallback() {
    return [$this, 'callback'];
  }

  public function callback( $block, $content, $isPreview, $postId ) {

		if( $isPreview ) {
			$previewPost = $this->getPreviewPost( $postId );
			$postId = $previewPost->ID;
    }

		$this->render( $block, $content, $postId );

  }

	protected function render( $block, $content, $postId ) {
		$formKey = get_field( 'form_key' );
		if( !$formKey ) {
			print "Set form key to see form.";
			return;
		}
		acf_form( $formKey );
	}

}
