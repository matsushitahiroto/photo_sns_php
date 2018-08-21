<?php

namespace MyApp\Exception;

class ImageSizeError extends \Exception {
  protected $message = '画像のサイズが大きすぎます！';
}
