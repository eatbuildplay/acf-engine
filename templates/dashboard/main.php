<?php

$countPostTypes     = wp_count_posts('acfg_post_type');
$countTaxonomies    = wp_count_posts('acfg_taxonomy');
$countOptionsPages  = wp_count_posts('acfg_options_page');
$countBlockTypes    = wp_count_posts('acfg_block_type');
$countTemplates     = wp_count_posts('acfg_template');

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

    <div class="acfg-dashboard-item">

      <h2>Taxonomies</h2>
      <h3 class="acfg-dashboard-stat">
        <?php print $countTaxonomies->publish; ?>
      </h3>
      <h4>
        <a href="edit.php?post_type=acfg_taxonomy">Manage Taxonomies</a>
      </h4>

    </div>

    <div class="acfg-dashboard-item">

      <h2>Options Pages</h2>
      <h3 class="acfg-dashboard-stat">
        <?php print $countOptionsPages->publish; ?>
      </h3>
      <h4>
        <a href="edit.php?post_type=acfg_options_page">Manage Options Pages</a>
      </h4>

    </div>

    <div class="acfg-dashboard-item">

      <h2>Block Types</h2>
      <h3 class="acfg-dashboard-stat">
        <?php print $countBlockTypes->publish; ?>
      </h3>
      <h4>
        <a href="edit.php?post_type=acfg_block_type">Manage Block Types</a>
      </h4>

    </div>

    <div class="acfg-dashboard-item">

      <h2>Templates</h2>
      <h3 class="acfg-dashboard-stat">
        <?php print $countTemplates->publish; ?>
      </h3>
      <h4>
        <a href="edit.php?post_type=acfg_template">Manage Templates</a>
      </h4>

    </div>

  </div>

  <!-- ACFEngine.com Link -->
  <div class="acfg-dashboard-row">
    <div>
      <h2>LEARN MORE ABOUT ACF ENGINE</h2>
      <p>For documentation, tutorials and support <a href="https://acfengine.com/">visit ACFEngine.com</a> to learn how to make the most of your ACF Engine.</p>
    </div>
  </div>

</div>


<style>

.acfg-dashboard-row {
  display: flex;
  flex-wrap: wrap;
  margin-bottom: 25px;
}

header {
  background: #D7D7D7;
  color: #353535;
  padding: 20px 25px;
  margin-left: -25px;
  margin-bottom: 20px;
}

.acfg-dashboard-item {
  margin: 10px;
  padding: 15px;
  background: #F8F8F8;
}

.acfg-dashboard-item:first-child {
  margin-left: 0;
}

.acfg-dashboard-item h2 {
  text-align: center;
  color: #454545;
}

.acfg-dashboard-stat {
  font-size: 2.8em;
  font-weight: 500;
  color: #454545;
  text-align: center;
}

</style>
