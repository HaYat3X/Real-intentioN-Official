<?php

session_start();
define('PATH', '/Applications/MAMP/htdocs/Deliverables4');

// 外部ファイルのインポート
require_once PATH . '/class/Session_calc.php';
require_once PATH . '/class/Database_calc.php';
require_once PATH . '/class/Register_calc.php';
require_once PATH . '/class/Validation_calc.php';
require_once PATH . '/function/functions.php';

// インスタンス化
$ses_calc = new Session();
$val_calc = new ValidationCheck();
$rgs_calc = new Register();

// メールアドレストークンの存在チェック
$email_token = $ses_calc->check_email_token();
if (!$email_token) {
    $uri = PATH . '/src/Exception/400_request.php';
    header('Location:' . $uri);
}

// クッキーの存在チェック　
if (!$_COOKIE['auth_time_limit']) {
    $uri = PATH . '/src/Exception/400_request.php';
    header('Location:' . $uri);
}

// パラメータからメールアドレスを受け取る
$email = filter_input(INPUT_GET, 'email');

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
    <title>学生情報登録 / 「Real intentioN」</title>
    <style>
        body {
            background-color: #EFF5F5;
        }

        header {
            background-color: #D6E4E5;
        }

        footer {
            background-color: #497174;
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
    </style>
</head>

<body>
    <?php include(PATH . '/src/template/header_template.php') ?>

    <div class="box d-flex vh-100 align-items-center">
        <div class="container bg-light py-5">
            <div class="row py-5">
                <div class="col-lg-5 mx-auto">
                    <form class="needs-validation" novalidate action="./auth_email.php" method="POST">
                        <h1 class="text-center fs-2 mb-5">
                            メールアドレスを認証する
                        </h1>

                        <div class="mt-4">
                            <label for="validationCustom02" class="form-label"></label>
                            <input type="password" class="form-control" id="validationCustom02" required name="token">

                            <div class="invalid-feedback">
                                <p>認証コードを入力してください。</p>
                            </div>
                        </div>

                        <input type="hidden" name="csrf_token" value="<?php h($ses_calc->create_csrf_token()); ?>">
                        <input type="hidden" name="email" value="<?php h($email); ?>">
                        <input type="hidden" name="email_token" value="<?php h($email_token); ?>">

                        <div class="mt-4">
                            <button type="submit" class="login-btn btn px-4">認証する</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include(PATH . '/src/template/footer.php') ?>

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