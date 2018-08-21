<?php

namespace MyApp\Controller;
class Post extends \MyApp\Controller {

  private $_imageFileName;
  private $_imageType;

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
      $this->upload();
    }
  }

  protected function upload() {

    try {
      // error check
      $this->_validateUpload();

      // type check
      $ext = $this->_validateImageType();

      // save
      $savePath = $this->_save($ext);

      // create thumbnail
      $this->_createThumbnail($savePath);

    } catch (\MyApp\Exception\InvalidTitle $e) {
      $this->setErrors('title', $e->getMessage());
    } catch (\MyApp\Exception\InvalidDescription $e) {
      $this->setErrors('description', $e->getMessage());
    } catch (\MyApp\Exception\ImageSizeError $e) {
      $this->setErrors('size', $e->getMessage());
    } catch (\MyApp\Exception\ImageTypeError $e) {
      $this->setErrors('type', $e->getMessage());
    } catch (\MyApp\Exception\UploadError $e) {
      $this->setErrors('image', $e->getMessage());
    }

    if($this->hasError()) {
      return;
    } else {
      //custom user
      try {
        $articleModel = new \MyApp\Model\Article();
        $articleModel->post([
          'title' => $_POST['title'],
          'description' => $_POST['description'],
          'savePath' => $savePath,
          'user_id' => $_POST['id']
        ]);

      } catch (\MyApp\Exception\UploadError $e) {
        $this->setErrors('article', $e->getMessage());
        return;
      }

      try {
        $articleModel = new \MyApp\Model\Article();
        $article = $articleModel->getMyArticles([
          'user_id' => $_POST['id']
        ]);
      } catch (\MyApp\Exception\UploadError $e) {
        $this->setErrors('article', $e->getMessage());
        return;
      }

      $_SESSION['img'] = $article;

      //redirect to index
      header('Location:' . SITE_URL . '/profile.php');
      exit;
    }
  }

  private function _validate() {
    if(!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']) {
      echo "不正な処理が行われました！";
      exit;
    }
    if($_POST['title'] !== '') {
      if(!preg_match('/^[ぁ-んァ-ヶーa-zA-Z0-9一-龠０-９、。\n\r]+$/u', $_POST['title'])) {
        throw new \MyApp\Exception\InvalidTitle();
      }
    }
    if($_POST['description'] !== '') {
      if(!preg_match('/^[ぁ-んァ-ヶーa-zA-Z0-9一-龠０-９、。\n\r]+$/u', $_POST['description'])) {
        throw new \MyApp\Exception\InvalidDescription();
      }
    }
  }

  private function _validateUpload() {

    if (!isset($_FILES['image']) || !isset($_FILES['image']['error'])) {
      throw new \MyApp\Exception\UploadError();
    }

    switch($_FILES['image']['error']) {
      case UPLOAD_ERR_OK:
        return true;
      case UPLOAD_ERR_INI_SIZE:
      case UPLOAD_ERR_FORM_SIZE:
        throw new \MyApp\Exception\ImageSizeError();
      default:
        throw new \MyApp\Exception\UploadError();
    }
  }

  private function _validateImageType() {
    $this->_imageType = exif_imagetype($_FILES['image']['tmp_name']);
    switch($this->_imageType) {
      case IMAGETYPE_GIF:
      return 'gif';
      case IMAGETYPE_JPEG:
      return 'jpg';
      case IMAGETYPE_PNG:
      return 'png';
      default:
      throw new \MyApp\Exception\ImageTypeError();
    }
  }

  private function _save($ext) {
    $this->_imageFileName = sprintf(
      '%s_%s.%s',
      time(),
      sha1(uniqid(mt_rand(), true)),
      $ext
    );
    $savePath = IMAGES_DIR . '/' . $this->_imageFileName;
    $res = move_uploaded_file($_FILES['image']['tmp_name'], $savePath);
    if ($res === false) {
      throw new \MyApp\Exception\UploadError();
    }
    return $savePath;
  }

  private function _createThumbnail($savePath) {
    $imageSize = getimagesize($savePath);
    $width = $imageSize[0];
    $height = $imageSize[1];
    if ($width > THUMBNAIL_WIDTH) {
      $this->_createThumbnailMain($savePath, $width, $height);
    }
  }

  private function _createThumbnailMain($savePath, $width, $height) {
    switch($this->_imageType) {
      case IMAGETYPE_GIF:
        $srcImage = imagecreatefromgif($savePath);
        break;
      case IMAGETYPE_JPEG:
        $srcImage = imagecreatefromjpeg($savePath);
        break;
      case IMAGETYPE_PNG:
        $srcImage = imagecreatefrompng($savePath);
        break;
    }
    $thumbHeight = round($height * THUMBNAIL_WIDTH / $width);
    $thumbImage = imagecreatetruecolor(THUMBNAIL_WIDTH, $thumbHeight);
    imagecopyresampled($thumbImage, $srcImage, 0, 0, 0, 0, THUMBNAIL_WIDTH, $thumbHeight, $width, $height);

    switch($this->_imageType) {
      case IMAGETYPE_GIF:
        imagegif($thumbImage, THUMBNAIL_DIR . '/' . $this->_imageFileName);
        break;
      case IMAGETYPE_JPEG:
        imagejpeg($thumbImage, THUMBNAIL_DIR . '/' . $this->_imageFileName);
        break;
      case IMAGETYPE_PNG:
        imagepng($thumbImage, THUMBNAIL_DIR . '/' . $this->_imageFileName);
        break;
    }

  }
}
