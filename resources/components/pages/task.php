  <table class="table">
    <thead>
      <tr>
        <th scope="col">Task</th>
        <th scope="col">Type</th>
        <th scope="col">Information</th>
        <th scope="col">File</th>
        <th scope="col">Status</th>
      </tr>
    </thead>
    <tbody>
      <? foreach($this->data['task'] as $task)  :?>
        <tr>
          <th scope="row"><?= $task['task'] ?></th>
          <td><?= $task['type'] ?></td>
          <td>
            <?= $task['information']->msg ?? '' ?>
          </td>
          <td>
            <?= $task['information']->file ?? 'false' ?>
          </td>
          <td><?= $task['status'] ?></td>
        </tr>
        <? endforeach ?>
      </tbody>
    </table>