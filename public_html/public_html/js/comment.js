$(function(){
  'use strict';

  //upload
  $('#newCommentForm').on('click', '.submitBtn', function(){
    //コメント取得
    var comment = $('#newComment').val();
    //ユーザーid取得
    var user_id = $('#user_id').val();
    //記事id取得
    var article_id = $('#article_id').val();
    //ajax処理

    $.post('js/_ajax.php', {
      comment: comment,
      user_id: user_id,
      article_id: article_id,
      mode: 'upload',
      token: $('#token').val()
    }, function(res){
      // var str = res.comment;
      // console.log(str);
      // function nl2br(str) {
      //   str = str.replace(/\r\n/g, "<br />");
      //   str = str.replace(/(\n|\r)/g, "<br />");
      //   return str;
      // }
      // console.log(res);
      $('.commentCount').text(res.count);
      //liを追加
      var $li = $('#commentTemplate').clone();
      $li
      .attr('id', 'comment_' + res.id)
      .data('id', res.id)
      .find('.postdate').append(
        $('<p></p>')
        .text(res.postTime)
      ).end()
      .find('.caption').append(
        $('<p></p>')
        .html(res.comment.replace( /\r?\n/g, '<br />' ))
      )
      $('#comments').append($li.fadeIn(800));
    });
  });
  //delete
  $('#comments').on('click','.deleteComment',function(){
    //id取得
    var id = $(this).closest('li').data('id');
    //記事id取得
    var article_id = $('#article_id').val();
    //ajax処理
    if (confirm('ok?')) {
      $.post('js/_ajax.php', {
        id: id,
        article_id: article_id,
        mode: 'delete',
        token: $('#token').val()
      }, function(res){
        $('.commentCount').text(res.count);
        $('#comment_' + id).fadeOut(800);
      });
    }
  });
});
