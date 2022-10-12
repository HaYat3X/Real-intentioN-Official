<?php

// セッションスタート
session_start();

// ユーザロジックファイルの読み込み
require '/Applications/MAMP/htdocs/Deliverables3/class/userLogic.php';

// エラーメッセージが入る配列を用意
$err = [];


// 仮変数用意
$email = filter_input(INPUT_POST, 'email');

// フォームから送信を行なっていない場合
if (!$email) {
    header('Location: auth_form.php');
}

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
        echo 'メールアドレスにトークンを送信しました。';
        header('refresh:5;url=token.php');
    } else {
        $err[] = 'トークンの送信に失敗しました。';
    }
}

if (count($err) > 0) {
    // エラー出力
    foreach ($err as $e) {
        echo $e;
    }
}
