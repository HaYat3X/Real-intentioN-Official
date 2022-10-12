<?php

// セッションスタート
session_start();

$err = [];

// セッション情報があるか判定をする
if (!isset($_SESSION['email'])) {
    $_SESSION['err'] = '不正なリクエストです';
    header('Location: auth_form.php');
}

$auth_token = $_SESSION['auth_token'];

$email = $_SESSION['email'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_input = filter_input(INPUT_POST, 'token');
    $int_token = intval($user_input);

    if ($auth_token === $int_token) {
        // セッションに値を入れる
        // 学生情報入力ページに飛ばす
        $_SESSION['access_token'] = $int_token;
        $_SESSION['email'] = $email;
        header('Location: student_information_form.php');
        echo '認証に成功しました';
    } else {
        $err[] = '認証に失敗しました';
    }
}

if (count($err) > 0) {
    // エラー出力
    foreach ($err as $e) {
        echo $e;
    }
}

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
    <form action="./token.php" method="post">
        トークン<input type="text" name="token">
        <button type="submit">認証</button>
    </form>
</body>

</html>