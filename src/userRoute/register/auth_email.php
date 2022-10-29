<?php

// セッション有効期限
// ini_set('session.gc_maxlifetime', 60);
session_start();

// クラスファイルインポート
require __DIR__ . '../../../../class/UserLogic.php';

// functionファイルインポート
require __DIR__ . '../../../../function/functions.php';

// err配列
$err = [];
$noErr = [];

// セッションで送信されてきた情報
$token = $_SESSION['token'];
$email = $_SESSION['email'];

// フォームリクエストを受け取る
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form_token = filter_input(INPUT_POST, 'token');

    if ($token == $form_token) {
        $noErr[] = '認証に成功しました。';
    } else {
        $err[] = 'トークンが一致しません。';
    }
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
    <form action="./auth_email.php" method="post">
        <p><label>トークン</label></p>
        <p><input type="text" name="token"></p>
        <button type="submit">認証</button>
    </form>

    <?php if (count($err) > 0) : ?>
        <?php foreach ($err as $e) : ?>
            <p><label><?php h($e); ?></label></p>
        <?php endforeach; ?>
    <?php endif; ?>

    <?php if (count($err) === 0) : ?>
        <?php foreach ($noErr as $success) : ?>
            <p><label><?php h($success); ?></label></p>
            <p><a href="./create_user_form.php">学生情報入力ページへ</a></p>
        <?php endforeach; ?>
    <?php endif; ?>
</body>

</html>