<?php

namespace App\Controllers;

use App\Helpers\ArgumentsHelpers;
use App\Models\ProxyModel;
use App\Services\Proxy\Ipv6Proxy;
use Carbon\Carbon;

/**
 * Max 3 request in 1 second. If request > 3, then return error 503.
 */
class ProxyController
{
  public function checkProxy(Ipv6Proxy $proxy, ProxyModel $model)
  {
    $proxies = $proxy->getProxy();
    foreach ($proxies->list as $proxy) {
      $data = $model
        ->where([
          "numeric_id" => $proxy->id,
          "active_ad" => $proxy->date_end,
        ])
        ->first();
      if (empty($data)) {
        $model->insert([
          "country" => $proxy->country,
          "address" => $proxy->host,
          "port" => $proxy->port,
          "login" => $proxy->user,
          "password" => $proxy->pass,
          "numeric_id" => $proxy->id,
          "active" => $proxy->active,
          "active_ad" => $proxy->date_end,
          "active" => $proxy->active,
        ]);
      }
    }
  }

  public function buyProxy(
    ArgumentsHelpers $arguments,
    Ipv6Proxy $ipv6,
    ProxyModel $model
  ) {
    $data = $ipv6->buyHttpProxy(
      $arguments->count,
      $arguments->period,
      $arguments->country
    );
    if ($data) {
      foreach ($data->list as $proxy) {
        $model->insert([
          "country" => $arguments->country,
          "address" => $proxy->host,
          "port" => $proxy->port,
          "login" => $proxy->user,
          "password" => $proxy->pass,
          "numeric_id" => $proxy->id,
          "active" => $proxy->active,
          "active_ad" => Carbon::now()->addDays($arguments->period),
        ]);
      }
    }
  }

  public function checkActiveProxy(ProxyModel $model)
  {
    $proxies = $model->get();
    foreach ($proxies as $proxy) {
      if ($proxy->active_ad < Carbon::now()) {
        $model
          ->where(["numeric_id" => $proxy->numeric_id])
          ->update(["active" => 0]);
      } else {
        $model
          ->where(["numeric_id" => $proxy->numeric_id])
          ->update(["active" => 1]);
      }
    }
  }
}
