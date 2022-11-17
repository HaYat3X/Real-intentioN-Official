<?php

session_start();

// 外部ファイルのインポート
require '../../../../class/SystemLogic.php';
require __DIR__ . '../../../../../function/functions.php';

// インスタンス化
$val_inst = new DataValidationLogics();
$arr_prm_inst = new ArrayParamsLogics();
$db_inst = new DatabaseLogics();
$student_inst = new StudentLogics();

// ログインチェック
$userId = $student_inst->get_student_id();


// 学生の名前
$userName = $student_inst->get_student_name();

// ログインチェックの返り値がfalseの場合ログインページにリダイレクト　（不正なリクエストとみなす）
if (!$userId) {
    $url = '../../Incorrect_request.php';
    header('Location:' . $url);
}

// フォームリクエストを受け取る
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $keyword = filter_input(INPUT_POST, 'keyword');
} else {
    $url = '../../Incorrect_request.php';
    header('Location:' . $url);
}


// 企業名検索のSQL
$sql = "SELECT * FROM `staff_information_table` INNER JOIN `staff_master` ON staff_information_table.staff_id = staff_master.staff_id WHERE staff_information_table.type LIKE ? ORDER BY staff_information_table.post_id DESC";

// バインド
$argument = $arr_prm_inst->post_search_prm($keyword);

// テーブル全部取得
$results = $db_inst->data_select_argument($sql, $argument);

// 投稿にいいねしているか判定する
$sql2 = 'SELECT * FROM staff_information_like_table WHERE like_post_id = ?';

// 投稿のいいねを解除するSQL
$sql3 = 'SELECT * FROM staff_information_like_table WHERE like_post_id = ? AND student_id = ?';
?>








