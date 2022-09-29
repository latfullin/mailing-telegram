<div class="col">
  <? if ($this->data['session']['auth'] === false) : ?>
    <form class="col-6" action="/api/login" method="POST">
      <label for="login">
        Логин
      </label>
      <input class="form-control" type="text" name="login" id="login">
      <label for="password">
        Пароль
      </label>
      <input class="form-control" type="password" name="password" id="password">
      <button class="btn btn-outline-secondary mt-2" type="submit">Войти</button>
    </form>
  <? endif ?>
</div>