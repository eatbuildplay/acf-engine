<?php

namespace AcfEngine\Core\BlockType;

if (!defined('ABSPATH')) {
	exit;
}

class AcfRepeaterTable extends BlockType {

  public function key() {
		return 'acf_repeater_table';
	}

  public function title() {
    return 'ACF Repeater Table';
  }

  public function description() {
    return 'Use an ACF repeater field to make a table display.';
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

		$repeaterFieldKey = get_field( 'meta_key' );
		$repeaterFieldObject = get_field_object( $repeaterFieldKey, $postId );
		$subfields = $repeaterFieldObject['sub_fields'];



		if( have_rows( $repeaterFieldObject['key'], $postId )):

			$loopCount = 0;
			$headers = '<tr>';
			$content = '';

			while ( have_rows( $repeaterFieldObject['key'], $postId )) :

				the_row();

				$content .= '<tr>';

				foreach( $subfields as $index => $subfield ) :

					if( $loopCount == 0 ) {

						$headers .= '<th>';
						$headers .= $subfield['label'];
						$headers .= '</th>';

					}

					$content .= '<td>';

		      $subfieldValue = get_sub_field( $subfield['key'] );

					$tl = new \AcfEngine\Core\TemplateLoader();
		      $tl->path = 'templates/fields/' . $subfield['type'] . '/';
		      $tl->name = 'default';
		      $tl->data = [
		        'field'  => $subfield,
		        'value'  => $subfieldValue,
		  			'postId' => $postId
		      ];
		      $content .= $tl->get();

					$content .= '</td>';

				endforeach;

				$content .= '</tr>';
				$loopCount++;

			endwhile;

			$headers .= '</tr>';

		endif;

		print '<div class="acfg-repeater-table">';
		print '<table>';
		print '<thead>';
		print $headers;
		print '</thead>';
		print '<tbody>';
		print $content;
		print '</tbody>';
		print '</table>';
		print '</div>';

	}

}
