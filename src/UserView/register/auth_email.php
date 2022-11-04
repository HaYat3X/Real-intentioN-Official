<?php

// セッション有効期限
// ini_set('session.gc_maxlifetime', 60);
session_start();

// クラスファイルインポート
require __DIR__ . '../../../../class/Logic.php';

// functionファイルインポート
require __DIR__ . '../../../../function/functions.php';

// err配列
$err = [];

// フォームリクエストを受け取る
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // バリーデーションチェック
    if (!$form_token = filter_input(INPUT_POST, 'token')) {
        $err[] =  'トークンを入力してください。';
    }

    $email = filter_input(INPUT_POST, 'email');

    if ($_SESSION['token'] == $form_token) {
        $success = '認証に成功しました。';
    } else {
        $err[] = 'トークンが一致しません。';
    }
} else {
    $err[] = '不正なリクエストです。';
    header('refresh:3;url=./tentative_register_form.php');
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
    <?php if (count($err) > 0) : ?>
        <?php foreach ($err as $e) : ?>
            <p><label><?php h($e); ?></label></p>
        <?php endforeach; ?>
    <?php endif; ?>

    <?php if (count($err) === 0) : ?>
        <p><label><?php h($success); ?></label></p>
        <p><a href="./full_registration_form.php?key=<?php h($email) ?>">学生情報入力ページへ</a></p>
    <?php endif; ?>
</body>

</html>