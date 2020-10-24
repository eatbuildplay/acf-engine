<?php

namespace AcfEngine\Core;

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

class Import {

  public function init() {


    add_action('acf/save_post', [$this, 'saveCallback'], 20);

  }

  public function saveCallback( $id ) {

    $screen = get_current_screen();

    /*
     * Check if we're on the settings screen
     */
    if( $screen->base != 'acf-engine_page_acf-options-settings' ) {
      return;
    }

    /*
     * Check if user ordered a sync/import
     */
    $syncObjectFiles = get_field('sync_object_files', 'option');
    if( $syncObjectFiles != 1 ) {
      return;
    }

    /* Reset the sync_object_files field */
    update_field('sync_object_files', 0, 'option');

    /*
     * Fetch and loop over the available object types
     */
    foreach( $this->importableObjectTypes() as $objectType ) {

      $namespace = '\AcfEngine\Core\\' . $objectType['name'] . 'Manager';
      $manager = new $namespace();
      $files = $manager->getDataFiles();

      if( !empty( $files )) {

        foreach( $files as $filename ) {

          $data = $manager->loadDataFile( $filename );
  				$obj 	= $manager->initObject( $data );
          $post = $manager->fetchByKey( $obj->key() );

          if( $post ) {
            continue; // already exists in db
          }

          // use the import method found in abstract class
          $obj->import();

        }
      }
    }

  }

  protected function importableObjectTypes() {

    return [
      'block-type' => [
        'key'       => 'block-type',
        'name'      => 'BlockType'
      ],
      'post-type' => [
        'key'       => 'post-type',
        'name'      => 'PostType'
      ],
      'taxonomy' => [
        'key'       => 'taxonomy',
        'name'      => 'Taxonomy'
      ],
      'options-page' => [
        'key'       => 'options-page',
        'name'      => 'OptionsPage'
      ],
      'template' => [
        'key'       => 'template',
        'name'      => 'Template'
      ]
    ];

  }

}
