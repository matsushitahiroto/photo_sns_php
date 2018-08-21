<?php

namespace MyApp\Controller;

class Photo extends \MyApp\Controller {

  public function run() {

    if($_SERVER['REQUEST_METHOD'] === 'GET') {
      $article = $this->getProcess();
    }
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
      $this->postProcess();
    }

    return $article;
  }

  protected function getProcess() {
    // ユーザー情報取得
    $userModel = new \MyApp\Model\User();
    $postUser = $userModel->getPostUser([
      'uid' => $_GET['uid']
    ]);
    // 投稿内容取得
    $articleModel = new \MyApp\Model\Article();
    $article = $articleModel->getArticle([
      'id' => $_GET['id']
    ]);
    // コメント取得
    // イイネ取得

    $article = [
      $postUser,
      $article
    ];
    return $article;
  }

}
