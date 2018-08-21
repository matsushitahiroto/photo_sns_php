<?php

namespace MyApp\Exception;

class UploadError extends \Exception {
  protected $message = 'GIF,JPEG,PNGで投稿して下さい！';
}
