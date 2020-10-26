<?php

$file = $value;

?>

<figure>
  <!--<figcaption>Listen to the T-Rex:</figcaption>-->
  <audio
    controls
    src="<?php echo $file['url']; ?>">
      Your browser does not support the
      <code>audio</code> element.
  </audio>
</figure>
