<?php

namespace MyApp\Exception;

class EmptyPost extends \Exception {
  protected $message = 'ユーザー名、パスワードを入力してください！';
}
