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

// コメントする投稿IDの取得
$post_id = filter_input(INPUT_GET, 'post_id');

// SQL発行
$sql = 'SELECT i.id, i.user_id, i.company, i.format, i.content, i.question, i.answer, i.ster, i.field, u.name, u.department, u.school_year FROM intern_table i, user_master u WHERE i.user_id = u.id AND i.id = ? ORDER BY i.id DESC';

// コメント元取得
$post_date = $obj::post_one_acquisition($sql, $post_id);

// SQL2発行
$sql2 = 'SELECT r.id, r.post_id, r.user_id, r.comment, u.name, u.department, u.school_year FROM intern_reply_table r, user_master u WHERE r.user_id = u.id AND r.post_id = ? ORDER BY r.id DESC';

// 投稿に紐付いたコメントを取得
$comment_date = $obj::post_one_acquisition($sql2, $post_id);

// フォームリクエストを受け取る
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // SQL3発行
    $sql3 = 'INSERT INTO `intern_reply_table`(`post_id`, `user_id`, `comment`) VALUES (?, ?, ?)';

    $bind = [];
    $bind[] = $_POST['post_id'];
    $bind[] = $_POST['user_id'];
    $bind[] = $_POST['content'];

    // 投稿を保存する
    $commentInsert = $obj::post_submission($sql3, $bind);

    // 投稿失敗時
    if (!$commentInsert) {
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
                <?php if (is_array($post_date) || is_object($post_date)) : ?>

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
                <?php endif; ?>

                <div>
                    <form action="./comment.php" method="post">
                        <textarea required name="content" cols="100" rows="10"></textarea>
                        <input type="hidden" name="post_id" value="<?php h($post_id) ?>">
                        <input type="hidden" name="user_id" value="<?php h($userId) ?>">
                        <button type="submit">コメントする</button>
                    </form>
                </div>

                <div>
                    <?php if (is_array($comment_date) || is_object($comment_date)) : ?>
                        <?php foreach ($comment_date as $rowComment) : ?>
                            <p><?php h($rowComment['comment']) ?></p>
                            <div class="userInformation">
                                <label class="one">
                                    <?php h($rowComment['name']) ?> ｜ <?php h($rowComment['department']) ?> ｜ <?php h($rowComment['school_year']) ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
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