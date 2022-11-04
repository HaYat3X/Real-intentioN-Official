<?php

// セッション有効期限
// ini_set('session.gc_maxlifetime', 60);
session_start();

// functionファイルインポート
require __DIR__ . '../../../../function/functions.php';

// err配列
$err = [];

// セッションで送信されてきた情報
$token = $_SESSION['token'];
$email = $_SESSION['email'];

// セッション情報がなければれダイレクト
if (!$_SESSION) {
    header('Location: ./provisional_registration_form.php');
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

        <input type="hidden" name="email" value="<?php h($email) ?>">
        <button type="submit">認証</button>
    </form>
</body>

</html>