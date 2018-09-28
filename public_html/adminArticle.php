<?php
require_once(__DIR__ . '/../config/config.php');

$app = new MyApp\Controller\AdminArticle();

$app->run();
$app->getValues()->articles;

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

     <p>全<?php echo h(count($app->getValues()->articles)); ?>件</p>
     <a href="adminIndex.php">go back</a>

     <table>
       <tr>
         <th></th>
         <th></th>
         <th>id</th>
         <th>user_id</th>
         <th>title</th>
         <th>description</th>
         <th>savePath</th>
         <th>savePathSab1</th>
         <th>savePathSab2</th>
         <th>created</th>
         <th>modifid</th>
       </tr>
       <?php foreach ($app->getValues()->articles as $article) : ?>
         <tr id="<?php echo h($article->id); ?>">
           <td>
             <a href="adminCustom.php?id=<?php echo h($article->id); ?>&type=article">編集</a>
           </td>
           <td>
             <a href="adminDelete.php?id=<?php echo h($article->id); ?>&type=article">削除</a>
           </td>
           <td><?php echo h($article->id); ?></td>
           <td><?php echo h($article->user_id); ?></td>
           <td><?php echo h($article->title); ?></td>
           <td><?php echo h($article->description); ?></td>
           <td><?php echo h($article->savePath); ?></td>
           <td><?php echo h($article->savePathSub1); ?></td>
           <td><?php echo h($article->savePathSub2); ?></td>
           <td><?php echo h($article->created); ?></td>
           <td><?php echo h($article->modified); ?></td>
         </tr>
       <?php endforeach; ?>
     </table>
     <a href="adminIndex.php">go back</a>

   </body>
 </html>
