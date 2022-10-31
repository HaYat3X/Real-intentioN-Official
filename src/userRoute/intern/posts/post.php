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

$err = [];

// ログインチェックの返り値がfalseの場合ログインページにリダイレクト
if (!$login_check) {
    header('Location: ../login/login_form.php');
}

// ユーザID取得
foreach ($login_check as $row) {
    $userId = $row['id'];
}


// POSTリクエストを受け取る
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 投稿するメソッド
    $insert = $obj::insertInternDate($_POST);

    // 返り値がFalseの場合リダイレクト 配列でメッセージ
    if (!$insert) {
        $err[] = '投稿に失敗しました。やり直してください。';
        header('refresh:3;url=./post_form.php');
    };
} else {
    // postリクエストがない場合リダイレクト
    header('Location: ./post_form.php');
}


?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>「Real intentioN」 / インターン体験記</title>
    <!-- font-awesomeのインポート -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <link rel="stylesheet" href="../../../../public/css/register/auth.css">
</head>

<body>
    <?php include '/Applications/MAMP/htdocs/Deliverables3/public/template/header.html'; ?>

    <div class="err">
        <?php if (count($err) > 0) : ?>
            <?php foreach ($err as $e) : ?>
                <label><?php h($e); ?></label>
                <div class="backBtn">
                    <a href="./post_form.php">戻る</a>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php if (count($err) === 0) : ?>
            <label>投稿が完了しました。</label>
            <?php header('refresh:3;url=../view.php'); ?>
        <?php endif; ?>
    </div>
</body>

</html>