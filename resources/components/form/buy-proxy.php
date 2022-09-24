<div class="proxy li col-6">
  <h2 class="fs-2">Купить прокси</h2>
  <form class="row g-3 px-1" action="/api/buy-proxy" method="POST">
    <label for="country">
      Страна:
    </label>
    <div class="input-group mb-1">
      <select class="form-select" name="country" id="country">
        <option value="ru">Россия</option>
        <option value="de">Германия</option>
        <option value="nl">Нидерланды</option>
        <option value="sg">Сингапур</option>
        <option value="fr">Франция</option>
        <option value="us">США</option>
      </select>
    </div>
    <label for="count">
      Количество:
    </label>
    <input class="form-control" type="number" name="count" id="count">
    <label for="period">
      Период:
    </label>
    <div class="input-group mb-1">
      <select class="form-select" name="period" id="period">
        <option value="3">3</option>
        <option value="7">7</option>
        <option value="14">14</option>
        <option value="30">30</option>
        <option value="60">60</option>
        <option value="90">90</option>
      </select>
    </div>
    <button class="btn border btn-outline-secondary" type="submit">Купить</button>
  </form>
</div>