<?php

session_start();

// 値の受け取り
$email = filter_input(INPUT_POST, 'email');
$password = filter_input(INPUT_POST, 'password');

// エラー配列
$err = [];

// ユーザロジックファイルの読み込み
require '/Applications/MAMP/htdocs/Deliverables3/class/userLogic.php';

$result = UserLogic::login($email, $password);

if (!$result) {
    $err[] = 'ログインに失敗しました。';
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../../public/img/favicon.ico">
    <link rel="stylesheet" href="../../../public/css/login/login.css">
    <title>「Real intentioN」 / ログイン</title>
</head>

<body>
    <?php include '/Applications/MAMP/htdocs/Deliverables3/public/template/header.html'; ?>

    <div class="err">
        <?php if (count($err) > 0) : ?>
            <?php foreach ($err as $e) : ?>
                <label><?php echo $e; ?></label>
                <div class="backBtn">
                    <a href="./login_form.php">戻る</a>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php if (count($err) === 0) : ?>
            <label>ログインに成功しました。</label>
            <!-- <div class="backBtn">
                <a href="../intern/view.php">ホームへ</a>
            </div> -->
            <?php header('refresh:3;url=../intern/view.php'); ?>
        <?php endif; ?>
    </div>
</body>

</html>