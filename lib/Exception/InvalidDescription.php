<?php

namespace MyApp\Exception;

class InvalidDescription extends \Exception {
  protected $message = '紹介文に使えない記号があります！';
}
