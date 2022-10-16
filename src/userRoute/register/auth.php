<?php

// セッションスタート
session_start();

// ユーザロジックファイルの読み込み
require '/Applications/MAMP/htdocs/Deliverables3/class/userLogic.php';

// エラーメッセージが入る配列を用意
$err = [];

// メールアドレス変数格納
$email = filter_input(INPUT_POST, 'email');

// バリデーションチェック
if (!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@st.kobedenshi.ac.jp/", $email)) {
    $err[] = '@st.kobedenshi.ac.jpのメールアドレスを入力して下さい。';
} else {
    // メールアドレスの重複を判定するメソッド
    $hasCreated = UserLogic::checkUser($email);

    // ユーザがすでに存在する場合
    if ($hasCreated === 'NG') {
        $err[] = 'ご利用のメールアドレスは既に登録されています。ログインしてください。';
    }

    if ($hasCreated === 'OK') {

        // トークン生成メソッド
        $create_token = UserLogic::pushToken($email);

        // トークンを正常に送信できた場合
        if ($create_token) {
            // トークン情報
            $_SESSION['auth_token'] = $create_token;
            $_SESSION['email'] = $email;

            $noErr = [];
            $noErr[] = 'メールアドレスにトークンを送信しました。';
            header('refresh:3;url=token.php');
        } else {
            $err[] = 'トークンの送信に失敗しました。';
        }
    }
}

// フォームから送信を行なっていない場合
if (!$email) {
    header('Location: auth_form.php');
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
                <label><?php echo $e; ?></label>
                <div class="backBtn">
                    <a href="./auth_form.php">戻る</a>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php if (count($err) === 0) : ?>
            <?php foreach ($noErr as $ok) : ?>
                <label><?php echo $ok; ?></label>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>

</html>