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

// SQL発行
$sql = 'SELECT i.id, i.user_id, i.company, i.format, i.content, i.question, i.answer, i.ster, i.field, u.name, u.department, u.school_year FROM intern_table i, user_master u WHERE i.user_id = u.id AND i.id = ? ORDER BY i.id DESC';

// 更新データ取得
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

// SQL発行
$sql = 'DELETE FROM `intern_table` WHERE id = ?';

$arr = [];
$arr[] = $delete_id;

// 削除実行
$delete = $obj::post_delete($sql, $arr);

$err = [];

if (!$delete) {
    $err[] = '削除に失敗しました。';
}

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
    <?php if (count($err) > 0) : ?>
        <?php foreach ($err as $e) : ?>
            <label><?php h($e); ?></label>
            <div class="backBtn">
                <a href="../view.php">戻る</a>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <?php if (count($err) === 0) : ?>
        <label>削除が完了しました。</label>
        <?php header('refresh:3;url=../view.php'); ?>
    <?php endif; ?>
</body>

</html>