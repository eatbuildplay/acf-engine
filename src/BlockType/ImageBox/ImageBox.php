<?php

namespace AcfEngine\Core\BlockType;

if (!defined('ABSPATH')) {
	exit;
}

class ImageBox extends BlockType {

  public function key() {
		return 'image_box';
	}

  public function title() {
    return 'Image Box';
  }

  public function description() {
    return 'ACFG Image Box';
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
	    ob_start();
        $image  = get_field('image');
        $size = 'full';
        $boxedWidth = get_field( 'boxed_width' );
	    ?>

        <div class="acfg-image-box">
            <figure>
                <?= wp_get_attachment_image( $image, $size ) ?>
                <figcaption><?= get_field( 'caption' ) ?></figcaption>
            </figure>
        </div>
        <style>
            .acfg-image-box {
                max-width: 100%;
                text-align: <?= get_field( 'alignment' ) ?>;
            }
            <?php if  ($boxedWidth) { ?>
            .acfg-image-box  {
                max-width: <?= get_field( 'max_width' ) ?>px !important;
                margin-right: auto;
                margin-left: auto;
            }
            <?php } ?>
            .acfg-image-box figcaption {
                font-size: <?= get_field('text_image_box')['font_size'] ?>px;
                font-weight: <?= get_field('text_image_box')['font_weight'] ?>;
                color: <?= get_field('text_image_box')['color'] ?>;
                background-color: <?= get_field('text_image_box')['background_color'] ?>;
                padding: <?= get_field('text_image_box')['padding'] ?>px;
                margin: <?= get_field('text_image_box')['margin'] ?>px;
            }
        </style>
        <?php
      print ob_get_clean();
	}

}
