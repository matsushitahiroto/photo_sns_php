<?php

namespace MyApp\Exception;

class DeleteError extends \Exception {
  protected $message = '削除できません！';
}
