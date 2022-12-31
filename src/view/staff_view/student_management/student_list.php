<?php

// セッション開始
session_start();

// 外部ファイルのインポート
require_once '../../../../class/Session_calc.php';
require_once '../../../../class/Validation_calc.php';
require_once '../../../../function/functions.php';
require_once '../../../../class/View_calc.php';
require_once '../../../../class/Like_calc.php';
require_once '../../../../class/Reserve_calc.php';
require_once '../../../../class/Student_calc.php';

// インスタンス化
$ses_calc = new Session();
$val_calc = new ValidationCheck();
$viw_calc = new View();
$lik_calc = new Like();
$rsv_calc = new Reserve();
$sdn_calc = new Student();

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
    $uri = '../../../Exception/400_request.php';
    header('Location: ' . $uri);
}

$post_id = filter_input(INPUT_GET, 'post_id');

// サービスに登録している学生の就活状況を取得する
$student_data = $sdn_calc->student_date();

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
    <title>学生の就活状況 /「Real intentioN」</title>
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

    <div class="box d-flex vh-100 align-items-center">
        <div class="container my-5">
            <div class="row">
                <div class="col-lg-8 col-md-12 col-12">
                    <div class="row mb-5 px-4 py-4 mx-1 bg-light">
                        <h1 class="fs-4 mt-2 mb-4">学生の就活状況</h1>
                        <table class="table table-striped mt-2">
                            <thead>
                                <tr>
                                    <th scope="col">就活状況</th>
                                    <th scope="col">メールアドレス</th>
                                    <th scope="col">所属学科</th>
                                    <th scope="col">学年</th>
                                    <th scope="col">出席番号</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php if (is_array($student_data) || is_object($student_data)) : ?>
                                    <?php foreach ($student_data as $row) : ?>
                                        <tr>
                                            <td><?php h($row['status']) ?></td>
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
                                <a href="../post/post_form.php" class="nav-link link-dark">
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
                            <div class="mb-4">
                                <form action="./search/search_result.php" method="post">
                                    <div class="input-group">
                                        <select class="form-select" name="keyword" aria-label="Default select example">
                                            <option selected disabled>学科名で検索</option>
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
                                        <input type="hidden" name="category" value="course_of_study">
                                        <button class="btn btn-outline-success" type="submit" id="button-addon2"><i class="bi bi-search"></i></button>
                                    </div>
                                </form>
                            </div>

                            <div>
                                <form action="./search/search_result.php" method="post">
                                    <div class="input-group">
                                        <select class="form-select" name="keyword" aria-label="Default select example">
                                            <option selected>学年で検索</option>
                                            <option value="1年生">1年生</option>
                                            <option value="2年生">2年生</option>
                                            <option value="3年生">3年生</option>
                                            <option value="4年生">4年生</option>
                                        </select>
                                        <input type="hidden" name="category" value="grade_in_school">
                                        <button class="btn btn-outline-success" type="submit" id="button-addon2"><i class="bi bi-search"></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <hr>

                        <div class="dropdown">
                            <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="../../../../public/ICON/default-icon.jpeg" alt="" width="32" height="32" class="rounded-circle me-2" style="object-fit: cover;">
                                <strong><?php h($user_name) ?></strong>
                            </a>
                            <ul class="dropdown-menu text-small shadow">
                                <li><a class="dropdown-item" href="../../../logout/logout.php">ログアウト</a></li>
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