<?php

namespace AcfEngine\Core\BlockType;

if (!defined('ABSPATH')) {
	exit;
}

class FlipBox extends BlockType {

  public function key() {
		return 'flip_box';
	}

  public function title() {
    return 'Flip Box';
  }

  public function description() {
    return 'Render a flip box.';
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
        ob_start(); ?>
        <div class="col span_12">

            <div class="col-sm-4" data-bg-cover="" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
                <div class="column-inner">
                    <div class="wrapper">
                        <div class="oranges-flip-box" data-min-height="400" data-flip-direction="horizontal-to-left" data-h_text_align="left" data-v_text_align="center">
                            <div class="flip-box-front" data-bg-overlay="true" data-text-color="light" style="background-image: url(https://hsto.org/files/74b/891/ed1/74b891ed153a4b36a55b61bb24f32b16.jpg); min-height: 400px; height: auto;">
                                <div class="inner"><i class="icon-default-style fa fa-firefox" data-color="accent-color" style="font-size: 60px!important; line-height: 60px!important;"></i>SEO</div>
                            </div>
                            <div class="flip-box-back" data-bg-overlay="" data-text-color="dark" style="background-color: rgb(255, 255, 255); min-height: 400px; height: auto;">
                                <div class="inner"><span style="color: orange">///</span>&nbsp;<span style="color: #000000;"><a style="color: #000000; text-decoration: none;" href="https://oranges.guru">SEO</a></span>&nbsp;<span style="color: orange">///</span>
                                    <p></p>
                                    <p>Web studio
                                        <br> (123) 456-7890
                                        <br> mail@oranges.guru
                                    </p>
                                    <p>Mon – Fri: 09am – 21pm
                                        <br> Sat – Sun: holidays</p>
                                    <p><img class="" src="https://oranges.guru/images/logo_black.png" alt="" width="215" height="">
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <style>
            @import url('//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
            body {
                font-family: arial;
            }
            .span_12 {
                max-width: 1400px;
                margin: auto;
            }
            .col-sm-4 {
                width: 31.914893614%;
                float: left;
                position: relative;
                min-height: 1px;
                margin-left: 1%;
                box-sizing: border-box;
            }
            .oranges-flip-box {
                transform-style: preserve-3d;
                -webkit-transform-style: preserve-3d;
                perspective: 1000px;
                -webkit-perspective: 1000px;
            }
            .oranges-flip-box .flip-box-front[data-text-color="light"],
            .oranges-flip-box .flip-box-back[data-text-color="light"],
            .oranges-flip-box .flip-box-front[data-text-color="light"] h1,
            .oranges-flip-box .flip-box-back[data-text-color="light"] h1,
            .oranges-flip-box .flip-box-front[data-text-color="light"] h2,
            .oranges-flip-box .flip-box-back[data-text-color="light"] h2,
            .oranges-flip-box .flip-box-front[data-text-color="light"] h3,
            .oranges-flip-box .flip-box-back[data-text-color="light"] h3,
            .oranges-flip-box .flip-box-front[data-text-color="light"] h4,
            .oranges-flip-box .flip-box-back[data-text-color="light"] h4,
            .oranges-flip-box .flip-box-front[data-text-color="light"] h5,
            .oranges-flip-box .flip-box-back[data-text-color="light"] h5,
            .oranges-flip-box .flip-box-front[data-text-color="light"] h6,
            .oranges-flip-box .flip-box-back[data-text-color="light"] h6 {
                color: #fff;
            }
            .oranges-flip-box .flip-box-front,
            .oranges-flip-box .flip-box-back {
                background-size: cover;
                background-position: center;
                transition: -webkit-transform 0.75s cubic-bezier(.45, .2, .2, 1);
                transition: transform 0.75s cubic-bezier(.45, .2, .2, 1);
                transition: transform 0.75s cubic-bezier(.45, .2, .2, 1), -webkit-transform 0.75s cubic-bezier(.45, .2, .2, 1);
                -webkit-transition: transform 0.75s cubic-bezier(.45, .2, .2, 1);
                -webkit-backface-visibility: hidden;
                backface-visibility: hidden;
                -webkit-perspective: inherit;
                perspective: inherit;
            }
            .oranges-flip-box[data-shadow="light_visibility"] .flip-box-back,
            .oranges-flip-box[data-shadow="light_visibility"] .flip-box-front {
                box-shadow: 0px 30px 60px rgba(0, 0, 0, 0.2);
            }
            .oranges-flip-box[data-shadow="heavy_visibility"] .flip-box-back,
            .oranges-flip-box[data-shadow="heavy_visibility"] .flip-box-front {
                box-shadow: 0px 30px 75px rgba(0, 0, 0, 0.4);
            }
            .oranges-flip-box .flip-box-back[data-bg-overlay="true"]:after,
            .oranges-flip-box .flip-box-front[data-bg-overlay="true"]:after {
                position: absolute;
                z-index: 1;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                content: ' ';
                display: block;
                opacity: 0.6;
                background-color: inherit;
                -webkit-backface-visibility: hidden;
                backface-visibility: hidden;
            }
            .oranges-flip-box:hover .flip-box-front,
            .oranges-flip-box:hover .flip-box-back {
                transition: -webkit-transform 0.75s cubic-bezier(.45, .2, .2, 1);
                transition: transform 0.75s cubic-bezier(.45, .2, .2, 1);
                transition: transform 0.75s cubic-bezier(.45, .2, .2, 1), -webkit-transform 0.75s cubic-bezier(.45, .2, .2, 1);
                -webkit-transition: transform 0.75s cubic-bezier(.45, .2, .2, 1);
            }
            .oranges-flip-box .flip-box-back {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
            }
            .oranges-flip-box .oranges-button {
                -webkit-transform: translateZ(0);
                transform: translateZ(0);
            }
            .oranges-flip-box[data-h_text_align="center"] .flip-box-back,
            .oranges-flip-box[data-h_text_align="center"] .flip-box-front {
                text-align: center;
            }
            .oranges-flip-box[data-h_text_align="right"] .flip-box-back,
            .oranges-flip-box[data-h_text_align="right"] .flip-box-front {
                text-align: right;
            }
            .oranges-flip-box[data-v_text_align="center"] .flip-box-back .inner,
            .oranges-flip-box[data-v_text_align="center"] .flip-box-front .inner {
                transform: translateY(-50%) translateZ(60px) scale(.88);
                -webkit-transform: translateY(-50%) translateZ(60px) scale(.88);
                -ms-transform: translateY(-50%) translateZ(60px) scale(.88);
                top: 50%;
            }
            .oranges-flip-box[data-v_text_align="bottom"] .flip-box-back .inner,
            .oranges-flip-box[data-v_text_align="bottom"] .flip-box-front .inner {
                -ms-transform: translateZ(60px) scale(.88);
                transform: translateZ(60px) scale(.88);
                -webkit-transform: translateZ(60px) scale(.88);
                bottom: 0;
            }
            .oranges-flip-box[data-v_text_align="top"] .flip-box-back .inner,
            .oranges-flip-box[data-v_text_align="top"] .flip-box-front .inner {
                -ms-transform: translateZ(60px) scale(.88);
                transform: translateZ(60px) scale(.88);
                -webkit-transform: translateZ(60px) scale(.88);
                top: 0;
            }
            .oranges-flip-box[data-flip-direction="vertical-to-top"] .flip-box-back .inner,
            .oranges-flip-box[data-flip-direction="vertical-to-top"] .flip-box-front .inner,
            .oranges-flip-box[data-flip-direction="vertical-to-bottom"] .flip-box-back .inner,
            .oranges-flip-box[data-flip-direction="vertical-to-bottom"] .flip-box-front .inner {
                -ms-transform: translateZ(50px) scale(.9);
                transform: translateZ(50px) scale(.9);
                -webkit-transform: translateZ(50px) scale(.9);
            }
            .oranges-flip-box[data-v_text_align="center"][data-flip-direction="vertical-to-bottom"] .flip-box-back .inner,
            .oranges-flip-box[data-v_text_align="center"][data-flip-direction="vertical-to-bottom"] .flip-box-front .inner,
            .oranges-flip-box[data-v_text_align="center"][data-flip-direction="vertical-to-top"] .flip-box-back .inner,
            .oranges-flip-box[data-v_text_align="center"][data-flip-direction="vertical-to-top"] .flip-box-front .inner {
                -ms-transform: translateY(-50%) translateZ(50px) scale(.9);
                transform: translateY(-50%) translateZ(50px) scale(.9);
                -webkit-transform: translateY(-50%) translateZ(50px) scale(.9);
            }
            .oranges-flip-box .flip-box-back .inner,
            .oranges-flip-box .flip-box-front .inner {
                position: absolute;
                left: 0;
                width: 100%;
                padding: 60px;
                outline: 1px solid transparent;
                -webkit-perspective: inherit;
                perspective: inherit;
                z-index: 2;
            }
            .oranges-flip-box[data-flip-direction="horizontal-to-left"] .flip-box-back,
            body:not(.using-mobile-browser) .oranges-flip-box[data-flip-direction="horizontal-to-right"]:hover .flip-box-front,
            .owl-carousel.moving .oranges-flip-box[data-flip-direction="horizontal-to-left"] .flip-box-back {
                -ms-transform: rotateY(180deg);
                -webkit-transform: rotateY(180deg);
                transform: rotateY(180deg);
                -webkit-transform-style: preserve-3d;
                transform-style: preserve-3d;
            }
            .oranges-flip-box[data-flip-direction="horizontal-to-right"].flipped .flip-box-front {
                -ms-transform: rotateY(180deg)!important;
                -webkit-transform: rotateY(180deg)!important;
                transform: rotateY(180deg)!important;
            }
            .oranges-flip-box[data-flip-direction="horizontal-to-left"] .flip-box-front,
            body:not(.using-mobile-browser) .oranges-flip-box[data-flip-direction="horizontal-to-left"]:hover .flip-box-back,
            .oranges-flip-box[data-flip-direction="horizontal-to-right"] .flip-box-front,
            body:not(.using-mobile-browser) .oranges-flip-box[data-flip-direction="horizontal-to-right"]:hover .flip-box-back,
            .owl-carousel.moving .oranges-flip-box[data-flip-direction="horizontal-to-left"] .flip-box-front,
            .owl-carousel.moving .oranges-flip-box[data-flip-direction="horizontal-to-right"] .flip-box-front {
                -ms-transform: rotateY(0deg);
                -webkit-transform: rotateY(0deg);
                transform: rotateY(0deg);
                -webkit-transform-style: preserve-3d;
                transform-style: preserve-3d;
            }
            .oranges-flip-box[data-flip-direction="horizontal-to-left"].flipped .flip-box-back,
            .oranges-flip-box[data-flip-direction="horizontal-to-right"].flipped .flip-box-back {
                -ms-transform: rotateY(0deg)!important;
                -webkit-transform: rotateY(0deg)!important;
                transform: rotateY(0deg)!important;
            }
            body:not(.using-mobile-browser) .oranges-flip-box[data-flip-direction="horizontal-to-left"]:hover .flip-box-front,
            .oranges-flip-box[data-flip-direction="horizontal-to-right"] .flip-box-back,
            .owl-carousel.moving .oranges-flip-box[data-flip-direction="horizontal-to-right"] .flip-box-back {
                -ms-transform: rotateY(-180deg);
                -webkit-transform: rotateY(-180deg);
                transform: rotateY(-180deg);
                -webkit-transform-style: preserve-3d;
                transform-style: preserve-3d;
            }
            .oranges-flip-box[data-flip-direction="horizontal-to-left"].flipped .flip-box-front {
                -ms-transform: rotateY(-180deg)!important;
                -webkit-transform: rotateY(-180deg)!important;
                transform: rotateY(-180deg)!important;
            }
            .oranges-flip-box[data-flip-direction="vertical-to-top"] .flip-box-back,
            body:not(.using-mobile-browser) .oranges-flip-box[data-flip-direction="vertical-to-bottom"]:hover .flip-box-front {
                -ms-transform: rotateX(180deg);
                -webkit-transform: rotateX(180deg);
                transform: rotateX(180deg);
                -webkit-transform-style: preserve-3d;
                transform-style: preserve-3d;
            }
            .oranges-flip-box[data-flip-direction="vertical-to-bottom"].flipped .flip-box-front {
                -ms-transform: rotateX(180deg)!important;
                -webkit-transform: rotateX(180deg)!important;
                transform: rotateX(180deg)!important;
            }
            .oranges-flip-box[data-flip-direction="vertical-to-top"] .flip-box-front,
            body:not(.using-mobile-browser) .oranges-flip-box[data-flip-direction="vertical-to-top"]:hover .flip-box-back,
            .oranges-flip-box[data-flip-direction="vertical-to-bottom"] .flip-box-front,
            body:not(.using-mobile-browser) .oranges-flip-box[data-flip-direction="vertical-to-bottom"]:hover .flip-box-back {
                -ms-transform: rotateX(0deg);
                -webkit-transform: rotateX(0deg);
                transform: rotateX(0deg);
                -webkit-transform-style: preserve-3d;
                transform-style: preserve-3d;
            }
            .oranges-flip-box[data-flip-direction="vertical-to-top"].flipped .flip-box-back,
            .oranges-flip-box[data-flip-direction="vertical-to-bottom"].flipped .flip-box-back {
                -ms-transform: rotateX(0deg)!important;
                -webkit-transform: rotateX(0deg)!important;
                transform: rotateX(0deg)!important;
            }
            body:not(.using-mobile-browser) .oranges-flip-box[data-flip-direction="vertical-to-top"]:hover .flip-box-front,
            .oranges-flip-box[data-flip-direction="vertical-to-bottom"] .flip-box-back {
                -ms-transform: rotateX(-180deg);
                -webkit-transform: rotateX(-180deg);
                transform: rotateX(-180deg);
                -webkit-transform-style: preserve-3d;
                transform-style: preserve-3d;
            }
            .oranges-flip-box[data-flip-direction="vertical-to-top"].flipped .flip-box-front {
                -ms-transform: rotateX(-180deg)!important;
                -webkit-transform: rotateX(-180deg)!important;
                transform: rotateX(-180deg)!important;
            }
            .oranges-flip-box .flip-box-front i {
                margin-bottom: 20px;
                height: auto!important;
                display: block;
                width: auto!important;
            }
            .oranges-flip-box .flip-box-front .inner {
                position: absolute;
                left: 0;
                width: 100%;
                text-align: center;
                outline: 1px solid transparent;
                -webkit-perspective: inherit;
                perspective: inherit;
                z-index: 2;
                font-size: 30px;
                font-weight: 900;
                color: white;
            }
            .oranges-flip-box .flip-box-back .inner,
            .oranges-flip-box .flip-box-front .inner {
                position: absolute;
                left: 0;
                width: 100%;
                padding: 60px 0px;
                outline: 1px solid transparent;
                -webkit-perspective: inherit;
                perspective: inherit;
                z-index: 2;
            }
        </style>
		<?php
        print ob_get_clean();

	}

}
