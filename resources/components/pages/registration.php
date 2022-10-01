<form action="/api/registration" method="POST">
  <label for="login">
    Логин
  </label>
  <input class="form-control" type="text" name="login" id="login">
  <label for="name">
    Имя
  </label>
  <input class="form-control" type="text" name="name" id="name">
  <label for="password">
    Пароль
  </label>
  <input class="form-control" type="password" name="password" id="password">
  <label for="doublePassword">
    Повторите пароль
  </label>
  <input class="form-control" type="password" name="doublePassword" id="doublePassword">
  <button class="btn btn-outline-secondary mt-2" type="submit">Регистрация</button>
</form>