<?php

namespace MyApp\Exception;

class InvalidEmail extends \Exception {
  protected $message = 'メールアドレスに使えない記号があります！';
}
