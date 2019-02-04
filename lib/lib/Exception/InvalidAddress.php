<?php

namespace MyApp\Exception;

class InvalidAddress extends \Exception {
  protected $message = '住所に使えない記号があります！';
}
