<?php

namespace MyApp\Controller;

class Map extends \MyApp\Controller {

  public function run() {
    // 投稿内容取得
    $articleModel = new \MyApp\Model\Article();
    $this->setValues('article', $articleModel->getArticle([
      'id' => $_GET['id']
    ]));
  }
}
