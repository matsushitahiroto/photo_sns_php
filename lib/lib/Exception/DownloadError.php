<?php

namespace MyApp\Exception;

class DownloadError extends \Exception {
  protected $message = 'うまく読み込めませんでした。';
}
