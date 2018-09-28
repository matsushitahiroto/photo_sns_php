<?php
require_once(__DIR__ . '/../config/config.php');

$app = new MyApp\Controller\AdminUser();

$app->run();
$app->getValues()->users;

// var_dump($app->getValues()->users);
// exit;

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
     <h1>ユーザー管理画面</h1>
     <p>全<?php echo h(count($app->getValues()->users)); ?>件</p>
     <a href="adminIndex.php">go back</a>
     <table>
       <tr>
         <th></th>
         <th></th>
         <th>id</th>
         <th>admin</th>
         <th>name</th>
         <th>description</th>
         <th>email</th>
         <th>password</th>
         <th>created</th>
         <th>modifid</th>
       </tr>
       <?php foreach ($app->getValues()->users as $user) : ?>
         <tr id="<?php echo h($user->id); ?>">
           <td>
             <a href="adminCustom.php?id=<?php echo h($user->id); ?>&type=user">編集</a>
           </td>
           <td>
             <a href="adminDelete.php?id=<?php echo h($user->id); ?>&type=user">削除</a>
           </td>
           <td><?php echo h($user->id); ?></td>
           <td><?php echo h($user->admin); ?></td>
           <td><?php echo h($user->name); ?></td>
           <td><?php echo h($user->description); ?></td>
           <td><?php echo h($user->email); ?></td>
           <td><?php echo h($user->password); ?></td>
           <td><?php echo h($user->created); ?></td>
           <td><?php echo h($user->modified); ?></td>
         </tr>
       <?php endforeach; ?>
     </table>
     <a href="adminIndex.php">go back</a>

   </body>
 </html>
