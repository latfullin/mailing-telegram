  <table class="table">
    <thead>
      <tr>
        <th scope="col">task</th>
        <th scope="col">type</th>
        <th scope="col">information</th>
        <th scope="col">status</th>
      </tr>
    </thead>
    <tbody>
      <? foreach($this->data['task'] as $task)  :?>
        <tr>
          <th scope="row"><?= $task['task'] ?></th>
          <td><?= $task['type'] ?></td>
          <td>
            Сообщение: <br><?= $task['information']->msg ?? '' ?><br>
            File: <br><?= $task['information']->file ?? '' ?>
          </td>
          <td><?= $task['status'] ?></td>
        </tr>
        <? endforeach ?>
      </tbody>
    </table>