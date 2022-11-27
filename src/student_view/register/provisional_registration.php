<?php

session_start();

require '../../../class/Csrf_calc.php';
require '../../../class/Validation_calc.php';
require '../../../function/functions.php';

$csrf_calc = new Session();
$val_calc = new ValidationCheck();
$err_array = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // フォームで送信したリクエストを受け取る
    $csrf_token = filter_input(INPUT_POST, 'csrf_token');
    $email = filter_input(INPUT_POST, 'email');

    // csrfトークンの存在確認と正誤判定
    $csrf_check = $csrf_calc->csrf_match_check($csrf_token);
    if (!$csrf_check) {
        $uri = '/Deliverables4/src/' . basename('400_request.php');
        header('Location:' . $uri);
    }

    // バリデーションチェック
    $val_check_arr[] = strval($email);
    if (!$val_calc->not_yet_entered($val_check_arr)) {
        $err_array[] = $val_calc->getErrorMsg();
    }

    if (!$val_calc->not_yet_kic($email)) {
        $err_array[] = $val_calc->getErrorMsg();
    }

    // エラーがない場合メールアドレスにトークン送信

    // csrf_token削除　二重送信対策
    $csrf_calc->csrf_token_unset();
} else {
    $uri = '/Deliverables4/src/' . basename('400_request.php');
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
    <?php if (count($err_array) > 0) : ?>
        <?php foreach ($err_array as $err_msg) : ?>
            <p class="fw-bold" style="color: red;"><?php h($err_msg); ?></p>
        <?php endforeach; ?>
        <a class="btn btn-primary px-4" href="./provisional_registration_form.php">戻る</a>
    <?php endif; ?>

    <?php if (count($err_array) === 0) : ?>
        <p class="fw-bold">メールアドレスに認証トークンを送信しました。</p>
    <?php endif; ?>
    </div>
</body>

</html>