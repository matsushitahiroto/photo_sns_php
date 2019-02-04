<?php

namespace MyApp\Exception;

class ImageTypeError extends \Exception {
  protected $message = 'GIF,JPEG,PNGで投稿して下さい！';
}
