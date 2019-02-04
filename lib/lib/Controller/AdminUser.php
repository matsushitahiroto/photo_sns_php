<?php

namespace MyApp\Controller;

class AdminUser extends \MyApp\Controller {
  public function run() {
    if(!$this->adminLoggedIn()) {
      //login
      header('Location:' . SITE_URL . '/adminLogin.php');
      exit;
    }

    $userModel = new \MyApp\Model\User();
    $this->setValues('users', $userModel->findAll());
  }

}
