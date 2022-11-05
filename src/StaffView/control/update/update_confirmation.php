<?php

session_start();

// クラスファイルインポート
require __DIR__ . '../../../../../class/Logic.php';

// functionファイルインポート
require __DIR__ . '../../../../../function/functions.php';

// オブジェクト
$obj = new PostLogic();

// ログインチェック
$login_check = $obj::login_check_staff();

// ログインチェックの返り値がfalseの場合ログインページにリダイレクト
if (!$login_check) {
    header('Location: ../login/login_form.php');
}

// ユーザID取得
foreach ($login_check as $row) {
    $staffId = $row['id'];
}

// POSTリクエストを受け取る
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 入力した値を取得
    $arr = [];
    $arr[] = $_POST;
} else {
    // postリクエストがない場合リダイレクト
    header('Location: ./post_form.php');
}



?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../../../public/img/favicon.ico">
    <link rel="stylesheet" href="../../../../public/css/intern/post_form.css">
    <title>「Real intentioN」 / インターン体験記</title>
    <!-- font-awesomeのインポート -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
</head>

<body>
    <?php include '/Applications/MAMP/htdocs/Deliverables3/public/template/header.html'; ?>

    <div class="wrap">
        <div class="main">
            <div class="main_content">
                <form action="./update.php" method="post">
                    <div class="box">
                        <?php foreach ($arr as $value) : ?>
                            <h2>インターン体験記を編集する</h2>
                            <p><label style="margin-right: 68px;">企業名</label><input style="width: 300px; height:35px; font-size:20px; border-radius: 5px; border: 2px solid blue;" type="text" name="company" required value="<?php h($value['company']) ?>" readonly></p>


                            <p>
                                <label style="margin-right: 42px;">参加形式</label>

                                <?php if ($value['format'] === 'オンライン') : ?>
                                    <input id="item-1" class="radio-inline__input" type="radio" name="format" value="オンライン" checked="checked" readonly />
                                    <label style="font-size: 13px;" class="radio-inline__label" for="item-1">
                                        オンライン
                                    </label>
                                    <input id="item-2" class="radio-inline__input" type="radio" name="format" value="対面形式" readonly />
                                    <label style="font-size: 13px;" class="radio-inline__label" for="item-2">
                                        対面形式
                                    </label>
                                <?php endif; ?>

                                <?php if ($value['format'] === '対面形式') : ?>
                                    <input id="item-1" class="radio-inline__input" type="radio" name="format" value="オンライン" readonly />
                                    <label style="font-size: 13px;" class="radio-inline__label" for="item-1">
                                        オンライン
                                    </label>
                                    <input id="item-2" class="radio-inline__input" type="radio" name="format" value="対面形式" checked="checked" readonly />
                                    <label style="font-size: 13px;" class="radio-inline__label" for="item-2">
                                        対面形式
                                    </label>
                                <?php endif; ?>
                            </p>

                            <p>
                                <label style="margin-right: 42px;">参加分野</label>

                                <?php if ($value['field'] === 'メーカ') : ?>
                                    <input id="item-3" class="radio-inline__input1" type="radio" name="field" value="メーカ" checked="checked" />
                                    <label style="font-size: 13px;" class="radio-inline__label1" for="item-3">
                                        メーカ
                                    </label>

                                    <input id="item-4" class="radio-inline__input1" type="radio" name="field" value="サービス・インフラ" />
                                    <label style="font-size: 13px;" class="radio-inline__label1" for="item-4">
                                        サービス・インフラ
                                    </label>

                                    <input id="item-5" class="radio-inline__input1" type="radio" name="field" value="商社" />
                                    <label style="font-size: 13px;" class="radio-inline__label1" for="item-5">
                                        商社
                                    </label>

                                    <input id="item-6" class="radio-inline__input1" type="radio" name="field" value="金融・保険" />
                                    <label style="font-size: 13px;" class="radio-inline__label1" for="item-6">
                                        金融・保険
                                    </label>

                                    <input id="item-7" class="radio-inline__input1" type="radio" name="field" value="広告・通信" />
                                    <label style="font-size: 13px;" class="radio-inline__label1" for="item-7">
                                        広告・通信
                                    </label>

                                    <input id="item-8" class="radio-inline__input1" type="radio" name="field" value="百貨店・専門店" />
                                    <label style="font-size: 13px;" class="radio-inline__label1" for="item-8">
                                        百貨店・専門店
                                    </label>

                                    <input id="item-9" class="radio-inline__input1" type="radio" name="field" value="IT・ソフトウェア" />
                                    <label style="font-size: 13px; margin-left:127px; margin-top:10px;" class="radio-inline__label1" for="item-9">
                                        IT・ソフトウェア
                                    </label>
                                <?php endif; ?>

                                <?php if ($value['field'] === 'サービス・インフラ') : ?>
                                    <input id="item-3" class="radio-inline__input1" type="radio" name="field" value="メーカ" />
                                    <label style="font-size: 13px;" class="radio-inline__label1" for="item-3">
                                        メーカ
                                    </label>

                                    <input id="item-4" class="radio-inline__input1" type="radio" name="field" value="サービス・インフラ" checked="checked" />
                                    <label style="font-size: 13px;" class="radio-inline__label1" for="item-4">
                                        サービス・インフラ
                                    </label>

                                    <input id="item-5" class="radio-inline__input1" type="radio" name="field" value="商社" />
                                    <label style="font-size: 13px;" class="radio-inline__label1" for="item-5">
                                        商社
                                    </label>

                                    <input id="item-6" class="radio-inline__input1" type="radio" name="field" value="金融・保険" />
                                    <label style="font-size: 13px;" class="radio-inline__label1" for="item-6">
                                        金融・保険
                                    </label>

                                    <input id="item-7" class="radio-inline__input1" type="radio" name="field" value="広告・通信" />
                                    <label style="font-size: 13px;" class="radio-inline__label1" for="item-7">
                                        広告・通信
                                    </label>

                                    <input id="item-8" class="radio-inline__input1" type="radio" name="field" value="百貨店・専門店" />
                                    <label style="font-size: 13px;" class="radio-inline__label1" for="item-8">
                                        百貨店・専門店
                                    </label>

                                    <input id="item-9" class="radio-inline__input1" type="radio" name="field" value="IT・ソフトウェア" />
                                    <label style="font-size: 13px; margin-left:127px; margin-top:10px;" class="radio-inline__label1" for="item-9">
                                        IT・ソフトウェア
                                    </label>
                                <?php endif; ?>

                                <?php if ($value['field'] === '商社') : ?>
                                    <input id="item-3" class="radio-inline__input1" type="radio" name="field" value="メーカ" />
                                    <label style="font-size: 13px;" class="radio-inline__label1" for="item-3">
                                        メーカ
                                    </label>

                                    <input id="item-4" class="radio-inline__input1" type="radio" name="field" value="サービス・インフラ" />
                                    <label style="font-size: 13px;" class="radio-inline__label1" for="item-4">
                                        サービス・インフラ
                                    </label>

                                    <input id="item-5" class="radio-inline__input1" type="radio" name="field" value="商社" checked="checked" />
                                    <label style="font-size: 13px;" class="radio-inline__label1" for="item-5">
                                        商社
                                    </label>

                                    <input id="item-6" class="radio-inline__input1" type="radio" name="field" value="金融・保険" />
                                    <label style="font-size: 13px;" class="radio-inline__label1" for="item-6">
                                        金融・保険
                                    </label>

                                    <input id="item-7" class="radio-inline__input1" type="radio" name="field" value="広告・通信" />
                                    <label style="font-size: 13px;" class="radio-inline__label1" for="item-7">
                                        広告・通信
                                    </label>

                                    <input id="item-8" class="radio-inline__input1" type="radio" name="field" value="百貨店・専門店" />
                                    <label style="font-size: 13px;" class="radio-inline__label1" for="item-8">
                                        百貨店・専門店
                                    </label>

                                    <input id="item-9" class="radio-inline__input1" type="radio" name="field" value="IT・ソフトウェア" />
                                    <label style="font-size: 13px; margin-left:127px; margin-top:10px;" class="radio-inline__label1" for="item-9">
                                        IT・ソフトウェア
                                    </label>
                                <?php endif; ?>

                                <?php if ($value['field'] === '金融・保険') : ?>
                                    <input id="item-3" class="radio-inline__input1" type="radio" name="field" value="メーカ" />
                                    <label style="font-size: 13px;" class="radio-inline__label1" for="item-3">
                                        メーカ
                                    </label>

                                    <input id="item-4" class="radio-inline__input1" type="radio" name="field" value="サービス・インフラ" />
                                    <label style="font-size: 13px;" class="radio-inline__label1" for="item-4">
                                        サービス・インフラ
                                    </label>

                                    <input id="item-5" class="radio-inline__input1" type="radio" name="field" value="商社" />
                                    <label style="font-size: 13px;" class="radio-inline__label1" for="item-5">
                                        商社
                                    </label>

                                    <input id="item-6" class="radio-inline__input1" type="radio" name="field" value="金融・保険" checked="checked" />
                                    <label style="font-size: 13px;" class="radio-inline__label1" for="item-6">
                                        金融・保険
                                    </label>

                                    <input id="item-7" class="radio-inline__input1" type="radio" name="field" value="広告・通信" />
                                    <label style="font-size: 13px;" class="radio-inline__label1" for="item-7">
                                        広告・通信
                                    </label>

                                    <input id="item-8" class="radio-inline__input1" type="radio" name="field" value="百貨店・専門店" />
                                    <label style="font-size: 13px;" class="radio-inline__label1" for="item-8">
                                        百貨店・専門店
                                    </label>

                                    <input id="item-9" class="radio-inline__input1" type="radio" name="field" value="IT・ソフトウェア" />
                                    <label style="font-size: 13px; margin-left:127px; margin-top:10px;" class="radio-inline__label1" for="item-9">
                                        IT・ソフトウェア
                                    </label>
                                <?php endif; ?>

                                <?php if ($value['field'] === '広告・保険') : ?>
                                    <input id="item-3" class="radio-inline__input1" type="radio" name="field" value="メーカ" />
                                    <label style="font-size: 13px;" class="radio-inline__label1" for="item-3">
                                        メーカ
                                    </label>

                                    <input id="item-4" class="radio-inline__input1" type="radio" name="field" value="サービス・インフラ" />
                                    <label style="font-size: 13px;" class="radio-inline__label1" for="item-4">
                                        サービス・インフラ
                                    </label>

                                    <input id="item-5" class="radio-inline__input1" type="radio" name="field" value="商社" />
                                    <label style="font-size: 13px;" class="radio-inline__label1" for="item-5">
                                        商社
                                    </label>

                                    <input id="item-6" class="radio-inline__input1" type="radio" name="field" value="金融・保険" />
                                    <label style="font-size: 13px;" class="radio-inline__label1" for="item-6">
                                        金融・保険
                                    </label>

                                    <input id="item-7" class="radio-inline__input1" type="radio" name="field" value="広告・通信" checked="checked" />
                                    <label style="font-size: 13px;" class="radio-inline__label1" for="item-7">
                                        広告・通信
                                    </label>

                                    <input id="item-8" class="radio-inline__input1" type="radio" name="field" value="百貨店・専門店" />
                                    <label style="font-size: 13px;" class="radio-inline__label1" for="item-8">
                                        百貨店・専門店
                                    </label>

                                    <input id="item-9" class="radio-inline__input1" type="radio" name="field" value="IT・ソフトウェア" />
                                    <label style="font-size: 13px; margin-left:127px; margin-top:10px;" class="radio-inline__label1" for="item-9">
                                        IT・ソフトウェア
                                    </label>
                                <?php endif; ?>

                                <?php if ($value['field'] === '百貨店・専門店') : ?>
                                    <input id="item-3" class="radio-inline__input1" type="radio" name="field" value="メーカ" />
                                    <label style="font-size: 13px;" class="radio-inline__label1" for="item-3">
                                        メーカ
                                    </label>

                                    <input id="item-4" class="radio-inline__input1" type="radio" name="field" value="サービス・インフラ" />
                                    <label style="font-size: 13px;" class="radio-inline__label1" for="item-4">
                                        サービス・インフラ
                                    </label>

                                    <input id="item-5" class="radio-inline__input1" type="radio" name="field" value="商社" />
                                    <label style="font-size: 13px;" class="radio-inline__label1" for="item-5">
                                        商社
                                    </label>

                                    <input id="item-6" class="radio-inline__input1" type="radio" name="field" value="金融・保険" />
                                    <label style="font-size: 13px;" class="radio-inline__label1" for="item-6">
                                        金融・保険
                                    </label>

                                    <input id="item-7" class="radio-inline__input1" type="radio" name="field" value="広告・通信" />
                                    <label style="font-size: 13px;" class="radio-inline__label1" for="item-7">
                                        広告・通信
                                    </label>

                                    <input id="item-8" class="radio-inline__input1" type="radio" name="field" value="百貨店・専門店" checked="checked" />
                                    <label style="font-size: 13px;" class="radio-inline__label1" for="item-8">
                                        百貨店・専門店
                                    </label>

                                    <input id="item-9" class="radio-inline__input1" type="radio" name="field" value="IT・ソフトウェア" />
                                    <label style="font-size: 13px; margin-left:127px; margin-top:10px;" class="radio-inline__label1" for="item-9">
                                        IT・ソフトウェア
                                    </label>
                                <?php endif; ?>

                                <?php if ($value['field'] === 'IT・ソフトウェア') : ?>
                                    <input id="item-3" class="radio-inline__input1" type="radio" name="field" value="メーカ" />
                                    <label style="font-size: 13px;" class="radio-inline__label1" for="item-3">
                                        メーカ
                                    </label>

                                    <input id="item-4" class="radio-inline__input1" type="radio" name="field" value="サービス・インフラ" />
                                    <label style="font-size: 13px;" class="radio-inline__label1" for="item-4">
                                        サービス・インフラ
                                    </label>

                                    <input id="item-5" class="radio-inline__input1" type="radio" name="field" value="商社" />
                                    <label style="font-size: 13px;" class="radio-inline__label1" for="item-5">
                                        商社
                                    </label>

                                    <input id="item-6" class="radio-inline__input1" type="radio" name="field" value="金融・保険" />
                                    <label style="font-size: 13px;" class="radio-inline__label1" for="item-6">
                                        金融・保険
                                    </label>

                                    <input id="item-7" class="radio-inline__input1" type="radio" name="field" value="広告・通信" />
                                    <label style="font-size: 13px;" class="radio-inline__label1" for="item-7">
                                        広告・通信
                                    </label>

                                    <input id="item-8" class="radio-inline__input1" type="radio" name="field" value="百貨店・専門店" />
                                    <label style="font-size: 13px;" class="radio-inline__label1" for="item-8">
                                        百貨店・専門店
                                    </label>

                                    <input id="item-9" class="radio-inline__input1" type="radio" name="field" value="IT・ソフトウェア" checked="checked" />
                                    <label style="font-size: 13px; margin-left:127px; margin-top:10px;" class="radio-inline__label1" for="item-9">
                                        IT・ソフトウェア
                                    </label>
                                <?php endif; ?>
                            </p>

                            <p><label style="margin-right: 48px;">メッセージ</label><textarea name="overview" style="width: 650px; height:200px; font-size:20px; resize:none; border-radius: 5px; border: 2px solid blue;"><?php h($row['overview']) ?></textarea></p>

                            <p><label style="margin-right: 48px;">応募期限</label><input type="date" name="time" value="<?php h($row['time']) ?>"></p>

                            <p><label style="margin-right: 48px;">添付資料</label><textarea name="attachment" style="width: 650px; height:200px; font-size:20px; resize:none; border-radius: 5px; border: 2px solid blue;"><?php h($row['attachment']) ?></textarea></p>

                            <!-- hiddenでuser_idを送信 -->
                            <input type="hidden" name="user_id" value="<?php h($staffId) ?>">

                            <!-- hiddenでpost_idを送信 -->
                            <input type="hidden" name="post_id" value="<?php h($row['id']) ?>">
                        <?php endforeach; ?>

                        <div class="submit">
                            <a href="./post_form.php">書き直す</a>
                            <button type="submit">投稿する</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="side">
            <div class="side_content">
                <p>a</p>
            </div>
        </div>
    </div>
</body>

</html>