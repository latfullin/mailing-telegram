  <div class="col-6 li g-2">
    <h2 class="fs-2 mb-2">Информация о прокси</h2>
      <div class="p-3 mb-2 border bg-light">Количество использованных прокси: <?= $this->data['proxy']['all'] ?></div>
      <div class="p-3 mb-2 border bg-light">Активные прокси: <?= $this->data['proxy']['active'] ?></div>
      <div class="p-3 mb-2 border bg-light">Не используемые прокси: <?= $this->data['proxy']['not_used'] ?></div>
      <? include_once root("resources/components/form/form-check-proxy.php") ?>
  </div>