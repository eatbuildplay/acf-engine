<?php

// see https://www.advancedcustomfields.com/resources/image/

/*

@TODO support different sizes
@TODO support attachment format
@TODO support object format
@TODO support wrap in link

 */

$alt = $value['alt'];
$imageSource = $value['sizes']['medium'];

?>

<div class="acfg-image-wrap">
  <img src="<?php echo esc_url($imageSource); ?>" alt="<?php echo esc_attr($alt); ?>" />
</div>
