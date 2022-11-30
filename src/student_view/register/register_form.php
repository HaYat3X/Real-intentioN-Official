<?php

// なぜこれでこれで会決意するのか不明？
ob_start();

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

$email = filter_input(INPUT_GET, 'email');

if (!$email) {
    $uri = '../../400_request.php';
    header('Location:' . $uri);
}

$ses_calc->email_token_unset();

// クッキーの存在チェック　なければ不正レクエスト
if (!$_COOKIE['input_time_limit']) {
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
    <title>「Real IntentioN」 / 会員登録（学生）</title>
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

    <div class="box my-5">
        <div class="container bg-light py-5">
            <div class="row py-5">
                <div class="col-lg-5 mx-auto">
                    <form class="needs-validation" novalidate action="./register.php" method="POST">
                        <h1 class="text-center fs-2 mb-5">
                            学生情報を登録する
                        </h1>

                        <div class="mt-4">
                            <label for="validationCustom02" class="form-label">ニックネーム</label>
                            <input type="text" class="form-control" id="validationCustom02" required name="name">

                            <div class="invalid-feedback">
                                <p>名前を入力してください。</p>
                            </div>
                        </div>

                        <div class="mt-4">
                            <label for="validationCustom04" class="form-label">所属学科</label>
                            <select class="form-select" id="validationCustom04" name="department" required>
                                <option selected disabled value="">-- 選択してください --</option>
                                <option value="ITエキスパート学科">ITエキスパート学科</option>
                                <option value="ITスペシャリスト学科">ITスペシャリスト学科</option>
                                <option value="情報処理学科">情報処理学科</option>
                                <option value="AIシステム開発学科">AIシステム開発学科</option>
                                <option value="ゲーム開発研究学科">ゲーム開発研究学科</option>
                                <option value="エンターテインメントソフト学科">エンターテインメントソフト学科</option>
                                <option value="ゲームソフト学科">ゲームソフト学科</option>
                                <option value="情報工学学科">情報工学学科</option>
                                <option value="情報ビジネス学科">情報ビジネス学科</option>
                                <option value="建築インテリアデザイン学科">建築インテリアデザイン学科</option>
                                <option value="インダストリアルデザイン学科">インダストリアルデザイン学科</option>
                                <option value="総合研究科（建築コース）">総合研究科（建築コース）</option>
                                <option value="3DCGアニメーション学科">3DCGアニメーション学科</option>
                                <option value="デジタルアニメ学科">デジタルアニメ学科</option>
                                <option value="グラフィックスデザイン学科">グラフィックデザイン学科</option>
                                <option value="総合研究科（CGコース）">総合研究科（CGコース）</option>
                                <option value="サウンドクリエイト学科">サウンドクリエイト学科</option>
                                <option value="サウンドテクニック学科">サウンドテクニック学科</option>
                                <option value="声優タレント学科">声優タレント学科</option>
                                <option value="日本語学科">日本語学科</option>
                                <option value="国際コミュニケーション学科">国際コミュニケーション学科</option>
                            </select>

                            <div class="invalid-feedback">
                                学科情報を選択してください。
                            </div>
                        </div>

                        <div class="mt-4">
                            <label for="validationCustom04" class="form-label">学年情報</label>
                            <select class="form-select" class="form-select" id="validationCustom04" name="school_year" required>
                                <option selected disabled value="">-- 選択してください --</option>
                                <option value="1年生">1年生</option>
                                <option value="2年生">2年生</option>
                                <option value="3年生">3年生</option>
                                <option value="4年生">4年生</option>
                            </select>

                            <div class="invalid-feedback">
                                学年情報を選択してください。
                            </div>
                        </div>

                        <div class="mt-4">
                            <label for="validationCustom02" class="form-label">出席番号</label>
                            <input type="text" class="form-control" id="validationCustom02" required name="number">

                            <div class="invalid-feedback">
                                <p>出席番号を入力してください。</p>
                            </div>
                        </div>

                        <div class="mt-4">
                            <label for="validationCustom02" class="form-label">パスワード</label>
                            <input type="password" class="form-control" id="validationCustom02" required name="password">

                            <div class="invalid-feedback">
                                <p>パスワードを入力してください。</p>
                            </div>
                        </div>

                        <input type="hidden" name="email" value="<?php h($email) ?>">
                        <input type="hidden" name="csrf_token" value="<?php h($ses_calc->create_csrf_token()); ?>">

                        <div class="mt-4">
                            <button type="submit" class="login-btn btn px-4">登録する</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

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