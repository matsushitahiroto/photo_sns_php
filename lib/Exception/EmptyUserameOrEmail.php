<?php

namespace MyApp\Exception;

class EmptyPost extends \Exception {
  protected $message = 'ユーザー名、メールアドレスは必須入力です！';
}
