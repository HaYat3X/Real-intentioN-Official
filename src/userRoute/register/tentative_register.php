<?php

session_start();

// クラスファイルインポート
require __DIR__ . '../../../../class/UserLogic.php';

// functionファイルインポート
require __DIR__ . '../../../../function/functions.php';

// クラスのインポート
$obj = new UserLogic();

// err配列準備
$err = [];

// フォームリクエストを受け取る
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // フォームから送信された値を受け取る
    $email = filter_input(INPUT_POST, 'email');


    // メールアドレスのバリデーション
    if (!$email) {
        $err[] = 'メールアドレスを入力してください。';
    };

    $validation = $obj::emailValidation($email);

    if (!$validation) {
        $err[] = '「@st.kobedenshi.ac.jp」のメールアドレスを入力してください。';
    }


    // すでにメールアドレスが登録されている場合エラー出力
    $alreadyEmail = $obj::emailCheck($email);
    if (!$alreadyEmail) {
        $err[] = '指定のメールアドレスは既に登録されています。ログインしてください。';
    }


    // エラーに引っかからない場合メールアドレスにトークンを送信する
    if (count($err) === 0) {
        $token = genRandomStr();

        // トークン送信
        $sendToken = $obj::pushToken($email);

        if (!$sendToken) {
            $err[] = 'トークンの送信に失敗しました。';
        }

        // セッションにトークン格納
        $_SESSION['token'] = $sendToken;
        $_SESSION['email'] = $email;
        header('refresh:3;url=./auth_email.php');
    }
} else {
    $err[] = '不正なリクエストです。';

    // 3秒後に入力フォームへリダイレクト
    header('refresh:3;url=./tentative_register_form.php');
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
            <p><label><?php h($e); ?></label></p>
        <?php endforeach; ?>
        <div class="backBtn">
            <a href="./tentative_register_form.php">戻る</a>
        </div>
    <?php endif; ?>

    <?php if (count($err) === 0) : ?>
        <label>メールアドレスにトークンを送信しました。</label>
    <?php endif; ?>
</body>

</html>