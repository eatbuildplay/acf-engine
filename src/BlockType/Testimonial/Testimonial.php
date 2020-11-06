<?php

namespace AcfEngine\Core\BlockType;

if (!defined('ABSPATH')) {
	exit;
}

class Testimonial extends BlockType {

  public function key() {
		return 'testimonial';
	}

  public function title() {
    return 'Testimonial';
  }

  public function description() {
    return 'ACFG Testimonial';
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
        <div class="acfg-testimonials" >
            <div class="acfg-testimonial">
                <?= wp_get_attachment_image( $image, $size ) ?>
                <h2 class="acfg-tertimonial-name"><?= get_field( 'name' ) ?></h2>
                <h3 class="acfg-tertimonial-company"><?= get_field( 'company' ) ?></h3>
                <p class="acfg-tertimonial-content"><?= get_field( 'body' ) ?></p>
                <div class="acfg-tertimonial-stars" style="--rating: <?= get_field( 'rating' ) ?>;" aria-label="Rating of this product is 2.3 out of 5.">
            </div>
        </div>
        <style>
            :root {
                --star-size: <?= get_field('stars_testimonial')['font_size'] ?>px;
                --star-color: <?= get_field('stars_testimonial')['color'] ?>;
                --star-background: <?= get_field('stars_testimonial')['backgound_color'] ?>;
            }
            .acfg-tertimonial-stars {
                --percent: calc(var(--rating) / 5 * 100%);

                display: inline-block;
                font-size: var(--star-size);
                font-family: Times; /* make sure ★ appears correctly */
                line-height: 1;
                height: ;
            }
            .acfg-tertimonial-stars::before {
                 content: "★★★★★";
                 letter-spacing: 3px;
                 background: linear-gradient(
                         90deg,
                         var(--star-background) var(--percent),
                         var(--star-color) var(--percent)
                 );
                 -webkit-background-clip: text;
                 -webkit-text-fill-color: transparent;
             }
            /* outer wrap div around list */

            <?php if  ($boxedWidth) { ?>
            .acfg-testimonials  {
                max-width: <?= get_field( 'max_width' ) ?>px !important;
                margin: 30px auto;
            }
            <?php } ?>

            /* singular testimonial */
            .acfg-testimonial {
                background-color: #FFF;
                border: solid 1px #D6D6D6;
                text-align: center;
                font-family: verdana, sans-serif;
                margin: 15px auto;
                padding: 25px;
                width: 600px;
            }

            .acfg-testimonial img {
                height: <?= get_field('image_testimonial')['height'] ?>px !important;
                width: <?= get_field('image_testimonial')['height'] ?>px !important;
                margin: auto;
                border-radius: 50%;
            }

            /* name */
            .acfg-testimonial h2 {
                color: <?= get_field('name_testimonial')['color'] ?>;
                font-size: <?= get_field('name_testimonial')['font_size'] ?>px;
                margin: <?= get_field('name_testimonial')['margin'] ?>px;
                padding: <?= get_field('name_testimonial')['padding'] ?>px;
            }

            /* company */
            .acfg-testimonial h3 {
                color: <?= get_field('company_testimonial')['color'] ?>;
                font-size: <?= get_field('company_testimonial')['font_size'] ?>px;
                margin: <?= get_field('company_testimonial')['margin'] ?>px;
                padding: <?= get_field('company_testimonial')['padding'] ?>px;
            }

            /* body */
            .acfg-testimonial p {
                color: <?= get_field('body_testimonial')['color'] ?>;
                font-size: <?= get_field('body_testimonial')['font_size'] ?>px;
                font-style: italic;
                margin: <?= get_field('body_testimonial')['margin'] ?>px;
                padding: <?= get_field('body_testimonial')['padding'] ?>px;
                text-align: <?= get_field( 'alignment' ) ?>;
            }

        </style>

        <?php
		print ob_get_clean();
	}

}
