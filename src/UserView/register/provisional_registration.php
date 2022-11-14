<?php

// セッション開始
session_start();

// 外部ファイルのインポート
require __DIR__ . '../../../../class/Logic.php';
require __DIR__ . '../../../../function/functions.php';

// クラスのインポート
$object = new SystemLogic();

// errメッセージが格納される配列を定義
$err_array = [];

// フォームリクエストを受け取る
if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    // バリーデーションチェック
    if (!$email = filter_input(INPUT_POST, 'email')) {
        $err_array[] =  'メールアドレスを入力してください。';
    }

    // 正規表現で神戸電子以外のメールアドレスは登録できないようにする
    if (!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@st.kobedenshi.ac.jp/", $email)) {
        $err_array[] = '@st.kobedenshi.ac.jpのメールアドレスを入力してください。';
    }

    $email_data = [];
    // 文字列型で定義
    $email_data[] = strval($email);

    // メールアドレスが登録されているかどうかチェックする
    $sql = 'SELECT * FROM student_master WHERE email = ?';
    $already_email = $object::user_exist_check($sql, $email_data);

    // 返り値がTrueであれば登録できない
    if ($already_email) {
        $err_array[] = '指定のメールアドレスは既に登録されています。ログインしてください。';
    }

    // エラーに引っかからない場合メールアドレスにトークンを送信する
    if (count($err_array) === 0) {
        // トークン送信
        $send_token = $object->push_token($email);

        if (!$send_token) {
            $err_array[] = 'トークンの送信に失敗しました。';
        }

        // セッションにトークン情報とメールアドレスを格納
        $_SESSION['token'] = $send_token;
        $_SESSION['email'] = $email;
        header('refresh:3;url=./auth_email_form.php');
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
                            <?php foreach ($err_array as $err_msg) : ?>
                                <p style="color: red;"><?php h($err_msg); ?></p>
                            <?php endforeach; ?>
                            <div class="backBtn">
                                <a class="btn btn-primary px-5" href="./provisional_registration_form.php">戻る</a>
                            </div>
                        <?php endif; ?>

                        <?php if (count($err_array) === 0) : ?>
                            <label>メールアドレスにトークンを送信しました。</label>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>