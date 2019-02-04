$(document).ready(function(){
  $('#menuBtn').on('click', function(){
    $scroll = $('window').scrollTop();
    $('#menu').slideToggle();
    $('scroll').toggleClass('scroll-prevent');
    if($('#msk').hasClass('hidden')) {
      $('#msk').removeClass('hidden');
    } else {
      $('#msk').addClass('hidden');
    }
  });
  $('#msk').on('click', function(){
    $('#menu').slideToggle();
    $('scroll').removeClass('scroll-prevent');
    $('#msk').addClass('hidden');
  });
});
