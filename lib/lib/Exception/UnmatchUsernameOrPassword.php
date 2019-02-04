<?php

namespace MyApp\Exception;

class UnmatchUsernameOrPassword extends \Exception {
  protected $message = 'ユーザー名、パスワードが一致しません！';
}
