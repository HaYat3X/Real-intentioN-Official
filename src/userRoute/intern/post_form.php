<?php

session_start();

// インターンロジックファイルの読み込み
require '/Applications/MAMP/htdocs/Deliverables3/class/InternLogic.php';

// ファンクションファイルの読み込み
require '/Applications/MAMP/htdocs/Deliverables3/function/functions.php';

// ログインチェック
$result = InternLogic::loginCheck();

// ログインチェックの返り値がfalseの場合ログインページにリダイレクト
if (!$result) {
    header('Location: ../login/login_form.php');
}

// 質問リストを用意
$array = [
    '体験内容について教えてください。',
    'インターンに参加は選考に有利になったと思いますか？',
    'お金持ち持ちですか'
    // 問題リストを追加していくといいかもね
];

// ランダムに配列の値を呼ぶ
$responses = $array[array_rand($array)];

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../../public/img/favicon.ico">
    <link rel="stylesheet" href="../../../public/css/intern/view.css">
    <title>「Real intentioN」 / インターン体験記</title>
    <!-- font-awesomeのインポート -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
</head>

<body>
    <?php include '/Applications/MAMP/htdocs/Deliverables3/public/template/header2.html'; ?>

    <form action="./post.php" method="post">
        <div class="box">
            <p><span>必須</span><label style="margin-right: 10px;">企業名</label><input type="text" name="company" required></p>

            <p><span>必須</span><label style="margin-right: 48px;">体験内容</label><input type="password" name="password" required></p>

            <p><span>必須</span><label style="margin-right: 48px;">参加形式</label><input type="password" name="password" required></p>

            <p><span>必須</span><label style="margin-right: 48px;">体験内容</label><input type="password" name="password" required></p>

            <p><span>必須</span><label style="margin-right: 48px;">質問内容</label><?php h($responses) ?></p>

            <p><span>必須</span><label style="margin-right: 48px;">回答内容</label><input type="password" name="password" required></p>

            <p><span>必須</span><label style="margin-right: 48px;">総合レビュー</label><input type="password" name="password" required></p>

            <!-- hiddenで問題内容を送信 -->
            <input type="hidden" name="question" value="<?php h($responses) ?>">

            <button type="submit">確認する</button>
        </div>
    </form>
</body>

</html>