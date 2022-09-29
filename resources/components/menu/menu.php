<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="/">Navbar</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDarkDropdown" aria-controls="navbarNavDarkDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDarkDropdown">
      <ul class="navbar-nav">
        <? if ($this->data['session']['auth'] === true ?? false) : ?>
          <li class="nav-item">
            <a class="nav-link" href="/send-message" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Написать сообщение
            </a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="/proxy" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Прокси
            </a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="/task" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Задания
            </a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="/created-task" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Создать задание
            </a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="/parsing" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Парсинг
            </a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="/sessions" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Сессии
            </a>
          </li>
        <? else : ?>
          <li class="nav-item ">
            <a class="nav-link" href="/" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Логин
            </a>
          </li>
        <? endif ?>
      </ul>
    </div>
    <? if ($this->data['session']['auth'] === true ?? false) :?>
    <div class="col-1">
      <form action="/api/logout" method="POST">
        <button class="btn btn-secondary" type="submit">Выход</button>
      </form>
    </div>
    <?endif?>
</nav>