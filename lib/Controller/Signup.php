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
    } catch (\MyApp\Exception\InvalidUsername $e) {
      $this->setErrors('name', $e->getMessage());
    } catch (\MyApp\Exception\InvalidDescription $e) {
      $this->setErrors('description', $e->getMessage());
    } catch (\MyApp\Exception\InvalidEmail $e) {
      $this->setErrors('email', $e->getMessage());
    } catch (\MyApp\Exception\InvalidPassword $e) {
      $this->setErrors('password', $e->getMessage());
    }

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
    if(!preg_match('/^[ぁ-んァ-ヶーa-zA-Z0-9０-９\n\r]+$/u', $_POST['name'])) {
      throw new \MyApp\Exception\InvalidUsername();
    }
    if($_POST['description'] !== '') {
      if(!preg_match('/^[ぁ-んァ-ヶーa-zA-Z0-9一-龠０-９、。\n\r]+$/u', $_POST['description'])) {
        throw new \MyApp\Exception\InvalidDescription();
      }
    }
    if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
      throw new \MyApp\Exception\InvalidEmail();
    }
    if(!preg_match('/\A[a-zA-Z0-9]+\z/', $_POST['password'])) {
      throw new \MyApp\Exception\InvalidPassword();
    }
  }
}
