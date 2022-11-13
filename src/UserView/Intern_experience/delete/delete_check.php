<?php

session_start();

// 外部ファイルのインポート
require '../../../../class/Logic.php';
require '../../../../function/functions.php';

// オブジェクト
$object = new SystemLogic();

// ログインチェック
$login_check = $object::login_check_student();

// ログインチェックの返り値がfalseの場合ログインページにリダイレクト
if (!$login_check) {
    header('Location: ../login/login_form.php');
}

// ユーザID取得
foreach ($login_check as $row) {
    $userId = $row['student_id'];
}

// 削除する投稿IDの取得
$delete_post_id = filter_input(INPUT_GET, 'post_id');
$argument = [];
$argument[] = intval($delete_post_id);

// SQL発行
$sql = 'SELECT * FROM `intern_table` INNER JOIN `student_master` ON intern_table.user_id = student_master.student_id AND intern_table.post_id = ?';

// 削除データ取得
$delete_date = $object::db_select_argument($sql, $argument);


// 削除対象データがない場合はリダイレクト
if (!$delete_date) {
    $url = '../../../Incorrect_request.php';
    header('Location:' . $url);
}

// 投稿者IDとログイン中のユーザのIDが一致しなければリダイレクト
foreach ($delete_date as $date) {
    if (!$userId == $date['user_id']) {
        $url = '../../../Incorrect_request.php';
        header('Location:' . $url);
    }

    // // 削除するID
    // $post_id = $date['id'];
}



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
            background-color: #e6e6e6;
        }



        .square_box {
            position: relative;
            max-width: 100px;
            background: #ffb6c1;
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
        }

        .side-area {
            position: sticky;
            top: 60px;
        }
    </style>
</head>

<body>

    <!-- テスト-------------------------------------------------------------------------------------------- -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light py-4">
            <div class="container">
                <img style="width: 45px; height:45px; margin-right:10px;" src="../../../public/img/logo.png" alt="">
                <a class="navbar-brand" href="#">Real intentioN</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="#">職員の方はこちら</a>
                        </li>
                        <button class="btn btn-primary ms-3">ログインはこちら</button>
                    </ul>
                </div>
            </div>
        </nav>
    </header>



    <!-- <div class="bg-light"> -->
    <main role="main" class="container mt-5" style="padding: 0px">
        <div class="row">

            <div class="col-md-8">
                <?php if (is_array($delete_date) || is_object($delete_date)) : ?>
                    <?php foreach ($delete_date as $row) : ?>
                        <div class="mb-5 bg-light">

                            <!-- area1 -->
                            <div class="area1 d-flex px-3 py-4">
                                <div class="info-left col-2">
                                    <div class="square_box">
                                        <p>INTERN</p>
                                    </div>
                                </div>

                                <div class="info-center col-10">
                                    <?php h($row['company']) ?><span style="margin: 0 10px;">/</span><?php h($row['field']) ?><span style="margin: 0 10px;">/</span><?php h($row['format']) ?>

                                    <p><?php h($row['content']) ?>s</p>

                                    <p><?php h($row['ster']) ?></p>
                                </div>


                            </div>

                            <div class="question px-3">
                                <span>Q.</span><?php h($row['question']) ?>
                            </div>

                            <div class="answer px-3">
                                <span>A.</span><?php h($row['answer']) ?>
                            </div>

                            <div class="area2 d-flex px-3 py-4">
                                <div class="post-name col-5 pt-2">
                                    <?php h($row['name']) ?> ｜ <?php h($row['department']) ?> ｜ <?php h($row['school_year']) ?>
                                </div>
                            </div>

                            <div class="btn-group">
                                <div>
                                    <a href="../view.php" class="btn btn-primary">削除キャンセル</a>
                                </div>


                                <a href="./delete.php?post_id=<?php h($delete_post_id) ?>">削除</a>
                                <!--  -->

                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>



            <div class="col-md-4 bg-warning sticky-top vh-100">
                <div>
                    <h1>送信</h1>
                    <a href="./post/post_form.php">新規投稿</a>
                </div>
                <!-- <ul class=" list-group">
                    <li class="list-group-item list-group-item-light">Latest Posts</li>
                    <li class="list-group-item list-group-item-light">Announcements</li>
                </ul> -->
            </div><!-- col-md-4 終了-->



        </div><!-- Div row 終了-->
    </main>
    <!-- </div> -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>