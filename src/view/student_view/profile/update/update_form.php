<?php

// セッション開始
session_start();

// 外部ファイルのインポート
require_once '../../../../../class/Session_calc.php';
require_once '../../../../../class/Validation_calc.php';
require_once '../../../../../function/functions.php';
require_once '../../../../../class/View_calc.php';
require_once '../../../../../class/Like_calc.php';
require_once '../../../../../class/Register_calc.php';
require_once '../../../../../class/Login_calc.php';
require_once '../../../../../class/Profile_calc.php';

// インスタンス化
$ses_calc = new Session();
$val_calc = new ValidationCheck();
$viw_calc = new View();
$lik_calc = new Like();
$rgs_calc = new Register();
$lgn_calc = new Login();
$pfl_calc = new Profile();

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

// 学生情報を取得する
$student_date = $pfl_calc->student_data($user_id);

// 編集権限がない場合リダイレクト
foreach ($student_date as $row) {
    if (!$row['student_id'] == $user_id) {
        $uri = '../../../../Exception/400_request.php';
        header('Location: ' . $uri);
    }
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
    <title>プロフィールを更新 /「Real intentioN」</title>
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
            var submit = confirm("更新しますか？　編集内容を確認してください。");

            if (!submit) {
                window.location.href = '../posts.php';
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
                <?php if (is_array($student_date) || is_object($student_date)) : ?>
                    <?php foreach ($student_date as $row) : ?>
                        <div class="bg-light py-5">
                            <form class="needs-validation col-lg-7 col-md-9 col-11 mx-auto" novalidate action="./update.php" method="POST" enctype="multipart/form-data">
                                <h1 class="text-center fs-2 mb-5">
                                    プロフィールを編集する
                                </h1>

                                <div class="mt-4">
                                    <label for="validationCustom02" class="form-label">プロフィール画像</label>
                                    <input type="file" class="form-control" id="validationCustom02" name="icon" accept=".jpg, .jpeg, .png, .webp">
                                </div>

                                <div class="mt-4">
                                    <label for="validationCustom02" class="form-label">ユーザ名<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="validationCustom02" value="<?php h($row['name']) ?>" required name="name">

                                    <div class="invalid-feedback">
                                        <p>ユーザ名を入力してください。</p>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <label for="validationCustom04" class="form-label">所属学科<span class="text-danger">*</span></label>
                                    <select class="form-select" id="validationCustom04" name="department" required>
                                        <option selected value="<?php h($row['course_of_study']) ?>"><?php h($row['course_of_study']) ?></option>
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
                                    <label for="validationCustom04" class="form-label">学年情報<span class="text-danger">*</span></label>
                                    <select class="form-select" class="form-select" id="validationCustom04" name="school_year" required>
                                        <option selected value="<?php h($row['grade_in_school']) ?>"><?php h($row['grade_in_school']) ?></option>
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
                                    <label for="validationCustom02" class="form-label">学籍番号<span class="text-danger">*（7桁の番号を入力して下さい。）</span></label>
                                    <input type="text" class="form-control" id="validationCustom02" required name="number" value="<?php h($row['attendance_record_number']) ?>">

                                    <div class="invalid-feedback">
                                        <p>学籍番号を入力してください。</p>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <label for="validationCustom04" class="form-label">プロフィール文</label>
                                    <textarea class="form-control" name="doc" id="validationCustom04" rows="5"><?php h($row['doc']) ?></textarea>
                                </div>

                                <div class="mt-4">
                                    <label for="validationCustom04" class="form-label">就活ステータス<span class="text-danger">*</span></label>
                                    <select class="form-select" id="validationCustom04" name="status" required>
                                        <option selected value="<?php h($row['status']) ?>"><?php h($row['status']) ?></option>
                                        <option value="就職活動中">就職活動中</option>
                                        <option value="就職活動終了">就職活動終了</option>
                                    </select>

                                    <div class="invalid-feedback">
                                        就活ステータスを選択してください。
                                    </div>
                                </div>

                                <input type="hidden" name="csrf_token" value="<?php h($ses_calc->create_csrf_token()); ?>">

                                <div class="mt-4">
                                    <button class="btn login-btn px-4" onclick="alertFunction1()">更新する</button>
                                </div>
                            </form>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <div class="side-bar col-12 col-md-12 col-lg-4 bg-light h-100">
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
                            <a href="../../intern_experience/posts.php" class="nav-link link-dark">
                                インターンシップ体験記
                            </a>
                        </li>

                        <li>
                            <a href="../../es_experience/posts.php" class="nav-link link-dark">
                                ES体験記
                            </a>
                        </li>

                        <li>
                            <a href="../../intern_experience/post/post_form.php" class="nav-link link-dark">
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
                            <?php if ($user_icon == "") : ?>
                                <img src="../../../../../public/ICON/default-icon.jpeg" width="32" height="32" class="rounded-circle me-2" style="object-fit: cover;">
                            <?php else : ?>
                                <img src="../../../../../public/ICON/<?php h($user_icon) ?>" width="32" height="32" class="rounded-circle me-2" style="object-fit: cover;">
                            <?php endif; ?>
                            <strong><?php h($user_name) ?></strong>
                        </a>
                        <ul class="dropdown-menu text-small shadow">
                            <li><a class="dropdown-item" href="../profile.php">プロフィール</a></li>
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