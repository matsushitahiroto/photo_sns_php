<?php

namespace MyApp\Controller;

class Custom extends \MyApp\Controller {
  public function run() {
    if(!$this->isLoggedIn()) {
      //login
      header('Location:' . SITE_URL . '/login.php');

      exit;

    }
    //get users info
    $userModel = new \MyApp\Model\User();

    $this->setValues('users', $userModel->findAllUser());

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
      $this->postProcess();
    }
  }

  protected function postProcess() {
    $_POST['description'] = ($_POST['description'] === '') ? '' : $_POST['description'];
    //validate
    try {
      $this->_validate();
    } catch (\MyApp\Exception\InvalidUsername $e) {
      // echo $e->getMessage();
      // exit;
      $this->setErrors('name', $e->getMessage());
    } catch (\MyApp\Exception\InvalidDescription $e) {
      // echo $e->getMessage();
      // exit;
      $this->setErrors('description', $e->getMessage());
    } catch (\MyApp\Exception\InvalidEmail $e) {
      // echo $e->getMessage();
      // exit;
      $this->setErrors('email', $e->getMessage());
    } catch (\MyApp\Exception\InvalidPassword $e) {
      // echo $e->getMessage();
      // exit;
      $this->setErrors('password', $e->getMessage());
    }

    if($this->hasError()) {
      return;
    } else {
      //custom user
      try {
        $userModel = new \MyApp\Model\User();
        $user = $userModel->custom([
          'name' => $_POST['name'],
          'description' => $_POST['description'],
          'email' => $_POST['email'],
          'password' => $_POST['password'],
          'id' => $_POST['id']
        ]);
      } catch (\MyApp\Exception\UnmatchPassword $e) {
        $this->setErrors('custom', $e->getMessage());
        return;
      } catch (\MyApp\Exception\DuplicateEmail $e) {
        $this->setErrors('email', $e->getMessage());
        return;
      }
      $_SESSION['me'] = $user;
      //redirect to index
      header('Location:' . SITE_URL);
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
