<?php

session_start();

// インターンロジックファイルの読み込み
require '/Applications/MAMP/htdocs/Deliverables3/class/InternLogic.php';

// ファンクションファイルの読み込み
require '/Applications/MAMP/htdocs/Deliverables3/function/functions.php';

// ログインチェック
$result = InternLogic::loginCheck();

// ログインチェックの返り値がfalseの場合ログインページにリダイレクト
if (!$result) {
    header('Location: ../login/login_form.php');
}

// ユーザID取得
$userId = $result['id'];


// インターンデータ取得メソッドの読み込み
$results = InternLogic::selectInternDate();

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

    <!-- jquery読み込み -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>
    <?php include '/Applications/MAMP/htdocs/Deliverables3/public/template/header2.html'; ?>

    <div class="wrap">
        <div class="main">
            <div class="main_content">
                <?php foreach ($results as $row) : ?>
                    <div class="posts">
                        <div class="area1">
                            <div class="parent">
                                <p class="child">INTERN</p>
                            </div>

                            <div class="information">
                                <div class="company">
                                    <h3><?php h($row['company']) ?></h3>

                                    <!-- 星の数値によって表示する内容を変える -->
                                    <?php if ($row['ster'] == 5) : ?>
                                        <label>総合レビュー：
                                            <span>
                                                <i style="color:#f6d04d;" class="fa-solid fa-star"></i>
                                                <i style="color:yellow;" class="fa-solid fa-star"></i>
                                                <i style="color:yellow;" class="fa-solid fa-star"></i>
                                                <i style="color:yellow;" class="fa-solid fa-star"></i>
                                                <i style="color:yellow;" class="fa-solid fa-star"></i>
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
                                                <i style="color:yellow;" class="fa-solid fa-star"></i>
                                                <i style="color:yellow;" class="fa-solid fa-star"></i>
                                                <i style="color:yellow;" class="fa-solid fa-star"></i>
                                                <i style="color:gray" class="fa-solid fa-star"></i>
                                                <i style="color:gray" class="fa-solid fa-star"></i>
                                            </span>
                                        </label>
                                    <?php elseif ($row['ster'] == 2) : ?>
                                        <label>総合レビュー：
                                            <span>
                                                <i style="color:yellow;" class="fa-solid fa-star"></i>
                                                <i style="color:yellow;" class="fa-solid fa-star"></i>
                                                <i style="color:gray" class="fa-solid fa-star"></i>
                                                <i style="color:gray" class="fa-solid fa-star"></i>
                                                <i style="color:gray" class="fa-solid fa-star"></i>
                                            </span>
                                        </label>
                                    <?php elseif ($row['ster'] == 1) : ?>
                                        <label>総合レビュー：
                                            <span>
                                                <i style="color:yellow;" class="fa-solid fa-star"></i>
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
                                    <p><label><?php h($row['format']) ?></label></p>
                                </div>
                            </div>
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
                                <a href="#">投稿者に質問する</a>
                            </div>

                            <div class="userInformation">
                                <label class="one">
                                    <?php h($row['name']) ?> ｜ <?php h($row['department']) ?> ｜ <?php h($row['school_year']) ?>
                                </label>
                            </div>
                        </div>

                        <div class="area4">
                            <!-- 投稿者である場合編集、削除表示 -->
                            <?php if ($userId == $row['user_id']) : ?>
                                <p>テスト</p>
                            <?php endif; ?>
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