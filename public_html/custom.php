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
        <div id="form" class="form">
          <h2>プロフィール変更</h2>
          <form action="" method="post" id="custom">
            <div class="guestUser flexCenter">
              <div class="guestIcon flexCenter">
                <div class="guestIconInner"></div>
              </div>
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
            <div class="btn">
              <a href="index.php">
                戻る
              </a>
            </div>
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
</html>
