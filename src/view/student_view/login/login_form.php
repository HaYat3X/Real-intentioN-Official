<?php

// セッション開始
session_start();

// 外部ファイルのインポート
require_once '../../../../class/Session_calc.php';
require_once '../../../../class/Login_calc.php';
require_once '../../../../class/Validation_calc.php';
require_once '../../../../function/functions.php';

// インスタンス化
$ses_calc = new Session();
$val_calc = new ValidationCheck();
$lgn_calc = new Login();

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
                    <form class="needs-validation" novalidate action="./login.php" method="POST">
                        <h1 class="text-center fs-2 mb-5">
                            ログインする（学生）
                        </h1>

                        <div class="mt-4">
                            <label for="validationCustom02" class="form-label">メールアドレス<span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="validationCustom02" required name="email">

                            <div class="invalid-feedback">
                                <p>メールアドレスを入力してください。</p>
                            </div>
                        </div>

                        <div class="mt-4">
                            <label for="validationCustom02" class="form-label">パスワード<span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="validationCustom02" required name="password">

                            <div class="invalid-feedback">
                                <p>パスワードを入力してください。</p>
                            </div>
                        </div>

                        <input type="hidden" name="csrf_token" value="<?php h($ses_calc->create_csrf_token()); ?>">

                        <div class="mt-4">
                            <button type="submit" class="login-btn btn px-4">認証する</button>
                        </div>
                    </form>
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

    <script>
        (() => {
            'use strict'
            const forms = document.querySelectorAll('.needs-validation')

            // ループして帰順を防ぐ
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }

                    form.classList.add('was-validated')
                }, false)
            })
        })()
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous">
    </script>
</body>

</html>