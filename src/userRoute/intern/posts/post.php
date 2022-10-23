<?php

session_start();

// インターンロジックファイルの読み込み
require '/Applications/MAMP/htdocs/Deliverables3/class/InternLogic.php';

// オブジェクト
$obj = new InternLogic;

// ログインチェックメソッド
$result = $obj::loginCheck();

// ログインチェックの返り値がfalseの場合ログインページにリダイレクト
if (!$result) {
    header('Location: ../login/login_form.php');
}

// POSTリクエストを受け取る
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 投稿するメソッド
    $insert = $obj::insertInternDate($_POST);

    // 返り値がTrueの場合
    if ($insert) {
        $noErr = [];
        $noErr[] = '投稿しました。';
        header('refresh:3;url=../view.php');
    }

    // 返り値がFalseの場合リダイレクト
    if (!$insert) {
        header('Location: ./post_form.php');
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
        <?php foreach ($noErr as $ok) : ?>
            <label><?php echo $ok; ?></label>
        <?php endforeach; ?>
    </div>
</body>

</html>