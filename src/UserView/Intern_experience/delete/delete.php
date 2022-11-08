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

if (!$delete_id = filter_input(INPUT_POST, 'post_id')) {
    header('Location: ../view.php');
};

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