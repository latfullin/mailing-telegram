<?php

namespace App\Services\Proxy;

use App\Helpers\ErrorHelper;
use stdClass;

class Ipv6Proxy
{
  private $token = "4b8a62b100-8dbba6003d-dfa0f56cac";
  private $url = "https://proxy6.net/api";
  private string $method;
  private int $version = 6;
  private $proxy;
  private array $methodsList = [
    "getProxy",
    "delete",
    "buy",
    "prolong",
    "getcount",
    "getcountry",
  ];
  private array $variablesPeriod = [3, 7, 14, 30, 60, 90];
  private array $variablesCountry = [
    "Russia" => "ru",
    "Germany" => "de",
    "Nederland" => "nl",
    "France" => "fr",
    "Singapore" => "sg",
    "UnitedStates" => "us",
  ];

  public function __construct()
  {
  }

  public static function init()
  {
    return new self();
  }

  /**
   * @param state 'active' => 'active', 'expired' => 'inactive', 'expiring' => 'ends', 'all' => 'all'
   */
  public function getProxy(string $state = "active"): array|stdClass
  {
    $params = ["state" => $state, "nokey" => ""];

    $this->get($params, "getproxy");

    return $this->proxy;
  }

  private function get(array $params, string $method): void
  {
    if ($this->validateParams($params)) {
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
  }

  public function setMethod(string $method): self
  {
    try {
      if (array_search($method, $this->methodsList)) {
        $this->method = $method;

        return $this;
      }
      throw new \Exception("Not found method");
    } catch (\Exception $e) {
      ErrorHelper::writeToFile($e->getMessage());
    }
  }

  /**
   * @param country need country format ISO 3166
   */
  public function buyHttpProxy(
    int $count,
    int $period,
    string $country
  ): array|stdClass {
    $params = [
      "count" => $count,
      "period" => $period,
      "country" => $country,
      "version" => $this->version,
      "type" => "http",
    ];
    $this->validateParams($params);
    $this->get($params, "buy");
    return $this->proxy;
  }

  public function validateParams($params): bool
  {
    foreach ($params as $key => $param) {
      $array = "variables" . ucfirst($key);
      if ($this->{$array} ?? false) {
        $result = array_search($param, $this->{$array});
        if ($result === false) {
          throw new \Exception(
            "Error values - {$key}. Not found params - $param. Check possible values. https://proxy6.net/developers"
          );
        }
      }
    }

    return true;
  }
}
