<?php

session_start();

// クラスファイルインポート
require __DIR__ . '../../../../class/Logic.php';

// functionファイルインポート
require __DIR__ . '../../../../function/functions.php';

// クラスのインポート
$obj = new UserLogic();

// err配列準備
$err = [];

// フォームリクエストを受け取る
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // バリーデーションチェック
    if (!$password = filter_input(INPUT_POST, 'password')) {
        $err[] =  'パスワードを入力してください。';
    }

    if (!$password = filter_input(INPUT_POST, 'name')) {
        $err[] =  '名前を入力してください。';
    }

    if (!$department = filter_input(INPUT_POST, 'department')) {
        $err[] =  '学科を入力してください。';
    }

    if (!$department = filter_input(INPUT_POST, 'school_year')) {
        $err[] =  '学年を入力してください。';
    }

    if (!$department = filter_input(INPUT_POST, 'number')) {
        $err[] =  '出席番号を入力してください。';
    }

    if (preg_match("/\A[a-z\d]{6,100}+\z/i", $password)) {
        $err[] = 'パスワードは英数字8文字以上で作成してください。';
    }

    // エラーが一つもない場合ユーザ登録する
    if (count($err) === 0) {

        // 登録する情報を配列で処理
        $arr = [];
        $arr[] = $_POST['name'];
        $arr[] = $_POST['email'];
        $arr[] = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $arr[] = $_POST['department'];
        $arr[] = $_POST['school_year'];
        $arr[] = $_POST['number'];

        // SQL発行
        $sql = 'INSERT INTO `user_master`(`name`, `email`, `password`, `department`, `school_year`, `number`) VALUES (?, ?, ?, ?, ?, ?)';

        // 登録処理
        $hasCreated = $obj::create_user($sql, $arr);

        if (!$hasCreated) {
            $err[] = '登録できませんでした';
        }
    }
} else {
    header('Location: ./provisional_registration_form.php');
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../../public/img/favicon.ico">
    <link rel="stylesheet" href="../../../public/css/register/auth.css">
    <title>「Real intentioN」 / 新規会員登録</title>
</head>

<body>
    <?php include '/Applications/MAMP/htdocs/Deliverables3/public/template/header.html'; ?>

    <div class="err">
        <?php if (count($err) > 0) : ?>
            <?php foreach ($err as $e) : ?>
                <label><?php h($e); ?></label>
            <?php endforeach; ?>
            <div class="backBtn">
                <a href="./full_registration_form.php?key=<?php h($_POST['email']) ?>">戻る</a>
            </div>
        <?php endif; ?>

        <?php if (count($err) === 0) : ?>
            <label>ユーザ登録が完了しました。</label>
            <?php header('refresh:3;url=../login/login_form.php'); ?>
        <?php endif; ?>
    </div>
</body>

</html>