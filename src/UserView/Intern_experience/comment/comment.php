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

// コメントする投稿IDの取得
$post_id = filter_input(INPUT_GET, 'post_id');
$argument = $arr_prm_inst->student_post_one_prm($post_id);

// パラメータがない場合れダイレクト
if (!$post_id) {
    $url = '../../../Incorrect_request.php';
    header('Location:' . $url);
}

// SQL発行
$sql = 'SELECT * FROM `intern_table` INNER JOIN `student_master` ON intern_table.user_id = student_master.student_id AND intern_table.post_id = ?';

// コメント元取得
$post_date = $db_inst->data_select_argument($sql, $argument);

// 投稿に日も付いたコメントを取得するSQL
$sql2 = 'SELECT * FROM `intern_reply_table` INNER JOIN `student_master` ON intern_reply_table.user_id = student_master.student_id AND intern_reply_table.post_id = ? ORDER BY intern_reply_table.reply_id DESC';

// 投稿に紐付いたコメントを取得
$comment_date = $db_inst->data_select_argument($sql2, $argument);


// フォームリクエストを受け取る
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // SQL3発行
    $sql3 = 'INSERT INTO `intern_reply_table`(`post_id`, `post_user_id`, `user_id`, `comment`, `read_status`) VALUES (?, ?, ?, ?, ?)';

    $post_id = filter_input(INPUT_POST, 'post_id');
    $post_user_id = filter_input(INPUT_POST, 'post_user_id');
    $user_id = filter_input(INPUT_POST, 'user_id');
    $comment = filter_input(INPUT_POST, 'comment');
    $read = filter_input(INPUT_POST, 'read');

    $argument = $arr_prm_inst->student_comment_post_prm($post_id, $post_user_id, $user_id, $comment, $read);

    // 投稿を保存する
    $comment_insert = $db_inst->data_various_kinds($sql3, $argument);

    // 投稿失敗時
    if (!$comment_insert) {
        header('Location: ../view.php');
    }

    // 変数にリダイレクト先URLを格納する（パラメータ付きURLにリダイレクトさせる想定）
    $url = "comment.php?post_id=" . $_POST['post_id'];
    header("Location:" . $url);
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
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- <div class="bg-light"> -->
    <main role="main" class="container mt-5">
        <div class="row">

            <div class="col-md-8">
                <?php if (is_array($post_date) || is_object($post_date)) : ?>
                    <?php foreach ($post_date as $posts) : ?>
                        <!-- コメントする投稿のみ表示する -->

                        <!-- 投稿したユーザIDを取得」-->
                        <?php $post_user_id = $posts['user_id']; ?>

                        <div class="mb-5 bg-light">

                            <!-- area1 -->
                            <div class="area1 d-flex px-3 py-4">
                                <div class="info-left col-2">
                                    <div class="square_box">
                                        <p>INTERN</p>
                                    </div>
                                </div>

                                <div class="info-center col-9">
                                    <?php h($posts['company']) ?><span style="margin: 0 10px;">/</span><?php h($posts['field']) ?><span style="margin: 0 10px;">/</span><?php h($posts['format']) ?>

                                    <p><?php h($posts['content']) ?></p>

                                    <p><?php h($posts['ster']) ?></p>
                                </div>

                                <div class="info-right col-1 ms-4">
                                    <?php if ($userId == $posts['user_id']) : ?>
                                        <div class="btn-group">

                                            <div class="btn-group dropstart" role="group">
                                                <button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <span class="visually-hidden">Toggle Dropstart</span>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-dark">

                                                    <li><a href="./delete/delete_check.php?post_id=<?php h($posts['post_id']) ?>" class="dropdown-item">削除</a></li>
                                                    <li><a class="dropdown-item" href="./update/update_form.php?post_id=<?php h($posts['post_id']) ?>">編集</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="question px-3">
                                <span>Q.</span><?php h($posts['question']) ?>
                            </div>

                            <div class="answer px-3">
                                <span>A.</span><?php h($posts['answer']) ?>
                            </div>

                            <div class="area2 d-flex px-3 py-4">
                                <div class="question-btn col-7">
                                    <a href="./comment.php?post_id=<?php h($posts['post_id']) ?>" class="btn btn-primary">投稿者に質問する</a>
                                </div>

                                <div class="post-name col-5 pt-2">
                                    <?php h($posts['name']) ?> ｜ <?php h($posts['department']) ?> ｜
                                    <?php h($posts['school_year']) ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>

                <!-- コメント -->

                <form action="./comment.php" method="post">
                    <div class="mb-2">
                        <label for="exampleFormControlTextarea1" class="form-label">コメント</label>
                        <textarea class="form-control" name="comment" id="exampleFormControlTextarea1" rows="3"></textarea>
                        <input type="hidden" name="post_id" value="<?php h($post_id) ?>">
                        <input type="hidden" name="user_id" value="<?php h($userId) ?>">

                        <!-- コメントする投稿を投稿したユーザIDを格納 -->
                        <input type="hidden" name="post_user_id" value="<?php h($post_user_id) ?>">
                        <input type="hidden" name="read" value="<?php h('0') ?>">
                    </div>

                    <button class="btn btn-primary">コメントする</button>
                </form>


                <!-- コメント表示 -->
                <div class="comment mt-5">
                    <?php if (is_array($comment_date) || is_object($comment_date)) : ?>
                        <?php foreach ($comment_date as $comments) : ?>

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
                            </div>

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