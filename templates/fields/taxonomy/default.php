<?php

// @TODO add support for multiple terms

$terms = $value;

if( $terms ): ?>
    <div>
    <?php foreach( $terms as $term ):

      if( !isset( $term->name ) || is_null($term->name)) {
        $term->name = 'uncategorized';
      } else {
        print "NOT NULL";
      }

    ?>
        <h2><?php echo esc_html( $term->name ); ?></h2>
        <a href="<?php echo esc_url( get_term_link( $term ) ); ?>">View all '<?php echo esc_html( $term->name ); ?>' posts</a>
    <?php endforeach; ?>
  </div>
<?php endif; ?>
