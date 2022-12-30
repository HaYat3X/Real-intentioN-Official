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
$staff_login_data = $ses_calc->staff_login_check();

// ユーザIDを抽出
foreach ($staff_login_data as $row) {
    $user_id = $row['staff_id'];
}

// ユーザ名を抽出
foreach ($staff_login_data as $row) {
    $user_name = $row['name'];
}

// ログイン情報がない場合リダイレクト
if (!$staff_login_data) {
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css">
    <link rel="shortcut icon" href="../../../../../public/img/favicon.ico" type="image/x-icon">
    <title>インターン情報を投稿 /「Real intentioN」</title>
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
            <div class="col-lg-8 col-md-12 col-12">
                <div class="bg-light py-5 mb-5">
                    <form class="needs-validation col-lg-7 col-md-9 col-11 mx-auto" novalidate action="./post.php" method="POST">
                        <h1 class="text-center fs-2 mb-5">
                            インターンシップ情報を投稿
                        </h1>

                        <div class="mt-4">
                            <label for="validationCustom02" class="form-label">企業名<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="validationCustom02" required name="company">

                            <div class="invalid-feedback">
                                <p>企業名を入力してください。</p>
                            </div>
                        </div>

                        <div class="mt-4">
                            <label for="validationCustom02" class="form-label">インターンシップ予約締切日<span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="validationCustom02" required name="time">

                            <div class="invalid-feedback">
                                <p>インターンシップ予約締切日を入力してください。</p>
                            </div>
                        </div>

                        <div class="mt-4">
                            <label for="validationCustom04" class="form-label">開催形式<span class="text-danger">*</span></label>
                            <select class="form-select" class="form-select" id="validationCustom04" name="format" required>
                                <option selected disabled value="">-- 選択してください --</option>
                                <option value="対面">対面</option>
                                <option value="オンライン">オンライン</option>
                            </select>

                            <div class="invalid-feedback">
                                参加分野を選択してください。
                            </div>
                        </div>

                        <div class="mt-4">
                            <label for="validationCustom04" class="form-label">業種分野<span class="text-danger">*</span></label>
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
                                参加分野を選択してください。
                            </div>
                        </div>

                        <div class="mt-4">
                            <label for="validationCustom04" class="form-label">情報投稿対象学科<span class="text-danger">*（Shiftキーを押しながら選択すると複数選択できます。）</span></label>
                            <select class="form-select" multiple required name="outgoing_course_of_study[]" c size="5">
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
                                少なくとも一つの学科を選択してください。
                            </div>
                        </div>

                        <div class="mt-4">
                            <label for="validationCustom04" class="form-label">インターンシップ内容<span class="text-danger">*</span></label>
                            <textarea class="form-control" name="overview" id="validationCustom04" rows="6" required></textarea>
                            <div class="invalid-feedback">
                                インターンシップ内容を入力してください。
                            </div>
                        </div>

                        <div class="mt-4">
                            <label for="validationCustom04" class="form-label">添付資料</label>
                            <textarea class="form-control" name="attachment" id="validationCustom04" rows="1"></textarea>
                        </div>

                        <input type="hidden" name="csrf_token" value="<?php h($ses_calc->create_csrf_token()); ?>">

                        <div class="mt-4">
                            <button class="btn login-btn" onclick="alertFunction1()">投稿する</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="side-bar col-md-12 col-12 col-lg-4 bg-light h-100">
                <div class="d-flex flex-column flex-shrink-0 p-3 bg-light">
                    <ul class="nav nav-pills flex-column mb-auto">
                        <li class="nav-item">
                            <a href="../posts.php" class="nav-link link-dark">
                                インターンシップ情報
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="../../briefing_information/posts.php" class="nav-link link-dark">
                                会社説明会情報
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="../../kic_information/posts.php" class="nav-link link-dark">
                                キャリアセンターからのお知らせ
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="./post_form.php" style="background-color: #EB6440;" class="nav-link active" aria-current="page">
                                インターンシップ情報を投稿
                            </a>
                        </li>

                        <li>
                            <a href="../../briefing_information/post/post_form.php" class="nav-link link-dark">
                                会社説明会情報を投稿
                            </a>
                        </li>

                        <li>
                            <a href="../../kic_information/post/post_form.php" class="nav-link link-dark">
                                キャリアセンターからのお知らせを投稿
                            </a>
                        </li>
                    </ul>

                    <hr>

                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="../../../../../public/ICON/default-icon.jpeg" alt="" width="32" height="32" class="rounded-circle me-2" style="object-fit: cover;">
                            <strong><?php h($user_name) ?></strong>
                        </a>
                        <ul class="dropdown-menu text-small shadow">
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