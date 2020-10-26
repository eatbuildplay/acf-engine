<?php

// see https://www.advancedcustomfields.com/resources/file/

/*

@TODO support different sizes
@TODO support attachment format
@TODO support object format
@TODO support wrap in link

 */

$file = $value;

?>

<a href="<?php echo $file['url']; ?>"><?php echo $file['filename']; ?></a>
