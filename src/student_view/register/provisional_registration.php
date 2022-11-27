<?php

session_start();

require '../../../class/Session_calc.php';
require '../../../class/Validation_calc.php';
require '../../../function/functions.php';
require '../../../class/Register_calc.php';

$ses_calc = new Session();
$val_calc = new ValidationCheck("");
$rgs_calc = new Register();

$err_array = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // フォームで送信したリクエストを受け取る
    $csrf_token = filter_input(INPUT_POST, 'csrf_token');
    $email = filter_input(INPUT_POST, 'email');

    // csrfトークンの存在確認と正誤判定
    $csrf_check = $ses_calc->csrf_match_check($csrf_token);
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

    // メールアドレスが既に登録されているか判定する
    $email_set = $rgs_calc->set_email($email);

    $sql = 'SELECT * FROM Student_Mst WHERE email = ?';

    $registered_check = $rgs_calc->registered_check($sql);

    // 配列が返ってくるということは登録されている
    if ($registered_check) {
        $err_array[] = 'メールアドレスが既に登録されています。';
    }

    if (count($err_array) === 0) {
        // エラーがない場合メールアドレスにトークン送信
        $send_token = $rgs_calc->send_token();
        var_dump($send_token);

        // 送信したトークンをセッションに格納
        $ses_calc->create_email_token($send_token);
    }

    // csrf_token削除　二重送信対策
    $ses_calc->csrf_token_unset();
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
        <?php $uri = './auth_email_form.php?email=' . $email ?>
        <?php header('refresh:3;url=' . $uri); ?>
    <?php endif; ?>
    </div>
</body>

</html>