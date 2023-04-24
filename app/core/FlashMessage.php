<?php

class FlashMessage
{
  /** set single message */
  public static function setFlash(string $type, string $message)
  {
    $_SESSION["flash"] = [
      "type" => $type,
      "message" => $message
    ];
  }
  
  /** get message */
  public static function getMessage()
  {
    if (isset($_SESSION['flash'])) {
      // call printMessage with static calling method
      self::printMessage($_SESSION['flash']['type'], $_SESSION['flash']['message']);
      // remove session because already used
      unset($_SESSION['flash']);
    }
  }

  /** set flash message by array */
  public static function setFlashMessageArray(string $typeIcon, array $messages): void
  {
    $_SESSION["flashArray"] = ["type" => $typeIcon, "messages" => (object)$messages];
  }

  /** get flash message by array errors */
  public static function getFlashMessageArray(): void
  {
    if (isset($_SESSION["flashArray"])) {
      $alert = $_SESSION["flashArray"];
      $type = $alert["type"];
      $messages = $alert["messages"];

      foreach ($messages as $message) {
        self::printMessage($type, $message);
      }

    }
    // remove session message
    unset($_SESSION['flashArray']);
  }

  /** private method to helper print message with error or success popup */
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
