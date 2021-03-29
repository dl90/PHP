<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\BinaryFileResponse;

class FileController extends Controller
{

  public function getFile(string $file_name): BinaryFileResponse
  {
    return response()->file(base_path("storage\app\private-uploads\images\\" . $file_name));
  }
}