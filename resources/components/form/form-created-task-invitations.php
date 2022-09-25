<form action="/api/created-task-invitations" method="POST">
  <label for="channel">
    Ссылка на группу:
  </label>
  <input class="form-control" placeholder="https://t.me/link_group" type="text" name="channel" id="channel">
  <label for="users">
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