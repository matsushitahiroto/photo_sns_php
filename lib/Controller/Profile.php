<?php

namespace MyApp\Controller;

class Profile extends \MyApp\Controller {
  public function run() {
    if(!$this->isLoggedIn()) {
      //login
      header('Location:' . SITE_URL . '/login.php');

      exit;
    }

    $articleModel = new \MyApp\Model\Article();

    $this->setValues('articles', $articleModel->getMyArticles([
      'user_id' => $_SESSION['me']->id
    ]));
  }
}
