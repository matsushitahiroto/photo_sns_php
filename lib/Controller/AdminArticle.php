<?php

namespace MyApp\Controller;

class AdminArticle extends \MyApp\Controller {
  public function run() {
    if(!$this->adminLoggedIn()) {
      //login
      header('Location:' . SITE_URL . '/adminLogin.php');
      exit;
    }

    $articleModel = new \MyApp\Model\Article();
    $this->setValues('articles', $articleModel->findAll());
  }

}
