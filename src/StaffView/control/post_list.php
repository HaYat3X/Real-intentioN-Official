<?php

session_start();

// 外部ファイルのインポート
require '../../../class/SystemLogic.php';
require __DIR__ . '../../../../function/functions.php';

// インスタンス化
$val_inst = new DataValidationLogics();
$arr_prm_inst = new ArrayParamsLogics();
$db_inst = new DatabaseLogics();
$student_inst = new StaffLogics();

// ログインチェック
$userId = $student_inst->get_staff_id();

// ログインチェックの返り値がfalseの場合ログインページにリダイレクト　（不正なリクエストとみなす）
if (!$userId) {
    $url = '../../Incorrect_request.php';
    header('Location:' . $url);
}

$sql = 'SELECT * FROM `staff_information_table` INNER JOIN `staff_master` ON staff_information_table.staff_id = staff_master.staff_id ORDER BY staff_information_table.post_id DESC';

// テーブル全部取得
$results = $db_inst->data_select($sql);
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../../public/img/favicon.ico">
    <link rel="stylesheet" href="../../../public/css/intern/view.css">
    <title>「Real intentioN」 / インターン体験記</title>
    <!-- font-awesomeのインポート -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
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

        /* ユーザの開業を判定し、そのまま出す */
        .information {
            word-break: break-all;
            white-space: pre-line;
        }

        .simple {
            width: 500px;
            /* 省略せずに表示するサイズを指定 */
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .simple-box {
            background-color: #eaf0f0;
        }
    </style>
</head>

<body>

    <!-- テスト-------------------------------------------------------------------------------------------- -->
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
            </div>
        </nav>
    </header>


    <!-- <div class="bg-light"> -->
    <main role="main" class="container mt-5">
        <div class="row">

            <div class="col-md-8">
                <?php if (is_array($results) || is_object($results)) : ?>
                    <?php foreach ($results as $row) : ?>
                        <?php
                        // 正規表現でリンク以外の文字列はエスケープ、リンクはaタグで囲んで、遷移できるようにする。
                        $pattern = '/((?:https?|ftp):\/\/[-_.!~*\'()a-zA-Z0-9;\/?:@&=+$,%#]+)/';
                        $replace = '<a target="_blank" href="$1">$1</a>';
                        $attachment = preg_replace($pattern, $replace, $row['attachment']);
                        ?>

                        <div class="mb-5 bg-light">

                            <!-- area1 -->
                            <div class="area1 d-flex px-3 pt-4">

                                <!-- 今はインターンで仮定 -->
                                <div class="info-left col-md-2">
                                    <!-- インターンの場合 -->
                                    <?php if ($row['type'] === 'インターン情報') : ?>
                                        <div class="square_box_intern">
                                            <p>INTERN</p>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($row['type'] === '説明会情報') : ?>
                                        <div class="square_box_briefing">
                                            <p>BRIEFING</p>
                                        </div>
                                    <?php endif; ?>
                                </div>


                                <div class="info-center col-md-10">
                                    <p class="fw-bold">
                                        <?php h($row['time']) ?>
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


                            <div class="area2 px-5 mt-1 mb-4">
                                <p class="information">
                                    <span><?php h($row['overview']) ?></span>
                                </p>

                                <p class="pt-3">
                                    <span><?php echo $attachment ?></span>
                                </p>
                            </div>


                            <div class="area3 d-flex px-3 pb-3">
                                <div class="question-btn col-md-6">
                                    <a href="./update/update_form.php?post_id=<?php h($row['post_id']) ?>" class="login-btn btn">投稿を編集する</a>
                                    <a href="./delete/delete_check.php?post_id=<?php h($row['post_id']) ?>" class="login-btn btn">投稿を削除する</a>
                                </div>

                                <div class="question-btn col-md-6 text-end">
                                    <?php
                                    $sql2 = 'SELECT * FROM staff_information_like_table WHERE like_post_id = ?';
                                    $argument = $arr_prm_inst->student_post_one_prm($row['post_id']);
                                    $like_value = $db_inst->data_select_count($sql2, $argument);
                                    ?>
                                    <p class="mt-2">学生からのいいね数：<?php h($like_value) ?></p>
                                </div>
                            </div>
                        </div>

                    <?php endforeach; ?>
                <?php endif; ?>



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

            </div>

            <div class="side-bar col-md-4 bg-light sticky-top h-100">
                <div class="d-flex flex-column flex-shrink-0 p-3 bg-light">
                    <ul class="nav nav-pills flex-column mb-auto">
                        <li class="nav-item">
                            <a style="background-color: #EB6440;" href="./view.php" class="nav-link active" aria-current="page">
                                ホーム
                            </a>
                        </li>
                        <li>
                            <a href="./post/post_form.php" class="nav-link link-dark">
                                情報新規投稿
                            </a>
                        </li>

                        <li>
                            <a href="../staff_information/staff_information.php" class="nav-link link-dark">
                                ログアウト
                            </a>
                        </li>
                    </ul>
                </div>
            </div>




        </div><!-- Div row 終了-->
    </main>
    <!-- </div> -->

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


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>