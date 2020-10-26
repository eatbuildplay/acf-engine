<?php

$postObject = $value;

if( $postObject ):

?>

  <div>
  	<h3><a href="<?php print get_permalink( $postObject->ID ); ?>"><?php print $postObject->post_title; ?></a></h3>
  </div>

<?php endif; ?>
