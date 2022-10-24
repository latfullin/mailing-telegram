<label for="type">
  Тип задания:
</label>
<div class="input-group mb-1">
  <select class="form-select" id="created-task">
    <option value="send-message">Рассылка сообщений</option>
    <option value="invitations-channel">Инвайтинг</option>
  </select>
</div>

<div class="created-task">

  <div class="send-message popup-closed">
    <? include_once root("resources/components/form/form-created-task-mailing.php") ?>
</div>
<div class="invitations-channel popup-closed">
  <? include_once root("resources/components/form/form-created-task-invitations.php") ?>
</div>
</div>