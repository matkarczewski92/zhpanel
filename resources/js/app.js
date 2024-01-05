import './bootstrap';


$(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip({
      selector: true,
      title: function() {
        return $(this).attr('href');
      }
    });
  });
