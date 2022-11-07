<?php

session_start();

// クラスファイルインポート
require __DIR__ . '../../../../class/Logic.php';

// functionファイルインポート
require __DIR__ . '../../../../function/functions.php';

// オブジェクト
$post_obj = new PostLogic();

// ログインチェック
$login_check = $post_obj::login_check();

// ログインチェックの返り値がfalseの場合ログインページにリダイレクト
if (!$login_check) {
    header('Location: ../login/login_form.php');
}

// ユーザID取得
foreach ($login_check as $row) {
    $userId = $row['id'];
}

// インターンデータ取得メソッドの読み込み　最低一件のデータが必要
$sql = 'SELECT i.id, i.user_id, i.company, i.format, i.content, i.question, i.answer, i.ster, i.field, u.name, u.department, u.school_year FROM intern_table i, user_master u WHERE i.user_id = u.id ORDER BY id DESC';

$results = $post_obj::post_acquisition($sql);

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
    </style>
</head>

<body>


    <div class="wrap">
        <div class="main">
            <div class="main_content">
                <?php if (is_array($results) || is_object($results)) : ?>
                    <?php foreach ($results as $row) : ?>
                        <div class="posts">
                            <div class="area1">
                                <details>
                                    <summary>
                                        <div class="parent">
                                            <p class="child">INTERN</p>
                                        </div>

                                        <div class="information">
                                            <div class="company">
                                                <h3>
                                                    <?php h($row['company']) ?> / <?php h($row['format']) ?> / <?php h($row['field']) ?>
                                                </h3>

                                                <!-- 星の数値によって表示する内容を変える -->
                                                <?php if ($row['ster'] == 5) : ?>
                                                    <label>総合レビュー：
                                                        <span>
                                                            <i style="color:#f6d04d;" class="fa-solid fa-star"></i>
                                                            <i style="color:#f6d04d;" class="fa-solid fa-star"></i>
                                                            <i style="color:#f6d04d;" class="fa-solid fa-star"></i>
                                                            <i style="color:#f6d04d;" class="fa-solid fa-star"></i>
                                                            <i style="color:#f6d04d;" class="fa-solid fa-star"></i>
                                                        </span>
                                                    </label>
                                                <?php elseif ($row['ster'] == 4) : ?>
                                                    <label>総合レビュー：
                                                        <span>
                                                            <i style="color:#f6d04d;" class="fa-solid fa-star"></i>
                                                            <i style="color:#f6d04d;" class="fa-solid fa-star"></i>
                                                            <i style="color:#f6d04d;" class="fa-solid fa-star"></i>
                                                            <i style="color:#f6d04d;" class="fa-solid fa-star"></i>
                                                            <i style="color:gray" class="fa-solid fa-star"></i>
                                                        </span>
                                                    </label>
                                                <?php elseif ($row['ster'] == 3) : ?>
                                                    <label>総合レビュー：
                                                        <span>
                                                            <i style="color:#f6d04d;" class="fa-solid fa-star"></i>
                                                            <i style="color:#f6d04d;" class="fa-solid fa-star"></i>
                                                            <i style="color:#f6d04d;" class="fa-solid fa-star"></i>
                                                            <i style="color:gray" class="fa-solid fa-star"></i>
                                                            <i style="color:gray" class="fa-solid fa-star"></i>
                                                        </span>
                                                    </label>
                                                <?php elseif ($row['ster'] == 2) : ?>
                                                    <label>総合レビュー：
                                                        <span>
                                                            <i style="color:#f6d04d;" class="fa-solid fa-star"></i>
                                                            <i style="color:#f6d04d;" class="fa-solid fa-star"></i>
                                                            <i style="color:gray" class="fa-solid fa-star"></i>
                                                            <i style="color:gray" class="fa-solid fa-star"></i>
                                                            <i style="color:gray" class="fa-solid fa-star"></i>
                                                        </span>
                                                    </label>
                                                <?php elseif ($row['ster'] == 1) : ?>
                                                    <label>総合レビュー：
                                                        <span>
                                                            <i style="color:#f6d04d;" class="fa-solid fa-star"></i>
                                                            <i style="color:gray" class="fa-solid fa-star"></i>
                                                            <i style="color:gray" class="fa-solid fa-star"></i>
                                                            <i style="color:gray" class="fa-solid fa-star"></i>
                                                            <i style="color:gray" class="fa-solid fa-star"></i>
                                                        </span>
                                                    </label>
                                                <?php elseif ($row['ster'] == 0) : ?>
                                                    <label>総合レビュー：
                                                        <span>
                                                            <i style="color:gray" class="fa-solid fa-star"></i>
                                                            <i style="color:gray" class="fa-solid fa-star"></i>
                                                            <i style="color:gray" class="fa-solid fa-star"></i>
                                                            <i style="color:gray" class="fa-solid fa-star"></i>
                                                            <i style="color:gray" class="fa-solid fa-star"></i>
                                                        </span>
                                                    </label>
                                                <?php endif; ?>

                                                <p class="curriculum"><?php h($row['content']) ?></p>
                                            </div>

                                            <div class="format">
                                                <span><i class="fa-solid fa-ellipsis-vertical"></i></span>
                                            </div>
                                        </div>
                                    </summary>

                                    <div class="area4">
                                        <!-- 投稿者である場合編集、削除表示 -->
                                        <?php if ($userId == $row['user_id']) : ?>
                                            <div class="link">
                                                <a class="edit" href="./update/update_form.php?post_id=<?php h($row['id']) ?>">編集</a>
                                                <a class="delete" href="./delete/delete.php?post_id=<?php h($row['id']) ?>">削除</a>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </details>
                            </div>

                            <div class="area2">
                                <div class="question">
                                    <span>Q.　</span><label><?php h($row['question']) ?></label>
                                </div>

                                <div class="answer">
                                    <span>A.　</span><label><?php h($row['answer']) ?></label>
                                </div>
                            </div>

                            <div class="area3">
                                <div class="reply">
                                    <a class="edit" href="./comment/comment.php?post_id=<?php h($row['id']) ?>">投稿者に質問する</a>
                                </div>

                                <div class="userInformation">
                                    <label class="one">
                                        <?php h($row['name']) ?> ｜ <?php h($row['department']) ?> ｜ <?php h($row['school_year']) ?>
                                    </label>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>


            <p>aっp</p>
        </div>

        <div class="side">
            <div class="side_content">
                <p>a</p>
            </div>
        </div>
    </div>
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
                <?php if (is_array($results) || is_object($results)) : ?>
                    <?php foreach ($results as $row) : ?>

                        <div class="mb-5 bg-light">

                            <!-- area1 -->
                            <div class="area1 d-flex px-3 py-4">
                                <div class="info-left col-2">
                                    <div class="square_box">
                                        <p>INTERN</p>
                                    </div>
                                </div>

                                <div class="info-center col-9">
                                    <?php h($row['company']) ?><span style="margin: 0 10px;">/</span><?php h($row['field']) ?><span style="margin: 0 10px;">/</span><?php h($row['format']) ?>

                                    <p><?php h($row['content']) ?>s</p>
                                </div>

                                <div class="info-right col-1 ms-4">

                                    <div class="btn-group">
                                        <div class="btn-group dropstart" role="group">
                                            <button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                                <span class="visually-hidden">Toggle Dropstart</span>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-dark">
                                                <li><a class="dropdown-item" href="#">削除</a></li>
                                                <li><a class="dropdown-item" href="#">編集</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="question px-3">
                                <span>Q.</span><?php h($row['question']) ?>
                            </div>

                            <div class="answer px-3">
                                <span>A.</span><?php h($row['answer']) ?>
                            </div>

                            <div class="area2 d-flex px-3 py-4">
                                <div class="question-btn col-7">
                                    <a href="#" class="btn btn-primary">投稿者に質問する</a>
                                </div>

                                <div class="post-name col-5 pt-2">
                                    <?php h($row['name']) ?> ｜ <?php h($row['department']) ?> ｜ <?php h($row['school_year']) ?>
                                </div>
                            </div>
                        </div>

                    <?php endforeach; ?>
                <?php endif; ?>
            </div>


            <div class="col-md-4 bg-warning">
                <ul class="list-group">
                    <li class="list-group-item list-group-item-light">Latest Posts</li>
                    <li class="list-group-item list-group-item-light">Announcements</li>
                </ul>
            </div><!-- col-md-4 終了-->


        </div><!-- Div row 終了-->
    </main>
    <!-- </div> -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>