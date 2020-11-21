<?php

namespace AcfEngine\Core\BlockType;
use AcfEngine\Core\QueryManager;
use AcfEngine\Core\FormManager;

if (!defined('ABSPATH')) {
	exit;
}

class SinglePageApp extends BlockType {

  public function __construct() {

    add_action('wp_ajax_acfg_spa_edit_form', function() {

      $formManager = new FormManager();
      $registeredForms = $formManager->registerForms();
      $postId = $_POST['postId'];
      $editFormKey = $_POST['formKey'];
      $form = $registeredForms[ $editFormKey ];
      $form->setPostId( $postId );


			$currentUrl = 'http://exercise-tracker.dev.cc/spa-test';
			$form->setReturn( $currentUrl );
      $formArgs = $form->args();

			//var_dump( $formArgs ); die();

      ob_start();
        print '<div class="acfg-spa-edit-form" data-form-key="' . $editFormKey . '">';
    		print acf_form( $formArgs );
        print '</div>';
      $formMarkup = ob_get_contents();
      ob_end_clean();

      $response = new \stdClass;
      $response->code = 200;
      $response->formMarkup = $formMarkup;
      wp_send_json_success( $response );

    });

  }

  public function key() {
		return 'single_page_app';
	}

  public function title() {
    return 'Single Page App';
  }

  public function description() {
    return 'A single page application for the management of a post type.';
  }

  public function renderCallback() {
    return [$this, 'callback'];
  }

  public function enqueueScript() {
    return ACF_ENGINE_URL . 'src/BlockType/SinglePageApp/script.js';
  }

  public function enqueueStyle() {
    return ACF_ENGINE_URL . 'src/BlockType/SinglePageApp/styles.css';
  }

  public function callback( $block, $content, $isPreview, $postId ) {

		if( $isPreview ) {
			$previewPost = $this->getPreviewPost( $postId );
			$postId = $previewPost->ID;
    }

		$this->render( $block, $content, $postId );

  }

	protected function render( $block, $content, $postId ) {

    /*
     * Create form
     */
		$createFormKey = get_field( 'create_form_key' );
		if( !$createFormKey ) {
			print "Set create form key to see create form.";
			return;
		}
		print '<button class="create-button">CREATE</button>';
    print '<div class="acfg-spa-create-form">';
		acf_form( $createFormKey );
    print '</div>';

		/*
		 * Edit form wrap (placement position for JS)
		 */
		print '<div id="edit-form-wrap"></div>';

    /*
     * Posts table
     */
    $this->postsTable();

    /*
     * Edit form
     */
    $editFormKey = get_field( 'edit_form_key' );
		if( !$editFormKey ) {
			print "Set create form key to see edit form.";
			return;
		}
    print '<div class="acfg-spa-edit-form-data" data-form-key="' . $editFormKey . '">';
    print '</div>';

	}

  public function postsTable() {

		// https://support.advancedcustomfields.com/forums/topic/getting-get_field-outside-block-loop/
    $columns = get_field('columns');

		if( !$columns ) {
			print '<h2>No columns defined.</h2>';
			return;
		}

		$columnFieldKeys = [];
		foreach( $columns as $row ) {
			$columnFieldKeys[] = $row['column_field_key'];
		}

		$queryKey = get_field('query');
		$query = QueryManager::load( $queryKey );
		$posts = $query->run();

    if( !$posts ) {
      print '<h2>No posts returned in query.</h2>';
    }

    print '<div class="acfg-posts-table">';
    print '<table>';
    foreach( $posts as $post ) {

      print '<tr>';

			foreach( $columnFieldKeys as $fieldKey ) {

				$fieldObject = get_field_object( $fieldKey, $post->ID );
				if( !$fieldObject || $fieldObject['type'] == '' ) {
					print '<td>--&nbsp;</td>';
					continue;
				}
				$tl = new \AcfEngine\Core\TemplateLoader();
				$tl->path = 'templates/fields/' . $fieldObject['type'] . '/';
				$tl->name = 'default';
				$tl->data = [
					'field'  => $fieldObject,
					'value'  => $fieldObject['value'],
					'postId' => $post->ID
				];
				$content = $tl->get();

				print '<td>';
	      print $content;
	      print '</td>';

			}

			if( get_field('management_column') == 1 ) {

				print '<td>';
				print '<a data-post-id="' . $post->ID . '" href="' . get_edit_post_link( $post ) . '">Edit</a>';
				print '</td>';

			}

      print '</tr>';

    }

		$calculations = get_field('calculations');

		if( !empty($calculations)) {
			foreach( $calculations as $calculation ) {

				$valueField = $calculation['value_field'];
				$groupingField = $calculation['grouping_field'];
				$type = get_field('type', $post->ID);

				if(!$groupingField) {
					$result = 0;
				} else {
					$result = [];
				}
				foreach( $posts as $post ) {

					if(!$groupingField) {
						// singular calculation
						$result += (int) get_field($valueField, $post->ID);
					} else {
						// grouped calculations
						$group = get_field($groupingField, $post->ID);
						if( !isset( $result[$group] )) {
							$result[$group] = 0;
						}
						$result[$group] += (int) get_field($valueField, $post->ID);
					}

				}



			} // end foreach over all calculations
		}

		if( $calculations ) {

			print '<tfoot>';
			print '<tr>';
			print '<td>';
			if( is_array( $result )) {
				foreach( $result as $index => $value ) {
					print '<h3>' . $index . ' - ' . $value . '</h3>';
				}
			} else {
					print '<h3>' . $result . '</h3>';
			}
			print '</td>';
			print '</tr>';
			print '</tfoot>';

		}

		print '</table>';
		print '</div>';

  }

}
