$(document).ready(function(){
  $("#green").on('click', function(){
    $(this).addClass('height45px');
    $('#orange').removeClass('height45px');
    if($('#border').hasClass('orange')) {
      $('#border').removeClass('orange');
      $('#border').addClass('green');
    }
    if($('#greenAria').hasClass('hidden')) {
      $('#greenAria').removeClass('hidden');
      $('#orangeAria').addClass('hidden');
    }
  });
  $("#orange").on('click', function(){
    $(this).addClass('height45px');
    $('#green').removeClass('height45px');
    if($('#border').hasClass('green')) {
      $('#border').removeClass('green');
      $('#border').addClass('orange');
    }
    if($('#orangeAria').hasClass('hidden')) {
      $('#orangeAria').removeClass('hidden');
      $('#greenAria').addClass('hidden');

    }
  });
});
