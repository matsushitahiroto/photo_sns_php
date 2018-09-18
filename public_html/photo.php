<?php

require_once(__DIR__ . '/../config/config.php');

$app = new MyApp\Controller\Photo();

$app->run();
$app->getValues()->article;
$app->getValues()->comments;
$app->getValues()->likes;
$app->getValues()->check;

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
              <p><span class="fs18"><?php echo h($app->getValues()->article[0]->name); ?></span> さんの投稿。</p>
            </div>
            <div class="fs14 postdate">
              <p><?php echo h($app->getValues()->article[0]->created); ?></p>
            </div>
          </div>
          <?php if($app->me()) : ?>
            <div class="countWrap">
              <p>
                <i class="far fa-thumbs-up thumbs-up <?php if ($app->getValues()->check[0]->bool === '1') { echo 'orangeIcon';} ?>"></i>
                <span class="thumbs-up-count">
                  <?php echo h($app->getValues()->article[0]->lc); ?>
                </span>
                </br>
                <a href="#newCommentForm">
                  <i class="far fa-comment-alt"></i>
                  <span class="commentCount">
                    <?php echo h($app->getValues()->article[0]->cc); ?>
                  </span>
                </a>
              </p>
            </div>
          <?php else : ?>
            <div class="countWrap">
              <p>
                <i class="far fa-thumbs-up"></i>
                <span class="thumbs-up-count">
                  <?php echo h($app->getValues()->article[0]->lc); ?>
                </span>
                </br>
                <i class="far fa-comment-alt"></i>
                <span class="commentCount">
                  <?php echo h($app->getValues()->article[0]->cc); ?>
                </span>
              </p>
            </div>
          <?php endif ; ?>
        </div>
        <div class="postGallery">
          <div class="caption">
            <p class="fs18"><?php echo h($app->getValues()->article[0]->title); ?></p>
          </div>
          <div class="shadowBorder"></div>
          <div class="mapLink">
            <div class="mapLinkIcon">
              <p><i class="fas fa-map-marker-alt fa-3x"></i></br>map</p>
            </div>
            <p>群馬県板倉町　付近</p>
          </div>
          <div class="gallery">
            <img id="bigImage" src="postimage/<?php echo h(basename($app->getValues()->article[0]->savePath)); ?>" alt="">
            <div class="thumbWap">
              <div class="thumbBlock">
                <img class="thumb" src="postimage/<?php echo h(basename($app->getValues()->article[0]->savePath)); ?>" alt="メイン画像" data-image="postimage/<?php echo h(basename($app->getValues()->article[0]->savePath)); ?>">
              </div>
              <?php if($app->getValues()->article[0]->savePathSub1 !== '') : ?>
                <div class="thumbBlock">
                  <img class="thumb" src="postimage/<?php echo h(basename($app->getValues()->article[0]->savePathSub1)); ?>" alt="メイン画像" data-image="postimage/<?php echo h(basename($app->getValues()->article[0]->savePathSub1)); ?>">
                </div>
              <?php endif; ?>
              <?php if($app->getValues()->article[0]->savePathSub2 !== '') : ?>
                <div class="thumbBlock">
                  <img class="thumb" src="postimage/<?php echo h(basename($app->getValues()->article[0]->savePathSub2)); ?>" alt="メイン画像" data-image="postimage/<?php echo h(basename($app->getValues()->article[0]->savePathSub2)); ?>">
                </div>
              <?php endif; ?>
            </div>
          </div>
          <div class="postGalleryComment clear">
            <div class="caption">
              <p><?php echo h($app->getValues()->article[0]->description); ?></p>
            </div>
            <?php if($app->me()) : ?>
              <p>
                <i class="far fa-thumbs-up thumbs-up <?php if ($app->getValues()->check[0]->bool === '1') { echo 'orangeIcon';} ?>"></i>
                <span class="thumbs-up-count">
                  <?php echo h($app->getValues()->article[0]->lc); ?>
                </span>
                <a href="#newCommentForm">
                  <i class="far fa-comment-alt"></i>
                  <span class="commentCount">
                    <?php echo h($app->getValues()->article[0]->cc); ?>
                  </span>
                </a>
              </p>
            <?php else : ?>
              <p>
                <i class="far fa-thumbs-up"></i>
                <span class="thumbs-up-count">
                  <?php echo h($app->getValues()->article[0]->lc); ?>
                </span>
                <i class="far fa-comment-alt"></i>
                <span class="commentCount">
                  <?php echo h($app->getValues()->article[0]->cc); ?>
                </span>
              </p>
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
              <ul id="likes">
                <?php foreach ($app->getValues()->likes as $like) : ?>
                  <li id="like_<?php echo h($like->id) ; ?>" data-id="<?php echo h($like->id) ; ?>">
                    <div class="user">
                      <div class="userIcon flexCenter">
                        <div class="userIconInner"></div>
                      </div>
                      <div class="userData">
                        <div class="postUser">
                          <p><span class="fs18"><?php echo h($like->name) ; ?></span> さん</p>
                        </div>
                        <div class="fs14 postdate">
                          <p><?php echo h($like->created) ; ?></p>
                        </div>
                      </div>
                      <?php if($like->user_id === $app->me()->id) : ?>
                        <div class="countWrap deleteLike">
                          <p><i class="fas fa-times"></i></p>
                        </div>
                      <?php endif; ?>
                    </div>
                  </li>
                <?php endforeach; ?>
                <li id="likeTemplate" data-id="">
                  <div class="user">
                    <div class="userIcon flexCenter">
                      <div class="userIconInner"></div>
                    </div>
                    <div class="userData">
                      <div class="postUser">
                        <p><span class="fs18"><?php echo h($app->me()->name) ; ?></span> さん</p>
                      </div>
                      <div class="fs14 postdate">
                      </div>
                    </div>
                    <div class="countWrap deleteLike">
                      <p><i class="fas fa-times"></i></p>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
            <div class="orangeAria" id="orangeAria">
              <ul id="comments">
                <?php foreach ($app->getValues()->comments as $comment) : ?>
                  <li id="comment_<?php echo h($comment->id) ; ?>" data-id="<?php echo h($comment->id) ; ?>">
                    <div class="user">
                      <div class="userIcon flexCenter">
                        <div class="userIconInner"></div>
                      </div>
                      <div class="userData">
                        <div class="postUser">
                          <p><span class="fs18"><?php echo h($comment->name) ; ?></span> さん</p>
                        </div>
                        <div class="fs14 postdate">
                          <p><?php echo h($comment->created) ; ?></p>
                        </div>
                      </div>
                      <?php if($comment->user_id === $app->me()->id) : ?>
                        <div class="countWrap deleteComment">
                          <p><i class="fas fa-times"></i></p>
                        </div>
                      <?php endif; ?>
                    </div>
                    <div class="caption">
                      <p><?php echo h($comment->comment) ; ?></p>
                    </div>
                  </li>
                <?php endforeach; ?>
                <li id="commentTemplate" data-id="">
                  <div class="user">
                    <div class="userIcon flexCenter">
                      <div class="userIconInner"></div>
                    </div>
                    <div class="userData">
                      <div class="postUser">
                        <p><span class="fs18"><?php echo h($app->me()->name) ; ?></span> さん</p>
                      </div>
                      <div class="fs14 postdate">
                      </div>
                    </div>
                    <div class="countWrap deleteComment">
                      <p><i class="fas fa-times"></i></p>
                    </div>
                  </div>
                  <div class="caption">
                  </div>
                </li>
              </ul>
              <form class="form" id="newCommentForm" action="" method="post">
                <textarea class="fs30" id="newComment" name="description" wrap="soft" placeholder="コメントを追加する"></textarea>
                <div class="btn submitBtn" >
                  送信
                </div>
              </form>
            </div>
          </div>
        <?php else : ?>
          <div class="btn">
            <a href="login.php">
              戻る
            </a>
          </div>
        <?php endif ; ?>
        </div>
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
  </body>
</html>
