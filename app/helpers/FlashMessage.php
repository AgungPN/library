<?php
if (!session_id()) session_start();

class FlashMessage
{
  public static function setFlash(string $type, string $message)
  {
    $_SESSION["flash"] = [
      "type" => $type,
      "message" => $message
    ];
  }
  public static function message()
  {
    if (isset($_SESSION['flash'])) {
      self::printMessage($_SESSION['flash']['type'], $_SESSION['flash']['message']);
      unset($_SESSION['flash']);
    }
  }

  public static function setFlashMessageArray(string $typeIcon, array $messages): void
  {
    $_SESSION["flashArray"] = ["type" => $typeIcon, "messages" => (object)$messages];
  }

  public static function getFlashMessageArray(): void
  {
    if (isset($_SESSION["flashArray"])) {
      $alert = $_SESSION["flashArray"];
      $type = $alert["type"];
      $messages = $alert["messages"];

      foreach ($messages as $message) {
        self::printMessage($type, $message);
      }

      // echo "<script>console.log('".$message."')</script>";
    }
    unset($_SESSION['flashArray']);
  }

  private static function printMessage($type, $message)
  {
    if ($type == "success") {
      echo "<script>
    iziToast.success({
      title: '$type',
      message: '$message',
      position: 'topRight'
    });
      </script>";
  } else{
      echo "<script>
    iziToast.error({
      title: '$type',
      message: '$message',
      position: 'topRight'
    });
      </script>";
  }
  }
}
