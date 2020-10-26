<?php

$posts = $value;

if( $posts ): ?>
  <ul>
  <?php foreach( $posts as $postObject): // variable must be called $post (IMPORTANT) ?>
    <li>
      <h3><a href="<?php print get_permalink( $postObject->ID ); ?>"><?php print $postObject->post_title; ?></a></h3>
    </li>
  <?php endforeach; ?>
  </ul>
<?php endif; ?>
