<?php
session_start();

require '../../../class/Csrf_calc.php';
require '../../../function/functions.php';

$csrf_calc = new CsrfToken();

// フォームリクエストがあるかないか判定する
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // フォームで送信したリクエストを受け取る
    $csrf_token = filter_input(INPUT_POST, 'csrf_token');
    $email = filter_input(INPUT_POST, 'csrf_token');

    // csrfトークンの存在確認と正誤判定
    $csrf_check = $csrf_calc->csrf_match_check($csrf_token);

    if (!$csrf_check) {
        $uri = '/Deliverables4/src/400_request.php';
        header('Location:' . $uri);
    }

    // バリデーションチェック
} else {
    $uri = '/Deliverables4/src/400_request.php';
    header('Location:' . $uri);
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