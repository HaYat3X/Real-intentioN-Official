<?php

session_start();

// 外部ファイルのインポート
require '../../../../class/SystemLogic.php';
require '../../../../function/functions.php';

// インスタンス化
$val_inst = new DataValidationLogics();
$arr_prm_inst = new ArrayParamsLogics();
$db_inst = new DatabaseLogics();
$student_inst = new StaffLogics();

// ログインチェック
$userId = $student_inst->get_staff_id();

// ログインチェックの返り値がfalseの場合ログインページにリダイレクト　（不正なリクエストとみなす）
if (!$userId) {
    $url = '../../Incorrect_request.php';
    header('Location:' . $url);
}


$err_array = [];

// POSTリクエストを受け取る
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $type = filter_input(INPUT_POST, 'type');
    $format = filter_input(INPUT_POST, 'format');
    $field = filter_input(INPUT_POST, 'field');
    $time = filter_input(INPUT_POST, 'time');
    $company = filter_input(INPUT_POST, 'company');
    $overview = filter_input(INPUT_POST, 'overview');
    $attachment = filter_input(INPUT_POST, 'attachment');

    $argument = $arr_prm_inst->staff_post_prm($userId, $type, $company, $format, $overview, $field, $time, $attachment);

    // SQL発行
    $sql = 'INSERT INTO `staff_information_table`(`staff_id`, `type`, `company`, `format`, `overview`, `field`, `time`, `attachment`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)';

    // 投稿するメソッド
    $insert = $db_inst->data_various_kinds($sql, $argument);

    // // 返り値がFalseの場合リダイレクト 配列でメッセージ
    // if (!$insert) {
    //     $err_array[] = '投稿に失敗しました。やり直してください。';
    //     header('refresh:3;url=./post_form.php');
    // };
} else {
    $url = '../../../Incorrect_request.php';
    header('Location:' . $url);
}

?>








<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../../public/img/favicon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        body {
            background-color: #EFF5F5;
        }

        header {
            background-color: #D6E4E5;
        }

        footer {
            background-color: #D6E4E5;
        }

        .nav-link {
            font-weight: bold;
        }

        .nav-link:hover {
            text-decoration: underline;
        }

        .login-btn {
            background-color: #EB6440;
            color: white;
        }

        .login-btn:hover {
            color: white;
            background-color: #eb6540c1;
        }

        .box {
            background-color: white;
            border-radius: 5px;
        }
    </style>
    <title>「Real IntentioN」 / ログイン（学生）</title>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light py-4">
            <div class="container">
                <a class="navbar-brand" href="../../../index.html">
                    <img src="../../../public/img/logo.png" alt="" width="30" height="24" class="d-inline-block
                                align-text-top" style="object-fit: cover;">
                    Real intentioN
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="./src/StaffView/login/login_form.php">Real intentioNとは</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="./src/StaffView/login/login_form.php">お問い合わせはこちら</a>
                        </li>
                    </ul>
                </div>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="../../StaffView/login/login_form.php">職員の方はこちら</a>
                        </li>

                        <li class="nav-item">
                            <a class="login-btn btn" href="./login_form.php">ログインはこちら</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main role="main" class="container my-5" style="padding: 0px">
        <div class="row">
            <div class="col-md-8">
                <div class="bg-light">
                    <div class="mx-auto col-lg-8 pt-2 pb-5">
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
                            <?php header('refresh:3;url=../post_list.php'); ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>


            <div class="side-bar col-md-4 bg-light sticky-top h-100">
                <div class="d-flex flex-column flex-shrink-0 p-3 bg-light">
                    <ul class="nav nav-pills flex-column mb-auto">
                        <li class="nav-item">
                            <a style="background-color: #EB6440;" href="./view.php" class="nav-link active" aria-current="page">
                                インターン体験記
                            </a>
                        </li>
                        <li>
                            <a href="../staff_information/staff_information.php" class="nav-link link-dark">
                                インターン / イベント情報 / 説明会情報
                            </a>
                        </li>
                    </ul>

                </div>
            </div>
        </div>
    </main>



    <footer>
        <nav class="navbar navbar-expand-lg navbar-light py-4">
            <div class="container">
                <a class="navbar-brand" href="../../../index.html">
                    <img src="../../../public/img" alt="" width="30" height="24" class="d-inline-block
                                align-text-top" style="object-fit: cover;">
                    Real intentioN
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav2" aria-controls="navbarNav2" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav2">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="./src/StaffView/login/login_form.php">職員の方はこちら</a>
                        </li>

                        <li class="nav-item">
                            <a class="login-btn btn" href="./src/UserView/login/login_form.php">ログインはこちら</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>