<?php

namespace MyApp\Controller;

class AdminCustom extends \MyApp\Controller {
  // private $user;
  public function run() {
    $user = array();
    if(!$this->isLoggedIn()) {
      //login
      header('Location:' . SITE_URL . '/login.php');
      exit;
    }


    switch ($_GET['type']) {
      case 'user':
        $this->_customUser();
        break;
      case 'article':
        $this->_customArticle();
        break;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      switch ($_GET['type']) {
        case 'user':
          $this->postProcessUser();
          break;
        case 'article':
          $this->postProcessArticle();
          break;
      }
    }
  }

  private function _customUser() {
    $userModel = new \MyApp\Model\User();
    $user = $userModel->adminGetUser([
      'id' => $_GET['id']
    ]);
    $this->setValues('user', $user);

  }

  protected function postProcessUser() {
    $_POST['description'] = ($_POST['description'] === '') ? '' : $_POST['description'];
    //validate
    try {
      $this->_validateUser();
    } catch (\MyApp\Exception\InvalidUsername $e) {
      $this->setErrors('name', $e->getMessage());
    } catch (\MyApp\Exception\InvalidDescription $e) {
      $this->setErrors('description', $e->getMessage());
    } catch (\MyApp\Exception\InvalidEmail $e) {
      $this->setErrors('email', $e->getMessage());
    }

    if($this->hasError()) {
      return;
    } else {
      try {
        $userModel = new \MyApp\Model\User();
        $userModel->adminCustom([
          'name' => $_POST['name'],
          'admin' => $_POST['admin'],
          'description' => $_POST['description'],
          'email' => $_POST['email'],
          'id' => $_POST['id']
        ]);
      } catch (\MyApp\Exception\DuplicateEmail $e) {
        $this->setErrors('demail', $e->getMessage());
        return;
      }
    }
    //redirect to index
    header('Location:' . SITE_URL . '/adminUser.php');
    exit;
  }

  private function _validateUser() {
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
  }

  private function _customArticle() {
    $articleModel = new \MyApp\Model\Article();
    $article = $articleModel->adminGetArticle([
      'id' => $_GET['id']
    ]);
    $this->setValues('article', $article);
  }

  protected function postProcessArticle() {
    $_POST['description'] = ($_POST['description'] === '') ? '' : $_POST['description'];
    $_POST['savePathSub1'] = (!isset($_POST['savePathSub1'])) ? '' : $_POST['savePathSub1'];
    $_POST['savePathSub2'] = (!isset($_POST['savePathSub2'])) ? '' : $_POST['savePathSub2'];
    //validate
    try {
      $this->_validateArticle();
    } catch (\MyApp\Exception\InvalidTitle $e) {
      $this->setErrors('title', $e->getMessage());
    } catch (\MyApp\Exception\InvalidDescription $e) {
      $this->setErrors('description', $e->getMessage());
    } catch (\MyApp\Exception\InvalidAddress $e) {
      $this->setErrors('address', $e->getMessage());
    } catch (\MyApp\Exception\InvalidLatitude $e) {
      $this->setErrors('lat', $e->getMessage());
    } catch (\MyApp\Exception\InvalidLongitude $e) {
      $this->setErrors('lng', $e->getMessage());
    }

    if($this->hasError()) {
      return;
    } else {
      try {
        $articleModel = new \MyApp\Model\Article();
        $articleModel->custom([
          'title' => $_POST['title'],
          'description' => $_POST['description'],
          'savePath' => $_POST['savePath'],
          'savePathSub1' => $_POST['savePathSub1'],
          'savePathSub2' => $_POST['savePathSub2'],
          'address' => $_POST['address'],
          'lat' => $_POST['lat'],
          'lng' => $_POST['lng'],
          'id' => $_POST['id']
        ]);
      } catch (\MyApp\Exception\UploadError $e) {
        $this->setErrors('upload', $e->getMessage());
        return;
      }
    }
    //redirect to index
    header('Location:' . SITE_URL . '/adminArticle.php');
    exit;
  }

  private function _validateArticle() {
    if(!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']) {
      echo "不正な処理が行われました！";
      exit;
    }
    if($_POST['title'] !== '') {
      if(!preg_match('/^[ぁ-んァ-ヶ一-龠０-９、。,\.ー＿\-\w\s]+$/u', $_POST['title'])) {
        throw new \MyApp\Exception\InvalidTitle();
      }
    }
    if($_POST['description'] !== '') {
      if(!preg_match('/^[ぁ-んァ-ヶ一-龠０-９、。,\.ー＿\-\w\s]+$/u', $_POST['description'])) {
        throw new \MyApp\Exception\InvalidDescription();
      }
    }
    if($_POST['address'] !== '') {
      if(!preg_match('/^[ぁ-んァ-ヶ一-龠０-９〒、。,\.ー－−＿\-\w\s]+$/u', $_POST['address'])) {
        throw new \MyApp\Exception\InvalidAddress();
      }
    }
    if($_POST['lat'] !== '') {
      if(!preg_match('/[0-9\.]+/u', $_POST['lat'])) {
        throw new \MyApp\Exception\InvalidLatitude();
      }
    }
    if($_POST['lng'] !== '') {
      if(!preg_match('/[0-9\.]+/u', $_POST['lng'])) {
        throw new \MyApp\Exception\InvalidLongitude();
      }
    }
  }
}
