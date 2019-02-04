<?php

require_once(__DIR__ . '/../config/config.php');

$app = new MyApp\Controller\Signup();

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
              <ul>
                <li><a href="login.php#login">ログイン</a></li>
                <li><a href="help.php">ヘルプ</a></li>
                <li><a href="privacy.php">プライバシー</a></li>
                <li><a href="terms.php">利用規約</a></li>
              </ul>
            </div>
          </div>
        </div>
      </header>
      <div class="container">
        <div class="hero">
          <div class="heroIntro flexCenter">
            <p class="fs32">気の向くままに<br>投稿しよう！</p>
          </div>
        </div>
        <div class="link">
          <h2>始めよう！</h2>
          <div class="selecterInner">
            <div class="flexCenter btnBox">
              <a href="login.php#form">
                <div class="btn flexCenter">
                    ログイン
                </div>
              </a>
            </div>
            <div class="flexCenter btnBox">
              <a href="signup.php#form">
                <div class="btn flexCenter">
                    新規登録
                </div>
              </a>
            </div>
          </div>
        </div>
        <div class="featur">
          <div class="col">
            <div class="postCol visualInner">
              <h2>投稿しよう！</h2>
            </div>
            <p>まずは投稿。まずは投稿。まずは投稿。まずは投稿。まずは投稿。まずは投稿。まずは投稿。まずは投稿。まずは投稿。まずは投稿。まずは投稿。まずは投稿。まずは投稿。</p>
          </div>
          <div class="col">
            <div class="connectCol visualInner">
              <h2>繋がろう！</h2>
            </div>
            <p>いいねしよう。いいねしよう。いいねしよう。いいねしよう。いいねしよう。いいねしよう。いいねしよう。いいねしよう。いいねしよう。いいねしよう。いいねしよう。</p>
          </div>
          <div class="col">
            <div class="serchCol visualInner">
              <h2>探そう！</h2>
            </div>
            <p>探そう。探そう。探そう。探そう。探そう。探そう。探そう。探そう。探そう。探そう。探そう。探そう。探そう。探そう。探そう。探そう。探そう。探そう。探そう。</p>
          </div>
        </div>
        <div id="form" class="form">
          <h2>新規登録</h2>
          <p class="red">
            <?php echo h($app->getErrors('empty')); ?>
            <?php echo h($app->getErrors('name')); ?>
            <?php echo h($app->getErrors('password')); ?>
            <?php echo h($app->getErrors('email')); ?>
          </p>
          <p>*印は必ず入力してください。</p>
          <form action="" method="post" id="signup">
            <p class="name">
              ２０文字以内で記号は使えません。<br />
              <span class="red fs20">*</span>
              <input type="name" name="name" placeholder="ユーザー名" maxlength="20" pattern="^[ぁ-んァ-ヶーa-zA-Z0-9０-９]+$" value="<?php echo isset($app->getValues()->name) ? h($app->getValues()->name) : ''; ?>" required>
            </p>
            <p class="description">
              <textarea class="fs24" name="description" rows="6" placeholder="自己紹介"><?php echo isset($app->getValues()->description) ? h($app->getValues()->description) : ''; ?></textarea>
            </p>
            <p class="email">
              <span class="red fs20">*</span>
              <input type="email" name="email" placeholder="メールアドレス" value="<?php echo isset($app->getValues()->email) ? h($app->getValues()->email) : ''; ?>" required>
            </p>
            <p class="password">
              半角英数字を含む８文字以上２０文字以下。<br />
              <span class="red fs20">*</span>
              <input type="password" name="password" placeholder="例）password1234" maxlength="20" pattern="^(?=.*?[a-zA-Z])(?=.*?\d)[a-zA-Z\d]{8,20}$" required>
            </p>
            <input type="hidden" name="token" value="<?php echo h($_SESSION['token']); ?>">
            <div class="btn submitBtn" onclick="document.getElementById('signup').submit();">
              登録
            </div>
            <a href="login.php">
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
