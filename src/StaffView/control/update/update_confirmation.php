<?php

session_start();

// 外部ファイルのインポート
require '../../../../class/SystemLogic.php';
require '../../../../function/functions.php';

// インスタンス化
$val_inst = new DataValidationLogics();
$arr_prm_inst = new ArrayParamsLogics();
$db_inst = new DatabaseLogics();
$student_inst = new StaffLogics();

$err_array = [];

// ログインチェック
$userId = $student_inst->get_staff_id();

// ログインチェックの返り値がfalseの場合ログインページにリダイレクト　（不正なリクエストとみなす）
if (!$userId) {
    $url = '../../Incorrect_request.php';
    header('Location:' . $url);
}

// 編集する投稿IDの取得
$update_post_id = filter_input(INPUT_GET, 'post_id');

// postリクエストがない場合リダイレクト
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $type = filter_input(INPUT_POST, 'type');
    $format = filter_input(INPUT_POST, 'format');
    $field = filter_input(INPUT_POST, 'field');
    $time = filter_input(INPUT_POST, 'time');
    $company = filter_input(INPUT_POST, 'company');
    $overview = filter_input(INPUT_POST, 'overview');
    $attachment = filter_input(INPUT_POST, 'attachment');


    if (!$val_inst->staff_post_val($type, $format, $field, $time, $company, $overview, $attachment)) {
        $err_array[] = $val_inst->getErrorMsg();
    }
} else {
    $url = '../../../Incorrect_request.php';
    header('Location:' . $url);
}

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        body {
            background-color: #e6e6e6;
        }

        header {
            background-color: #D6E4E5;
        }

        footer {
            background-color: #D6E4E5;
        }

        .nav-link {
            font-weight: bold;
        }

        .nav-link:hover {
            text-decoration: underline;
        }

        .login-btn {
            background-color: #EB6440;
            color: white;
        }

        .login-btn:hover {
            color: white;
            background-color: #eb6540c1;
        }

        .box {
            background-color: white;
            border-radius: 5px;
        }
    </style>
</head>

<body>
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
                        <div class="err-msg">
                            <?php if (count($err_array) > 0) : ?>
                                <?php foreach ($err_array as $err_msg) : ?>
                                    <p style="color: red;"><?php h($err_msg); ?></p>
                                <?php endforeach; ?>
                                <div class="backBtn">
                                    <a class="btn btn-primary px-4" href="./update_form.php?post_id=<?php h($update_post_id) ?>">戻る</a>
                                </div>
                            <?php endif; ?>
                        </div>


                        <?php if (count($err_array) === 0) : ?>
                            <form class="mt-5 mb-5" action="./update.php" method="post">

                                <h1 class="text-center fs-2 mb-5">編集内容を確認する</h1>
                                <div class="mb-4">
                                    <label class="form-label" for="name">投稿情報の種類</label>
                                    <input class="form-control" 　type="text" name="type" value="<?php h($type) ?>" readonly>
                                </div>



                                <div class="mb-4">
                                    <label class="form-label" for="name">イベント形式</label>
                                    <input class="form-control" 　type="text" name="format" value="<?php h($format) ?>" readonly>
                                </div>



                                <div class="mb-4">
                                    <label class="form-label" for="name">イベント分野</label>
                                    <input class="form-control" 　type="text" name="field" value="<?php h($field) ?>" readonly>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label" for="name">イベント日時</label>
                                    <input class="form-control" type="date" name="time" value="<?php h($time) ?>" readonly>
                                </div>


                                <div class="mb-4">
                                    <label class="form-label" for="name">企業名</label>
                                    <input class="form-control" type="text" name="company" value="<?php h($company) ?>" readonly>
                                </div>



                                <div class="mb-4">
                                    <label for="exampleFormControlTextarea1" class="form-label">イベント内容</label>
                                    <textarea class="form-control" name="overview" id="exampleFormControlTextarea1" rows="8" readonly><?php h($overview) ?></textarea>
                                </div>


                                <div class="mb-4">
                                    <label for="exampleFormControlTextarea1" class="form-label">添付資料</label>
                                    <input class="form-control" type="text" name="attachment" value="<?php h($attachment) ?>" readonly>
                                </div>

                                <input type="hidden" name="post_id" value="<?php h($update_post_id) ?>">

                                <a href="./update_form.php" class="btn btn-primary px-4">書き直す</a>
                                <button type="submit" class="login-btn btn px-4">更新する</button>
                            </form>
                        <?php endif; ?>
                    </div>



                </div>
            </div>


            <div class="side-bar col-md-4 bg-light sticky-top h-100">
                <div class="d-flex flex-column flex-shrink-0 p-3 bg-light">
                    <ul class="nav nav-pills flex-column mb-auto">
                        <li class="nav-item">
                            <a style="background-color: #EB6440;" href="./view.php" class="nav-link active" aria-current="page">
                                インターン体験記
                            </a>
                        </li>
                        <li>
                            <a href="../staff_information/staff_information.php" class="nav-link link-dark">
                                インターン / イベント情報 / 説明会情報
                            </a>
                        </li>
                    </ul>

                </div>
            </div>

        </div><!-- Div row 終了-->
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>