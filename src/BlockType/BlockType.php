<?php

namespace AcfEngine\Core\BlockType;

if (!defined('ABSPATH')) {
	exit;
}

abstract class BlockType {

  protected $prefix = 'acfg_';
	protected $postType = 'acfg_block_type';
  public 		$key;
	protected $renderCode;
	protected $category;
	protected $icon;
	protected $keywords;
	protected $postTypes;
	protected $mode;
	protected $align;
	protected $alignText;
	protected $alignContent;
	protected $renderTemplate;
	protected $renderCallback;
	protected $enqueueStyle;
	protected $enqueueScript;
	protected $enqueueAssets;
	protected $supports;

  public function init() {
		$this->parseArgs();
		$this->register();
	}

  /*
   *
   * Block registration
   * https://www.advancedcustomfields.com/resources/acf_register_block_type/
   *
   */
  public function register() {

		$args = [
			'name'              => $this->getPrefixedKey(),
			'title'             => $this->title(),
			'description'       => $this->description(),
			'category'          => 'formatting',
			'mode'							=> 'preview',
			'supports'					=> [
				'align' => true,
        'mode' 	=> true,
        'jsx' 	=> true
			]
		];

		if( $this->renderTemplate() ) {
			$args['render_template'] = $this->renderTemplate();
		} elseif( $this->renderCallback() ) {
			$args['render_callback'] = $this->renderCallback();
		} else {
			$args['render_callback'] = [$this, 'defaultCallback'];
		}

		if( $this->enqueueScript() ) {
			$args['enqueue_script'] = $this->enqueueScript();
		}

		if( $this->enqueueStyle() ) {
			$args['enqueue_style'] = $this->enqueueStyle();
		}

		if( $this->enqueueAssets() ) {
			$args['enqueue_assets'] = $this->enqueueAssets();
		}

    acf_register_block_type( $args );

	}

	public function setRenderTemplate( $v ) {
		$this->renderTemplate = $v;
	}

	public function renderCallback() {
		return $this->renderCallback;
	}

	public function setRenderCallback( $v ) {
		$this->renderCallback = $v;
	}

	public function renderTemplate() {
		return $this->renderTemplate;
	}

	/*
	 * Default callback registered when blocks created
	 * Uses the render_code field (user written code)
	 */
	public function defaultCallback( $block, $content = '', $isPreview, $editorPostId ) {

		$filename = str_replace('acf/acfg-', '', $block['name']) . '.json';
		$filename = str_replace('-', '_', $filename);

		$json = file_get_contents( \AcfEngine\Plugin::dataStoragePath() . 'block-types/' . $filename );
		$data = json_decode( $json );

		$code = get_field( 'render_code', $data->id );
		print $code;

	}

  public function parseArgs() {



	}

  public function args() {
    return $this->defaultArgs();
  }

  public function defaultArgs() {

  }

  public function getPrefixedKey() {
		return $this->prefix . $this->key();
	}

  public function setKey( $v ) {
		$this->key = $v;
	}

	public function key() {
		return $this->key;
	}

	public function setTitle( $v ) {
		$this->title = $v;
	}

	public function title() {
		return $this->title;
	}

	public function setDescription( $v ) {
		$this->description = $v;
	}

	public function description() {
		return $this->description;
	}

	public function setRenderCode( $v ) {
		$this->renderCode = $v;
	}

	public function renderCode() {
		return $this->renderCode;
	}

	public function setCategory( $v ) {
		$this->category = $v;
	}

	public function category() {
		return $this->category;
	}

	public function setIcon( $v ) {
		$this->icon = $v;
	}

	public function icon() {
		return $this->icon;
	}

	public function setKeywords( $v ) {
		$this->keywords = $v;
	}

	public function keywords() {
		return $this->keywords;
	}

	public function setPostTypes( $v ) {
		$this->postTypes = $v;
	}

	public function postTypes() {
		return $this->postTypes;
	}

