<?php

namespace App\Services\Proxy;

class Ipv6Proxy
{
  private $token = "4b8a62b100-8dbba6003d-dfa0f56cac";
  private $url = "https://proxy6.net/api";
  private string $method;
  private int $version = 6;
  private array $proxy;
  private array $methodsList = [
    "getProxy",
    "delete",
    "buy",
    "prolong",
    "getcount",
    "getcountry",
  ];

  /**
   * @param state 'active' => 'active', 'expired' => 'inactive', 'expiring' => 'ends', 'all' => 'all'
   *  
   */
  public function getProxy(string $state)
  {
    $params = ['state' => 'active']
  }

  public function get(array $params, string $method): void
  {
    $curl = curl_init();
    curl_setopt_array($curl, [
      CURLOPT_URL => "{$this->url}/{$this->token}/{$method}",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_TIMEOUT => 10,
      CURLOPT_POSTFIELDS => $params,
    ]);

    $this->proxy = json_decode(curl_exec($curl));
    curl_close($curl);
  }

  public function setMethod(string $method): self
  {
    if (array_search($method, $this->methodsList)) {
      $this->method = $method;

      return $this;
    }
    return false;
  }
}
