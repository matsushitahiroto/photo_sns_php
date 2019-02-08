<?php

namespace MyApp\Controller;

class AdminComment extends \MyApp\Controller {
  public function run() {
    if(!$this->adminLoggedIn()) {
      //login
      header('Location:' . SITE_URL . '/adminLogin.php');
      exit;
    }

    $commentModel = new \MyApp\Model\Comment();
    $this->setValues('comments', $commentModel->findAll());
  }

}
