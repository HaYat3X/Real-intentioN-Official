<?php

session_start();

// クラスファイルインポート
require __DIR__ . '../../../../class/Logic.php';

// functionファイルインポート
require __DIR__ . '../../../../function/functions.php';

// クラスのインポート
$user_obj = new StaffLogic();

// errメッセージが入る配列準備
$err = [];

// フォームリクエストを受け取る
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // バリーデーションチェック
    if (!$email = filter_input(INPUT_POST, 'email')) {
        $err[] =  'メールアドレスを入力してください。';
    }

    if (!$password = filter_input(INPUT_POST, 'password')) {
        $err[] =  'パスワードを入力してください。';
    }

    // ログインメソッドを実行
    $login = $user_obj::login_execution($email, $password);

    // ユーザ存在なし、パスワード不一致の場合エラーを出す
    if (!$login) {
        $err[] = 'ログインに失敗しました。';
    }
} else {
    $err[] = '不正なリクエストです。';

    // 3秒後に入力フォームへリダイレクト
    header('refresh:3;url=./login_form.php');
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
    <div class="err">
        <?php if (count($err) > 0) : ?>
            <?php foreach ($err as $e) : ?>
                <label><?php h($e); ?></label>
            <?php endforeach; ?>
            <div class="backBtn">
                <a href="./login_form.php">戻る</a>
            </div>
        <?php endif; ?>

        <?php if (count($err) === 0) : ?>
            <label>ログインが完了しました。</label>
            <?php header('refresh:3;url=../intern_experience/view.php'); ?>
        <?php endif; ?>
    </div>
</body>

</html>