<?php
session_start();


// $err = $_SESSION['err'];

// if (isset($err)) {

//     echo '不正なリクエストです';
// }

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>「Real intentioN」 / 新規会員登録</title>
    <link rel="icon" href="../../../public/img/favicon.ico">
    <link rel="stylesheet" href="../../../public/css/register/auth_form.css">
</head>

<body>
    <!-- ヘッダーテンプレート -->
    <?php include '/Applications/MAMP/htdocs/Deliverables3/public/template/header.html'; ?>

    <div class="authContent">
        <h2>新規会員登録</h2>
        <form action="./auth.php" method="post">
            <p><span>必須</span><label>メールアドレス</label><input type="text" name="email" required></p>
            <button type="submit">認証する</button>
        </form>
    </div>
</body>

</html>