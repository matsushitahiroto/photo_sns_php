$(function(){
  'use strict';

  $('.thumbs-up').on('click', function(){
    if($(this).hasClass('orangeIcon')){
      return false;
    } else {
      //ユーザーid取得
      var user_id = $('#user_id').val();
      //記事id取得
      var article_id = $('#article_id').val();
      //ajax処理
      $.post('js/_ajax.php', {
        user_id: user_id,
        article_id: article_id,
        mode: 'like',
        token: $('#token').val()
      }, function(res){
        $('.thumbs-up').addClass('orangeIcon');
        $("#green").addClass('height50px');
        $('#orange').removeClass('height50px');
        if($('#border').hasClass('orange')) {
          $('#border').removeClass('orange');
          $('#border').addClass('green');
        }
        if($('#greenAria').hasClass('hidden')) {
          $('#greenAria').removeClass('hidden');
          $('#orangeAria').addClass('hidden');
        }
        $('.thumbs-up-count').text(res.count);
        //liを追加
        var $li = $('#likeTemplate').clone();
        $li
        .attr('id', 'like_' + res.id)
        .data('id', res.id)
        .find('.postdate').append(
          $('<p></p>')
          .text(res.postTime)
        )
        $('#likes').append($li.fadeIn(800));
      });
    }
  });
  //delete
  $('#likes').on('click','.deleteLike',function(){
    //id取得
    var id = $(this).closest('li').data('id');
    console.log(id);
    //記事id取得
    var article_id = $('#article_id').val();
    console.log(article_id);

    //ajax処理
    $.post('js/_ajax.php', {
      id: id,
      article_id: article_id,
      mode: 'deleteLike',
      token: $('#token').val()
    }, function(res){
      $('.thumbs-up').removeClass('orangeIcon');
      $('.thumbs-up-count').text(res.count);
      $('#like_' + id).fadeOut(800);
    });
  });
});
