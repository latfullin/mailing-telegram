<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="/">Главная</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDarkDropdown" aria-controls="navbarNavDarkDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDarkDropdown">
      <ul class="navbar-nav">
        <? foreach ($this->data['menu'] ?? [] as $menu) : ?>
          <li class="nav-item">
            <a class="nav-link" href="<?= $menu->link ?>" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <?= $menu->title ?>
            </a>
          </li>
        <? endforeach ?>
      </ul>
    </div>
    <? if ($this->data['session']['auth'] === true ?? false) : ?>
      <div class="col-1">
       Здравствуйте, <? $this->data['session']['name'] ?? '' ?>
      </div>
      <div class="col-1">
        <form action="/api/logout" method="POST">
          <button class="btn btn-secondary" type="submit">Выход</button>
        </form>
      </div>
    <? endif ?>
</nav>