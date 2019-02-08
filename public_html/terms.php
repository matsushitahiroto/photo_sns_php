<?php

require_once(__DIR__ . '/../config/config.php');

$app = new MyApp\Controller\Terms();

$app->run();

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
              <?php if($app->me()) : ?>
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
              <?php else : ?>
                <ul>
                  <li><a href="login.php#login">ログイン</a></li>
                  <li><a href="help.php">ヘルプ</a></li>
                  <li><a href="privacy.php">プライバシー</a></li>
                  <li><a href="terms.php">利用規約</a></li>
                </ul>
              <?php endif ; ?>
            </div>
          </div>
        </div>
      </header>
      <div class="container">
        <p>
          まだ何もありません。
        </p>
        <a href="index.php">
          <div class="btn">
              戻る
          </div>
        </a>
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
    <?php if (isset($_SESSION['me'])): ?>
      <input type="hidden" id="user_id" value="<?php echo h($app->me()->id) ; ?>">
    <?php endif; ?>
    <input type="hidden" id="token" value="<?php echo h($_SESSION['token']); ?>">
  </body>
</html>
