<div class="col-6">
  <form action="/api/parser-channel" method="POST">
    <label for="channel">
      Ссылка на группу:
    </label>
    <input class="form-control" placeholder="https://t.me/link_group" type="text" name="channel" id="channel">
    <label for="userId">
      ID аккаунта, кому отправить результат (можно узнать <a href="https://t.me/getmyid_bot" target="__blank">тут</a>):
    </label>
    <input class="form-control" placeholder="123456788" type="text" name="userId" id="userId">
    <button class="btn border mt-2 btn-outline-secondary" type="submit">Отправить</button>
  </form>
</div>