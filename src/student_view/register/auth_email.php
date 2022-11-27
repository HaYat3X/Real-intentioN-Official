<?php

session_start();

require '../../../class/Session_calc.php';
require '../../../function/functions.php';
require '../../../class/Validation_calc.php';

$val_calc = new ValidationCheck("");
$ses_calc = new Session();

$err_array = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email');
    $user_input_token = filter_input(INPUT_POST, 'token');
    $email_token = filter_input(INPUT_POST, 'email_token');
    $csrf_token = filter_input(INPUT_POST, 'csrf_token');

    // csrfトークンの存在確認と正誤判定
    $csrf_check = $ses_calc->csrf_match_check($csrf_token);
    if (!$csrf_check) {
        $uri = '/Deliverables4/src/' . basename('400_request.php');
        header('Location:' . $uri);
    }

    // バリデーションチェック
    $val_check_arr[] = strval($user_input_token);
    if (!$val_calc->not_yet_entered($val_check_arr)) {
        $err_array[] = $val_calc->getErrorMsg();
    }


    if ($email_token !== $user_input_token) {
        $err_array[] = '認証コードが間違っています。';
    }

    // // セッション消去
    // $ses_calc->email_token_unset();
    // csrf_token削除　二重送信対策
    $ses_calc->csrf_token_unset();
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
    <?php if (count($err_array) > 0) : ?>
        <?php foreach ($err_array as $err_msg) : ?>
            <p class="fw-bold" style="color: red;"><?php h($err_msg); ?></p>
        <?php endforeach; ?>
        <a class="btn btn-primary px-4" href="./auth_email_form.php">戻る</a>
    <?php endif; ?>

    <?php if (count($err_array) === 0) : ?>
        <p class="fw-bold">メールアドレスに認証トークンを送信しました。</p>
        <?php $uri = './auth_email_form.php?email=' . $email ?>
        <?php header('refresh:3;url=' . $uri); ?>
    <?php endif; ?>
</body>

</html>