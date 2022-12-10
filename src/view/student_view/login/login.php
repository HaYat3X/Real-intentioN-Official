<?php

// セッション開始
session_start();
ob_start();

// 外部ファイルのインポート
require_once '../../../../class/Session_calc.php';
require_once '../../../../class/Login_calc.php';
require_once '../../../../class/Validation_calc.php';
require_once '../../../../function/functions.php';

// インスタンス化
$ses_calc = new Session();
$val_calc = new ValidationCheck();
$lgn_calc = new Login();

// エラーメッセージが入る配列を定義
$err_array = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 送信された値を受け取り
    $email = filter_input(INPUT_POST, 'email');
    $password = filter_input(INPUT_POST, 'password');
    $csrf_token = filter_input(INPUT_POST, 'csrf_token');

    // csrfトークンの存在確認と正誤判定
    $csrf_check = $ses_calc->csrf_match_check($csrf_token);

    if (!$csrf_check) {
        $uri = '../../../Exception/400_request.php';
        header('Location:' . $uri);
    }

    // バリデーションチェックする値を配列に格納
    $val_check_arr = [];
    $val_check_arr[] = strval($email);
    $val_check_arr[] = strval($password);

    // バリデーションチェック
    if (!$test = $val_calc->not_yet_entered($val_check_arr)) {
        $err_array[] = $val_calc->getErrorMsg();
    }

    // エラーがない場合の登録処理
    if (count($err_array) === 0) {

        // プロパティに値をセット
        $lgn_calc->student_set_email($email);
        $lgn_calc->student_set_password($password);

        // ログイン処理をする
        $student_login = $lgn_calc->student_login();

        if (!$student_login) {
            $err_array[] = 'ログインに失敗しました。';
        }

        // ログイン情報をセッションに格納
        $ses_calc->create_student_login_session($student_login);
    }

    // csrf_token削除　二重送信対策
    $ses_calc->csrf_token_unset();
} else {
    $uri = '../../../Exception/400_request.php';
    header('Location:' . $uri);
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous" />
    <link href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css" rel="stylesheet" />
    <link rel="shortcut icon" href="../../../public/img/favicon.ico" type="image/x-icon">
    <title>学生ログイン /「Real intentioN」</title>
    <style>
        body {
            background-color: #EFF5F5;
        }

        header {
            background-color: #c2dbde;
        }

        footer {
            background-color: #497174;
            margin-top: 120px;
        }

        .footer-top {
            padding-bottom: 90px;
            padding: 90px;
        }

        .footer-top a {
            color: #fff;
        }

        .footer-top a:hover {
            color: #fff;
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
            background-color: #eb6540c4;
        }

        section {
            padding-top: 120px;
        }

        .hero {
            background-image: url('./public/img/92d501bc70777a3bf854e9e1aab4881d.jpg');
            background-position: center;
            background-size: cover;
            background-attachment: fixed;
            position: relative;
            z-index: 2;
        }

        .hero::after {
            content: "";
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
            background-color: rgba(37, 39, 71, 0.3);
            z-index: -1;
        }

        .card-effect {
            box-shadow: blue;
            background-color: #fff;
            padding: 25px;
            transition: all 0.35s ease;
        }

        .card-effect:hover {
            box-shadow: none;
            transform: translateY(5px);
        }

        .iconbox {
            width: 54px;
            height: 54px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #EB6440;
            color: white;
            font-size: 32px;
            border-radius: 100px;
            flex: none;
        }

        .service {
            position: relative;
            z-index: 2;
            overflow: hidden;
        }

        .service::after {
            content: "";
            position: absolute;
            top: -100%;
            left: 0;
            background-color: #EB6440;
            width: 100%;
            height: 100%;
            z-index: -1;
            opacity: 0;
            transition: all 0.4s ease;
        }

        .service:hover h5,
        .service:hover p {
            color: white;
        }

        .service:hover .iconbox {
            background-color: #fff;
            color: #EB6440;
        }

        .service:hover::after {
            opacity: 1;
            top: 0;
        }

        .col-img {
            background-image: url('./public/img/kaihatusya.png');
            background-position: center;
            background-size: cover;
            min-height: 480px;
        }
    </style>
</head>

<body>
    <header class="sticky-top">
        <nav class="navbar navbar-expand-lg navbar-light py-4">
            <div class="container">
                <a class="navbar-brand" href="../../../../index.html">
                    <img src="../../../../public/img/logo.png" alt="" width="30" height="24" class="d-inline-block
                            align-text-top" style="object-fit: cover;"> Real intentioN
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link px-4" href="../../staff_view/login/login_form.php">職員の方はこちら</a>
                        </li>
                        <li class="nav-item">
                            <a class="login-btn btn px-4" href="../login/login_form.php">ログインはこちら</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <div class="box d-flex vh-100 align-items-center">
        <div class="container bg-light py-5">
            <div class="row py-5">
                <div class="col-lg-5 mx-auto">
                    <?php if (count($err_array) > 0) : ?>
                        <?php foreach ($err_array as $err_msg) : ?>
                            <div class="alert alert-danger" role="alert"><strong>エラー</strong>　-<?php h($err_msg) ?></div>
                        <?php endforeach; ?>

                        <div class="mt-2">
                            <a class="btn btn-primary px-4" href="./login_form.php">戻る</a>
                        </div>
                    <?php endif; ?>

                    <?php if (count($err_array) === 0) : ?>
                        <div class="alert alert-dark" role="alert"><strong>チェック</strong>　-ログインが完了しました。</div>
                        <?php $uri = '../intern_experience/posts.php'; ?>
                        <?php header('refresh:3;url=' . $uri); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <footer class="text-center py-3">
        <div class="text-light text-center small">
            &copy; 2022 Toge-Company, Inc
            <a class="text-white" target="_blank" href="https://hayate-takeda.xyz/">hayate-takeda.xyz</a>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous">
    </script>
</body>

</html>