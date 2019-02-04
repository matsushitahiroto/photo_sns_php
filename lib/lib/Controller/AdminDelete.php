<?php

namespace MyApp\Controller;

class AdminDelete extends \MyApp\Controller {
  // private $user;
  public function run() {
    $user = array();
    if(!$this->adminLoggedIn()) {
      //login
      header('Location:' . SITE_URL . '/adminLogin.php');
      exit;
    }
    switch ($_GET['type']) {
      case 'user':
        $this->_deleteUser();
        break;
      case 'article':
        $this->_deleteArticle();
        break;
      case 'comment':
        $this->_deleteComment();
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
        case 'comment':
          $this->postProcessComment();
          break;
      }
    }
  }

  private function _deleteUser() {
    $userModel = new \MyApp\Model\User();
    $user = $userModel->adminGetUser([
      'id' => $_GET['id']
    ]);
    $this->setValues('user', $user);
  }

  protected function postProcessUser() {
    try {
      $userModel = new \MyApp\Model\User();
      $userModel->delete([
        'id' => $_POST['id']
      ]);
    } catch (\MyApp\Exception\DeleteError $e) {
      $this->setErrors('delete', $e->getMessage());
      return;
    }
    //redirect to index
    header('Location:' . SITE_URL . '/adminUser.php');
    exit;
  }

  private function _deleteArticle() {
    $articleModel = new \MyApp\Model\Article();
    $article = $articleModel->adminGetArticle([
      'id' => $_GET['id']
    ]);
    $this->setValues('article', $article);
  }

  protected function postProcessArticle() {
    try {
      $articleModel = new \MyApp\Model\Article();
      $articleModel->delete([
        'id' => $_POST['id']
      ]);
    } catch (\MyApp\Exception\DeleteError $e) {
      $this->setErrors('delete', $e->getMessage());
      return;
    }
    //redirect to index
    header('Location:' . SITE_URL . '/adminArticle.php');
    exit;
  }

  private function _deleteComment() {
    $commentModel = new \MyApp\Model\Comment();
    $comment = $commentModel->adminGetComment([
      'id' => $_GET['id']
    ]);
    $this->setValues('comment', $comment);
  }

  protected function postProcessComment() {
    try {
      $commentModel = new \MyApp\Model\Comment();
      $commentModel->adminDelete([
        'id' => $_POST['id']
      ]);
    } catch (\MyApp\Exception\DeleteError $e) {
      $this->setErrors('delete', $e->getMessage());
      return;
    }
    //redirect to index
    header('Location:' . SITE_URL . '/adminComment.php');
    exit;
  }
}
