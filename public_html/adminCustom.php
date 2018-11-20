<?php
require_once(__DIR__ . '/../config/config.php');

$app = new MyApp\Controller\AdminCustom();

$app->run();

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>photo_sns_php管理画面</title>
</head>
<style media="screen">
  img {
    max-width: 400px;
  }
  .btn {
    font-size: 16px;
    text-align: center;
    display: inline-block;
    margin: 10px;
    width: 80px;
    height: 30px;
    background-color: #fff;
    border-radius: 10%;
    box-shadow: 2px 2px 5px #666;
    cursor: pointer;
  }
  #target {
    width: 550px;
    height: 300px;
  }
</style>
<body>
  <h1>編集画面</h1>

  <p class="err">
    <?php echo h($app->getErrors('name')) ?>
    <?php echo h($app->getErrors('description')) ?>
    <?php echo h($app->getErrors('email')) ?>
    <?php echo h($app->getErrors('demail')) ?>
    <?php echo h($app->getErrors('title')) ?>
    <?php echo h($app->getErrors('upload')) ?>
    <?php echo h($app->getErrors('address')) ?>
    <?php echo h($app->getErrors('lat')) ?>
    <?php echo h($app->getErrors('lng')) ?>
  </p>

  <?php if ($_GET['type'] === 'user'): ?>

    <form action="" method="post">
      <p>ユーザー名</br><input type="text" name="name" value="<?php echo h($app->getValues()->user->name); ?>"></p>
      <p>管理者フラグ</br>
        <select name="admin">
          <option value="0">一般ユーザー</option>
          <option value="1" <?php if ($app->getValues()->user->admin === '1') {echo 'selected';} ?>>管理者</option>
        </select>
      </p>
      <p>自己紹介</br><input type="text" name="description" value="<?php echo h($app->getValues()->user->description); ?>"></p>
      <p>メールアドレス</br><input type="text" name="email" value="<?php echo h($app->getValues()->user->email); ?>"></p>
      <input type="hidden" name="id" value="<?php echo h($_GET['id']); ?>">
      <input type="hidden" name="token" value="<?php echo h($_SESSION['token']); ?>">
      <input class="btn" type="submit" value="編集">
    </form>

    <a href="adminUser.php">Go Back</a>

  <?php endif; ?>

  <?php if ($_GET['type'] === 'article'): ?>

    <form action="" method="post">
      <p>記事タイトル</br><input type="text" name="title" value="<?php echo h($app->getValues()->article->title); ?>"></p>
      <p>記事紹介</br><input type="text" name="description" value="<?php echo h($app->getValues()->article->description); ?>"></p>
      <p>住所</br><input type="text" name="address" value="<?php echo h($app->getValues()->article->address); ?>"></p>
      <p>緯度</br><input type="text" name="lat" value="<?php echo h($app->getValues()->article->lat); ?>"></p>
      <p>経度</br><input type="text" name="lng" value="<?php echo h($app->getValues()->article->lng); ?>"></p>
        <div id="target"></div>
        <input type="hidden" id="lat" value="<?php echo h($app->getValues()->article->lat) ?>">
        <input type="hidden" id="lng" value="<?php echo h($app->getValues()->article->lng) ?>">
        <input type="hidden" id="title" value="<?php echo h($app->getValues()->article->title) ?>">
        <input type="hidden" id="description" value="<?php echo h($app->getValues()->article->description) ?>">
      <div class="gallery">
        <div class="thumbWap">
          <div class="thumbBlock">
            <p>メイン画像</br><input type="text" name="savePath" value="<?php echo h($app->getValues()->article->savePath); ?>"></p>
            <img class="thumb" src="postimage/<?php echo h(basename($app->getValues()->article->savePath)); ?>" alt="メイン画像" data-image="postimage/<?php echo h(basename($app->getValues()->article->savePath)); ?>">
          </div>
          <?php if($app->getValues()->article->savePathSub1 !== '') : ?>
            <div class="thumbBlock">
              <p>サブ画像１</br><input type="text" name="savePathSub1" value="<?php echo h($app->getValues()->article->savePathSub1); ?>"></p>
              <img class="thumb" src="postimage/<?php echo h(basename($app->getValues()->article->savePathSub1)); ?>" alt="メイン画像" data-image="postimage/<?php echo h(basename($app->getValues()->article->savePathSub1)); ?>">
            </div>
          <?php endif; ?>
          <?php if($app->getValues()->article->savePathSub2 !== '') : ?>
            <div class="thumbBlock">
              <p>サブ画像２</br><input type="text" name="savePathSub2" value="<?php echo h($app->getValues()->article->savePathSub2); ?>"></p>
              <img class="thumb" src="postimage/<?php echo h(basename($app->getValues()->article->savePathSub2)); ?>" alt="メイン画像" data-image="postimage/<?php echo h(basename($app->getValues()->article->savePathSub2)); ?>">
            </div>
          <?php endif; ?>
        </div>
      </div>
      <input type="hidden" name="id" value="<?php echo h($_GET['id']); ?>">
      <input type="hidden" name="token" value="<?php echo h($_SESSION['token']); ?>">
      <input class="btn" type="submit" value="編集">
    </form>

    <a href="adminArticle.php">Go Back</a>

  <?php endif; ?>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDWa5xach73WUBlxYTkhaUHasJZ1XeIkSU&callback=initMap" async defer></script>
  <script src="/js/googleMapsView.js"></script>
</body>
</html>
