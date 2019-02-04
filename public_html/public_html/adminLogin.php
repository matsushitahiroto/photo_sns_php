<?php
require_once(__DIR__ . '/../config/config.php');

$app = new MyApp\Controller\AdminLogin();

$app->run();
 ?>
 <!DOCTYPE html>
 <html lang="ja">
   <head>
     <meta charset="utf-8">
     <title>photo_sns_php管理画面</title>
   </head>
   <body>
     <h1>ログイン</h1>
     <p>
       <?php echo h($app->getErrors('login')); ?>
       <?php echo h($app->getErrors('admin')); ?>
     </p>
     <form action="" method="post">
       <input type="text" name="id" placeholder="id">
       <input type="text" name="password" placeholder="password">
       <input type="hidden" name="token" value="<?php echo h($_SESSION['token']); ?>">
       <input type="submit" value="ログイン">
     </form>
     <a href="login.php">Go Back</a>
   </body>
 </html>
