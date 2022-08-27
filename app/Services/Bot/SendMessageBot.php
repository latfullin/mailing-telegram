<?php

namespace App\Services\Bot;

/** 
 * @param $typeMsg, default = /sendMessage; 
 * @param myid 365047507
 */

class SendMessageBot
{
  protected $url = 'https://api.telegram.org/bot';
  private $chat_id;
  private $token = '5425154420:AAF_bDkwaXo-OcoA6bZlXHVeE1vQkurzT5Q';

  private function __construct($chat_id)
  {
    $this->chat_id = $chat_id;
  }

  public static function create($chat_id)
  {
    return new self($chat_id);
  }

  public function sendMsg($msg, $keyboardMsg = false, $url = false)
  {
    try {
      $params = ['chat_id' => $this->chat_id, 'text' => $msg];
      if ($keyboardMsg) {
        $params['reply_markup'] = $this->addKeyboad($keyboardMsg, $url);
      }

      $this->send($params, '/sendMessage');
      return $this;
    } catch (\Exception $e) {
      $this->exceptionError($e);
    }
  }

  public function sendFile(string $path)
  {
    if (is_file($path)) {
      try {
        $params = ['chat_id' => $this->chat_id, 'document' => $path];
        $this->send($params, '/sendDocument');
      } catch (\Exception $e) {
        print_r($e);
      }
    }
    return false;
  }

  public function photo($msg, $urlImages = '', $url = false,  $keyboardMsg = "")
  {
    $params =  [
      'chat_id' => $this->chat_id,
      'caption' => $msg, 'photo' => $urlImages
    ];
    if ($url) {
      $params['reply_markup'] = $this->addKeyboad($keyboardMsg, $url);
    }
    $this->send($params, '/sendPhoto');
    return $this;
  }

  public function sticker($sticker)
  {
    $params = ['chat_id' => $this->chat_id, 'sticker' => $sticker];
    $this->send($params, '/sendSticker');
    return $this;
  }

  private function send($params, $typeMsg)
  {
    try {
      $ch = curl_init();
      curl_setopt_array(
        $ch,
        [
          CURLOPT_URL => $this->url . $this->token . $typeMsg,
          CURLOPT_POST => TRUE,
          CURLOPT_RETURNTRANSFER => TRUE,
          CURLOPT_TIMEOUT => 10,
          CURLOPT_POSTFIELDS => $params
        ]
      );
      curl_exec($ch);
      curl_close($ch);
    } catch (\Exception $e) {
      $this->exceptionError($e);
    }
  }

  private static function exceptionError($error = 'Error')
  {
    static::create('365047507')->sendMsg($error);
  }

  private function addKeyboad($textBtn, $url = false)
  {
    return json_encode(array('inline_keyboard' => [
      [
        ['text' => $textBtn, 'url' => $url]
      ]
    ]));
  }
}
