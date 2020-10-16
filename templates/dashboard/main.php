<?php

$countPostTypes = wp_count_posts('acfg_post_type');

// var_dump( $countPostTypes );

?>

<div class="acfg-dashboard">

  <header>
    <h1>ACF Engine</h1>
  </header>

  <div class="acfg-dashboard-row">

    <div class="acfg-dashboard-item">

      <h2>Post Types</h2>
      <h3 class="acfg-dashboard-stat">
        <?php print $countPostTypes->publish; ?>
      </h3>
      <h4>
        <a href="edit.php?post_type=acfg_post_type">Manage Post Types</a>
      </h4>

    </div>

  </div>

</div>


<style>

header {
  background: #AAA;
  color: #353535;
}

</style>
