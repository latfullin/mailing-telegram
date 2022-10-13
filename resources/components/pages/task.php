<table class="table">
  <thead>
    <tr>
      <th scope="col">Task</th>
      <th scope="col">Тип</th>
      <th scope="col">Информация</th>
      <th scope="col">Статус</th>
      <th scope="col">Запустить</th>
    </tr>
  </thead>
  <tbody>
    <?

use App\Helpers\Enum\EnumStatusTask;

 foreach ($this->data['task'] as $task) : ?>
      <tr>
        <th scope="row"><?= $task['task'] ?></th>
        <td><?= $task['type'] ?></td>
        <td>
          <?= $task['information']->msg ?? '' ?>
        </td>

        <td class="col-2"><?= EnumStatusTask::getValue($task['status']) ?></td>
        <? if ($task['status'] <= 1) : ?>
          <td>
            <form action="/api/continue-task" method="post">
              <input type="hidden" name="task" value="<?= $task['task'] ?>">
              <button class="btn btn-outline-secondary" type="submit">Запустить</button>
            </form>
          </td>
        <? endif ?>
      </tr>
    <? endforeach ?>
  </tbody>
</table>