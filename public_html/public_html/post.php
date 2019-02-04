<?php
require_once(__DIR__ . '/../config/config.php');

$app = new MyApp\Controller\Post();

$app->run();

// var_dump($app->me()->name);
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
    <script src="js/JQUERY ChangeImage.js"></script>
  </head>
  <body>
    <div class="wrapper">
      <div id="msk" class="hidden"></div>
      <header>
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
            <div class="headerMenu hidden" id="menu">
              <div class="user">
                <div class="userIcon flexCenter">
                  <?php if(!isset($app->me()->iconPath)): ?>
                    <div class="userIconInner">
                    </div>
                  <?php else: ?>
                  <img src="<?php echo h($app->me()->iconPath); ?>" alt=""  class="userIconInner">
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
                <li><a href="help.php">ヘルプ</a></li>
                <li><a href="privacy.php">プライバシー</a></li>
                <li><a href="terms.php">利用規約</a></li>
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
        <form class="form" action="" method="post" id="post" enctype="multipart/form-data">
          <div class="red">
            <?php echo h($app->getErrors('title')); ?>
            <?php echo h($app->getErrors('size')); ?>
            <?php echo h($app->getErrors('type')); ?>
            <?php echo h($app->getErrors('image')); ?>
            <?php echo h($app->getErrors('address')); ?>
            <?php echo h($app->getErrors('lat')); ?>
            <?php echo h($app->getErrors('lng')); ?>
            <?php echo h($app->getErrors('article')); ?>
            <?php echo h($app->getErrors('login')); ?>
          </div>
          <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo h(MAX_FILE_SIZE); ?>">
          <p>
            <input type="text" name="title" value="" placeholder="タイトル">
          </p>
          <p>
            メインの写真</br>
            <input type="file" name="images[]" value="main">
          </p>
          <p>
            サブの写真１枚目</br>
            <input type="file" name="images[]" value="sub1">
          </p>
          <p>
            サブの写真２枚目</br>
            <input type="file" name="images[]" value="sub2">
          </p>
          <p><input type="text" id="keyword" placeholder="検索"></p>
          <div class="btn submitBtn" id="search">
            serch
          </div>
          <div id="target"></div>
          <p>住所：<span id="add"></span></p>
          <p>緯度：<span id="la"></span></p>
          <p>経度：<span id="ln"></span></p>
          <p>
            <textarea class="fs24" name="description" rows="6" value="" placeholder="コメント"></textarea>
          </p>
          <input type="hidden" name="token" value="<?php echo h($_SESSION['token']); ?>">
          <input type="hidden" name="address" id="address" value="">
          <input type="hidden" name="lat" id="lat" value="">
          <input type="hidden" name="lng" id="lng" value="">
          <input type="hidden" name="id" value="<?php echo h($app->me()->id); ?>">


          <div class="btn submitBtn" onclick="document.getElementById('post').submit();">
            投稿
          </div>
        </form>
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
    <div class="bottomMenu">
      <div class="menuIcon flexCenter">
        <a href="index.php">
          <i class="fas fa-home fa-2x"></i>
        </a>
      </div>
      <div class="menuIcon flexCenter">
        <a href="post.php">
          <i class="fas fa-plus fa-2x greenIcon"></i>
        </a>
      </div>
      <div class="menuIcon flexCenter">
        <a href="profile.php">
          <i class="fas fa-user fa-2x"></i>
        </a>
      </div>
    </div>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDWa5xach73WUBlxYTkhaUHasJZ1XeIkSU&callback=initMap" async defer></script>
    <script src="/js/googleMapsPost.js"></script>
  </body>
</html>
