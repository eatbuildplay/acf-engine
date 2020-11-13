<?php

// https://www.advancedcustomfields.com/resources/group/

//var_dump( $field );

while ( have_rows( $field['key'], $postId )) :

  the_row();
  $content = '';

  foreach( $field['sub_fields'] as $index => $subfield ) :

    $subfieldValue = get_sub_field( $subfield['key'] );
    $tl = new \AcfEngine\Core\TemplateLoader();
    $tl->path = 'templates/fields/' . $subfield['type'] . '/';
    $tl->name = 'default';
    $tl->data = [
      'field'  => $subfield,
      'value'  => $subfieldValue,
      'postId' => $postId
    ];
    $content .= $tl->get();

  endforeach;
endwhile;

print $content;

?>
