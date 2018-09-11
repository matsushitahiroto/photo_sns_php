<?php

namespace MyApp\Controller;

class Photo extends \MyApp\Controller {

  public function run() {
    // 投稿内容取得
    $articleModel = new \MyApp\Model\Article();
    $this->setValues('article', $articleModel->getArticle([
      'id' => $_GET['id']
    ]));
    // コメント取得
    $commentModel = new \MyApp\Model\Comment();
    $this->setValues('comments', $commentModel->getComment([
      'article_id' => $_GET['id']
    ]));
    // イイネ取得
    $likeModel = new \MyApp\Model\Like();
    $this->setValues('likes', $likeModel->getLike([
      'article_id' => $_GET['id']
    ]));
    // イイネ取得
    $likeModel = new \MyApp\Model\Like();
    $this->setValues('check', $likeModel->check([
      'article_id' => $_GET['id'],
      'user_id' => $_SESSION['me']->id
    ]));
  }

  public function post() {
    if (!isset($_POST['mode'])) {
      throw new \Exceotion('mode not set!');
    }
    switch ($_POST['mode']) {
      case 'upload':
        return $this->_upload();
      case 'delete':
        return $this->_delete();
      case 'like':
        return $this->_like();
      case 'deleteLike':
        return $this->_deleteLike();
    }
  }

  private function _upload() {
    if (!isset($_POST['comment']) || $_POST['comment'] === '') {
      throw new \Exceotion('id not set!');
    }
    try {
      $commentModel = new \MyApp\Model\Comment();
      $comment = $commentModel->upload([
        'comment' => $_POST['comment'],
        'user_id' => $_POST['user_id'],
        'article_id' => $_POST['article_id']
      ]);
    } catch (\Exception $e) {
      $e->getMessage();
      exit;
    }
    try {
      $commentModel = new \MyApp\Model\Comment();
      $count = $commentModel->count([
        'article_id' => $_POST['article_id']
      ]);
    } catch (\Exception $e) {
      $e->getMessage();
      exit;
    }
    return[
      'count' => $count,
      'id' => $comment,
      'comment' => $_POST['comment'],
      'postTime' => date('Y-m-d H:i:s')
    ];
  }

  private function _delete() {
    if (!isset($_POST['id'])) {
      throw new \Exceotion('id not set!');
    }
    try {
      $commentModel = new \MyApp\Model\Comment();
      $commentModel->delete([
        'id' => $_POST['id']
      ]);
    } catch (\Exception $e) {
      $e->getMessage();
      exit;
    }
    try {
      $commentModel = new \MyApp\Model\Comment();
      $count = $commentModel->count([
        'article_id' => $_POST['article_id']
      ]);
    } catch (\Exception $e) {
      $e->getMessage();
      exit;
    }
    return[
      'count' => $count
    ];
  }

  private function _like() {
    try {
      $likeModel = new \MyApp\Model\Like();
      $like = $likeModel->upload([
        'user_id' => $_POST['user_id'],
        'article_id' => $_POST['article_id']
      ]);
    } catch (\Exception $e) {
      $e->getMessage();
      exit;
    }
    try {
      $likeModel = new \MyApp\Model\Like();
      $count = $likeModel->count([
        'article_id' => $_POST['article_id']
      ]);
    } catch (\Exception $e) {
      $e->getMessage();
      exit;
    }
    return[
      'count' => $count,
      'id' => $like,
      'postTime' => date('Y-m-d H:i:s')
    ];
  }

  private function _deleteLike() {
    if (!isset($_POST['id'])) {
      throw new \Exceotion('id not set!');
    }
    try {
      $likeModel = new \MyApp\Model\Like();
      $likeModel->delete([
        'id' => $_POST['id']
      ]);
    } catch (\Exception $e) {
      $e->getMessage();
      exit;
    }
    try {
      $likeModel = new \MyApp\Model\Like();
      $count = $likeModel->count([
        'article_id' => $_POST['article_id']
      ]);
    } catch (\Exception $e) {
      $e->getMessage();
      exit;
    }
    return[
      'count' => $count
    ];
  }
}
