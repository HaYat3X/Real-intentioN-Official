<?php

session_start();

// セッション情報がない場合リダイレクト　職員情報がない場合ダイレクト
if (!$_SESSION['auth_success']) {
    header('Location: staff_auth_form.php');
}

// 外部ファイルのファイルインポート
require __DIR__ . '../../../../class/Logic.php';
require __DIR__ . '../../../../function/functions.php';

// クラスのインポート
$object = new SystemLogic();

// errメッセージが入る配列準備
$err_array = [];

// フォームリクエストを受け取る
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // バリーデーションチェック
    if (!$name = filter_input(INPUT_POST, 'name')) {
        $err_array[] =  '名前を入力してください。';
    }

    // バリーデーションチェック
    if (!$email = filter_input(INPUT_POST, 'email')) {
        $err_array[] =  'メールアドレスを入力してください。';
    }

    // バリーデーションチェック
    if (!$password = filter_input(INPUT_POST, 'password')) {
        $err_array[] =  'パスワードを入力してください。';
    }

    // 正規表現で神戸電子以外のメールアドレスは登録できないようにする
    if (!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@st.kobedenshi.ac.jp/", $email)) {
        $err_array[] = '@st.kobedenshi.ac.jpのメールアドレスを入力してください。';
    }

    if (!preg_match("/\A[a-z\d]{8,100}+\z/i", $password)) {
        $err_array[] = 'パスワードは英数字8文字以上で作成してください。';
    }

    $email_data = [];
    $email_data[] = strval($email);

    // メールアドレスがすでに登録されている場合エラー
    $sql = 'SELECT * FROM staff_master WHERE email = ?';
    $already_email = $object::user_exist_check($sql, $email_data);

    if ($already_email) {
        $err_array[] = '指定のメールアドレスは既に登録されています。ログインしてください。';
    }

    // エラーが一つもない場合ユーザ登録する
    if (count($err_array) === 0) {

        // 登録する情報を配列で処理
        $insert_data = [];
        $insert_data[] = strval($_POST['name']);
        $insert_data[] = strval($_POST['email']);
        $insert_data[] = strval(password_hash($_POST['password'], PASSWORD_DEFAULT));

        // SQL発行
        $sql = 'INSERT INTO `staff_master`(`name`, `email`, `password`) VALUES (?, ?, ?)';

        // 登録処理
        $hasCreated = $object::db_insert($sql, $insert_data);

        if (!$hasCreated) {
            $err_array[] = '登録できませんでした';
        }
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
                                <a class="btn btn-primary" href="./register_form.php">戻る</a>
                            </div>
                        <?php endif; ?>

                        <?php if (count($err_array) === 0) : ?>
                            <label>登録が完了しました。</label>
                            <?php header('refresh:3;url=../login/login_form.php'); ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>