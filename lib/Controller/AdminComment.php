<?php

namespace MyApp\Controller;

class AdminComment extends \MyApp\Controller {
  public function run() {
    if(!$this->isLoggedIn()) {
      //login
      header('Location:' . SITE_URL . '/login.php');
      exit;
    }

    $commentModel = new \MyApp\Model\Comment();
    $this->setValues('comments', $commentModel->findAll());
  }

}
