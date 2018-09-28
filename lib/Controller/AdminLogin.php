<?php

namespace MyApp\Controller;

class AdminLogin extends \MyApp\Controller {
  public function run() {
    if($this->isLoggedIn()) {
      //login
      header('Location:' . SITE_URL . '/adminIndex.php');
      exit;
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $this->postProcess();
    }
  }

  protected function postProcess() {
    try {
      $this->_validate();
    } catch (MyApp\Exception\EmptyPost $e) {
      $this->setErrors('login', $e->getMessage());
    }

    if ($this->hasError()) {
      return;
    } else {
      try {
        $userModel = new \MyApp\Model\User();
        $user = $userModel->adminLogin([
          'id' => $_POST['id'],
          'password' => $_POST['password']
        ]);
      } catch (\MyApp\Exception\UnmatchUsernameOrPassword $e) {
        $this->setErrors('login', $e->getMessage());
      } catch (\MyApp\Exception\NoAdminUser $e) {
        $this->setErrors('admin', $e->getMessage());
        return;
      }

      session_regenerate_id(true);
      $_SESSION['me'] = $user;

      header('Location:' . SITE_URL . '/adminIndex.php');
      exit;
    }
  }

  private function _validate() {
    if (!isset($_SESSION['token']) || $_SESSION['token'] !== $_POST['token']) {
      echo "不正な処理が行われました";
      exit;
    }
    if (!isset($_POST['id']) || !isset($_POST['password'])) {
      echo "入力がされていません";
      exit;
    }
    if ($_POST['id'] === '' || $_POST['password'] === '') {
      throw new \MyApp\Exception\EmptyPost();
    }
  }
}
