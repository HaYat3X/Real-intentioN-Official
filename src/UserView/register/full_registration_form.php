<?php

// セッション有効期限
// ini_set('session.gc_maxlifetime', 60);
session_start();

// 外部ファイル
require __DIR__ . '../../../../class/Logic.php';
require __DIR__ . '../../../../function/functions.php';

// パラメータがない場合リダイレクト
if (!$access_key = filter_input(INPUT_GET, 'key')) {
    $url = '../../Incorrect_request.php';
    header('Location:' . $url);
}

$key = $_SESSION['email'];
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../../public/img/favicon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        body {
            background-color: #EFF5F5;
        }

        header {
            background-color: #D6E4E5;
        }

        footer {
            background-color: #D6E4E5;
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
            background-color: #eb6540c1;
        }

        .box {
            background-color: white;
            border-radius: 5px;
        }
    </style>
    <title>「Real IntentioN」 / ログイン（学生）</title>
</head>

<body>
    <header class="sticky-top">
        <nav class="navbar navbar-expand-lg navbar-light py-4">
            <div class="container">
                <a class="navbar-brand" href="../../../index.html">
                    <img src="../../../public/img/logo.png" alt="" width="30" height="24" class="d-inline-block
                                align-text-top" style="object-fit: cover;">
                    Real intentioN
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="./src/StaffView/login/login_form.php">Real intentioNとは</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="./src/StaffView/login/login_form.php">お問い合わせはこちら</a>
                        </li>
                    </ul>
                </div>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="../../StaffView/login/login_form.php">職員の方はこちら</a>
                        </li>

                        <li class="nav-item">
                            <a class="login-btn btn px-4" href="./login_form.php">ログインはこちら</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>








    <div class="container">
        <div class="box mt-5 py-5">
            <div class="mx-auto col-lg-5">
                <form action="./full_registration.php" method="post">
                    <h1 class="text-center fs-1 mb-5">学生情報を登録する</h1>

                    <div class="mb-4">
                        <label class="form-label" for="name">ニックネーム</label>
                        <input class="form-control" type="text" name="name" id="name">
                    </div>

                    <div class="mb-4">
                        <label class="form-label" for="name">学科情報</label>
                        <select class="form-select" name="department" aria-label="Default select example">
                            <option selected>-- 選択してください --</option>
                            <option value="AIシステム開発学科">AIシステム開発学科</option>
                            <option value="ITソフトウェア学科">ITソフトウェア学科</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label" for="name">学年情報</label>
                        <select class="form-select" name="school_year" aria-label="Default select example">
                            <option selected>-- 選択してください --</option>
                            <option value="1年生">1年生</option>
                            <option value="2年生">2年生</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label" for="name">出席番号</label>
                        <input class="form-control" type="text" name="number" id="name">
                    </div>

                    <div class="mb-4">
                        <label class="form-label" for="name">パスワード</label>
                        <input class="form-control" type="password" name="password" id="name">
                    </div>


                    <input type="hidden" name="email" value="<?php h($key) ?>">
                    <button type="submit" class="login-btn btn px-4">登録</button>
                </form>
            </div>
        </div>
    </div>



    <footer class="fixed-bottom">
        <nav class="navbar navbar-expand-lg navbar-light py-4">
            <div class="container">
                <a class="navbar-brand" href="../../../index.html">
                    <img src="../../../public/img" alt="" width="30" height="24" class="d-inline-block
                                align-text-top" style="object-fit: cover;">
                    Real intentioN
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav2" aria-controls="navbarNav2" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav2">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="./src/StaffView/login/login_form.php">職員の方はこちら</a>
                        </li>

                        <li class="nav-item">
                            <a class="login-btn btn" href="./src/UserView/login/login_form.php">ログインはこちら</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>