<?php

namespace MyApp\Exception;

class InvalidTitle extends \Exception {
  protected $message = 'タイトルに使えない記号があります！';
}
