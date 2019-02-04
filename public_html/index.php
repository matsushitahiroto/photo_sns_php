<?php

require_once(__DIR__ . '/../config/config.php');

$app = new MyApp\Controller\Index();

$app->run();
$app->getValues()->articles;
$app->getValues()->likeArticles;
// var_dump($app->me());
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
                  <img src="<?php echo h($app->me()->iconPath); ?>" alt="" class="userIconInner">
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
        <p class="err">
          <?php echo h($app->getErrors('id')); ?>
        </p>
        <div class="hero">
          <div class="heroIntro flexCenter">
            <p class="fs32">散歩しよう！<br>写真撮ろう！<br>そんな場所</p>
          </div>
          <div class="keyVisual"></div>
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
      </div>
    </div>
    <footer>
      <div class="guest">
        <h2>ようこそ！</h2>
        <div class="guestUser">
          <div class="guestInner">
            <div class="guestIcon">
              <?php if(!isset($app->me()->iconPath)): ?>
                <div class="guestIconInner">
                </div>
              <?php else: ?>
                <img src="<?php echo h($app->me()->iconPath); ?>" alt="" class="guestIconInner">
              <?php endif; ?>
            </div>
            <div class="guestData fs14">
              <div class="height50">
                <p><span class="fs24"><?php echo h($app->me()->name); ?></span> さん</p>
              </div>
              <div class="height50">
                <p><span class="fs24"><?php echo h($app->me()->ac); ?></span></br>投稿</p>
              </div>
            </div>
            <div class="guestBtnWrap">
              <div class="btnBox">
                <a href="profile.php">
                  <div class="btn">
                      アカウント
                  </div>
                </a>
              </div>
              <div class="btnBox">
                <a href="post.php">
                  <div class="btn">
                      新規投稿
                  </div>
                </a>
              </div>
            </div>
            <div class="guestBtnWrap">
              <div class="btnBox">
                <a href="custom.php">
                  <div class="btn">
                      編集
                  </div>
                </a>
              </div>
              <div class="btnBox">
                <div class="btn submitBtn">
                  <form action="logout.php" method="post" id="logout">
                    <input type="hidden" name="token" value="<?php echo h($_SESSION['token']); ?>">
                    <div onclick="document.getElementById('logout').submit();">
                      ログアウト
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

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
          <i class="fas fa-home fa-2x greenIcon"></i>
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
</html>
