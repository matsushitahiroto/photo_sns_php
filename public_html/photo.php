<?php

require_once(__DIR__ . '/../config/config.php');

$app = new MyApp\Controller\Photo();

$article = $app->run();

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
              <?php if($app->me()) : ?>
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
        <div class="user">
          <div class="userIcon flexCenter">
            <div class="userIconInner"></div>
          </div>
          <div class="userData">
            <div class="postUser">
              <p><span class="fs18"><?php echo h($article[0][0]->name); ?></span> さんの投稿。</p>
            </div>
            <div class="fs14 postdate">
              <p><?php echo h($article[1][0]->created); ?></p>
            </div>
          </div>
          <div class="countWrap">
            <p><i class="far fa-thumbs-up"></i> 3</br><i class="far fa-comment-alt"></i> 3</p>
          </div>
        </div>
        <div class="postGallery">
          <div class="caption">
            <p class="fs18"><?php echo h($article[1][0]->title); ?></p>
          </div>
          <div class="shadowBorder"></div>
          <div class="mapLink">
            <div class="mapLinkIcon">
              <p><i class="fas fa-map-marker-alt fa-3x"></i></br>map</p>
            </div>
            <p>群馬県板倉町　付近</p>
          </div>
          <div class="gallery">
            <img id="bigImage" src="postimage/<?php echo h(basename($article[1][0]->savePath)); ?>" alt="">
            <div class="thumbWap">
              <div class="thumbBlock">
                <img class="thumb" src="postimage/<?php echo h(basename($article[1][0]->savePath)); ?>" alt="メイン画像" data-image="postimage/<?php echo h(basename($article[1][0]->savePath)); ?>">
              </div>
              <div class="thumbBlock">
                <img class="thumb" src="images/p2.jpg" alt="サブ画像１" data-image="images/p2.jpg">
              </div>
              <div class="thumbBlock">
                <img class="thumb" src="images/p3.jpg" alt="サブ画像２" data-image="images/p3.jpg">
              </div>
            </div>
          </div>
          <div class="postGalleryComment clear">
            <div class="caption">
              <p><?php echo h($article[1][0]->description); ?></p>
            </div>
            <?php if($app->me()) : ?>
            <p><i class="far fa-thumbs-up"></i> 3　　<i class="far fa-comment-alt"></i> 3</p>
          <?php endif ; ?>
          </div>
        </div>
        <?php if($app->me()) : ?>
          <div class="selecter">
            <div class="selecterInner">
              <div class="flexCenter btnBox">
                <div class="selecterBtn flexCenter green" id="green">
                  <i class="far fa-thumbs-up"></i>イイネ
                </div>
              </div>
              <div class="flexCenter btnBox">
                <div class="selecterBtn flexCenter orange height45px" id="orange">
                  <i class="far fa-comment-alt"></i>コメント
                </div>
              </div>
            </div>
            <div class="border orange" id="border"></div>
            <div class="greenAria hidden" id="greenAria">
              <ul>
                <li>
                  <div class="user">
                    <div class="userIcon flexCenter">
                      <div class="userIconInner"></div>
                    </div>
                    <div class="userData">
                      <div class="postUser">
                        <p><span class="fs18">php</span> さん</p>
                      </div>
                    </div>
                  </div>
                </li>
                <li>
                  <div class="user">
                    <div class="userIcon flexCenter">
                      <div class="userIconInner"></div>
                    </div>
                    <div class="userData">
                      <div class="postUser">
                        <p><span class="fs18">sql</span> さん</p>
                      </div>
                    </div>
                  </div>
                </li>
                <li>
                  <div class="user">
                    <div class="userIcon flexCenter">
                      <div class="userIconInner"></div>
                    </div>
                    <div class="userData">
                      <div class="postUser">
                        <p><span class="fs18">css</span> さん</p>
                      </div>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
            <div class="orangeAria" id="orangeAria">
              <ul>
                <li>
                  <div class="user">
                    <div class="userIcon flexCenter">
                      <div class="userIconInner"></div>
                    </div>
                    <div class="userData">
                      <div class="postUser">
                        <p><span class="fs18">php</span> さん</p>
                      </div>
                      <div class="fs14 postdate">
                        <p>2018年07月23日 19:10</p>
                      </div>
                    </div>
                  </div>
                  <div class="caption">
                    <p>ここにコメントを表示</p>
                  </div>
                </li>
                <li>
                  <div class="user">
                    <div class="userIcon flexCenter">
                      <div class="userIconInner"></div>
                    </div>
                    <div class="userData">
                      <div class="postUser">
                        <p><span class="fs18">sql</span> さん</p>
                      </div>
                      <div class="fs14 postdate">
                        <p>2018年07月23日 19:35</p>
                      </div>
                    </div>
                  </div>
                  <div class="caption">
                    <p>ここにコメントを表示</p>
                  </div>
                </li>
                <li>
                  <div class="user">
                    <div class="userIcon flexCenter">
                      <div class="userIconInner"></div>
                    </div>
                    <div class="userData">
                      <div class="postUser">
                        <p><span class="fs18">css</span> さん</p>
                      </div>
                      <div class="fs14 postdate">
                        <p>2018年07月23日 19:45</p>
                      </div>
                    </div>
                  </div>
                  <div class="caption">
                    <p>ここにコメントを表示</p>
                  </div>
                </li>
              </ul>
              <div class="">
                <form class="form" action="" method="post">
                  <textarea class="fs30" name="description" wrap="soft" value="" placeholder="コメントを追加する"></textarea>
                  <div class="btn submitBtn">
                    送信
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      <?php endif ; ?>
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
  </body>
</html>
