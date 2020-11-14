<?php

namespace AcfEngine\Core\BlockType;

if (!defined('ABSPATH')) {
	exit;
}

class Accordion extends BlockType {

  public function key() {
		return 'accordion';
	}

  public function title() {
    return 'Accordion';
  }

  public function description() {
    return 'An accordion filled with content.';
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
    
    $items = get_field('items');
    if (!empty($items)) {
    ob_start(); ?>
      <div class="acfg-row">
        <div class="acfg-col">
          <div class="acfg-tabs">
            <?php foreach($items as $item){  ?>
              <button class="acfg-accordion"><?= $item['title'] ?></button>
              <div class="acfg-panel">
                <p><?= $item['content'] ?></p>
              </div>
            <?php }  ?>
          </div>
        </div>
      </div>

      <style>
        .acfg-tab input {
          position: absolute;
          opacity: 0;
          z-index: -1;
        }
        .acfg-row {
          display: flex;
        }
        .acfg-row .acfg-col {
          flex: 1;
        }
        .acfg-row .acfg-col:last-child {
          margin-left: 1em;
        }
        /* Accordion styles */
        .acfg-tabs {
          border-radius: 8px;
          overflow: hidden;
          box-shadow: 0 4px 4px -2px rgba(0, 0, 0, 0.5);
        }
      
        /* Accordion */
        .acfg-accordion {
          background-color: #eee;
          color: #444;
          cursor: pointer;
          padding: 18px;
          width: 100%;
          border: none;
          text-align: left;
          outline: none;
          font-size: 15px;
          transition: 0.4s;
          text-decoration: none;
        }

        .acfg-active, .acfg-accordion:hover {
          background-color: #ccc;
          text-decoration: none;
        }

        .acfg-accordion:after {
          content: '\002B';
          color: #777;
          font-weight: bold;
          float: right;
          margin-left: 5px;
        }

        .acfg-active:after {
          content: "\2212";
        }

        .acfg-panel {
          padding: 0 18px;
          background-color: white;
          max-height: 0;
          overflow: hidden;
          transition: max-height 0.2s ease-out;
        }
        .acfg-panel p{
          margin-bottom: 0;
          padding-top: 10px;
          padding-bottom: 10px;
        }
      </style>
		
    <script>
      var acc = document.getElementsByClassName("acfg-accordion");
      var i;

      for (i = 0; i < acc.length; i++) {
        acc[i].addEventListener("click", function() {
          this.classList.toggle("acfg-active");
          var panel = this.nextElementSibling;
          if (panel.style.maxHeight) {
            panel.style.maxHeight = null;
          } else {
            panel.style.maxHeight = panel.scrollHeight + "px";
          } 
        });
      }
    </script>
    <?php
    }
		print ob_get_clean();

	}

}
