<?php

session_start();

// クラスファイルインポート
require __DIR__ . '../../../../class/Logic.php';

// functionファイルインポート
require __DIR__ . '../../../../function/functions.php';

// オブジェクト
$post_obj = new PostLogic();

// ログインチェック（職員）
$login_check = $post_obj::login_check_staff();

// ログインチェックの返り値がfalseの場合ログインページにリダイレクト
if (!$login_check) {
    header('Location: ../login/login_form.php');
}

// 職員ID取得
foreach ($login_check as $row) {
    $staffId = $row['id'];
}

// SQL発行
$sql = 'SELECT i.id, i.staff_id, i.company, i.format, i.field, i.overview, i.time, i.attachment, u.name FROM intern_information i, staff_master u WHERE i.staff_id = u.id ORDER BY id DESC';

// テーブル全部取得
$results = $post_obj::post_acquisition($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>職員用のやつ</h1>
    <?php if (is_array($results) || is_object($results)) : ?>
        <?php foreach ($results as $row) : ?>
            <hr>
            <p>職員の名前<?php h($row['name']) ?></p>
            <p>企業名<?php h($row['company']) ?></p>
            <p>参加形式<?php h($row['format']) ?></p>
            <p>メッセージ<?php h($row['overview']) ?></p>
            <p>分野<?php h($row['field']) ?></p>
            <p>応募期限<?php h($row['time']) ?></p>
            <p>添付資料<?php h($row['attachment']) ?></p>
            <p><a href="">削除</a>　｜　<a href="./update/update_form.php?post_id=<?php h($row['id']) ?>">編集</a>　｜　<a href="">コメント一覧</a></p>
            <hr>
        <?php endforeach; ?>
    <?php endif; ?>
</body>

</html>