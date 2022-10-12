<?php

// セッションスタート
session_start();

// セッション情報があるか判定をする
if (!isset($_SESSION['access_token'])) {
    $_SESSION['err'] = '不正なリクエストです';
    header('Location: auth_form.php');
}

$email = $_SESSION['email'];
var_dump($email)

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
    <form action="./student_information.php" method="post">
        <label for=""></label>
    </form>
</body>
</html>