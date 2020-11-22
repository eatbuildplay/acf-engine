jQuery(document).ready(function( $ ) {

  $(document).on('acfg_data_refresh', function( e, data ) {

    // need meta key passed in data also

    let filterVal = data.filterVal;

    // do post request for data here


    wp.ajax.post( 'acfg_spa_load_data', data ).done(
      function( response ) {

         /*
          * Place content into table
          */
        $('.acfg-posts-table').html(
          'TABLE DATA HERE'
        );

      }
    )

  })

  /*
   * Edit link click and edit form loading
   */
  $('.acfg-posts-table td a').on('click', function(e) {

    e.preventDefault();
    $('.acfg-spa-create-form').hide();

    let formKey = $('.acfg-spa-edit-form-data').data('form-key');
    let postId = $(this).data('post-id');

    var data = {
      formKey: formKey,
      postId: postId
    }
    wp.ajax.post( 'acfg_spa_edit_form', data ).done(
      function( response ) {

         //response = JSON.parse(response);
         console.log( response );

         /*
          * Place form into dom
          */
        $('#edit-form-wrap').html( response.formMarkup );
        acf.do_action('append', $('#edit-form-wrap'));
        $(document).trigger('acf/setup_fields', $('#edit-form-wrap'));
        $('#edit-form-wrap').show();

      }
    ).fail(
      function() {
        console.log('failed')
      }
    );

  })

  /*
   * Create form click
   */
  $('.create-button').on('click', function(e) {
    $('#edit-form-wrap').hide();
    $('.acfg-spa-create-form').show();
    $(this).hide();
  })


});
