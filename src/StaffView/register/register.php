<?php

session_start();

// セッション情報がない場合リダイレクト　職員情報がない場合ダイレクト
if (!$_SESSION['auth_success']) {
    header('Location: staff_auth_form.php');
}

// クラスファイルインポート
require __DIR__ . '../../../../class/Logic.php';

// functionファイルインポート
require __DIR__ . '../../../../function/functions.php';

// クラスのインポート
$user_obj = new StaffLogic();

// errメッセージが入る配列準備
$err = [];



// フォームリクエストを受け取る
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // バリーデーションチェック
    if (!$name = filter_input(INPUT_POST, 'name')) {
        $err[] =  '名前を入力してください。';
    }

    // バリーデーションチェック
    if (!$email = filter_input(INPUT_POST, 'email')) {
        $err[] =  'メールアドレスを入力してください。';
    }

    // バリーデーションチェック
    if (!$password = filter_input(INPUT_POST, 'password')) {
        $err[] =  'パスワードを入力してください。';
    }

    if (!preg_match("/\A[a-z\d]{8,100}+\z/i", $password)) {
        $err[] = 'パスワードは英数字8文字以上で作成してください。';
    }

    // メールアドレスがすでに登録されている場合エラー
    $already_email = $user_obj::staff_exist_check($email);

    if ($already_email) {
        $err[] = '指定のメールアドレスは既に登録されています。ログインしてください。';
    }


    // エラーが一つもない場合ユーザ登録する
    if (count($err) === 0) {

        // 登録する情報を配列で処理
        $arr = [];
        $arr[] = $_POST['name'];
        $arr[] = $_POST['email'];
        $arr[] = password_hash($_POST['password'], PASSWORD_DEFAULT);

        // SQL発行
        $sql = 'INSERT INTO `staff_master`(`name`, `email`, `password`) VALUES (?, ?, ?)';

        // 登録処理
        $hasCreated = $user_obj::create_staff_user($sql, $arr);

        if (!$hasCreated) {
            $err[] = '登録できませんでした';
        }
    }
} else {
    $err[] = '不正なリクエストです。';

    // 3秒後に入力フォームへリダイレクト
    header('refresh:3;url=./login_form.php');
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
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
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
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
                        <p><?php h($e); ?></p>
                        <?php endforeach; ?>
                        <div class="backBtn">
                            <a class="btn btn-primary" href="./register_form.php">戻る</a>
                        </div>
                        <?php endif; ?>

                        <?php if (count($err) === 0) : ?>
                        <label>登録が完了しました。</label>
                        <?php header('refresh:3;url=../login/login_form.php'); ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>