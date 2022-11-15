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

        #fixed {
            position: fixed;
            /* 要素の位置を固定する */
            bottom: 100px;
            /* 基準の位置を画面の一番下に指定する */
            right: 500px;
            /* 基準の位置を画面の一番右に指定する */
            width: 150px;
            /* 幅を指定する */
            border: 3px solid #326693;
            /* ボーダーを指定する */
        }

        /* ユーザの開業を判定し、そのまま出す */
        .information {
            word-break: break-all;
            white-space: pre-line;
        }

        .simple {
            width: 300px;
            /* 省略せずに表示するサイズを指定 */
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .simple-box {
            background-color: #e6e6e6;
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

    <div id="fixed">
        <a href="./post/post_form.php">インターン / イベント情報を投稿する！</a>
    </div>

    <!-- <div class="bg-light"> -->
    <main role="main" class="container mt-5">
        <div class="row">

            <div class="col-md-8">
                <?php if (is_array($results) || is_object($results)) : ?>
                    <?php foreach ($results as $row) : ?>



                        <div class="mb-5 bg-light">

                            <!-- area1 -->
                            <div class="area1 d-flex px-3 py-4">

                                <!-- 今はインターンで仮定 -->
                                <div class="info-left col-2">
                                    <div class="square_box">
                                        <p>INTERN</p>
                                    </div>
                                </div>

                                <div class=""></div>

                                <div class="info-center col-10">

                                    <!-- 時間の表示 -->
                                    <!-- 最終的にはあと〇〇日って出るようにする -->
                                    <!-- 日じを過ぎた場合終了とする　また自動削除などはできるのか？？ -->
                                    <p><?php h($row['time']) ?></p>

                                    <?php h($row['company']) ?>
                                    <span style="margin: 0 10px;">/</span>
                                    <?php h($row['field']) ?>
                                    <span style="margin: 0 10px;">/</span>
                                    <?php h($row['format']) ?>
                                </div>

                            </div>


                            <div class="area2 px-3">
                                <p>
                                    <button type="button" class="simple-box btn" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">

                                        <div class="simple"><?php h($row['overview']) ?></div>
                                    </button>
                                </p>

                                <div class="collapse" id="collapseExample">
                                    <div class="information card card-body">
                                        <p><?php h($row['overview']) ?></p>
                                        <p><?php h($row['attachment']) ?></p>
                                    </div>
                                </div>


                            </div>


                            <div class="area3 d-flex px-3 py-4">
                                <div class="question-btn col-7">
                                    <a href="./comment/comment.php?post_id=<?php h($row['post_id']) ?>" class="btn btn-primary">投稿を削除する</a>

                                    <a href="./update/update_form.php?post_id=<?php h($row['post_id']) ?>" class="btn btn-primary">投稿を編集する</a>
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

            <div class="col-md-4 bg-light sticky-top vh-100">
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>