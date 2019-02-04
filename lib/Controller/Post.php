<?php

namespace MyApp\Controller;
class Post extends \MyApp\Controller {

  private $_imageFileName;
  private $_imageType;
  private $_fileDatas;
  private $fileData;

  public function run() {
    if(!$this->isLoggedIn()) {
      //login
      header('Location:' . SITE_URL . '/login.php');

      exit;

    }

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
      $this->upload();
    }
  }

  protected function upload() {
    //ファイルの数をカウントする
    $photoData = $_FILES['images']['name'];
    $num = count($photoData);

    $fileData = array();
    $arr = array();
    for($i = 0; $i < $num; $i++){
      $name = $_FILES['images']['name'][$i];
      $type = $_FILES['images']['type'][$i];
      $tmp_name = $_FILES['images']['tmp_name'][$i];
      $error = $_FILES['images']['error'][$i];
      $size = $_FILES['images']['size'][$i];

      $arr['name'] = $name;
      $arr['type'] = $type;
      $arr['tmp_name'] = $tmp_name;
      $arr['error'] = $error;
      $arr['size'] = $size;
      $this->_fileDatas[] = $arr;
    }
    try {
      $this->_validate();
      // error check
      $this->_validateUploadMain();
      // var_dump($this->_fileDatas);
      // exit;
      foreach ($this->_fileDatas as $this->fileData) {
        if ($this->fileData['size'] !== 0) {
          // error check
          $this->_validateUpload();
          // type check
          $ext = $this->_validateImageType();
          // save
          $savePath = $this->_save($ext);
          // create thumbnail
          $this->_createThumbnail($savePath);

          $path[] = $savePath;
        }
      }
      $path[1] = (!isset($path[1])) ? '' : $path[1];
      $path[2] = (!isset($path[2])) ? '' : $path[2];

    } catch (\MyApp\Exception\InvalidTitle $e) {
      $this->setErrors('title', $e->getMessage());
    } catch (\MyApp\Exception\ImageSizeError $e) {
      $this->setErrors('size', $e->getMessage());
    } catch (\MyApp\Exception\ImageTypeError $e) {
      $this->setErrors('type', $e->getMessage());
    } catch (\MyApp\Exception\UploadError $e) {
      $this->setErrors('image', $e->getMessage());
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
      $address = preg_replace('/^.+〒[0-9]{3}-[0-9]{4} /u','',$_POST['address']);
      try {
        $articleModel = new \MyApp\Model\Article();
        $articleModel->post([
          'title' => $_POST['title'],
          'description' => $_POST['description'],
          'savePath' => $path[0],
          'savePathSub1' => $path[1],
          'savePathSub2' => $path[2],
          'address' => $address,
          'lat' => $_POST['lat'],
          'lng' => $_POST['lng'],
          'id' => $_POST['id']
        ]);
      } catch (\MyApp\Exception\UploadError $e) {
        $this->setErrors('article', $e->getMessage());
        return;
      }
      try {
        $userModel = new \MyApp\Model\User();
        $user = $userModel->reload([
          'id' => $_POST['id']
        ]);
      } catch (\MyApp\Exception\DownloadError $e) {
        $this->setErrors('login', $e->getMessage());
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
    if($_POST['title'] !== '') {
      if(!preg_match('/^[ぁ-んァ-ヶ一-龠０-９、。,\.ー＿\-\w\s]+$/u', $_POST['title'])) {
        throw new \MyApp\Exception\InvalidTitle();
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

  private function _validateUploadMain() {
    if (!isset($this->_fileDatas[0]) || !isset($this->_fileDatas[0]['error'])) {
      throw new \MyApp\Exception\UploadError();
    }

    switch($this->_fileDatas[0]['error']) {
      case UPLOAD_ERR_OK:
        return true;
      case UPLOAD_ERR_INI_SIZE:
      case UPLOAD_ERR_FORM_SIZE:
        throw new \MyApp\Exception\ImageSizeError();
      default:
        throw new \MyApp\Exception\UploadError();
    }
  }

  private function _validateUpload() {
    switch($this->fileData['error']) {
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
    $this->_imageType = exif_imagetype($this->fileData['tmp_name']);
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
    $res = move_uploaded_file($this->fileData['tmp_name'], $savePath);
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
