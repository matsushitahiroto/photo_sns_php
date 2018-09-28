<?php

namespace MyApp\Controller;

class AdminLike extends \MyApp\Controller {
  public function run() {
    if(!$this->isLoggedIn()) {
      //login
      header('Location:' . SITE_URL . '/login.php');
      exit;
    }

    $likeModel = new \MyApp\Model\Like();
    $this->setValues('likes', $likeModel->findAll());
  }

}
