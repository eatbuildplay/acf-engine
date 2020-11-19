jQuery(document).ready(function( $ ) {

  function runFilterSetup() {

    // try to find filter in dom
    // add a change/click event to the filter
    // fire a loading ajax call

    var $filterEls = $('.acfg-filter');

    console.log( $filterEls );

    $filterEls.on('change', function() {
      var filterVal = $(this).val();
      applyFilter( filterVal );
    });


  }

  function applyFilter( filterVal ) {

    var data = {
      filter: filterVal
    }
    wp.ajax.post( 'acfg_spa_load_data', data ).done(
      function( response ) {

         console.log( response );

         /*
          * Place results into table
          */
        $('body').append('HELLO THIS IS REPLACE 34 FILTERRRRRR.');

      }
    ).fail(
      function() {
        console.log('failed')
      }
    );
    console.log('apply filter here')

  }

  runFilterSetup();

});
