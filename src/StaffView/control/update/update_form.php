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
    header('Location: ../../login/login_form.php');
}

// ユーザID取得
foreach ($login_check as $row) {
    $staffId = $row['id'];
}

// 編集する投稿IDの取得
$update_id = filter_input(INPUT_GET, 'post_id');

// SQL発行
$sql = 'SELECT i.id, i.staff_id, i.company, i.format, i.field, i.overview, i.time, i.attachment, u.name FROM intern_information i, staff_master u WHERE i.staff_id = u.id AND i.id = ? ORDER BY i.id DESC';

// 更新データ取得
$update_date = $obj::post_one_acquisition($sql, $update_id);

// 編集対象データがない場合はリダイレクト
if (!$update_date) {
    header('Location: ../post_list.php');
}

// 投稿者IDとログイン中のユーザのIDが一致しなければリダイレクト
foreach ($update_date as $date) {
    if (!$staffId == $date['staff_id']) {
        header('Location: ../view.php');
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../../public/css/intern/post_form.css">
    <title>Document</title>
</head>

<body>
    <div class="wrap">
        <div class="main">
            <div class="main_content">
                <form action="./update_confirmation.php" method="post">
                    <?php foreach ($update_date as $row) : ?>
                        <div class="box">
                            <h2>編集する</h2>
                            <p><label style="margin-right: 68px;">企業名</label><input style="width: 300px; height:35px; font-size:20px; border-radius: 5px; border: 2px solid blue;" type="text" name="company" required value="<?php h($row['company']) ?>"></p>

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


                            <p><label style="margin-right: 48px;">メッセージ</label><textarea name="overview" style="width: 650px; height:200px; font-size:20px; resize:none; border-radius: 5px; border: 2px solid blue;"><?php h($row['overview']) ?></textarea></p>

                            <p><label style="margin-right: 48px;">応募期限</label><input type="date" name="time" value="<?php h($row['time']) ?>"></p>

                            <p><label style="margin-right: 48px;">添付資料</label><textarea name="attachment" style="width: 650px; height:200px; font-size:20px; resize:none; border-radius: 5px; border: 2px solid blue;"><?php h($row['attachment']) ?></textarea></p>

                            <!-- hiddenでuser_idを送信 -->
                            <input type="hidden" name="user_id" value="<?php h($staffId) ?>">

                            <!-- hiddenでpost_idを送信 -->
                            <input type="hidden" name="post_id" value="<?php h($row['id']) ?>">

                            <div class="submit">
                                <button type="submit">確認する</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
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