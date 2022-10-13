<div class="px-2">
  <h2 class="fs-2">Написать сообщение</h2>
  <form class="col-3 py-1 send-messages" >
    <div class="mb-1">
      <label class="form-label" for='phone'>
        Номер телефона сессии
      </label>
      <input class="form-control" required type="text" name="phone" id="phone">
    </div>
    <div class="mb-1">
      <label class="form-label" for='phone'>
        Кому:
      </label>
      <input class="form-control" required type="text" name="how" id="">
    </div>
    <div class="mb-2">
      <label class="form-label" for='phone'>
        Сообщение:
      </label>
      <textarea class="form-control" placeholder="Минимальное количество символов 15, максимум 1300" required type="text" name="msg" id=""></textarea>
    </div>
    <button class="btn border btn-outline-secondary" type="submit">Отправить</button>
  </form>
</div>