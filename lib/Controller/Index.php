<?php

namespace MyApp\Controller;

class Index extends \MyApp\Controller {
  public function run() {
    if(!$this->isLoggedIn()) {
      //login
      header('Location:' . SITE_URL . '/login.php');

      exit;
    }

    $articleModel = new \MyApp\Model\Article();

    $this->setValues('articles', $articleModel->findAllArticle());
    $this->setValues('likeArticles', $articleModel->findAllLikeArticle());
  }
}
