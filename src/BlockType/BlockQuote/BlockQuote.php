<?php

namespace AcfEngine\Core\BlockType;

if (!defined('ABSPATH')) {
	exit;
}

class BlockQuote extends BlockType {

  public function key() {
		return 'block_quote';
	}

  public function title() {
    return 'Block Quote';
  }

  public function description() {
    return 'Render a block quote.';
  }

  public function renderCallback() {
    return [$this, 'callback'];
  }

  public function callback( $block, $content, $isPreview, $postId ) {


		$this->render( $block, $content, $postId );

  }

	protected function render( $block, $content, $postId ) {
        ob_start(); ?>
        <div class="acfg-blockquote-container">
            <blockquote class="acfg-blockquote"><?= get_field('text') ?></blockquote>
            <cite class="acfg-author">- <?= get_field('author') ?></cite>
        </div>
        <style>
            .acfg-blockquote-container{
                max-width: 600px !important;
                margin: auto;
            }
            .acfg-blockquote{
                font-weight: 100;
                font-style: italic;
                line-height: 1.4;
                position: relative;
                border: none;

                <?php if( $fontSize = get_field('font_size') ) { ?>
                font-size: <?= $fontSize ?>px;
                <?php }else{ ?>
                font-size: 16px;
                <?php } ?>

                <?php if( $padding = get_field('padding') ) { ?>
                padding: <?= $padding ?>px;
                <?php }else{ ?>
                padding: 8px;
                <?php } ?>

                <?php if( $margin = get_field('margin') ) { ?>
                margin: <?= $margin ?>px !important;
                <?php }else{ ?>
                margin: 0 !important;
                <?php } ?>

                <?php if( $color = get_field('color') ) { ?>
                    color: <?= $color ?>;
                <?php }else{ ?>
                    color: #000;
                <?php } ?>
            }
            .acfg-blockquote:before,
            .acfg-blockquote:after {
                position: absolute;
                color: #777777;
                font-size: 8rem;
                width: 4rem;
                height: 4rem;
            }

            .acfg-blockquote:before {
                content: '“';
                left: -5rem;
                top: -2rem;
            }

            .acfg-blockquote:after {
                content: '”';
                right: -4rem;
                bottom: 1rem;
            }
            .acfg-author {
                text-transform: capitalize;
                line-height: 3;
                text-align: left;
                max-width: 600px;
                width: 100%;
                color: #777777;
                font-weight: 700;
                <?php if( $padding = get_field('padding') ) { ?>
                    padding-left: <?= $padding ?>px;
                <?php }else{ ?>
                    padding-left: 0;
                <?php } ?>
            }
        </style>

        <?php
        print ob_get_clean();

	}

}
