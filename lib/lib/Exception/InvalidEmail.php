<?php

namespace MyApp\Exception;

class InvalidEmail extends \Exception {
  protected $message = 'メールアドレスが不正な形式か、使えない記号があります！';
}
