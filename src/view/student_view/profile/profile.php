<?php

// セッション開始
session_start();

// 外部ファイルのインポート
require_once '../../../../class/Session_calc.php';
require_once '../../../../class/Validation_calc.php';
require_once '../../../../function/functions.php';
require_once '../../../../class/View_calc.php';
require_once '../../../../class/Like_calc.php';
require_once '../../../../class/Register_calc.php';
require_once '../../../../class/Login_calc.php';
require_once '../../../../class/Profile_calc.php';

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
    $uri = '../../../Exception/400_request.php';
    header('Location: ' . $uri);
}

// 学生情報を取得する
$student_date = $pfl_calc->student_data($user_id);

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css">
    <link rel="shortcut icon" href="../../../../public/img/favicon.ico" type="image/x-icon">
    <title>プロフィール /「Real intentioN」</title>
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
</head>

<body>
    <header class="sticky-top">
        <nav class="navbar navbar-expand-lg navbar-light py-4">
            <div class="container">
                <a class="navbar-brand" href="">
                    <img src="../../../../public/img/logo.png" alt="" width="30" height="24" class="d-inline-block
                            align-text-top" style="object-fit: cover;"> Real intentioN
                </a>
            </div>
        </nav>
    </header>

    <div class="container my-5" style="padding-bottom: 160px;">
        <div class="row">
            <?php foreach ($student_date as $row) : ?>
                <div class="col-lg-8 col-md-12 col-12">
                    <div class="intern-contents mb-5 px-4 py-4 bg-light">
                        <div class="row px-3">
                            <div class="mt-3 col-lg-2 col-md-2 col-4">
                                <div class="ratio ratio-1x1">
                                    <?php if ($row['icon'] === "") : ?>
                                        <img src="../../../../public/ICON/default-icon.jpeg" class="img-fluid" style="object-fit: cover; border-radius: 50%;">
                                    <?php else : ?>
                                        <img src="../../../../public/ICON/<?php h($row['icon']) ?>" class="img-fluid" style="object-fit: cover; border-radius: 50%;">
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="col-lg-10 col-md-10 col-8 px-4 mt-2">
                                <p>
                                    <label class="fs-3"><?php h($row['name']) ?></label>
                                </p>

                                <p>
                                    <?php if ($row['status'] === '就職活動中') : ?>
                                        <label class="btn btn-danger px-4"><?php h($row['status']) ?></label>
                                    <?php else : ?>
                                        <label class="btn btn-success px-4"><?php h($row['status']) ?></label>
                                    <?php endif; ?>
                                </p>

                                <p>
                                    <label class="btn btn-secondary px-4"><?php h($row['course_of_study']) ?></label>
                                    <label class="btn btn-secondary px-4"><?php h($row['grade_in_school']) ?></label>
                                </p>
                            </div>
                        </div>

                        <div class="px-4 mt-3 pt-2">
                            <p class="text-dark fw-bold">
                                <?php echo preg_replace('/\n/', "<br>",  $row['doc']); ?>
                            </p>
                        </div>

                        <div class="px-4 mt-5 pb-3">
                            <a class="btn login-btn px-4" href="./update/update_form.php">プロフィールを更新する</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

            <div class="side-bar col-md-12 col-12 col-lg-4 bg-light h-100">
                <div class="d-flex flex-column flex-shrink-0 p-3 bg-light">
                    <ul class="nav nav-pills flex-column mb-auto">
                        <li class="nav-item">
                            <a href="../intern_information/posts_recommendation.php" class="nav-link link-dark">
                                インターンシップ情報
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="../briefing_information/posts_recommendation.php" class="nav-link link-dark">
                                会社説明会情報
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="../kic_notification/posts.php" class="nav-link link-dark">
                                キャリアセンターからのお知らせ
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="../intern_experience/posts.php" class="nav-link link-dark">
                                インターンシップ体験記
                            </a>
                        </li>

                        <li>
                            <a href="../es_experience/posts.php" class="nav-link link-dark">
                                ES体験記
                            </a>
                        </li>

                        <li>
                            <a href="../intern_experience/post/post_form.php" class="nav-link link-dark">
                                インターンシップ体験記を投稿
                            </a>
                        </li>

                        <li>
                            <a href="../es_experience/post/post_form.php" class="nav-link link-dark">
                                ES体験記を投稿
                            </a>
                        </li>
                    </ul>

                    <hr>

                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            <?php if ($user_icon === "") : ?>
                                <img src="../../../../public/ICON/default-icon.jpeg" width="32" height="32" class="rounded-circle me-2" style="object-fit: cover;">
                            <?php else : ?>
                                <img src="../../../../public/ICON/<?php h($user_icon) ?>" width="32" height="32" class="rounded-circle me-2" style="object-fit: cover;">
                            <?php endif; ?>
                            <strong><?php h($user_name) ?></strong>
                        </a>
                        <ul class="dropdown-menu text-small shadow">
                            <li><a class="dropdown-item" href="./profile.php">プロフィール</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="../../../logout/logout.php">ログアウト</a></li>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous">
    </script>
</body>

</html>