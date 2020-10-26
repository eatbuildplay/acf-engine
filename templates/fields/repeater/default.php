<?php

$subfields = $field['sub_fields'];

if( have_rows( $field['key'], $postId )):
  while ( have_rows( $field['key'], $postId )) :

    the_row();
    foreach( $subfields as $index => $subfield ) {

      $subfieldValue = get_sub_field( $subfield['key'] );

      $tl = new \AcfEngine\Core\TemplateLoader();
      $tl->path = 'templates/fields/' . $subfield['type'] . '/';
      $tl->name = 'default';
      $tl->data = [
        'field'  => $subfield,
        'value'  => $subfieldValue,
  			'postId' => $postId
      ];
      $tl->render();

    }

  endwhile;
else :
    // no rows found
endif;
