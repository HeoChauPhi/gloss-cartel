(function($) {
  function dateTimePicker() {
    console.log('ok');
    $('.acf-field[data-name*="time_form_event"] input, .acf-field[data-name*="time_to_event"] input').datetimepicker({
      format: 'LT'
    });
  }

  $(document).ready(function() {
    // Call to function
    dateTimePicker();
  });

  $(window).load(function() {
    // Call to function
  });

  $(window).resize(function() {
    // Call to function
  });
})(jQuery);
