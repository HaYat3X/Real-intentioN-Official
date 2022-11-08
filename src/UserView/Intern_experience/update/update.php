<?php

session_start();

// クラスファイルインポート
require __DIR__ . '../../../../../class/Logic.php';

// functionファイルインポート
require __DIR__ . '../../../../../function/functions.php';

// オブジェクト
$obj = new PostLogic();

// ログインチェック
$login_check = $obj::login_check();

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

    // SQL発行
    $sql = 'UPDATE `intern_table` SET `user_id`=?, `company`=?, `format`=?, `content`=?, `question`=?,`answer`=?, `ster`=?, `field`=? WHERE id=?';

    // 更新するデータを配列に格納
    $arr = [];
    $arr[] = $_POST['user_id'];
    $arr[] = $_POST['company'];
    $arr[] = $_POST['format'];
    $arr[] = $_POST['content'];
    $arr[] = $_POST['question'];
    $arr[] = $_POST['answer'];
    $arr[] = $_POST['ster'];
    $arr[] = $_POST['field'];
    $arr[] = $_POST['post_id'];

    // 編集するメソッド実行
    $update = $obj::post_update($sql, $arr);

    // 返り値がFalseの場合リダイレクト 配列でメッセージ
    if (!$update) {
        $err[] = '編集に失敗しました。やり直してください。';
        header('refresh:3;url=../view.php');
    };
} else {
    // postリクエストがない場合リダイレクト
    header('Location: ../view.php');
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
                        <?php if (count($err) > 0) : ?>
                            <?php foreach ($err as $e) : ?>
                                <label><?php h($e); ?></label>
                                <div class="backBtn">
                                    <a href="../view.php">戻る</a>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        <?php if (count($err) === 0) : ?>
                            <label>更新が完了しました。</label>
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