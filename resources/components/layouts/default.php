<!DOCTYPE html>
<html lang="en">

<head>
  <? include_once root("resources/components/head.php") ?>
</head>

<body>
  <head>
    <? include_once root("resources/components/menu/menu.php") ?>
  </head>
    <main>
      <div class="container">
        <? include_once root("resources/components/pages/{$this->data['page']}.php") ?>
      </div>
      <div class="notification"></div>
    </main>
</body>

</html>