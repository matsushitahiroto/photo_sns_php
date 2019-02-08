<?php

namespace MyApp\Controller;

class AdminLike extends \MyApp\Controller {
  public function run() {
    if(!$this->adminLoggedIn()) {
      //login
      header('Location:' . SITE_URL . '/adminLogin.php');
      exit;
    }

    $likeModel = new \MyApp\Model\Like();
    $this->setValues('likes', $likeModel->findAll());
  }

}
