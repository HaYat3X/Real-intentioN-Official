<?php

// セッション開始
session_start();

// 外部ファイルのインポート
require_once '../../../../../class/Session_calc.php';
require_once '../../../../../class/Register_calc.php';
require_once '../../../../../class/Validation_calc.php';
require_once '../../../../../function/functions.php';
require_once '../../../../../class/View_calc.php';
require_once '../../../../../class/Like_calc.php';

// インスタンス化
$ses_calc = new Session();
$val_calc = new ValidationCheck();
$rgs_calc = new Register();
$viw_calc = new View();
$lik_calc = new Like();

// ログインチェック
$student_login_data = $ses_calc->student_login_check();

// ユーザIDを抽出
foreach ($student_login_data as $row) {
    $user_id = $row['student_id'];
}

// ユーザ名を抽出
foreach ($student_login_data as $row) {
    $user_name = $row['name'];
}

// ユーザアイコンを抽出
foreach ($student_login_data as $row) {
    $user_icon = $row['icon'];
}

// ログイン情報がない場合リダイレクト
if (!$student_login_data) {
    $uri = '../../../../Exception/400_request.php';
    header('Location: ' . $uri);
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous" />
    <link rel="shortcut icon" href="../../../../../public/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css">
    <title>インターンシップ体験記を投稿 /「Real intentioN」</title>
    <style>
        body {
            background-color: #EFF5F5;
        }

        header {
            background-color: #c2dbde;
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

    <script>
        function alertFunction1() {
            var submit = confirm("投稿しますか？　投稿内容を確認してください。");

            if (!submit) {
                window.location.href = './post_form.php';
            }
        }
    </script>
</head>

<body>
    <header class="sticky-top">
        <nav class="navbar navbar-expand-lg navbar-light py-4">
            <div class="container">
                <a class="navbar-brand" href="">
                    <img src="../../../../../public/img/logo.png" alt="" width="30" height="24" class="d-inline-block
                            align-text-top" style="object-fit: cover;"> Real intentioN
                </a>
            </div>
        </nav>
    </header>

    <div class="container my-5">
        <div class="row">
            <div class="col-lg-8 col-md-12 col-12 mb-5">
                <div class="bg-light py-5">
                    <form class="needs-validation col-lg-7 col-md-9 col-11 mx-auto" novalidate action="./post.php" method="POST">
                        <h1 class="text-center fs-2 mb-5">
                            インターンシップ体験記を投稿
                        </h1>

                        <div class="mt-4">
                            <label for="validationCustom02" class="form-label">企業名<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="validationCustom02" required name="company">

                            <div class="invalid-feedback">
                                <p>企業名を入力してください。</p>
                            </div>
                        </div>

                        <div class="mt-4">
                            <label for="validationCustom02" class="form-label">体験内容<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="validationCustom02" required name="content">

                            <div class="invalid-feedback">
                                <p>体験内容を入力してください。</p>
                            </div>
                        </div>

                        <div class="mt-4">
                            <label for="validationCustom04" class="form-label">開催形式<span class="text-danger">*</span></label>
                            <select class="form-select" id="validationCustom04" name="format" required>
                                <option selected disabled value="">-- 選択してください --</option>
                                <option value="オンライン開催">オンライン開催</option>
                                <option value="対面開催">対面開催</option>
                            </select>

                            <div class="invalid-feedback">
                                開催形式を選択してください。
                            </div>
                        </div>

                        <div class="mt-4">
                            <label for="validationCustom04" class="form-label">参加業界<span class="text-danger">*</span></label>
                            <select class="form-select" class="form-select" id="validationCustom04" name="field" required>
                                <option selected disabled value="">-- 選択してください --</option>
                                <option value="IT分野">IT分野</option>
                                <option value="ゲームソフト分野">ゲームソフト分野</option>
                                <option value="ハード分野">ハード分野</option>
                                <option value="ビジネス分野">ビジネス分野</option>
                                <option value="CAD分野">CAD分野</option>
                                <option value="グラフィックス分野">グラフィックス分野</option>
                                <option value="サウンド分野">サウンド分野</option>
                                <option value="日本語分野">日本語分野</option>
                                <option value="国際コミュニケーション分野">国際コミュニケーション分野</option>
                            </select>

                            <div class="invalid-feedback">
                                参加した業界を選択してください。
                            </div>
                        </div>

                        <div class="mt-4">
                            <label for="validationCustom04" class="form-label">回答する質問を選択<span class="text-danger">*</span></label>
                            <select class="form-select" class="form-select" id="validationCustom04" name="question" required>
                                <option selected disabled value="">-- 選択してください --</option>
                                <option value="インターンで体験した内容を教えてください。">インターンで体験した内容を教えてください。</option>
                                <option value="インターンの参加は選考に有利になったと感じますか？その理由も教えてください。">インターンの参加は選考に有利になったと感じますか？その理由も教えてください。</option>
                                <option value="交通費の支給など、金銭面でのサポートはありましたか？">交通費の支給など、金銭面でのサポートはありましたか？</option>
                            </select>

                            <div class="invalid-feedback">
                                質問を選択してください。
                            </div>
                        </div>

                        <div class="mt-4">
                            <label for="validationCustom04" class="form-label">選択した質問に回答<span class="text-danger">*</span></label>
                            <textarea class="form-control" name="answer" id="validationCustom04" rows="6" required></textarea>
                            <div class="invalid-feedback">
                                質問に回答してください。
                            </div>
                        </div>

                        <div class="mt-4">
                            <label for="validationCustom04" class="form-label">総合評価<span class="text-danger">*</span></label>
                            <select class="form-select" class="form-select" id="validationCustom04" name="ster" required>
                                <option selected disabled value="">-- 選択してください --</option>
                                <option value="星1">星1</option>
                                <option value="星2">星2</option>
                                <option value="星3">星3</option>
                                <option value="星4">星4</option>
                                <option value="星5">星5</option>
                            </select>

                            <div class="invalid-feedback">
                                総合評価を選択してください。
                            </div>
                        </div>

                        <input type="hidden" name="user_id" value="<?php h($user_id) ?>">
                        <input type="hidden" name="csrf_token" value="<?php h($ses_calc->create_csrf_token()); ?>">

                        <div class="mt-4">
                            <button class="btn login-btn px-4" onclick="alertFunction1()">投稿する</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="side-bar col-md-12 col-12 col-lg-4 g-light h-100">
                <div class="d-flex flex-column flex-shrink-0 p-3 bg-light">
                    <ul class="nav nav-pills flex-column mb-auto">
                        <li class="nav-item">
                            <a href="../../intern_information/posts_recommendation.php" class="nav-link link-dark">
                                インターンシップ情報
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="../../briefing_information/posts_recommendation.php" class="nav-link link-dark">
                                会社説明会情報
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="../posts.php" class="nav-link link-dark">
                                インターンシップ体験記
                            </a>
                        </li>

                        <li>
                            <a href="../../es_experience/posts.php" class="nav-link link-dark">
                                ES体験記
                            </a>
                        </li>

                        <li>
                            <a href="./post_form.php" style="background-color: #EB6440;" class="nav-link active" aria-current="page">
                                インターンシップ体験記を投稿
                            </a>
                        </li>

                        <li>
                            <a href="../../es_experience/post/post_form.php" class="nav-link link-dark">
                                ES体験記を投稿
                            </a>
                        </li>
                    </ul>

                    <hr>

                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            <?php if ($user_icon === "") : ?>
                                <img src="../../../../../public/ICON/default-icon.jpeg" width="32" height="32" class="rounded-circle me-2" style="object-fit: cover;">
                            <?php else : ?>
                                <img src="../../../../../public/ICON/<?php h($user_icon) ?>" width="32" height="32" class="rounded-circle me-2" style="object-fit: cover;">
                            <?php endif; ?>
                            <strong><?php h($user_name) ?></strong>
                        </a>
                        <ul class="dropdown-menu text-small shadow">
                            <li><a class="dropdown-item" href="../../profile/profile.php">プロフィール</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="../../../../logout/logout.php">ログアウト</a></li>
                        </ul>
                    </div>
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