<?php

namespace AcfEngine\Core\BlockType;

if (!defined('ABSPATH')) {
	exit;
}

class Login extends BlockType {

  public function key() {
		return 'login';
	}

  public function title() {
    return 'Login';
  }

  public function description() {
    return 'ACFG Login';
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
        <div class="acfg-login-page">
            <form name="loginform" id="loginform" class="acfg-login-form" action="<?= wp_login_url( home_url() ) ?>" method="post" _lpchecked="1">
                <?= get_field('login_image') && the_custom_logo('custom-logo') ? the_custom_logo('custom-logo') : '';  ?>
                <h3 class="acfg-login-title"><?= get_field('login_text') ?></h3>
                <label for="user_login"><?= get_field('login_label_user_email') ?></label>
                <input type="text" name="log" id="user_login" placeholder="<?= get_field('login_placeholder_user_email') ?>"/>
                <label for="user_pass"><?= get_field('login_label_pass') ?></label>
                <input type="password" name="pwd" id="user_pass" placeholder="<?= get_field('login_placeholder_pass') ?>"/>
                <?php if ( get_field('login_remenber_me') ) { ?>
                    <input type="checkbox" value="rememberMe" id="acfg-remember-me"> <label for="acfg-remember-me">Remember me</label>
                <?php } ?>
                <button>login</button>
                <p class="acfg-login-message">Not registered? <a href="#">Create an account</a></p>
            </form>
        </div>

        <style>
            .acfg-login-page {
                width: 360px;
                padding: 8% 0 0;
                margin: auto;
            }
            .acfg-login-form {
                position: relative;
                z-index: 1;
                background: #FFFFFF;
                max-width: 360px;
                margin: auto;
                padding: 45px;
                text-align: center;
                box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
            }
            .acfg-login-form .custom-logo-link img {
                width: 150px;
                margin: auto;
            }
            .acfg-login-title {
                margin: <?= get_field('login_text_group')['margin'] ?>px !important;
                padding: <?= get_field('login_text_group')['padding'] ?>px;
                font-size: <?= get_field('login_text_group')['font_size'] ?>px;
                color: <?= get_field('login_text_group')['color'] ?>;
            }
            .acfg-login-form label {
                font-family: "Roboto", sans-serif;
                font-size: <?= get_field('login_labels_group')['font_size'] ?>px;
                color: <?= get_field('login_labels_group')['color'] ?>;
                margin: <?= get_field('login_labels_group')['margin'] ?>px;
                padding: <?= get_field('login_labels_group')['padding'] ?>px;
                text-align: <?= get_field('login_labels_group')['text_align'] ?>;
            }
            .acfg-login-form input[type="checkbox"],
            .acfg-login-form label[for="acfg-remember-me"] {
                float: left;
            }
            .acfg-login-form input[type="password"],
            .acfg-login-form input[type="text"] {
                font-family: "Roboto", sans-serif;
                outline: 0;
                background: #f2f2f2;
                width: 100%;
                border: 0;
                margin: 0 0 15px;
                padding: 15px;
                box-sizing: border-box;
                font-size: 14px;
            }
            .acfg-login-form button {
                font-family: "Roboto", sans-serif;
                text-transform: uppercase;
                outline: 0;
                background: #4CAF50;
                width: 100%;
                border: 0;
                padding: 15px;
                color: #FFFFFF;
                font-size: 14px;
                -webkit-transition: all 0.3 ease;
                transition: all 0.3 ease;
                cursor: pointer;
            }
            .acfg-login-form button:hover,
            .acfg-login-form button:active,
            .acfg-login-form button:focus {
                background: #43A047;
            }
            .acfg-login-form .acfg-login-message {
                margin: 15px 0 0;
                color: #b3b3b3;
                font-size: 12px;
            }
            .acfg-login-form .acfg-login-message a {
                color: #4CAF50;
                text-decoration: none;
            }
        </style>
      <?php
		print ob_get_clean();
	}
}
