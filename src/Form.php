<?php

namespace AcfEngine\Core;

if (!defined('ABSPATH')) {
	exit;
}

abstract class Form {

  protected $prefix = 'acfg_';
  protected $postType = 'acfg_form';
  protected	$key;
  protected $postId;
  protected $title;
  protected $newPost;
  protected $fieldGroups;
  protected $fields;
  protected $postTitle;
  protected $postContent;
  protected $formAttributes;
  protected $return;
  protected $htmlBeforeFields;
  protected $htmlAfterFields;
  protected $submitValue = 'Update';
  protected $updatedMessage = 'Post updated';
  protected $labelPlacement;
  protected $instructionPlacement;
  protected $formFieldEl;
  protected $uploader;
  protected $honeypot;
  protected $htmlUpdatedMessage = '<div id="message" class="updated"><p>%s</p></div>';
  protected $htmlSubmitButton = '<input type="submit" class="acf-button button button-primary button-large" value="%s" />';
  protected $htmlSubmitSpinner = '<span class="acf-spinner"></span>';
  protected $kses;

  public function init() {
		$this->parseArgs();
		$this->register();
	}

  /*
   *
   * Form registration
   *
   */
  public function register() {

		$args = $this->args();

		//var_dump( $args );

		acf_register_form( $args );

	}


  public function parseArgs() {


	}

  public function args() {
    return $this->defaultArgs();
  }

  public function defaultArgs() {

	$args = [
		'id' 					=> $this->key(),
		'post_id' 	 			=> $this->postId(),
		'new_post'	 			=> $this->newPost(),
		'field_groups' 	 		=> [$this->fieldGroups()], // temporary fix, value must be array
		'post_title' 	 		=> $this->postTitle(),
		'post_content'	 		=> $this->postContent(),
		'form' 	 				=> $this->form(),
		'label_placement'	 	=> $this->labelPlacement(),
		'instruction_placement' => $this->instructionPlacement(),
		'field_el' 				=> $this->formFieldEl(),
		'uploader'	 			=> $this->uploader(),
		'honeypot' 				=> $this->honeypot(),
		'kses' 					=> $this->kses()
	];

    if( $this->fields() && $this->fields() != '' ) {
    	$args['fields'] = $this->fields();
    }

    if( $this->formAttributes() && $this->formAttributes() != '' ) {
    	$args['form_attributes'] = $this->formAttributes();
    }

    if( $this->updatedMessage() && $this->updatedMessage() != '' ) {
    	$args['updated_message'] = __($this->updatedMessage(), 'acf');
    }

	if( $this->submitValue() && $this->submitValue() != '' ) {
		$args['submit_value'] = __($this->submitValue(), 'acf');
	}

    if( $this->htmlUpdatedMessage() && $this->htmlUpdatedMessage() != '' ) {
    	$args['html_updated_message']	= $this->htmlUpdatedMessage();
    }

    if( $this->htmlSubmitSpinner() && $this->htmlSubmitSpinner() != '' ) {
    	$args['html_submit_spinner']	= $this->htmlSubmitSpinner();
    }

	if( $this->htmlSubmitButton() && $this->htmlSubmitButton() != '' ) {
		$args['html_submit_button']	= $this->htmlSubmitButton();
	}

	if( !empty($this->return()) ) {
		$args['return'] = $this->return();
	}

	if( !empty($this->htmlBeforeFields()) ) {
		$args['html_before_fields'] = $this->htmlBeforeFields();
	}

	if( !empty($this->htmlAfterFields()) ) {
		$args['html_after_fields'] = $this->htmlAfterFields();
	}

	return $args;

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

	public function setPostId( $v ) {
		$this->postId = $v;
	}

	public function postId() {
		return $this->postId;
	}

	public function postType() {
		return $this->postType;
	}

	public function setTitle( $v ) {
		$this->title = $v;
	}

	public function title() {
		return $this->title;
	}

	public function setNewPost( $v ) {
		$this->newPost = $v;
	}

	public function newPost() {
		return $this->newPost;
	}

	public function setFieldGroups( $v ) {
		$this->fieldGroups = $v;
	}

	public function fieldGroups() {
		return $this->fieldGroups;
	}

	public function setFields( $v ) {
		$this->fields = $v;
	}

	public function fields() {
		return $this->fields;
	}

	public function setPostTitle( $v ) {
		$this->postTitle = $v;
	}

	public function postTitle() {
		return $this->postTitle;
	}

	public function setPostContent( $v ) {
		$this->postContent = $v;
	}

	public function postContent() {
		return $this->postContent;
	}

	public function setForm( $v ) {
		$this->form = $v;
	}

	public function form() {
		return $this->form;
	}

	public function setFormAttributes( $v ) {
		$this->formAttributes = $v;
	}

	public function formAttributes() {
		return $this->formAttributes;
	}

	public function setReturn( $v ) {
		$this->return = $v;
	}

	public function return() {
		return $this->return;
	}

	public function setHtmlBeforeFields( $v ) {
		$this->htmlBeforeFields = $v;
	}

	public function htmlBeforeFields() {
		return $this->htmlBeforeFields;
	}

	public function setHtmlAfterFields( $v ) {
		$this->htmlAfterFields = $v;
	}

	public function htmlAfterFields() {
		return $this->htmlAfterFields;
	}

	public function setSubmitValue( $v ) {
    	if ( !empty($v) ){
        	$this->submitValue = $v;
    	}
    }

	public function submitValue() {
		return $this->submitValue;
	}

	public function setUpdatedMessage( $v ) {
		if ( !empty($v) ){
			$this->updatedMessage = $v;
		}
	}

	public function updatedMessage() {
		return $this->updatedMessage;
	}

	public function setLabelPlacement( $v ) {
		$this->labelPlacement = $v;
	}

	public function labelPlacement() {
		return $this->labelPlacement;
	}

	public function setInstructionPlacement( $v ) {
		$this->instructionPlacement = $v;
	}

	public function instructionPlacement() {
		return $this->instructionPlacement;
	}

	public function setFormFieldEl( $v ) {
		$this->formFieldEl = $v;
	}

	public function formFieldEl() {
		return $this->formFieldEl;
	}

	public function setUploader( $v ) {
		$this->uploader = $v;
	}

	public function uploader() {
		return $this->uploader;
	}

	public function setHoneypot( $v ) {
		$this->honeypot = $v;
	}

	public function honeypot() {
		return $this->honeypot;
	}

	public function setHtmlUpdatedMessage( $v ) {
		if ($v && $v != '') {
			$this->htmlUpdatedMessage = $v;
		}
	}

	public function htmlUpdatedMessage() {
		return $this->htmlUpdatedMessage;
	}

	public function setHtmlSubmitButton( $v ) {
        if ($v && $v != ''){
            $this->htmlSubmitButton = $v;
        }
    }

	public function htmlSubmitButton() {
		return $this->htmlSubmitButton;
	}

	public function setHtmlSubmitSpinner( $v ) {
    	if ($v && $v != '') {
            $this->htmlSubmitSpinner = $v;
        }
    }

	public function htmlSubmitSpinner() {
		return $this->htmlSubmitSpinner;
	}

	public function setKses( $v ) {
		$this->kses = $v;
	}

	public function kses() {
		return $this->kses;
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

		return $postId;

	}

}
