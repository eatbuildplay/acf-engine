<?php

namespace AcfEngine\Core\BlockType;

if (!defined('ABSPATH')) {
	exit;
}

class BlockTypeManager {

  public function setup() {

    add_action('save_post', [$this, 'savePost'], 10, 3);
    add_action('acf/init', [$this, 'registerBlockTypes']);

  }


  public function savePost( $postId, $post, $update ) {

    // only target our post type registrations
    if( $post->post_type !== 'acfg_block_type' ) {
      return;
    }

		$data = new \stdClass();

		$data->key = get_field('key', $postId);
		if( !$data->key ) {
			return;
		}

		$data->id = $postId;
		$data->title 					= get_field('title', $postId);
		$data->description 		= get_field('title', $postId);
		$data->renderCode 		= get_field('render_code', $postId);
		$data->category		 		= get_field('category', $postId);
		$data->icon		 				= get_field('icon', $postId);
		$data->keywords		 		= get_field('keywords', $postId);
		$data->postTypes			= get_field('post_types', $postId);
		$data->mode						= get_field('mode', $postId);
		$data->align					= get_field('align', $postId);
		$data->alignText			= get_field('align_text', $postId);
		$data->alignContent		= get_field('align_content', $postId);
		$data->renderTemplate	= get_field('render_template', $postId);
		$data->renderCallback	= get_field('render_callback', $postId);
		$data->enqueueStyle		= get_field('enqueue_style', $postId);
		$data->enqueueScript	= get_field('enqueue_script', $postId);
		$data->enqueueAssets	= get_field('enqueue_assets', $postId);
		$data->supports				= get_field('supports', $postId);

		/* update post title */
		remove_action( 'save_post', [$this, 'savePost'] );
		wp_update_post(
			[
				'ID' => $postId,
				'post_title' => $data->title
			]
		);

    $json = json_encode( $data );
    \file_put_contents( \AcfEngine\Plugin::dataStoragePath() . 'block-types/' . $data->key . '.json', $json );

  }

  public function registerBlockTypes() {


		/*
		 * Register internal React block types
		 */
		new FancyText();
		new NavBar();

		/*
		 * Register internal ACF block types
		 */

		$bt = new Accordion();
		$bt->init();

		$bt = new AcfTemplate();
 		$bt->init();

		$bt = new AcfField();
		$bt->init();

		$bt = new AcfFieldNumber();
		$bt->init();

		$bt = new AcfFieldImage();
		$bt->init();

		$bt = new AcfRepeaterGallery();
		$bt->init();

		$bt = new BigHeadline();
		$bt->init();

		$bt = new Image();
		$bt->init();

		$bt = new Header();
		$bt->init();

		$bt = new Footer();
		$bt->init();

		$bt = new Heading();
		$bt->init();

		$bt = new TextEditor();
		$bt->init();

		$bt = new Video();
		$bt->init();

		$bt = new Button();
		$bt->init();

		$bt = new StarRating();
		$bt->init();

		$bt = new Icon();
		$bt->init();

		$bt = new CallToAction();
		$bt->init();

		$bt = new BlockQuote();
		$bt->init();

		$bt = new CountDown();
		$bt->init();

		$bt = new Counter();
		$bt->init();

		$bt = new Alert();
		$bt->init();

		$bt = new FlipBox();
		$bt->init();

		$bt = new Form();
		$bt->init();

		$bt = new GoogleMap();
		$bt->init();

		$bt = new Gallery();
		$bt->init();

		$bt = new Html();
		$bt->init();

		$bt = new IconBox();
		$bt->init();

		$bt = new IconList();
		$bt->init();

		$bt = new ImageBox();
		$bt->init();

		$bt = new ImageCarousel();
		$bt->init();

		$bt = new Login();
		$bt->init();

		$bt = new Logo();
		$bt->init();

		$bt = new Lottie();
		$bt->init();

		$bt = new Menu();
		$bt->init();

		$bt = new Posts();
		$bt->init();

		$bt = new PriceTable();
		$bt->init();

		$bt = new MenuAnchor();
		$bt->init();

		$bt = new Portfolio();
		$bt->init();

		$bt = new Slides();
		$bt->init();

		$bt = new ShareButtons();
		$bt->init();

		$bt = new Register();
		$bt->init();

		$bt = new Reviews();
		$bt->init();

		$bt = new ProgressBar();
		$bt->init();

		$bt = new Testimonial();
		$bt->init();

		$bt = new TableOfContents();
		$bt->init();

		$bt = new Tabs();
		$bt->init();

		$bt = new SocialIcons();
		$bt->init();

		$bt = new Users();
		$bt->init();

		$bt = new Toggle();
		$bt->init();

    // get all the data files stored
    $dataFiles = $this->findBlockTypeDataFiles();

    if( !empty( $dataFiles )) {

      foreach( $dataFiles as $filename ) {

        $data = $this->loadDataFile( $filename );
				$obj 	= $this->initObject( $data );
        $obj->register();

      }
    }
  }

	public function fetchByKey( $key ) {

		$posts = get_posts([
			'post_type' 	=> 'acfg_block_type',
			'numberposts' => -1,
			'meta_query' => [
				[
					'key' 	=> 'key',
					'value' => $key
				]
			]
		]);

		if( !$posts || empty( $posts )) {
			return false;
		}

		return $posts[0];

	}

	public function initObject( $data ) {
		$obj = new BlockTypeCustom();
		$obj->setKey( $data->key );
		$obj->setTitle( $data->title );
		$obj->setDescription( $data->description );
		return $obj;
	}

	public function loadDataFile( $filename ) {
		$json = file_get_contents( \AcfEngine\Plugin::dataStoragePath() . 'block-types/' . $filename );
		return json_decode( $json );
	}

	// public option to get the data file list
	public function getDataFiles() {
		return $this->findBlockTypeDataFiles();
	}

  protected function findBlockTypeDataFiles() {

    $files = [];
		if( !is_dir( \AcfEngine\Plugin::dataStoragePath() . 'block-types')) {
			return [];
		}
    $dir = new \DirectoryIterator( \AcfEngine\Plugin::dataStoragePath() . 'block-types' );

    foreach ($dir as $fileInfo) {
      if (!$fileInfo->isDot()) {
        $files[] = $fileInfo->getFilename();
      }
    }

    return $files;

  }




}
