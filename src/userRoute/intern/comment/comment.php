<?php

session_start();

// クラスファイルインポート
require __DIR__ . '../../../../../class/InternLogic.php';

// functionファイルインポート
require __DIR__ . '../../../../../function/functions.php';

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

// コメントする投稿IDの取得
$post_id = filter_input(INPUT_GET, 'post_id');

// コメントするデータを取得する
$post_date = $obj::selectInternOneDate($post_id);

// 投稿に対するコメントを取得する
$comment_date = $obj::selectInternCommentDate($post_id);

// フォームリクエストを受け取る
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 投稿を保存する
    $commentInsert = $obj::insertInternCommentDate($_POST, $userId);

    // 投稿成功時
    if ($commentInsert) {

        // 変数にリダイレクト先URLを格納する（パラメータ付きURLにリダイレクトさせる想定）
        $url = "comment.php?post_id=" . $_POST['post_id'];
        header("Location:" . $url);
    } else {
        header('Location: ../view.php');
    }
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../../public/img/favicon.ico">
    <link rel="stylesheet" href="../../../../public/css/intern/comment.css">
    <title>「Real intentioN」 / インターン体験記</title>
    <!-- font-awesomeのインポート -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />

</head>

<body>
    <?php include '/Applications/MAMP/htdocs/Deliverables3/public/template/header2.html'; ?>

    <div class="wrap">
        <div class="main">
            <div class="main_content">
                <?php foreach ($post_date as $row) : ?>
                    <!-- コメントするデータを表示 -->
                    <?php if ($row['id'] === $post_id) : ?>
                        <div class="posts">
                            <div class="area1">
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
                                <div class="userInformation">
                                    <label class="one" style="margin-left: 570px;">
                                        <?php h($row['name']) ?> ｜ <?php h($row['department']) ?> ｜ <?php h($row['school_year']) ?>
                                    </label>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>

                <div>
                    <form action="./comment.php" method="post">
                        <textarea name="content" cols="100" rows="10"></textarea>
                        <input type="hidden" name="post_id" value="<?php h($post_id) ?>">
                        <button type="submit">コメントする</button>
                    </form>
                </div>

                <div>
                    <?php foreach ($comment_date as $rowComment) : ?>
                        <p><?php h($rowComment['comment']) ?></p>
                        <div class="userInformation">
                            <label class="one">
                                <?php h($rowComment['name']) ?> ｜ <?php h($rowComment['department']) ?> ｜ <?php h($rowComment['school_year']) ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="side">
            <div class="side_content">
                <p>a</p>
            </div>
        </div>
    </div>
</body>

</html>