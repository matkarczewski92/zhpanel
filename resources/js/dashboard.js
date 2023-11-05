$(document).ready(function() {
    $('#table').DataTable();
} );

  $(document).ready(function(){
    $(".jsBtnKarma").click(function(){
      $(".optKarma").toggle();
      $(this).toggleClass("active");
    });

    $(".jsBtnOstatnie").click(function(){
      $(".optOstatnie").toggle();
      $(this).toggleClass("active");
    });

    $(".jsBtnNastepne").click(function(){
      $(".optNastepne").toggle();
      $(this).toggleClass("active");
    });

    $(".jsBtnInterwal").click(function(){
      $(".optInterwal").toggle();
      $(this).toggleClass("active");
    });

    $(".jsBtnWaga").click(function(){
      $(".optWaga").toggle();
      $(this).toggleClass("active");
    });

  });
