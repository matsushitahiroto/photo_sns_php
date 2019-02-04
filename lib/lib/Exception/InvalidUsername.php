<?php

namespace MyApp\Exception;

class InvalidUsername extends \Exception {
  protected $message = 'ユーザーの名前は２０文字以内で記号は使えません！';
}
