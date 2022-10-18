<?php

session_start();

// インターンロジックファイルの読み込み
require '/Applications/MAMP/htdocs/Deliverables3/class/InternLogic.php';

// ログインチェック
$result = InternLogic::loginCheck();

// ログインチェックの返り値がfalseの場合ログインページにリダイレクト
if (!$result) {
    header('Location: ../login/login_form.php');
}

// フォームの値を受け取る


?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

</body>

</html>