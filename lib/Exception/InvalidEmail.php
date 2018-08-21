<?php

namespace MyApp\Exception;

class InvalidEmail extends \Exception {
  protected $message = 'メールアドレスが正しくありません！';
}
