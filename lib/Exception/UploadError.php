<?php

namespace MyApp\Exception;

class UploadError extends \Exception {
  protected $message = 'アップロードできません！';
}
