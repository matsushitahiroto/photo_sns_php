<?php

namespace MyApp\Exception;

class InvalidLatitude extends \Exception {
  protected $message = '緯度は半角数字です';
}