	public function setMode( $v ) {
		$this->mode = $v;
	}

	public function mode() {
		return $this->mode;
	}

	public function setAlign( $v ) {
		$this->align = $v;
	}

	public function align() {
		return $this->align;
	}

	public function setAlignText( $v ) {
		$this->alignText = $v;
	}

	public function alignText() {
		return $this->alignText;
	}

	public function setAlignContent( $v ) {
		$this->alignContent = $v;
	}

	public function alignContent() {
		return $this->alignContent;
	}

	public function setEnqueueStyle( $v ) {
		$this->enqueueStyle = $v;
	}

	public function enqueueStyle() {
		return $this->enqueueStyle;
	}

	public function setEnqueueScript( $v ) {
		$this->enqueueScript = $v;
	}

	public function enqueueScript() {
		return $this->enqueueScript;
	}

	public function setEnqueueAssets( $v ) {
		$this->enqueueAssets = $v;
	}

	public function enqueueAssets() {
		return $this->enqueueAssets;
	}

	public function postType() {
		return $this->postType;
	}

	/*
	 * Make a WP post with meta data from the current properties of this object
	 */
	public function import() {

		/*
		 * insert into db with create post
		 */
		$postId = wp_insert_post(
			[
				'post_type'      => $this->postType(),
				'post_title'     => $this->title,
				'post_status'    => 'publish'
			]
		);

		/*
		 * update acf fields with meta data
		 */
		update_field( 'key', $this->key, $postId );
		update_field( 'title', $this->title, $postId );
		update_field( 'description', $this->description, $postId );
		update_field( 'render_code', $this->renderCode, $postId );
		update_field( 'category', $this->category, $postId );
		update_field( 'icon', $this->icon, $postId );
		update_field( 'keywords', $this->keywords, $postId );
		update_field( 'post_types', $this->postTypes, $postId );
		update_field( 'mode', $this->mode, $postId );
		update_field( 'align', $this->align, $postId );
		update_field( 'align_text', $this->alignText, $postId );
		update_field( 'align_content', $this->alignContent, $postId );
		update_field( 'render_template', $this->renderTemplate, $postId );
		update_field( 'render_callback', $this->renderCallback, $postId );
		update_field( 'enqueue_style', $this->enqueueStyle, $postId );
		update_field( 'enqueue_style', $this->enqueueStyle, $postId );
		update_field( 'enqueue_script', $this->enqueueScript, $postId );
		update_field( 'enqueue_assets', $this->enqueueAssets, $postId );
		update_field( 'supports', $this->supports, $postId );

		return $postId;

	}

	protected function getPreviewPost( $editorPostId ) {

		$templatePostType = get_field('post_type', $editorPostId);
		if( !$templatePostType ) {
			return false;
		}

		$previewPosts = get_posts([
			'post_type' => $templatePostType
		]);
		if( empty( $previewPosts )) {
			return false;
		}

		return $previewPosts[0];

	}

	protected function replaceDynamicTags( $content, $postId ) {

		// check for field placeholders
		if( strpos( $content, '{{' ) !== false ) {

			preg_match_all('/{{(.*?)}}/', $content, $matches);
			if( !empty( $matches[1] )) {
				foreach( $matches[1] as $placeholder ) {
					$placeholderValue = get_field( $placeholder, $postId );
					$content = str_replace('{{'.$placeholder.'}}', $placeholderValue, $content);
				}
			}
		}

		return $content;

	}

	protected function parseBlockContent( $content ) {

    $priority = has_filter( 'the_content', 'wpautop' );
    if ( false !== $priority && doing_filter( 'the_content' ) && has_blocks( $content ) ) {
    	remove_filter( 'the_content', 'wpautop', $priority );
    	add_filter( 'the_content', '_restore_wpautop_hook', $priority + 1 );
    }
    $blocks = parse_blocks( $content );
    $output = '';
    foreach ( $blocks as $block ) {
      $output .= render_block( $block );
    }
    return $output;

  }

}
