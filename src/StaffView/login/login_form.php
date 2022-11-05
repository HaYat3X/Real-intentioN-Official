<?php

session_start();

// functionファイルインポート
require __DIR__ . '../../../../function/functions.php';

// // ログインしている場合にはログインフォームを表示させない
// $result = UserLogic::checkLogin();
// if ($result) {
//     header('Location: mypage.php');
//     return;
// }



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
    <form action="./login.php" method="post">
        <p><label>メールアドレス</label><input type="text" name="email"></p>

        <p><label>パスワード</label><input type="password" name="password"></p>


        <button type="submit">ログイン</button>
    </form>
</body>

</html>