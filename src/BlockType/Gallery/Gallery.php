<?php

namespace AcfEngine\Core\BlockType;

if (!defined('ABSPATH')) {
	exit;
}

class Gallery extends BlockType {

  public function key() {
		return 'gallery';
	}

  public function title() {
    return 'Gallery';
  }

  public function description() {
    return 'A single Gallery.';
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
    $images = get_field( 'gallery_images' );
    $size = get_field('gallery_images_size_image');
    $colums = get_field('gallery_images_columns');
    $fr = '';
    for ($i = 0 ; $i < $colums ; $i++ ) {
        $fr .= '1fr ';
    }
    ob_start(); ?>
        <?php if ( get_field( 'gallery_images_lightbox' ) ) { ?>
        <!--  Style CDN Slick  -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css">
        <!--  Style CDN Slick-Lightbox  -->
        <link rel="stylesheet" href="https://mreq.github.io/slick-lightbox/dist/slick-lightbox.css">
        <?php } ?>
        <div class="acfg_image_gallery">
            <?php
            if ( !empty($images) ){
                foreach ($images as $image){
                    if ( $image['gallery_images_image'] ){ ?>
                    <div>
                        <a href="<?= wp_get_attachment_image_src( $image['gallery_images_image'], $size )[0] ?>">
                            <?= wp_get_attachment_image( $image['gallery_images_image'], $size ) ?>
                        </a>
                    </div>
            <?php } } } ?>
        </div>
        <style>
            .acfg_image_gallery {
                display: grid;
                grid-template-columns: <?= $fr ?>;
                grid-gap: <?= get_field( 'gallery_images_image_gap' ) ?>px;
            }
            .acfg_image_gallery img{
                height: <?= get_field( 'gallery_images_height' ) ?>px;
                object-fit: cover;
                margin: auto;
                width: 100%;
            }
        </style>

        <?php
            /* register js to backend previews */
            wp_register_script('slick', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.js', array('jquery'), '1', true );
            wp_enqueue_script('slick');
            wp_register_script('slick-lightbox', 'https://mreq.github.io/slick-lightbox/dist/slick-lightbox.js', array('jquery','slick'), '1', true );
            wp_enqueue_script('slick-lightbox');
        ?>
        <?php if ( get_field( 'gallery_images_lightbox' ) ) { ?>
        <!--  script CDN Slick  -->
        <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.js"></script>
        <!--  script CDN Slick-Lightbox  -->
        <script src="https://mreq.github.io/slick-lightbox/dist/slick-lightbox.js"></script>

        <script>
            jQuery('.acfg_image_gallery').slickLightbox({
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
