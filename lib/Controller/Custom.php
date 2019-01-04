<?php

namespace MyApp\Controller;

class Custom extends \MyApp\Controller {

  private $iconPath;
  private $newIconPath;

  public function run() {
    if(!$this->isLoggedIn()) {
      //login
      header('Location:' . SITE_URL . '/login.php');
      exit;
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
      $this->postProcess();
    }
  }

  protected function postProcess() {
    $_POST['iconPath'] = ($_POST['iconPath'] === '') ? '' : $_POST['iconPath'];
    $iconPath = $_POST['iconPath'];
    
    //新たな保存先を指定
    $newIconPath = str_replace('./tmpImage', './croppedImage', $iconPath);

    //ファイルの移動
    rename("$iconPath", "$newIconPath");

    $dir = glob('./tmpImage/*');

    foreach ($dir as $file){
      //ファイルを削除する
      unlink($file);
    }
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
      try {
        $userModel = new \MyApp\Model\User();
        $userModel->checkPassword([
          'password' => $_POST['password'],
          'id' => $_POST['id']
        ]);
      } catch (\MyApp\Exception\UnmatchPassword $e) {
        $this->setErrors('custom', $e->getMessage());
        return;
      }
      try {
        $userModel = new \MyApp\Model\User();
        $userModel->custom([
          'iconPath' => $newIconPath,
          'name' => $_POST['name'],
          'description' => $_POST['description'],
          'email' => $_POST['email'],
          'id' => $_POST['id']
        ]);
      } catch (\MyApp\Exception\DuplicateEmail $e) {
        $this->setErrors('demail', $e->getMessage());
        return;
      }
      try {
        $userModel = new \MyApp\Model\User();
        $user = $userModel->reload([
          'id' => $_POST['id']
        ]);
      } catch (\MyApp\Exception\UnmatchPassword $e) {
        $this->setErrors('custom', $e->getMessage());
        return;
      }
      $_SESSION['me'] = $user;
    }
    //redirect to index
    header('Location:' . SITE_URL . '/profile.php');
    exit;
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
