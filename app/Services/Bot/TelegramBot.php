<?php

namespace App\Services\Bot;

/**
 * @param $typeMsg, default = /sendMessage;
 * @param myid 365047507
 * @param Anton 45881581
 */

class TelegramBot
{
  protected $url = "https://api.telegram.org/bot";
  private $chatId;
  private $token = "5425154420:AAF_bDkwaXo-OcoA6bZlXHVeE1vQkurzT5Q";

  public function __construct($chatId = "")
  {
    $this->chatId = $chatId;
  }

  public static function create($chatId)
  {
    return new self($chatId);
  }

  public function sendMsg($msg, $keyboardMsg = false, $url = false)
  {
    try {
      $params = ["chat_id" => $this->chatId, "text" => $msg];
      if ($keyboardMsg) {
        $params["reply_markup"] = $this->addKeyboad($keyboardMsg, $url);
      }

      $this->send($params, "/sendMessage");
      return $this;
    } catch (\Exception $e) {
      $this->exceptionError($e);
    }
  }

  public function sendFile(string $path)
  {
    if (is_file($path)) {
      $file = curl_file_create($path);
      try {
        $params = ["chat_id" => $this->chatId, "document" => $file];
        $this->send($params, "/sendDocument");
      } catch (\Exception $e) {
        print_r($e);
      }
    }
    return false;
  }

  public function sendPhoto(
    $msg,
    $urlImages = "",
    $url = false,
    $keyboardMsg = ""
  ) {
    $params = [
      "chat_id" => $this->chatId,
      "caption" => $msg,
      "photo" => $urlImages,
    ];
    if ($url) {
      $params["reply_markup"] = $this->addKeyboad($keyboardMsg, $url);
    }
    $this->send($params, "/sendPhoto");
    return $this;
  }

  public function sendSticker($sticker)
  {
    $params = ["chat_id" => $this->chatId, "sticker" => $sticker];
    $this->send($params, "/sendSticker");
    return $this;
  }

  private function send($params, $typeMsg)
  {
    try {
      $ch = curl_init();
      curl_setopt_array($ch, [
        CURLOPT_URL => $this->url . $this->token . $typeMsg,
        CURLOPT_POST => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 10,
        CURLOPT_POSTFIELDS => $params,
      ]);
      curl_exec($ch);
      curl_close($ch);
    } catch (\Exception $e) {
      $this->exceptionError($e);
    }
  }

  private static function exceptionError($error = "Error")
  {
    static::create("365047507")->sendMsg($error);
  }

  private function addKeyboad($textBtn, $url = false)
  {
    return json_encode([
      "inline_keyboard" => [[["text" => $textBtn, "url" => $url]]],
    ]);
  }

  public function setChatId(string $chatId)
  {
    $this->chatId = $chatId;

    return $this;
  }
}
