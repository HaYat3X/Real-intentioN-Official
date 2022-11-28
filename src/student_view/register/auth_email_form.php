<?php

session_start();

require '/Applications/MAMP/htdocs/Deliverables4/class/Session_calc.php';
require '../../../function/functions.php';

$ses_calc = new Session();

$email_token_check = $ses_calc->check_email_token();

if (!$email_token_check) {
    $uri = '../../400_request.php';
    header('Location:' . $uri);
}

$email = filter_input(INPUT_GET, 'email');

// クッキーの存在チェック　なければ不正レクエスト
if (!$_COOKIE['auto_login']) {
    $uri = '../../400_request.php';
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
    <header>
        <nav class="navbar navbar-expand-lg navbar-light py-4">
            <div class="container">
                <a class="navbar-brand" href="./index.html">
                    <img src="../../../public/img/logo.png" alt="" width="30" height="24" class="d-inline-block
                                align-text-top" style="object-fit: cover;"> Real intentioN
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="./src/StaffView/login/login_form.php">職員の方はこちら</a>
                        </li>

                        <li class="nav-item">
                            <a class="login-btn btn px-3" href="./src/UserView/login/login_form.php">ログインはこちら</a>
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
                    <form action="./auth_email.php" method="post">
                        <h1 class="text-center fs-2 mb-5">
                            メールアドレスを認証する
                        </h1>

                        <div class="mb-4">
                            <label class="form-label" for="name">認証トークン</label>
                            <input class="form-control" type="password" name="token">
                        </div>

                        <input type="hidden" name="email" value="<?php h($email); ?>">
                        <input type="hidden" name="csrf_token" value="<?php h($ses_calc->create_csrf_token()); ?>">
                        <input type="hidden" name="email_token" value="<?php h($email_token_check); ?>">

                        <button type="submit" class="login-btn btn px-4">認証する</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <nav class="navbar navbar-expand-lg navbar-light py-4">
            <div class="container">
                <div class="col-md-4 d-flex align-items-center">
                    <a href="../../../index.html" class="mb-3 me-2 mb-md-0
                                text-muted text-decoration-none lh-1"><img src="../../../public/img/logo.png" width="30px" height="30px" alt=""></a>
                    <span class="mb-3 mb-md-0" style="color: rgba(255,
                                255, 255, 0.697);">&copy;
                        2022 Toge-Company, Inc</span>
                </div>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav2" aria-controls="navbarNav2" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav2">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" target="_blank" href="https://github.com/Hayate12345">
                                <img src="../../../public/img/icons8-github-120.png" width="35px" height="35px" alt="">
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" target="_blank" href="https://hayate-takeda.xyz/">
                                <img src="../../../public/img/icons8-ポートフォリオ-100.png" width="30px" height="30px" alt="">
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" target="_blank" href="https://twitter.com/hayate_KIC">
                                <img src="../../../public/img/icons8-ツイッター-100.png" width="30px" height="30px" alt="">
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous">
    </script>
</body>

</html>