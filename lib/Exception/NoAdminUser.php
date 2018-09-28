<?php

namespace MyApp\Exception;

class NoAdminUser extends \Exception {
  protected $message = '管理者ではありません！';
}
