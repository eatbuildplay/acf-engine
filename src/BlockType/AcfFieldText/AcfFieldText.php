<?php

namespace AcfEngine\Core\BlockType;

if (!defined('ABSPATH')) {
	exit;
}

class AcfFieldText extends BlockType {

  public function key() {
		return 'acf_field_text';
	}

  public function title() {
    return 'ACF Field Text';
  }

  public function description() {
    return 'Render a single ACF text field using default render template or custom template';
  }

  public function renderCallback() {
    return [$this, 'callback'];
  }

  public function callback( $block, $content = '', $isPreview, $editorPostId ) {

		if( $isPreview ) {

			$previewPost = $this->getPreviewPost( $editorPostId );
			$postId = $previewPost->ID;

			$fieldKey = get_field('meta_key');
	    $fieldPostId = get_field('post_id');

			if( $fieldPostId == 'current' ) {
				$fieldValue = get_field( $fieldKey, $previewPost->ID );
				$fieldObject = get_field_object( $fieldKey, $previewPost->ID);
			} else {
				$fieldValue = get_field( $fieldKey, $fieldPostId );
				$fieldObject = get_field_object( $fieldKey, $fieldPostId);
			}

		} else {

			// live render
			$postId = $editorPostId;
			$fieldKey = get_field('meta_key');
	    $fieldPostId = get_field('post_id');

			if( $fieldPostId == 'current' ) {
				$fieldValue = get_field( $fieldKey, $editorPostId );
				$fieldObject = get_field_object( $fieldKey, $editorPostId );
			} else {
				$fieldValue = get_field( $fieldKey, $fieldPostId );
				$fieldObject = get_field_object( $fieldKey, $fieldPostId );
			}

		}

		if( $fieldValue == '' ) {
			return;
		}

    $this->render( $fieldObject, $fieldValue, $postId );

  }


	protected function render( $fieldObject, $fieldValue, $postId ) {

		$wrapTag = get_field('wrap_tag');
    $prepend = get_field('prepend');
    $append = get_field('append');

		print '<' . $wrapTag . ' class="acfg-field-text">';

    if( $prepend ) {
      print '<span class="prepend">' . $prepend . '</span>';
    }

		$tl = new \AcfEngine\Core\TemplateLoader();
		$tl->path = 'templates/fields/text/';
		$tl->name = 'default';
		$tl->data = [
			'value' 	=> $fieldValue,
			'field' 	=> $fieldObject,
			'postId' 	=> $postId
		];

		$tl->render();

    print '</' . $wrapTag . '>';

	}

  public function enqueueStyle() {
    return ACF_ENGINE_URL . 'src/BlockType/AcfFieldText/styles.css';
  }

}
