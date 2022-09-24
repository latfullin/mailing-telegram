<!DOCTYPE html>
<html lang="en">

<head>
  <? include_once "{$_SERVER['DOCUMENT_ROOT']}/resources/components/head.php" ?>
</head>

<body>
  <head>
    <? include_once "{$_SERVER['DOCUMENT_ROOT']}/resources/components/menu/menu.php" ?>
    <div class="container">
      <? include_once "{$_SERVER['DOCUMENT_ROOT']}/resources/components/pages/{$this->data['page']}.php" ?>
    </div>
  </head>
</body>

</html>