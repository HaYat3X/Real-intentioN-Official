<?php

// セッション開始
session_start();

// 外部ファイルのインポート
require_once '../../../../class/Session_calc.php';
require_once '../../../../class/Database_calc.php';
require_once '../../../../class/Register_calc.php';
require_once '../../../../class/Validation_calc.php';
require_once '../../../../function/functions.php';

// インスタンス化
$ses_calc = new Session();
$val_calc = new ValidationCheck();
$rgs_calc = new Register();

// ログインチェック
$student_user_id = $ses_calc->student_login_check();
var_dump($student_user_id);

// ログイン情報がない場合リダイレクト
if (!$student_user_id) {
    $uri = '../../../Exception/400_request.php';
    header('Location: ' . $uri);
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
    てst
</body>

</html>