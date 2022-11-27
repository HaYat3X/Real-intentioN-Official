<?php
session_start();
// csrf対策
require '../../../class/Csrf_calc.php';
require '../../../function/functions.php';

$csrf_calc = new CsrfToken();

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="./provisional_registration.php" method="post">
        <input type="text" name="email">
        <input type="hidden" name="csrf_token" value="<?php h($csrf_calc->create_csrf_token()); ?>">
        <button type="submit">仮登録する</button>
    </form>
</body>

</html>