<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../../public/img/favicon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        body {
            background-color: #eaf0f0;
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
            background-color: #eb6540c1;
        }

        .square_box_intern {
            position: relative;
            max-width: 100px;
            background: #ffb6b9;
            border-radius: 5px;
        }

        .square_box_intern::before {
            content: "";
            display: block;
            padding-bottom: 100%;
        }

        .square_box_intern p {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-weight: bold;
        }

        .square_box_briefing {
            position: relative;
            max-width: 100px;
            background: #fae3d9;
            border-radius: 5px;
        }

        .square_box_briefing::before {
            content: "";
            display: block;
            padding-bottom: 100%;
        }

        .square_box_briefing p {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-weight: bold;
        }

        .square_box_event {
            position: relative;
            max-width: 100px;
            background: #bbded6;
            border-radius: 5px;
        }

        .square_box_event::before {
            content: "";
            display: block;
            padding-bottom: 100%;
        }

        .square_box_event p {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-weight: bold;
        }

        .student-review {
            color: #FCCA4D;
        }

        .side-bar {
            padding-top: 10px;
            padding-bottom: 10px;
        }

        .like {
            color: black;
            font-size: 25px;
        }

        .like:hover {
            color: pink;
            font-size: 25px;
        }

        .unsubscribe {
            color: pink;
            font-size: 25px;
        }

        .unsubscribe:hover {
            color: pink;
            font-size: 25px;
        }
    </style>
    <title>「Real IntentioN」 / インターン体験記</title>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light py-4">
            <div class="container">
                <a class="navbar-brand" href="./view.php">
                    <img src="../../../public/img/logo.png" alt="" width="30" height="24" class="d-inline-block
                                align-text-top" style="object-fit: cover;">
                    Real intentioN
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>


                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="../../StaffView/login/login_form.php">
                                <i class="fa-sharp fa-solid fa-user fa-2x"></i><span class="badge fs-5 text text-danger">9</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="../../StaffView/login/login_form.php">
                                <i class="fa-sharp fa-solid fa-bell fa-2x"></i><span class="badge fs-5 text text-danger">9</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>



    <main role="main" class="container mt-5">
        <div class="row">

            <div class="col-md-8">
                <?php if (is_array($results) || is_object($results)) : ?>
                    <?php foreach ($results as $row) : ?>

                        <?php
                        // 今日の日付の取得
                        $objDateTime = new DateTime();
                        $time = $objDateTime->format('Y-m-d');

                        // 現在時刻と指定時刻の差を計算
                        $time1 = new DateTime($row['time']);
                        $time2 = new DateTime($time);
                        $diff = $time1->diff($time2);
                        $limit = $diff->format('%a');
                        ?>

                        <!-- 開催期限が過ぎたものは表示しない -->
                        <?php if ($limit >= 1) : ?>


                            <div class="mb-5 bg-light">

                                <!-- area1 -->
                                <div class="area1 d-flex px-3 pt-4">

                                    <!-- 今はインターンで仮定 -->
                                    <div class="info-left col-2">
                                        <!-- インターンの場合 -->
                                        <?php if ($row['type'] === 'インターン情報') : ?>
                                            <div class="square_box_intern">
                                                <p>INTERN</p>
                                            </div>
                                        <?php endif; ?>

                                        <?php if ($row['type'] === 'イベント情報') : ?>
                                            <div class="square_box_event">
                                                <p>EVENT</p>
                                            </div>
                                        <?php endif; ?>

                                        <?php if ($row['type'] === '説明会情報') : ?>
                                            <div class="square_box_briefing">
                                                <p>BRIEFING</p>
                                            </div>
                                        <?php endif; ?>
                                    </div>



                                    <div class="info-center col-10">
                                        <p>
                                            <?php if ($limit <= 7) : ?>
                                                <span style="color: red;" class="fw-bold">
                                                    <?php h('開催まであと' . $limit . '日') ?>
                                                </span>
                                            <?php else : ?>
                                                <span class="fw-bold">
                                                    <?php h('開催まであと' . $limit . '日') ?>
                                                </span>
                                            <?php endif; ?>
                                        </p>

                                        <p class="fs-5 fw-bold">
                                            <?php h($row['company']) ?>
                                            <span style="margin: 0 10px;">/</span>
                                            <?php h($row['field']) ?>
                                            <span style="margin: 0 10px;">/</span>
                                            <?php h($row['format']) ?>
                                        </p>
                                    </div>

                                </div>


                                <div class="area2 px-5">
                                    <p class="intern-contents" style="word-break: break-all; white-space: pre-line;">
                                        <?php h($row['overview']) ?>
                                    </p>

                                    <?php
                                    // 正規表現でリンク以外の文字列はエスケープ、リンクはaタグで囲んで、遷移できるようにする。
                                    $pattern = '/((?:https?|ftp):\/\/[-_.!~*\'()a-zA-Z0-9;\/?:@&=+$,%#]+)/';
                                    $replace = '<a target="_blank" href="$1">$1</a>';
                                    $attachment = preg_replace($pattern, $replace, $row['attachment']);
                                    ?>

                                    <p><?php echo $attachment; ?></p>
                                </div>

                                <div class="px-3 pb-3">
                                    <!-- 投稿に既にいいねしている場合いいねできない -->
                                    <?php $argument = $arr_prm_inst->like_post_prm($userId, $row['post_id']); ?>
                                    <?php $unsubscribe = $db_inst->data_select_argument($sql3, $argument); ?>

                                    <?php if ($unsubscribe) : ?>
                                        <!-- これ押したらいいね解除 -->
                                        <a class="unsubscribe" href="./like/like_delete.php?post_id=<?php h($row['post_id']) ?>">
                                            <i class="bi bi-heart-fill"></i>
                                        </a>いいね解除
                                    <?php else : ?>
                                        <a class="like" href="./like/like.php?post_id=<?php h($row['post_id']) ?>">
                                            <i class="bi bi-heart"></i>
                                        </a>いいね
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                    <?php endforeach; ?>
                <?php endif; ?>

            </div>



            <div class="side-bar col-md-4 bg-light sticky-top h-100">
                <div class="d-flex flex-column flex-shrink-0 p-3 bg-light">
                    <ul class="nav nav-pills flex-column mb-auto">
                        <li class="nav-item">
                            <a href="../Intern_experience/view.php" class="nav-link link-dark" aria-current="page">
                                インターン体験記
                            </a>
                        </li>
                        <li>
                            <a href="../staff_information/staff_information.php" style="background-color: #EB6440;" class="nav-link active">
                                インターン / イベント情報 / 説明会情報
                            </a>
                        </li>
                    </ul>



                    <hr>
                    <div class="dropdown">
                        <form action="./search/type_search.php" method="post">
                            <div class="input-group mt-4">
                                <select class="form-select" name="keyword" aria-label="Default select example">
                                    <option selected>情報の種類</option>
                                    <option value="インターン情報">インターン情報</option>
                                    <option value="イベントぞ情報">イベント情報</option>
                                    <option value="説明会形式">説明会情報</option>
                                </select>
                                <button class="btn btn-outline-success" type="submit" id="button-addon2"><i class="fas fa-search"></i>検索</button>
                            </div>
                        </form>

                        <form action="./format_search.php" method="post">
                            <div class="input-group mt-4">
                                <select class="form-select" name="keyword" aria-label="Default select example">
                                    <option selected>開催分野</option>
                                    <option value="対面形式">対面開催</option>
                                    <option value="オンライン形式">オンライン開催</option>
                                </select>
                                <button class="btn btn-outline-success" type="submit" id="button-addon2"><i class="fas fa-search"></i>検索</button>
                            </div>
                        </form>

                        <form action="./field_search.php" method="post">
                            <div class="input-group mt-4">
                                <select class="form-select" name="keyword" aria-label="Default select example">
                                    <option selected>開催形式</option>
                                    <option value="IT・ソフトウェア">IT・ソフトウェア</option>
                                    <option value="2">星2</option>
                                    <option value="3">星3</option>
                                    <option value="4">星4</option>
                                    <option value="5">星5</option>
                                </select>
                                <button class="btn btn-outline-success" type="submit" id="button-addon2"><i class="fas fa-search"></i>検索</button>
                            </div>
                        </form>
                    </div>

                    <hr>
                    <div class="dropdown">
                        人気の情報を表示
                    </div>

                    <hr>
                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://github.com/mdo.png" alt="" width="32" height="32" class="rounded-circle me-2">
                            <strong><?php h($userName) ?></strong>
                        </a>
                        <ul class="dropdown-menu text-small shadow">
                            <li><a class="dropdown-item" href="#">プロフィール</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="../logout.php">サインアウト</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>


        <!-- ページネーション -->
        <div class="justify-content-center">
            <nav aria-label="Page navigation example justify-content-center">
                <ul class="pagination">
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </main>



    <footer>
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