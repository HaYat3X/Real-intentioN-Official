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
                <form action="./post_confirmation.php" method="post">
                    <div class="box">
                        <h2>イ. ターン / イベント情報を投稿する</h2>
                        <p><label style="margin-right: 68px;">企業名</label><input style="width: 300px; height:35px; font-size:20px; border-radius: 5px; border: 2px solid blue;" type="text" name="company" required></p>

                        <p>
                            <label style="margin-right: 42px;">参加形式</label>
                            <input id="item-1" class="radio-inline__input" type="radio" name="format" value="オンライン" checked="checked" />
                            <label style="font-size: 13px;" class="radio-inline__label" for="item-1">
                                オンライン
                            </label>
                            <input id="item-2" class="radio-inline__input" type="radio" name="format" value="対面形式" />
                            <label style="font-size: 13px;" class="radio-inline__label" for="item-2">
                                対面形式
                            </label>
                        </p>

                        <p>
                            <label style="margin-right: 42px;">参加分野</label>

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
                        </p>



                        <p><label style="margin-right: 48px;">インターン / イベント内容</label><textarea name="overview" style="width: 650px; height:200px; font-size:20px; resize:none; border-radius: 5px; border: 2px solid blue;"></textarea></p>

                        <p><label style="margin-right: 48px;">応募期限</label><input type="date" name="time"></p>

                        <p><label style="margin-right: 48px;">添付資料</label><textarea name="attachment" style="width: 650px; height:200px; font-size:20px; resize:none; border-radius: 5px; border: 2px solid blue;"></textarea></p>


                        <!-- hiddenでuser_idを送信 -->
                        <input type="hidden" name="user_id" value="<?php h($staffId) ?>">

                        <div class="submit">
                            <button type="submit">確認する</button>
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