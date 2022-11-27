<?php
session_start();

require '../../../class/csrf_calc.php';
require '../../../function/functions.php';

$csrf_calc = new CsrfToken();

// フォームリクエストがあるかないか判定する
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrf_token = filter_input(INPUT_POST, 'csrf_token');

    // csrfトークンの存在確認と正誤判定
} else {
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    TestCase
</body>

</html>