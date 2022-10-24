<form action="/api/created-task-mailing" method="POST">
  <label for="msg">
    Сообщение:
  </label>
  <textarea class="form-control" type="text" name="msg" id="msg"></textarea>
  <label for="period">
    Список пользователей:
  </label>
  <div class="input-group mb-1">
    <div class="form-floating">
      <textarea class="form-control" placeholder="Leave a comment here" name="users" id="users" style="height: 100px"></textarea>
      <label for="floatingTextarea2">Пользователи</label>
    </div>
  </div>
  <button class="btn border btn-outline-secondary" type="submit">Создать</button>
</form>