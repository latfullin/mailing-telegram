<?php

namespace App\View\Components\Menu;

use App\Helpers\Cache;
use App\Models\MenuModel;

class Menu
{
  public $menu = null;
  private string $cacheMenu = 'menu';

  public function __construct(MenuModel $menuModel)
  {
    if (Cache::issetCache($this->cacheMenu)) {
      $this->unserialize();
    } else {
      $this->menu = $menuModel->get();
    }
  }

  public function __serialize()
  {
    Cache::serialize($this->cacheMenu, $this);
  }

  public function unserialize()
  {
    $data = Cache::unserialize($this->cacheMenu);
    foreach ($data as $key => $value) {
      $this->$key = $value;
    }
  }

  public function __destruct()
  {
    $this->__serialize();
  }

  public function getMenu()
  {
    $access = session()->getAccess();
    $auth = session()->getAuth();
    $menu = array_filter($this->menu, function ($i) use ($auth, $access) {
      if ($auth === boolval($i->authorization)) {
        if ($access >= $i->need_level_access) {
          return true;
        }
      }
    });

    return $menu;
  }
}
