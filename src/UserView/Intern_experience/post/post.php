<?php

session_start();

// 外部ファイルのインポート
require '../../../../class/Logic.php';
require '../../../../function/functions.php';

// オブジェクト
$object = new SystemLogic();

// ログインチェック
$login_check = $object::login_check_student();

// ログインチェックの返り値がfalseの場合ログインページにリダイレクト
if (!$login_check) {
    header('Location: ../login/login_form.php');
}

// ユーザID取得
foreach ($login_check as $row) {
    $userId = $row['student_id'];
}

$err_array = [];

// POSTリクエストを受け取る
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 投稿するデータをarr処理
    $insert_data = [];
    $insert_data[] = strval($userId);
    $insert_data[] = strval($_POST['company']);
    $insert_data[] = strval($_POST['format']);
    $insert_data[] = strval($_POST['content']);
    $insert_data[] = strval($_POST['question']);
    $insert_data[] = strval($_POST['answer']);
    $insert_data[] = strval($_POST['ster']);
    $insert_data[] = strval($_POST['field']);

    // SQL発行
    $sql = 'INSERT INTO `intern_table`(`user_id`, `company`, `format`, `content`, `question`, `answer`, `ster`, `field`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)';

    // 投稿するメソッド
    $insert = $object::db_insert($sql, $insert_data);

    // 返り値がFalseの場合リダイレクト 配列でメッセージ
    if (!$insert) {
        $err_array[] = '投稿に失敗しました。やり直してください。';
        header('refresh:3;url=./post_form.php');
    };
} else {
    $url = '../../../Incorrect_request.php';
    header('Location:' . $url);
}

?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        body {
            background-color: #e6e6e6;
        }

        .err-msg {
            margin-top: 150px;
            background-color: white;
            padding: 30px 50px;
        }
    </style>
    <title>Document</title>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light py-4">
            <div class="container">
                <a class="navbar-brand" href="#">Real intentioN</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="#">職員の方はこちら</a>
                        </li>
                        <button class="btn btn-primary ms-3">ログインはこちら</button>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <div class="main d-flex align-items-center">
        <div class="container">
            <div class="row">
                <div class="mx-auto col-lg-6">
                    <div class="err-msg">
                        <?php if (count($err_array) > 0) : ?>
                            <?php foreach ($err_array as $err_msg) : ?>
                                <label><?php h($err_msg); ?></label>
                                <div class="backBtn">
                                    <a href="./post_form.php">戻る</a>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        <?php if (count($err_array) === 0) : ?>
                            <label>投稿が完了しました。</label>
                            <?php header('refresh:3;url=../view.php'); ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>