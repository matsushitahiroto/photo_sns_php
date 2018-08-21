<?php

namespace MyApp\Exception;

class InvalidUsername extends \Exception {
  protected $message = 'ユーザーの名前が正しくありません！';
}
