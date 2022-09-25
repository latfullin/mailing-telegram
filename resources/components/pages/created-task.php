<label for="type">
  Тип задания:
</label>
<div class="input-group mb-1">
  <select class="form-select" id="type">
    <option value="send_message">Рассылка сообщений</option>
    <option value="invitations_channel">Инвайтинг</option>
  </select>
</div>

<div class="">
  <? include_once "{$_SERVER['DOCUMENT_ROOT']}/resources/components/form/form-created-task-mailing.php" ?>
</div>
<div class="">
  <? include_once "{$_SERVER['DOCUMENT_ROOT']}/resources/components/form/form-created-task-invitations.php" ?>
</div>