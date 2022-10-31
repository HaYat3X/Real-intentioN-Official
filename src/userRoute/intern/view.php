<?php

session_start();

// クラスファイルインポート
require __DIR__ . '../../../../class/InternLogic.php';

// functionファイルインポート
require __DIR__ . '../../../../function/functions.php';

// オブジェクト
$obj = new InternLogic;

// ログインチェック
$login_check = $obj::loginCheck();

// ログインチェックの返り値がfalseの場合ログインページにリダイレクト
if (!$login_check) {
    header('Location: ../login/login_form.php');
}

// ユーザID取得
foreach ($login_check as $row) {
    $userId = $row['id'];
}

// インターンデータ取得メソッドの読み込み
$results = $obj::selectInternDate();
var_dump($results);

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
</head>

<body>
    <?php include '/Applications/MAMP/htdocs/Deliverables3/public/template/header2.html'; ?>

    <div class="wrap">
        <div class="main">
            <div class="main_content">
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
                                            <a class="edit" href="#">編集</a>
                                            <a class="delete" href="#">削除</a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </details>
                        </div>
                        <!--  -->

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
                                <a href="#">投稿者に質問する</a>
                            </div>

                            <div class="userInformation">
                                <label class="one">
                                    <?php h($row['name']) ?> ｜ <?php h($row['department']) ?> ｜ <?php h($row['school_year']) ?>
                                </label>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <p>aっp</p>
            <p>aっp</p>
            <p>aっp</p>
            <p>aっp</p>
            <p>aっp</p>
            <p>aっp</p>
            <p>aっp</p>
            <p>aっp</p>
            <p>aっp</p>
            <p>aっp</p>
            <p>aっp</p>
            <p>aっp</p>
            <p>aっp</p>
            <p>aっp</p>
            <p>aっp</p>
            <p>aっp</p>
            <p>aっp</p>
            <p>aっp</p>
            <p>aっp</p>
            <p>aっp</p>
            <p>aっp</p>
            <p>aっp</p>
            <p>aっp</p>
            <p>aっp</p>
            <p>aっp</p>
        </div>

        <div class="side">
            <div class="side_content">
                <p>a</p>
            </div>
        </div>
    </div>
</body>

</html>