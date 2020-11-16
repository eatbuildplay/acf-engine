<?php

namespace AcfEngine\Core\BlockType;

if (!defined('ABSPATH')) {
	exit;
}

class CountDown extends BlockType {

  public function key() {
    return 'count_down';
  }

  public function title() {
    return 'CountDown';
  }

  public function description() {
    return 'A single countdown.';
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
    $time = get_field('countdown_date');
    $startTitle = get_field('countdown_start_title');
    $endTitle = get_field('countdown_end_title');
    $endSubTitle = get_field('countdown_end_sub_title');
    ob_start() ?>
      <div class="acfg-countdown-container">
          <h1 id="acfg-countdown-headline"><?= $startTitle ?></h1>
          <input type="hidden" name="countdown-time" id="countdown-time" value="<?= $time ?>">
          <input type="hidden" name="end-title" id="end-title" value="<?= $endTitle ?>">
          <div id="acfg-countdown">
              <ul>
                  <li class="<?= get_field('countdown_days')? '' : 'acfg-countdown-none'; ?>" ><span id="acfg-countdown-days"></span>days</li>
                  <li class="<?= get_field('countdown_hours')? '' : 'acfg-countdown-none'; ?>" ><span id="acfg-countdown-hours"></span>Hours</li>
                  <li class="<?= get_field('countdown_minutes')? '' : 'acfg-countdown-none'; ?>" ><span id="acfg-countdown-minutes"></span>Minutes</li>
                  <li class="<?= get_field('countdown_seconds')? '' : 'acfg-countdown-none'; ?>" ><span id="acfg-countdown-seconds"></span>Seconds</li>
              </ul>
          </div>
          <div class="acfg-countdown-message">
              <div id="acfg-countdown-content">
                  <span class="acfg-countdown-message-span"><?= $endSubTitle ?></span>
          </div>
      </div>
      <style>
        .acfg-countdown-none {
            display: none;
        }
        .acfg-countdown-container {
            color: #333;
            margin: 0 auto;
            text-align: center;
        }
        #acfg-countdown-headline {
            font-weight: normal;
            letter-spacing: .125rem;
            text-transform: uppercase;
            font-size: <?= get_field('group_countdown_start_title')['font_size'] ?>px;
            color: <?= get_field('group_countdown_start_title')['color'] ?>;
        }
        #acfg-countdown-content {
            font-weight: normal;
            letter-spacing: .125rem;
            text-transform: uppercase;
            font-size: <?= get_field('group_countdown_end_title')['font_size'] ?>px;
            color: <?= get_field('group_countdown_end_title')['color'] ?>;
        }
        #acfg-countdown ul {
            display: flex;
            width: 100%;
            margin: auto;
            justify-content: center;
        }
        #acfg-countdown li {
            display: inline-block;
            font-size: <?= get_field('group_countdown_date')['font_size_text'] ?>px;
            color: <?= get_field('group_countdown_date')['color_text'] ?>;
            list-style-type: none;
            padding: 1em;
            text-transform: uppercase;
          }
        #acfg-countdown li span {
            display: block;
            font-size: <?= get_field('group_countdown_date')['font_size_number'] ?>px;
            color: <?= get_field('group_countdown_date')['color_number'] ?>;
        }
        .acfg-countdown-message {
            font-size: <?= get_field('group_countdown_end_sub_title')['font_size'] ?>px;
            color: <?= get_field('group_countdown_end_sub_title')['color'] ?>;
        }
        #acfg-countdown-content {
            display: none;
            padding: 1rem;
        }
        .acfg-countdown-message-span {
            padding: 0 .25rem;
        }
      </style>

      <script>
          let countdownTime = document.getElementById("countdown-time");
          const second = 1000,
                minute = second * 60,
                hour = minute * 60,
                day = hour * 24;

          let x = setInterval(function() {
            let countDown = new Date(countdownTime.value).getTime(),
                now = new Date().getTime(),
                distance = countDown - now;
            document.getElementById("acfg-countdown-days").innerText = Math.floor(distance / (day)),
            document.getElementById("acfg-countdown-hours").innerText = Math.floor((distance % (day)) / (hour)),
            document.getElementById("acfg-countdown-minutes").innerText = Math.floor((distance % (hour)) / (minute)),
            document.getElementById("acfg-countdown-seconds").innerText = Math.floor((distance % (minute)) / second);

            //do something later when date is reached
            if (distance < 0) {
                let headline = document.getElementById("acfg-countdown-headline"),
                    countdown = document.getElementById("acfg-countdown"),
                    content = document.getElementById("acfg-countdown-content");

                headline.innerText = document.getElementById("end-title").value;
                countdown.style.display = "none";
                content.style.display = "block";
                clearInterval(x);
                }
          //seconds
          }, 1000)
      </script>
    <?php
    print ob_get_clean();
  }

}
