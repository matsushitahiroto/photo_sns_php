<?php
require_once(__DIR__ . '/../config/config.php');

$app = new MyApp\Controller\AdminDelete();

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
    <?php echo h($app->getErrors('delete')) ?>
  </p>

  <?php if ($_GET['type'] === 'user'): ?>

    <form action="" method="post">
      <p>ユーザー名</br><?php echo h($app->getValues()->user->name); ?></p>
      <p>自己紹介</br><?php echo h($app->getValues()->user->description); ?></p>
      <p>メールアドレス</br><?php echo h($app->getValues()->user->email); ?></p>
      <input type="hidden" name="id" value="<?php echo h($_GET['id']); ?>">
      <input type="hidden" name="token" value="<?php echo h($_SESSION['token']); ?>">
      <input class="btn" type="submit" value="削除">
    </form>

    <a href="adminUser.php">Go Back</a>

  <?php endif; ?>

  <?php if ($_GET['type'] === 'article'): ?>

    <form action="" method="post">
      <p>記事タイトル</br><?php echo h($app->getValues()->article->title); ?></p>
      <p>記事紹介</br><?php echo h($app->getValues()->article->description); ?></p>
      <div class="gallery">
        <div class="thumbWap">
          <div class="thumbBlock">
            <img class="thumb" src="postimage/<?php echo h(basename($app->getValues()->article->savePath)); ?>" alt="メイン画像" data-image="postimage/<?php echo h(basename($app->getValues()->article->savePath)); ?>">
          </div>
          <?php if($app->getValues()->article->savePathSub1 !== '') : ?>
            <div class="thumbBlock">
              <img class="thumb" src="postimage/<?php echo h(basename($app->getValues()->article->savePathSub1)); ?>" alt="メイン画像" data-image="postimage/<?php echo h(basename($app->getValues()->article->savePathSub1)); ?>">
            </div>
          <?php endif; ?>
          <?php if($app->getValues()->article->savePathSub2 !== '') : ?>
            <div class="thumbBlock">
              <img class="thumb" src="postimage/<?php echo h(basename($app->getValues()->article->savePathSub2)); ?>" alt="メイン画像" data-image="postimage/<?php echo h(basename($app->getValues()->article->savePathSub2)); ?>">
            </div>
          <?php endif; ?>
        </div>
      </div>
      <input type="hidden" name="id" value="<?php echo h($_GET['id']); ?>">
      <input type="hidden" name="token" value="<?php echo h($_SESSION['token']); ?>">
      <input class="btn" type="submit" value="削除">
    </form>

    <a href="adminArticle.php">Go Back</a>

  <?php endif; ?>

  <?php if ($_GET['type'] === 'comment'): ?>

    <form action="" method="post">
      <p>コメント</br><?php echo h($app->getValues()->comment->comment); ?></p>
      <input type="hidden" name="id" value="<?php echo h($_GET['id']); ?>">
      <input type="hidden" name="token" value="<?php echo h($_SESSION['token']); ?>">
      <input class="btn" type="submit" value="削除">
    </form>

    <a href="adminComment.php">Go Back</a>

  <?php endif; ?>
</body>
</html>
