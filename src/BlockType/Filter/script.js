jQuery(document).ready(function( $ ) {

  function runFilterSetup() {

    // try to find filter in dom
    // add a change/click event to the filter
    // fire a loading ajax call

    var $filterEls = $('.acfg-filter');

    console.log( $filterEls );

    $filterEls.on('change', function() {
      var filterVal = $(this).val();
      sendFilterRequest( filterVal );
    });


  }

  function sendFilterRequest( filterVal ) {

    $(document).trigger(
      'acfg_data_refresh',
      {
        filterVal: filterVal
      }
    );

    console.log('filter sent!!! ' + filterVal);

  }

  runFilterSetup();

});
