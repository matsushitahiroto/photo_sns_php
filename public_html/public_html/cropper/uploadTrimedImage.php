<?php
    $res = array();
    try{
        // $_FILESで受け取れます。
        $file = $_FILES['blob'];
        // 画像アップロード
        $ext = 'jpg';
        $imageFileName = sprintf(
          '%s_%s.%s',
          time(),
          sha1(uniqid(mt_rand(), true)),
          $ext
        );
        $savePath = './tmpImage/' . $imageFileName;

        move_uploaded_file($_FILES['blob']['tmp_name'], '.' . $savePath);

        $res = [
            'status' => 'success',
            'msg' => 'sample01',
            'obj' => $savePath,
        ];
    }catch(Exception $ex){
        $res = [
            'status' => 'error',
            'msg' => $ex->getMessge(),
            'obj' => null,
        ];
    }
    echo json_encode($res);
    exit();
