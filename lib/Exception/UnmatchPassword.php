<?php

namespace MyApp\Exception;

class UnmatchPassword extends \Exception {
  protected $message = 'パスワードが一致しません！';
}
