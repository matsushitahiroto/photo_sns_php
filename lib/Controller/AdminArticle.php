<?php

namespace MyApp\Controller;

class AdminArticle extends \MyApp\Controller {
  public function run() {
    if(!$this->isLoggedIn()) {
      //login
      header('Location:' . SITE_URL . '/login.php');
      exit;
    }

    $articleModel = new \MyApp\Model\Article();
    $this->setValues('articles', $articleModel->findAll());
  }

}
