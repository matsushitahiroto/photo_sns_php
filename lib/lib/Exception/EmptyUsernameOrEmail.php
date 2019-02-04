<?php

namespace MyApp\Exception;

class EmptyUsernameOrEmail extends \Exception {
  protected $message = 'ユーザー名、メールアドレスは必須入力です！';
}
