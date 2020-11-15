console.log('what up from SPA')

jQuery(document).ready(function( $ ) {

  $('.acfg-posts-table td a').on('click', function(e) {

    e.preventDefault();

    let formKey = $('.acfg-spa-edit-form-data').data('form-key');

    var data = {
      formKey: formKey,
      postId: 251
    }
    wp.ajax.post( 'acfg_spa_edit_form', data ).done(
      function( response ) {

         //response = JSON.parse(response);
         console.log( response );

         /*
          * Place form into dom
          */
        $('.acfg-posts-table').prepend( response.formMarkup );
        acf.do_action('append', $('.acfg-posts-table'));

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
    $('.acfg-spa-create-form').show();
    $(this).hide();
  })


});
