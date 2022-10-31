<?php

session_start();

// クラスファイルインポート
require __DIR__ . '../../../../../class/InternLogic.php';

// functionファイルインポート
require __DIR__ . '../../../../../function/functions.php';

// オブジェクト
$obj = new InternLogic;

// ログインチェック
$login_check = $obj::loginCheck();

// ログインチェックの返り値がfalseの場合ログインページにリダイレクト
if (!$login_check) {
    header('Location: ../../login/login_form.php');
}

// ユーザID取得
foreach ($login_check as $row) {
    $userId = $row['id'];
}

// 編集する投稿データの取得
$update_id = filter_input(INPUT_GET, 'post_id');

// 編集するデータを取得する
$update_date = $obj::selectInternOneDate($update_id);

// 投稿者IDとログイン中のユーザのIDが一致しなければ編集できないように

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
    <form action="" method="post"></form>
</body>

</html>