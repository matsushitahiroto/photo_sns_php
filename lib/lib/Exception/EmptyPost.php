<?php

namespace MyApp\Exception;

class EmptyPost extends \Exception {
  protected $message = 'ユーザー名、メールアドレス、パスワードは必須入力です！';
}
