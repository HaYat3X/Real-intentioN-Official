<?php

session_start();

// ユーザロジックファイルの読み込み
require '/Applications/MAMP/htdocs/Deliverables3/class/userLogic.php';

// ログインチェック
$result = UserLogic::loginCheck();

// ログインチェックの返り値がfalseの場合ログインページにリダイレクト
if (!$result) {
    header('Location: ../login/login_form.php');
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>「Real intentioN」 / インターン体験記</title>
</head>

<body>
    <p>ああ</p>
</body>

</html>