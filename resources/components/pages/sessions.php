<table class="table">
  <thead>
    <tr>
      <th scope="col">Phone</th>
      <th scope="col">Status</th>
      <th scope="col">Last active</th>
      <th scope="col">Ban</th>
      <th scope="col">Validate</th>
    </tr>
  </thead>
  <tbody>
    <? foreach ($this->data['phones'] as $phone) : ?>
      <tr>
        <th scope="row"><?= $phone->phone ?></th>
        <td><?= $phone->status ?></td>
        <td>
          <?= $phone->updated_at ?? 'No data' ?>
        </td>
        <td>
          <?= $phone->ban ?>
        </td>
        <td>
          <form action="/api/send-message" method="POST">
            <input type="hidden" name="phone" value="<?= $phone->phone ?>">
            <input type="hidden" name="msg" value="Hello. I'm not ban!">
            <input type="hidden" name="how" value="365047507">
            <button class="btn" type="submit">Тест</button>
          </form>
        </td>
      </tr>
    <? endforeach ?>
  </tbody>
</table>