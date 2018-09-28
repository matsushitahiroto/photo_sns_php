<?php
require_once(__DIR__ . '/../config/config.php');

$app = new MyApp\Controller\AdminComment();

$app->run();
$app->getValues()->comments;

 ?>
 <!DOCTYPE html>
 <html lang="ja">
   <head>
     <meta charset="utf-8">
     <title>photo_sns_php管理画面</title>
   </head>
   <style media="screen">
     table {
       border: 1px solid #000;
     }
     th {
       border: 1px solid #000;
       max-width: 200px;
       overflow: hidden;
     }
     td {
       border: 1px solid #000;
       max-width: 200px;
       overflow-x: scroll;
     }
   </style>
   <body>
     <h1>管理画面</h1>
     <a href="adminIndex.php">go back</a>
     <table>
       <tr>
         <th></th>
         <th>id</th>
         <th>article_id</th>
         <th>user_id</th>
         <th>comment</th>
         <th>created</th>
         <th>modifid</th>
       </tr>
       <?php foreach ($app->getValues()->comments as $comment) : ?>
         <tr id="<?php echo h($comment->id); ?>">
           <td><a href="adminDelete.php?id=<?php echo h($comment->id); ?>&type=comment">削除</a></td>
           <td><?php echo h($comment->id); ?></td>
           <td><?php echo h($comment->article_id); ?></td>
           <td><?php echo h($comment->user_id); ?></td>
           <td><?php echo h($comment->comment); ?></td>
           <td><?php echo h($comment->created); ?></td>
           <td><?php echo h($comment->modified); ?></td>
         </tr>
       <?php endforeach; ?>
     </table>
     <a href="adminIndex.php">go back</a>

   </body>
 </html>
