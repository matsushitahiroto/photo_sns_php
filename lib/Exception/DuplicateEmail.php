<?php

namespace MyApp\Exception;

class DuplicateEmail extends \Exception {
  protected $message = '既に登録されているユーザー名、または、メールアドレスです！';
}
