<?php

// セッション有効期限
// ini_set('session.gc_maxlifetime', 60);
session_start();

// クラスファイルインポート
require __DIR__ . '../../../../class/Logic.php';

// functionファイルインポート
require __DIR__ . '../../../../function/functions.php';

// err配列
$err = [];

// フォームリクエストを受け取る
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // バリーデーションチェック
    if (!$form_token = filter_input(INPUT_POST, 'token')) {
        $err[] =  'トークンを入力してください。';
    }

    $email = filter_input(INPUT_POST, 'email');

    if ($_SESSION['token'] == $form_token) {
        $success = '認証に成功しました。';
    } else {
        $err[] = 'トークンが一致しません。';
    }
} else {
    $err[] = '不正なリクエストです。';
    header('refresh:3;url=./tentative_register_form.php');
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
                                <p><label><?php h($e); ?></label></p>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        <?php if (count($err) === 0) : ?>
                            <p><label><?php h($success); ?></label></p>
                            <p><a class="btn btn-primary px-5" href="./full_registration_form.php?key=<?php h($email) ?>">学生情報入力ページへ</a></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>