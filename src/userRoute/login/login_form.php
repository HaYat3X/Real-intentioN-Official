<?php

// // セッションスタート
// session_start();

// // セッション情報があるか判定をする
// if (!isset($_SESSION['access_token'])) {
//     $_SESSION['err'] = '不正なリクエストです';
//     header('Location: auth_form.php');
//     exit();
// }

// $email = $_SESSION['email'];

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../../public/img/favicon.ico">
    <link rel="stylesheet" href="../../../public/css/register/student_infomation.css">
    <title>「Real intentioN」 / ログイン</title>
</head>

<body>

    <?php include '/Applications/MAMP/htdocs/Deliverables3/public/template/header.html'; ?>

    <div class="authContent">
        <h2>ログイン</h2>
        <form action="./login.php" method="post">
            <p><span>必須</span><label style="margin-right: 10px;">メールアドレス</label><input type="text" name="email" required></p>

            <p><span>必須</span><label style="margin-right: 48px;">パスワード</label><input type="password" name="password" required></p>
            
            <button type="submit">認証する</button>
        </form>
    </div>
</body>

</html>