<?php

session_start();

// クラスファイルインポート
require __DIR__ . '../../../../../class/Logic.php';

// functionファイルインポート
require __DIR__ . '../../../../../function/functions.php';

// オブジェクト
$obj = new PostLogic();

// ログインチェック
$login_check = $obj::login_check();

// ログインチェックの返り値がfalseの場合ログインページにリダイレクト
if (!$login_check) {
    header('Location: ../login/login_form.php');
}

// ユーザID取得
foreach ($login_check as $row) {
    $userId = $row['id'];
}

// 質問の配列
$array = [
    '体験内容について教えてください。',
    'インターンに参加は選考に有利になったと思いますか？',
    'index'
];

// ランダムに質問の配列の値を呼ぶ
$responses = $array[array_rand($array)];

?>

<!-- <!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../../../public/img/favicon.ico">
    <link rel="stylesheet" href="../../../../public/css/intern/post_form.css">
    <title>「Real intentioN」 / インターン体験記</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
</head>

<body>

    <div class="wrap">
        <div class="main">
            <div class="main_content">
                <form action="./post_confirmation.php" method="post">
                    <div class="box">
                        <h2>インターン体験記を投稿する</h2>
                        <p><label style="margin-right: 68px;">企業名</label><input style="width: 300px; height:35px; font-size:20px; border-radius: 5px; border: 2px solid blue;" type="text" name="company" required></p>

                        <p><label style="margin-right: 48px;">体験内容</label><input style="width: 650px; height:35px; font-size:20px; border-radius: 5px; border: 2px solid blue;" type="text" name="content" required></p>

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

                        <p>
                            <label style="margin-right: 60px;">質問</label>
                            <span style="font-size:20px; margin-left:30px;">
                                <?php h($responses); ?>
                            </span>d
                        </p>

                        <p><label style="margin-right: 48px;">回答内容</label><textarea name="answer" style="width: 650px; height:200px; font-size:20px; resize:none; border-radius: 5px; border: 2px solid blue;"></textarea></p>



                        <div class="review-wrap">
                            <div class="review">
                                <label style="margin-right: 42px;">総合評価</label>
                            </div>

                            <div class="rate-form">
                                <input id="star5" type="radio" name="ster" value="5">
                                <label for="star5">★</label>
                                <input id="star4" type="radio" name="ster" value="4">
                                <label for="star4">★</label>
                                <input id="star3" type="radio" name="ster" value="3">
                                <label for="star3">★</label>
                                <input id="star2" type="radio" name="ster" value="2">
                                <label for="star2">★</label>
                                <input id="star1" type="radio" name="ster" value="1">
                                <label for="star1">★</label>
                            </div>
                        </div>


                        <input type="hidden" name="question" value="<?php h($responses) ?>">

                     
                        <input type="hidden" name="user_id" value="<?php h($userId) ?>">

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

</html> -->

<!-- ------------------------------------------------------------------------------- -->

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        body {
            background-color: #e6e6e6;
        }



        .square_box {
            position: relative;
            max-width: 100px;
            background: #ffb6c1;
        }

        .square_box::before {
            content: "";
            display: block;
            padding-bottom: 100%;
        }

        .square_box p {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .side-area {
            position: sticky;
            top: 60px;
        }
    </style>
</head>

<body>

    <!-- テスト-------------------------------------------------------------------------------------------- -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light py-4">
            <div class="container">
                <img style="width: 45px; height:45px; margin-right:10px;" src="../../../public/img/logo.png" alt="">
                <a class="navbar-brand" href="#">Real intentioN</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="#">職員の方はこちら</a>
                        </li>
                        <button class="btn btn-primary ms-3">ログインはこちら</button>
                    </ul>
                </div>
            </div>
        </nav>
    </header>



    <main role="main" class="container mt-5" style="padding: 0px">
        <div class="row">


            <div class="col-md-8">
                <div class="bg-light py-3">
                    <div class="mx-auto col-lg-8">
                        <form class="mt-5" action="./post_confirmation.php" method="post">

                            <div class="mb-2">
                                <label class="form-label" for="name">企業名</label>
                                <input class="form-control" type="text" name="company" id="name">
                            </div>

                            <div class="mb-2">
                                <label class="form-label" for="name">体験内容</label>
                                <input class="form-control" type="text" name="company" id="name">
                            </div>

                            <div class="mb-2">
                                <label class="form-label" for="name">参加形式</label>
                                <select class="form-select" name="format" aria-label="Default select example">

                                    <option selected>-- 選択してください！ --</option>
                                    <option value="オンライン形式">オンライン形式</option>
                                    <option value="対面形式">対面形式</option>
                                </select>
                            </div>

                            <div class="mb-2">
                                <label class="form-label" for="name">質問内容</label>
                                <input class="form-control" type="text" name="question" readonly value="<?php h($responses) ?>" id="name">
                                <!-- <select class="form-select" name="format" aria-label="Default select example">

                                    <option selected>-- 選択してください！ --</option>
                                    <option value="メーカ">メーカ</option>
                                    <option value="IT・ソフトウェア">IT・ソフトウェア</option>
                                </select> -->
                            </div>

                            <button type="submit" class="btn btn-primary px-5">入力内容を確認する</button>
                        </form>
                    </div>
                </div>
            </div>


            <div class="col-md-4 bg-warning sticky-top vh-100">
                <div>
                    <h1>送信</h1>
                </div>
                <!-- <ul class=" list-group">
                    <li class="list-group-item list-group-item-light">Latest Posts</li>
                    <li class="list-group-item list-group-item-light">Announcements</li>
                </ul> -->
            </div><!-- col-md-4 終了-->



        </div><!-- Div row 終了-->
    </main>
    <!-- </div> -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>