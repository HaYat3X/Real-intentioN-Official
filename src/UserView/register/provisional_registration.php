<?php

session_start();

// クラスファイルインポート
require __DIR__ . '../../../../class/Logic.php';

// functionファイルインポート
require __DIR__ . '../../../../function/functions.php';

// クラスのインポート
$user_obj = new UserLogic();

// err配列準備
$err = [];

// フォームリクエストを受け取る
if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    // バリーデーションチェック
    if (!$email = filter_input(INPUT_POST, 'email')) {
        $err[] =  'メールアドレスを入力してください。';
    }

    // 正規表現
    if (!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@st.kobedenshi.ac.jp/", $email)) {
        $err[] = '「@st.kobedenshi.ac.jp」のメールアドレスを入力してください。';
    }

    // すでにメールアドレスが登録されている場合エラー出力
    $alreadyEmail = $user_obj::user_exist_check($email);

    // 返り値がTrueであれば登録できない
    if ($alreadyEmail) {
        $err[] = '指定のメールアドレスは既に登録されています。ログインしてください。';
    }

    // エラーに引っかからない場合メールアドレスにトークンを送信する
    if (count($err) === 0) {
        $token = genRandomStr();

        // トークン送信
        $send_token = $user_obj::push_token($email);

        if (!$send_token) {
            $err[] = 'トークンの送信に失敗しました。';
        }

        // セッションにトークン格納
        $_SESSION['token'] = $send_token;
        $_SESSION['email'] = $email;
        header('refresh:3;url=./auth_email_form.php');
    }
} else {
    $err[] = '不正なリクエストです。';
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
            <a href="./provisional_registration_form.php">戻る</a>
        </div>
    <?php endif; ?>

    <?php if (count($err) === 0) : ?>
        <label>メールアドレスにトークンを送信しました。</label>
    <?php endif; ?>
</body>

</html>