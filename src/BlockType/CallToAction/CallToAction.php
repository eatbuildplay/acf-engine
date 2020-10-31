<?php

namespace AcfEngine\Core\BlockType;

if (!defined('ABSPATH')) {
	exit;
}

class CallToAction extends BlockType {

  public function key() {
		return 'call_to_action';
	}

  public function title() {
    return 'ACFG Call To Action';
  }

  public function description() {
    return 'Adds a CTA (Call to Action).';
  }

  public function renderCallback() {
    return [$this, 'callback'];
  }

  public function callback( $block, $content, $isPreview, $postId ) {
		$this->render( $block, $content, $postId );
  }

	protected function render( $block, $content, $postId ) {

		$heading = get_field('heading');
		$body = get_field('body');

		/* content */
		print '<div class="acfg-call-to-action">';
    print '<h2>' . $heading . '</h2>';
		print '<p>' . $body . '</p>';
		print '</div>';

		/* styles */
		print '<style>';
		print '.acfg-call-to-action {';

			if( $block['align'] == 'center' ) {
				print 'margin: 0 auto; max-width: 800px;';
			}

		print 'background-color: #363688;';
		print 'padding: 50px;';
		print 'width: 500px;';

		print 'cursor: pointer;';


		print '}';
		print '</style>';

	}

}
