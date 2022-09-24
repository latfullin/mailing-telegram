<form action="/api/created-task-mailing" method="POST">
  <label for="country">
    Тип задания:
  </label>
  <div class="input-group mb-1">
    <select class="form-select" name="country" id="country">
      <option value="send_message">Рассылка сообщений</option>
      <option value="invitations_channel">Инвайтинг</option>
    </select>
  </div>
  <label for="msg">
    Сообщение:
  </label>
  <input class="form-control" type="text" name="msg" id="msg">
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