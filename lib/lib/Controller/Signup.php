<?php

namespace MyApp\Controller;

class Signup extends \MyApp\Controller {
  public function run() {
    if($this->isLoggedIn()) {
      header('Location:' . SITE_URL);
      exit;
    }
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
      $this->postProcess();
    }
  }

  protected function postProcess() {
    // 紹介文が空なら空文字を挿入
      $_POST['description'] = ($_POST['description'] === '') ? '' : $_POST['description'];
    //validate
    try {
      $this->_validate();
    } catch (\MyApp\Exception\EmptyPost $e) {
      $this->setErrors('empty', $e->getMessage());
    } catch (\MyApp\Exception\InvalidUsername $e) {
      $this->setErrors('name', $e->getMessage());
    } catch (\MyApp\Exception\InvalidEmail $e) {
      $this->setErrors('email', $e->getMessage());
    } catch (\MyApp\Exception\InvalidPassword $e) {
      $this->setErrors('password', $e->getMessage());
    }
    $this->setValues('name', $_POST['name']);
    $this->setValues('description', $_POST['description']);
    $this->setValues('email', $_POST['email']);

    if($this->hasError()) {
      return;
    } else {
      //create user
      try {
        $userModel = new \MyApp\Model\User();
        $userModel->create([
          'name' => $_POST['name'],
          'description' => $_POST['description'],
          'email' => $_POST['email'],
          'password' => $_POST['password']
        ]);
      } catch (\MyApp\Exception\DuplicateEmail $e) {
        $this->setErrors('email', $e->getMessage());
        return;
      }
      //redirect to login
      header('Location:' . SITE_URL . '/login.php#form');
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
    if(!preg_match('/^[ぁ-んァ-ヶ一-龠a-zA-Z0-9０-９]+$/u', $_POST['name'])) {
      throw new \MyApp\Exception\InvalidUsername();
    }
    if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
      throw new \MyApp\Exception\InvalidEmail();
    }
    if(!preg_match('/\A(?=.*?[a-z])(?=.*?\d)[a-z\d]{8,20}+\z/i', $_POST['password'])) {
      throw new \MyApp\Exception\InvalidPassword();
    }
  }
}
