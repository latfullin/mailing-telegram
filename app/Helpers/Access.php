<?php

namespace App\Helpers;

use App\Models\MenuModel;

class Access
{
  public mixed $menu = null;

  public function __construct()
  {
  }

  public function handle(MenuModel $menu)
  {
    if (Cache::issetCache('menu')) {
      $this->__unserialize(Cache::unserialize('menu'));
    } else {
      $this->menu = $menu->get();
    }
    $page = strtok($_SERVER['REQUEST_URI'], '?');
    $lvlAccess = session()->getAccess();

    $bool = $this->checkAccess($page, $lvlAccess);
    if (!$bool) {
      response('Error')->redirect('/404');
    }
  }

  public function __unserialize($data)
  {
    foreach ($data as $key => $value) {
      $this->$key = $value;
    }
  }

  public function checkAccess($page, $lvlAccess): bool
  {
    $item = array_filter($this->menu, function ($item) use ($page, $lvlAccess) {
      if ($item->link !== $page) {
        return false;
      }
      if ($item->need_level_access <= $lvlAccess) {
        return true;
      }
    });

    if ($item) {
      return true;
    } else {
      return false;
    }
  }
}
