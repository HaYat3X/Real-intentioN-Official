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

// ログインチェックの返り値がfalseの場合ログインページにリダイレクト　（不正なリクエストとみなす）
if (!$userId) {
    $url = '../../Incorrect_request.php';
    header('Location:' . $url);
}


// ユーザが投稿した投稿についたコメントを取得
$sql = 'SELECT * FROM intern_reply_table WHERE post_user_id = ? AND `user_id` != ? AND `read_status` = ?';

$argument = $arr_prm_inst->student_view_notice_prm($userId);

// 通知をカウント rowCountでselectした回数を判定できる
$notification = $db_inst->data_select_count($sql, $argument);



$sql2 = 'SELECT * FROM intern_reply_table INNER JOIN `student_master` ON intern_reply_table.user_id = student_master.student_id AND intern_reply_table.post_user_id = ? AND intern_reply_table.user_id != ? AND intern_reply_table.read_status = ? ORDER BY intern_reply_table.reply_id DESC';

$argument2 = $arr_prm_inst->student_view_notice_prm($userId);

// sql実行
$notification_data = $db_inst->data_select_argument($sql2, $argument2);

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

        .icon_box {
            position: relative;
            max-width: 70px;
            background: #ffb6c1;
        }

        .icon_box::before {
            content: "";
            display: block;
            padding-bottom: 100%;
        }

        .icon_box p {
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

                        <!-- 通知の数を出す -->
                        <button class="btn btn-primary ms-3"><?php h($notification) ?></button>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <div id="fixed">
        <a href="./post/post_form.php">インターン体験記<br>を投稿する！</a>
    </div>

    <!-- <div class="bg-light"> -->
    <main role="main" class="container mt-5">
        <div class="row">

            <div class="col-md-8">
                <h1>コメント一覧</h1>

                <!-- コメント表示 -->
                <div class="comment mt-5">
                    <?php if (is_array($notification_data) || is_object($notification_data)) : ?>
                        <?php foreach ($notification_data as $comments) : ?>
                            <!-- 自分のコメントは表示しない -->
                            <?php if ($comments['user_id'] !== $userId) : ?>

                                <div class="mb-5 bg-light">
                                    <!-- area1 -->
                                    <div class="area1 d-flex px-3 py-4">
                                        <div class="info-left col-6">
                                            <div class="icon_box">
                                                <p>ICON</p>
                                            </div>
                                        </div>

                                        <div class="info-center col-6">
                                            <?php h($comments['name']) ?> ｜ <?php h($comments['department']) ?> ｜
                                            <?php h($comments['school_year']) ?>
                                        </div>
                                    </div>

                                    <div class="px-3">
                                        <?php h($comments['comment']) ?>
                                    </div>

                                    <div>
                                        <a href="../comment/comment.php?post_id=<?php h($comments['post_id']) ?>">コメントに返信する</a>
                                        <a href="./already_read.php?reply_id=<?php h($comments['reply_id']) ?>">既読にする</a>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
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