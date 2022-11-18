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

// ログインチェック
$userId = $student_inst->get_staff_id();

// ログインチェックの返り値がfalseの場合ログインページにリダイレクト　（不正なリクエストとみなす）
if (!$userId) {
    $url = '../../Incorrect_request.php';
    header('Location:' . $url);
}

// 編集する投稿IDの取得
$update_id = filter_input(INPUT_GET, 'post_id');

// SQL発行
$sql = 'SELECT * FROM `staff_information_table` INNER JOIN `staff_master` ON staff_information_table.staff_id = staff_master.staff_id AND staff_information_table.post_id = ?';

$argument = $arr_prm_inst->student_post_one_prm($update_id);

$update_date = $db_inst->data_select_argument($sql, $argument);


// 編集対象データがない場合はリダイレクト
if (!$update_date) {
    header('Location: ../post_list.php');
}

// 投稿者IDとログイン中のユーザのIDが一致しなければリダイレクト
foreach ($update_date as $date) {
    if (!$userId == $date['staff_id']) {
        header('Location: ../post_list.php');
    }
}


?>

<!-- <!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../../public/img/favicon.ico">
    <link rel="stylesheet" href="../../../public/css/intern/view.css">
    <title>「Real intentioN」 / インターン体験記</title>
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
                <?php if (is_array($update_date) || is_object($update_date)) : ?>
                    <?php foreach ($update_date as $row) : ?>
                        <div class="bg-light py-3">
                            <div class="mx-auto col-lg-8">
                                <form class="mt-5" action="./update_confirmation.php?post_id=<?php h($row['post_id']) ?>" method="post">


                                    <div class="mb-2">
                                        <label class="form-label" for="name">投稿情報の種類</label>
                                        <select class="form-select" name="type" aria-label="Default select example">
                                            <option selected><?php h($row['type']) ?>情報</option>
                                            <option value="インターン">インターン情報</option>
                                            <option value="イベント">イベント情報</option>
                                        </select>
                                    </div>



                                    <div class="mb-2">
                                        <label class="form-label" for="name">イベント形式</label>
                                        <select class="form-select" name="format" aria-label="Default select example">
                                            <option selected>-- 選択してください --</option>
                                            <option value="オンライン形式">オンライン形式</option>
                                            <option value="対面形式">対面形式</option>
                                        </select>
                                    </div>



                                    <div class="mb-2">
                                        <label class="form-label" for="name">イベント分野</label>
                                        <select class="form-select" name="field" aria-label="Default select example">
                                            <option selected>-- 選択してください --</option>
                                            <option value="IT・ソフトウェア">IT・ソフトウェア</option>
                                            <option value="対面形式">対面形式</option>
                                        </select>
                                    </div>

                                    <div class="mb-2">
                                        <label class="form-label" for="name">イベント日時</label>
                                        <input class="form-control" type="date" name="time" value="<?php h($row['time']) ?>">
                                    </div>


                                    <div class="mb-2">
                                        <label class="form-label" for="name">企業名</label>
                                        <input class="form-control" type="text" name="company" value="<?php h($row['company']) ?>">
                                    </div>



                                    <div class="mb-2">
                                        <label for="exampleFormControlTextarea1" class="form-label">イベント内容</label>
                                        <textarea class="form-control" name="overview" id="exampleFormControlTextarea1" rows="3"><?php h($row['overview']) ?></textarea>
                                    </div>


                                    <div class="mb-2">
                                        <label for="exampleFormControlTextarea1" class="form-label">添付資料</label>
                                        <input class="form-control" type="text" name="attachment" value="<?php h($row['attachment']) ?>">
                                    </div>

                                    <button type="submit" class="btn btn-primary px-5">入力内容を編集する</button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>


            <div class="col-md-4 bg-warning sticky-top vh-100">
                <div>
                    <h1>送信</h1>
                </div>
               
            </div>



        </div>
    </main>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html> -->

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
        <nav class="navbar navbar-expand-lg navbar-light py-4">
            <div class="container">
                <a class="navbar-brand" href="../../../index.html">
                    <img src="../../../public/img/logo.png" alt="" width="30" height="24" class="d-inline-block
                                align-text-top" style="object-fit: cover;">
                    Real intentioN
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="./src/StaffView/login/login_form.php">Real intentioNとは</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="./src/StaffView/login/login_form.php">お問い合わせはこちら</a>
                        </li>
                    </ul>
                </div>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="../../StaffView/login/login_form.php">職員の方はこちら</a>
                        </li>

                        <li class="nav-item">
                            <a class="login-btn btn" href="./login_form.php">ログインはこちら</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>



    <main role="main" class="container my-5" style="padding: 0px">
        <div class="row">
            <div class="col-md-8">
                <?php if (is_array($update_date) || is_object($update_date)) : ?>
                    <?php foreach ($update_date as $row) : ?>
                        <div class="bg-light py-3">
                            <div class="mx-auto col-lg-8">

                                <form class="mt-5 mb-5" action="./update_confirmation.php?post_id=<?php h($row['post_id']) ?>" method="post">

                                    <h1 class="text-center fs-2 mb-5">投稿内容を編集する</h1>


                                    <div class="mb-4">
                                        <label class="form-label" for="name">投稿情報の種類</label>
                                        <select class="form-select" name="type" aria-label="Default select example">
                                            <option selected><?php h($row['type']) ?></option>
                                            <option value="インターン情報">インターン情報</option>
                                            <option value="説明会情報">説明会情報</option>
                                        </select>
                                    </div>



                                    <div class="mb-4">
                                        <label class="form-label" for="name">イベント形式</label>
                                        <select class="form-select" name="format" aria-label="Default select example">
                                            <option selected><?php h($row['format']) ?></option>
                                            <option value="オンライン開催">オンライン開催</option>
                                            <option value="対面開催">対面開催</option>
                                        </select>
                                    </div>



                                    <div class="mb-4">
                                        <label class="form-label" for="name">イベント分野</label>
                                        <select class="form-select" name="field" aria-label="Default select example">
                                            <option selected><?php h($row['field']) ?></option>
                                            <option value="IT分野">IT分野</option>
                                            <option value="ゲームソフト分野">ゲームソフト分野</option>
                                            <option value="ハード分野">ハード分野</option>
                                            <option value="ビジネス分野">ビジネス分野</option>
                                            <option value="CAD分野">CAD分野</option>
                                            <option value="グラフィックス分野">グラフィックス分野</option>
                                            <option value="サウンド分野">サウンド分野</option>
                                            <option value="日本語分野">日本語分野</option>
                                            <option value="国際コミュニケーション分野">国際コミュニケーション分野</option>
                                        </select>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label" for="name">イベント日時</label>
                                        <input class="form-control" type="date" name="time" value="<?php h($row['time']) ?>">
                                    </div>


                                    <div class="mb-4">
                                        <label class="form-label" for="name">企業名</label>
                                        <input class="form-control" type="text" name="company" value="<?php h($row['company']) ?>">
                                    </div>


                                    <div class="mb-4">
                                        <label for="exampleFormControlTextarea1" class="form-label">イベント内容</label>
                                        <textarea class="form-control" name="overview" id="exampleFormControlTextarea1" rows="8"><?php h($row['overview']) ?></textarea>
                                    </div>


                                    <div class="mb-4">
                                        <label for="exampleFormControlTextarea1" class="form-label">添付資料</label>
                                        <input class="form-control" type="text" name="attachment" value="<?php h($row['attachment']) ?>">
                                    </div>

                                    <button type="submit" class="login-btn btn px-4">編集内容を確認する</button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
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

    <footer>
        <nav class="navbar navbar-expand-lg navbar-light py-4">
            <div class="container">
                <a class="navbar-brand" href="../../../index.html">
                    <img src="../../../public/img" alt="" width="30" height="24" class="d-inline-block
                                align-text-top" style="object-fit: cover;">
                    Real intentioN
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav2" aria-controls="navbarNav2" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav2">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="./src/StaffView/login/login_form.php">職員の方はこちら</a>
                        </li>

                        <li class="nav-item">
                            <a class="login-btn btn" href="./src/UserView/login/login_form.php">ログインはこちら</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>