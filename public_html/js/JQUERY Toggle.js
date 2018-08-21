$(document).ready(function(){
  $('#menuBtn').on('click', function(){
    $('#menu').slideToggle();
    if($('#msk').hasClass('hidden')) {
      $('#msk').removeClass('hidden');
    } else {
      $('#msk').addClass('hidden');
    }
  });
  $('#msk').on('click', function(){
    $('#menu').slideToggle();
    $('#msk').addClass('hidden');
  });
});
