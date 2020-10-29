<?php

namespace AcfEngine\Core\BlockType;

if (!defined('ABSPATH')) {
	exit;
}

class AcfField extends BlockType {

  public function key() {
		return 'acf_field';
	}

  public function title() {
    return 'ACF Field';
  }

  public function description() {
    return 'Render a single ACF field using default render template or custom template';
  }

  public function renderCallback() {
    return [$this, 'callback'];
  }

  public function callback( $block, $content = '', $isPreview, $editorPostId ) {

		if( isset( $GLOBALS['acfg_loop_field_value'] )) {
			print '<div class="acfg-field">';
	    print $GLOBALS['acfg_loop_field_value'];
			print '</div>';
			return;
		}

		if( $isPreview ) {
			$templatePostType = get_field('post_type', $editorPostId);

			$previewPosts = get_posts([
				'post_type' => $templatePostType
			]);
			if( empty( $previewPosts )) {
				print 'SORRY NO POSTS AVAILABLE TO USE FOR PREVIEW.';
				return;
			}

			$previewPost = $previewPosts[0];
			$fieldKey = get_field('meta_key');
	    $fieldPostId = get_field('post_id');
			if( $fieldPostId == 'current' ) {
				$fieldValue = get_field( $fieldKey, $previewPost->ID );
				$fieldObject = get_field_object( $fieldKey, $previewPost->ID);
			} else {
				$fieldValue = get_field( $fieldKey, $fieldPostId );
				$fieldObject = get_field_object( $fieldKey, $fieldPostId);
			}

			print '<h2>';
	    print $fieldValue;
	    print '</h2>';
			return;

		}

    $data = $block['data'];
    $fieldKey = get_field('meta_key');
    $fieldPostId = get_field('post_id');
		$wrapTag = get_field('wrap_tag');

		if( $fieldPostId == 'current' ) {
			$fieldValue = get_field( $fieldKey, $editorPostId );
			$fieldObject = get_field_object( $fieldKey, $editorPostId );
		} else {
			$fieldValue = get_field( $fieldKey, $fieldPostId );
			$fieldObject = get_field_object( $fieldKey, $fieldPostId );
		}

		if( $fieldValue == '' || $wrapTag == '' ) {
			return;
		}

    print '<' . $wrapTag . '>';

		$tl = new TemplateLoader();
		$tl->path = 'templates/fields/' . $fieldObject['type'] . '/';
		$tl->name = 'default';
		$tl->data = [
			'field' => $fieldObject,
			'postId' => $editorPostId
		];

		//var_dump( $tl );

		$tl->render();

    print '</' . $wrapTag . '>';

  }

	protected function renderPreview() {




	}

	protected function renderFront() {



	}

}
