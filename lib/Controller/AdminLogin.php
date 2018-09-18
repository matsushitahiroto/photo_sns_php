<?php

namespace MyApp\Controller;

class AdminLogin extends \MyApp\Controller {
  public function run() {
    if($this->isLoggedIn()) {
      //login
      header('Location:' . SITE_URL);
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
        $userModel->adminLogin([
          'id' => $_POST['id'],
          'password' => $_POST['password']
        ]);
      } catch (\MyApp\Exception\UnmatchUsernameOrPassword $e) {
        $this->setErrors('login', $e->getMessage());
      }

      session_regenerate_id(true);
      $_SESSION['me'] = $user;

      header('Location:' . SITE_URL);
      exit;
    }
  }
}
