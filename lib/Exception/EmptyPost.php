<?php

namespace MyApp\Exception;

class EmptyPost extends \Exception {
  protected $message = 'ユーザー名、メールアドレス、パスワードを入力してください！';
}
