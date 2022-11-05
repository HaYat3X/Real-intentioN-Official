<?php

session_start();

// クラスファイルインポート
require __DIR__ . '../../../../class/Logic.php';

// functionファイルインポート
require __DIR__ . '../../../../function/functions.php';

// クラスのインポート
$user_obj = new UserLogic();

// err配列準備
$err = [];

// フォームリクエストを受け取る
if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    // バリーデーションチェック
    if (!$email = filter_input(INPUT_POST, 'email')) {
        $err[] =  'メールアドレスを入力してください。';
    }

    // 正規表現
    if (!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@st.kobedenshi.ac.jp/", $email)) {
        $err[] = '@st.kobedenshi.ac.jpのメールアドレスを入力してください。';
    }

    // すでにメールアドレスが登録されている場合エラー出力
    $alreadyEmail = $user_obj::user_exist_check($email);

    // 返り値がTrueであれば登録できない
    if ($alreadyEmail) {
        $err[] = '指定のメールアドレスは既に登録されています。ログインしてください。';
    }

    // エラーに引っかからない場合メールアドレスにトークンを送信する
    if (count($err) === 0) {
        $token = genRandomStr();

        // トークン送信
        $send_token = $user_obj::push_token($email);

        if (!$send_token) {
            $err[] = 'トークンの送信に失敗しました。';
        }

        // セッションにトークン格納
        $_SESSION['token'] = $send_token;
        $_SESSION['email'] = $email;
        header('refresh:3;url=./auth_email_form.php');
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
                                <p style="color: red;"><?php h($e); ?></p>
                            <?php endforeach; ?>
                            <div class="backBtn">
                                <a class="btn btn-primary px-5" href="./provisional_registration_form.php">戻る</a>
                            </div>
                        <?php endif; ?>

                        <?php if (count($err) === 0) : ?>
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