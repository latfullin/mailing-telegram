<?php

namespace App\Controllers;

use App\Helpers\ArgumentsHelpers;
use App\Models\AuthHistoryModel;
use App\Models\UsersModel;
use App\Services\Bot\TelegramBot;

class LoginController
{
  public function login(ArgumentsHelpers $argument, UsersModel $users, AuthHistoryModel $auth)
  {
    @$auth->insert([
      'ip' => $_SERVER['REMOTE_ADDR'] ?? null,
      'login' => $argument->login,
      'url_referer' => $_SERVER['HTTP_REFERER'],
      'action' => 'login',
    ]);
    $user = $users->where(['login' => $argument->login])->first();
    if ($user) {
      $validate = password_verify($argument->password, $user['password']);
      if ($validate) {
        $_SESSION['auth'] = true;
        $_SESSION['login'] = $user['login'];
        $_SESSION['is_admin'] = boolval($user['admin']);
        $_SESSION['access'] = $user['access'];
        return response('Success')->header('Location: /');
      }
      return response('Wrong password');
    }
    return response('Not found users');
  }

  public function logout(AuthHistoryModel $auth, TelegramBot $bot)
  {
    @$auth->insert([
      'ip' => $_SERVER['REMOTE_ADDR'] ?? null,
      'login' => $_SESSION['login'],
      'url_referer' => $_SERVER['HTTP_REFERER'],
      'action' => 'logout',
    ]);
    try {
      session_destroy();
      return response('Logout')->header('Location: /login');
    } catch (\Exception $e) {
      $bot::exceptionError($e->getMessage());
      return response('Undefined error');
    }
  }

  public function registration(ArgumentsHelpers $argument, UsersModel $users)
  {
    $user = $users->where(['login' => $argument->login])->first();

    if (empty($user)) {
      if ($argument->password === $argument->doublePassword) {
        try {
          $users->insert([
            'login' => $argument->login,
            'password' => password_hash($argument->password, PASSWORD_BCRYPT),
            'name' => $argument?->name,
          ]);
        } catch (\Exception $e) {
          \App\Services\Bot\TelegramBot::exceptionError($e->getMessage());
          return response(
            'Happened exception. Please, send this message in telegram, link - https://t.me/@hitThat',
            status: 404,
          );
        }
        return response('Success');
      } else {
        return response('Passwords do not match');
      }
    } else {
      return response('This login exists');
    }
  }
}
