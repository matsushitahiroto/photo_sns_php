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
    $_POST['iconPath'] = ($_POST['iconPath'] === '') ? NULL : $_POST['iconPath'];
    $iconPath = $_POST['iconPath'];

    //新たな保存先を指定
    if ($iconPath !== NULL) {
      // code...
      $newIconPath = str_replace('./tmpImage', './croppedImage', $iconPath);

      //ファイルの移動
      rename("$iconPath", "$newIconPath");

      // $dir = glob('./tmpImage/*');
      //
      // foreach ($dir as $file){
      //   //ファイルを削除する
      //   unlink($file);
      // }
    }
    $_POST['description'] = ($_POST['description'] === '') ? '' : $_POST['description'];
    //validate
    try {
      $this->_validate();
    } catch (\MyApp\Exception\EmptyUserameOrEmail $e) {
      $this->setErrors('empty', $e->getMessage());
    } catch (\MyApp\Exception\InvalidUsername $e) {
      $this->setErrors('name', $e->getMessage());
    } catch (\MyApp\Exception\InvalidEmail $e) {
      $this->setErrors('email', $e->getMessage());
    }

    if($this->hasError()) {
      return;
    } else {
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
      } catch (\MyApp\Exception\DownloadError $e) {
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
    if(!isset($_POST['name']) || !isset($_POST['email'])) {
      echo "入力がされていません！";
      exit;
    }
    if($_POST['name'] === '' || $_POST['email'] === '') {
      throw new \MyApp\Exception\EmptyUserameOrEmail();
    }
    if(!preg_match('/^[ぁ-んァ-ヶ一-龠a-zA-Z0-9０-９\n\r]+$/u', $_POST['name'])) {
      throw new \MyApp\Exception\InvalidUsername();
    }
    if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
      throw new \MyApp\Exception\InvalidEmail();
    }
  }
}
