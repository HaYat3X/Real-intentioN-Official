<?php

session_start();

// クラスファイルインポート
require __DIR__ . '../../../../class/staffLogic.php';

// functionファイルインポート
require __DIR__ . '../../../../function/functions.php';

// オブジェクト
$obj = new StaffLogic;

// // ログインチェック
// $login_check = $obj::loginCheck();

// // ログインチェックの返り値がfalseの場合ログインページにリダイレクト
// if (!$login_check) {
//     header('Location: ../login/login_form.php');
// }

// // ユーザID取得
// foreach ($login_check as $row) {
//     $userId = $row['id'];
// }

// // インターンデータ取得メソッドの読み込み
// $results = $obj::selectInternDate();


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

</body>

</html>