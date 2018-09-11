<?php

namespace MyApp\Controller;

class Login extends \MyApp\Controller {
  public function run() {
    if($this->isLoggedIn()) {
      header('Location:' . SITE_URL);
      exit;
    }

    $articleModel = new \MyApp\Model\Article();

    $this->setValues('articles', $articleModel->findAllArticle());
    $this->setValues('likeArticles', $articleModel->findAllLikeArticle());


    if($_SERVER['REQUEST_METHOD'] === 'POST') {
      $this->postProcess();
    }
  }


  protected function postProcess() {
    //validate
    try {
      $this->_validate();
    } catch (\MyApp\Exception\EmptyPost $e) {
      $this->setErrors('login', $e->getMessage());
    }

    if($this->hasError()) {
      return;
    } else {
      try {
        $userModel = new \MyApp\Model\User();
        $user = $userModel->login([
          'name' => $_POST['name'],
          'email' => $_POST['email'],
          'password' => $_POST['password']
        ]);
      } catch (\MyApp\Exception\UnmatchUsernameOrPassword $e) {
        $this->setErrors('login', $e->getMessage());
        return;
      }
      //login
      session_regenerate_id(true);
      $_SESSION['me'] = $user;

      //redirect to login
      header('Location:' . SITE_URL);
      exit;
    }

  }

  private function _validate() {
    if(!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']) {
      echo "不正な処理が行われました！";
      exit;
    }
    if(!isset($_POST['name']) || !isset($_POST['email']) || !isset($_POST['password'])) {
      echo "入力がされていません！";
      exit;
    }
    if($_POST['name'] === '' || $_POST['email'] === '' || $_POST['password'] === '') {
      throw new \MyApp\Exception\EmptyPost();
    }
  }
}
