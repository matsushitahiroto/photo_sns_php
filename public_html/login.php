<?php

require_once(__DIR__ . '/../config/config.php');

$app = new MyApp\Controller\Login();

$app->run();
$app->getValues()->articles;
$app->getValues()->likeArticles;

// var_dump($app->getValues()->articles);
// exit;

 ?>
 <!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>さんぽみち</title>
    <link rel="stylesheet" href="css/import.css">
    <link rel="stylesheet" href="font/font-awesome.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/JQUERY Toggle.js"></script>
    <script src="js/JQUERY ChangeColor.js"></script>
  </head>
  <body>
    <div class="wrapper">
      <div id="msk" class="hidden"></div>
      <header id="header">
        <div class="headerInner">
          <div class="headerTitle">
            <div class="headerTitleInner">
            </div>
          </div>
          <div class="headerNav">
            <ul>
              <li id="menuBtn">
                <i class="fas fa-bars fa-2x"></i><br>メニュー
              </li>
            </ul>
          </div>
        </div>
        <div class="headerMenu hidden" id="menu">
          <ul>
            <li><a href="login.php#login">ログイン</a></li>
            <li><a href="help.php">ヘルプ</a></li>
            <li><a href="privacy.php">プライバシー</a></li>
            <li><a href="terms.php">利用規約</a></li>
          </ul>
        </div>
      </header>
      <div class="container">
        <div class="hero">
          <div class="heroIntro flexCenter">
            <p class="fs32">散歩しよう！<br>写真撮ろう！<br>そんな場所</p>
          </div>
          <div class="keyVisual">
            <div class="keyVisualLink">
              <a href="signup.php">
                <p>
                    今すぐはじめる！<br><i class="fas fa-sign-in-alt"></i>
                </p>
              </a>
            </div>
          </div>
        </div>
        <div class="selecter">
          <div class="selecterInner">
            <div class="left flexCenter btnBox">
              <div class="selecterBtn flexCenter green height50px" id="green">
                新着
              </div>
            </div>
            <div class="right flexCenter btnBox">
              <div class="selecterBtn flexCenter orange" id="orange">
                人気
              </div>
            </div>
          </div>
          <div class="border green" id="border"></div>
          <div class="gallery" id="greenAria">
            <div class="thumbWap">
              <?php foreach ($app->getValues()->articles as $article) : ?>
                <div class="thumbBlock">
                  <div class="inner">
                    <a href="photo.php?id=<?php echo h($article->id); ?>">
                      <?php if (file_exists(THUMBNAIL_DIR . '/' . basename($article->savePath))): ?>
                        <img src="thumbs/<?php echo h(basename($article->savePath)); ?>" alt="">
                      <?php else: ?>
                        <img src="postimage/<?php echo h(basename($article->savePath)); ?>" alt="">
                      <?php endif;  ?>
                    </a>
                  </div>
                  <p><i class="far fa-thumbs-up"></i><?php echo h($article->lc); ?>  <i class="far fa-comment-alt"></i><?php echo h($article->cc); ?></p>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
          <div class="gallery hidden" id="orangeAria">
            <div class="thumbWap">
              <?php foreach ($app->getValues()->likeArticles as $likeArticle) : ?>
                <div class="thumbBlock">
                  <div class="inner">
                    <a href="photo.php?id=<?php echo h($likeArticle->id); ?>">
                      <?php if (file_exists(THUMBNAIL_DIR . '/' . basename($likeArticle->savePath))): ?>
                        <img src="thumbs/<?php echo h(basename($likeArticle->savePath)); ?>" alt="">
                      <?php else: ?>
                        <img src="postimage/<?php echo h(basename($likeArticle->savePath)); ?>" alt="">
                      <?php endif;  ?>
                    </a>
                  </div>
                  <p><i class="far fa-thumbs-up"></i><?php echo h($likeArticle->lc); ?>  <i class="far fa-comment-alt"></i><?php echo h($likeArticle->cc); ?></p>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
        <div id="form" class="form">
          <p class="red">
            <?php echo h($app->getErrors('login')); ?>
            <?php echo h($app->getErrors('load')); ?>
          </p>
          <div class="formWap">
            <div class="loginForm">
              <form action="" method="post" id="login">
                <p class="name">
                  <input type="name" name="name" placeholder="ユーザー名" <?php echo isset($app->getValues()->name) ? h($app->getValues()->name) : ''; ?>>
                </p>
                <p class="email">
                  <input type="email" name="email" placeholder="メールアドレス" <?php echo isset($app->getValues()->email) ? h($app->getValues()->email) : ''; ?>>
                </p>
                <p class="password">
                  <input type="password" name="password" placeholder="パスワード">
                </p>
                <input type="hidden" name="token" value="<?php echo h($_SESSION['token']); ?>">
              </form>
            </div>
            <div class="loginFormBtn">
              <div class="btn submitBtn" onclick="document.getElementById('login').submit();">
                ログイン
              </div>
              <p>アカウントをお持ちでない方はこちら</p>
              <a href="signup.php">
                <div class="btn">
                    新規登録
                </div>
              </a>
              <p>管理者はこちら</p>
              <a href="adminLogin.php">
                <div class="btn">
                    管理者入口
                </div>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <footer>
      <div class="footerMenu">
        <div class="footerMenuInner flexCenter">
          <a href="help.php">
            ヘルプ
          </a>
        </div>
        <div class="footerMenuInner flexCenter">
          <a href="privacy.php">
            プライバシー
          </a>
        </div>
        <div class="footerMenuInner flexCenter">
          <a href="terms.php">
            利用規約
          </a>
        </div>
      </div>
      <div class="footerTitle">
        <div class="footerTitleInner">
        </div>
      </div>
      <address>
        &copy;Copyright 2018 Neko.
      </address>
    </footer>
  </body>
</html>
