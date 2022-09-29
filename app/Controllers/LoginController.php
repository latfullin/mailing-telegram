<?php

namespace App\Controllers;

use App\Helpers\ArgumentsHelpers;
use App\Models\UsersModel;

class LoginController
{
  public function login(ArgumentsHelpers $argument, UsersModel $users)
  {
    $user = $users->where(['login' => $argument->login])->first();
    if ($user) {
      $validate = password_verify($argument->password, $user['password']);
      if ($validate) {
        $_SESSION['auth'] = true;
        $_SESSION['is_admin'] = boolval($user['admin']);
        return response('Success')->header('Location: /');
      }
      return response('Wrong password');
    }
    return response('Not found users');
  }

  public function logout()
  {
    session_destroy();
    return response('Logout')->header('Location: /login');
  }
}
