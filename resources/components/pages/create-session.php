<div class="row">
  <? if($this->data['proxy'] ?? false) :?>
  <form action="/api/redirect-create-session" method="post">
    <div class="col-6">

      <label for="how">
        Ваш ник в телеграм
      </label>
      <input class="form-control" type="text" placeholder="@hitThat" name="how" id="how">
      <label for="">
        Номер телефона для авторизации
      </label>
      <input class="form-control" type="text" placeholder="7987654321\8987654321" name="phone" id="">
      <button class="btn btn-outline-secondary mt-1" type="submit">Начать</button>
    </div>
    <div class="col-6">
      <h2>Прокси</h2>
      <label for="address">
      address
      </label>
      <input class="form-control mb-1" type="text" value="<?= $this->data['proxy'][
        'address'
      ] ?>" name="address" id="address">
      <label for="port">
        PORT
      </label>
      <input class="form-control mb-1" type="text" value="<?= $this->data['proxy']['port'] ?>" name="port" id="port">
      <label for="login">
        Login
      </label>
      <input class="form-control mb-1" type="text" value="<?= $this->data['proxy']['login'] ?>" name="login" id="login">
      <label for="password">
        Password
      </label>
      <input class="form-control mb-1" type="text" value="<?= $this->data['proxy'][
        'password'
      ] ?>" name="password" id="password">
      <label for="">
        Numeric id
      </label>
      <input class="form-control mb-1" type="text" name="numeric_id" value="<?= $this->data['proxy'][
        'numeric_id'
      ] ?>" id="">
    </div>
  </form>
  <? else :?>
    <div class="col">
      <h2 class="fs-2">
        Необходимо приобрести прокси
      </h2>
    </div>
  <? endif?>
</div>