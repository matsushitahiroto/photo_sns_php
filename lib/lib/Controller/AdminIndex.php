<?php

namespace MyApp\Controller;

class AdminIndex extends \MyApp\Controller {
  public function run() {
    if(!$this->adminLoggedIn()) {
      //login
      header('Location:' . SITE_URL . '/adminLogin.php');
      exit;
    }
  }

}
