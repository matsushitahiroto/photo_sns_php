<?php

require_once(__DIR__ . '/../config/config.php');

$app = new MyApp\Controller\Profile();

$app->run();

$myArticles = $_SESSION['img'];

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
                  <div class="userIconInner"></div>
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
        <div class="user">
          <div class="userIcon flexCenter">
            <div class="userIconInner"></div>
          </div>
          <div class="userData">
            <div class="postUser">
              <p><span class="fs20"><?php echo h($app->me()->name); ?></span> さん</p>
            </div>
          </div>
          <div class="countWrap">
            <p><span class="fs18"><?php echo h(count($_SESSION['img'])); ?></span></br>投稿</p>
          </div>
        </div>
        <div class="caption">
          <p class="fs18"><?php echo h($app->me()->description); ?></p>
        </div>
        <div class="shadowBorder"></div>
        <div class="gallery">
          <h2>投稿した写真</h2>
          <div class="thumbWap">
            <?php foreach ($myArticles as $myArticle) : ?>
              <div class="thumbBlock">
                <a href="photo.php?id=<?php echo h($myArticle->id); ?>&uid=<?php echo h($myArticle->user_id) ?>">
                  <img src="postimage/<?php echo h(basename($myArticle->savePath)); ?>" alt="">
                  <p><i class="far fa-thumbs-up"></i>●  <i class="far fa-comment-alt"></i>●</p>
                </a>
              </div>
            <?php endforeach; ?>
          </div>
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
          <i class="fas fa-user fa-2x greenIcon"></i>
        </a>
      </div>
    </div>
  </body>
</html>
