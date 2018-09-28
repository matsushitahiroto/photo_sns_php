<?php
require_once(__DIR__ . '/../config/config.php');

$app = new MyApp\Controller\AdminIndex();

$app->run();

 ?>
 <!DOCTYPE html>
 <html lang="ja">
   <head>
     <meta charset="utf-8">
     <title>photo_sns_php管理画面</title>
   </head>
   <body>
     <h1>管理画面</h1>
     <ul>
       <li>
         <a href="adminUser.php">ユーザー管理</a>
       </li>
       <li>
         <a href="adminArticle.php">記事管理</a>
       </li>
       <li>
         <a href="adminComment.php">コメント管理</a>
       </li>
     </ul>

     <form id="logout" action="logout.php" method="post">
       <input type="hidden" name="token" value="<?php echo h($_SESSION['token']) ?>">
       <input type="submit" value="logout">
     </form>

   </body>
 </html>
