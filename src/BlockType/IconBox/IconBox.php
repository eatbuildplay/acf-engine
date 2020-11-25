<?php

namespace AcfEngine\Core\BlockType;

if (!defined('ABSPATH')) {
	exit;
}

class IconBox extends BlockType {

  public function key() {
		return 'icon_box';
	}

  public function title() {
    return 'Icon Box';
  }

  public function description() {
    return 'A single icon box.';
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
        $boxedWidth = get_field( 'boxed_width_icon_box' );
        ?>

        <div class="acfg-icon-box">
            <div class="acfg-iconbox">
                <span class="dashicons <?= get_field( 'icon_box' ) ?>"></span>
            </div>
            <div class="acfg-text">
                <span class="acfg-box"><?= get_field( 'text_icon_box' ) ?></span>
            </div>
        </div>

        <style>
            .acfg-iconbox .dashicons {
                font-size: <?= get_field( 'width_icon_box' ) ?>px;
                width: <?= get_field( 'width_icon_box' ) ?>px;
                height: <?= get_field( 'height_icon_box' ) ?>px;
                color: <?= get_field( 'color_icon_box' ) ?>;
            }
            <?php if  ($boxedWidth) { ?>
                .acfg-icon-box {
                    max-width: <?= get_field( 'max_width_icon_box' ) ?>px !important;
                    margin-right: auto;
                    margin-left: auto;
                }
            <?php } ?>
            .acfg-icon-box {
                text-align: <?= get_field( 'alignment_icon_box' ) ?>;
            }
            .acfg-text {
                padding: <?= get_field('icon_box_group')['padding'] ?>px;
                margin: <?= get_field('icon_box_group')['margin'] ?>px;
            }
            .acfg-text .acfg-box {
                font-size: <?= get_field('icon_box_group')['font_size'] ?>px;
                font-weight: <?= get_field('icon_box_group')['font_weight'] ?>;
                color: <?= get_field('icon_box_group')['color'] ?>;
            }
        </style>

        <?php
		print ob_get_clean();
	}

}
