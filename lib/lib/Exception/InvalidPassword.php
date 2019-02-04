<?php

namespace MyApp\Exception;

class InvalidPassword extends \Exception {
  protected $message = 'パスワードは半角英数字を含む８文字以上２０文字以下です！';
}
