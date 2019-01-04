<?php

require_once(__DIR__ . '/../config/config.php');

$app = new MyApp\Controller\Custom();

$app->run();

 ?>
 <!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>test</title>
    <link rel="stylesheet" href="css/import.css">
    <link rel="stylesheet" href="cropper/cropper.css" charset="UTF-8">
    <link rel="stylesheet" href="font/font-awesome.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js" charset="UTF-8"></script>
    <script type="text/javascript" src="cropper/cropper.js" charset="UTF-8"></script>
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/JQUERY Toggle.js"></script>
    <script src="js/JQUERY ChangeColor.js"></script>
    <script src="js/JQUERY ChangeImage.js"></script>
  </head>
  <body>
    <div class="wrapper">
      <div id="msk" class="hidden"></div>
      <header>
        <div class="headerInner">
          <div class="headerTitle">
            <h1>ふらつき場</h1>
          </div>
          <div class="headerNav">
            <ul>
              <li id="menuBtn">
                <i class="fas fa-bars fa-2x"></i><br>メニュー
              </li>
            </ul>
            <div class="headerMenu hidden" id="menu">
              <div class="user">
                <div class="userIcon flexCenter">
                  <?php if(!isset($app->me()->iconPath)): ?>
                    <div class="userIconInner">
                    </div>
                  <?php else: ?>
                  <img src="<?php echo h($app->me()->iconPath); ?>" alt="ゲスト写真"  class="userIconInner">
                  <?php endif; ?>
                </div>
                <div class="userData">
                  <div class="postUser">
                    <p><span class="fs20"><?php echo h($app->me()->name); ?></span> さん</p>
                  </div>
                </div>
              </div>
              <ul>
                <li><a href="profile.php">プロフィール</a></li>
                <li><a href="post.php">投稿</a></li>
                <li><a href="custom.php">編集</a></li>
                <li><a href="">プライバシー</a></li>
                <li><a href="">ヘルプ</a></li>
                <li><a href="">利用規約</a></li>
                <li>
                  <form action="logout.php" method="post" id="logout">
                    <input type="hidden" name="token" value="<?php echo h($_SESSION['token']); ?>">
                    <div class="fs30" onclick="document.getElementById('logout').submit();">
                      ログアウト
                    </div>
                  </form>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </header>
      <div class="container">
        <div id="form" class="form">
          <h2>プロフィール変更</h2>
          <form action="" method="post" id="custom">
            <div class="cropper-container">
              <p><span class="fs20">アイコン</span></br>
              <input type="file" id="triming_image" name="triming_image" class="triming-image" required /></p>
              <p><img src="" alt="トリミング画像" id="trimed_image" style="display: none;" /></p>
              <p><input type="button" id="crop_btn" value="画像をトリミングして送信" /></p>
            </div>
            <div id="result">
              <img src="<?php echo h($app->me()->iconPath); ?>" alt="画像が読めません"  id="trimed">
            </div>
            <p class="name">
              <span class="fs20">名前</span></br>
              <input type="name" name="name" value="<?php echo h($app->me()->name); ?>">
            </p>
            <p class="description">
              <span class="fs20">自己紹介</span></br>
              <textarea class="fs24" name="description" rows="6" placeholder="こんにちは。"><?php echo h($app->me()->description); ?></textarea>
            </p>
            <p class="email">
              <span class="fs20">メールアドレス</span></br>
              <input type="email" name="email" value="<?php echo h($app->me()->email); ?>">
            </p>
            <p class="password">
              <span class="fs20">パスワードを入力</span></br>
              <input type="password" name="password" placeholder="パスワード">
            </p>
            <input type="hidden" name="iconPath" id="savePath" value="<?php echo h($app->me()->iconPath); ?>">
            <input type="hidden" name="token" value="<?php echo h($_SESSION['token']); ?>">
            <input type="hidden" name="id" value="<?php echo h($app->me()->id); ?>">
            <p class="err">
              <?php echo h($app->getErrors('name')); ?>
              <?php echo h($app->getErrors('description')); ?>
              <?php echo h($app->getErrors('email')); ?>
              <?php echo h($app->getErrors('demail')); ?>
              <?php echo h($app->getErrors('custom')); ?>
              <?php echo h($app->getErrors('password')); ?>
            </p>
            <div class="btn submitBtn" onclick="document.getElementById('custom').submit();">
              保存
            </div>
            <a href="index.php">
              <div class="btn">
                  戻る
              </div>
            </a>
          </form>
        </div>
      </div>
    </div>
    <footer>
      <div class="footerMenu">
        <div class="footerMenuInner flexCenter">
          <a href="">
            ヘルプ
          </a>
        </div>
        <div class="footerMenuInner flexCenter">
          <a href="">
            プライバシー
          </a>
        </div>
        <div class="footerMenuInner flexCenter">
          <a href="">
            利用規約
          </a>
        </div>
      </div>
      <div class="footerTitle">
        <h1>ふらつき場</h1>
      </div>
      <address>
        &copy;Copyright 2018 Neko.
      </address>
    </footer>
    <div class="bottomMenu">
      <div class="menuIcon flexCenter">
        <a href="index.php">
          <i class="fas fa-home fa-2x"></i>
        </a>
      </div>
      <div class="menuIcon flexCenter">
        <a href="post.php">
          <i class="fas fa-plus fa-2x"></i>
        </a>
      </div>
      <div class="menuIcon flexCenter">
        <a href="profile.php">
          <i class="fas fa-user fa-2x"></i>
        </a>
      </div>
    </div>
  </body>
  <script type="text/javascript">
      /**
       * 丸くトリミングするために必要な関数です。
       * キャンバスの画像を円形に座標計算し、切り取って返しています。
       */
      function getRoundedCanvas(sourceCanvas) {
          var canvas = document.createElement('canvas');
          var context = canvas.getContext('2d');
          var width = sourceCanvas.width;
          var height = sourceCanvas.height;

          canvas.width = width;
          canvas.height = height;
          context.imageSmoothingEnabled = true;
          context.drawImage(sourceCanvas, 0, 0, width, height);
          context.globalCompositeOperation = 'destination-in';
          context.beginPath();
          context.arc(width / 2, height / 2, Math.min(width, height) / 2, 0, 2 * Math.PI, true);
          context.fill();
          return canvas;
      }

      $(function(){
          $('#triming_image').on('change', function(event){
              var trimingImage = event.target.files;

              // imageタグは1つしかファイルを送信できない仕組みと複数送信する仕組みの二通りありますので、サーバー側でチェックを忘れないようにしてください。
              if(trimingImage.length > 1){
                  console.log(trimingImage.length + 'つのファイルが選択されました。');
                  return false;
              }
              // 改め代入します。
              trimingImage = trimingImage[0];

              // 画像のチェックを行いますが、あくまでjsでのチェックなのでサーバーサイドでもう一度チェックを行ってください。
              if(!trimingImage.type.match('image/jp.*') // jpg jpeg でない
               &&!trimingImage.type.match('image/png') // png でない
               &&!trimingImage.type.match('image/gif') // gif でない
               &&!trimingImage.type.match('image/bmp') // bmp でない
              ){
                  alert('No Support ' + trimingImage.type + ' type image');
                  $(this).val('');
                  return false;
              }

              var fileReader = new FileReader();
              fileReader.onload = function(e){
                  var int32View = new Uint8Array(e.target.result);
                  // see https://en.wikipedia.org/wiki/List_of_file_signatures
                  // ファイルのヘッダを参照し、マイムタイプを疑似的に取得します。フレームワークによってはもっと簡単に正確に読めるものもあります。
                  // 下記は厳しい設定です。正規の手順を踏んでもアップロードできないカメラなどがあります。
                  // （私の環境ではアクションカメラの写真などは下記に引っ掛かりました。）
                  if((int32View.length>4 && int32View[0]==0xFF && int32View[1]==0xD8 && int32View[2]==0xFF && int32View[3]==0xE0)
                  || (int32View.length>4 && int32View[0]==0xFF && int32View[1]==0xD8 && int32View[2]==0xFF && int32View[3]==0xDB)
                  || (int32View.length>4 && int32View[0]==0xFF && int32View[1]==0xD8 && int32View[2]==0xFF && int32View[3]==0xD1)
                  || (int32View.length>4 && int32View[0]==0x89 && int32View[1]==0x50 && int32View[2]==0x4E && int32View[3]==0x47)
                  || (int32View.length>4 && int32View[0]==0x47 && int32View[1]==0x49 && int32View[2]==0x46 && int32View[3]==0x38)
                  || (int32View.length=2 && int32View[0]==0x42 && int32View[1]==0x4D && int32View[2]==0x46 && int32View[3]==0x38)
                  ){
                      // success
                      $('#trimed_image').css('display', 'block');
                      $('#trimed_image').attr('src', URL.createObjectURL(trimingImage));
                      return true;
                  } else {
                      // failed
                      alert('No Support ' + trimingImage.type + ' type image');
                      // exeファイルのアップロードを考えると下記よりもいいプラクティスがある可能性があります。
                      $('#trimed_image').val('');
                      return false;
                  }
              };
              fileReader.readAsArrayBuffer(trimingImage);

              fileReader.onloadend = function(e){
                  var image = document.getElementById('trimed_image');
                  var button = document.getElementById('crop_btn');

                  var croppable = false;
                  var cropper = new Cropper(image, {
                      aspectRatio: 1,
                      viewMode: 1,
                      ready: function () {
                          croppable = true;
                      },
                  });

                  // fileReaderが完了した後にボタンクリックイベントを作成する必要があります。
                  button.onclick = function () {
                      var croppedCanvas;

                      if (!croppable) {
                          alert('トリミングする画像が設定されていません。');
                          return false;
                      }

                      // cropper.jsに用意されている機能です。
                      croppedCanvas = cropper.getCroppedCanvas();
                      // 下記toBlob関数はブラウザによって名前が違います。
                      var blob;
                      if(croppedCanvas.toBlob){
                          croppedCanvas.toBlob(function(blob){
                              var trimedImageForm = new FormData();
                              trimedImageForm.append('blob', blob);
                              // この例ではAjaxにて送信します。
                              $.ajax({
                                  url: './cropper/uploadTrimedImage.php', // POST送信先
                                  type: 'post',
                                  processData: false,
                                  contentType: false,
                                  data: trimedImageForm,
                              }).done(function( jsonResponse ){
                                  var responese = $.parseJSON(jsonResponse);
                                  if(responese.status == 'success'){
                                      console.log(responese);
                                      alert('アップロードしました。');
                                      var path = document.getElementById('savePath');
                                      path.value = responese.obj;
                                  }else if(responese.status == 'error'){
                                      alert('画像作成に失敗しました。再度お試しください。\n' + responese.msg);
                                  }else{
                                      alert('システムエラーが発生しました。');
                                  }
                              }).fail(function( responese ) {
                                  alert('システムエラーが発生しました。');
                                  // フレームワークによってはサーバーエラーをjsonで返してくれます。
                                  var responese = $.parseJSON(jsonResponse);
                              });
                          });
                      }else if(croppedCanvas.msToBlob){
                          blob = croppedCanvas.msToBlob();
                          var trimedImageForm = new FormData();
                          trimedImageForm.append('blob', blob);
                          // この例ではAjaxにて送信します。
                          $.ajax({
                              url: './cropper/uploadTrimedImage.php', // POST送信先
                              type: 'post',
                              processData: false,
                              contentType: false,
                              data: trimedImageForm,
                          }).done(function( jsonResponse ){
                              var responese = $.parseJSON(jsonResponse);
                              if(responese.status == 'success'){
                                  console.log(responese);
                                  alert('アップロードしました。');
                              }else if(responese.status == 'error'){
                                  alert('画像作成に失敗しました。再度お試しください。\n' + responese.msg);
                              }else{
                                  alert('システムエラーが発生しました。');
                              }
                          }).fail(function( responese ) {
                              alert('システムエラーが発生しました。');
                              // フレームワークによってはサーバーエラーをjsonで返してくれます。
                              var responese = $.parseJSON(jsonResponse);
                          });
                      }else{
                          // これは少しわからないです。申し訳ない。
                          imageURL = canvas.toDataURL();
                      }

                      // 画面にトリミング結果を出力する場合は下記が必要です。
                      // 例ではAjaxにて送信済みでので、下記機能に特に意味がありません。（結果表示したところですでに送信済みですので。）
                      var trimed = document.getElementById('trimed');
                      var roundedImage;
                      roundedCanvas = getRoundedCanvas(croppedCanvas);
                      trimed.src = roundedCanvas.toDataURL()
                  };
              };
          });
      });
  </script>
</html>
