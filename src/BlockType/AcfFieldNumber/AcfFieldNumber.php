<?php

namespace AcfEngine\Core\BlockType;

if (!defined('ABSPATH')) {
	exit;
}

class AcfFieldNumber extends BlockType {

  public function key() {
		return 'acf_field_number';
	}

  public function title() {
    return 'ACF Number Field';
  }

  public function description() {
    return 'Render a single ACF number field with formatting options.';
  }

  public function renderCallback() {
    return [$this, 'callback'];
  }

  public function callback( $block, $content = '', $isPreview, $editorPostId ) {

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
			$numberPrepend = get_field('number_prepend');
	    $numberAppend = get_field('number_append');

			if( $fieldPostId == 'current' ) {
				$fieldValue = get_field( $fieldKey, $previewPost->ID );
			} else {
				$fieldValue = get_field( $fieldKey, $fieldPostId );
			}

			print '<h2>';
	    print $numberPrepend . $fieldValue . $numberAppend;
	    print '</h2>';
			return;

		}

    $data = $block['data'];
    $fieldKey = get_field('meta_key');
    $fieldPostId = get_field('post_id');
    $numberPrepend = get_field('number_prepend');
    $numberAppend = get_field('number_append');

		if( $fieldPostId == 'current' ) {
			$fieldValue = get_field( $fieldKey, $editorPostId );
		} else {
			$fieldValue = get_field( $fieldKey, $fieldPostId );
		}

    print '<h2>';
    print $numberPrepend . $fieldValue . $numberAppend;
    print '</h2>';

  }

}
