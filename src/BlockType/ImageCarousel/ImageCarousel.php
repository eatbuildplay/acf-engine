<?php

namespace AcfEngine\Core\BlockType;

if (!defined('ABSPATH')) {
	exit;
}

class ImageCarousel extends BlockType {

  public function key() {
		return 'image_carousel';
	}

  public function title() {
    return 'Image Carousel';
  }

  public function description() {
    return 'ACFG Image Carousel';
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
        $images = get_field( 'image_carousel_repeater' );
        $size = 'full';
        ob_start(); ?>

        <!--  Style CDN Slick  -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css">
        <!--  Style CDN Slick-Lightbox  -->
        <link rel="stylesheet" href="https://mreq.github.io/slick-lightbox/dist/slick-lightbox.css">

        <style>
            .acfg-image_carousel {
                width: 90%;
                margin: auto;
            }
            .acfg-image_carousel .slick-slide img {
                display: block;
                height: <?= get_field( 'image_carousel_height_image' ) ?>px;
                object-fit: cover;
                margin: auto;
            }
            .acfg-image_carousel .slick-slide {
                margin: 0px 20px;
            }
            .acfg-image_carousel .slick-prev:before,
            .acfg-image_carousel .slick-next:before {
                color: <?= get_field( 'image_carousel_color_prevnext' ) ?> !important;
            }
            .slick-dots li button:before {
                color: <?= get_field( 'image_carousel_color_dots' ) ?> !important;
            }
            .acfg-image_carousel .slick-slide {
                transition: all ease-in-out .3s;
                opacity: .2;
            }
            .acfg-image_carousel .slick-active {
                opacity: .5;
            }
            .acfg-image_carousel .slick-current {
                opacity: 1;
            }
        </style>

        <div class="acfg-image_carousel">
            <?php
            if ( !empty($images) ){
            foreach ($images as $image){
                if ( $image['image'] ){ ?>
                    <div>
                        <a href="<?= wp_get_attachment_image_src( $image['image'], $size )[0] ?>">
                            <?= wp_get_attachment_image( $image['image'], $size ) ?>
                        </a>
                    </div>
            <?php } } } ?>
        </div>
        <?php
            /* register js to backend previews */
            wp_register_script('slick', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.js', array('jquery'), '1', true );
            wp_enqueue_script('slick');
            wp_register_script('slick-lightbox', 'https://mreq.github.io/slick-lightbox/dist/slick-lightbox.js', array('jquery','slick'), '1', true );
            wp_enqueue_script('slick-lightbox');
        ?>
        <!--  script CDN Slick  -->
        <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.js"></script>
        <!--  script CDN Slick-Lightbox  -->
        <script src="https://mreq.github.io/slick-lightbox/dist/slick-lightbox.js"></script>
        <?php if ( !empty($images) ){ ?>
        <script>
            jQuery(document).ready(function() {
                jQuery(".acfg-image_carousel").slick({
                    dots: true,
                    infinite: true,
                    slidesToShow: 1,
                    slidesToScroll: 1
                });
            });
            jQuery('.acfg-image_carousel').slickLightbox({
                itemSelector        : 'a',
                arrows              : true,
                navigateByKeyboard  : true
            });
        </script>
        <?php } ?>
        <?php
        print ob_get_clean();
	}

}
