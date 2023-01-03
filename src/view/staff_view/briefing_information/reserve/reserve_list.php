<?php

// セッション開始
session_start();

// 外部ファイルのインポート
require_once '../../../../../class/Session_calc.php';
require_once '../../../../../class/Validation_calc.php';
require_once '../../../../../function/functions.php';
require_once '../../../../../class/View_calc.php';
require_once '../../../../../class/Like_calc.php';
require_once '../../../../../class/Reserve_calc.php';

// インスタンス化
$ses_calc = new Session();
$val_calc = new ValidationCheck();
$viw_calc = new View();
$lik_calc = new Like();
$rsv_calc = new Reserve();

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

// パラメータから投稿IDを取得
$post_id = filter_input(INPUT_GET, 'post_id');

// インターンシップ情報投稿に予約をした学生情報を取得する
$reserve_data = $rsv_calc->briefing_information_reserve_data($post_id);

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
    <title>会社説明会予約者一覧 /「Real intentioN」</title>
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

        .square_box {
            position: relative;
            max-width: 100px;
            background: #ff3278;
            border-radius: 5px;
        }

        .square_box::before {
            content: "";
            display: block;
            padding-bottom: 100%;
        }

        .square_box p {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-weight: bold;
        }
    </style>
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

    <div class="box d-flex vh-100 align-items-center">
        <div class="container my-5">
            <div class="row">
                <div class="col-lg-8 col-md-12 col-12">
                    <div class="row mb-5 px-4 py-4 bg-light">
                        <h1 class="fs-4 mt-2 mb-4">予約者一覧</h1>
                        <table class="table table-striped mt-2">
                            <thead>
                                <tr>
                                    <th scope="col">予約者名</th>
                                    <th scope="col">メールアドレス</th>
                                    <th scope="col">所属学科</th>
                                    <th scope="col">学年</th>
                                    <th scope="col">出席番号</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php if (is_array($reserve_data) || is_object($reserve_data)) : ?>
                                    <?php foreach ($reserve_data as $row) : ?>
                                        <tr>
                                            <td><?php h($row['name']) ?></td>
                                            <td><?php h($row['email']) ?></td>
                                            <td><?php h($row['course_of_study']) ?></td>
                                            <td><?php h($row['grade_in_school']) ?></td>
                                            <td><?php h($row['attendance_record_number']) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="side-bar col-md-4 bg-light h-100">
                    <div class="d-flex flex-column flex-shrink-0 p-3 bg-light">
                        <ul class="nav nav-pills flex-column mb-auto">
                            <li class="nav-item">
                                <a href="../../intern_information/posts.php" class="nav-link link-dark">
                                    インターンシップ情報
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="../posts.php" class="nav-link link-dark">
                                    会社説明会情報
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="../../student_management/student_list.php" class="nav-link link-dark">
                                    学生の就活状況
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="../../intern_information/post/post_form.php" class="nav-link link-dark">
                                    インターンシップ情報を投稿
                                </a>
                            </li>

                            <li>
                                <a href="../post/post_form.php" class="nav-link link-dark">
                                    会社説明会情報を投稿
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