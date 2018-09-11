<?php

namespace MyApp\Exception;

class InvalidUsername extends \Exception {
  protected $message = 'ユーザーの名前に使えない記号があります！';
}
