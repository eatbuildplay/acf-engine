<?php

namespace AcfEngine\Core\BlockType;

if (!defined('ABSPATH')) {
	exit;
}

class Footer extends BlockType {

  public function key() {
		return 'footer';
	}

  public function title() {
    return 'ACFG Footer';
  }

  public function description() {
    return 'Renders a website footer.';
  }

  public function renderCallback() {
    return [$this, 'callback'];
  }

  public function callback( $block, $content, $isPreview, $postId ) {
		$this->render( $block, $content, $postId );
  }

	protected function render( $block, $content, $postId ) {

		$key = get_field('key');
		$tm = new \AcfEngine\Core\TemplateManager();
		$template = $tm->fetchByKey( $key );

		if( !$template ) {
			print 'SORRY THAT TEMPLATE COULD NOT BE FOUND.';
		}

		$content = $this->parseBlockContent( $template->post_content );
		print $content;

	}

}
