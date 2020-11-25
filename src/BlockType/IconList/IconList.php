<?php

namespace AcfEngine\Core\BlockType;

if (!defined('ABSPATH')) {
	exit;
}

class IconList extends BlockType {

  public function key() {
		return 'icon_list';
	}

  public function title() {
    return 'Icon List';
  }

  public function description() {
    return 'A single icon list.';
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
        $boxedWidth = get_field( 'boxed_width_icon_list' );
        ?>

        <div class="acfg-icon-list">
            <div class="acfg-iconlist">
                <span class="dashicons <?= get_field( 'icon_list' ) ?>"></span>
            </div>
            <div class="acfg-text">
                <span class="acfg-list"><?= get_field( 'text_icon_list' ) ?></span>
            </div>
        </div>

        <style>
            .acfg-icon-list .acfg-iconlist .dashicons {
                font-size: <?= get_field( 'width_icon_list' ) ?>px;
                width: <?= get_field( 'width_icon_list' ) ?>px;
                height: <?= get_field( 'height_icon_list' ) ?>px;
                color: <?= get_field( 'color_icon_list' ) ?>;
            }
            <?php if  ($boxedWidth) { ?>
            .acfg-icon-list {
                max-width: <?= get_field( 'max_width_icon_list' ) ?>px !important;
                margin-right: auto;
                margin-left: auto;
            }
            <?php } ?>
            .acfg-icon-list {
                text-align: left;
                display: flex;
                align-items: center;
            }
            .acfg-icon-list .acfg-text {
                padding: <?= get_field('icon_list_group')['padding'] ?>px;
                margin: <?= get_field('icon_list_group')['margin'] ?>px;
                line-height: 1.5;
            }
            .acfg-icon-list .acfg-text .acfg-list {
                font-size: <?= get_field('icon_list_group')['font_size'] ?>px;
                font-weight: <?= get_field('icon_list_group')['font_weight'] ?>;
                color: <?= get_field('icon_list_group')['color'] ?>;
            }
        </style>

        <?php
        print ob_get_clean();
	}

}
