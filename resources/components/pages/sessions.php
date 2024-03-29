<table class="table">
  <thead>
    <tr>
      <th scope="col">Номер</th>
      <th scope="col">Тип</th>
      <th scope="col">Последняя активность</th>
      <th scope="col">Блокировка</th>
      <th scope="col">Проверка</th>
    </tr>
  </thead>
  <tbody>
    <?

use App\Helpers\Enum\EnumStatusPhone;

 foreach ($this->data['phones'] as $phone) : ?>
      <tr>
        <th scope="row"><?= $phone->phone ?></th>
        <td><?= EnumStatusPhone::getValue($phone->status) ?></td>
        <td>
          <?= $phone->updated_at ?? 'No data' ?>
        </td>
        <td>
          <?= EnumStatusPhone::getValue($phone->ban) ?>
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