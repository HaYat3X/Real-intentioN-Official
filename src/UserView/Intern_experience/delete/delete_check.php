<?php

session_start();

// クラスファイルインポート
require __DIR__ . '../../../../../class/Logic.php';

// functionファイルインポート
require __DIR__ . '../../../../../function/functions.php';

// オブジェクト
$obj = new PostLogic();

// ログインチェック
$login_check = $obj::login_check();

// ログインチェックの返り値がfalseの場合ログインページにリダイレクト
if (!$login_check) {
    header('Location: ../login/login_form.php');
}

// ユーザID取得
foreach ($login_check as $row) {
    $userId = $row['id'];
}

// 削除する投稿IDの取得
$delete_id = filter_input(INPUT_GET, 'post_id');
var_dump($delete_id);

// SQL発行
$sql = 'SELECT i.id, i.user_id, i.company, i.format, i.content, i.question, i.answer, i.ster, i.field, u.name, u.department, u.school_year FROM intern_table i, user_master u WHERE i.user_id = u.id AND i.id = ? ORDER BY i.id DESC';

// 削除データ取得
$delete_date = $obj::post_one_acquisition($sql, $delete_id);


// 削除対象データがない場合はリダイレクト
if (!$delete_date) {
    header('Location: ../view.php');
}

// 投稿者IDとログイン中のユーザのIDが一致しなければリダイレクト
foreach ($delete_date as $date) {
    if (!$userId == $date['user_id']) {
        header('Location: ../view.php');
    }

    // 削除するID
    $post_id = $date['id'];
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
                <div class="mb-5 bg-light">

                    <!-- area1 -->
                    <div class="area1 d-flex px-3 py-4">
                        <div class="info-left col-2">
                            <div class="square_box">
                                <p>INTERN</p>
                            </div>
                        </div>

                        <div class="info-center col-10">
                            <?php h($date['company']) ?><span style="margin: 0 10px;">/</span><?php h($date['field']) ?><span style="margin: 0 10px;">/</span><?php h($date['format']) ?>

                            <p><?php h($date['content']) ?>s</p>

                            <p><?php h($date['ster']) ?></p>
                        </div>


                    </div>

                    <div class="question px-3">
                        <span>Q.</span><?php h($date['question']) ?>
                    </div>

                    <div class="answer px-3">
                        <span>A.</span><?php h($date['answer']) ?>
                    </div>

                    <div class="area2 d-flex px-3 py-4">
                        <div class="post-name col-5 pt-2">
                            <?php h($date['name']) ?> ｜ <?php h($date['department']) ?> ｜ <?php h($date['school_year']) ?>
                        </div>
                    </div>

                    <div class="btn-group">
                        <div>
                            <a href="../view.php" class="btn btn-primary">削除キャンセル</a>
                        </div>

                        <form action="./delete.php" method="post">
                            <input type="hidden" name="post_id" value="<?php h($post_id) ?>">
                            <button class="btn btn-primary">削除実行</button>
                        </form>

                    </div>
                </div>
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