<?php

session_start();

// 外部ファイルおインポート
// 外部ファイルのインポート
require '../../../class/SystemLogic.php';
require __DIR__ . '../../../../function/functions.php';

// インスタンス化
$val_inst = new DataValidationLogics();
$arr_prm_inst = new ArrayParamsLogics();
$db_inst = new DatabaseLogics();
$student_inst = new StudentLogics();

// errメッセージが格納される配列を定義
$err_array = [];

// フォームリクエストを受け取る
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = filter_input(INPUT_POST, 'name');
    $email = filter_input(INPUT_POST, 'email');
    $password = filter_input(INPUT_POST, 'password');
    $department = filter_input(INPUT_POST, 'department');
    $school_year = filter_input(INPUT_POST, 'school_year');
    $number = filter_input(INPUT_POST, 'number');

    // バリデーションエラーの画面表示
    if ($val_inst->student_register_full_registration_val($name, $password, $department, $school_year, $number)) {
        $argument = $arr_prm_inst->student_register_full_registration_prm($name, $email, $password, $department, $school_year, $number);

        // データ登録
        $sql = 'INSERT INTO `student_master`(`name`, `email`, `password`, `department`, `school_year`, `number`, `status`) VALUES (?, ?, ?, ?, ?, ?, ?)';

        $register = $db_inst->data_various_kinds($sql, $argument);

        if (!$register) {
            $err_array[] = '登録できませんでした';
        }
    } else {
        $err_array[] = $val_inst->getErrorMsg();
    }
} else {
    $url = '../../Incorrect_request.php';
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
                            <?php foreach ($err_array as $err_mag) : ?>
                                <p style="color: red;"><?php h($err_mag); ?></p>
                            <?php endforeach; ?>
                            <div class="backBtn">
                                <a class="btn btn-primary px-5" href="./full_registration_form.php?key=<?php h($_POST['email']) ?>">戻る</a>
                            </div>
                        <?php endif; ?>

                        <?php if (count($err_array) == 0) : ?>
                            <p>ユーザ登録が完了しました。</p>
                            <?php header('refresh:3;url=../login/login_form.php'); ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>