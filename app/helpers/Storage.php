<?php

class Storage
{
  // default image extensions
  private static $extensionImage = ['png', 'jpg', 'jpeg'];

  /** Save as file */
  public static function putFileAs(string  $location,
                                   ?string $input_name = 'image',
                                   ?array  $extensions = null,
                                   ?string $nameFile = null,
                                   ?int    $maxSize = 2000000)
  {
    // get data from input files
    $name = $_FILES[$input_name]['name'];  // name file
    $error = $_FILES[$input_name]['error']; // error status: 2 means success, 4 means error
    $size = $_FILES[$input_name]['size']; // file size (in byte)
    $tmp = $_FILES[$input_name]['tmp_name']; // location temporary file uploaded

    // if status error === 4, means not uploaded
    if ($error === 4) {
      throw new \Exception($input_name . " not uploaded"); // create throw error
    }
    // check size
    if ($size > $maxSize) {
      throw new \Exception($input_name . " size exceeds " . $maxSize);
    }

    // if extensions null then use image extensions
    $validExtension = $extensions ?? self::$extensionImage;

    // get file extensions, etc: .pdf .png
    $getImageExtension = explode('.', $name);
    $getImageExtension = strtolower(end($getImageExtension));

    // if extensions not in valid extensions file, then trow error
    if (!in_array($getImageExtension, $validExtension)) {
      throw new \Exception($input_name . " not valid");
    }

    // setup name file
    if (is_null($nameFile))
      $nameFile = microtime() . '_' . uniqid() . '.' . $getImageExtension;
    else
      $nameFile = $nameFile . "." . $getImageExtension;

    // move file from temporary location to real path location
    move_uploaded_file($tmp, path($location) . "/$nameFile");
    // return name file
    return $nameFile;
  }

  /** remove file */
  public static function delete($path, $file): bool
  {
    // if file exists
    if (file_exists(path() . $path . '/' . $file)) {
      // then unlink (means remove file)
      unlink(path() . $path . '/' . $file);
      return true;
    }
    return false;
  }
}
