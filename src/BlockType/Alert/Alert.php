<?php

namespace AcfEngine\Core\BlockType;

if (!defined('ABSPATH')) {
	exit;
}

class Alert extends BlockType {

  public function key() {
		return 'alert';
	}

  public function title() {
    return 'Alert';
  }

  public function description() {
    return 'A single alert with content.';
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
    $type_alert = get_field('alert_type');
    $alert_title = get_field('alert_title');
    $alert_description = get_field('alert_description');
    $alert_buttom = get_field('alert_close_button');
    
    ob_start(); ?>

    <div class="acfg-container-alert">
      <div class="acfg-alert acfg-alert-<?= $type_alert ?>">
        <input type="checkbox" id="alert-<?= $type_alert ?>"/>
        <label class="acfg-alert-close" title="close" for="alert-<?= $type_alert ?>">
          <i class="acfg-alert-icon-remove <?= $alert_buttom ? '' : 'acfg-hide-alert-close'; ?>">
            <svg xmlns="http://www.w3.org/2000/svg" height="8pt" viewBox="0 0 365.696 365.696" width="8pt"><path d="m243.1875 182.859375 113.132812-113.132813c12.5-12.5 12.5-32.765624 0-45.246093l-15.082031-15.082031c-12.503906-12.503907-32.769531-12.503907-45.25 0l-113.128906 113.128906-113.132813-113.152344c-12.5-12.5-32.765624-12.5-45.246093 0l-15.105469 15.082031c-12.5 12.503907-12.5 32.769531 0 45.25l113.152344 113.152344-113.128906 113.128906c-12.503907 12.503907-12.503907 32.769531 0 45.25l15.082031 15.082031c12.5 12.5 32.765625 12.5 45.246093 0l113.132813-113.132812 113.128906 113.132812c12.503907 12.5 32.769531 12.5 45.25 0l15.082031-15.082031c12.5-12.503906 12.5-32.769531 0-45.25zm0 0"></path></svg>
          </i>
        </label>
        <p class="acfg-alert-inner">
          <span class="acfg-alert-title"><?= $alert_title ?></span><br>
          <span class="acfg-alert-description"><?= $alert_description ?></span> 
        </p>
      </div>
    </div>

    <style>
      .acfg-container-alert {
        width: 500px; 
        margin: 0 auto;
      }
      .acfg-alert .acfg-alert-inner {
        display: block;
        padding: 10px 20px;
        margin: 6px;
        border-radius: 3px;
        border: 1px solid rgb(180,180,180);
        background-color: rgb(212,212,212);
      }
      .acfg-alert .acfg-alert-inner .acfg-alert-title {
        font-weight: 600;
        font-size: 20px;
      }
      .acfg-alert .acfg-alert-inner .acfg-alert-description {
        font-size: 16px;
        font-weight: 300;
      }
      .acfg-alert .acfg-alert-close {
        float: right;
        margin: 10px 15px 0px 0px;
        cursor: pointer;
      }
      .acfg-alert .acfg-alert-close .acfg-alert-icon-remove {
        font-weight: 900;
        font-size: 22px;
      }
      .acfg-hide-alert-close {
        display: none;
      }
      .acfg-alert .acfg-alert-inner,.acfg-alert .acfg-alert-close {
        color: rgb(88,88,88);
      }
      .acfg-alert input {
        display: none;
      }
      .acfg-alert input:checked ~ * {
        animation-name: dismiss,hide;
        animation-duration: 300ms;
        animation-iteration-count: 1;
        animation-timing-function: ease;
        animation-fill-mode: forwards;
        animation-delay: 0s,100ms;
      }
      .acfg-alert.acfg-alert-danger .acfg-alert-inner {
        border: 1px solid rgb(238,211,215);
        background-color: rgb(242,222,222);
      }
      .acfg-alert.acfg-alert-danger .acfg-alert-inner {
        color: rgb(185,74,72);
      }
      .acfg-alert.acfg-alert-danger .acfg-alert-close svg {
        fill: rgb(185,74,72);
      }
      .acfg-alert.acfg-alert-success .acfg-alert-inner {
        border: 1px solid rgb(214,233,198);
        background-color: rgb(223,240,216);
      }
      .acfg-alert.acfg-alert-success .acfg-alert-inner{
        color: rgb(70,136,71);
      }
      .acfg-alert.acfg-alert-success .acfg-alert-close  svg {
        fill: rgb(70,136,71);
      }
      .acfg-alert.acfg-alert-info .acfg-alert-inner {
        border: 1px solid rgb(188,232,241);
        background-color: rgb(217,237,247);
      }
      .acfg-alert.acfg-alert-info .acfg-alert-inner {
        color: rgb(58,135,173);
      }
      .acfg-alert.acfg-alert-info .acfg-alert-close  svg {
        fill: rgb(58,135,173);
      }
      .acfg-alert.acfg-alert-warning .acfg-alert-inner {
        border: 1px solid rgb(251,238,213);
        background-color: rgb(252,248,227);
      }
      .acfg-alert.acfg-alert-warning .acfg-alert-inner {
        color: rgb(192,152,83);
      }
      .acfg-alert.acfg-alert-warning .acfg-alert-close svg {
        fill: rgb(192,152,83);
      }

      @keyframes dismiss {
        0% {
          opacity: 1;
        }
        90%, 100% {
          opacity: 0;
          font-size: 0.1px;
          transform: scale(0);
        }
      }

      @keyframes hide {
        100% {
          height: 0px;
          width: 0px;
          overflow: hidden;
          margin: 0px;
          padding: 0px;
          border: 0px;
        }
      }
    </style>

    <?php
		print ob_get_clean();
	}

}
