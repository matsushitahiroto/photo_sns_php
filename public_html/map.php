<?php

require_once(__DIR__ . '/../config/config.php');

$app = new MyApp\Controller\Map();

$app->run();
$app->getValues()->article;

// var_dump($app->getValues()->article);
// var_dump($app->getValues()->article[0]->lc);
// var_dump($app->getValues()->comments);
// var_dump($app->getValues()->likes);
// var_dump($_SESSION['me']->id);
// var_dump($app->getValues()->check[0]->bool);
// exit;

 ?>
 <!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>test</title>
    <link rel="stylesheet" href="css/import.css">
    <link rel="stylesheet" href="font/font-awesome.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/JQUERY Toggle.js"></script>
    <script src="js/JQUERY ChangeColor.js"></script>
    <script src="js/JQUERY ChangeImage.js"></script>
    <script src="js/comment.js"></script>
    <script src="js/like.js"></script>
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
              <?php if($app->me()) : ?>
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
              <?php else : ?>
                <ul>
                  <li><a href="login.php#login">ログイン</a></li>
                  <li><a href="">プライバシー</a></li>
                  <li><a href="">ヘルプ</a></li>
                  <li><a href="">利用規約</a></li>
                </ul>
              <?php endif ; ?>
            </div>
          </div>
        </div>
      </header>
      <div class="container">
        <div id="target"></div>
        <input type="hidden" name="lat" id="lat" value="<?php echo h($app->getValues()->article[0]->lat) ?>">
        <input type="hidden" name="lng" id="lng" value="<?php echo h($app->getValues()->article[0]->lng) ?>">
        <input type="hidden" name="title" id="title" value="<?php echo h($app->getValues()->article[0]->title) ?>">
        <input type="hidden" name="description" id="description" value="<?php echo h($app->getValues()->article[0]->description) ?>">
      </div>
      <a href="photo.php?id=<?php echo h($app->getValues()->article[0]->id) ?>">
        <div class="btn">
            戻る
        </div>
      </a>
    </div>
    <footer>
      <div class="footerTitle">
        <h1>ふらつき場</h1>
      </div>
      <address>
        &copy;Copyright 2018 Neko.
      </address>
    </footer>
    <?php if($app->me()) : ?>
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
    <?php endif ; ?>
    <input type="hidden" id="user_id" value="<?php echo h($app->me()->id) ; ?>">
    <input type="hidden" id="article_id" value="<?php echo h($app->getValues()->article[0]->id) ; ?>">
    <input type="hidden" id="token" value="<?php echo h($_SESSION['token']); ?>">
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDWa5xach73WUBlxYTkhaUHasJZ1XeIkSU&callback=initMap" async defer></script>
    <script src="/js/googleMapsView.js"></script>
  </body>
</html>
